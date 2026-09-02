<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateTextField implements FabricatorInterface {

    /**
     * Generates random text data for TINYTEXT/MEDIUMTEXT field types
     *
     * @param int $minLength minimum character count (default 100)
     * @param int $maxLength maximum character count (default 2000)
     * @return string Random text
     */
    public static function fabricate(int $minLength = 100, int $maxLength = 2000) : string {
        
        $minLength = max(1, $minLength);
        $maxLength = max($minLength, $maxLength);
        
        $length = mt_rand($minLength, $maxLength);
        
        return self::generateLoremText($length);
    }

    private static function generateLoremText(int $length) : string {
        
        $words = [
            'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
            'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore',
            'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud', 'exercitation',
            'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo', 'consequat', 'duis'
        ];
        
        $text = '';
        while (strlen($text) < $length) {
            $text .= $words[array_rand($words)] . ' ';
        }
        
        return trim(substr($text, 0, $length));
    }

}
