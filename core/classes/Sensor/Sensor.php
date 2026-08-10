<?php

namespace spoova\mi\core\classes\Sensor;

use Error;
use Exception;
use Throwable;
use spoova\mi\core\classes\Sensor\SensorBase;
use spoova\mi\core\classes\Sensor\AbstractSense;
use spoova\mi\core\classes\Sensor\SenseUnknown;

/**
 * Retrieves uniform information for device memory, cpu usage and *[Disk I/O (if available)] 
 * - Note, this package is built for spoova framework and requires spoova's GhostFunction inbuilt package for anonymous functions encapsulation.
 * @throws Exception If the OS is unsupported.
 */
class Sensor extends SensorBase{
  
    private bool $initialized = false;

    final public function __construct()
    {
        if($this->initialized) return;

        $osName = Sensor::os_name();
        $sensorPath = $osName ? 'core/classes/Sensor/Sense'.$osName : false;

        try {
            if($sensorPath && appExists($sensorPath)){
                $sensorClass = scheme($sensorPath);
                $sensor = new $sensorClass($this);

                // Reject a package that does not match the resolved OS family;
                // fall back to the null sensor rather than throwing.
                if(!($sensor instanceof AbstractSense)
                    || $sensor->os_name() !== Sensor::os_name($sensor->os_name())){
                    $sensor = new SenseUnknown($this);
                }
            }else{
                // Unrecognised / unsupported OS family (e.g. BSD, Solaris, unknown):
                // degrade gracefully with a null sensor instead of a fatal error.
                $sensor = new SenseUnknown($this);
            }
        } catch (Throwable $e) {
            $sensor = new SenseUnknown($this);
        }

        $this->sensor = $sensor;
        $this->initialized = true;
    }

    /**
     * Creates the instance of the sensor class
     *
     * @return Sensor|mixed
     */
    public static function sense(?string $name = null) : mixed {
        $sensor = new self();
        if($name) {
            $name = str_replace('-','_', $name);
            if(method_exists($sensor, $name)){
                return $sensor->$name();
            }
            return false;
        }else{
            return $sensor;
        }
    }
  
}
