<?php 

/* Set custom static resources url */
Ress::pull('core.ress');

Ress::new('res/assets/') //base directory
    
     ->url('your-file-path')->named('unique-name') //add your resources

     ->bindTo('headers', ['animateCSS'])
    
     ->close(); //close resource
