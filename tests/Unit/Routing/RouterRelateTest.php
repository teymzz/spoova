<?php

namespace spoova\mi\tests\Unit\Routing;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Router;

/**
 * Covers Router::relate(), which resolves a url against a route map entry into
 * the target controller/class name. Behaviour by map shape:
 *
 *   - no wildcard              -> url passed through (ucfirst)
 *   - '*' ending in "\"        -> treated as a namespace prefix on the url
 *   - '*' NOT ending in "\"    -> absolute override (url ignored)
 *   - '.*'                     -> absolute override, highest priority
 */
class RouterRelateTest extends TestCase
{
    public function test_no_map_passes_url_through_ucfirst(): void
    {
        $this->assertSame('Home', Router::relate('home', []));
        $this->assertSame('About', Router::relate('about', []));
    }

    public function test_star_with_trailing_backslash_is_namespace_prefix(): void
    {
        $this->assertSame('Docs\\hello', Router::relate('hello', ['*' => 'Docs\\']));
    }

    public function test_star_without_backslash_is_absolute_override(): void
    {
        // the url ("ignored") is discarded in favour of the map value
        $this->assertSame('Home', Router::relate('ignored', ['*' => 'Home']));
    }

    public function test_dot_star_is_absolute_override(): void
    {
        $this->assertSame('Custom\\AppSupport', Router::relate('ignored', ['.*' => 'Custom\\AppSupport']));
    }

    public function test_dot_star_takes_priority_over_star(): void
    {
        $map = ['.*' => 'Absolute', '*' => 'Docs\\'];
        $this->assertSame('Absolute', Router::relate('hello', $map));
    }

    public function test_result_is_ucfirst_normalised(): void
    {
        // lowercase leading char in the final value is capitalised
        $this->assertSame('Home', Router::relate('home', ['*' => 'home']));
    }
}
