<?php

namespace spoova\mi\core\classes\Bundle\API\APITest;

use Closure;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

trait APIQueries {

  use APIValidation;

  /**
   * Validation method to check for specified url query parameters in ajax url address
   *  - Note that url queries is retrieved internally from forwarded URL request.
   *  - Default error response code if validation fails is 405 (unauthorized request)
   * 
   * @param array $keys an array list of valid parameters and their respective values
   *  - $keys format : [key=>value]
   *  - Default response code when validation fails is 405
   *  - All specified keys are assumed to be required in request url query
   *  - For a given array key (i.e query name), a FALSE value validates key, TRUE 
   *    value validates key & non-empty value, STRING value ensures that query name's
   *    value is equivalent to string specified
   * 
   * @param Closure|null $callback A closure triggered if defined and takes {@see spoova\mi\core\classes\Bundle\API\APITest} instance: function(APITest $test): void
   * check is done.
   * 
   * @return API
   */
  public static function queries(array $keys, ?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      if((self::getProp('testid')===false) || $callback){

        $queries = url(uri)->query();
        if(!$queries) $queries = self::getProp('queries'); // use manually set queries if url query is empty
        
        // mismatch: key existing that does not match desired non-boolean value
        // missing: key that is non-existing or existing with empty value when expected value is set to TRUE 
        // invalid: key that is missing or mismatched
        $missing = []; 
        $mismatch = [];
        $invalid = [];

        // validate required query keys and values
        foreach($keys as $key => $value){
          if(!isset($queries[$key])){
            $missing[] = $key;
            $invalid[] = $key;
          }else{
            if(($value === true) && empty($queries[$key])){
              $missing[] = $key;
              $invalid[] = $key;
            }elseif(($value !== false) && $value !== true && ($queries[$key] !== $value)) {
              $mismatch[] = $key;
              $invalid[] = $key;
            }
          }
        }

        // set empty, missing and invalid data
        if($invalid) self::setLog('queries','invalid',$invalid);
        if($missing) self::setLog('queries','missing',$missing);
        if($mismatch) self::setLog('queries','mismatch',$mismatch);

        $response_data = self::getProp('queries') ?? [];
        $response_data['fetched'] = $queries;

        if($callback && self::getProp('testid')===false){

          $Ghost = self::make_ghost(['queries', 'queries_required', 'invalids', 'addLog']);
          $Ghost->queries(function($type) use($response_data){
            return $response_data[$type] ?? ''; // returns stored queries log data
          });
          $Ghost->queries_required(function() use($keys){
            return $keys; // returns supplied required test keys and values pair
          });
          $Ghost->invalids(function($type) use($invalid, $missing, $mismatch){
            return [
              'invalid' => $invalid,
              'missing' => $missing,
              'mismatch' => $mismatch
            ][$type] ?? [];
          });
          $Ghost->addLog(fn($key, $value) => self::setLog('queries',$key,$value));

          GhostProxy::new($Ghost, fn(GhostDraft $draft) =>
            new class($draft) extends APITest {

              // test for missing queries
              public function missing(array $data) {
                // $data contains expected data keys and corresponding messages
                $proxy = $this->proxy();
                $missing = $proxy->queries('missing') ?: [];
                $requireds = array_keys($proxy->queries_required()); 
                
                foreach ($requireds as $required) {
                  if(in_array($required, $missing)){
                    if(!$proxy->debounce()){
                      $proxy->set('response_error', true);
                      $proxy->set('response_code', 405);
                      $message = $data[$required] ?? "url query key \"{$required}\" is missing.";
                      $proxy->set('response_message', $message);
                      $proxy->addLog('missing', $missing);
                      $proxy->addLog('invalid', $proxy->queries('invalid'));
                      break;
                    }
                  }
                }

              }

              // test for mismatched queries
              public function mismatch(array $data) {
                // $data contains expected data keys and corresponding messages
                $proxy = $this->proxy();
                $mismatches = $proxy->queries('mismatch') ?: [];

                foreach ($mismatches as $mismatch) {
                  if(!$proxy->debounce()){
                    $proxy->set('response_error', true);
                    $proxy->set('response_code', 405);
                    $message = $data[$mismatch] ?? "mismatched query key \"{$mismatch}\".";
                    $proxy->set('response_message', $message);
                    $proxy->addLog('mismatch', $mismatch);
                    $proxy->addLog('invalid', $proxy->queries('invalid'));
                    break;
                  }
                }

              }

              public function invalid(array $data) { 
                $proxy = $this->proxy();
                if(!$proxy->debounce()){
                  $queries_required = $proxy->queries_required();
                  $merge = array_merge($queries_required, $data);
                  $datakeys = array_keys($merge); // query keys that are required.
                  $invalids = $proxy->invalids('invalid');
                  if($invalids){
                    foreach($invalids as $invalid){
                      $message = $data[$invalid] ?? 'unauthorized url query detected for '.$invalid;
                      $proxy->set('response_error', true);
                      $proxy->set('response_code', 405);
                      $proxy->set('response_message', $message);
                      $proxy->addLog('invalid',$invalids);
                      break;
                    }
                  }
                }
              }
            }
          );

          $callback(GhostProxy::object()); // this will not work because of debounce() affecting missing!!!.

        } 
        
        if(($invalid??[])&& !self::getProp('response_error') && self::getProp('testid') === false){
          // set default invalid response if no callback is defined or if callback did not set response error
          if((self::getProp('testid')===false) && (!self::getProp('response_error'))){
            self::setProp('response_error', true);
            self::setProp('response_code', 405);
            self::setProp('response_message', 'unauthorized request');
            self::setLog('queries','invalid',$invalid);
            self::setLog('queries','missing',$missing);
            self::setLog('queries','mismatch',$mismatch);
          }
        }

      }
    }

    return self::API();

  }

  /**
   * Sets the request method data (i.e POST, GET) to be used for testing queries
   * @param string $method optional [POST|GET]
   * @return API
   */
  public static function setqueries(string $method = 'GET') : API {
    $method = strtolower($method);
    if($method === 'post'){
      $method = $_POST;
    }else{
      $method = $_GET;
    }
    self::setProp('queries', $method);
    return self::API();
  }

}