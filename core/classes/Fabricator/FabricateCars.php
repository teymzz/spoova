<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateCars implements FabricatorInterface {
  
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
      "Toyota","Honda","Ford","Chevrolet",
      "BMW","Mercedes","Audi","Volkswagen","Nissan",
      "Hyundai","Subaru","Kia","Mazda","Tesla",
      "Porsche","Lexus","Volvo","Jaguar",
      "Range Rover","Dodge","Cadillac","GMC Yukon","Acura",
      "Infiniti","Honda","GMC Sierra","Prado"
    ];
  }
  
}
