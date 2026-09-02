<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class Livescript {

    public const controller = _icore.'live.config'; 
    private static ?Filemanager $Filemanager = null;
    private static string $message = '';

    private static function load() : bool {

        self::$message = '';
        
        if(!self::$Filemanager){
            self::$Filemanager = new Filemanager;
            self::$Filemanager->setUrl(self::controller);
            self::$Filemanager->separator(':');
            $Filemanager = self::$Filemanager;
            $loaded = ($Filemanager->openFile(true));
            
            if(!$loaded) self::$message = 'file missing ('.$Filemanager->response().')';
        }else{
            $Filemanager = self::$Filemanager;
            $loaded = ($Filemanager->openFile(true));
        }

        return $loaded;

    }

    public static function loaded() : bool {
        return self::load();
    }

    public static function set(string $key, string $value) : bool {

        if(self::load()){

            $key = strtoupper($key);

            $Filemanager = self::$Filemanager;
            $Filemanager->textUpdate([$key => $value]);
            
            $valid = $Filemanager->readFile($key) === $value;

            if(!$valid) self::$message = 'value mismatch';

            return $valid;
        }
        
        return false;
        
    }

    public static function unset(string $key) : bool {

        if(self::load()){

            $key = strtoupper($key);

            $Filemanager = self::$Filemanager;
            $removed = $Filemanager->textDelete($key);

            if(!$removed) self::$message = 'value not deleted';

            return $removed;

        }
        
        return false;

    }

    /**
     * Returns the live server key's relative value
     *
     * @param string $key key to be fetched
     * @return string|false
     *  - false is automatically returned if the live config file cannot be loaded 
     */
    public static function key(string $key) : string|false {

        
        if(self::load()){

            $key = strtoupper($key);

            $Filemanager = self::$Filemanager;
            return $Filemanager->readFile($key);

        }
        
        return false;

    }

    /**
     * Return all or specific lie server keys
     *
     * @param array $keys list of keys to be fetched
     * @return array
     */
    public static function keys(array $keys = []) : array {

        if(self::load()){

            $Filemanager = self::$Filemanager;
            
            if(func_num_args() === 0) {
                return $Filemanager->readAll(':') ?: [];
            }else{
                $keys = array_map(fn($val) => strtoupper($val), $keys);
                return $Filemanager->readFile($keys, ':') ?: [];
            }

        }

        return [];

    }

    /**
     * Returns the text received when error occurs
     *
     * @return string
     */
    public static function message() : string {
        return self::$message;
    }


}