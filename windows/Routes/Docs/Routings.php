<?php

namespace spoova\mi\windows\Routes\Docs;

use spoova\mi\windows\Frames\UserFrame;

class Routings extends UserFrame {

    function __construct($value){

        $base = str_replace('/', ' / ', window('base'));

        $vars = [ 'pointer' => self::mapurl(ucwords($base), ' <span class="bi-chevron-right"></span> ') ];

        self::call($this, [
            window(':routings') => 'index',
            window(':routings.mvc') => 'mvc',
            window(':routings.wmv') => 'wmv',
            
            SELF::ARG => $vars
        ]);   

        
    }

    public function index($vars) {

        self::load('routings', fn() => compile() );

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