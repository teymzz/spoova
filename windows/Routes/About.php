<?php

namespace spoova\windows\Routes;

use Window;

class About extends Window {

    public function __construct(){

        //your code here...

        self::call($this,
            [
                window(':') => 'root',
            ]
        );

    }

    function root(){
        
        //  $pointer = self::mapurl('Home/About', ' <span class="bi-chevron-right"></span> ');

        $vars = [
            'title' => 'About',
            //'pointer' => $pointer
        ];

        //Handle all Routings from the Routings class
        self::load('about', fn() => compile($vars));  

    }

}