<?php

namespace spoova\mi\core\classes;

/**
 * Res controller class for static files
 * This class is used to load css, javascripts, xml, html files
 */
class Ress{
  
  private static $res;
  
  function __construct(\Res $res){
     
    self::$res = $res;
    
  }

  function name($name){
    
    self::$res = \Res::name($name);
    return $this;
    
  }

  function __call($method, $args){
     
     self::$res->$method(...$args);
    
     return $this; 
     
  } 

} 