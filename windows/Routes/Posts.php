<?php

namespace teymzz\spoova\windows\Routes;

use Window;

class Posts extends Window {
    
    public function __construct(){

        self::call($this,
            [
                window('root') => 'root'
            ]
        );

    }

    function root() {

        //self::load('index', fn() => compile() );
        
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
