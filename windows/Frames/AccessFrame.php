<?php

namespace spoova\windows\Frames;

use Session;
use Window;

//session('user');

class AccessFrame extends Window {
    
    static function super(){
        new Session('user', 'usercookie', true);
    }

}
