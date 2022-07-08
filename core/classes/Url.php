<?php

  namespace spoova\core\classes;
  
  class Url{
    
   private $url;
   
    function path($url = '') {
      $this->url = $url;
      return $this;
    }
   
   /**
    * matches urls that follows a single base path
    * 
    * @param $path root url name
    */
    function follows($path = '') : bool {
     // index follows index => true 
     // index/profile follows index => true
     // index/profile follows profile => false 
     $url  = explode('/', trim($this->url, '/ '))[0] ?? ''; //url address
     $path = explode('/', trim($path, '/ '))[0] ?? '';

     return ($url == $path);
    }
    
   /**
    * matches urls that matches base url structure
    * 
    * @param $path base url structure
    */    
    function isLike($path = '') : bool {
      // index/profile is like profile => false 
      // index/profile is like index => true
      // index/profile is like index/profile => true 
      // index/profile/user is like index/profile => true 
     $url  = trim($this->url, '/ '); //url address
     $path = trim($path, '/ ');
     $root = explode($path, $url)[0]?? '';      
     
     return ($url == $root);
    }
    
    
    /**
     * Return true if exact url supplied is matched    
     * 
     * @param string $path      
     */
    function is(string $path = '') : bool {

     $url  = strtolower($this->url);
     $path = strtolower($url);
     return $url === $path;         
     
    }

    /**
     * Return true if exact url supplied exists in or is equal to test url ($path) 
     * 
     * @param array|string $path
     * 
     * @return bool         
     */
    function in($path = '') : bool {

     $url  = strtolower($this->url);
     $paths = (array) $path;

     $paths = array_map('strtolower', $paths);
     return (in_array($url, $paths));         
     
    }
    
    function hash() : string {
      
      $url = $this->url;
      $urlExp = explode('#', $url);
      return $urlExp[1]?? '';
      
    }
    
    function query(): array {
      $url = $this->url;
      $url = parse_url($url,PHP_URL_QUERY);
      parse_str($url, $params);
      return $params;
    }
    
    
  }