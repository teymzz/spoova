<?php 

namespace spoova\mi\core\classes\Sensor;

interface SensorInterface { 

    public static function memory() : array ; 

    public static function disk_io() : array ; 

    public static function cpu() : array ; 
    
    public static function processes(int $bytes = 52428800) : array ; 

}