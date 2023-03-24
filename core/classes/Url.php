<?php

  namespace spoova\mi\core\classes;
  
  class Url{
    
   private $url;
    
   /**
    * Sets a path for testing
    *
    * @param string $url path to be tested
    * @return \spoova\mi\core\classes\Url
    */
    function path($url = '') {
      $this->url = $url;
      return $this;
    }
   
    // /**
    //  * matches urls that follows a single base path
    //  * 
    //  * @param string $rootpath root url name (must be a single base name)
    //  * @param bool $strict false lowers the testing level (case insensitive)
    //  * 
    //  * @return bool
    //  */
    // function follows($rootpath = '', bool $strict = true) : bool {
    //  // index follows index => true 
    //  // index/profile follows index => true
    //  // index/profile follows profile => false 
    //  $url = $this->url;
    //  if(!$strict) {
    //   $url = strtolower($url);
    //   $rootpath = strtolower($rootpath);
    //  }
    //  $url  = explode( '/', trim($url, '/ ') )[0] ?? ''; //url address
    //  $path = explode( '/', trim($rootpath, '/ ') )[0] ?? '';

    //  return ($url == $path);
    // }
    
    /**
     * matches urls that matches base (supplied) path structure
     * 
     * @param $basepath base url structure on which supplied defined path is tested
     * @param bool $strict false lowers the testing level (case insensitive)
     *  - Ex1: For a path abc/def/ghi, a basepath of abc, abc/def, abc/def/ghi will return true.
     *  - Ex2: For a path abc/def/ghi, a basepath of abc/def/ghi/xyz will return false.
     *  - Note: This returns true if the base path or full path (structure) of a url defined matches $basepath supplied
     * @return bool
     */    
    function isLike($basepath = '', bool $strict = true) : bool {
     $testpath = $this->url; //url address 
     $basepath = $basepath; //url address 
     if(!$strict) {
      $testpath = strtolower($testpath);
      $basepath = strtolower($basepath);
     }
     $baselen = strlen($basepath);
     $pathlen = strlen($testpath);

     return (substr($testpath, 0, $baselen) == $basepath);

    }
    
    
    /**
     * Return true if exact url supplied is matched    
     * 
     * @param string $path   
     * @param bool $strict false lowers the testing level (case insensitive)
     * 
     */
    function is(string $path = '', bool $strict = true) : bool {

     $url  = $this->url;
     $path = $url;
     if(!$strict) {
      $url = strtolower($url);
      $path = strtolower($path);
     }
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
    
    /**
     *Returns the hash value of a url string having hash within it
     *
     * @return string
     */
    function hash() : string {
      
      $url = $this->url;
      $urlExp = explode('#', $url);
      return $urlExp[1]?? '';
      
    }
    
    /**
     * Returns the query parameters of a url as key and value pairs
     *
     * @return array
     */
    function query(): array {
      $url = $this->url;
      $url = parse_url($url,PHP_URL_QUERY);
      parse_str($url, $params);
      return $params;
    }

    /**
     * splits a supplied path and returns the path name of an index supplied
     *
     * @param integer $index from 0 above
     * @return string
     */
    function position(int $index) : string {

      if($index < 1) return '';

      $index -= 1;

      $url = $this->url;
      $splitUrls = explode('/', $url)?? [];

      return $splitUrls[$index] ?? '';

    }

    /**
     * Returns the uppermost path(s) based on the number of paths needed from a supplied path 
     * 
     * @param int $level number of paths to be returned.
     * @param int $ignore number of uppermost (left) paths to be ignored
     * 
     * @return string
     */
    function first(int $level = 1, int $ignore = 0) : string {

      if($level < 1) return '';

      $level -= 1;

      $url = $this->url;
      $splitUrls = explode('/', $url)?? [];
      $newurl = '';
      
      $count = 0; $ignored = 0;
      foreach($splitUrls as $splitUrl){
        if($ignored < $ignore) {
          $ignored++;
          continue;
        }
        if($count > $level) break;
        $newurl .= $splitUrl.'/';
        $count++;
      }

      return rtrim($newurl, '/ ');

    }

    /**
     * Returns a url path while ignoring the first levels defined
     * 
     * @param int $ignore number of uppermost (left) paths to be ignored
     * 
     * @return string
     */
    function ignore(int $ignore = 0) : string {

      $url = $this->url;
      $splitUrls = explode('/', $url)?? [];
      $newurl = '';
      
      $count = 0; $ignored = 0;
      
      foreach($splitUrls as $splitUrl){
        if($ignored < $ignore) {
          $ignored++;
          continue;
        }

        $newurl .= $splitUrl.'/';
        $count++;
      }

      return rtrim($newurl, '/ ');

    }

    /**
     * Get the path from a particular string
     *
     * @param string $baseUrl
     * @return string
     */
    function pathFrom($baseUrl){

      if(func_num_args() < 2){
        //$baseUrl = window('base');
      }

      $acceptedDirectives = [':', 'base:', 'root:', 'path:'];

      if(substr($baseUrl, 0, 1) === ':' || in_array(substr($baseUrl, 0, 5), $acceptedDirectives)) {
        $baseUrl = window($baseUrl);
      }

      $url = $this->url;

      return ltrim(explode($baseUrl, $url, 2)[1] ?? '', '/');

    }
    
    
  }