<?php

namespace spoova\mi\windows\Routes;

use Window;

class Hello extends Window {
    
    public function __construct(){

        self::call($this,
            [
                window('root') => 'root'
            ]
        );

    }

    function root() {

        $title = ['title' => 'Hello! Spoova'];

        self::load('hello', fn() => compile($title) );
        
    }

}
