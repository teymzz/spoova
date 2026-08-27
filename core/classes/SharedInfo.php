<?php

/**
 * Defines the main connection shared across states and classes
 * This connection cannot be modified by children classes that
 * are not permitted to modify it. 
 * UserAuth is the default modifier class capable of modifying this connection.         
 */
namespace spoova\mi\core\classes;

use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

/**
 * - Contains information shared by current connection
 * - Reads and sets information from the init configuration file
 */
abstract class SharedInfo{
  
  protected static DB|false|null $dbc = null;
  protected static DBHandler|false|null $dbh = null;
  /* Needs an explicit default. A typed static without one is *uninitialized* rather
     than null, and Session::__construct() reads this while deciding whether to open
     a connection — before anything has assigned it. Reading it in that state is a
     fatal Error, so the CLI died on boot. The untyped declaration this replaced
     defaulted to null implicitly, which is what kept it working. */
  protected static string|false|null $dbe = null;
  protected static array $init = [];
  protected static $init_base;
  protected $fileManager;
  public $dbtable;
  
  /**
   * Supplying arguments into assumes a new connection
   *
   * @param boolean $conn a new DB connection 
   * @param DBHandler $dbhandler
   */
  function __construct($conn = false, ?DBHandler $dbhandler = null){

    if($conn === true) {
    
      $dbcon = new DB;
      if($dbh = $dbcon->openDB()){
        if($dbcon->active()){
          self::$dbc = $dbcon;
          self::$dbh = $dbh;
          self::$dbe = null;
        }else{

          self::$dbc = null;
          self::$dbh = null;
          self::$dbe = 'no database name selected';
        }
        
      } else {   
        self::$dbc = null;
        self::$dbh = null;
        self::$dbe = 'database connection failed';
        
      }     
      
    }elseif ((func_num_args() > 0) && ($conn !== false) && $dbhandler) {
        if($conn->currentDB() === $dbhandler->currentDB()){
          self::$dbc = $conn;
          self::$dbh = $dbhandler;
          self::$dbe = false;
        }else{
          self::$dbc = false;
          self::$dbh = false;
          self::$dbe = 'no database name selected';
        }
    } 

    if(!self::$init){

      if( (self::getDefined('_core')) and ($icore = self::getDefined('_icore')) )
      {
        if(@class_exists(scheme('core\classes\Bundle\Filemanager\Filemanager')))
        {

            //read file
            self::$init_base = $icore.'init';
            $fileManager = $this->fileManager = new Filemanager;
            $fileManager->setUrl($icore."init");
            $fileManager->openFile($icore."init");
              
            $initData = $fileManager->readFile(['USER_TABLE','COOKIE_FIELDNAME','USER_ID_FIELDNAME', 'SESSION_STORAGE_KEY']);     
            $userTable = $initData['USER_TABLE'];
            $cookieField = $initData['COOKIE_FIELDNAME'];
            $useridField = $initData['USER_ID_FIELDNAME'];
            $sesskey = $initData['SESSION_STORAGE_KEY'];
            
            $init['USER_TABLE'] = $this->dbtable = !empty($userTable)? trim($userTable) : 'users';
            $init['COOKIE_FIELDNAME'] = !empty($cookieField)? trim($cookieField) : 'cookie';
            $init['USER_ID_FIELDNAME'] = !empty($useridField)? trim($useridField) : 'email';
            $init['SESSION_STORAGE_KEY'] = !empty($sesskey)? trim($sesskey) : docBase;
            self::$init = $init;

        } else {
            exit('Filemanager is missing!');
        }
      }

    }
    
  }


  /**
   * References the instance of current DBHandler and Database Connector Class
   *
   * @param DBHandler|null $dbh
   * @param DB|null $dbc
   * @return bool true if a connection exists
   */
  public function getConnection(?DBHandler &$dbh = null, ?DB &$dbc = null){

    $dbc = self::$dbc;
    $dbh = self::$dbh;

    return ($dbh)? true : false;

  }

  /**
   * Returns the current database connector class, 
   * an instance of DBBrdige
   *
   * @return DBBridge
   */
  public function dbc(){

    return self::$dbc;

  }  
  
  /**
   * Returns the database handler
   *
   * @return DBHandler
   */
  public function dbh(){

    return self::$dbh;

  }  

  /**
   * Returns the database handler
   *
   * @return DBHandler
   */
  public function con(){

    return self::$dbh;

  }
  
  /**
   * Returns the current user id database table name set in the init folder
   *
   * @return string
   */  
  public static function tablename(){
    return self::$init['USER_TABLE']?? '';
  }

  /**
   * Returns the current user id fieldname set in the init folder
   *
   * @return string
   */
  public static function idField(){
    return self::$init['USER_ID_FIELDNAME']?? '';
  } 

  /**
   * Update the data of the currently signed in user in the user configuration (or supplied) table
   *
   * @param array $data new data to be supplied
   * @param string $table - opitional custom database table name
   * @notice The update is scoped to the current session's user id. Nothing is updated when no
   * user session is active.
   * @return DBHandler|null
   */
  public static function update(array $data, string $table = ''){

    $db = self::$dbh;

    if(!$db) return $db;

    // a supplied table wins, the configured user table is the fallback (this test was inverted)
    $table = (trim($table) !== '')? trim($table) : (self::$init['USER_TABLE'] ?? '');

    $idField = self::$init['USER_ID_FIELDNAME'] ?? '';

    if(!$data || $table === '' || $idField === '') return $db;

    /* Scoped to one account on purpose. The statement carried no WHERE clause before,
       so a single call rewrote the supplied columns for every row in the table. */
    $userId = (string) \User::id();

    if($userId === '') return $db;

    // "a = ?, b = ?" — without the comma the statement was invalid for more than one column
    $fields = implode(' = ?, ', array_keys($data)).' = ? ';

    $values = array_values($data);
    $values[] = $userId;

    $db->query('UPDATE `'.$table.'` SET '.$fields.' WHERE `'.$idField.'` = ?', $values);
    $db->update();
    return $db;

  }

  /**
   * get defined constant from string
   *
   * @param string $core
   * @return mixed
   */
  protected static function getDefined(string $core){
     if(defined($core)) return constant($core);
  }

  public static function init() : array {

    return self::$init;

  }
  
}