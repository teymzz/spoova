<?php

namespace spoova\mi\core\classes;

/**
 * This class handles route request
 */
class Request
{

  private $isValid = false;
  private $block = false;
  private $strict = false;
  private static ?Request $instance = null;

  /**
   * Request data option on {@see Request::input()} for any request method
   */
  public const any = 'ANY';

  /** 
   * Request data option on {@see Request::input()} for POST {@see Request::input()}
   */
  public const post = 'POST';

  /**
   * Request data option on {@see Request::input()} for GET {@see Request::input()}
   */
  public const get = 'GET';

  /**
   * Directs the data() method to apply authentication 
   * to data returned
   *
   * @var boolean
   */
  private $auth = true;

  /**
   * Contains data set only when authentication has been made
   *
   * @var array
   */
  private $data = [];
  
  
  /**
   * Initialize request class with enabled or disabled authentication
   */
  public function __construct(bool $auth = true)
  {
    $this->auth = $auth;
    self::$instance = $this;
  }
  
  public function getPath(){
    
    $path = $_SERVER['REQUEST_URI'];
    return $this->resolvePath($path); 

  }
  
  private function resolvePath(string $path){
    
    $uri = $path ?? '/'; 
    $uri = strtok($uri, '?');
    
    $search = '/'.preg_quote(fol, '/').'/';
    $newPath = preg_replace($search, '' , $path , 1) ;
    
    $pos = strpos($newPath, '?'); 
    if ($pos !== false) {
        return substr($newPath, 0, $pos);          
    }
    return $newPath; 
  }
  
  /**
   * Returns current server request method in lower case.
   *
   * @return string|false FALSE if no request method is found (e.g in CLI)
   */
  public static function method() : string|false {
    return strtolower($_SERVER['REQUEST_METHOD'] ?? false);
  }
  
  /**
   * Check if request method is the specified argument
   *
   * @return boolean
   */
  public static function isMethod(string $method) : bool {
    return (self::method() === $method);
  }
  
  /**
   * Check if request method is GET
   *
   * @return boolean
   */
  public static function isGet() : bool {
    return (self::method() === 'get');
  }
  
  /**
   * Check if request method is POST
   *
   * @return boolean
   */
  public static function isPost() : bool {
    return (self::method() === 'post');
  }
  
  /**
   * Check if request method is PUT
   *
   * @return boolean
   */
  public static function isPut() : bool {
    return (self::method() === 'put');
  }
  
  /**
   * Check if request method is DELETE
   *
   * @return boolean
   */
  public static function isDelete() : bool {
    return (self::method() === 'delete');
  }

  /**
   * Check if request method is PATCH
   *
   * @return boolean
   */
  public static function isPatch() : bool {
    return (self::method() === 'patch');
  }

  /**
   * Request the input data depending on the request method.
   *  - Note that POST and GET request data keys' values are validated with INPUT_GET or INPUT_POST
   *    unless $validate is set as false
   *  - Data is only returned for POST, GET or 'php://input'
   *
   * @param string $type optional [Request::any|Request::get|Request::post]
   * @param boolean $validate - determines the if request data values are validated for data keys of POST and GET requests.
   * @return array of request data depending on the request method and $validate argument supplied
   */
  public static function entries(string $type = Request::any, bool $validate = true) : array {
    $data = [];
    $type = \strtoupper($type);
    $method = \strtoupper(trim(($type === 'ANY')? self::method() : $type));

    if(($type === (self::post | self::get)) && !in_array($method,['POST', 'GET'])){
      return [];
    }
    if($method === 'POST'){
      foreach ($_POST as $key => $value){
        $data[$key] = ($validate)? filter_input(INPUT_POST, $key) : $value;
      }
    }elseif($method === 'GET'){
      foreach ($_GET as $key => $value){
        $data[$key] = ($validate)? filter_input(INPUT_GET, $key) : $value;
      }
    }elseif($method){
      $data = PHPInput(fn(array $data) => $data);
    }
    return $data;
  }

  /**
   * Request the input data depending on the request method.
   *  - Note that POST and GET invalid data keys are removed
   *
   * @param string $type optional [Request::any|Request::get|Request::post]
   * @return array of request data depending on the request method
   */
  public static function input(string $type = Request::any) : array {
    $data = [];
    $method = trim(($type === 'ANY')? self::method() : $type);
    if(($type === (self::post | self::get)) && !in_array($method,['post', 'get'])){
      return [];
    }
    if($method === 'post'){
      foreach ($_POST as $key => $value){
        if(filter_input(INPUT_POST, $key)){
          $data[$key] = $value;
        }
      }
    }elseif($method === 'get'){
      foreach ($_GET as $key => $value){
        if(filter_input(INPUT_GET, $key)){
          $data[$key] = $value;
        }
      }
    }elseif($method){
      $data = PHPInput(fn(array $data) => $data);
    }
    return $data;
  }

  /**
   * Return the CSRF_TOKEN data key's value retrieved from the request data
   *
   * @return string|false False is returned if no token is detected
   */
  public static function token(bool $valid = false) : string|false{

    $data['CSRF_TOKEN'] = '';
    $data = self::entries(validate: $valid);

    return $data['CSRF_TOKEN'] ?? false;

  }

  /**
   * Returns unauthenticated POST request data
   *
   * @param string|null $key an optional post key whose value is returned
   * @param boolean $validate
   * @return mixed 
   *  - NULL will be returned if the GET key supplied does not exist.
   */
  static function post(?string $key = null, bool $validate = false) : mixed {
    $post = $validate? Request::entries(Request::post) : $_POST;

    if($key !== null){
      return $post[$key] ?? null;
    }
    return $post ?? [];
  }

  /**
   * Returns unauthenticated GET request data
   *
   * @param string|null $key an optional get key whose value is returned
   * @param boolean $validate
   * @return mixed 
   *  - NULL will be returned if the GET key supplied does not exist.
   */
  static function get(?string $key = null, bool $validate = false) : mixed {
    $get = $validate? Request::entries(Request::get) : $_GET;

    if($key !== null){
      return $get[$key] ?? null;
    }
    return $get ?? [];
  }

  /**
   * Returns a URL's GET request query parameters and their corresponding values.
   *
   * @param boolean $strict 
   * @return array
   */
  static function query($strict = true) : array{
    $request = $_GET;

    return  $strict ? array_filter($request, fn($key)=> filter_input(INPUT_GET, $key), \ARRAY_FILTER_USE_KEY) : $request;
  }

  /**
   * Returns the current data of either GET, POST or custom request based on 
   * argument and authentication (i.e Request::auth()) type. When enabled, 
   * authentication is internally done using internally generated csrf token.
   * 
   *  - Note that by default {@see Request::auth()} is TRUE. To disable data authentication, first set auth() argument as false.
   * 
   * @param string $datakey An optional form datakey. If not supplied, 
   * data returned will always be an array which may be filled or empty  
   * based on authentication level and request data obtained,
   *   - If supplied and authentication fails empty string is returned
   *   - If supplied and authentication passes corresponding request data value is returned or false.
   *     Note that authentication can also pass if auth() method is set as false. By default it is set as 
   *     authentication is set as true.
   * 
   * @return mixed
   * 1. If auth() method is set as true and authentication fails, an empty string or array is returned depending on whether an argument (i.e $datakey) is supplied or NOT supplied respectively.
   * 2. If auth() method is set as false : 
   *    - If $datakey is supplied, the corresponding value is returned from request data if it exists else it returns false.
   *    - If $datakey is not supplied, the array of request data is returned.
   */
  public function data(string $datakey = ''){

    $args = func_num_args();

    $data = []; 

    if(self::isGet() || self::isPost()){
      if(self::isPost()){
        $request = $_POST;
        $filter = INPUT_POST; 
      }else{
        $request = $_GET;
        $filter = INPUT_GET;
      }
      if(!CSRF::isReferred()){
        foreach ($request as $key => $value){
            $data[$key] = filter_input($filter, $key);
        }
      }else{
        foreach ($request as $key => $value){
          $data[$key] = $value;
        }
      }
    }else{

      $data = PHPInput(fn(array $data) => $data);

    }

    $isValid = false;
    $csrf = $data['CSRF_TOKEN'] ?? '';
    //apply csrfToken when needed

    if($this->auth){
      $isValid = CSRF::auth($csrf);
      if(!$isValid) $data = [];
    }
    //return for data key
    if($args > 0) {
      if($this->auth){
        if(!$isValid) {
          $this->isValid = false;
          return $this->data = '';
        }
        $this->isValid = true;
      }
      return $this->data = $data[$datakey]?? false;
    }

    //
    if($this->auth){
      if(!$isValid) { 
        $this->isValid = false;
        return $this->data = [];
      }
      $this->isValid = true;
    }
    if($this->auth) return $data;
    return $this->data = $data; 
    
  }

  /**
   * Returns authenticated request data without affecting the state of the class
   *
   * @param boolean $strictCSRF determines if CSRF is set as strict
   * @return array
   */
  public static function authData(bool $strictCSRF = false)  : array {
    
    if(!self::$instance) {
      $instance = new static;
      $auth = $instance->getauth();
      $strict = $instance->getstrict();
    }else{
      $instance = self::$instance;
      $auth = $instance->getauth();
      $strict = $instance->getstrict();
      $instance->auth(true);
      if($strictCSRF) $instance->strict();
    }

    $data = $instance->data();

    //revert back to old settings;
    $instance->strict($strict);
    $instance->auth($auth);

    return $data;

  }

  /**
   * This method works similarly to data() method, However, 
   * csrf token authentication are never applied
   *
   * @param string $datakey when supplied, corresponding value of 
   * key supplied in request data is returned request data is 
   *   - If $datakey is supplied, the corresponding value is returned from request data if it exists else it returns false.
   *   - If $datakey is not supplied, an array of request data is returned.
   *
   * @return mixed data
   */
  public function prompt(string $datakey = '') {

    $auth = $this->auth;
    $this->auth = false;
    $data = $this->data(...func_get_args());
    $this->auth = $auth;

    return $data;

  }
  
  /**
   * Loads request data into Request class
   *
   * @param boolean $strict
   * @return Request
   */
  public function load(bool $strict = false) : Request {
    $strict = $strict ? [':strict'] : [];
    $this->data(...$strict);
    return $this;
  }
  
  /**
   * Check if current request data has a specific key
   * 
   * @param array|string|null $key request method's key name
   * @param string $method optional [get|post]
   * 
   * @return bool
   */
  public function has(array|string|null $key = null, string $method = '') : bool {

    $auth = $this->auth;
    $strict = $this->strict;
    $this->auth = false;
    $data = $this->data();

    if($auth && !isset($data['CSRF_TOKEN']) && $strict ){
      CSRF::setError('invalid');
      CSRF::block();
    }elseif(!isset($data['CSRF_TOKEN'])){
      CSRF::setError('invalid');
    }

    $this->auth = $auth;
    $method = strtolower($method);
    $methods = ['post', 'get'];
    if($method){
      if(!in_array($method, $methods)) return false;
      if(!$this->{'is'.$method}()) return false;
    } 

    if( empty($data) && CSRF::isReferred() && !CSRF::ref()->isValid) {
      CSRF::setError('invalid');
    }

    if(is_array($key)){
      foreach($key as $name){
        if(!array_key_exists($name, $data)){
          return false;
        }
      }
      return true;
    }

    return array_key_exists($key, $data);

  }

  /**
   * Determines if an authentication should be made when data
   * is being fetched using the data() method
   *
   * @param bool $auth allow or disallow authentication
   * @return Request
   */
  public function auth(bool $auth = true) : Request {
    $this->auth  = $auth;
    return $this;
  }

  /**
   * Returns the current value of property $auth
   *
   * @return bool
   */
  public function getauth() : bool {
    return $this->auth;
  }

  /**
   * Returns the current value of property $strict
   *
   * @return bool
   */
  public function getstrict() : bool {
    return $this->strict;
  }

  /**
   * Detemines the maximum time range in which a request form 
   * token is valid and form authenticated data can be returned 
   * if request forwarded is valid
   *
   * @param integer $seconds
   * @return void
   */
  public function expires(int $seconds = 60){
    $this->auth = true;
    CSRF::expires($seconds);
  }

  /**
   * Detemines if a request type is strict
   *
   * @param boolean $strict
   * @return Request
   */
  public function strict(bool $strict = true) : Request {
    $this->auth = true;
    $this->strict = $strict;
    CSRF::strict($strict);
    return $this;
  }
  
}