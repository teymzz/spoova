<?php

namespace spoova\mi\core\classes\Bundle\API;

use Closure;
use Exception;
use stdClass;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Bundle\API\APITest\APIAccepts;
use spoova\mi\core\classes\Bundle\API\APITest\APIData;
use spoova\mi\core\classes\Bundle\API\APITest\APIHeaders;
use spoova\mi\core\classes\Bundle\API\APITest\APIQueries;
use spoova\mi\core\classes\Bundle\API\APITest\APIReferer;
use spoova\mi\core\classes\Bundle\API\APITest\APIXMLHttpRequest;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\Request;

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 * 
 * The API class enables a customized structure for building ajax responses with extra validation methods 
 * supported through the {@see spoova\mi\core\classes\Ghost\GhostProxy} anonymous object injection.
 *
 */
class API {

  public const NONE = '';

  /**
   * Configures ajax response data format for Windows API integration
   * channel() method is called. 
   *  - Deines valid conditions :
   *   - An XMLHttpRequest header is required on the API channel (i.e API route)
   *   - A referer url is required on the API before a channel is open to display data 
   */
  public const AJAX = 'ajax';

  /**
   * Configures ajax:json response data format for Windows API integration.
   *  - Applies 'application/json' header content-type.
   *  - Defines valid conditions :
   *    - XMLHttpRequest header is required. (Error code : 400)
   *    - Referer url is required. (Error code : 403).
   */
  public const AJOX = 'ajax:json';


  
  /**
   * Configures response data format to return as JSON string 
   *  - Applies 'application/json' header content-type.
   */
  public const JSON = 'json';

  /**
   * Configures response data format to return as JSON string and sets environment content-type as 
   * 'application/json' unless {@see API::noheader()} is applied before {@see API::channel()} method is called.
   * - Default Behaviour :
   *   - Applies 'application/json' header content-type except .
   *   - 
   */
  public const JSOX = 'jsox';
 
  /**
   * Define common request methods
   */
  public const REQUEST_METHODS = [
    'post', 'get', 'put', 'delete','head',
    'patch', 'options', 'copy', 'link', 'unlink',
    'purge', 'lock', 'unlock', 'propfind', 'view'
  ];
  
  private static bool $new_state = false;
  /** @var string optional json */
  private static string $channel_type= '';
  
  /** @var string sets a default content type */
  private static string $content_type= '';
  private static bool $debounce = false;
  /**
   * Determines controllers behaviour 
   *  - FALSE specifies a default state that allows the use of {@see API::fail()}
   *  - INT flags on the use of {@see API::fail()}
   *  - TRUE flags on the use of {@see spoova\mi\core\classes\Bundle\API\APITest} helper class
   *
   * @var integer|boolean
   */
  protected static int|bool $testid = false;
  protected static int $response_code = 500;
  protected static string $response_message = '';
  protected static bool $response_error = false;
  private static bool $onfail = false;
  private static bool $is_data = false;
  private static array $queries = [];
  private static array $response_data = [];
  private static array|string $response_info = [];
  private static array $log = [];
  private static bool $noheader = false;

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

  use APIXMLHttpRequest;
  use APIReferer;
  use APIQueries;
  use APIData;
  use APIAccepts;
  use APIHeaders;

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
   * Returns or defines a default name for the header content type of an API channel
   *  - This does not set header('content-type') by default.
   * @param string|null $content_type
   * @return string
   */
  public static function scope(?string $content_type = null): string {
    if($content_type !== null) self::$content_type = strtolower($content_type);
    return self::$content_type;
  }

  /**
   * Checks the header content type of API channel
   *
   * @param string|null $content_type
   * @return boolean
   */
  public static function is(?string $content_type = null){
    return self::$content_type === strtolower($content_type);
  }

  /**
   * This method is used for performing basic validation for an api.
   *
   * @param string $type optional [API::NONE|API::JSON|API::JSOX] is used to determine the content-type and response format returned by the API class.
   *  - ```API::NONE``` Returns array response data format.
   *  - ```API::JSON``` Returns response data format as JSON string
   *  - ```API::JSOX``` Returns response data format as JSON string and sets header content-type as JSON provided API::noheaders() is not applied earlier.
   * @param Closure|null $test closure takes {@see spoova\mi\core\classes\Bundle\API\API} instance : function(API $api): void
   * 
   * @return API
   */
  public static function channel(string $type = API::NONE, ?Closure $test = null) : API {
    $type = strtolower($type);
    self::$channel_type = $type;

    if(in_array($type, ['json','jsox'])) {
      self::scope('application/json'); // sets data return format type application/json
      if(!self::noheader() && $type === 'jsox') header('content-type: application/json');
    }

    self::resetProperties(); // refresh all previously stored values if any. 

    if(self::$new_state){
      self::$new_state = false;
      $API = self::$API;
    }else{
      $API = self::$API = new static();
    }    
    self::$channel_type = $type;
    if($test) $test($API);
    return $API;
  }
  
 
  /**
   * Enables error debouncing which prevents further validations 
   * after a first error is triggered by any of the validation methods. 
   *
   * @param boolean $debounce
   * @return API
   */
  public static function debounce(bool $debounce = true) : API {
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

  // API Validation Methods -------------------------------------------------------------

  /**
   * Sets an executable shutdown function or saved error id when 
   * an api validation method fails 
   *
   * @param Closure|integer $push a shutdown function or unique id.
   *  - The function(APIStatus $status) closure argument takes {@see spoova\mi\core\classes\Bundle\API\APIStatus} instance
   *  - shutdown closure function will be executed immediately
   *  - shutdown id will be saved and can be accessed by shutdown() method
   * @return API
   */
  public static function onfail(Closure|int $push) : API {
    
    if(self::$testid===false && self::$response_error && !self::$onfail){
      self::$onfail = true;
      if($push instanceof Closure){
        $push(self::make_status(self::$response_code, self::$response_message, self::$testid, self::$log));
      }else{
        self::$testid = $push;
      }
    }
    return self::$API;
  }

  /**
   * Applies a shutdown for api channels when validations fail.
   *
   * @param Closure $function a closure function that takes {@see spoova\mi\core\classes\Bundle\API\APIResponse} instance and log array: function(APIResponse $response, array $log): void
   * @return never
   */
  public static function shutdown(Closure $function){
    if(self::$response_error){

      $Ghost = self::make_ghost(['status','message','id','failed','data','view','catalog']);

      $data = false; $view = false;
      $response_code = self::$response_code;
      $response_msg = self::$response_message;
      $response_id = self::$testid;
      $log = self::$log;
      $Ghost->status(fn() =>  $response_code );
      $Ghost->message(fn() => $response_msg);
      $Ghost->id(function($id = null) use($response_id): bool|int{ 
        if($id !== null){
          return $response_id === $id;
        }
        return $response_id;
      });
      $Ghost->failed(function(?string $type = null) use($log) : array {
        $map = ['methods'=>'accepts', 'isXMLHttpRequest'=>'XMLHttpRequest'];
        $type = $map[$type] ?? $type;
        return ($type === null)? array_keys($log) : ($log[$type] ?? []);
      });

      $Ghost->data(function(bool $extras = false) use(&$data){
        $response = self::$response_data;
        if($extras) $response = self::responseData($response);
        self::$is_data = true;
        $response = self::response($response); // convert response format
        self::$is_data = false;
        $data = true;
        return $response;
      });
      
      $Ghost->view(function($response = []) use(&$data){
        if(func_num_args() === 0) $response = self::$response_data;
        $response = self::responseData($response, self::$spec);
        $response = self::response($response);
        $data = true;
        return $response;
      });

      $Ghost->catalog(function($key = ''){
        if(func_num_args() === 0) return self::$log;
        if(isset(self::$log[$key])){
          if(in_array(self::$channel_type, ['json','jsox'])){
            return json_encode(self::$log[$key]);
          }else{
            return self::$log[$key];
          }
        }
        return false;
      });

      GhostProxy::new($Ghost, fn(GhostDraft $draft) => 
          
          /* access predefined API Response methods */
          new class($draft) extends APIResponse {}

      );
      
      $function(GhostProxy::object(), self::$log);

      if(self::$view && !$data){
        // Display for API::view()
        $response = self::$response_info;
        $response = self::response($response);
        print_r($response);
      }
      exit;
    }
  }
  
  /**
   * Determines the response returned by the API class
   *  - Applies response {@see \header()} function except {@see spoova\mi\core\classes\Bundle\API\API::noheader()} is applied. 
   *  - Note that none of the arguments supplied modifies or affects the value already cached in storage only the data returned is modified.
   * 
   * @param array $response defines the http response data from which response status code and message are automatically retrieved
   * @param integer|null $status code supplied defines the {@see http_response_code()}
   * @param string|null $message defines the http response message
   * @return array|string 
   *  - JSON string is returned if API channel is set as 'JSON' else Array is returned by default. 
   */
  public static function response($response, ?int $status = null, ?string $message = null) : array|string {
    $code = $status ?? $response['status'] ?? self::$response_code ?? 500;
    $message = $message ?? $response['message'] ?? 'unknown response';

    if(!self::$is_data){
      if(in_array(strtolower(self::$channel_type), ['json','jsox']) && is_array($response)){
          $response = json_encode($response);
      }
    }
    
    if(!self::$noheader) header("HTTP/1.1 $code $message");
    return ($response);
  }

  /**
   * Determines if {@see spoova\mi\core\classes\Bundle\API\API::response()} can modify response header and 
   * also returns the response header's configuration state as TRUE or FALSE
   *
   * @param boolean|null $state TRUE
   * @return boolean $state if argument is defined else returns the last configuration state.
   */
  public static function noheader(?bool $state = null) : bool {
    if($state !== null) self::$noheader = $state;
    return self::$noheader;
  }
  
  /**
   * Returns the response status code
   * 
   *  This will override default code if supplied
   * @return int
   */
  public static function status() : int {
    return self::$response_code;
  }
  
  /**
   * Returns the response status message
   *
   * @return string
   */
  public static function message() : string {
    return self::$response_message;
  }
  
  /**
   * Determines if content-type is json format
   *  - Does not directly apply {@see \header()} function.
   * @param boolean|int $isJSON optional 
   *  FALSE, 0 or invalid option sets the type to API::NONE
   *  TRUE or 1 sets the type to API::JSON
   *  Integer 2 sets the type to API::JSOX
   * @return API
   */
  public static function json(bool|int $isJSON = true) : API {
    $map = [0=>API::NONE, 1=>API::JSON, 2=>API::JSOX];
    self::$channel_type = $map[$isJSON] ?? API::NONE;
    return self::$API;
  }
  
  /**
   * Returns response data and also determines the behaviour of API::shutdown() method
   *  - When custom response data is supplied as argument, this modifies the previous response data.
   * @param array $response
   * @return array returns array data
   */
  public static function view(array $response = []) : array {
    if(func_num_args() === 0) $response = self::$response_data;
    $data = self::responseData($response, self::$spec);
    self::$spec = false;
    self::$view = true;
    return self::$response_info = self::$response_data = $data;
  }

  /**
   * Updates the response data supplied with the previous detected response code and message if they do not exist in response data supplied 
   * and new data flag is not applied.
   *
   * @param array $response response data to be updated if it does not already contain the 'status' and 'message' response data keys.
   * @param boolean $new TRUE prevents the use of existing response data status and message values.
   * @return array
   */
  private static function responseData(array $response = [], bool $new = false) : array{
    $data = [];
    if(!$new){
      $data['status'] = self::$response_code;
      $data['message'] = self::$response_message;
    }
    foreach($response as $key => $value){
      if(isset($data[strtolower($key)])){
        unset($data[strtolower($key)]);
      }
      $data[$key] = $value; // set or update $data keys
    }
    self::$response_code = $data['status'] ?? self::$response_code;
    self::$response_message = $data['message'] ?? self::$response_message;
    self::$response_data = $data;
    return $data;
  }

  /**
   * Enables the creation of new custom messages
   * 
   * @param APIResponse $response if supplied, this method will return the 
   * APIResponse object instance supplied.
   *
   * @return API|APIResponse
   *  - API : default response when $response is null or not defined
   *  - APIResponse : default response when $response is NOT null
   */
  public static function spec(?APIResponse $response = null) : API|APIResponse {
    self::$spec = true;
    return $response? $response : self::$API;
  }
  
  /**
   * Sets the error response message
   *
   * @param integer $status
   * @param string|null $msg
   * @param array $view contains a response data
   * @return void
   */
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

  /**
   * Triggers a failed callback function if previous error is found.
   *
   * @param Closure $callback receives (APIStatus $APIStatus) object
   *  - The APIStatus object is an instance of the {@see spoova\mi\core\classes\Bundle\API\APIStatus} class.
   *  - The APIStatus object contains methods to retrieve the response status code, message, id and log data. 
   *    - status(): retrieves the status code
   *    - message(): retrieves the status message
   *    - id(): retrieves the test id
   *    - log(): retrieves the logged data as an array
   * @return API may terminate further operations if previous error is detected. 
   */
  public function failed(Closure $callback) {
    if(self::$response_error){
        $callback(self::make_status(self::$response_code, self::$response_message, self::$testid, self::$log));
        exit;
    }
    return self::API();
  }

  /**
   * Triggers a success callback function if no previous error is found.
   *
   * @param Closure $callback 
   * @return API
   */
  public function success(Closure $callback) : API {
    if(!self::$response_error){
      $callback(self::make_status(200, 'success', 0, self::$log)); 
    }
    return self::API();
  }

  /**
   * Returns the request method
   *
   * @return string|false
   */
  public static function request() : string|false {
    return Request::method();
  }

  /**
   * Create a APIStaus object from a response data.
   *
   * @param int $status
   * @param string $message
   * @param int $id
   * @param array $log
   * @return APIStatus
   */
  private static function make_status($status, $message, $id, $log) : APIStatus {
    
    $data = compact('status','message','id','log');

    GhostProxy::new($data, fn(GhostDraft $draft) => 

      new class($draft) extends APIStatus {

        public function status() : int {
          return $this->getProxy('status');
        }
        public function message() : string {
          return $this->getProxy('message');
        }
        public function id() : int {
          return $this->getProxy('id');
        }
        public function log() : array {
          return $this->getProxy('log');
        }

      }

    );
    
    return GhostProxy::object();
  }
  
  /**
   * make ghost controller for this class
   *
   * @param string[] $data
   * @return GhostFunction instance of GhostFunction class with reserved custom helper methods
   *  - reserved methods: debounce, set, get
   */
  private static function make_ghost(array $data) : GhostFunction {
    $defaults = ['debounce','set','get'];
    $data = array_merge($defaults, $data);
    $Ghost = new GhostFunction($data);
    $Ghost->debounce(function(){
      return self::errorDebounce();
    });
    $Ghost->set(function($prop, $value){
      API::$$prop = $value;
    });
    $Ghost->get(function($prop){
      return API::$$prop;
    });

    return $Ghost;
  }

  // APIValidation Trait methods ........................................

  private static function setProp(string $name, mixed $value){
    self::$$name = $value;
  }
  private static function getProp(string $name){
    return self::$$name;
  }
  private static function getLog(string $key) : array{
    return self::$log[$key] ?? [];
  }

  public static function setLog(string $name, string $key, mixed $value){
    $log = self::$log;
    $log[$name][$key] = $value;
    self::$log = $log; // update log  
  }

  private static function API() : API {
    return self::$API;
  }
 
}
