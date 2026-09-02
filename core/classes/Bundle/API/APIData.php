<?php 

namespace spoova\mi\core\classes\Bundle\API;

use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Ghost\GhostClass;
use spoova\mi\core\classes\Ghost\GhostFunction;

/**
 * Ghost class for API Bundle. Provides IDE support for data validation
 *  - Note that this class works with the {@see API::data()} class bundle
 * 
 * @uses API class for managing API requests.
 */
abstract class APIData extends GhostClass {

    protected static $response_set = false;

    /**
     * Map GhostProxy id and return GhostFunction data object
     *
     * @return GhostFunction data
     */
    protected function proxy() : GhostFunction {
        return $this->proxy;
    }

    /**
     * Sets error response message for missing data keys that are detected for a given API data validation method.
     *
     * @param string[] $responder array of keys and values pair where if test key fails, value is triggered as response.
     *  - The format is: ['data_key'=>'error_message']
     * @return array list of missing data keys
     */
    public function missing(array $responder) : array {
      // missing data stored by calling the missing method
      $proxy = $this->proxy();
      if($proxy->debounce()) return [];
      $data = $proxy->data(); // source data
      $missing = [];
      foreach($responder as $ekey => $eval){
        if(!array_key_exists($ekey, $data)){
          if(!$proxy->debounce() && !$missing && !self::$response_set){
            self::$response_set = true;
            $proxy->set('response_error', true);
            $proxy->set('response_code', 400);
            $message = $eval ?? 'api missing data key "'.$ekey.'" is required';
            $proxy->set('response_message', $message);
          }
          $missing[] = $ekey;
        }
      }

      $log = $proxy->get('log');
      $logdata = $log['data'] ?? [];
      $oldmissing = $logdata['missing'] ?? [];
      $missing = array_merge($oldmissing, $missing);
      $proxy->addLog('missing', $missing);
      
      $invalid = $log['data']['invalid'] ?? [];
      $invalid = array_unique(array_merge($invalid, $missing));
      $proxy->addLog('invalid', $invalid);
      return $missing;
    }

    /**
     * Sets error response message for missing data keys or data keys with empty values
     *  - When applied, performs check for both missing and empty values.
     *  - This method should not be used together with {@see APIData::missing()} method.
     * @param string[] $responder array of keys and values pair where if test key fails, value is triggered as response.
     *  - The format is: ['data_key'=>'error_message']
     * @return array list of data keys with missing or empty values
     */
    public function void(array $responder) : array {
      $proxy = $this->proxy();
      if($proxy->debounce()) return [];
      $data = $proxy->data(); // return source data
      $empty = [];
      
      foreach($responder as $ekey => $eval){
        if(empty($data[$ekey])){
          if(!$proxy->debounce() && !$empty && !self::$response_set){
            self::$response_set = true;
            $proxy->set('response_error', true);
            $proxy->set('response_code', 400);
            $message = $eval ?? 'api data key "'.$ekey.'" is blank';
            $proxy->set('response_message', $message);
          }
          $empty[] = $ekey;
        }
      }

      $oldempty = $proxy->get('log');
      $logdata = $log['data'] ?? [];
      $oldempty = $logdata['empty'] ?? [];
      
      $empty = array_merge($oldempty, $empty);
      $proxy->addLog('empty', $empty);
      $invalid = $log['data']['invalid'] ?? [];
      $invalid = array_unique(array_merge($invalid, $empty));
      $proxy->addLog('invalid', $invalid);
      return $empty;
    }

    /**
     * Sets error response message for detected data keys whose values mismatches expected values of a given API data validation method.
     * 
     * @param string[] $responder array of keys and values pair where if test key fails, value is triggered as response.
     * @return array list of data keys with mismatched values
     */
    public function mismatch(array $responder) : array {
      // empty data stored by calling empty method
      $proxy = $this->proxy();
      if($proxy->debounce()) return [];
      $data = $proxy->data(); // return source data
      $expected = $proxy->expected() ?: [];
      $mismatch = [];
      foreach($expected as $ekey => $eval){
        if(array_key_exists($ekey, $data) && ($data[$ekey] !== $eval)){
          if(!$proxy->debounce() && !$mismatch && !self::$response_set){
            self::$response_set = true;
            $proxy->set('response_error', true);
            $proxy->set('response_code', 400);
            $message = $responder[$ekey] ?? 'api requires matching data key "'.$ekey.'"';
            $proxy->set('response_message', $message);
          }
          $mismatch[] = $ekey;
        }
      }
      
      $oldmismatch = $proxy->get('log');
      $logdata = $log['data'] ?? [];
      $oldmismatch = $logdata['mismatch'] ?? [];
      
      $mismatch = array_merge($oldmismatch, $mismatch);
      $proxy->addLog('mismatch', $mismatch);
      
      $invalid = $log['data']['invalid'] ?? [];
      $invalid = array_unique(array_merge($invalid, $mismatch));
      $proxy->addLog('invalid', $invalid);
      return $mismatch;
    }

    /**
     * Sets error response message for detected data keys whose values mismatches expected values of a given API data validation method.
     *
     * @param string[] $responder array of keys and values pair where if test key fails, value is triggered as response.
     * @return array list of data keys with mismatched values
     */
    public function invalid(array $responder) : array {
      $data = $this->proxy->data();
      $expected = $this->proxy->expected();
      $ekeys = array_keys($expected);
      $rkeys = array_keys($responder);
      $testkeys = array_unique(array_merge($ekeys, $rkeys));

      foreach($testkeys as $testkey){
        if(array_key_exists($testkey, $data)){
            $this->void([$testkey => $responder[$testkey] ?? null]);
            $this->mismatch([$testkey => $responder[$testkey] ?? null]);
        }else{
          $this->missing([$testkey => $responder[$testkey] ?? null]);
        }
      }
      return $this->proxy()->get('log')['data']['invalid'] ?? [];
    }

}