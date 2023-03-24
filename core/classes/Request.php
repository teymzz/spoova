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
   * 
   */
  public function __construct()
  {
    // code...
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
   * Return the current data of either get or post request
   *  - When a key is supplied, returns the key value from 
   *    the current request data if it exists else returns a bool of false
   *  - when session csrf does not match returns false
   * @return mixed
   */
  public function data($datakey = true){

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
   * @param $name request method's key name
   * @param string $method optional [get|post]
   */
  public function has(string $name = null, string $method = '') {

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

    return array_key_exists($name, $data);

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