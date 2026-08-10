<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateVarchar implements FabricatorInterface {

    /**
     * Generates random VARCHAR data within field length constraints
     *
     * @param int $maxLength maximum field length in characters (default 255)
     * @param int $minLength minimum character count to generate (default 5)
     * @return string Random alphanumeric string
     */
    public static function fabricate(int $maxLength = 255, int $minLength = 5) : string {
        
        $maxLength = max(1, min($maxLength, 65535)); // MySQL VARCHAR max
        $minLength = max(1, min($minLength, $maxLength));
        
        $length = mt_rand($minLength, $maxLength);
        
        return self::generateRandomString($length);
    }

    private static function generateRandomString(int $length) : string {
        
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
        $charCount = strlen($characters);
        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[mt_rand(0, $charCount - 1)];
        }
        
        return $result;
    }

}
