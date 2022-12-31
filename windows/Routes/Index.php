<?php

namespace spoova\windows\Routes;

use Window;

class Index extends Window{

  function __construct(){

    //load index page
    self::call($this, [

      window(':') => 'root',
      
    ]); 

  }

  function root(){

      self::load('index', fn() => compile(['Title' => 'Spoova']) );    

  }

  public static function addRoutes(array $array = []) : array {

    return [
     'about' => DomUrl('about')
    ];

  }

}

