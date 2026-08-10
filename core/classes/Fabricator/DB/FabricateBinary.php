<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateBinary implements FabricatorInterface {

    /**
     * Generates random binary data for BINARY field type
     *
     * @param int $length number of bytes to generate (default 10)
     * @return string Binary data as a hexadecimal string
     */
    public static function fabricate(int $length = 10) : string {
        
        $length = max(1, min($length, 255)); // Ensure within valid range
        
        $binaryData = random_bytes($length);
        return bin2hex($binaryData);
    }

}
