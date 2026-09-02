<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateDevice implements FabricatorInterface {
  
  /**
   * Generates a random car name
   *
   * @return string
   */
  public static function fabricate() : string {
    
    $cars = self::cars();
    return $cars[array_rand($cars)];
    
  }
  
  private static function cars() : array {
    return [
      "Phone","Desktop","Clipper","Fan",
      "Selfie stick","Dish Washer","Washing machine",
      "AirPod","Dish Washer","Washing machine",
    ];
  }
  
}
