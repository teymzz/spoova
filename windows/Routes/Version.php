<?php

namespace spoova\mi\windows\Routes;

use DOMDocument;
use DOMXPath;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\FileManager;
use spoova\mi\core\classes\Request;
use Window;

class Version extends Window {
    
    public function __construct(){

        //call main page
        self::call($this, [window(':') => 'root'], false);

        //call preferred subsequents on 1.5 only
        self::basecall($this,
            [
                window(':1.5', true) => 'version1d5',
                window(':2.0', true) => 'version2d0'
            ]
        );

    }

    function root() {

        self::load('version.index', fn() => compile() );
        
    }

    function version1d5(Request $Request) {

        //manage all 1.5 routes

        $lastCall = lastCall().'/';
        $windowUrl= window('base');
        self::addRex();
        $controller = [ 
            $lastCall.'ajax-requests' => 'version.1v5.ajax',
            $lastCall.'map-file'      => 'version.1v5.map-file',
            $lastCall.'live-notice'   => 'version.1v5.live-notice',
            $lastCall.'live-template' => 'version.1v5.live-template',
            $lastCall.'deprecations'  => 'version.1v5.deprecations',
        ];

        if(array_key_exists($windowUrl, $controller)){

            self::load($controller[$windowUrl], fn() => compile());

        } else {
            self::close();
        }

    }

    function version2d0() {

        //manage all 2.0 routes

        $lastCall = lastCall().'/';
        $windowUrl= window('base');

        $controller = [ 
            $lastCall.'urls' => 'version.2v0.urls',
            $lastCall.'window-functions'      => 'version.2v0.window-functions',
            $lastCall.'shutter-calls'   => 'version.2v0.shutter-calls',
            $lastCall.'compiler-engine' => 'version.2v0.compiler-engine',
            $lastCall.'compiler-class' => 'version.2v0.compiler-class',
            $lastCall.'models' => 'version.2v0.models',
            $lastCall.'resource'  => 'version.2v0.resource',
            $lastCall.'others' => 'version.2v0.others',
        ];

        if(array_key_exists($windowUrl, $controller)){

            self::load($controller[$windowUrl], fn() => compile(['soft'=>'boy']));

        } else {

            self::basecall($this, [

                lastCall() => 'win:Routes\Docs\V2\BondComponents'

            ]);

        }
        
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
