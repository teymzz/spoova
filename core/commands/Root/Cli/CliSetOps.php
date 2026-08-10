<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use Error;
use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;

abstract class CliSetOps {

    public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
    }

    /**
     * Tests the number of argument counts
     *
     * @return boolean
     */
    public function isCount($key) : bool {
        return $this->proxy->isCount($key);
    }

    /**
     * Returns the total number of argument counts
     *
     * @return int
     */
    public function count($key) : int {
        return $this->proxy->count();
    }

    /**
     * Returns arguments supplied
     *
     * @param string|int $key if supplied, returns the value of $key in argument if it exists else FALSE is returned
     * 
     * @return array|string|false 
     *   - ```array``` : command arguments if $key is not supplied
     *   - ```string``` : value of $key in command's arguments
     *   - ```FALSE``` : only if $key is provided and does not exist in command's arguments.
     */
    public function argument(string|int $key = null) : array|string|false {
        return $this->proxy->count();
    }

}