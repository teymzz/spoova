<?php

namespace spoova\mi\core\classes\DB;

/**
 * This class is exepected to bridge the gap between
 * Different database connections
 * 
 * All methods implemented from the DBBase are only specific to this method
 */
abstract class DBBridge implements DBInterface, DBHelpers{
  
  protected static string $baseerror = '';
  protected static string $basequery = '';
  protected static ?string $basequeryerr = null; 
  protected static array $dbqueries = []; 
  
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
   * @var object|null|false database connection variable
   */
  protected object|null|false $conn = false;

  /**
   * Tells when a connection has failed
   *
   * @var boolean
   */
  protected bool $isFailed = false;

  /**
   * Tells theh handler to use the setData method
   *
   * @var boolean
   */
  protected bool $useData = true;

  /**
   * The connection class name
   *
   * @var string
   */
  protected string|null $conName = '';

  /**
   * The connection name
   *
   * @var string
   */
  protected string|null $conType;

  /**
   * Currently selected database name
   *
   * @var string
   */
  protected string $currentDB = '';

  /**
   * anchors the last sql query executed
   *
   * @var string
   */
  protected string $last_query = '';

  /**
   * completed sql query string
   *
   * @var string|null
   */
  protected string|null $dataString;

  /**
   * data to be binded
   *
   * @var array
   */
  protected array $data;

  /**
   * Sql query
   *
   * @var string
   */
  protected $sQL;
  protected $binder;
  protected $num_rows = 0; //0 in MiSQL
  protected $error;
  protected string $full_error;
  protected $affectedRows;
  protected string $previousLimit;
  protected $limit;
  protected string $conResponse;
  protected string|null $DBSERVER = DBSERVER; 
  protected string|null $DBPORT   = DBPORT;
  protected string|null $DBSOCKET = DBSOCKET;
  protected string|null $DBUSER   = DBUSER;
  protected string|null $DBPASS   = DBPASS;
  protected string|null $DBNAME   = DBNAME;
  protected bool $dbConnection;

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
    $dbname = null, 
    string|null $dbuser   = null, 
    string|null $dbpass   = null, 
    string|null $dbserver = null, 
    string|null|int $dbport   = null, 
    string|null $dbsocket = null
    ){ 
    if(count(func_get_args()) > 0){
      $this->setDB($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket);
    }
    return $this->open_connection(); 
  }
  
  /**
   * Makes an explicitly supplied port authoritative by forcing a TCP connection.
   *
   *  - Both mysqli and PDO treat the host name "localhost" as a request for the
   *    local unix socket (a named pipe on Windows) and silently ignore the port.
   *    A wrong port therefore reads back as a successful connection, which hides
   *    misconfiguration instead of reporting it.
   *  - Swapping in the loopback address makes the supplied port take effect, so a
   *    port that is genuinely wrong fails as the caller would expect.
   *  - A configured socket always wins: that is an explicit request for a
   *    non-TCP connection and must not be overridden.
   *
   * Applied here rather than in a driver so {@see DBM\MiSQL} and {@see DBM\MiPDO}
   * share one behaviour.
   *
   * @param string|null $dbserver referenced server name, rewritten in place
   * @param string|int|null $dbport port supplied alongside the server
   * @param string|null $dbsocket socket supplied alongside the server
   * @return void
   */
  protected static function normalizeHost(&$dbserver, int|string|null $dbport, string|null $dbsocket = null) : void {

    if(trim((string) $dbsocket) !== '') return;                          // socket beats TCP
    if(strtolower(trim((string) $dbserver)) !== 'localhost') return;     // only "localhost" is ambiguous

    $dbport = trim((string) $dbport);

    if($dbport === '' || !ctype_digit($dbport) || ((int) $dbport < 1)) return;

    $dbserver = '127.0.0.1';
  }

  protected function setDB(string|array|null $dbname, string|null $dbuser, string|null $dbpass, string|null $dbserver, int|string|null $dbport, string|null $dbsocket){
    $dbserver = isset($dbserver)? $dbserver : DBSERVER;

    if($dbname === ":tool"){
      $this->DBNAME = '';
      return null;
    }

    if(!isset($dbname, $dbuser, $dbpass)){
      return false;
    }

    self::normalizeHost($dbserver, $dbport, $dbsocket);

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
   * @return object|false|null
   */
  public function dbcon() : object|false|null {
     return $this->conn;
  }

  //* All Helper methods---------------------------------
  public function conName() : string {
      return $this->conName;
  }

  public function conType() : string {
      return $this->conType;
  }  

  /**
   * Returns the connection responses
   * This is mostly used to return errors when database connection fails.
   *
   * @return string connection response
   */
  public function conResponse() : string {
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

  public function isConnected() : bool {
    return ($this->conn != false && isset($this->dbConnection));
  }

  /**
   * Switch to a new database using current or new connection
   *
   * @param string $dbname (required)
   * @param string|null $dbuser (optional)
   * @param string|null $dbpass (optional)
   * @param string|null $dbserver (optional)
   * @param string|null|int $dbport (optional)
   * @param string|null $dbsocket (optional)
   * @return true if connection successful
   */
  public function switchDB(
    
    $dbname, 
    string|null $dbuser   = null ,
    string|null $dbpass   = null, 
    string|null $dbserver = null, 
    string|null|int $dbport   = null, 
    string|null $dbsocket = null

    ){

      self::normalizeHost($dbserver, $dbport, $dbsocket);

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
  abstract public function process_query(string $sql) : bool;

  /**
   * Performs insert query
   *
   * @param array $sql sqlquery
   * @return bool true if insertion was done successfully
   */
  abstract public function insert_query(array $sql) : bool;

  /**
   * Fetches data from the database
   *
   * @param array $sql sqlquery
   */
  abstract public function fetch_array(array $sql);
  
  /**
   * updates database using supplied query
   *
   * @param array $sql
   * @return bool
   */
  abstract public function update_query(array $sql) : bool;

  /**
   * deletes data from the database
   *
   * @param array $sql
   * @return bool
   */
  abstract public function delete_query(array $sql) : bool;

  /**
   * sort or creates binded parameters syntax
   *
   * @param array $data parameters to be binded to query supplied
   * @param string $sqL raw sql query supplied
   * @return bool
   */
  abstract public function buildBind(&$data, string $sqL) : bool;


  /**
   * This method defines a new connection parameters {@see DBBridge::switchDB()}
   *
   * @param string $dbname
   * @param string|null $dbuser
   * @param string|null $dbpass
   * @param string|null $dbserver
   * @param string|null $dbport
   * @param string|null $dbsocket
   * @return bool
   *  - True : if connection is successful
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
    
  protected function buildError(string $error, $custom_error){

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
   * @param array|false $limit [from to]. 
   *    - when array is supplied, the first index value should be lesser than the second index value
   *    - false: usents the limit
   * @return string|false|null string of limit is returned only if it matches proper structure
   */
  public function buildLimit(array|false $limit) : string|false|null {
    
    if($limit === false){ $this->limit = null; return null; }
    if(!is_array($limit)) return false;
    
    if(count($limit) < 1){
      $this->limit = "";
      return $this->limit;
    }
   
    if(count($limit) > 0){

      $text = [];
      foreach ($limit as $key => $value) {
        $text[] = $limit[$key];
      }

      $separator = " , ";
      $newdataString = implode($separator , $text);
      $this->limit = " limit ".$newdataString;

      return $this->limit;
    }
    return false;

  }


}

?>
