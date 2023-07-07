<?php

namespace spoova\mi\windows\Routes;

use Window;

class Index extends Window{

  function __construct(){
    

    self::call($this, [

      window(':') => 'root' //call index page
      
    ]); 

  }

  function root(){

      self::load('index', fn() => compile(['Title' => 'Spoova']) );    

  }

}