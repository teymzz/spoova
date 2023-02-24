<?php

namespace spoova\windows\Frames;

use Session;
use Window;

//session('user');

class AccessFrame extends Window {
    
    static function super(){
        /* Session only works when all required data table columns have ben created */
        new Session('user', 'usercookie', true);
    }

}
