<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use spoova\mi\core\classes\RequestRateLimiter;
use spoova\mi\core\classes\RouteInspector;

/**
 * Covers RequestRateLimiter, which counts a caller's recent hits against a route
 * and reports whether the next one is permitted.
 */
class RequestRateLimiterTest extends TestCase
{
    /** Buckets are written to disk, so each test gets its own directory. */
    private string $store;

    private string $original;

    protected function setUp(): void
    {
        $this->original = RequestRateLimiter::$storeDir;
        $this->store    = 'core/storage/ratelimit-test-'.uniqid();

        RequestRateLimiter::$storeDir = $this->store;
    }

    protected function tearDown(): void
    {
        $directory = (new RequestRateLimiter())->directory();

        foreach (glob($directory.DIRECTORY_SEPARATOR.'*.json') ?: [] as $bucket) {
            @unlink($bucket);
        }

        if (is_dir($directory)) {
            @rmdir($directory);
        }

        RequestRateLimiter::$storeDir = $this->original;
    }

    /** A limiter pinned to one identity, so the client address never decides a test. */
    private function limiter(int $limit = 3, int $window = 60, string $scope = 'test'): RequestRateLimiter
    {
        return (new RequestRateLimiter($limit, $window))->scope($scope)->identify('tester');
    }

    /* ---- counting ---- */

    public function test_hits_are_allowed_up_to_the_limit(): void
    {
        $limiter = $this->limiter(3);

        $this->assertTrue($limiter->attempt());
        $this->assertTrue($limiter->attempt());
        $this->assertTrue($limiter->attempt());
    }

    public function test_the_hit_after_the_limit_is_refused(): void
    {
        $limiter = $this->limiter(2);

        $limiter->attempt();
        $limiter->attempt();

        $this->assertFalse($limiter->attempt());
    }

    /**
     * The count has to survive between requests, so a second instance reading the
     * same bucket must see what the first one recorded.
     */
    public function test_the_count_is_shared_between_instances(): void
    {
        $this->limiter(2)->attempt();
        $this->limiter(2)->attempt();

        $this->assertFalse($this->limiter(2)->attempt(), 'A fresh instance did not see the earlier hits.');
    }

    public function test_remaining_counts_down_and_stops_at_zero(): void
    {
        $limiter = $this->limiter(2);

        $this->assertSame(2, $limiter->remaining());

        $limiter->attempt();
        $this->assertSame(1, $limiter->remaining());

        $limiter->attempt();
        $this->assertSame(0, $limiter->remaining());

        $limiter->attempt();
        $this->assertSame(0, $limiter->remaining(), 'A refused hit must not push the count below zero.');
    }

    /**
     * A refused hit is not recorded, so a caller cannot hold their own limit open
     * by continuing to hammer it.
     */
    public function test_a_refused_hit_is_not_recorded(): void
    {
        $limiter = $this->limiter(1, 60);
        $limiter->attempt();

        $first = $limiter->retryAfter();

        $limiter->attempt();
        $limiter->attempt();

        $this->assertLessThanOrEqual($first, $this->limiter(1, 60)->retryAfter());
    }

    /* ---- checking without spending ---- */

    public function test_permitted_reports_without_recording_a_hit(): void
    {
        $limiter = $this->limiter(1);

        $this->assertTrue($limiter->permitted());
        $this->assertTrue($limiter->permitted());
        $this->assertSame(1, $limiter->remaining(), 'Asking must not spend the allowance.');
        $this->assertTrue($limiter->attempt());
    }

    /* ---- the window ---- */

    public function test_hits_age_out_of_the_window(): void
    {
        $limiter = $this->limiter(2, 1); // two hits a second

        $limiter->attempt();
        $limiter->attempt();
        $this->assertFalse($limiter->attempt());

        usleep(1100000); // let the window pass

        $this->assertTrue($this->limiter(2, 1)->attempt(), 'The window should have slid past the earlier hits.');
    }

    public function test_retry_after_is_zero_while_the_caller_has_room(): void
    {
        $limiter = $this->limiter(3);

        $limiter->attempt();

        $this->assertSame(0, $limiter->retryAfter());
    }

    public function test_retry_after_is_reported_once_the_limit_is_reached(): void
    {
        $limiter = $this->limiter(1, 30);

        $limiter->attempt();
        $limiter->attempt();

        $retry = $limiter->retryAfter();

        $this->assertGreaterThan(0, $retry);
        $this->assertLessThanOrEqual(30, $retry);
    }

    /* ---- scope and identity ---- */

    /**
     * Being throttled out of one route must not close the others, or a single busy
     * endpoint would lock a caller out of the whole application.
     */
    public function test_scopes_hold_separate_allowances(): void
    {
        $login = $this->limiter(1, 60, 'login');
        $search = $this->limiter(1, 60, 'search');

        $login->attempt();

        $this->assertFalse($login->attempt());
        $this->assertTrue($search->attempt(), 'A separate scope should have its own allowance.');
    }

    public function test_identities_hold_separate_allowances(): void
    {
        $first  = (new RequestRateLimiter(1, 60))->scope('test')->identify('ann');
        $second = (new RequestRateLimiter(1, 60))->scope('test')->identify('joe');

        $first->attempt();

        $this->assertFalse($first->attempt());
        $this->assertTrue($second->attempt());
    }

    /**
     * An identity reaches the filesystem as a hash, so an address or an api key is
     * never written into a file name.
     */
    public function test_the_identity_is_not_written_into_the_bucket_name(): void
    {
        $limiter = (new RequestRateLimiter(1, 60))->scope('test')->identify('192.168.0.55');
        $limiter->attempt();

        $names = array_map('basename', glob($limiter->directory().DIRECTORY_SEPARATOR.'*.json') ?: []);

        $this->assertNotEmpty($names);
        $this->assertStringNotContainsString('192.168', implode(' ', $names));
    }

    /* ---- forgetting ---- */

    public function test_forget_restores_a_full_allowance(): void
    {
        $limiter = $this->limiter(1);

        $limiter->attempt();
        $this->assertFalse($limiter->attempt());

        $this->assertTrue($limiter->forget());
        $this->assertTrue($limiter->attempt(), 'The allowance should have been restored.');
    }

    public function test_forgetting_something_that_was_never_recorded_is_not_a_failure(): void
    {
        $this->assertTrue($this->limiter()->forget());
    }

    /* ---- headers ---- */

    public function test_headers_describe_the_callers_standing(): void
    {
        $limiter = $this->limiter(2);
        $limiter->attempt();

        $headers = $limiter->headers();

        $this->assertSame('2', $headers['X-RateLimit-Limit']);
        $this->assertSame('1', $headers['X-RateLimit-Remaining']);
        $this->assertArrayNotHasKey('Retry-After', $headers, 'Retry-After has no meaning while the caller has room.');
    }

    public function test_headers_carry_retry_after_once_refused(): void
    {
        $limiter = $this->limiter(1, 30);
        $limiter->attempt();
        $limiter->attempt();

        $headers = $limiter->headers();

        $this->assertSame('0', $headers['X-RateLimit-Remaining']);
        $this->assertArrayHasKey('Retry-After', $headers);
        $this->assertGreaterThan(0, (int) $headers['Retry-After']);
    }

    /* ---- awkward input ---- */

    /**
     * A limit of zero would refuse every caller including the first, which is never
     * what a misconfigured route intends.
     */
    public function test_a_limit_below_one_still_permits_a_single_hit(): void
    {
        $limiter = (new RequestRateLimiter(0, 60))->scope('test')->identify('tester');

        $this->assertTrue($limiter->attempt());
        $this->assertFalse($limiter->attempt());
    }

    public function test_an_empty_scope_falls_back_rather_than_writing_a_nameless_bucket(): void
    {
        $limiter = (new RequestRateLimiter(1, 60))->scope('   ')->identify('tester');

        $this->assertTrue($limiter->attempt());
        $this->assertFalse($limiter->attempt());
    }

    /**
     * A bucket that cannot be read forgives the caller. Locking everybody out because
     * a cache file was truncated would turn a storage fault into an outage.
     */
    public function test_an_unreadable_bucket_does_not_lock_the_caller_out(): void
    {
        $limiter = $this->limiter(1);
        $limiter->attempt();

        foreach (glob($limiter->directory().DIRECTORY_SEPARATOR.'*.json') ?: [] as $bucket) {
            file_put_contents($bucket, '{ not json');
        }

        $this->assertTrue($this->limiter(1)->attempt());
    }

    /* ---- housekeeping ---- */

    public function test_prune_removes_buckets_that_have_gone_cold(): void
    {
        $limiter = $this->limiter(1);
        $limiter->attempt();

        $buckets = glob($limiter->directory().DIRECTORY_SEPARATOR.'*.json') ?: [];
        $this->assertNotEmpty($buckets);

        foreach ($buckets as $bucket) {
            touch($bucket, time() - 7200);
        }

        $this->assertSame(count($buckets), RequestRateLimiter::prune(3600));
        $this->assertSame([], glob($limiter->directory().DIRECTORY_SEPARATOR.'*.json') ?: []);
    }

    public function test_prune_leaves_buckets_that_are_still_current(): void
    {
        $limiter = $this->limiter(1);
        $limiter->attempt();

        $this->assertSame(0, RequestRateLimiter::prune(3600));
        $this->assertNotEmpty(glob($limiter->directory().DIRECTORY_SEPARATOR.'*.json') ?: []);
    }

    /* ---- middleware ---- */

    /** Flip RouteInspector's inspection flag, whose own toggle is private. */
    private function capturing(bool $on): void
    {
        $flag = new ReflectionMethod(RouteInspector::class, 'flag');
        $flag->setAccessible(true);
        $flag->invoke(null, $on);
    }

    public function test_guard_hands_back_a_closure_for_oncall(): void
    {
        $this->assertInstanceOf(\Closure::class, RequestRateLimiter::guard(5, 60, 'guarded'));
    }

    public function test_a_permitted_caller_passes_through_the_guard(): void
    {
        $guard = RequestRateLimiter::guard(2, 60, 'guarded');

        $this->assertTrue($guard());
        $this->assertTrue($guard());
    }

    /**
     * ONCALL discards what it returns, so a refusal has to be acted on rather than
     * reported. The callback is that seam — it receives the limiter and owns the
     * outcome, which is also what makes the refusal path testable without exiting.
     */
    public function test_a_refused_caller_reaches_the_refusal_callback(): void
    {
        $seen = null;

        $guard = RequestRateLimiter::guard(1, 60, 'guarded', function ($limiter) use (&$seen) {
            $seen = $limiter;
        });

        $this->assertTrue($guard(), 'the first hit is within the limit');
        $this->assertFalse($guard(), 'the second hit is over it');

        $this->assertInstanceOf(RequestRateLimiter::class, $seen);

        /** @var RequestRateLimiter $seen */
        $this->assertSame(0, $seen->remaining());
        $this->assertGreaterThan(0, $seen->retryAfter());
    }

    /**
     * Route scanning walks every shutter. Counting a hit there would spend a real
     * caller's allowance against a CLI command, and refusing one would end the scan.
     */
    public function test_the_guard_stands_aside_during_a_route_scan(): void
    {
        $refused = false;
        $guard = RequestRateLimiter::guard(1, 60, 'scanned', function () use (&$refused) {
            $refused = true;
        });

        $this->capturing(true);

        try {
            for ($i = 0; $i < 5; $i++) {
                $this->assertTrue($guard(), 'the guard must stand aside while capturing');
            }
        } finally {
            $this->capturing(false);
        }

        $this->assertFalse($refused, 'no caller should be refused during a scan');
        $this->assertSame(
            [],
            glob((new RequestRateLimiter())->directory().DIRECTORY_SEPARATOR.'*.json') ?: [],
            'a scan must not record any hits'
        );
    }

    /**
     * With no scope named, each request path carries its own allowance, so limiting
     * one route does not limit the rest.
     */
    public function test_the_default_scope_follows_the_request_path(): void
    {
        $original = $_SERVER['REQUEST_URI'] ?? null;

        try {
            /* a callback is supplied throughout: without one a refusal takes the
               default path, which sends a 429 and exits — ending the test run */
            $noop = static fn() => null;

            $_SERVER['REQUEST_URI'] = '/shop/checkout?step=2';
            $guard = RequestRateLimiter::guard(1, 60, '', $noop);
            $this->assertTrue($guard());
            $this->assertFalse($guard(), 'the same path shares one allowance');

            $_SERVER['REQUEST_URI'] = '/shop/basket';
            $other = RequestRateLimiter::guard(1, 60, '', $noop);
            $this->assertTrue($other(), 'a different path should have its own allowance');
        } finally {
            if ($original === null) {
                unset($_SERVER['REQUEST_URI']);
            } else {
                $_SERVER['REQUEST_URI'] = $original;
            }
        }
    }

    /**
     * The query string is dropped from the default scope, or every distinct set of
     * parameters would be counted as a separate route.
     */
    public function test_the_query_string_does_not_split_the_default_scope(): void
    {
        $original = $_SERVER['REQUEST_URI'] ?? null;

        try {
            $_SERVER['REQUEST_URI'] = '/search?q=one';
            $this->assertTrue((RequestRateLimiter::guard(1, 60, '', static fn() => null))());

            $_SERVER['REQUEST_URI'] = '/search?q=two';
            $refused = false;
            $guard = RequestRateLimiter::guard(1, 60, '', function () use (&$refused) {
                $refused = true;
            });
            $guard();

            $this->assertTrue($refused, 'a different query string must share the same allowance');
        } finally {
            if ($original === null) {
                unset($_SERVER['REQUEST_URI']);
            } else {
                $_SERVER['REQUEST_URI'] = $original;
            }
        }
    }

    public function test_sending_headers_is_safe_when_none_can_be_sent(): void
    {
        $limiter = $this->limiter(2);
        $limiter->attempt();

        $limiter->sendHeaders();

        $this->assertSame('2', $limiter->headers()['X-RateLimit-Limit']);
    }
}
