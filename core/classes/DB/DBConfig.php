<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

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
    
    private static string|null $message = null;

    /**
     * For storing configurations defined in .env file.
     *
     * @var array|false
     */
    private static array|false $issued = false;

    public const env_path =  secure_env_path;
    
    /**
     * Load the entire contents of the dbconfig file
     *
     * @param string $file dbconfig file path
     * @param array $data referenced variable to contain
     * @return bool
     */
    static function load(string $file, &$data) : bool{
        self::$message = null;

        // error message defined if methods fail
        $online  = self::online($file);
        $offline = self::offline($file);

        $config['online'] = self::$issued ?: $online;
        $config['offline'] = $offline;
        $config['issued'] = self::$issued;

        $data = $config;
        return !isset(self::$message); // returns TRUE when no error message is detected.
    }

    /**
     * Returns error message, if any.
     *
     * @return string|null
     */
    static function response() : string|null {
        return self::$message;
    }

    /**
     * Return offline database parameters from config file 
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
     * Get online settings from config file
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
     * References database connection parameters from secured environment (.env) file. 
     *  - This env file should be outside the root of the application
     *
     * @param array|null $var
     * @param bool|string $path 
     *    - bool(true): uses secure_env_path 
     *    - bool(false): FALSE uses normal behavior (dbconfig.php)
     *    - string: uses custom $path defined by user.
     * @return void
     */
    static function safeguard(array|null &$var, bool|string $path = false) {
        // if DBPARAMS is secured or $path is TRUE, use secured paths
        // if DBPARAMS is secured && $path is FALSE, use secured paths
        // if DBPARAMS is not secured && $path is defined, use defined path
        // if not DBPARAMS is secured && $path is false, use normal dbconfig

        if(getenv('DBPARAMS') === 'SECURED'){
            if($path === true){
               $var = self::load_env_params(secure_env_path);
           }else if($path){
               $var = self::load_env_params($path);
           }
        }
    }

    /**
     * Load environment parameters only for database parameters.
     *
     * @param boolean $reload
     * @return array|null
     */
    public static function load_env_params($path, bool $reload = false) : array|null {

        $DBPARAMS = ['DBSOCKET','DBPORT','DBSERVER','DBUSER','DBPASS','DBNAME'];

        if(is_file($path) && ($reload || !self::$issued)) {
            Filemanager::putenv($path, $DBPARAMS); // stores into environment and populates to $_ENV, $_SERVER
        }

        foreach($DBPARAMS as $DBPARAM) $DBCONFIG[substr($DBPARAM, 2)] = getenv($DBPARAM) ?: '';;
        $DBCONFIG = $DBCONFIG ?? NULL;

        self::$issued = $DBCONFIG ?: [];

        return $DBCONFIG;

    }

    /**
     * Generate a dbconfig build type. 
     *  -    Array values serial order [NAME, USER, PASS, SERVER, PORT, SOCKET] 
     *
     * @param string $type optional [icore|core]
     * @param array $online online database parameters
     * @param array $offline offline database parameters
     * @return string
     *  - If invalid $type option is entered, an empty string is returned
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

        return '';

    }

}