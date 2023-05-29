<?php

namespace spoova\mi\windows\Routes\Docs;

use Window;

class Libraries extends Window {

   
    function __construct($vars)
    {
        self::call($this, [
            window(":libraries") => 'root',
            SELF::ARG => $vars
        ]);
    }

    function root($vars) {

        self::load('docs.libraries.libraries', fn() => compile($vars) );

    }


}