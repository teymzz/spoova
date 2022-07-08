<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Plugins extends UserFrame {

    function __construct($value){

      if($value){
        self::close(); //accept no sub url       
      }
        
    }

    function index(){
      $pointer = self::mapurl('Tutorial/Plugins', ' <span class="bi-chevron-right"></span> ');
        
      $vars = [
          'title' => 'Tutorial - Plugins',
          'pointer' => $pointer
      ];
      self::load('docs/plugins/index', fn() => compile($vars));
    }
  

}