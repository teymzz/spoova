<?php

namespace spoova\mi\core\classes\Fabricator;
use spoova\mi\core\classes\Fabricator\FabricateName;

class FabricateEmail implements FabricatorInterface {
  
  /**
   * Fabricates an email string.
   * @param string $name uses a specific name to generate email types
   * @param string|array|null $domain email domain endings (e.g sample.com, webmail.com, gmail.com)
   */
  public static function fabricate(string|array|null $name = null, string|array|null $domain = null) : string {
    
    $domains = ['example.com', 'mail.com', 'usermail.com', 'umail.com', 'test.com', 'demo.com'];
    if(is_array($name)) {
      if($name){
        $name = randice(4, implode('', $name));
      }else{
        $name = null;
      }
    }
    if($name === null){
       //Generate a random name
       $name = FabricateName::fabricate('Firstname');
    }
    
    $name = strtolower($name);
    
    $domain = $domain ?? $domains[array_rand($domains)];
    if(is_array($domain)) $domain = $domain[array_rand($domain)];
    return $name.'@'.$domain;
  
  }
 
}