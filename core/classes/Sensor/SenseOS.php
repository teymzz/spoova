<?php

namespace spoova\mi\core\classes\Sensor;

use Exception;
use spoova\mi\core\tools\BytesConverter;
use spoova\mi\core\classes\Sensor\SensorFormat;

/**
 * Retrieves uniform information for device memory, cpu usage and *[Disk I/O (if available)] 
 * - Note, this package is built for spoova framework and requires spoova's GhostFunction inbuilt package for anonymous functions encapsulation.
 * @throws Exception If the OS is unsupported.
 */
class SenseOS extends SensorFormat{

    protected static array $message = [];
    protected static array $errors = [];

    /**
     * Defines the O.S Family class is built for
     *  - It is preferred to use the real O.S Family name (e.g Windows, Darwin, Linux)
     *
     * @return string|false
     */
    public function os_name() : string|false{
        return strtolower(PHP_OS_FAMILY);
    }

}