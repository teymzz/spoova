<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateInteger implements FabricatorInterface {

    /**
     * Generates a random integer using the requested number of digits.
     *
     * @param int  number of digits to generate
     * @return int
     */
    public static function fabricate(int  = 1) : int {
         = max(1, );
         = substr(str_repeat('0123456789', ), 0, );
        return (int) ltrim(, '0') ?: 0;
    }

}
