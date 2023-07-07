<?php

namespace spoova\mi\core\classes\DB;

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
     * Load the entire contents of the dbconfig file
     *
     * @param string $file dbconfig file path
     * @param array $data referenced variable to contain
     * @return bool
     */
    static function load(string $file, &$data) : bool{

        self::$message = null;
        $online  = self::online($file);
        $offline = self::offline($file);

        $config['online'] = $online;
        $config['offline'] = $offline;

        $data = $config;
        return !isset(self::$message);
    }

    /**
     * Returns error message, if any.
     *
     * @return void
     */
    static function response() {
        return self::$message;
    }

    /**
     * Return offline database parameters from init file 
     *
     * @param string $file dbconfig file path
     * @return array
     */
    static function offline(string $file) : array {
        if(is_file($file)){
            $status = !($_ENV['online'] ?? false);
            $_ENV['online'] = false;
            include ($file);
            $config = $_DBCONFIG ?? [];
            $_ENV['online'] = $status;
            return $config;
        }else{
            self::$message = 'file cannot be accessed';
        }
        return [];
    }

    /**
     * Get offline settings from init file
     *
     * @param string $file dbconfig file path
     * @return array
     */
    static function online(string $file){
        if(is_file($file)){
            $status = $_ENV['online'] ?? false;
            $_ENV['online'] = true;
            include_once($file);
            $config = $_DBCONFIG ?? [];
            $_ENV['online'] = $status;
            return $config;
        }else{
            self::$message = 'file cannot be accessed';
        }
        return [];
    }

    /**
     * Generate a dbconfig build type. 
     *  -    Array values serial order [NAME, USER, PASS, SERVER, PORT, SOCKET] 
     *
     * @param string $type  optional [icore|core]
     * @param array $online offline database parameters
     * @param array $offline online database parameters
     * @return string
     */
    static function build(string $type, array $online, array $offline) : string {

        if($type === 'icore'){
            return <<<CONFIG
            <?php
            
             // custom db configuration files for online and offline  

             \$_DBCONFIG['SOCKET']  = \$_ENV['online']? '$online[5]' : '$offline[5]';
             \$_DBCONFIG['PORT']    = \$_ENV['online']? '$online[4]' : '$offline[4]';
             \$_DBCONFIG['SERVER']  = \$_ENV['online']? '$online[3]' : '$offline[3]';
             \$_DBCONFIG['USER']    = \$_ENV['online']? '$online[1]' : '$offline[1]';
             \$_DBCONFIG['PASS']    = \$_ENV['online']? '$online[2]' : '$offline[2]';	
             \$_DBCONFIG['NAME']    = \$_ENV['online']? '$online[0]' : '$offline[0]';
            CONFIG;
        }elseif($type === 'core'){
            return <<<CONFIG
            <?php

             require_once \'secure.php\'; //secure file
            
             // default db configuration files for online and offline  

             \$_DBSOCKET  = \$_ENV['online']? '$online[5]' : '$offline[5]';
             \$_DBPORT    = \$_ENV['online']? '$online[4]' : '$offline[4]';
             \$_DBSERVER  = \$_ENV['online']? '$online[3]' : '$offline[3]';
             \$_DBUSER    = \$_ENV['online']? '$online[1]' : '$offline[1]';
             \$_DBPASS    = \$_ENV['online']? '$online[2]' : '$offline[2]';	
             \$_DBNAME    = \$_ENV['online']? '$online[0]' : '$offline[0]';

             // NOTE: This file should not be edited or used for connection, override with custom dbconfig in "icore" directory.           
            CONFIG;
        }

    }

}