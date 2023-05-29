<?php

namespace spoova\mi\windows\Routes\Docs;

use Window;

class Features extends Window {
    
    public function __construct(){

        self::call($this,
            [ lastCall() => 'root'], false
        );

        self::basecall($this, [
            lastCall('/css') => 'win:Routes\Docs\Features\Css',
            window(':other-features.javascript') => 'win:Routes\Docs\Features\Javascript',
            lastCall('/javascript/ajax')  => 'win:Routes\Docs\Features\FormValidator',
        ]);

    }

    function root() {

        self::load('docs.features.index', fn() => compile() );
        
    }

    function css() {

        self::load('docs.integerations.css.css', fn() => compile() );
        
    }
    
}
