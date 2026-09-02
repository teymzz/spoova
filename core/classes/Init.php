<?php 

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use Closure;

/**
 * This class is used to read the init configuration file keys from the 
 * "icore/init" directory. Note that defined values must contain non-space 
 * character to be considered a valid value.
 */
class Init {

    public const File = _icore.'init';
    private static ?Filemanager $Filemanager = null;
    private static $update = false;
    private static $init = [];

    /**
     * Updates previous init configuration and returns all configuation keys and values after update. 
     *
     * @return array
     */
    static function load() : array {

        self::setData(true);
        return self::$init;

    }

    /**
     * Return all previously read init configuration keys if it exists or new one if it does not already exist
     *
     * @return array
     */
    static function data() : array {

        if(!self::$init) self::setData(true); 

        return self::$init;

    }

    /**
     * Retrieve init file configuration key's value
     *   - Empty spaces that preceeds configuration value is usually trimmed before value is returned while empty spaces after value is retained.
     *   - Note that spaces are not considered as value unless a non-space character exists within the value retrieved. 
     *   - To get updated value after new change is made to init config file, consider using {@see Init::load()} first before calling this method.
     * @param string $key
     * @param mixed $alternate alternate value to be returned when $key is empty
     * @return string|false
     */
    static function key(string $key, string|false $alternate = false) : string|false {

        self::setData();
        self::$update = false;
        $value = self::$init[$key] ?? '';

        if(!isset(self::$init[$key])) return $alternate;
        return trim($value)? $value : $alternate;

    }

    /**
     * Retrieve init file configuration key's value
     *   - Left empty spaces of values are  before value is returned.
     *   - Note that spaces are not considered as value unless a non-space character exists within the value retrieved. 
     *   - To get updated value after new change is made to init config file, consider using {@see Init::load()} first before calling this method. 
     * @param string $key
     * @param Closure|null $modifier callback to modify the value to be returned when $key is empty
     * @return string|false
     */
    static function value(string $key, ?Closure $modifier = null) : string|false {

        self::setData();
        self::$update = false;
        
        $realValue = self::$init[$key] ?? false;
        if($realValue === false) return $modifier? $modifier(false) : false;
        $value = ($realValue !== false) ? $realValue : '';
        $value = trim($value)? $value : '';
        
        return $modifier? $modifier($value) : $value;

    }

    static function values() : array {
        self::$update = false;
        return self::$init;
    }

    private static function setData(bool $new = false) {
        if(empty(self::$init) || (!empty(self::$init) && self::$update) || $new){

            if(self::setFilemanager()){
                $Filemanager = self::$Filemanager;
                self::$init = $Filemanager->readAll(':');
            }

        }
    }

    /**
     * Sets a key and value into the icore/init configuration file
     *
     * @param string $key
     * @param string $value
     * @return bool true when $key is successfully set
     */
    public static function set(string $key , string $value) : bool {
        if(self::setFilemanager()){
            $Filemanager = self::$Filemanager;
            $Filemanager->textUpdate([$key => $value]);
            if($Filemanager->readFile($key) === $value){
                self::update();
                self::setData();
                return true;
            }
        }

        return false;
    }

    /**
     * Unsets a key from the icore/init configuration file
     *
     * @param string|array $key
     * @return string|array|false depending on the value supplied
     *  - false is returned if no key is deleted
     */
    public static function unset(string|array $key) : string|array|false {
        if(self::setFilemanager()){
            $Filemanager = self::$Filemanager;

            if($Filemanager->textDelete($key, $dels)){
                if(is_string($key)) {
                    return $key;
                }else if(is_array($key) && is_array($dels)){
                    return $dels;
                }
            }else{
                return false;
            }
        }

        return false;
    }

    /**
     * Update stored data
     *
     * @return void
     */
    public static function update() : void {
        self::$update = true;
    }

    /**
     * Set Filemanager
     *
     * @return boolean
     */
    private static function setFilemanager() : bool{
            $Filemanager = new Filemanager; 
            $open = $Filemanager->setUrl(self::File)->openFile(true);
            self::$Filemanager = $Filemanager;   
            return $open;    
    }

}