<?php 

namespace spoova\mi\core\classes\Ghost;

interface GhostInterface {

    /**
     * Designed for mapping a GhostProxy class to an abstract handler class.
     *
     * @return GhostInterface
     */
    public function map() : GhostInterface;

}