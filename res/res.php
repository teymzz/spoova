<?php

/* Core Static Resources  */

Res::ignore();

Res::new('res/main/')
  
    ->name("headers")
  
        # css headers
        ->url("css/res.css => x-debug:res-css")
    
        # javascript headers
        ->url("js/jquery/jquery-3.6.0.js")
        ->url("js/jquery/jquery.mousewheel.js")
        ->url("css/bootstrap/js/bootstrap.min.js")
        ->url("css/bootstrap/js/bootstrap.utilities.js")
        ->url("css/mdb5/css/mdb.min.css")
    
        # local javascript files
        ->url("js/local/core.js")
        ->url("js/local/onLoaded.js")
        ->url("js/local/jqmodex.js")
        ->url("js/local/device.js")

        # javascript headers - optional 
        ->url("js/local/loadImages.js") 
        ->url("js/local/formValidator.js")
        ->url("js/local/helper.js")
        ->url("js/local/init.js")
   
    ->name('footers')

        # javascript footers
        ->url("js/local/loadFuncs.js")
        ->url("css/mdb5/js/mdb.min.js")

    /* All resources in this folder are core static files */

    ->urlClose()
    ;