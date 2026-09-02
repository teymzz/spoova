<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use Closure;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

trait APIData {

  use APIValidation;

  /**
   * Enables data validation through {@see \spoova\mi\core\classes\Bundle\API\APIData} GhostFunction methods
   *  - Default error response code if validation fails is 400 (bad request)
   * 
   * @param array $source request or custom data used for validation.
   * @param Closure $callback triggered for source data validation and takes {@see \spoova\mi\core\classes\Bundle\API\APIData} instance : function(APIData $data):void
   * @param array $expected expected keys and value. This argument must be supplied in order to be able to use the {@see \spoova\mi\core\classes\Bundle\API\APIData::missing()} 
   * and {@see \spoova\mi\core\classes\Bundle\API\APIData::invalid()} methods.
   * @return API
   */
  public static function data(array $source, Closure $callback, ?array $expected = null){ 
    if(!self::errorDebounce()){
      
      $Ghost = self::make_ghost(['data','addLog','expected']);
      $Ghost->data(fn() => $source);
      $Ghost->expected(fn() => $expected);
      $Ghost->addLog(fn($key, $value) => self::setLog('data',$key,$value));


      GhostProxy::new($Ghost, fn(GhostDraft $draft) => 
    
        //* All validation methods are directly defined within the APIData class *//
        new class($draft) extends \spoova\mi\core\classes\Bundle\API\APIData {}

      );
      $callback(GhostProxy::object());
    }

    return self::API();
  }

}