<?php

namespace spoova\mi\core\commands\Root\Cli;

/**
 * class CliArgs
 *
 * A small, dependency-free declarative parser for CLI command arguments.
 *
 * It replaces the hand-rolled `$args[0]` / `in_array('-flag', $args)` /
 * `$lastArg == '-O'` style of argument handling used across the Support
 * commands with a single declarative definition:
 *
 *   $input = (new CliArgs($rawArgs))
 *       ->arg('class', required: true)   // positional
 *       ->flag('lite', ['-lite'])        // boolean flag
 *       ->flag('overwrite', ['-O'])      // boolean flag
 *       ->option('out', ['-o', '--out']) // option that takes a value
 *       ->max(1)                         // max number of positionals
 *       ->parse();
 *
 *   if (!$input->ok()) { /* render $input->errors() *\/ }
 *
 *   $input->getArg('class');     // 'Foo'
 *   $input->isFlag('lite');      // true|false
 *   $input->getOption('out');    // value or default
 *
 * Design notes:
 *  - Pure: the constructor receives the raw token array, so it is fully
 *    testable without $GLOBALS/argv or any framework bootstrap.
 *  - Strict: any token starting with "-" that is not a declared flag/option
 *    alias is reported as an error (mirrors "unknown directive" checks).
 *  - It only parses and validates; rendering is left to the caller (Cli).
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class CliArgs
{
    /** @var list<string> raw tokens as received */
    private array $raw;

    /** @var list<array{name:string,required:bool,default:mixed}> */
    private array $argDefs = [];

    /** @var array<string,array{aliases:list<string>}> */
    private array $flagDefs = [];

    /** @var array<string,array{aliases:list<string>,default:mixed}> */
    private array $optDefs = [];

    private ?int $maxPositional = null;

    /** @var array<string,mixed> resolved positional values keyed by name */
    private array $args = [];

    /** @var array<string,bool> resolved flag values keyed by name */
    private array $flags = [];

    /** @var array<string,mixed> resolved option values keyed by name */
    private array $options = [];

    /** @var list<string> validation errors */
    private array $errors = [];

    private bool $parsed = false;

    /**
     * @param list<string> $rawArgs the token array for the command (no program name)
     */
    public function __construct(array $rawArgs)
    {
        $this->raw = array_values($rawArgs);
    }

    /* --------------------------------------------------------------------- *
     *  Definition (builder)                                                  *
     * --------------------------------------------------------------------- */

    /**
     * Declare a positional argument (order matters).
     */
    public function arg(string $name, bool $required = false, mixed $default = null): static
    {
        $this->argDefs[] = ['name' => $name, 'required' => $required, 'default' => $default];
        return $this;
    }

    /**
     * Declare a boolean flag matched by one or more exact aliases (e.g. "-O", "--force").
     *
     * @param list<string> $aliases
     */
    public function flag(string $name, array $aliases): static
    {
        $this->flagDefs[$name] = ['aliases' => array_values($aliases)];
        return $this;
    }

    /**
     * Declare an option that takes a value, matched by exact aliases.
     * Accepts "--name value", "--name=value" and "-n value" forms.
     *
     * @param list<string> $aliases
     */
    public function option(string $name, array $aliases, mixed $default = null): static
    {
        $this->optDefs[$name] = ['aliases' => array_values($aliases), 'default' => $default];
        return $this;
    }

    /**
     * Cap the number of allowed positional arguments.
     */
    public function max(int $count): static
    {
        $this->maxPositional = $count;
        return $this;
    }

    /* --------------------------------------------------------------------- *
     *  Parsing                                                               *
     * --------------------------------------------------------------------- */

    public function parse(): static
    {
        if ($this->parsed) {
            return $this;
        }
        $this->parsed = true;

        // seed defaults
        foreach ($this->flagDefs as $name => $_) {
            $this->flags[$name] = false;
        }
        foreach ($this->optDefs as $name => $def) {
            $this->options[$name] = $def['default'];
        }

        $positionals = [];
        $tokens = $this->raw;
        $count = count($tokens);

        for ($i = 0; $i < $count; $i++) {
            $token = $tokens[$i];

            // split "--name=value" once
            $inlineValue = null;
            $lookup = $token;
            if (str_starts_with($token, '-') && str_contains($token, '=')) {
                [$lookup, $inlineValue] = explode('=', $token, 2);
            }

            if (($flagName = $this->matchFlag($lookup)) !== null) {
                if ($inlineValue !== null) {
                    $this->errors[] = "Flag \"{$lookup}\" does not take a value.";
                }
                $this->flags[$flagName] = true;
                continue;
            }

            if (($optName = $this->matchOption($lookup)) !== null) {
                if ($inlineValue !== null) {
                    $this->options[$optName] = $inlineValue;
                } elseif ($i + 1 < $count && !str_starts_with($tokens[$i + 1], '-')) {
                    $this->options[$optName] = $tokens[++$i];
                } else {
                    $this->errors[] = "Option \"{$lookup}\" expects a value.";
                }
                continue;
            }

            // any other dash-led token is an unknown directive
            if (str_starts_with($token, '-')) {
                $this->errors[] = "Unknown directive \"{$token}\" supplied.";
                continue;
            }

            $positionals[] = $token;
        }

        // enforce positional cap
        if ($this->maxPositional !== null && count($positionals) > $this->maxPositional) {
            $this->errors[] = "Expecting a maximum of {$this->maxPositional} argument(s).";
        }

        // bind positionals to declared names in order
        foreach ($this->argDefs as $index => $def) {
            $name = $def['name'];
            if (array_key_exists($index, $positionals)) {
                $this->args[$name] = $positionals[$index];
            } else {
                if ($def['required']) {
                    $this->errors[] = "Missing required argument \"{$name}\".";
                }
                $this->args[$name] = $def['default'];
            }
        }

        return $this;
    }

    /* --------------------------------------------------------------------- *
     *  Results                                                               *
     * --------------------------------------------------------------------- */

    public function getArg(string $name): mixed
    {
        $this->ensureParsed();
        return $this->args[$name] ?? null;
    }

    public function isFlag(string $name): bool
    {
        $this->ensureParsed();
        return $this->flags[$name] ?? false;
    }

    public function getOption(string $name): mixed
    {
        $this->ensureParsed();
        return $this->options[$name] ?? null;
    }

    /** @return list<string> */
    public function errors(): array
    {
        $this->ensureParsed();
        return $this->errors;
    }

    public function ok(): bool
    {
        $this->ensureParsed();
        return $this->errors === [];
    }

    /* --------------------------------------------------------------------- *
     *  Internals                                                             *
     * --------------------------------------------------------------------- */

    private function matchFlag(string $token): ?string
    {
        foreach ($this->flagDefs as $name => $def) {
            if (in_array($token, $def['aliases'], true)) {
                return $name;
            }
        }
        return null;
    }

    private function matchOption(string $token): ?string
    {
        foreach ($this->optDefs as $name => $def) {
            if (in_array($token, $def['aliases'], true)) {
                return $name;
            }
        }
        return null;
    }

    private function ensureParsed(): void
    {
        if (!$this->parsed) {
            $this->parse();
        }
    }
}
