<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateBlob implements FabricatorInterface {

    /**
     * Generates random binary large object data for BLOB field type
     *
     * @param int $length size in bytes (default 1024 - 1KB)
     * @return string Binary data as hexadecimal string
     */
    public static function fabricate(int $length = 1024) : string {
        
        $maxLength = 65535; // Max for BLOB in most databases
        $length = max(1, min($length, $maxLength));
        
        $binaryData = random_bytes($length);
        return bin2hex($binaryData);
    }

}
