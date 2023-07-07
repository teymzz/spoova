<?php 

/* Set custom static resources url */

Res::new('assets/') //base directory
    
    ->url('your-file-path')->named('unique-name') //add your resources

    ->bindTo('headers', ['animateCSS'])
    
    ->urlClose(); //close resource