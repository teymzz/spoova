<?php

namespace teymzz\spoova\windows\Routes\API;

use teymzz\spoova\core\classes\Ajax;

class Profile {


    function __construct()
    {
        Ajax::withJson('invalid transfer protocol', 404);
    }
    
}