<?php

namespace spoova\mi\tests\Unit\Classes;

use Error;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use spoova\mi\core\classes\Activity;

/**
 * Covers Activity, which times how long a named process takes.
 */
class ActivityTest extends TestCase
{
    /**
     * Activity keeps its readings in private statics with no public way to clear
     * them, so each test starts from a clean slate.
     */
    protected function setUp(): void
    {
        $activity = new ReflectionClass(Activity::class);

        foreach (['start', 'tests', 'activities'] as $property) {
            $reflected = $activity->getProperty($property);
            $reflected->setAccessible(true);
            $reflected->setValue(null, []);
        }
    }

    /**
     * Pretends the named process began $seconds ago, so a duration can be
     * asserted exactly instead of being slept for.
     */
    private function startedSecondsAgo(string $name, float $seconds): void
    {
        $start = new ReflectionClass(Activity::class);
        $reflected = $start->getProperty('start');
        $reflected->setAccessible(true);
        $reflected->setValue(null, [$name => hrtime(true) - (int) ($seconds * 1e9)]);
    }

    /* ---- normal use ---- */

    public function test_benched_reports_a_timeframe_and_a_runtime(): void
    {
        Activity::bench('job');
        $data = Activity::benched('job');

        $this->assertArrayHasKey('timeframe', $data);
        $this->assertArrayHasKey('runtime', $data);
        $this->assertIsFloat($data['timeframe']);
        $this->assertStringEndsWith('secs', $data['runtime']);
    }

    public function test_timeframe_measures_the_elapsed_time(): void
    {
        $this->startedSecondsAgo('job', 0.25);

        $data = Activity::benched('job');

        $this->assertGreaterThanOrEqual(0.25, $data['timeframe']);
        $this->assertLessThan(0.30, $data['timeframe']);
    }

    public function test_data_returns_the_first_reading_on_later_calls(): void
    {
        Activity::bench('job');

        $first = Activity::data('job');
        usleep(20000);
        $second = Activity::data('job');

        $this->assertSame($first, $second);
    }

    public function test_map_lists_every_saved_activity(): void
    {
        Activity::bench('one');
        Activity::bench('two');
        Activity::benched('one');
        Activity::benched('two');

        $this->assertCount(2, Activity::map());
    }

    /* ---- guards ---- */

    public function test_reading_a_process_that_was_never_started_explains_itself(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches('/No Activity::bench\("ghost"\) was started/');

        Activity::benched('ghost');
    }

    public function test_reusing_a_bench_name_is_rejected(): void
    {
        Activity::bench('job');

        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches('/Ambiguous Activity::bench name "job"/');

        Activity::bench('job');
    }

    /* ---- regression ---- */

    /**
     * A duration of a thousand seconds or more used to be pushed through
     * number_format(), whose thousands separator truncated the value to 1 on the
     * arithmetic that followed and made round() throw outright.
     */
    public function test_a_runtime_past_a_thousand_seconds_is_not_truncated(): void
    {
        $this->startedSecondsAgo('long', 1234.5678);

        $data = Activity::benched('long');

        $this->assertGreaterThan(1234.0, $data['timeframe']);
        $this->assertLessThan(1235.0, $data['timeframe']);
        $this->assertStringStartsWith('1234.5', $data['runtime']);
        $this->assertStringNotContainsString(',', $data['runtime']);
    }
}
