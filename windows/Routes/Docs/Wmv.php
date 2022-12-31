<?php

    namespace spoova\windows\Routes\Docs;

use spoova\core\classes\Ajax;
use spoova\windows\Frames\UserFrame;

    class Wmv extends UserFrame{

        function __construct($vars){

            // self::integrateAPI('ajax:json');

            $path = url(window('path'))->first(2);

            self::call($this,
                [
                    window(':wmv') => 'root',
                    SELF::ARG => $vars,
                ],
                false
            );

            self::call($this, [

                strtolower(window('!:'.$path)) => basename($path),

                    SELF::ARG => $vars,
                    

                ]
            );   

        }

        function root($vars){
            self::load("docs.wmv.index", fn() => compile($vars) );            
        }

        function about_wmv(){
            $pointer = self::mapurl('Tutorial/Wmv/About_wmv', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - About WMV',
                'pointer' => $pointer
            ];
            self::load("docs.wmv.about_wmv", fn() => compile($vars) );  
        }

        function shutters() {
            $pointer = self::mapurl('Tutorial/Wmv/Shutters', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - Shutters',
                'pointer' => $pointer
            ];
            self::load("docs.wmv.shutters", fn() => compile($vars) );  
        }

        function calls() {
            $pointer = self::mapurl('Tutorial/Wmv/Calls', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Calls',
                'pointer' => $pointer,
            ];
            self::load("docs.wmv.calls", fn() => compile($vars) );  
        }

        function middlewares() {
            $pointer = self::mapurl('Tutorial/Wmv/Middlewares', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Middlewares',
                'pointer' => $pointer,
            ];
            self::load("docs.wmv.middlewares", fn() => compile($vars) );  
        }

        function frames() {
            $pointer = self::mapurl('Tutorial/Wmv/Frames', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Frames',
                'pointer' => $pointer,
            ];
            self::load("docs.wmv.frames", fn() => compile($vars) );  
        }

        static function routes($array = []) {
            $pointer = self::mapurl('Tutorial/Wmv/Routes', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Routes',
                'pointer' => $pointer,
            ];
            
            self::load('docs.wmv.routes', fn() =>compile());

        }

        static function apis($array = []) {
            $pointer = self::mapurl('Tutorial/Wmv/APIs', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Routes',
                'pointer' => $pointer,
            ];
            
            self::load('docs.wmv.apis', fn() =>compile());

        }

        static function methods($array = []) {
            $pointer = self::mapurl('Tutorial/Wmv/Methods', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Methods',
                'pointer' => $pointer,
            ];
            
            self::load('docs.wmv.methods', fn() =>compile());

        }

        static function inverse($array = []) {
            $pointer = self::mapurl('Tutorial/Wmv/Errors', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - Window Url Inverse',
                'pointer' => $pointer,
            ];
            
            self::load('docs.wmv.inverse', fn() =>compile());

        }

        static function errors($array = []) {
            $pointer = self::mapurl('Tutorial/Wmv/Errors', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - Handling Window Errors',
                'pointer' => $pointer,
            ];
            
            self::load('docs.wmv.errors', fn() =>compile());

        }

        static function addRoutes(array $array = []) : array{
            return [
                '.wmv'    => DomUrl('docs/wmv/about_wmv'),
                '.open'   => DomUrl('docs/wmv/shutters'),
                '.calls'  => DomUrl('docs/wmv/calls'),
                '.frames' => DomUrl('docs/wmv/frames'),
                '.routes' => DomUrl('docs/wmv/routes'),
                '.methods' => DomUrl('docs/wmv/methods'),
                '.middlewares' => DomUrl('docs/wmv/middlewares'),
                '.errors' => DomUrl('docs/wmv/errors'),
                '.inverse' => DomUrl('docs/wmv/inverse'),
            ];
        }



    }