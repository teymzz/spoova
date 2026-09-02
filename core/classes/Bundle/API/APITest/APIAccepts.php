<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use Closure;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

trait APIAccepts {

  use APIValidation;

  /**
   * Validation method to check for specified headers in ajax headers
   *  - Default error response code if validation fails is 405 (unauthorized request)
   *
   * @param string|string[] $requests a request method string name or array list of valid request methods
   *  - Example format: 'POST' or ['POST','GET']
   *  - Request method names are case insensitive
   * @param Closure|null $callback A closure triggered if defined and takes {@see spoova\mi\core\classes\Bundle\API\APITest} instance: function(APITest $test): void
   * 
   * @return API
   */
  public static function accepts(string|array $requests, ?Closure $callback = null) : API {
    if(!self::errorDebounce()){

      $request_method = self::request();
      $requests = (array) $requests;
      $requests = array_map(fn($val) => strtolower($val), $requests);
      $accepts = array_values($requests);

      if((self::getProp('testid')===false) || $callback){

        if(!$request_method){
            self::setLog('methods', 'missing', $missing = $accepts);
        }elseif(!in_array($request_method, $requests)){
            self::setLog('methods', 'mismatches', $mismatches = array_values($requests));
        }

        $invalid = $missing ?? $mismatches ?? [];

        if($invalid) {

          self::setLog('methods', 'invalid', $invalid);
          $mlog = self::getProp('log')['methods'] ?? [];

          if($callback && self::getProp('testid')===false){

            $Ghost = self::make_ghost(['method','methods','methods_allowed']);
            
            $Ghost->method(function() use($request_method){
              return $request_method;
            });
            $Ghost->methods(function($type) use($mlog){
              return $mlog[$type] ?? [];
            });
            $Ghost->methods_allowed(function() use($requests){
              return $requests;
            });
            
            GhostProxy::new($Ghost, fn(GhostDraft $draft) => 

              new class($draft) extends APITest {

                public function missing(array $data){
                  $proxy = $this->proxy();
                  $message = array_values($data)[0] ?? 'missing request method ('.implode(' or ',$proxy->methods_allowed()).')';
                  $missing = $proxy->methods('missing');
                  if(!$proxy->debounce() && $missing){
                    $proxy->set('response_error', true);
                    $proxy->set('response_code', 405);
                    $proxy->set('response_message', $message);
                  }
                  return $missing;
                }

                public function mismatch(array $data){
                  // when request method is detected but does not match the accepted request method types
                  $proxy = $this->proxy();
                  $mismatches = $proxy->methods('mismatch');
                  $requests = $proxy->methods_allowed();
                  $message = array_values($data)[0] ?? 'api request method "'.$proxy->method().'" does not match ('.implode(',',$requests).')';

                  foreach($mismatches as $header){
                    if(!$proxy->debounce()){
                      $proxy->set('response_error', true);
                      $proxy->set('response_code', 405);
                      $proxy->set('response_message', $message);
                      break;
                    }
                  }
                  return $mismatches;
                }

                public function invalid(array $data){
                  $proxy = $this->proxy();
                  $message = array_values($data)[0] ?? 'invalid request method';
                  if(!$proxy->debounce() && $proxy->methods('invalid')){
                    $proxy->set('response_error', true);
                    $proxy->set('response_code', 405);
                    $proxy->set('response_message', $message);
                  }
                }

              }
          
            );

            $callback(GhostProxy::object());
          }
        }
      }
          
      if(!in_array($request_method, $requests) && self::getProp('testid') === false && !self::getProp('response_error')){
        self::setProp('response_error', true);
        self::setProp('response_code', 405);
        self::setProp('response_message', 'invalid request method'.($request_method? ' ('.$request_method.')' : ''));
        self::setLog('methods','invalid',$request_method);
        self::setLog('methods','missing',$accepts);
        self::setLog('methods','mismatch',$mismatches ?? []);
      }
    }

    return self::API();

  }

}

