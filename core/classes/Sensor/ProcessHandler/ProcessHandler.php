<?php

namespace spoova\mi\core\classes\Sensor\ProcessHandler;

use spoova\mi\core\classes\Sensor\ProcessHandler\WinProcessHandler;
use spoova\mi\core\classes\Sensor\ProcessHandler\LinuxProcessHandler;
use spoova\mi\core\classes\Sensor\ProcessHandler\MacProcessHandler;
use spoova\mi\core\classes\Sensor\ProcessHandler\UnixGenericProcessHandler;
use spoova\mi\core\classes\Sensor\ProcessHandler\NullProcessHandler;

abstract class ProcessHandler {

    /**
     * Get user processes and returns array of ['pid','name','memory_kb','memory']
     *
     * @param string|null $sortBy optional [memory|name]
     * @param string $order sorting order optional [asc|desc]
     * @return array
     */
    abstract public function getProcesses(?string $sortBy = null, string $order = 'desc'): array;

    /**
     * Unified name: group processes returned by getProcesses()
     */
    abstract public function getAppsGrouped(): array;

    /**
     * Return apps that meet the high-memory criteria.
     *
     * @param int|null $minKb   minimum total memory in KB (null => no minimum)
     * @param int|null $top     top N results after filtering (null => no limit)
     * @param string $sortBy    'memory'|'name' (controls sort field)
     * @param string $order     'desc'|'asc'
     * @param string $userApps   TRUE fetches only user apps
     *  - Note: system processes ignored is heuristic on window O.S (i.e uses blacklist + small pid).
     * @return array
     */
    abstract public function getHighMemoryApps(?int $minKb = null, ?int $top = null, string $sortBy = 'memory', string $order = 'desc', bool $userApps = false): array;

    /** Return error info */
    abstract public function getError(): ?array;

    public static function factory(): ProcessHandler {
        return match (PHP_OS_FAMILY) {
            'Windows'          => new WinProcessHandler(),
            'Linux'            => new LinuxProcessHandler(),
            'Darwin'           => new MacProcessHandler(),          // macOS
            'BSD', 'Solaris'   => new UnixGenericProcessHandler(),  // *BSD / Solaris / illumos (ps-based)
            default            => new NullProcessHandler(),         // unknown: degrade, don't throw
        };
    }
}
