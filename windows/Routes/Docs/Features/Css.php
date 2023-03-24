<?php

namespace spoova\mi\windows\Routes\Docs\Features;

use Window;

class Css extends Window {
    
    public function __construct(){

        $path = url(window('path'))->pathFrom('other-features/css');

        $acceptedRoutes = [
            '',
            'display-properties',
            'widths-and-heights',
            'responsive-paddings',
            'margins',
            'fluid-boxes',
            'images-and-thumbnails',
            'overlay-items',
            'overflow-items',
            'text-alignments',
            'fonts',
            'anchors',
            'property-inheritance',
            'forms-and-alignment',
            'borders',
            'colors',
            'menu-burger',
            'animation-effects',
        ];

        //$path = window(':other-features.css');
        if(in_array($path, $acceptedRoutes)){

            self::call($this, [

                window('base') => 'root',

                /* argument */
                SELF::ARG => $path
            ]); 

        }else{
            self::call($this);
        }


        

    }

    function root($path) {

        $path = $path?: 'css';

        self::load('docs.integerations.css.'.$path, fn() => compile() );
        
    }

}
