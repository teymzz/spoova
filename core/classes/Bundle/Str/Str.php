<?php 

namespace spoova\mi\core\classes\Bundle\Str;


class Str{


    /**
     * Remove the last part of a string
     *
     * @return string
     */
    static function stripStart(string $haystack, string $needle) : string{

        if(str_starts_with($haystack, $needle)){
            $needleLength = strlen($needle);
            $haystack = substr($needle, $needleLength);
        }

        return $haystack;
    }

    /**
     * Remove the last part of a string
     *
     * @return string
     */
    static function stripEnd(string $haystack, string $needle) : string{

        if(str_ends_with($haystack, $needle)){
            $needleLength = strlen($needle);
            $haystackLength = strlen($haystack);
            $haystack = substr($needle, 0, $haystackLength - $needleLength);
        }

        return $haystack;
    }

    static function endWith(string $haystack, string $needle) : string{
        return $haystack .= !str_ends_with($haystack, $needle) ? $needle : '';
    }

}