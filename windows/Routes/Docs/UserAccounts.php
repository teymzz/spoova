<?php

namespace spoova\windows\Routes\Docs;

use spoova\core\classes\DB;
use spoova\core\classes\DBBot;
use spoova\windows\Frames\UserFrame;
use User;

class UserAccounts extends UserFrame {

    function __construct($vars){

      self::call($this, [
        window(':useraccounts') => 'index',
        SELF::ARG => $vars
      ]);
        
    }

    function index($vars){
        
        self::load('docs.useraccounts.index', fn() => compile($vars));
        
    }


}