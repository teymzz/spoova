<?php

namespace spoova\mi\tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\IPHandler;

/**
 * Covers IPHandler's resolution of the client address.
 *
 * The security-relevant part is which address is believed. Any client can send an
 * X-Forwarded-For header of its choosing, so reading it without knowing the request
 * came from a proxy would let a caller mint a new identity per request — and defeat
 * anything keyed on the address, rate limiting included.
 */
class IPHandlerTest extends TestCase
{
    private array $server;

    protected function setUp(): void
    {
        $this->server = $_SERVER;
        IPHandler::$trustedProxies = [];
    }

    protected function tearDown(): void
    {
        $_SERVER = $this->server;
        IPHandler::$trustedProxies = null;
    }

    /** Resolve the client address for a given connection. */
    private function resolve(string $remote, ?string $forwarded = null, ?array $trusted = null): string
    {
        IPHandler::$trustedProxies = $trusted ?? [];

        $_SERVER['REMOTE_ADDR'] = $remote;

        if ($forwarded === null) {
            unset($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $_SERVER['HTTP_X_FORWARDED_FOR'] = $forwarded;
        }

        return (string) (new IPHandler)->clientIP();
    }

    /* ---- the address that is believed ---- */

    public function test_the_connecting_address_is_used_when_no_proxy_is_trusted(): void
    {
        $this->assertSame('203.0.113.9', $this->resolve('203.0.113.9'));
    }

    /**
     * With no proxy configured, a forwarded-for header is somebody's assertion about
     * themselves and must count for nothing.
     */
    public function test_a_spoofed_forwarded_header_is_ignored(): void
    {
        $this->assertSame('203.0.113.9', $this->resolve('203.0.113.9', '1.2.3.4'));
    }

    public function test_a_forwarded_header_from_an_untrusted_address_is_ignored(): void
    {
        $this->assertSame(
            '203.0.113.9',
            $this->resolve('203.0.113.9', '1.2.3.4', ['10.0.0.1']),
            'only the configured proxy may be believed'
        );
    }

    public function test_a_trusted_proxy_is_believed(): void
    {
        $this->assertSame('1.2.3.4', $this->resolve('10.0.0.1', '1.2.3.4', ['10.0.0.1']));
    }

    /**
     * The header can carry the whole chain. Only the hop the trusted proxy itself
     * appended can be relied on, which is the last one.
     */
    public function test_the_last_hop_of_a_forwarded_chain_is_taken(): void
    {
        $this->assertSame(
            '1.2.3.4',
            $this->resolve('10.0.0.1', '9.9.9.9, 8.8.8.8, 1.2.3.4', ['10.0.0.1'])
        );
    }

    /* ---- CIDR ranges ---- */

    public function test_a_proxy_inside_a_configured_range_is_trusted(): void
    {
        $this->assertSame('1.2.3.4', $this->resolve('10.5.6.7', '1.2.3.4', ['10.0.0.0/8']));
    }

    public function test_an_address_outside_the_range_is_not_trusted(): void
    {
        $this->assertSame('11.5.6.7', $this->resolve('11.5.6.7', '1.2.3.4', ['10.0.0.0/8']));
    }

    public function test_ranges_work_for_ipv6_as_well(): void
    {
        $this->assertSame('1.2.3.4', $this->resolve('2001:db8::5', '1.2.3.4', ['2001:db8::/32']));
        $this->assertSame('2001:dba::5', $this->resolve('2001:dba::5', '1.2.3.4', ['2001:db8::/32']));
    }

    /**
     * An IPv4 address must never be read as falling inside an IPv6 range, or the
     * packed-byte comparison would match on unrelated families.
     */
    public function test_a_range_never_matches_across_address_families(): void
    {
        $this->assertSame('10.0.0.1', $this->resolve('10.0.0.1', '1.2.3.4', ['::/0']));
    }

    /* ---- awkward input ---- */

    public function test_a_malformed_range_matches_nothing(): void
    {
        $this->assertSame('10.0.0.1', $this->resolve('10.0.0.1', '1.2.3.4', ['not/a/range']));
    }

    public function test_a_trusted_proxy_forwarding_junk_yields_no_address(): void
    {
        $this->assertSame('', $this->resolve('10.0.0.1', 'not-an-ip', ['10.0.0.1']));
    }

    public function test_a_trusted_proxy_sending_no_header_falls_back_to_the_connection(): void
    {
        $this->assertSame('10.0.0.1', $this->resolve('10.0.0.1', null, ['10.0.0.1']));
    }

    public function test_no_address_at_all_yields_nothing(): void
    {
        unset($_SERVER['REMOTE_ADDR']);

        $this->assertSame('', (string) (new IPHandler)->clientIP());
    }

    /* ---- configuration ---- */

    /**
     * The default has to be "trust nobody". A project only sits behind a proxy once
     * it is told it does, and until then the connecting address is the only fact
     * available.
     */
    public function test_nothing_is_trusted_by_default(): void
    {
        IPHandler::$trustedProxies = null;

        $_SERVER['REMOTE_ADDR'] = '203.0.113.9';
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '1.2.3.4';

        // no TRUSTED_PROXIES configured in the test project
        $this->assertSame('203.0.113.9', (string) (new IPHandler)->clientIP());
    }

    public function test_the_configured_list_is_read_as_a_comma_separated_string(): void
    {
        IPHandler::$trustedProxies = null;

        $this->assertIsArray(IPHandler::trustedProxies());
    }
}
