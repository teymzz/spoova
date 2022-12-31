<?php

namespace spoova\windows\Frames;

use Session;
use Window;
use spoova\core\classes\Rex;
use spoova\windows\Models\Access\AccessModel;
use User;

class UserFrame extends AccessFrame {

    static function super() : void {

      parent::super();

      if(window('base') !== 'signup' && window('base') !== 'login'){     

         User::onauto('logout', 'login');
         
      }

      AccessModel::onSubmit('logout');

    }

} 