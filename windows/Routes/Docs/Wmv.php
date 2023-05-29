<?php

namespace spoova\mi\windows\Routes\Docs;

use spoova\mi\windows\Frames\UserFrame;

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

        function about_wmv($vars){

            $vars['title'] = 'Tutorial - About WMV';

            self::load("docs.wmv.about_wmv", fn() => compile($vars) );  
        }

        function shutters($vars) {

            $vars['title'] = 'Tutorial - Shutters';

            self::load("docs.wmv.shutters", fn() => compile($vars) );  
        }

        function calls($vars) {

            $vars['title'] = 'Tutorial - WMV Calls';
            
            self::load("docs.wmv.calls", fn() => compile($vars) );  
        }

        function middlewares($vars) {

            $vars['title'] = 'Tutorial - WMV Middlewares';
            
            self::load("docs.wmv.middlewares", fn() => compile($vars) );  
        }

        function frames($vars) {

            $vars['title'] = 'Tutorial - WMV Frames';

            self::load("docs.wmv.frames", fn() => compile($vars) );  
        }

        static function routes($vars) {

            $vars['title'] = 'Tutorial - WMV Routes';

            self::load('docs.wmv.routes', fn() =>compile($vars));

        }

        static function apis($vars) {

            $vars['title'] = 'Tutorial - WMV Routes';
            
            self::load('docs.wmv.apis', fn() =>compile($vars));

        }

        static function methods($vars) {

            $vars['title'] = 'Tutorial - WMV Methods';
            
            self::load('docs.wmv.methods', fn() =>compile($vars));

        }

        static function models($vars) {
            
            $vars['title'] = 'Tutorial - Window Models';
            
            self::load('docs.wmv.models', fn() =>compile($vars));

        }

        static function rex($vars) {
            
            $vars['title'] = 'Tutorial - Window Rex';
            
            self::load('docs.wmv.rex', fn() =>compile($vars));

        }

        static function sessions($vars) {
            
            $vars['title'] = 'Tutorial - Window Rex';
            
            self::load('docs.wmv.sessions', fn() =>compile($vars));

        }

        static function inverse($vars) {
            
            $vars['title'] = 'Tutorial - Window Url Inverse';
            
            self::load('docs.wmv.inverse', fn() => compile($vars));

        }

        static function errors($vars) {
            
            $vars['title'] = 'Tutorial - Handling Window Errors';
            
            self::load('docs.wmv.errors', fn() =>compile($vars));

        }

        static function addRoutes(array $array = []) : array{
            return [
                '.wmv'    => DomUrl('docs/wmv/about_wmv'),
                '.open'   => DomUrl('docs/wmv/shutters'),
                '.calls'  => DomUrl('docs/wmv/calls'),
                '.frames' => DomUrl('docs/wmv/frames'),
                '.routes' => DomUrl('docs/wmv/routes'),
                '.models' => DomUrl('docs/wmv/models'),
                '.rex'    => DomUrl('docs/wmv/rex'),
                '.methods' => DomUrl('docs/wmv/methods'),
                '.sessions' => DomUrl('docs/wmv/sessions'),
                '.middlewares' => DomUrl('docs/wmv/middlewares'),
                '.errors' => DomUrl('docs/wmv/errors'),
                '.inverse' => DomUrl('docs/wmv/inverse'),
            ];
        }



    }