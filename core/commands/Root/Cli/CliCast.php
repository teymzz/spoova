<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Ghost\GhostClass;

/**
 * Supplied to the callback of {@see Cli::cast()} once for every line typed at the
 * shell, before that line is evaluated as PHP.
 *
 * The callback may claim the line with {@see CliCast::handled()}, in which case it
 * is never evaluated, or leave it alone and let the shell run it as PHP. Returning
 * TRUE from the callback ends the session, matching the callback of
 * {@see Cli::prompt()}; {@see CliCast::stop()} does the same thing by name.
 *
 * <code>
 *  Cli::cast(function(CliCast $cast){
 *
 *      if($cast->is('.vars'))     return $cast->handled(print_r($cast->scope(), true));
 *      if($cast->starts('route')) return $cast->handled(Route::map());
 *
 *      // returning nothing lets the line run as ordinary PHP
 *  });
 * </code>
 */
abstract class CliCast extends GhostClass {

    /**
     * The line typed at the shell, trimmed.
     *
     * @return string|null
     */
    public function input(): string|null {
        return $this->proxy->input();
    }

    /**
     * The line typed at the shell, trimmed.
     *  - Alias to {@see CliCast::input()}
     *
     * @return string|null
     * @uses CliCast::input()
     */
    public function i(): string|null {
        return $this->proxy->input();
    }

    /**
     * Every variable currently held by the shell, carried over from the lines
     * already evaluated in the session.
     *
     * @return array
     */
    public function scope(): array {
        return $this->proxy->scope();
    }

    /**
     * Claims the line, so that it is not evaluated as PHP.
     *
     * @param string|null $output printed as the response of the line when supplied
     * @return null returns NULL rather than TRUE so that the result can be returned
     *              straight out of the callback without also ending the session
     */
    public function handled(string|null $output = null) {
        return $this->proxy->handled($output);
    }

    /**
     * Ends the shell session.
     *
     * @return bool TRUE, so that returning it out of the callback reads the same way
     *              as the TRUE which {@see Cli::prompt()} treats as a termination
     */
    public function stop(): bool {
        return $this->proxy->stop();
    }

    /**
     * Checks whether the line typed is exactly the command supplied.
     *
     * @param string $command
     * @param bool $sensitive compares case sensitively when TRUE
     * @return bool
     */
    public function is(string $command, bool $sensitive = false): bool {
        $input = (string) $this->input();
        return $sensitive? ($input === $command) : (strtolower($input) === strtolower($command));
    }

    /**
     * Checks whether the line typed begins with the command supplied.
     *  - Useful for commands that carry their own arguments.
     *
     * @param string $command
     * @param bool $sensitive compares case sensitively when TRUE
     * @return bool
     */
    public function starts(string $command, bool $sensitive = false): bool {
        $input = (string) $this->input();
        if(!$sensitive){
            $input = strtolower($input);
            $command = strtolower($command);
        }
        return $command !== '' && str_starts_with($input, $command);
    }

    /**
     * The line typed with the leading command removed, so that a command can read
     * its own arguments.
     *
     * @param string $command the command that {@see CliCast::starts()} matched
     * @return string
     */
    public function args(string $command = ''): string {
        $input = (string) $this->input();
        if($command === '') return $input;
        return ltrim(substr($input, strlen($command)));
    }

}
