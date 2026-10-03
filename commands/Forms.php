<?php

namespace spoova\mi\commands;

use spoova\mi\core\commands\Consoler\Consoler;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliForms;

class Forms extends Consoler {
        
    /**
     * Set the maximum number of arguments allowed.
     */
    protected static int $args_max = 5;

    /**
     * Set arguments and options allowed on this command
     *
     * @return array
     */
    public static function setOps() : array {

        return [
            'test' => 'test',

            fn() => [
                
                '' => 'This is '.Cli::alert('forms').' command.',
                'test' => [
                    'i' => 'this is description for "'.Cli::warn('test').'".',
                    'x' => Cli::warn('php mi').' '.Cli::alert('cat::forms').' '.Cli::valid('test'),
                ]
            ]
        ];

    }

    /**
     * This is a dummy test command
     */
    public static function test() {
        
        CliForms::password();

    }

}
