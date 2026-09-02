<?php

Ress::new('res/main/')

        // css ............................................................ core (start:headers)
        ->url("css/local/debug/res.css => x-debug:res-css")->named('x-debug')
        
        // javascript ................................................. external
        ->url("js/local/autoload/ss.js => type:module")->named('ss')
        ->url("js/jquery/jquery-4.0.0.js")->named('jquery')
        ->url("js/jquery/jquery.mousewheel.js")->named('mousewheel')
        //->url("css/bootstrap/js/bootstrap.min.js")->named('bootstrapJS')
    
        // css ........................................................ external
        //->url("css/mdb5/css/mdb.min.css")->named('mdbCSS')
    
        // javascript .................................................... local
        ->url("js/local/core.js")->named('core')
        ->url("js/local/onLoaded.js")->named('onloaded')
        // ->url("js/local/jqmodex.js")->named('jqmodex')
        ->url("js/local/device.js => type:module")->named('ss.device')
        ->url("js/local/loadImages.js => type:module")->named('ss.loadImages')
        ->url("js/local/helper.js => type:module")->named('ss.helper')
        ->url("js/local/init.js => type:module")->named('ss.init')

        ->bindTo('headers') //* ................................................. (end:headers)

        // javascript ..................................................... core (start:footers)
        ->url("js/local/loadFuncs.js")->named('loadFuncs')
        ->url("css/mdb5/js/mdb.min.js")->named('mdb')

        ->bindTo('footers') //* ................................................. (end:footers)

        // css optionals .............................................. (manual)
        ->url('css/animations/animate.min.css')->named('animateCSS')

        
        // javascript optionals ....................................... (manual)
        ->new('res/main/js/local/') //set parent path
        ->url("bond.js => type:module")->named('bond')
        ->url('autoload/ssDom.js => type:module')->named('ss.SSDom')
        ->url('selector.js => type:module')->named('ss.selector')
        ->url('switcher.js => type:module')->named('ss.switcher')
        ->url('itemDragger.js => type:module')->named('ss.itemDragger')
        ->url('intersect.js => type:module')->named('ss.intersect')
        ->url('interval.js => type:module')->named('ss.interval')
        ->url('ajax.js => type:module')->named('ss.ajax')
        ->url('anime.js => type:module')->named('animeJS')
        ->url('scrollSlider.js => type:module')->named('scrollSliderJS')
        ->url("forms.js => type:module")->named('ss.forms')
        ->url("formValidator.js => type:module")->named('formvalidatorJS')
        ->url('ajaxController.js => type:module')->named('ss.ajaxController')
        ->url("loadFile.js => type:module")->named('ss.loadFile')
        ->url('checkBox/checkBox.js => type:module')->named('ss.checkBox')
        ->url('checkBox/textAnime.js => type:module')->named('ss.textAnime')
        ->new()//unset parent path
    ;