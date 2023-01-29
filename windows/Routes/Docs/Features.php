<?php

namespace spoova\windows\Routes\Docs;

use Window;

class Features extends Window {
    
    public function __construct(){

        //your code here...
        self::call($this,
            [
                lastCall() => 'root',
                // window(':other-features.javascript.core-functions') => 'coreJs',
                // window(':other-features.javascript.loadimages').'.js' => 'loadImagesJs',
                // window(':other-features.javascript.loadFile').'.js' => 'loadFileJs',
                // window(':other-features.javascript.intersect').'.js' => 'intersectJs',
                // window(':other-features.javascript.anime').'.js' => 'animeJs',
                // window(':other-features.javascript.device').'.js' => 'deviceJs',
                // window(':other-features.javascript.switcher').'.js' => 'switcherJs',
            ], false
        );
        /* window(':other-features'.url(window('base'))->pathFrom(lastCall())) */
        self::basecall($this, [
            lastCall('/css') => 'win:Routes\Docs\Features\Css',
            window(':other-features.javascript') => 'win:Routes\Docs\Features\Javascript',
            lastCall('/javascript/ajax')  => 'win:Routes\Docs\Features\FormValidator',
        ]);

    }

    function root() {

        self::load('docs.features.index', fn() => compile() );
        
    }

    function css() {

        self::load('docs.integerations.css.css', fn() => compile() );
        
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
