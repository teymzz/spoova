<?php

namespace spoova\mi\windows\Routes\Docs;

use Window;

class Forms extends Window {
    
    public function __construct($vars){

        self::call($this,
            [
                window(':forms') => 'root',
                SELF::ARG => $vars
            ], 
        );

    }

    function root($vars) {

        self::load('docs.forms.index', fn() => compile($vars) );
        
    }

}
