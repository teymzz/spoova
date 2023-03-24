<?php

namespace spoova\mi\windows\Routes\Docs;

use spoova\mi\windows\Frames\UserFrame;

class Directives extends UserFrame {

    function __construct($vars){
        

        self::pathcall($this, 
            [
                'directives' => 'index',

                 SELF::ARG => $vars
            ]
        );  

        
    }

    function index($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.directives.index', fn() => compile($vars));

    }

}