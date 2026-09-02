<?php 

namespace spoova\mi\core\classes\Ghost; 

use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;

/**
 * This class serves as anonymous extension helper class to assist in the faster creation of custom GhostProxy methods.
 *  - This class is part of the GhostProxy system and cannot be instantiated directly.
 *  - The {@see GhostClass::__construct()} method is designed to automatically initialize the GhostDraft and GhostFunction proxy objects 
 *    while automapping the GhostProxy data itself throught the {@see GhostProxy::map()} method.
 *  - The {@see GhostClass::__construct()} method cannot be overridden in the extended class, however, the {@see GhostClass::ghostInit()} method
 *    can be used to initialize the class with custom logic which will not override the GhostProxy mapping.
 *  - Proxy data is available and never lost during initialization.
 *  - Custom methods can be added to the extended class as needed but ghostInit should be used for initialization.
 *  - Properties like proxy and get are protected and can be accessed within the extended class but should not be overridden 
 *    to prevent breaking the GhostProxy functionality or losing the GhostProxy data mapping.
 */
abstract class GhostClass {

    final public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
        $proxy = $this->proxy; // assign proxy to local variable for easy access
        $this->ghostInit(); // initialize custom class
        $this->proxy = $proxy; // re-assign proxy to ensure it is not lost during initialization;
    }

    /**
     * This method should be used to initialize a child class.
     *  - This method is called at the end of the constructor after the GhostProxy mapping is completed.
     *  - Proxy data is available and never lost during initialization.
     * @return void
     */
    protected function ghostInit() : void {}

    public function __toString()
    {
        return (string) $this->proxy;
    }
}