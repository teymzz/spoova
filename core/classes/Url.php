<?php

namespace spoova\mi\core\classes;

use Closure;

class Url{
  
  private $url;
  private $urlmod;
  
  /**
   * Sets a path for testing
   *
   * @param string $url path to be tested
   * @return Url
   */
  function path(string $url = '') {
    $this->url = ltrim(str_replace('\\', '/', $url), "/");
    return $this;
  }
  
  /**
   * Returns all paths serially into array format
   *
   * @param string $url optional url
   *  - If not defined, assumes default url 
   * @return array list of path names in defined order
   */
  function pathlist(string $url = '') : array {
    $url = (func_num_args() > 0)? $url : $this->url;
    $url = explode('/', $url);
    return $url ?: [];
  }
  
  /**
   * Modify specified path
   * @param Closure $callback a callback function to be applied for specified divisional indices of a path.
   * @param array|int|null $position positional index or indices to be modified 
   *  - Note $position when defined can should be greater than or less than zero. However, if not specified, all divisional indices will be affected
   * @return string
   */
  function pathmod(Closure $callback, array|int|null $position = null) : string {
    
    $paths = $this->pathlist();
    
    if(func_num_args() < 2) {

      //apply callback for all paths
      $paths = array_map(fn($value) => $callback($value), $paths);

    }elseif(is_array($position)){

      foreach($position as $posit) {

        if($posit < 0) {
          $index = abs($posit + 1);
          $arrReverse = array_reverse($paths);

          if(isset($arrReverse[$index])){
            $arrReverse[$index] =  $callback($arrReverse[$index], $posit);
          }

          $paths = array_reverse($arrReverse);
        } elseif($posit > 0) {
          $index = $posit - 1;          
          
          if(isset($paths[$index])){
            $paths[$index] =  $callback($paths[$index], $posit);
          }
        }

      }
    } else {

      if($position < 0) {
          $index = abs($position + 1);
          $arrReverse = array_reverse($paths);

          if(isset($arrReverse[$index])) {
            $arrReverse[$index] = $callback($arrReverse[$index],$position);
          }

          $paths = array_reverse($arrReverse);
      } elseif($position > 0) {
          $index = $position - 1;          
          
          if(isset($paths[$index])) {
            $paths[$index] = $callback($paths[$index],$position);
          }
        }

    }

    return implode('/', $paths);
  }
  
  /**
   * matches urls that matches base (supplied) path structure
   * 
   * @param string $basepath base url structure on which supplied defined path is tested
   * @param bool $strict false lowers the testing level (case insensitive)
   *  - Ex1: For a path abc/def/ghi, a basepath of abc, abc/def, abc/def/ghi will return true.
   *  - Ex2: For a path abc/def/ghi, a basepath of abc/def/ghi/xyz will return false.
   *  - Note: This returns true if the base path or full path (structure) of a url defined matches $basepath supplied
   * @return bool
   */    
  function isLike(string $basepath = '', bool $strict = true) : bool {
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
   * Returns the hash value of a url string having hash within it
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
    $url = parse_url($url,PHP_URL_QUERY) ?: '';
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
    $newurl = self::strip_questionmark($newurl);    
    return rtrim($newurl, '/ ');
  }

  function last(int $level = 1, int $ignore = 0) : string {

    if($level === 1 && $ignore === 0) return self::strip_questionmark(basename($this->url));
    $path = rtrim(self::strip_questionmark($this->url));
    $paths = array_reverse(explode('/',$path));
    $pathsCount = count($paths);

    if($pathsCount < $level) return $path;
    $count = 0; $ignored = 0; $newurl = [];
    foreach($paths as $pth){
      if($ignored < $ignore) {
        $ignored++;
        continue;
      }
      if($count >= $level) break;
      $newurl[] = $pth;
      $count++;
    }    
    return implode('/',array_reverse($newurl));
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
   *  - Paths with prefixes [root:|base:|path:] applies the {@see window()} helper function while other values are treated as normal url path structure
   * @param string $index refers to the starting index relative to a path's positional index.
   * @return string
   */
  function pathFrom($baseUrl, ?int $index = null) : string {

    $acceptedDirectives = [':', 'base:', 'root:', 'path:'];

    if(substr($baseUrl, 0, 1) === ':' || in_array(substr($baseUrl, 0, 5), $acceptedDirectives)) {
      $baseUrl = window($baseUrl);
    }

    $url = $this->url;
    if(!$url){
      EInfo::view('No valid url detected! Try using Url->path() to load url first');
      return false;
    }

    if(!$index){
      $exp = $baseUrl? explode($baseUrl, $url, 2)[1] ?? '' : $url;
      return ltrim($exp, '/');
    }else{
      $exp = explode($baseUrl, $url); $j = 0;
      for($i = $index; $i < count($exp); $i++){
        $prefix = ($j === 0) ? '' : $baseUrl.'/';
        $paths[] = $prefix.ltrim(rtrim($exp[$i], ' /'),' /');
        $j++;
      }
      if(isset($paths))return implode('/',$paths);
      return '';
    }

  }

  private static function strip_questionmark(string $value) : string {
    return preg_replace('/\?.*/','', $value);
    // return  rtrim($value, ' ?'); //substr($value, -1) === '?'? substr($value, 0, strlen($value) -1) : $value;
  }
  
}