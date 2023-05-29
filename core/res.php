<?php

/* Core Static Resources  */

Res::new('res/main/')
  
    ->name("headers")
  
        # css headers
        ->url("css/local/debug/res.css => x-debug:res-css")->named('x-debug')
    
        # javascript headers
        ->url("js/jquery/jquery-3.6.0.js")->named('jquery')
        ->url("js/jquery/jquery.mousewheel.js")->named('mousewheel')
        ->url("css/mdb5/css/mdb.min.css")->named('mdb')
    
        # local javascript files
        ->url("js/local/core.js")->named('core')
        ->url("js/local/onLoaded.js")->named('onloaded')
        ->url("js/local/jqmodex.js")->named('jqmodex')
        ->url("js/local/device.js")->named('device')

        # javascript headers - optional 
        ->url("js/local/loadImages.js")->named('load-images')
        ->url("js/local/formValidator.js")->named('formvalidator')
        ->url("js/local/helper.js")->named('helperJs')
        ->url("js/local/init.js")->named('initJs')

        ->bindTo('headers')
   
    ->name('footers')

        # javascript footers
        ->url("js/local/loadFuncs.js")->named('loadFuncs')
        ->url("css/mdb5/js/mdb.min.js")->named('mdb')

        ->bindTo('footers')
   
    ->name('bond')

        # javascript footers
        ->url("js/local/bond.js")->named('bond')

    /* All resources in this folder are core static files */

    ->urlClose();