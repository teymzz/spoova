<?php 

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\commands\Root\Cli\CliKey;

/**
 * This class contains method callable from {@see CliInput::fetch()} closure argument.
 */
abstract class CliProcess extends GhostClass {

    /**
     * Exit terminal
     *
     * @return void
     */
    public function exit(){
        
        $key = $this->proxy->ghostData('key');
        $buffer = $this->proxy->ghostData('buffer');
        if($key instanceof CliKey) $key->exit();

    }

    /**
     * Returns buffered or inputed text
     */
    public function buffer() : string {
        
        return $this->proxy->ghostData('buffer');

    }

}