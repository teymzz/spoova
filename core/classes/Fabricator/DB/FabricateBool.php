<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateBool implements FabricatorInterface {

    /**
     * Generates a random boolean value for BOOLEAN/TINYINT field type
     *
     * @param bool|null $bias optional bias for true/false [null=50%, true=favors true, false=favors false]
     * @return int Boolean as integer (0 or 1)
     */
    public static function fabricate(bool|null $bias = null) : int {
        
        if ($bias === true) {
            return mt_rand(0, 100) > 30 ? 1 : 0;
        } elseif ($bias === false) {
            return mt_rand(0, 100) < 30 ? 1 : 0;
        }
        
        return mt_rand(0, 1);
    }

}
