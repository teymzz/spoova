<?php

namespace spoova\mi\core\commands\Root\Cli\CliPulser;

use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;

abstract class CliBits {

    public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
    }

    /**
     * Returns the full pulsated text string.
     * @return string
     */
    public function message() : string {
        return $this->proxy->char;
    }
    
    /**
     * Returns the current index character
     * @return string
     */
    public function char() : string {
        return $this->proxy->char;
    }

    /**
     * Returns the current character index
     *
     * @return int
     */
    public function index() : int{
        return $this->proxy->index + 1;
    }

    /**
     * Checks if the the bit is at the beginning character of the string selected or matched
     * @return boolean
     */
    public function startPosition() : bool {
        return $this->proxy->startPosition;
    }

}