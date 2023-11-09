<?php 

namespace spoova\mi\core\classes;

/**
 * This class is used to read the init configuration file keys from the 
 * icore/init directory.
 */
class Init {

    public const File = _icore.'init';
    private static ?FileManager $Filemanager = null;
    private static $update = false;
    private static $init = [];

    /**
     * Retrieve init file configuration key's value
     *   - Left empty spaces of values are  before value is returned.
     * @param string $key
     * @param mixed $alternate alternate value to be returned when $key is empty
     * @return string|false
     */
    static function key(string $key, $alternate = false) : string|false {

        self::setData();
        self::$update = false;
        $value = self::$init[$key] ?? '';

        return trim($value)? $value : $alternate;

    }

    static function values() : array {
        
        self::$update = false;
        return self::$init;
    }

    private static function setData() {
        if(empty(self::$init) || (!empty(self::$init) && self::$update)){

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
     * @param string $value
     * @return string|array|false depending on the value supplied
     *  - false is returned if no key is deleted
     */
    public static function unset(string|array $key) : string|array|false {
        if(self::setFilemanager()){
            $Filemanager = self::$Filemanager;

            if($Filemanager->textDelete($key, $dels)){
                if(is_string($key)) {
                    return $key;
                }else if(is_array($key)){
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
            $Filemanager = new FileManager; 
            $open = $Filemanager->setUrl(self::File)->openFile(true);
            self::$Filemanager = $Filemanager;   
            return $open;    
    }

}