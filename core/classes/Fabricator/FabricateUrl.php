<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateUrl implements FabricatorInterface {
  
  /**
   * Generates a random URL
   *
   * @return string
   */
  public static function fabricate() : string {

    function generateString($length = 10){

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;

    }
    
    $protocols = ['http', 'https'];
    $domain = ['example.com', 'dummy.org', 'test.net'];
    $paths = ['path', 'dir', 'folder', 'subdir'];

    $protocols = $protocols[array_rand($protocols)];
    $domain = $domain[array_rand($domain)];
    $path = $paths[array_rand($paths)];

    return $protocols . '://'.$domain.'/'.$path;
    
  }
  
}
