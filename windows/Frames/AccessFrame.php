<?php

namespace spoova\mi\windows\Frames;

use Session;
use Window;

class AccessFrame extends Window {
    
    static function frame(){
        /* Session only works when all required data table columns have been created */
        new Session('user', 'usercookie', true);
    }

}