<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use Closure;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

trait APIXMLHttpRequest {

  use APIValidation;

  /**
   * Set the log value for XMLHttpRequest
   */
  abstract public static function setLog(string $name, string $key, mixed $value);

  /**
   *
   * Validation method to check for XMLHttpRequest in ajax header
   *  - Default response code when validation fails is 400 (bad request)
   *  - API test method supports two test methods: missing() and invalid()
   * @param Closure|null $callback A closure triggered if defined and takes {@see spoova\mi\core\classes\Bundle\API\APITest} instance: function(APITest $test): void
   * @return API
   */
  public static function isXMLHttpRequest(?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      $request = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? false;
      $isXMLHttpRequest = $request === 'XMLHttpRequest';

      if(self::getProp('testid')===false || $callback){
        if(!$isXMLHttpRequest){

          if($callback && self::getProp('testid')===false){
            $Ghost = self::make_ghost(['requestType','addLog']);
            $Ghost->requestType(fn() => is_string($request)? strtolower($request) : false);
            $Ghost->addLog(fn($key, $value) => self::setLog('XMLHttpRequest',$key,$value));

            GhostProxy::new($Ghost, fn(GhostDraft $draft) => 
              new class($draft) extends APITest {
                public function missing(array $data = [])
                {
                  if($this->proxy->requestType() === false){
                    if(!$this->proxy->debounce()){
                      $this->proxy->set('response_error', true);
                      $this->proxy->set('response_code', 400);
                      $message = array_values($data)[0] ?? 'missing xmlHTTPRequest header';
                      $this->proxy->set('response_message', $message);
                      $this->proxy->addLog('missing', ['XMLHttpRequest']);
                      // missing data is automatically invalid
                      $this->proxy->addLog('invalid', [$this->proxy->requestType()]);
                    }
                  }
                }
                public function invalid(array $data = []){ 
                  if($this->proxy->requestType() !== 'xmlhttprequest'){
                    if(!$this->proxy->debounce()){
                      $this->proxy->set('response_error', true);
                      $this->proxy->set('response_code', 400);
                      $message = array_values($data)[0] ?? 'invalid XMLHttpRequest header';
                      $this->proxy->set('response_message', $message);
                      $this->proxy->addLog('invalid', [$this->proxy->requestType()]);
                    }
                  }
                }
              }
            );
            $callback(GhostProxy::object());
          }
        }
      }
      if(!$isXMLHttpRequest && !self::getProp('response_error') && self::getProp('testid') === false){
        self::setProp('response_error', true);
        self::setProp('response_code', 400);
        self::setProp('response_message', 'requires XMLHttpRequest header');
        self::setLog('XMLHttpRequest','invalid',[$request]);
        self::setLog('XMLHttpRequest','missing',['XMLHttpRequest']);
      }
    }

    return self::API();
  }

}