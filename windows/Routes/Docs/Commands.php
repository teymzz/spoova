<?php

    namespace spoova\windows\Routes\Docs;

    use spoova\windows\Frames\UserFrame;

    class Commands extends UserFrame{

        function __construct($vars){

                $path = url(window('path'))->first(2);

                self::call($this,
                    [
                        window(':commands') => 'root', 
                        SELF::ARG => $vars
                    ],
                    false
                );

                self::call($this, [

                    window(':'.$path) => basename($path),
                    SELF::ARG => $vars

                ]
            );   

        }

        function root($vars){
            self::load("docs.resource.commands", fn() => compile($vars) );            
        }

        static function addRoutes(array $array = []) : array{
            return [
                '.wmv'    => DomUrl('tutorial/wmv/about_wmv'),
                '.open'   => DomUrl('tutorial/wmv/shutters'),
                '.calls'  => DomUrl('tutorial/wmv/calls'),
                '.frames' => DomUrl('tutorial/wmv/frames'),
                '.routes' => DomUrl('tutorial/wmv/routes'),
                '.methods' => DomUrl('tutorial/wmv/methods'),
            ];
        }

    }