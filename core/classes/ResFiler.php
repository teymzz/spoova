<?php

/**
 * Directive Commands for Res class
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 * @package spoova\core\classes
 */
class ResFiler
{

    static function mkFile($name, $args){
        $class = 'spoova\core\commands\Make\Mk'.$name;
        if(class_exists($class)){
            new $class($args);
        }
    }

}