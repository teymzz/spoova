<?php 

/* Set custom static resources url */
Ress::pull('core.ress');

Ress::new('res/assets/') //base directory
    
     ->urx('res/main/js/local/Theme.js')->named('ThemeJs') //add your resources
     ->url('libraries/highlight/highlight.js')->named('HighlightJS') //add your resources
     ->urx('res/main/js/local/checkBox/checkBox.js => type:module')->named('checkboxJS') //add your resources
     ->urx('res/main/js/local/interval.js => type:module')->named('intervalJS') // for spoova doc

     ->bindTo('headers', ['animateCSS','ThemeJs','HighlightJS'])
    
     ->close(); //close resource
