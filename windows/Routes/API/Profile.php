<?php

namespace spoova\windows\Routes\API;

use spoova\core\classes\Ajax;

class Profile {


    function __construct()
    {
        Ajax::withJson('invalid transfer protocol', 404);
    }
    
}