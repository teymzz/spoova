<?php

namespace spoova\mi\windows\Routes;

use Res;
use Session;
use spoova\mi\core\classes\Request;
use spoova\mi\windows\Frames\AccessFrame;
use spoova\mi\windows\Models\Access\AccessModel;

class Login extends AccessFrame {
    
    public function __construct($Request){

        Session::onauto('login', 'home');

        $this::preload([window(':')], fn() => AccessModel::onSubmit() );
        
        $this::call($this,
            [
                window(':') => 'root',
            ]
        ); 

    }


    function root($vars, Request $Request) {
        
        self::load('login', fn() => compile() );
        
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
