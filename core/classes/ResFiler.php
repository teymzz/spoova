<?php

/**
 * Directive Commands for Res class
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class ResFiler
{

    static function mkFile(string $name, array|string $args){
        $class = scheme('core\commands\Make\Mk'.$name);
        if(class_exists($class)){
            new $class($args);
        }
    }

}