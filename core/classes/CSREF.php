<?php

namespace spoova\mi\core\classes;

use Res;
use Form;
use Window;
use Session;
use spoova\mi\core\classes\Hasher;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\Ghost\GhostFunction;

/**
 * This class provides methods for CSRF Pushed data
 * 
 */
class CSREF {

    /**
     * Time at which request was sent
     *
     * @var string
     */
    public $time;

    /** 
     * Time at which request was sent
     *  - Alias for {@see CSREF::$time} 
     **/
    public $TIME;

    /** 
     * Specifies if CSRF data is valid
     **/    
    public $valid;

    /** 
     * Specifies if CSRF data is valid
     *  - Alias for {@see CSREF::$valid} 
     **/       
    public $VALID;

    /** 
     * Specifies if CSRF data is valid
     *  - Alias for {@see CSREF::$valid} 
     **/    
    public $isValid;

    final public function __construct(protected GhostDraft $get, protected ?GhostFunction $proxy = null)
    {
        $this->proxy = GhostProxy::map($this->get->id(), fn() => $this->get->ghost());
        $this->time = $this->proxy->ghostData('time');
        $this->TIME = $this->proxy->ghostData('time');

        $this->valid = $this->proxy->ghostData('valid');
        $this->VALID = $this->proxy->ghostData('valid');
        $this->isValid = $this->proxy->ghostData('valid');
    }

    /**
     * Time at which CSRF data was sent
     *
     * @return string
     */
    public function time() : string {
        return $this->proxy->ghostData('time');
    }

    /**
     * Specifies if CSRF data is authentic
     *
     * @return boolean
     */
    public function valid() : bool {
        return $this->proxy->ghostData('valid');
    }

    /**
     * Specifies if CSRF data is authentic
     *
     * @return boolean
     */
    public function isValid(){
        return $this->proxy->ghostData('isValid');
    }

}