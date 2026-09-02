<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\Livescript;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

/**
 * This class only handles commands form {@see Entry::main} and commands 
 * associated within the Support directory.
 */
class MiSupport extends Entry {

    public static function initialize(string $class, array $commands, string $command) {
        // class in "core\commands\Support\\$command'
        
        if(defined($class.'::latent_mode') && $class::latent_mode === true) Cli::silentErrors();
        $arguments = array_values($commands);
        
        new $class($arguments);
    }

}