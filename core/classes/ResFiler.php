<?php

/**
 * Directive Commands for Res class
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
class ResFiler
{

    static function mkFile($name, $args){
        $class = scheme('core\commands\Make\Mk'.$name);
        if(class_exists($class)){
            new $class($args);
        }
    }

}