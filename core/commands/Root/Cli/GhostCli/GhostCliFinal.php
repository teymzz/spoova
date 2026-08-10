<?php 

namespace spoova\mi\core\commands\Root\Cli\GhostCli;

use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;
use spoova\mi\core\commands\Root\Cli\CliRuntime;

/**
 * This class handles the final data available after before command termination
 */
abstract class GhostCliFinal {

    /**
     * This uses the {@see CliRuntime::duration()} to detect the entire execution time.
     *
     * @param string|null $id
     * @return float
     */
    public function duration(?string $id = null) : float {
        return CliRuntime::duration($id);
    }

    /**
     * This uses the {@see CliRuntime::duration()} to detect the entire execution time.
     *
     * @uses HandleCliErrors::errors()
     * @return array
     */
    public function errors() : array {
        return HandleCliErrors::errors();
    }

}