<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use Closure;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

trait APIHeaders {

  use APIValidation;

  /**
   * Validation method to check for specified headers in ajax headers
   *
   * @param array $keys an array list of valid headers and their respective values
   *  - Headers keys in list whose values are set as false, will not have the header value validated
   *  - Default response code when validation fails is 400 (bad request)
   * 
   * @param Closure|null $callback triggered only if defined and takes {@see spoova\mi\core\classes\Bundle\API\APITest} instance: function(APITest $test):void
   * @param array $data if defined, will overwrite $_SERVER test data assumed by default.
   * 
   * @return API
   */
  public static function headers(array $keys, ?Closure $callback = null, array $data = []) : API {
    if(!self::errorDebounce()){
      if((self::getProp('testid')===false) || $callback){
        
        // define source data to be validated
        $headers = func_num_args() > 2? $data : ($_SERVER ?? []);

        $missing = []; // refers to missing/empty header keys
        $mismatch = []; // refers to request header keys whose values do not match expected value.
        $invalid = []; // refers to missing/empty, mismatched headers values

        foreach($keys as $header => $value){
          if(!array_key_exists($header, $headers)){
            $missing[] = $header;
            $invalid[] = $header;
          }elseif(($value !== false)){
            if((is_string($value) && (strtolower($headers[$header]) !== strtolower($value))) || (is_array($value) && (!in_array($headers[$header], $value))) || (!is_string($value) && !is_array($value))){
              $mismatch[] = $header;
              $invalid[] = $header;
            }elseif(($value === true) && empty($headers[$header])){
              // value header key's value must not be empty else logged as missing
              $missing[] = $header;
              $invalid[] = $header;
            }
          }
        }

        // set missing, empty and invalid data
        if($missing) self::setLog('headers','missing',array_unique($missing)); // expected header keys that are missing
        if($mismatch) self::setLog('headers','mismatch',array_unique($mismatch)); // headers with empty or invalid string values  
        if($invalid) self::setLog('headers','invalid',array_unique($invalid)); // headers with empty or invalid string values  

        $response_data = self::getLog('headers') ?? [];

        if($callback){

          $Ghost = self::make_ghost(['headers', 'headers_required','addLog']);
          $Ghost->headers(function($type) use($response_data){
            return $response_data[$type] ?? []; // return response data
          });
          $Ghost->headers_required(function() use($keys){
            return $keys; // returns supplied test keys and values pair
          });
          $Ghost->addLog(fn($key, $value) => self::setLog('headers',$key,$value));

          GhostProxy::new($Ghost, fn(GhostDraft $draft) =>
            new class($draft) extends APITest {

              public function missing(array $data) {
                
                $proxy = $this->proxy;
                $missing = $proxy->headers('missing');
                $invalid = $proxy->headers('invalid');
                
                $headers_required = array_keys($proxy->headers_required());
                
                foreach($headers_required as $datakey) {
                  if(in_array($datakey, $missing)){
                    if(!$proxy->debounce()){
                      $proxy->set('response_error', true);
                      $proxy->set('response_code', 400);
                      $message = $data[$datakey] ?? 'missing http request header '.$datakey;
                      $proxy->set('response_message', $message);
                      $proxy->addLog('missing', $missing);
                      $proxy->addLog('invalid', $invalid);
                      break;
                    }
                  }
                }

                return $missing;
              }

              public function mismatch(array $data) { 
                
                $proxy = $this->proxy;
                $mismatches = $proxy->headers('mismatch');
                $invalid = $proxy->headers('invalid');
                $headers_required = array_keys($proxy->headers_required());

                foreach($headers_required as $header) {
                  if(in_array($header, $mismatches)){
                    if(!$proxy->debounce()){
                      $proxy->set('response_error', true);
                      $proxy->set('response_code', 400);
                      $message = $data[$header] ?? 'invalid http request header value detected for '.$header;
                      $proxy->set('response_message', $message);
                      $proxy->addLog('mismatch', $mismatches);
                      $proxy->addLog('invalid', $invalid);
                      break;
                    }
                  }
                }
                return $mismatches;
              }

              public function invalid(array $data) { 

                $proxy = $this->proxy;
                $invalid = $proxy->headers('invalid');
                $headers_required = array_keys($proxy->headers_required());

                foreach($headers_required as $header){
                  if(in_array($header, $invalid)){
                    if(!$proxy->debounce()){
                      $proxy->set('response_error', true);
                      $proxy->set('response_code', 405);
                      $message = $data[$header] ?? 'invalid http request header value detected for '.$header;
                      $proxy->set('response_message', $message);
                      $proxy->addLog('invalid', $invalid);
                      break;
                    }
                  }
                }
                return $invalid;
              }

            }
          );

          $callback(GhostProxy::object()); // inject GhostProxy's GhostFunction for APITest
          
        }

        if(!self::getProp('response_error') && $invalid && (self::getProp('testid')===false)){
            // set a default response error message if no response previously exists.
            self::setProp('response_error', true);
            self::setProp('response_code', 405);
            self::setProp('response_message', 'unauthorized request');
            self::setProp('headers', $response_data);
        }
      }
    }

    return self::API();

  }
}