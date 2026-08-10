<?php

namespace spoova\mi\core\classes\Fabricator;
use spoova\mi\core\classes\Fabricator\FabricatorAbstract;

class Fabricator extends FabricatorAbstract {
  
  /**
   * @param string $handler Fabricator handler class name. 
   *  - Note that the class name should not include the full namespace or file path
   *  - The handler class must implement FabricatorInterface
   *  - The handler class file must be located in core/classes/Fabricator/ and named as Fabricate{Handler}.php 
   *  - For example, to use FabricateName class, the $handler should be 'Name' as the 'Fabricate' prefix is automatically added
   * @param mixed $value options if required
   *  - Note that array values are spread as multiple arguments to fabricate method
   * @return mixed
   */
  public static function fabricate(?string $handler = null, mixed $value = null){
    $classSpace = 'core/classes/Fabricator/Fabricate'.$handler;
    $nameSpace = scheme($classSpace);
    if(appExists($classSpace)){
      $Fabricator = new $nameSpace;
      if(!is_array($value)){
        $value = [$value];
      } 
      if($Fabricator instanceof FabricatorInterface){
        return $Fabricator::fabricate(...$value);
      }
    }
  }

  public static function reset(){

    $fabrics = self::$fabrics;

    foreach($fabrics as $key => $fabric){

      $fabric::reset();

      unset(self::$fabrics[$key]);

    }

  }

}