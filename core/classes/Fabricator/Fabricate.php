<?php

namespace spoova\mi\core\classes\Fabricator;

class Fabricate{
  
  public static function fabricate(){
    
  }
  
  public static function text($length){
    
  }
  
  public static function names($length){
    
  }
  
  public static function integer($length){
    
  }
  
  public static function date($length){
    
  }
  
  public static function time($length){
    
  }
  
  public static function year($length){
    
  }
  
  public static function month($type, $range) {
    
  }
  
  public static function json($length){
    
  }
  
  /**
   * Fabricate url
   * 
   * @return float|int|string
   */
  public static function url($length) {
    // protocol => http, https, any 
    // www => www. 
    // text => foo, bar, baz
    // id => com, org, net, ng, ai, fx, mobi, edu, us, cu, tv, media, web, cab
  }
  
  public static function token($length){
    
  }
  
  /**
   * Fabricate option from options supplied
   * 
   * @return float|int|string
   */
  public static function options(array $options) : float|int|string {
    return $options[array_rand($options)];
  }
  
  public static function fromType($type){
    
  }
  
  public static function fromOptions($number, $separator = ','){
    
  }
  
  
}