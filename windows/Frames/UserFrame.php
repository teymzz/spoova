<?php

namespace spoova\mi\windows\Frames;

use Form;
use spoova\mi\windows\Models\Access\AccessModel;
use User;

class UserFrame extends AccessFrame {

    static function frame() : void {

      if(in_array(window('base'), ['signup','login'])){     

        // session entry auto redirection
        User::onauto('login', 'home');
        
      } elseif(window('@root') !== 'index') {

        // session exit auto redirection
        User::onauto('logout', 'index');

      }
  
      //use model only when a post request is sent
      Form::onpost(fn() => AccessModel::onSubmit());

    }

} 