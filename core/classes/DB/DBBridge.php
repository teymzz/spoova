<?php
namespace spoova\core\classes\DB;

/**
 * This class is exepected to bridge the gap between
 * Different database connections
 * 
 * All methods implemented from the DBBase are only specific to this method
 */
abstract class DBBridge implements DBInterface, DBHelpers{
  
  protected static $baseerror;
  protected static $basequery;
  protected static $basequeryerr; 
  
  /**
   * To  identify when a connection 
   * is opened
   *
   * @var boolean
   */
  protected $con = false;

  /**
   * Database connection variable
   *
   * @var mixed database connection variable
   */
  protected $conn = false;

  /**
   * Tells when a connection has failed
   *
   * @var boolean
   */
  protected $isFailed = false;

  /**
   * Tells theh handler to use the setData method
   *
   * @var boolean
   */
  protected $useData = true;

  /**
   * The connection class name
   *
   * @var string
   */
  protected $conName;

  /**
   * The connection name
   *
   * @var string
   */
  protected $conType;

  /**
   * Currently selected database name
   *
   * @var string
   */
  protected $currentDB = '';

  /**
   * anchors the last sql query executed
   *
   * @var string
   */
  protected $last_query = '';

  /**
   * completed sql query string
   *
   * @var string
   */
  protected $dataString;

  /**
   * data to be binded
   *
   * @var array
   */
  protected $data;

  /**
   * Sql query
   *
   * @var string
   */
  protected $sQL;
  protected $binder;
  protected $num_rows = 0; //0 in MiSQL
  protected $error;
  protected $full_error;
  protected $affectedRows;
  protected $previousLimit;
  protected $limit;
  protected $conResponse;
  protected $DBSERVER = DBSERVER; 
  protected $DBPORT   = DBPORT;
  protected $DBSOCKET = DBSOCKET;
  protected $DBUSER   = DBUSER;
  protected $DBPASS   = DBPASS;
  protected $DBNAME   = DBNAME;

  /**
   * Initializes with database connection
   *
   * @param string $dbname - optional database name 
   * @param string $dbuser - optional database user 
   * @param string $dbpass - optional database password 
   * @param string $dbserver - optional database server
   * @param string $dbport - optional database port
   * @param string $dbsocket - optional database socket
   */
  function __construct(
    $dbname   = null, 
    $dbuser   = null, 
    $dbpass   = null, 
    $dbserver = null, 
    $dbport   = null, 
    $dbsocket = null
    ){ 
    if(count(func_get_args()) > 0){
      $this->setDB($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket);
    }
    return $this->open_connection(); 
  }

  protected function setDB($dbname,$dbuser,$dbpass,$dbserver,$dbport,$dbsocket){
    $dbserver = isset($dbserver)? $dbserver : DBSERVER;

    if($dbname === ":tool"){
      $this->DBNAME = ''; 
      return null;     
    }
           
    if(!isset($dbname, $dbuser, $dbpass)){
      return false;
    }

    $this->DBSERVER = $dbserver;
    $this->DBSOCKET = $dbsocket;      
    $this->DBPORT   = $dbport;
    $this->DBNAME   = $dbname;
    $this->DBUSER   = $dbuser;
    $this->DBPASS   = $dbpass;
  }

  /**
   * Return the object instance of the current connection
   * This can be mysqli or pdo
   *
   * @return object
   */
  public function dbcon(){
     return $this->conn;
  }

  //* All Helper methods---------------------------------
  public function conName(){
      return $this->conName;
  }

  public function conType(){
      return $this->conType;
  }  

  /**
   * Returns the connection responses
   * This is mostly used to return errors when database connection fails.
   *
   * @return string connection response
   */
  public function conResponse(){
    return $this->conResponse;
  } 

  /**
   * Return the current database selected
   *
   * @return string
   */
  public function currentDB() : string {
    return $this->currentDB;
  }

  public function isConnected(){
    if($this->conn != false && isset($this->dbConnection)){
        return true;
    }else{
        return false;
    }
  }

  /**
   * Switch to a new database using current or new connection
   *
   * @param string $dbname (required)
   * @param string $dbuser (optional)
   * @param string $dbpass (optional)
   * @param string $dbserver (optional)
   * @param string $dbport (optional)
   * @param string $dbsocket (optional)
   * @return true if connection successful
   */
  public function switchDB(
    
    $dbname, 
    $dbuser   = null ,
    $dbpass   = null, 
    $dbserver = null, 
    $dbport   = null, 
    $dbsocket = null

    ){

      return $this->newConnection($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket);
    
  }

  /**
   * Get the connection parameters
   *
   * @return array 
   */
  public function getParams(){
    return [
      'DBNAME'   => $this->DBNAME,
      'DBUSER'   => $this->DBUSER,
      'DBPASS'   => $this->DBPASS,
      'DBSERVER' => $this->DBSERVER, 
      'DBPORT'   => $this->DBPORT,
      'DBSOCKET' => $this->DBSOCKET,
    ];
  }

  /**
   * Return true when has connection failed
   * This can also return true if no connection is made
   *
   * @return boolean
   */
  public function isFailed(){
    return $this->isFailed;
  } 

  /**
   * Returns the number of rows affeted by the last query
   *
   * @return int|string
   */
  public function num_rows(){
    return $this->num_rows;
  }

  /**
   * return the last inserted id or void
   *
   * @return int|void
   */
  abstract public function insert_id();

  /**
   * This returns the last query that was executed
   * It helps to figure out any errrors existing in queries
   *
   * @return string
   */
  public function get_last_query(){
    return $this->last_query;
  }

  /**
   * This method will direct the dbhandler to use 
   * setData method to load query parameters
   *
   * @param  bool $type
   * @return void
   */
  public function useData(bool $type = true){
    $this->useData = $type;
  }

  /**
   * Returns the last query error.
   * If no error exists it returns void
   * This method is always called on the current connection
   *
   * @return void|string 
   */
  public function error(){ 
    return $this->error;
  }

  /**
   * Checks if error exists in current connection
   *
   * @return bool
   */
  public function error_exists() : bool{  
    return $this->error? true : false;
  }  

  //* abstract methods

  /**
   * process non-crude operations
   *
   * @param string $sql sqlquery
   * @return bool true is returned if query ran successfully
   */
  abstract public function process_query($sql) : bool;

  /**
   * Performs insert query
   *
   * @param string $sql sqlquery
   * @return bool true if insertion was done successfully
   */
  abstract public function insert_query($sql) : bool;

  /**
   * Fetches data from the database
   *
   * @param string $sql sqlquery
   * @return void
   */
  abstract public function fetch_array($sql);
  
  /**
   * updates database using supplied query
   *
   * @param string $sql
   * @return bool
   */
  abstract public function update_query($sql) : bool;

  /**
   * deletes data from the database
   *
   * @param string $sql
   * @return bool
   */
  abstract public function delete_query($sql) : bool;

  /**
   * sort or creates binded parameters syntax
   *
   * @param array $data parameters to be binded to query supplied
   * @param string $sqL raw sql query supplied
   * @return bool
   */
  abstract public function buildBind(&$data, $sqL) : bool;

  /**
   * This method defines a new connection parameters 
   * {@see DBBridge::switchDB()}
   * 
   * @return bool true if connection is successful
   */
  abstract protected function newConnection($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket);

  /**
   * open a new connection
   *
   * @return void
   */
  abstract protected function open_connection();

  /**
   * close a connection
   *
   * @return void
   */
  abstract public function close_connection();
    
  protected function buildError($error, $custom_error){

    self::$baseerror = $error;

    self::$basequery = $this->last_query;
    self::$basequeryerr = $this->error;    
    $queryText = $this->conName() === 'MiPDO'? '::' : '::query::';
    $this->full_error = $error." ".$queryText." ".strtolower($this->last_query);
    $this->error = $error;  

  }
  
  /**
   * Build the limit used. Supports only a maximum of two limits range
   *
   * @param array|bool(false) $limit [from to]. 
   *      - when array is supplied, the first index value should be lesser than the second index value
   *  -
   * @return bool|string string of limit is returned onl if it matches proper structure
   */
  public function buildLimit($limit){
    
    if($limit === false){ $this->limit = null; return null; }
    if(!is_array($limit)) return false;
    
    if(count($limit) < 1){
      $this->limit = "";
      return $this->limit;
    }
   
    if(count($limit) > 0){
    
      foreach ($limit as $key => $value) {
        $text[] = $limit[$key];
      }

      $implode = " , ";
      $newdataString = implode(" $implode " , $text);
      $this->limit = " limit ".$newdataString;

      return $this->limit;
    }
    return false;

  }


}

?>
