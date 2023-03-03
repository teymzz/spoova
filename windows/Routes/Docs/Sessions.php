<?php

namespace teymzz\spoova\windows\Routes\Docs;

use teymzz\spoova\windows\Frames\UserFrame;

class Sessions extends UserFrame {

    function __construct($vars){

      self::call($this, [
        lastCall() => 'root',
        lastCall('/session') => 'docs',
        SELF::ARG => $vars
      ]);
        
    }

    function root($vars){
        
        self::load('docs.sessions.index', fn() => compile($vars));
        
    }

    function docs($vars) {
        self::load('docs.sessions.session', fn() => compile($vars));
    }


}