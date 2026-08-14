<?php 

/* Set custom static resources url */
Ress::pull('core.ress');

Ress::new('res/assets/') //base directory
    
    // ->url('libraries/highlight/styles/isbl-editor-dark.min.css')->named('HighlightCss') //add your resources
    ->url('libraries/highlight/highlight.min.js')->named('HighlightJs') //add your resources

     ->bindTo('headers', ['animateCSS','HighlightCss', 'HighlightJs'])
    
     ->close(); //close resource
