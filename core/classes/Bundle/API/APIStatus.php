<?php 

namespace spoova\mi\core\classes\Bundle\API;

use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;

/**
 * Ghost class for API Bundle. Provides IDE support for response state methods 
 * such as {@see API::failed()}, {@see API::success()},
 * 
 * @uses API class for managing API requests.
 */
abstract class APIStatus extends GhostClass {

    /**
     * Return GhostFunction data object
     *
     * @return GhostFunction data
     */
    protected function proxy() : GhostFunction {
        return $this->proxy;
    }

    protected function getProxy(string $value){
      return $this->proxy->$value;
    }

    /**
     * Returns the response status code.
     *
     * @return int
     */
    abstract public function status() : int;

    /**
     * Alias of {@see APIStatus::status()}. Returns the response status code.
     *
     * @return int
     */
    public function code() : int{
        return $this->status();
    }

    /**
     * Returns the string message from API response
     * 
     * @return string
     */
    abstract public function message() : string;

    /**
     * Returns the message id from API response
     * 
     * @return int
     */
    abstract public function id() : int;

    /**
     * Returns the last log
     *
     * @return array|false
     */
    abstract public function log(): array|false;
}