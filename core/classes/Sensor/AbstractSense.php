<?php 

namespace spoova\mi\core\classes\Sensor;

use Error;
use spoova\mi\core\classes\Sensor\Sensor;

abstract class AbstractSense {

    protected Sensor $sensor;

    final public function __construct(Sensor $sensor)
    {
        if($sensor->os_name() !== $sensor->os_name($this->os_name())){
            throw new Error('conflicting or unsupported O.S family {'.PHP_OS_FAMILY.'}');
        }
        $this->sensor = $sensor;
    }

    /**
     * Defines the O.S Family class is built for
     *  - It is preferred to use the real O.S Family name (e.g Windows, Darwin, Linux)
     *
     * @return string|false
     */
    abstract public function os_name() : string|false;

}