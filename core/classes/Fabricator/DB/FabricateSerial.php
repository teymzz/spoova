<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateSerial implements FabricatorInterface {

    private static int $counter = 0;

    /**
     * Generates auto-incrementing SERIAL value
     * 
     * Note: SERIAL is an auto-increment field. This generates sequential values
     * starting from 1. Reset counter with reset() method if needed.
     *
     * @param int $start starting value (default 1)
     * @return int Auto-incremented integer
     */
    public static function fabricate(int $start = 1) : int {
        
        if (self::$counter === 0) {
            self::$counter = $start;
        }
        
        return self::$counter++;
    }

    /**
     * Reset the SERIAL counter
     *
     * @return void
     */
    public static function reset() : void {
        self::$counter = 0;
    }

}
