<?php

namespace spoova\windows\Routes;

use Window;

class Features extends Window {


    function __construct()
    {
        $pointer = self::mapurl('Home/Download', ' <span class="bi-chevron-right"></span> ');

        $vars = [
            'title' => 'Download',
            'pointer' => $pointer
        ];
    
        //Handle all Routings from the Routings class
        self::load('features', fn() => compile($vars)); 
    }

}