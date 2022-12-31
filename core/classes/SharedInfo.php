<?php

/**
 * Defines the main connection shared across states and classes
 * This connection cannot be modified by children classes that
 * are not permitted to modify it. 
 * UserAuth is the default modifier class capable of modifying this connection.         
 */
namespace spoova\core\classes;

/**
 * - Contains information shared by current connection
 * - Reads and sets information from the init configuration file
 */
abstract class SharedInfo{
  
  protected static ?DB $dbc = null;
  protected static ?DBHandler $dbh = null;
  protected static $dbe;
  protected static $init = [];
  protected static $init_base;
  protected $fileManager;
  
  /**
   * Supplying arguments into assumes a new connection
   *
   * @param boolean $conn a new DB connection 
   * @param DBHandler $dbhandler
   */
  function __construct($conn = false, DBHandler $dbhandler = NULL){
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
          self::$dbe = '';
        }else{
          self::$dbc = '';
          self::$dbh = '';
          self::$dbe = 'no database name selected';
        }
    } 

    if(!self::$init){

      if( (self::getDefined('_core')) and ($icore = self::getDefined('_icore')) )
      {
        if(@class_exists('spoova\core\classes\FileManager'))
        {

            //read file
            self::$init_base = $icore.'init';
            $fileManager = $this->fileManager = new FileManager;
            $fileManager->setUrl($icore."init");
            $fileManager->openFile($icore."init");
              
            $initData = $fileManager->readFile(['USER_TABLE','COOKIE_FIELDNAME','USER_ID_FIELDNAME']);     
            $userTable = $initData['USER_TABLE'];
            $cookieField = $initData['COOKIE_FIELDNAME'];
            $useridField = $initData['USER_ID_FIELDNAME'];
            
            $init['USER_TABLE'] = $this->dbtable = !empty($userTable)? trim($userTable) : 'users';
            $init['COOKIE_FIELDNAME'] = !empty($cookieField)? trim($cookieField) : 'cookie';
            $init['USER_ID_FIELDNAME'] = !empty($useridField)? trim($useridField) : 'email';
            self::$init = $init;

        } else {
            exit('FileManager is missing!');
        }
      }

    }
    
  }


  /**
   * References the instance of current DBHandler and Database Connector Class
   *
   * @param void $dbh
   * @param void $dbc
   * @return bool true if a connection exists
   */
  public function getConnection(&$dbh, &$dbc = null){

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
  public static function tableName(){
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
   * Update the user data in the user configuration (or supplied) table
   *
   * @param array $data new data to be supplied
   * @param string $table - opitional custom database table name 
   * @return DBHandler
   */
  public static function update(array $data, string $table = ''){

    $db = self::$dbh;

    $table = (func_num_args() === 2)? self::$init['USER_TABLE'] : $table;
    
    $newdata = array_keys($data);
    $fields = implode(' = ? ', $newdata);

    $db->query('update '.$table.' set '.$fields, $data);
    $db->update();
    return $db;

  }

  /**
   * get defined constant from string
   *
   * @param string $core
   * @return void
   */
  protected static function getDefined(string $core){
     if(defined($core)) return constant($core);
  }
  
}