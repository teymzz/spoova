<?php  

namespace spoova\core\classes\DB\DBSchema;

use Closure;
use DBStatus;
use spoova\core\classes\DB;
use spoova\core\classes\DB\DBHandler;
use spoova\core\commands\Cli;

class DBSCHEMA {

    private static $DRAFT_SQL = '';
    private static $DRAFT_TABLE = '';
    private static DRAFT $DRAFT;

    /**
     * Create a new database table
     *
     * @param string|object $TABLE table name or object that implements a table() method that returns a table name 
     * @param Closure $FORMAT
     * @return boolean
     */
    static function CREATE(string|object $TABLE, Closure $FORMAT) : bool{

        self::SET_TABLE($TABLE);
        $DRAFT = self::$DRAFT = new DRAFT('CREATE');
        $STRUCTURE = $FORMAT($DRAFT);
        
        if(self::GET_DRAFT($NAME, $STRUCTURE)){
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



    /**
     * Drop a database table
     *
     * @param string|object $TABLE
     * @return boolean
     */
    static function DROP_TABLE(string|object $TABLE) : bool{
        self::SET_TABLE($TABLE);
        if(self::GET_DRAFT($NAME)){ 
            if(!DRAFT::hasError()){
                self::DBCONNECT($dbc, $db);
                return $db->drop($NAME, true);
            }
        }
        return false;

    }

    /**
     * Drop a database field
     *
     * @param string|object $TABLE
     * @param string $FIELD
     * @return void
     */
    static function DROP_FIELD(string|object $TABLE, string $FIELD){
        self::SET_TABLE($TABLE);
        if(self::GET_DRAFT($NAME)){
            if(!DRAFT::hasError()){
                self::DBCONNECT($dbc, $db);
        
                return $db->drop($NAME, $FIELD);
            }
        }
        return false;
    }

    static function ALTER(string|object $TABLE, Closure $FORMAT) : bool {
        self::SET_TABLE($TABLE);
        $DRAFT = self::$DRAFT = new DRAFT('ALTER');
        $STRUCTURE = $FORMAT($DRAFT);
        if(self::GET_DRAFT($NAME, $STRUCTURE)){
            if(!DRAFT::hasError()){
                self::DBCONNECT($dbc, $db);
                $DRAFT = $STRUCTURE::BUILD($NAME);

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
     * @param string|null $NAME references the name of the table
     * @param DRAFT|NULL $STRUCTURE
     * @return bool
     */
    private static function GET_DRAFT(string|null &$NAME, DRAFT|NULL &$STRUCTURE = NULL) : bool {


        //proceed to get the draft structure
        if(func_num_args() > 1){
            if(!($STRUCTURE instanceof DRAFT)){
                return DRAFT::callError(Cli::error(('Schema function must return be a draft object'), 0, '|2'));
            }
        }

        $NAME = SELF::$DRAFT_TABLE;
        if($NAME) return true;
        return DRAFT::callError(Cli::error(('invalid database table supplied for schema'), 0, '|2'));

    }

    /**
     * Validate table
     *
     * @param string|object $TABLE
     * @return void
     */
    private static function SET_TABLE(string|object $TABLE){

        if(is_object($TABLE)){
            if(method_exists($TABLE, 'table')){
                $TABLE = $TABLE->table();
                if(!is_string($TABLE)){
                    DRAFT::callError(Cli::error('Schema "table" must be a string'), 0, '|2');         
                }
            }else{
                return DRAFT::callError(Cli::error('Schema object does not contain a "table" method!'), 0, '|2');
            }
        }
        SELF::$DRAFT_TABLE = strtolower($TABLE);
    }

    /**
     * Return the draft object
     *
     * @return DRAFT
     */
    public static function DRAFT(): DRAFT {

        return self::$DRAFT;

    }

    /**
     * Return a the sql query
     *
     * @return string
     */
    public static function DRAFT_SQL() : string {

        return self::$DRAFT_SQL;

    }

    /**
     * Returns the dbschema table name
     *
     * @return string
     */
    public static function DRAFT_TABLE() : string{
        return self::$DRAFT_TABLE;
    }

}