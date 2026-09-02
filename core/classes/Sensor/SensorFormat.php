<?php

namespace spoova\mi\core\classes\Sensor;

use Exception;
use spoova\mi\core\classes\Sensor\AbstractSense;
use spoova\mi\core\classes\Sensor\SensorInterface;
use spoova\mi\core\tools\BytesConverter;

/**
 * Retrieves uniform information for device memory, cpu usage and *[Disk I/O (if available)] 
 * - Note, this package is built for spoova framework and requires spoova's GhostFunction inbuilt package for anonymous functions encapsulation.
 * @throws Exception If the OS is unsupported.
 */
class SensorFormat extends AbstractSense implements SensorInterface{

    /**
     * Defines the O.S Family class is built for
     *  - It is preferred to use the real O.S Family name (e.g Windows, Darwin, Linux)
     *
     * @return string|false
     */
    public function os_name() : string|false{
        return false;
    }
    
    public static function memory() : array {
        return [];
    }

    public static function disk_io() : array {
        
        return [];
    } 

    public static function cpu() : array {
        return [];
    } 
    
    public static function processes(int $bytes = 52428800) : array {
        return [];
    } 

}