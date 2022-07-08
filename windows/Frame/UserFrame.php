<?php

namespace spoova\windows\Frame;
use Window;
use spoova\core\classes\Rex;

class UserFrame extends Window{
   
    public function __construct()
    {

    }

    public static function routes(array $routes = []){
        Rex::routes(
          ['docs'=>'tutorial']
        );
    }

} 