<?php 

namespace spoova\mi\core\classes;

use Window;

class Win extends Window {

  public function __construct(Window $window){}

  /**
   * Strips off a prefix path from a base path
   *
   * @param string $base full path whose prefix is to be stripped
   * @param string $prefix prefix path to be stripped
   * @return string If $prefix is not a prefix of $base, an empty string is returned
   */
  public static function subpath(string $base, string $prefix) : string {
    $base = window('base'); //get the current window base 
    $parent = substr($base, 0, strlen($prefix));
    $subpath = '';
    if(strtolower($prefix) === strtolower($parent)){
      $subpath = ltrim(substr($base, strlen($parent)), "/");
    }
    return $subpath;
  }

}