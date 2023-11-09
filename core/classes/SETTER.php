<?php

namespace spoova\mi\core\classes;

/**
 * This class is only applied on DBWhere
 */
class SETTER {


    const CLOSE = '##_SETTERCLOSE_##';
    const LOCK  = true;
    private static $vars = [];
    private static $locked = [];

    /**
     * Set static values which can be called before SETTER::CLOSE() method is called.
     * 
     * @param string $key key to which a value is expected to be assigned
     * @param mixed $value value to be assigned to a key
     * @param bool|string defines key protection
     *   - if $lock is [true], $key cannot be modified or unset
     *   - if $lock is {string}, $key cannot be modified or unset unless $lock string is supplied
     * @return void|false 
     */
    static function SET(string $key, $value, bool|string $lock = false){

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

        if($lock === true) {
            self::$locked[$key] = true;
        }elseif(!is_bool($lock) && trim($lock)){
            self::$locked[$key] = $lock;
        }

    }

    /**
     * Set operational tables
     * 
     * @param string $value - DBSetter constants
     *   -when value is DBWhereSetter::TABLE default table is set
     *   -when value is DBWhereSetter::PREFIX sql prefix is set
     *   -when value is DBWhereSetter::SUFFIX sql suffix is set
     * @return void|false
     */
    static function MOD(string $key, $value, $secureKey = ''){

        if($key === self::CLOSE){
            self::$vars = [];
            return ;
        }
        
        if(array_key_exists($key, self::$locked)) {
            $hashKey = self::$locked[$key];
            if($hashKey === true){
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
     * @param string $value - DBSetter constants
     * @param string $secureKey - secure key for fetching previously stored secure value
     * @return string|false 
     */
    static function GET(string $key, string $secureKey = ''){

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
     * @param string $value - DBSetter constants
     * @return boolean 
     */
    static function EXISTS(string $key) : bool {

        return isset(self::$vars[$key]);

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
