<?php

namespace spoova\mi\core\classes;

use Res;

/**
 * Res controller class for static files
 * This class is used to load css, javascripts, xml, html files
 * 
 * @method Resource url()
 */
class Ress{
  
  private static $res;
  
  function __construct(Res $res){
     
    self::$res = $res;
    
  }

  /**
   * Defines a new name for resource group
   *
   * @param string $name
   * @return Ress
   */
  function name($name){
    
    self::$res = Res::name($name);
    return $this;
    
  }

  function __call($method, $args){
     
     self::$res->$method(...$args);
    
     return $this; 
     
  } 

} 