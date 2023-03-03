<?php

namespace teymzz\spoova\core\classes;

/**
 * This class manages the dybamic DomUrl Name and Key Value Pairs
 */
class DomUrl {

    private static $keys = [];
    private static $Hash;
    private static $Name;

    /**
     * Generates a single one-way hash key on each supplied integer
     *
     * @param integer $int
     * @return string hash key of supplied integer
     */
    static function Hash() : string {

        if(!self::$Name){
            return EInfo::view('Domurl::Hash() cannot be called until name is defined!');
        }

        if(!isset(self::$keys[self::$Name])){
            self::$keys[self::$Name] = randice(4);
        }
        return self::$keys[self::$Name];
    }

    static function Name() {

        if(!self::$Name){
            $name = '::DOMURL-'.RANDICE('4', '0123456789').'::';
            self::$Name = $name; 
        }
        return self::$Name;     

    }


}