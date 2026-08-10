<?php

namespace spoova\mi\core\classes\Res;

use spoova\mi\core\classes\Res\Rescon;

/**
 * Contains Directive Commands for Res class
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
abstract class Rescom extends Rescon
{


  /**
   * apply directives to create files
   *
   * @param string $name type of file (e.g Frame, Model, Window, WinModel, Route, API e.t.c)
   * @param array|string $args argument supplied on command
   * @return string|false
   */
  static function mkFile(string $name, $args){
    $class = scheme('core\commands\Support\Make\Mk'.$name, false);
    if(class_exists($class)){
        $newclass = new $class($args);
        $build = $newclass->build();
        return $build;
    }else{
      trigger_error('Missing executable file: core/commands/Supoort/Make/Mk'.$name);
      return false;
    }
  }

}