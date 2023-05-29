<?php

namespace spoova\mi\windows\Routes;

use spoova\mi\core\classes\Request;
use Window;

class Updates extends Window {

    public function __construct(){
        self::addRex();

        self::call($this,
            [
                window(':') => 'root',
                window(':1.5', 1) => 'root',
                self::ARG => ['sasa']
            ]
        );
    }

    function root(Request $Request, $arg) {

        self::load('updates', fn() => compile() );
        
    }

    /**
     * Add name of routes
     *
     * @return array
     */
    public static function addRoutes(array $array = []) : array {

        return [
            // 'routeName' => 'routePath'
        ];

    }

}
