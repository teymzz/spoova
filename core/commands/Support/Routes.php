<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\classes\RouteInspector;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

/**
 * Command line class for inspecting the registered route map.
 *
 *   mi routes              -> pretty table (dynamic: fully resolved paths)
 *   mi routes json         -> the same map as JSON
 *   mi routes --static     -> parse source without executing anything (safe)
 *   mi routes json --static
 *
 * Dynamic mode puts the shutters into capture mode and evaluates route
 * expressions (e.g. lastCall()), but executes controller constructors behind
 * guards. Static mode reads the self::call() definitions from source and never
 * executes code; dynamic keys/values appear as their source text.
 */
class Routes extends Entry {

    public function __construct($args = [])
    {
        $args   = array_map('strtolower', $args);
        $static = in_array('--static', $args, true) || in_array('static', $args, true);
        $json   = in_array('json', $args, true);

        $unknown = array_diff($args, ['json', '--static', 'static']);

        Cli::textView(Cli::danger(Cli::emo('point-list').' routes'.($static ? ' --static' : '').($json ? ' json' : '')));
        Cli::break(2);

        if($unknown){
            Cli::textView(Cli::error('invalid argument "'.Cli::warn(implode(' ', $unknown)).'" for '.Cli::alert('routes')));
            Cli::break(1)->bashBreak(1);
            return;
        }

        if($json){
            echo RouteInspector::toJson(null, $static).PHP_EOL;
            Cli::break(1)->bashBreak(1);
            return;
        }

        echo RouteInspector::render(null, $static);
        Cli::break(1)->bashBreak(1);
    }

}
