<?php

namespace spoova\mi\windows\Routes\Docs;

use Window;

class Apis extends Window {
    
    public function __construct(){

        self::call($this,
            [
                window(':apis') => 'root'
            ]
        );

    }

    function root() {

        self::load('docs.apis.apis', fn() => compile() );
        
    }

}
