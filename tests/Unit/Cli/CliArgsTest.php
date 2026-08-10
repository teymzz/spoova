<?php

namespace spoova\mi\tests\Unit\Cli;

use PHPUnit\Framework\TestCase;
use spoova\mi\core\commands\Root\Cli\CliArgs;

/**
 * Covers the declarative CLI argument parser CliArgs.
 */
class CliArgsTest extends TestCase
{
    /* ---- positionals ---- */

    public function test_binds_positionals_in_declaration_order(): void
    {
        $input = (new CliArgs(['Foo', 'Bar']))
            ->arg('class')
            ->arg('extra')
            ->parse();

        $this->assertTrue($input->ok());
        $this->assertSame('Foo', $input->getArg('class'));
        $this->assertSame('Bar', $input->getArg('extra'));
    }

    public function test_missing_optional_positional_uses_default(): void
    {
        $input = (new CliArgs([]))
            ->arg('class', required: false, default: 'Fallback')
            ->parse();

        $this->assertTrue($input->ok());
        $this->assertSame('Fallback', $input->getArg('class'));
    }

    public function test_missing_required_positional_is_an_error(): void
    {
        $input = (new CliArgs([]))
            ->arg('class', required: true)
            ->parse();

        $this->assertFalse($input->ok());
        $this->assertStringContainsString('Missing required argument "class"', implode("\n", $input->errors()));
    }

    /* ---- flags ---- */

    public function test_flags_default_to_false_and_toggle_on_alias(): void
    {
        $input = (new CliArgs(['-lite']))
            ->flag('lite', ['-lite'])
            ->flag('overwrite', ['-O'])
            ->parse();

        $this->assertTrue($input->ok());
        $this->assertTrue($input->isFlag('lite'));
        $this->assertFalse($input->isFlag('overwrite'));
    }

    public function test_flag_matches_any_declared_alias(): void
    {
        $input = (new CliArgs(['--force']))
            ->flag('overwrite', ['-O', '--force'])
            ->parse();

        $this->assertTrue($input->isFlag('overwrite'));
    }

    public function test_flag_given_a_value_is_an_error(): void
    {
        $input = (new CliArgs(['--force=1']))
            ->flag('overwrite', ['--force'])
            ->parse();

        $this->assertFalse($input->ok());
        $this->assertStringContainsString('does not take a value', implode("\n", $input->errors()));
    }

    /* ---- options (value-taking) ---- */

    public function test_option_accepts_spaced_form(): void
    {
        $input = (new CliArgs(['--out', 'build/x']))
            ->option('out', ['-o', '--out'])
            ->parse();

        $this->assertSame('build/x', $input->getOption('out'));
    }

    public function test_option_accepts_inline_equals_form(): void
    {
        $input = (new CliArgs(['--out=build/x']))
            ->option('out', ['--out'])
            ->parse();

        $this->assertSame('build/x', $input->getOption('out'));
    }

    public function test_option_accepts_short_alias(): void
    {
        $input = (new CliArgs(['-o', 'here']))
            ->option('out', ['-o', '--out'])
            ->parse();

        $this->assertSame('here', $input->getOption('out'));
    }

    public function test_option_uses_default_when_absent(): void
    {
        $input = (new CliArgs([]))
            ->option('out', ['--out'], default: 'default/dir')
            ->parse();

        $this->assertSame('default/dir', $input->getOption('out'));
    }

    public function test_option_without_value_is_an_error(): void
    {
        $input = (new CliArgs(['--out']))
            ->option('out', ['--out'])
            ->parse();

        $this->assertFalse($input->ok());
        $this->assertStringContainsString('expects a value', implode("\n", $input->errors()));
    }

    /* ---- strictness ---- */

    public function test_unknown_dash_token_is_an_error(): void
    {
        $input = (new CliArgs(['Foo', '-x']))
            ->arg('class')
            ->flag('lite', ['-lite'])
            ->parse();

        $this->assertFalse($input->ok());
        $this->assertStringContainsString('Unknown directive "-x"', implode("\n", $input->errors()));
    }

    public function test_exceeding_max_positionals_is_an_error(): void
    {
        $input = (new CliArgs(['Foo', 'Bar']))
            ->arg('class')
            ->max(1)
            ->parse();

        $this->assertFalse($input->ok());
        $this->assertStringContainsString('maximum of 1', implode("\n", $input->errors()));
    }

    /* ---- end-to-end: reproduces the make:command contract ---- */

    public function test_make_command_happy_path(): void
    {
        // mi make:command Foo -lite -O
        $input = (new CliArgs(['Foo', '-lite', '-O']))
            ->arg('class', required: true)
            ->flag('lite', ['-lite'])
            ->flag('overwrite', ['-O'])
            ->max(1)
            ->parse();

        $this->assertTrue($input->ok());
        $this->assertSame('Foo', $input->getArg('class'));
        $this->assertTrue($input->isFlag('lite'));
        $this->assertTrue($input->isFlag('overwrite'));
    }

    public function test_make_command_rejects_unknown_flag(): void
    {
        // mi make:command Foo -z
        $input = (new CliArgs(['Foo', '-z']))
            ->arg('class', required: true)
            ->flag('lite', ['-lite'])
            ->flag('overwrite', ['-O'])
            ->max(1)
            ->parse();

        $this->assertFalse($input->ok());
        $this->assertStringContainsString('Unknown directive "-z"', implode("\n", $input->errors()));
    }

    public function test_flag_order_is_irrelevant(): void
    {
        // flags before the positional still resolve correctly
        $input = (new CliArgs(['-O', 'Foo', '-lite']))
            ->arg('class', required: true)
            ->flag('lite', ['-lite'])
            ->flag('overwrite', ['-O'])
            ->max(1)
            ->parse();

        $this->assertTrue($input->ok());
        $this->assertSame('Foo', $input->getArg('class'));
        $this->assertTrue($input->isFlag('lite'));
        $this->assertTrue($input->isFlag('overwrite'));
    }
}
