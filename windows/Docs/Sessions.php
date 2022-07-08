<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Sessions extends UserFrame {

    function __construct($value){

        if($value){
            self::close();
            // self::pathcall($this, [
            //     'sessions/mvc' => 'mvc',
            //     'sessions/wmv' => 'wmv',
            // ]);            
        }
        
    }

    function index($vars){
        
        self::load('docs/sessions/index', fn() => compile($vars));
        
    }


}