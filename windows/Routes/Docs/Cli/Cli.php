<?php

namespace spoova\windows\Routes\Docs\Cli;

use Window;

class Cli extends Window {
    
    public function __construct($url){

        $path = url(window('path'));
        $path = ['path' => $path];

        self::call($this, 
            [
                lastCall() => 'index',
                lastCall('/texts') => 'texts',
                lastCall('/colors') => 'colors',
                lastCall('/notifications') => 'notifications',
                lastCall('/animations') => 'animations',
                lastCall('/prompts') => 'prompts',
                lastCall('/storage') => 'storage',

                /* argument */
                SELF::ARG => $url

            ]
        );

    }

    function index($url) {

        self::load('docs.classes.cli.index', fn() => compile($url) );
        
    }

    function texts($url) {

        self::load('docs.classes.cli.texts', fn() => compile($url) );       

    }

    function colors($url){

        self::load('docs.classes.cli.colors', fn() => compile($url) );       

    }

    function notifications($url){

        self::load('docs.classes.cli.notifications', fn() => compile($url) );       

    }

    function animations($url) {

        self::load('docs.classes.cli.animations', fn() => compile($url) );
        
    }

    function prompts($url) {

        self::load('docs.classes.cli.prompts', fn() => compile($url) );
        
    }

    function storage(){

        self::load('docs.classes.cli.storage', fn() => compile() );       

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
