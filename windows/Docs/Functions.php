<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Functions extends UserFrame {

    function __construct($value){

      if($value){ 
      
        self::pathcall($this, [
           // 'functions' => 'index',
            'functions/core'  => 'core',
            'functions/modal' => 'modal',
            'functions/lite'  => 'lite',
            'functions/script'  => 'script',
        ], 

        );
      }
        
    }

    function index($vars){
      
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