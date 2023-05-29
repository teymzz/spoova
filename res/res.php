<?php 

/* Set custom static resources url */

Res::new('assets/')

    //->urlOpen(true)
    
    ->url('css/animate.min.css')->named('animate') //add your resources

    ->bindTo('headers', ['animate'])
    
    ->urlClose(); //close resource