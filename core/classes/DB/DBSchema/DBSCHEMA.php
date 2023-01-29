<?php  

namespace spoova\core\classes\DB\DBSchema;

use Closure;
use DBStatus;
use spoova\core\classes\DB;
use spoova\core\classes\DB\DBHandler;
use spoova\core\commands\Cli;

class DBSCHEMA {

    private static $DRAFT_SQL = '';

    /**
     * Create a new database table
     *
     * @param string|object $TABLE table name or object that implements a table() method that returns a table name 
     * @param Closure $FORMAT
     * @return boolean
     */
    static function CREATE(string|object $TABLE, Closure $FORMAT) : bool{

        $DRAFT = new DRAFT('CREATE');
        $STRUCTURE = $FORMAT($DRAFT);
        
        if(self::GET_DRAFT($TABLE, $NAME, $STRUCTURE)){
            self::DBCONNECT($dbc, $db);

            $DRAFT = $STRUCTURE::BUILD($NAME);

            if(!DRAFT::hasError()){
                $db->query($DRAFT);

                if(!$db->process()){ 
                    self::$DRAFT_SQL = (Cli::warn('DRAFT:', '|1').$DRAFT);
                    return false;
                }else{
                    return true;
                }      
            }
      
        }

        return false;

    }

    static function DROP_TABLE(string|object $TABLE) : bool{

        if(self::GET_DRAFT($TABLE, $NAME)){ 
            if(!DRAFT::hasError()){
                self::DBCONNECT($dbc, $db);
                return $db->drop($NAME, true);
            }
        }
        return false;

    }

    // static function ADD_FIELD(string|object $TABLE, Closure $FORMAT) : bool{

    //     $DRAFT = new DRAFT('ALTER');

    //     $STRUCTURE = $FORMAT($DRAFT);

    //     if(self::GET_DRAFT($TABLE, $NAME, $STRUCTURE)){
    //         if(!DRAFT::hasError()){
    //             self::DBCONNECT($dbc, $db);
    //             if($STRUCTURE instanceof DRAFT){
                    
    //                 self::DBCONNECT($dbc, $db);

    //                 $DRAFT = $STRUCTURE::BUILD($NAME);

    //                 $db->query($DRAFT);

    //                 if(!$db->process()){ 
    //                     Cli::textView(Cli::error($db->error()), 0, '|2');
    //                     Cli::textView(Cli::warn('DRAFT:', '|1').$DRAFT, 0, '|2');
    //                     return false;
    //                 }else{
    //                     return true;
    //                 }

    //             }else{
    //                 Cli::textView(Cli::error('Schema must a draft object'), 0, '|2');
    //                 return false;
    //             }

    //             return $db->drop($NAME, true);    
    //         }        
    //     }

    //     return false;

    // }

    static function DROP_FIELD(string|object $TABLE, string $FIELD){

        if(self::GET_DRAFT($TABLE, $NAME)){
            if(!DRAFT::hasError()){
                self::DBCONNECT($dbc, $db);
        
                return $db->drop($NAME, $FIELD);
            }
        }
        return false;
    }

    static function ALTER(string|object $TABLE, Closure $FORMAT) : bool {

        $DRAFT = new DRAFT('ALTER');
        $STRUCTURE = $FORMAT($DRAFT);

        if(self::GET_DRAFT($TABLE, $NAME, $STRUCTURE)){
            if(!DRAFT::hasError()){
                self::DBCONNECT($dbc, $db);
                $DRAFT = $STRUCTURE::BUILD($NAME);
        
                $db->query($DRAFT);
        
                if(!$db->process()){ 
                    //Cli::textView(Cli::error($db->error()), 0, '|2');
                    //Cli::textView(Cli::warn('DRAFT:', '|1').$DRAFT, 0, '|2');
                    self::$DRAFT_SQL = (Cli::warn('DRAFT:', '|1').$DRAFT);
                    return false;
                }else{
                    return true;
                }
            }
        }

        return false;
        
    }

    /**
     * setup a new database connection
     *
     */
    private static function DBCONNECT(?DB &$dbc = null, ?DBHandler &$db = null){
       
        $db = ($dbc = new DB())->openDB(); 
 
        if(!$db){
            Cli::textView(Cli::error('database connection failed!'), 0, '|2');
            Cli::textView(Cli::danger(DBStatus::err()), 0, '|2');
            exit();
        }

        return $db;

    }

    /**
     * get the current name from value supplied
     *
     * @return string table name
     */
    /**
     * Get the current name from value supplied
     *
     * @param string|object $TABLE
     * @param string|null $NAME references the name of the table
     * @param DRAFT|NULL $STRUCTURE
     * @return bool
     */
    private static function GET_DRAFT(string|object $TABLE,  string|null &$NAME, DRAFT|NULL &$STRUCTURE = NULL) : bool {

        if(is_object($TABLE)){
            if(method_exists($TABLE, 'table')){
                $TABLE = $TABLE->table();
                if(!is_string($TABLE)){
                    Cli::textView(Cli::error('Schema "table" must be a string'), 0, '|2');         
                   return false;
                }
            }else{
              
                Cli::textView(Cli::error('Schema object does not contain a "table" method!'), 0, '|2');
                return false;
            }
        }

        //proceed to get the draft structure
        if(func_num_args() > 2){
            if(!($STRUCTURE instanceof DRAFT)){
                Cli::textView(Cli::error('Schema must be a draft object'), 0, '|2');
                return false;
            }
        }

        $NAME = strtolower($TABLE);
        return true;

    }

    /**
     * Return a the sql query
     *
     * @return string
     */
    public static function DRAFT_SQL() : string {

        return self::$DRAFT_SQL;

    }

}