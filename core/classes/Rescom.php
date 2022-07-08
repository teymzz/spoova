<?php

namespace spoova\core\classes;

/**
 * Contains Directive Commands for Res class
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 * @package spoova\core\classes
 */

abstract class Rescom extends Rescon
{


  /**
   * apply directives to create files
   *
   * @param string $name
   * @param array|string $args
   * @return void
   */
  static function mkFile($name, $args){
    $class = 'spoova\core\commands\Make\Mk'.$name;
    if(class_exists($class)){
        $newclass = new $class($args);
        $build = $newclass->build();
        return $build;
    }else{
      trigger_error('Missing executable file: core/commands/Make/Mk'.$name);
      return false;
    }
  }

}