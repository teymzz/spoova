<?php 

namespace spoova\mi\core\classes;

/**
 * This class is used to read the init configuration file keys from the 
 * icore/init directory.
 */
class Init {

    private static $update = false;
    private static $init = [];

    static function key($key) : string|false {

        self::setData();
        self::$update = false;
        return self::$init[$key] ?? false;

    }

    /**
     * Get entire key and value pairs from the init file.
     *
     * @return array
     */
    static function values() : array {
        
        self::$update = false;
        return self::$init;
    }

    private static function setData() {
        if(empty(self::$init) || (!empty(self::$init) && self::$update)){

            $Filemanager = new FileManager; 
            $initFile    = _icore.'init';

            $Filemanager->setUrl($initFile)->openFile($initFile);

            self::$init = $Filemanager->readAll(':');

        }
    }

    /**
     * This method is used to force the init file to re-read from the init file 
     * after an initial read. If required, it must be called before any other public method.
     *
     * @return void
     */
    public static function update() : void {
        self::$update = true;
    }

}