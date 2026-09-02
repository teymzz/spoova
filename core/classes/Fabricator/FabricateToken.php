<?php

namespace spoova\mi\core\classes\Fabricator;

use spoova\mi\core\classes\Anonymous;
// use function spoova\mi\core\classes\Anonymous;

class FabricateToken implements FabricatorInterface {
  
  /**
   * Generates a random token
   *
   * @return string
   */
  public static function fabricate($length = 10) : string {

    // using anonymous function for future extensibility and to demonstrate the use of the Anonymous class
    return Anonymous::fn(function() use ($length) {

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;

    }, $id)::invoke($id);
    
  }
  
}
