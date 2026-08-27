<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\commands\Root\Cli;

/**
 * The :wizi channel — evaluates each line as it is entered and stays open for the
 * next one, carrying variables across lines.
 *
 * Everything but the heading comes from {@see WizConsole}.
 */
class CastConsole extends WizConsole {

    protected function interact() : void {

        Cli::textView(Cli::alert("Welcome to wizi code runner!"), 0, "|1");

        Cli::textView(Cli::alert(Cli::emos('ribbon-arrow')." Paste or write your code below: "), "2|1", "1|1");
        Cli::textView(Cli::warn(" Remember to end code with a semicolon delimiter. "), "5|1", "1|1");

        // the callback answers the console commands; everything else is run as PHP
        Cli::cast(static::caster());

    }

}
