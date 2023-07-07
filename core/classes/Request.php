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
  }
  
  public function getPath(){
    
    $path = $_SERVER['REQUEST_URI'];
    return $this->resolvePath($path); 

  }
  
  private function resolvePath($path){
    
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
  
  //current server request method
  public function method(){
    return strtolower($_SERVER['REQUEST_METHOD']);
  }
  
  /**
   * Check if request method is get
   *
   * @return boolean
   */
  public function isGet(){
    return ($this->method() === 'get');
  }
  
  /**
   * Check if request method is post
   *
   * @return boolean
   */
  public function isPost(){
    return ($this->method() === 'post');
  }

  
  /**
   * Returns the current data of either get or post request based on 
   * argument and authentication (i.e Request::auth()) type. When enabled, 
   * authentication is internally done using internally generated csrf token.
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
   * 1. If Request::auth() is set as true and authentication fails, an empty string or array is returned depending on whether an argument (i.e $datakey) is supplied or NOT supplied respectively.
   * 2. If Request::auth() is set as false : 
   *    - If $datakey is supplied, the corresponding value is returned from request data if it exists else it returns false.
   *    - If $datakey is not supplied, the array of request data is returned.
   */
  public function data(string $datakey = ''){

    $args = func_num_args();

    $data = []; 

    if($this->isGet()){

      if(!Csrf::isReferred()){

        foreach ($_GET as $key => $value){
            $data[$key] = filter_input(INPUT_GET, $key);
        }

      }else{
        foreach ($_GET as $key => $value){
            $data[$key] = $value;
        }        
      }
    }

    if($this->isPost()){
      if(!Csrf::isReferred()){

        foreach ($_POST as $key => $value){
            $data[$key] = filter_input(INPUT_POST, $key);
        }

      }else{
        foreach ($_POST as $key => $value){
            $data[$key] = $value;
        }        
      }
      
    }

    $csrf = $data['CSRF_TOKEN'] ?? '';
    //apply csrfToken when needed

    if($this->auth){ 
      $isValid = Csrf::auth($csrf);
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
   * This method works similarly to data() method, However, 
   * returns csrf token authentication are never applied
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
   * @param array|string $key request method's key name
   * @param string $method optional [get|post]
   */
  public function has(array|string $key = null, string $method = '') {

    $auth = $this->auth;
    $strict = $this->strict;
    $this->auth = false;
    $data = $this->data();

    if($auth && !isset($data['CSRF_TOKEN']) && $strict ){
      Csrf::setError('invalid');
      Csrf::block();
    }elseif(!isset($data['CSRF_TOKEN'])){
      Csrf::setError('invalid');
    }

    $this->auth = $auth;
    $method = strtolower($method);
    $methods = ['post', 'get'];
    if($method){
      if(!in_array($method, $methods)) return false;
      if(!$this->{'is'.$method}()) return false;
    } 

    if( empty($data) && Csrf::isReferred() && !Csrf::ref()->isValid) {
      Csrf::setError('invalid');
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
   * Detemines the maximum time range in which a request form 
   * token is valid and form authenticated data can be returned 
   * if request forwarded is valid
   *
   * @param integer $seconds
   * @return void
   */
  public function expires(int $seconds = 60){
    $this->auth = true;
    Csrf::expires($seconds);
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
    Csrf::strict($strict);
    return $this;
  }
  
}