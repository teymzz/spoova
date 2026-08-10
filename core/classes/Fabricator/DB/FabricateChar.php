<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateChar implements FabricatorInterface {

    /**
     * Generates random CHAR data with exact fixed length
     * 
     * CHAR fields require fixed-length strings, so this pads with spaces if needed
     *
     * @param int $length exact field length in characters (default 10)
     * @return string Fixed-length alphanumeric string padded to exact length
     */
    public static function fabricate(int $length = 10) : string {
        
        $length = max(1, min($length, 255)); // MySQL CHAR max
        
        $string = self::generateRandomString($length);
        
        // Pad with spaces if necessary to match exact CHAR field length
        return str_pad($string, $length, ' ', STR_PAD_RIGHT);
    }

    private static function generateRandomString(int $length) : string {
        
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charCount = strlen($characters);
        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[mt_rand(0, $charCount - 1)];
        }
        
        return $result;
    }

}
