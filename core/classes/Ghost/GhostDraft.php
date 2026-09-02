<?php 

namespace spoova\mi\core\classes\Ghost;

use spoova\mi\core\classes\Ghost\GhostFunction;

abstract class GhostDraft {

    /**
     * Returns the data id of a GhostProxy object
     *
     * @return int
     */
    abstract public function id() : int;

    /**
     * Returns internally parsed GhostFunction object data
     * from GhostDraft wrapper
     *
     * @return GhostFunction
     */
    abstract public function ghost() : GhostFunction;

}