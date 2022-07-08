<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Directives extends UserFrame {

    function __construct($value){
        
        
        if($value) {
            self::pathcall($this, 
                [
                    'functions/core'  => 'core',
                    'functions/modal' => 'modal',
                    'functions/lite'  => 'lite',
                    'functions/script'  => 'script',
                ], 
            );            
        }

        
    }

    function index($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.directives.index', fn() => compile($vars));

    }
    

}