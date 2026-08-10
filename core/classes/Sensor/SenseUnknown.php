<?php

namespace spoova\mi\core\classes\Sensor;

use spoova\mi\core\classes\Sensor\SenseOS;
use spoova\mi\core\classes\Sensor\Sensor;

/**
 * Null-object sensor used when the host operating system family is not
 * recognised/supported (e.g. BSD, Solaris or an unknown PHP_OS_FAMILY).
 *
 * Every metric returns an empty array so the application degrades gracefully
 * instead of throwing during page metrics. See {@see Sensor::__construct()}.
 */
class SenseUnknown extends SenseOS {

    protected static array $message = [];
    protected static array $errors = [];

    /**
     * Report the same family the Sensor resolved (or false when unresolved) so
     * the AbstractSense OS-match guard always passes for this fallback.
     */
    public function os_name() : string|false {
        return Sensor::os_name();
    }

    public static function memory() : array { return []; }

    public static function disk_io() : array { return []; }

    public static function cpu() : array { return []; }

    public static function processes(int $bytes = 52428800) : array { return []; }

}
