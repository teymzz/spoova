<?php

Res::ignore();

Res::new('res/main/')
  
    ->name("headers") /* headers */
  
    # css headers
    ->url("css/res.css => x-debug:res-css")
    
    # javascript headers
    ->url("js/jquery-3.6.0.js")
    ->url("css/bootstrap/js/bootstrap.min.js")
    ->url("css/bootstrap/js/bootstrap.utilities.js")
    ->url("css/mdb5/css/mdb.min.css")
    
    ->url("js/config.js")
    ->url("js/core.js")
    ->url("js/onLoaded.js")
    ->url("js/custom.js")
    ->url("js/device.js")

    # javascript headers - optional 
    ->url("js/loadImages.js") 
    ->url("js/formValidator.js")
    ->url("js/jquery.mousewheel.js")
    ->url("js/anime.js")
    ->url("js/init.js")
   
    # javascript footers
    ->name('footers') /* footers */

    ->url("js/loadFuncs.js")
    ->url("css/mdb5/js/mdb.min.js")

    /* All resources in this folder are core static files */

    ->urlClose()
    ;