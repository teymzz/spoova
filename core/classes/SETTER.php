<?php

namespace spoova\mi\core\classes;

use Closure;
use ValueError;

/**
 * This class is only applied on DBWhere
 */
class SETTER {

    const CLOSE = '##_SETTERCLOSE_##';
    const LOCK  = true;

    /**
     * Contains keys and value pairs
     *
     * @var array
     */
    private static $vars = [];

    /**
     * Contains locked keys and lock value (hash)
     *
     * @var array
     */
    private static $locked = [];
    private static $searchables = [];
    private static $searchID = false;
    private static $lock;

    /**
     * Set static values which can be called before SETTER::CLOSE() method is called.
     * 
     * @param string $key key to which a value is expected to be assigned
     * @param mixed $value value to be assigned to a key
     * @param string|float|int|bool|array|object $lock defines key protection
     *   - if $lock is ```TRUE```, $key cannot be modified or unset
     *   - if $lock is ```string|float|int|array|object```, $key cannot be modified or unset unless $lock is supplied
     * @return void|false 
     */
    static function SET(string $key, $value, string|float|int|bool|array|object $lock = false){

        if($key === self::CLOSE){
            return self::CLOSE();
        }

        if(isset(self::$vars[$key])) {
            return EInfo::view("SET('{$key}'): \"{$key}\" cannot be updated using SET consider using MOD instead.");
        }

        if(array_key_exists($key, self::$locked)) {
            return EInfo::view("SET('{$key}'): \"{$key}\" is a locked value and cannot be reset or remodified.");
        }

        self::$vars[$key] = $value;

        if(is_string($lock) && trim($lock)){
            self::$locked[$key] = $lock;
            self::$lock = $lock;
            return self::$searchID;
        }elseif(!is_string($lock) && ($lock !== false)){
            self::$locked[$key] = $lock;
            self::$lock = $lock;
            return self::$searchID;
        }
    }

    /**
     * To be used for setting keys whose locks are less secure
     * 
     * @param Closure $set closure that must return the id issued by this call.
     *   - a mismatch raises a ValueError, which is what keeps the method from being
     *     used outside its intended call sequence
     * @return void|false
     */
    static function SEARCHABLE(Closure $set){
        self::$searchID = mt_rand(1,1000);
        $searchID = $set();
        if(self::$searchID !== $searchID) throw new ValueError('conflicting closure id handshake cause by invalid method usage.');
        self::$searchables[] = self::$lock;
    }


    /**
     * Obtain the key of an object.
     *  - Only available for objects.
     * 
     * @param object $value searchable object that exists in the lockers library
     * @return mixed
     */
    static function SEARCH(object $value) : mixed {
        if(in_array($value, self::$searchables)){
            $key = array_search($value, self::$locked);
            return  self::$vars[$key];
        }
        return false;
    }

    /**
     * Modifies value of existing key
     * 
     * @param string $key - key whose value is to be modified
     * @param mixed $value - new value to be stored in key
     * @param string|float|int|array|object $secureKey - a secure non-bool hash key for secured values
     * 
     * @return void|false
     */
    static function MOD(string $key, $value, string|float|int|array|object $secureKey = ''){

        if($key === self::CLOSE){
            self::$vars = [];
            return ;
        }
        
        if(array_key_exists($key, self::$locked)) {
            $hashKey = self::$locked[$key];
            if($hashKey === true || is_object($hashKey)){
                return EInfo::view("MOD('{$key}'): \"$key\" is a locked value and cannot be reset or remodified.");
            }else{
                $isSecured = true;
                if($hashKey !== $secureKey){
                    return EInfo::view("MOD('{$key}'): \"$key\" is a locked value and cannot be reset or remodified without its secure hash key.");
                }
            }
        }

        if(isset(self::$vars[$key])) {
            if(!($isSecured??false) && $secureKey){
                EInfo::view("MOD('{$key}'): \"$key\" is not a secured value that requires a modifier hash key.");
            }
            self::$vars[$key] = $value;
            return ;
        }


        return EInfo::view("MOD('{$key}'): \"$key\" cannot be initialized using MOD consider setting key ({$key}) first.");

    }

    /**
     * Get static values stored before SETTER::CLOSE() method is called.
     * 
     * @param string $key - DBSetter constants
     * @param string $secureKey - secure key for fetching previously stored secure value
     * @return string|false 
     */
    static function GET(string $key, mixed $secureKey = ''){

      if(isset(self::$vars[$key])){
        $hashKey = self::$locked[$key]?? '';
        if($hashKey && !is_bool($hashKey)){
            if($hashKey !== $secureKey) return EInfo::view("GET('{$key}'): \"$key\" cannot be fetched without its valid secure hash key");
            $isSecured = true;
        } 
        if(!($isSecured??false) && $secureKey){
            EInfo::view("GET('{$key}'): \"$key\" is not a secured value that requires a fetcher hash key.");
        }       

        return self::$vars[$key];
      }
      
      return EInfo::view("GET('{$key}'): \"$key\" cannot be fetched because it does not exist.");

    }

    /**
     * Check if a key exists
     * 
     * @param string $key - key to be checked
     * @return boolean 
     */
    static function EXISTS(string $key) : bool {

        return isset(self::$vars[$key]);

    }

    /**
     * Returns all detected keys
     * 
     * @return array 
     */
    static function KEYS() : array {

        return array_keys(self::$vars);

    }

    /**
     * Unset all declared keys.
     *  - Warning, this will unset all declared keys.
     * @return void 
     */
    static function CLOSE() {

        self::$vars = [];

    }

}
