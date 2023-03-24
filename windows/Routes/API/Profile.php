<?php

namespace spoova\mi\windows\Routes\API;

use spoova\mi\core\classes\Ajax;

class Profile {


    function __construct()
    {
        Ajax::withJson('invalid transfer protocol', 404);
    }
    
}