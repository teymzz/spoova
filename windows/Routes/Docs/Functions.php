<?php

namespace spoova\mi\windows\Routes\Docs;

use spoova\mi\windows\Frames\UserFrame;

class Functions extends UserFrame {

    function __construct($vars){

        self::call($this, 
          [
              window(':functions')         => 'root',
              window(':functions.core')    => 'core',
              window(':functions.modal')   => 'modal',
              window(':functions.lite')    => 'lite',
              window(':functions.script')  => 'script',

              SELF::ARG => $vars
          ]
        );
        
    }

    function root($vars){
      
      self::load('docs.functions.index', fn() => compile($vars));

    }
    
    function routings(){
        self::load('docs.functions.routings', fn() => compile());
    }
    
    function core(){
      $pointer = self::mapurl('Tutorial/Functions/Core', ' <span class="bi-chevron-right"></span> ');
      
      $vars = [
          'title' => 'Tutorial - Functions',
          'pointer' => $pointer
      ];
    
      self::load('docs.functions.core', fn() => compile($vars));
    }
    
    function modal(){
      $pointer = self::mapurl('Tutorial/Functions/Modal', ' <span class="bi-chevron-right"></span> ');
        
      $vars = [
          'title' => 'Tutorial - Functions',
          'pointer' => $pointer
      ];
      self::load('docs.functions.modal', fn() => compile($vars));
    }

    function lite(){
      $pointer = self::mapurl('Tutorial/Functions/Lite', ' <span class="bi-chevron-right"></span> ');
        
      $vars = [
          'title' => 'Tutorial - Functions',
          'pointer' => $pointer
      ];
      self::load('docs.functions.lite', fn() => compile($vars));
    }  

    function script(){
      $pointer = self::mapurl('Tutorial/Functions/Script', ' <span class="bi-chevron-right"></span> ');
      
      $vars = [
          'title' => 'Tutorial - Functions',
          'pointer' => $pointer
      ];
    
      self::load('docs.functions.script', fn() => compile($vars));
    }

}