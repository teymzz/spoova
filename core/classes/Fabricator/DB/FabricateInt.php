<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateInt implements FabricatorInterface {

    /**
     * Database integer type limits
     * @var array
     */
    private static array $limits = [
        1 => [-128, 127],                              // TINYINT
        2 => [-32768, 32767],                          // SMALLINT
        3 => [-8388608, 8388607],                      // MEDIUMINT
        4 => [-2147483648, 2147483647],                // INT
        8 => [-9223372036854775808, 9223372036854775807], // BIGINT
    ];

    /**
     * Generates a random integer within database integer field limits
     * based on the specified length (byte size).
     *
     * @param int $length byte size of the integer field [1, 2, 3, 4, 8]
     *                    Defaults to 4 (INT) if invalid
     * @return int Random integer within the specified field limits
     */
    public static function fabricate(int $length = 4) : int {
        
        // Validate and normalize length to supported database field sizes
        if (!isset(self::$limits[$length])) {
            $length = 4; // Default to INT (4 bytes)
        }

        [$min, $max] = self::$limits[$length];

        // Generate random integer within the field's limits
        return random_int($min, $max);
    }

}
