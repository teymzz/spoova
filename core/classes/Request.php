<?php

namespace spoova\core\classes;

/**
 * @package spoova\core\classes
 */
class Request
{
  
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
  
  public function isGet(){
    return ($this->method() === 'get');
  }
  
  public function isPost(){
    return ($this->method() === 'post');
  }
  
  public function isRequest(){
    return ($this->method() === 'request');
  }
  
  
  
  public function data(){

    $data = []; 
    if($this->isGet()){
      foreach ($_GET as $key => $value){ 
        $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    if($this->isPost()){
      foreach ($_POST as $key => $value){
        $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }    
    
    return $data; 
    
  }
  
  /**
   * @param string $name request $key
   */
  public function has(string $name = null, $method = '') {
    $data = $this->data();
    $methods = ['post', 'get'];
    if($method){
      if(!in_array($method, $methods)) return false;
      if(!$this->{'is'.$method}()) return false;
    }
    return array_key_exists($name, $data);
  }
  
}