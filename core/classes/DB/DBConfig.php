<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\FileManager;

/**
 * @author Akinola Saheed <github teymzz>
 * 
 * This class was specifically 
 * created to load the dbconfig.php file structure
 * Any alteration to file code structure will structure will
 * result to an error as the class will not be able to read the file
 * 
 * The data returned is an array of offline and online configurations
 * 
 * This class handles session management, 
 * configurations and control pattern
 */
class DBConfig{
    
    private static $message;
    
    /**
     * Load the entire contents of the init file
     *
     * @param string $url init file url
     * @param array $data referenced variable to contain
     * @return bool
     */
    static function load(string $url, &$data) : bool{

        $FileManager = new FileManager;

        if(!$FileManager->openFile('', $url)){
            self::$message = 'file cannot be accessed';
            return false;
        } 

        $contents = FileManager::load($url, "=");
        $config = [];
        
        foreach($contents as $configKey => $value){

            $key = str_replace(['$_DBCONFIG[', "'",'"', "]"], '', $configKey);

            $exp = explode(":", rtrim($value, "; "), 2);

            $exp1 = $exp[0]?? '';
            $exp2 = $exp[1]?? '';

            $online = str_replace(['(online)?',"'"], '', $exp1);
            $offline = str_replace(['(online)?',"'"], '', $exp2);

            $config['online'][$key] = $online;
            $config['offline'][$key] = $offline;

        }

        $data = $config;
        return true;
    }

    static function response() {
        return self::$message;
    }


}