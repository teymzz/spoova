<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use Closure;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

trait APIReferer {

  use APIValidation;

  /**
   * Set the log value for XMLHttpRequest
   */
  abstract public static function setLog(string $name, string $key, mixed $value);


  /**
   * Enforces the requirement for an API referer URL 
   *  - Default error response code if validation fails is 403 (forbidden request)
   * 
   * @param array $referers list of expected referers (e.g http://domain/foo/bar)
   * @param Closure|null $callback A closure triggered if defined and takes {@see spoova\mi\core\classes\Bundle\API\APITest} instance: function(APITest $test): void
   * @throws Exception for unsupported {@see spoova\mi\core\classes\Bundle\API\APITest::mismatch()} validation method
   * @return API
   */
  public static function isReferred(array $referers = [], ?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      if(!self::getProp('response_error') || $callback){
        $referer = $_SERVER['HTTP_REFERER'] ?? false;
        if((!$referer) || ($referers && !in_array($referer, $referers))){
          if($callback){
            $Ghost = self::make_ghost(['referer','referers','addLog']);
            $Ghost->referer(fn() => $referer);
            $Ghost->referers(fn() => $referers);
            $Ghost->addLog(fn($key, $value) => self::setLog('referer',$key,$value));
            
            GhostProxy::new($Ghost, fn(GhostDraft $draft) => 
              new class($draft) extends APITest {
                public function missing(array $data = [])
                {
                  // handle missing referer
                  if(!$this->proxy->referer()){
                    if(!$this->proxy->debounce()){
                      $this->proxy->set('response_error', true);
                      $this->proxy->set('response_code', 403);
                      $message = array_values($data)[0] ?? 'missing http referer';
                      $this->proxy->set('response_message', $message);
                      $this->proxy->addLog('missing', $message);
                      $this->proxy->addLog('invalid', [$this->proxy->referer()]);
                    }
                  }
                }
                public function invalid(array $data = []){ 
                  // handle invalid referer
                  $referers = $this->proxy->referers();
                  $referer = $this->proxy->referer();
                  if(!in_array($referer, $referers)){
                    if(!$this->proxy->debounce()){
                      $this->proxy->set('response_error', true);
                      $this->proxy->set('response_code', 403);
                      $message = array_values($data)[0] ?? 'invalid http referer';
                      $this->proxy->set('response_message', $message);
                      $this->proxy->addLog('invalid', [$this->proxy->referer()]);
                    }
                  }
                }
                public function mismatch(array $data = []){ 
                  // handle invalid referer
                  $referers = $this->proxy->referers();
                  $referer = $this->proxy->referer();
                  if(!in_array($referer, $referers)){
                    if(!$this->proxy->debounce()){
                      $this->proxy->set('response_error', true);
                      $this->proxy->set('response_code', 403);
                      $message = array_values($data)[0] ?? 'bad http referer';
                      $this->proxy->set('response_message', $message);
                      $this->proxy->addLog('mismatch', [$this->proxy->referer()]);
                      $this->proxy->addLog('invalid', [$this->proxy->referer()]);
                    }
                  }
                }
              }
            );
            $callback(GhostProxy::object());
            // if(!self::getProp('response_error')){
            //   self::setProp('response_error', true);
            //   self::setProp('response_code', 403);
            //   self::setProp('response_message', 'forbidden');
            //   self::setLog('referer','invalid',$referer);
            //   self::setLog('referer','mismatch',$referers);
            //   self::setLog('referer','missing',$referers);
            // }
          }
        }
        if(!self::getProp('response_error') && self::getProp('testid') === false){
          if(($referers && !in_array($referer, $referers))||!$referer){
            self::setProp('response_error', true);
            self::setProp('response_code', 403);
            self::setProp('response_message', 'forbidden');
            self::setLog('referer','invalid',$referer);
            self::setLog('referer','mismatch',$referers);
            self::setLog('referer','missing',$referers);
          }
        }
      }
    }
    return self::API();
  }

}