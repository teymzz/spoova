<?php 

namespace spoova\mi\core\commands\Root\Cli;

class CliRuntime {

    public static array $runtime = [];

    /**
     * Undocumented function
     *
     * @param string|null &$name
     * @return string
     */
    public static function start(?string &$name = null) : string {
        // start runtime
        $name = ($name === null)? randice() : $name;
        self::$runtime[$name] = microtime(true);
        return $name;
    }

    /**
     * The total amount of time in seconds before a command terminates execute.
     *
     * @param string $name
     * @return float
     */
    public static function duration(string $name) : float {
        // start runtime
        $stopTime = microtime(true);
        $initTime = self::$runtime[$name] ?? $stopTime;
        return round(abs($initTime - $stopTime), 3);
    }

}