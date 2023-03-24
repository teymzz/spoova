<?php

namespace spoova\mi\windows\Routes;

use spoova\mi\windows\Frames\UserFrame;
use spoova\mi\windows\Models\Access\AccessModel;
use User;

class Signup extends UserFrame {
    
    public function __construct(){

        User::onauto('login', 'home');

        self::preload([ window(':') ], fn() => AccessModel::onSubmit() );

        //self::onCall([ window(':') => fn() => AccessModel::onSignup() ] );

        self::call($this,
            [
                window(':') => 'root'
            ]
        );

    }

    function root() {

        self::load('signup', fn() => compile() );
        
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
