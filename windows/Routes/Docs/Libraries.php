<?php

namespace spoova\mi\windows\Routes\Docs;

use Window;

class Libraries extends Window {

   
    function __construct()
    {
        self::call($this, [
            window(":libraries") => 'root'
        ]);
    }

    function root() {

        self::load('docs.libraries.libraries', fn() => compile() );

    }


}