<?php

namespace spoova\mi\core\classes;

use Closure;
use stdClass;

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 * 
 * This class enables a customized structure 
 * for building ajax responses. It is dependent on 
 * custom "response" function. 
 * Note:: Class should only be initialized with 
 * arguments for ajax requests. This will direct the class to  
 * terminate if the request is not ajax. 
 * 
 *
 */
class API {

  public const NONE = '';
  public const JSON = '';
 
  private const request_types = [
    'post', 'get', 'put', 'delete','head',
    'patch', 'options', 'copy', 'link', 'unlink',
    'purge', 'lock', 'unlock', 'propfind', 'view'
  ];
  
  private static bool $new_state = false;
  private static string $channel_type= '';
  private static bool $debounce = false;
  private static int|false $testid = false;
  private static int $response_code = 500;
  private static string $response_message = '';
  private static bool $response_error = false;
  private static array $response_data = [];
  private static array|string $response_info = [];
  private static array $log = [];

  /**
   * Determines when shutdown displays content
   *
   * @var boolean
   */
  private static bool $view = false;

  /**
   * Determines if raw response data is returned
   *
   * @var boolean
   */
  private static bool $spec = false;
  private bool $error = true;
  private static API $API;

  /**
   * Initialize new ajax request
   */
  private function __construct(){

    self::$API = $this;
    self::$new_state = true;
 	
  }

  private static function resetProperties() {
    //reset properties 
    self::$new_state = false;
    self::$channel_type= '';
    self::$debounce = false;
    self::$testid = false;
    self::$response_code = 500;
    self::$response_message = '';
    self::$response_error = false;
    self::$response_data = [];
    self::$response_info = [];
    self::$log = [];
  }

  /**
   * This method is used for performing basic validation for an api.
   *
   * @param string $type This is used to determine the content-type and response format returned by the API class.
   * @param Closure|null $test
   * 
   * @return API
   */
  public static function channel(string $type = API::NONE, ?Closure $test = null) : API {
    self::$channel_type = $type;
    if(strtolower($type) === 'json'){
      header('content-type: application/json');
    }

    self::resetProperties();

    if(self::$new_state){
      self::$new_state = false;
      $API = self::$API;
    }else{
      $API = self::$API = new static();
    }
    $test($API);
    return $API;
  }
  
  /**
   * Enables error debouncing which prevents further validations 
   * after a first error is triggered by any of the validation methods. 
   *
   * @param boolean $debounce
   * @return void
   */
  public static function debounce(bool $debounce = true){
    self::$debounce = $debounce;
    return self::$API;
  }
  
  /**
   * Checks if an error has been initially debounced.
   *
   * @return boolean TRUE if an error has been previously debounced and FALSE if not. 
   */
  public static function errorDebounce() : bool {
    if(self::$response_error && self::$debounce){
      return true;
    }
    return false;
  }
  
  /**
   * Validation method to check for XMLHttpRequest in ajax header
   * 
   * @param Closure|null $callback when defined closure will always be triggered after
   * check is done.
   *  - Default response code when validation fails is 400
   * 
   * @return API
   */
  public static function isXMLHttpRequest(?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      if(!self::$response_error || $callback){
        $request = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
        if(strtolower($request) !== 'xmlhttprequest'){
          if($callback){
            $response = new stdClass();
            $response->status = 400;
            $response->message = 'invalid http header';
            $response->log = ['HTTP_X_REQUESTED_WITH'=>$request];
            $callback($response);
          }
          if(!self::$response_error){
            self::$response_error = true;
            self::$response_code = 400;
            self::$response_message = 'invalid http header';
            self::$log = ['HTTP_X_REQUESTED_WITH'=>$request];
          }
        }
      }
    }

    return self::$API;
}
  
/**
 * Checks if a request has referer. This may be used to prevent direct access on ajax pages.
 *
 * @param Closure|null $callback
 * @return boolean
 */
public static function isReferred(?Closure $callback = null){
    if(!self::errorDebounce()){
      if(!self::$response_error || $callback){
        if(!($_SERVER['HTTP_REFERER'] ?? '')){
          if($callback){
            $response = new stdClass();
            $response->status = 400;
            $response->message = 'forbidden';
            $response->log = [];
            $callback($response);
          }
          if(!self::$response_error){
            self::$response_error = true;
            self::$response_code = 403;
            self::$response_message = 'forbidden';
          }
        }
      }
    }
    return self::$API;
  }

  /**
   * Validation method to check for specified headers in ajax headers
   *
   * @param array $list an array list of valid headers and their respective values
   *  - Headers keys in list whose values are set as false, will not have the header value validated
   *  - Default response code when validation fails is 400
   * 
   * @param Closure|null $callback when defined closure will always be triggered after
   * check is done.
   * 
   * @return API
   */
  public static function headers(array $list, ?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      if((self::$testid===false) || $callback){
        
        foreach($list as $header => $value){
          if(!isset($_SERVER[$header]) || (($_SERVER[$header] !== false) && strtolower($_SERVER[$header]) !== strtolower($value))){
            $failed_headers[$header] = $_SERVER[$header] ?? false; 
          }
        }
  
        if(isset($failed_headers)){
          if($callback){
            $response = new stdClass();
            $response->status = 400;
            $response->message = 'invalid http headers';
            $response->log = $failed_headers;
            
            $callback($response, $failed_headers);
          }
          if(self::$testid===false){
            self::$response_error = true;
            self::$response_code = 400;
            self::$response_message = 'invalid http headers';
            self::$log = $failed_headers;
          }
        }
      }
    }

    return self::$API;

  }

  /**
   * Validation method to check for specified (i.e accepted) request methods in an ajax request.
   *
   * @param array|string $requests a list of valid request methods
   *  - Default response code when validation fails is 405
   * 
   * @param Closure|null $callback when defined closure will always be triggered after
   * check is done.
   * 
   * @return API
   */
  public static function accepts(array|string $requests, ?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      if((self::$testid===false) || $callback){
        $requests = (array) $requests;
      
        if(!in_array( self::request(),  $requests )) {
          if($callback){
            $response = new stdClass();
            $response->status = 405;
            $response->message = 'invalid request method';
            $response->log = [self::request()];
            $callback($response);
          }
          if(self::$testid===false){
            self::$response_error = true;
            self::$response_code = 405;
            self::$response_message = 'invalid request method';
            self::$log = ['REQUEST_METHOD'=>self::request()];
          }
        }
      }
    }

    return self::$API;

  }

  /**
   * Validation method to check for specified url query parameters in ajax url address
   *
   * @param array $params expected queries and their respective values.
   *  - When the value of an expected query is set as false, only the query itself is required while the value is never validated.
   *  - Default response code when validation fails is 405
   * 
   * @param Closure|null $callback when defined closure will always be triggered after
   * check is done.
   * 
   * @return API
   */
  public static function queries(array $params, ?Closure $callback = null) : API {
    if(!self::errorDebounce()){
      if((self::$testid===false) || $callback){
        $params = (array) $params;

        $queries = url(uri)->query();

        foreach($params as $param => $value){
          if(!isset($queries[$param])){
            $failed_queries[$param] = null;
          }elseif(($value !== false) && ($queries[$param] !== $value)) {
            $failed_queries[$param] = $param; 
          }
        }

        if(isset($failed_queries)){
          if($callback){
            $response = new stdClass();
            $response->status = 405;
            $response->message = 'unauthorized request';
            $response->log = $failed_queries;
            $callback($response);
          }
          if(self::$testid===false){
            self::$response_error = true;
            self::$response_code = 405;
            self::$response_message = 'unauthorized request';
            self::$log = $failed_queries;
          }
        }
      }
    }

    return self::$API;

  }

  /**
   * Validation method to check if specified data keys exist in received source request data
   *
   * @param array $source a source data list containing data keys and their respective values
   * @param array $data an array with relative keys and value pairs. These defined keys must exist in source data, else their 
   * relative string values will be triggered as error messages.
   * 
   * @return API
   */
  public static function misses(array $source, array $data = []) : API {
    
    if(!self::errorDebounce()){
      if(!self::$response_error){

        $keys = array_keys($data);
  
        foreach($keys as $key){
          if(!array_key_exists($key, $source)){
            self::$response_error = true;
            self::$response_code = 405; // invalid request
            if($data[$key] === true){
              self::$response_message = $key.' data key is required!';
            }else{
              self::$response_message = $data[$key];
            }
            break;
          }
        }

      }

    }

    return self::$API;

  }

  /**
   * Sets an executable shutdown function or saved error id when 
   * an api validation method fails 
   *
   * @param Closure|integer $push a shutdown function or code
   *  - shutdown function will be executed immediately
   *  - shutdown id will be saved and can be accessed by shutdown() method
   * @return API
   */
  public static function onfail(Closure|int $push) : API {
    
      if(self::$testid===false){
        if($push instanceof Closure){
          $response = new stdClass();
          $response->status = self::$response_code;
          $response->message = self::$response_message;
          $push($response);
        }else{
          self::$testid = $push;
        }
      }
    return self::$API;
  }

  /**
   * Applies a shutdown for api channels when validations fail.
   *
   * @param Closure $function
   * @return never
   */
  public static function shutdown(Closure $function){

    if(self::$response_error){
      
      $response = new stdClass();
      $response->status = self::$response_code;
      $response->message = self::$response_message;
      $response->id = self::$testid;
      
      $function($response, self::$log);
      $response = self::$response_info;
      $response = self::response($response);
      if(self::$view){
        print_r($response);
      }
      exit;
    }
  }
  
  /**
   * Determines the response returned by the API class
   *
   * @param array $response
   * @param integer|null $status
   * @param string|null $message
   * @return array|string 
   *  - Array is returned when the API class is not set as json
   *  - String is returned when API class is set as json 
   */
  public static function response($response, ?int $status = null, ?string $message = null) : array|string {
    $code = $status ?? $response['status'] ?? 500;
    $message = $message ?? $response['message'] ?? 'unknown response';

    if(self::$channel_type === 'json' && is_array($response)){
        $response = json_encode($response);
    }
    header("HTTP/1.1 $code $message");
    return ($response);
  }
  
  /**
   * Returns the response status code
   *
   * @return integer
   */
  public static function status() : int {
    return self::$response_code;
  }
  
  /**
   * Determines if content-type is json format
   *
   * @param boolean $isJSON 
   * @return API
   */
  public static function json(bool $isJSON = true) : API {
    self::$channel_type = ($isJSON)? 'json' : '';
    return self::$API;
  }
  
  /**
   * Returns response data and also determines the behaviour of API::shutdown() method
   *
   * @param array $response
   * @return array
   */
  public static function view(array $response = []) : array {
    if(!self::$spec){
      $data['status'] = self::$response_code;
      $data['message'] = self::$response_message;
    }else{
      self::$spec = false;
    }
    
    $data = $data ?? [];
    if(func_num_args() === 0) $response = self::$response_data;
    
    foreach($response as $key => $value){
      if(isset($data[strtolower($key)])){
        unset($data[strtolower($key)]);
      }
      $data[$key] = $value;
    }
    self::$view = true;
    return self::$response_info = self::$response_data = $data;
  }

  public static function spec() : API {
    self::$spec = true;
    return self::$API;
  }
  
  public static function setError(int $status = 500, ?string $msg = null, $view = []){
    self::$response_error = true;
    self::$response_code = $status;
    self::$response_message = (string) $msg;
    if(func_num_args() > 2){
      if(self::$testid !== false){
        $index = self::$testid; 
        if(isset($view[$index]) && ($view[$index] instanceof Closure)){
         $data = $view[$index]();
         self::$testid = false;
         if(is_array($data) && (count($data) > 1)){
           self::setError(...$data);
         }
        }
      }else{
        self::$response_data = $view;
      }
    }
  }

  public function failed(Closure $callback){
    if($this->error){
        $response = new stdClass();
        $response->status = self::$response_code;
        $response->message = self::$response_message;
        $response->id = self::$testid;
        $response->log = self::$log;
        $callback($response);
        exit;
    }
    return $this;
  }

  public function success(Closure $callback){
    if(!$this->error){
      $response = new stdClass();
      $response->status = 200;
      $response->message = 'success';
      $response->id = 0;
      $response->log = self::$log;
      $callback($response); 
    }
    return $this;
  }

  /**
   * Returns the request method
   *
   * @return string
   */
  public static function request(){
    return strtolower($_SERVER['REQUEST_METHOD']) ;
  }
  
 
}
