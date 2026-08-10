<?php

namespace spoova\mi\tests\Unit\Routing;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\classes\Router;

/**
 * Guards Router::stripRexExtension() — the suffix-stripping used by resolve()
 * when falling back to convention-based file routing.
 *
 * These cases also lock in the fix for a former bug: resolve() used
 * rtrim($path, '.php') / rtrim($path, '.rex'), and because rtrim() treats its
 * argument as a *character set*, it wrongly shaved trailing letters off
 * extensionless paths (e.g. "/help" -> "/hel", "/map" -> "/ma").
 */
class RouterExtensionTest extends TestCase
{
    /**
     * @dataProvider extensionCases
     */
    public function test_strips_only_exact_extensions(string $input, string $expected): void
    {
        $this->assertSame($expected, Router::stripRexExtension($input));
    }

    public function extensionCases(): array
    {
        return [
            'double .rex.php extension' => ['/foo.rex.php', '/foo'],
            'single .php extension'     => ['/foo.php', '/foo'],
            'single .rex extension'     => ['/foo.rex', '/foo'],
            'nested path with ext'      => ['/docs/wvm/routes.rex.php', '/docs/wvm/routes'],
            'extensionless path'        => ['/index', '/index'],
            'root'                      => ['/', '/'],
        ];
    }

    /**
     * Regression cases: words ending in the characters of ".php"/".rex"
     * must NOT be truncated.
     *
     * @dataProvider regressionCases
     */
    public function test_does_not_shave_letters_from_extensionless_words(string $input): void
    {
        // input has no real extension, so it must be returned unchanged.
        $this->assertSame($input, Router::stripRexExtension($input));
    }

    public function regressionCases(): array
    {
        return [
            'ends in p' => ['/help'],
            'ends in p (map)' => ['/map'],
            'ends in h' => ['/graph'],
            'ends in x' => ['/prefix'],
            'ends in e' => ['/store'],
            'ends in r' => ['/user'],
        ];
    }
}
