<?php

namespace spoova\mi\core\classes\Sensor\ProcessHandler;

use spoova\mi\core\classes\Sensor\ProcessHandler\UnixProcessHandler;

/**
 * Generic Unix process handler for POSIX-like systems without a dedicated
 * subclass (e.g. *BSD, Solaris/illumos). Relies on the portable `ps` parsing
 * provided by {@see UnixProcessHandler}.
 */
class UnixGenericProcessHandler extends UnixProcessHandler {

}
