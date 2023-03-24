<?php

namespace spoova\mi\core\classes\DB;

use DBStatus;
use spoova\mi\core\classes\DB;

class DBPlugins {

    private static DB $dbc;
    private static DBHandler $dbh;
    private static ?DBPlugins $tthis = null;


    /**
     * Set the basic connection
     *
     * @param DB|null $dbc
     * @param DBHandler|null $dbh
     */
    function __construct(?DB $dbc = null, ?DBHandler $dbh = null)
    {
        if(func_num_args() === 0){
            self::$dbc = new DB();
            self::$dbh = self::$dbc->openDB();
        }elseif(func_num_args() === 1){
            self::$dbc = $dbc;
            self::$dbh = self::$dbc->openDB();
        }elseif(func_num_args() > 1){
            self::$dbc = $dbc;
            self::$dbh = $dbh;
        }
        self::$tthis = $this; 
    }

    /**
     * Fetches plugins from database
     *
     * @param array|string $plugin_name case sensitive plugin name (e.g partition, FEDERATED, ngram, BLACKHOLE, ARCHIVE, MyISAM, PERFORMANCE_SCHEMA, ...etc)
     * @param array|string $key case sensitive optional key (or array of keys). (e.g PLUGIN_STATUS, PLUGIN_TYPE, PLUGIN_VERSION, PLUGIN_DESCRIPTION, PLUGIN_LICENSE, ...etc)
     *  - when supplied, fetches the first index from a numeric series of multidimentional array
     * @return array|string|bool
     *  - array of all plugins and values are returned if no argument is supplied
     *  - array of specified plugin data are returned if only $plugin_name is supplied or $key is an array list
     *  - specified plugin corresponding data value is returned as string if $key is a string
     *  
     */
    static function get(string $plugin_name = '', array|string $key = '') : array|string {

        if(!self::$tthis){
            $tthis = new static;
        }else{
            $tthis = self::$tthis;
        }

        if(func_num_args() > 0){
    
            if($plugin_name){

                $values = (func_num_args() > 1)? implode(',', (array)$key) : '*'; 

                $sql = "SELECT {$values} FROM INFORMATION_SCHEMA.PLUGINS WHERE PLUGIN_NAME = ?";
    
                $tthis::$dbh->query($sql, [$plugin_name])->read();
        
                if(is_string($key)){
                    $result = $tthis::$dbh->results(0, $key);
                }else{
                    $result = ($tthis::$dbh->results(0));
                }
        
                return $result;
    
            }else{
    
                DBStatus::err('no name supplied for plugin in DBPlugins::get() method', true);
                return false;
            }

        }else{
            
            $sql = "SELECT * FROM INFORMATION_SCHEMA.PLUGINS";
            $tthis::$dbh->query($sql)->read();
        
            return ($tthis::$dbh->results());

        }

    }


}