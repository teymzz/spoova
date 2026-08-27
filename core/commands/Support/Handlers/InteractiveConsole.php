<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\commands\Root\Cli;

/**
 * The :wiz channel — collects a whole block of code and runs it once a semicolon
 * is entered on a line of its own.
 *
 * Everything but the heading comes from {@see WizConsole}.
 */
class InteractiveConsole extends WizConsole {

    protected function interact() : void {

        Cli::textView(Cli::alert("Welcome to wiz code runner!"), 0, "|1");

        Cli::textView(Cli::alert(Cli::emos('block')."Paste or write your (PHP) code below: "), 1, "1|1");
        Cli::textView(Cli::warn(" Remember to finally submit code using semicolon. "), "2|1", "1|1");

        self::process();

    }

}
