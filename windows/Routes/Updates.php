<?php

namespace spoova\mi\windows\Routes;

use Window;

class Updates extends Window {

    public function __construct(){
        self::addRex();
        self::call($this,
            [
                window('root') => 'root'
            ]
        );

    }

    function root() {

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
