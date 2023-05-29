<?php

namespace spoova\mi\windows\Routes;

use spoova\mi\core\classes\Request;
use Window;

class Hello extends Window {
    
    public function __construct(Request $Request){
        print_r(func_num_args());
        //print_r($arg3);

        // self::call($this,
        //     [
        //         window('root') => 'root'
        //     ]
        // );

    }

    function root() {
        print_r(func_get_args());
        $title = ['title' => 'Hello! Spoova'];

        self::load('hello', fn() => compile($title) );
        
    }

}
