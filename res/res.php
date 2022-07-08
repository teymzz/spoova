<?php

/* All resources in this folder are global files */
Res::ignore();

Res::new('res/main/')
  
    ->name("headers") /* headers */
  
    //css headers
    ->url("css/res.css => x-debug:res-css")
    ->url("css/ico.css")
    ->url("css/custom-fonts.css")
    
    //javascript headers
    ->url("js/jquery-3.6.0.js")
    ->url("css/bootstrap/js/bootstrap.min.js")
    ->url("css/bootstrap/js/bootstrap.utilities.js")
    ->xurl("res/assets/css/global.css")
    
    ->url("js/config.js")
    ->url("js/core.js")
    ->url("js/custom.js")
    ->url("js/device.js")

    //javascript headers - optional 
    ->url("js/loadImages.js") 
    ->url("js/formValidator.js")
    ->url("js/jquery.mousewheel.js")
    ->url("js/anime.js")
    ->url("js/init.js")

    ->name('footers') /* footers */
   
    //javascript footers
    ->url("js/loadFuncs.js")
    ->urlClose()
    ;

/* sample with attributes

   Res::name('foo') 

    ->url("https://res/js/ready.css => integrity:askdas; anonimity:sasdkasda;");    

*/

/* You may include your global assets below before close()*/

Res::close(); 