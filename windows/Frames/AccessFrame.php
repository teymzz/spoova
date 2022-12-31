<?php

namespace spoova\windows\Frames;

use Session;
use Window;

class AccessFrame extends Window {
    
    static function super(){
        new Session('user', 'usercookie', true);
    }

}
