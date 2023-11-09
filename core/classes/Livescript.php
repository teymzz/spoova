<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\FileManager;

class Livescript {

    public const controller = _icore.'live'; 
    private static ?FileManager $Filemanager = null;

    private static function load() : bool {
        
        if(!self::$Filemanager){
            self::$Filemanager = new FileManager;
            self::$Filemanager->setUrl(self::controller);
            self::$Filemanager->separator(':');
        }
        
        $Filemanager = self::$Filemanager;

        return ($Filemanager->openFile(true));

    }

    public static function set($key, $value) : bool {

        if(self::load()){

            $key = strtoupper($key);

            $Filemanager = self::$Filemanager;
            $Filemanager->textUpdate([$key => $value]);
            
            return  $Filemanager->readFile($key) === $value;
        }
        
        return false;
        
    }

    public static function unset($key) : bool {

        if(self::load()){

            $key = strtoupper($key);

            $Filemanager = self::$Filemanager;
            return $Filemanager->textDelete($key);

        }
        
        return false;

    }

    public static function key($key) : string|false {

        
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
     * @return string|false
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


}