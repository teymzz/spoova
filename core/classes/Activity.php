<?php 

namespace spoova\mi\core\classes;

use DateTime;
use DBStatus;
use Error;
use spoova\mi\core\classes\DB\DBSeed;
use Window;

/**
 * This class is designed for checking the total runtime for which an activity 
 * or process is executed.
 */
class Activity {

    private static array $start = [];
    private static array $tests = [];
    private static array $activities = [];

    private function __construct(){}

    /**
     * Initializes a starting time before a process is loaded
     *
     * @param string $name defines a unique access name for the activity or process to be executed
     * @return void
     */
    public static function bench(string $name = docBase){
        if(isset(self::$start[$name])){
            throw new Error('Ambiguous Activity::bench name "'.$name.'" detected within the application. Consider using a different unique name');
        }
        self::$start[$name] = hrtime(true);
    }

    /**
     * Creates a stop point and returns the total runtime expended for the specified executed process.
     *  - Returns a previously saved runtime data or creates a new one if none is found
     * @param string $name unique access name for a started process 
     * @return array
     */
    public static function data(string $name = docBase) : array {
        if(self::$tests[$name] ?? []) return self::$tests[$name];
        self::end_activity($name);
        $tests = self::$tests[$name] ?? []; 
        self::$activities[$name] = $tests; 
        return $tests;
    }

    /**
     * Creates a stop point and returns the total runtime expended for the specified executed process.
     *  - Generates, saves and return a new runtime data 
     *
     * @param string $name unique access name for a started process 
     * @return array
     */
    public static function benched(string $name = docBase) : array {
        self::end_activity($name);
        $tests = self::$tests[$name] ?? []; 
        self::$activities[$name] = $tests; 
        return $tests;
    }

    /**
     * Returns all saved activities
     *
     * @return void
     */
    public static function map(){
        return array_values(self::$activities); 
    }

    private static function end_activity(string $name){

        if(!isset(self::$start[$name])){
            throw new Error('No Activity::bench("'.$name.'") was started, so there is no point to measure from. Call Activity::bench() before reading its runtime.');
        }

        $start = self::$start[$name];
        $stop = hrtime(true);
        $diff = ($stop - $start) / 1e9;

        // rounded rather than formatted: number_format() returns a string, and a
        // runtime of a thousand seconds or more carries a thousands separator that
        // silently truncates on the arithmetic below
        self::$tests[$name]['timeframe']  = round($diff, 4);
        self::$tests[$name]['runtime']  = round($diff, 2).'secs';
    }


}