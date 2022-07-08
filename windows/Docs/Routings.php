<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Routings extends UserFrame {

    function __construct($value){

        if($value){
            self::pathcall($this, [
                //'routings' => 'index',
                'routings/mvc' => 'mvc',
                'routings/wmv' => 'wmv',
            ]);            
        }

        
    }

    public function index($vars) {

        self::load('routings', fn() => compile($vars) );

    }

    public function mvc(){
        $pointer = self::mapurl('Tutorial/Routings/MVC', ' <span class="bi-chevron-right"></span> ');

        $vars = [
            'title' => 'Tutorial - Routing MVC',
            'pointer' => $pointer
        ];
        self::load('docs.routing.mvc', fn() => compile($vars) );        
    }

    public function wmv(){
        $pointer = self::mapurl('Tutorial/Routings/WMV', ' <span class="bi-chevron-right"></span> ');

        $vars = [
            'title' => 'Tutorial - Routing WMV',
            'pointer' => $pointer
        ];
        self::load('docs.routing.wmv', fn() => compile($vars) );        
    }

}