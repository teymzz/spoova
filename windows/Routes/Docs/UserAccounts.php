<?php

namespace spoova\mi\windows\Routes\Docs;

use spoova\mi\windows\Frames\UserFrame;

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