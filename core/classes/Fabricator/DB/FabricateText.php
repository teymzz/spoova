<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateText implements FabricatorInterface {

    /**
     * Generates random text data for TEXT field type
     *
     * @param int $minLength minimum character count (default 50)
     * @param int $maxLength maximum character count (default 500)
     * @return string Random text
     */
    public static function fabricate(int $minLength = 50, int $maxLength = 500) : string {
        
        $minLength = max(1, $minLength);
        $maxLength = max($minLength, $maxLength);
        
        $length = mt_rand($minLength, $maxLength);
        
        return self::generateLoremText($length);
    }

    private static function generateLoremText(int $length) : string {
        
        $words = [
            'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
            'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore',
            'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud', 'exercitation'
        ];
        
        $text = '';
        while (strlen($text) < $length) {
            $text .= $words[array_rand($words)] . ' ';
        }
        
        return trim(substr($text, 0, $length));
    }

}
