<?php

namespace spoova\mi\windows\Routes\Docs\Features;

use spoova\mi\core\classes\Request;
use Window;

class Javascript extends Window {
    
    public function __construct(){

        self::call($this, 
            [
                lastCall() => 'root',
                lastCall('/helper-functions') => 'helperJs',
                lastCall('/loadFile.js') => 'loadFileJs',
                lastCall('/switcher.js') => 'switcherJs',
                lastCall('/device.js') => 'deviceJs',
                lastCall('/intersect.js') => 'intersectJs',

                /* ajax api url */
                window(':features/javascript/formvalidator') => 'ajax',
            ], 
            
            false);

        self::basecall($this, 
            [ 
                LASTCALL('/formvalidator') => 'formValidator', 
            ]);

    }

    function root() {

        self::load('docs.integerations.javascript.javascript', fn() => compile() );
        
    }

    function formValidator() {

        $lastcall = lastCall();
        
        $path = ( url(window('base'))->pathFrom($lastcall) );

        $accepted = ['', '/index','/index.html'];

        for($i = 1; $i <= 13; $i++){
            $accepted[] = '/sample'.$i;
            $accepted[] = '/sample'.$i.'.html';
        }

        $path = $path? '/'.$path : '';       
        
        if( in_array($path, $accepted) ) {

            self::call($this,
                [ 
                    lastcall($path) => 'loadFormValidator',

                    SELF::ARG => ($path?: '/index')
                ]
            );

        }else{
            self::call($this);
        }

    }

    function loadFormvalidator($path){

        $path = str_replace('.html','', $path);
        self::load('docs.integerations.javascript.formvalidator'.$path, fn() => compile() );        
    }

    function ajax() {

        self::integrateAPI('json');

        $Request = new Request();

        if(isset($_GET['input'])){

            $input = $_GET['input'];

            if($input == 'felix'){

                $msg = [
                    'msg' => 'username exists',
                    'valid' => false
                ];         
            } else {
                $msg = [
                    'msg' => 'something is right',
                    'valid' => true
                ];          
            }

        }else{

            $msg = [
                'msg' => 'something is wrong.'.toJson($Request->method()),
                'valid' => false
            ];

        }

        print_r(json_encode($msg));
     
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

    
    function helperJs() {

        self::load('docs.features.javascript.helperjs', fn() => compile() );
        
    }

    function loadImagesJs() {

        self::load('docs.features.javascript.loadImage', fn() => compile() );
        
    }

    function loadFileJs() {

        self::load('docs.features.javascript.loadFile', fn() => compile() );
        
    }

    function intersectJs() {

        self::load('docs.features.javascript.intersect', fn() => compile() );
        
    }

    function animeJs() {

        self::load('docs.features.javascript.anime', fn() => compile() );
        
    }

    function deviceJs() {

        self::load('docs.features.javascript.device', fn() => compile() );
        
    }

    function formValidatorJs() {

        self::load('docs.integerations.formvalidator.index', fn() => compile() );
        
    }

    function switcherJs() {

        self::load('docs.features.javascript.switcher', fn() => compile() );
        
    }

}
