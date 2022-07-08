<?php

    namespace spoova\windows\Docs;

use spoova\core\classes\Rex;
use spoova\core\classes\Slicer;
use spoova\windows\Frame\UserFrame;

    class Wmv extends UserFrame{

        function __construct($url){
            self::routes();
            if($url){
                self::call($this, [
                    'tutorial/wmv/about_wmv' => 'about_wmv',
                    'tutorial/wmv/shutters' => 'shutters',
                    'tutorial/wmv/calls'    => 'calls',
                    'tutorial/wmv/frames'   => 'frames',
                ]);                
            }

            //self::load("docs/wmv/index", fn() => compile() );
        }

        function index($vars){
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
                'user' => "-----------uuuser"
            ];
            self::load("docs.wmv.calls", fn() => compile($vars) );  
        }

        function frames() {
            $pointer = self::mapurl('Tutorial/Wmv/Frames', ' <span class="bi-chevron-right"></span> ');

            $vars = [
                'title' => 'Tutorial - WMV Frames',
                'pointer' => $pointer,
                'user' => "-----------uuuser"
            ];
            self::load("docs.wmv.frames", fn() => compile($vars) );  
        }

        static function routes($array = []) {
            Rex::routes([
                '.wmv'    => DomUrl('tutorial/wmv/why_wmv'),
                '.open'   => DomUrl('tutorial/wmv/shutters'),
                '.calls'  => DomUrl('tutorial/wmv/calls'),
                '.frames' => DomUrl('tutorial/wmv/frames'),
                '.routes' => DomUrl('tutorial/wmv/routes'),
            ]);
        }

    }