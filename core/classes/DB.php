<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\DB\DBBridge;
use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\DB\DBHelpers;

class DB implements DBHelpers{
  
  private ?DBBridge $conn = null; //dbconnection
  private ?DBHandler $dbh = null; //dbhandler
  private ?array $connections = [];

  private const conNamesmap = [
      'mysqli' => 'MiSQL', 
      'misqli' => 'MiSQL', 
      'misql'  => 'MiSQL',
      'pdo'    => 'MiPDO',
      'mipdo'  => 'MiPDO'
  ];
  
  /**
   * Specifies the connection handler class name (e.g MiSQL, MiPDO)
   *
   * @var string
   */
  private ?string $conName;

  /**
   * Static alias for {@see DB::$conName}
   *
   * @var string
   */
  private static ?string $conNameStatic = null;

  /**
   * Static lists of all specified connection handler classes names (e.g MiSQL, MiPDO)
   *
   * @var array 
   */
  private static ?array $DBCON = [];

  private $currentDB;
  private $isConnected = false;
  private const DBCON = DBCON;

  protected $newState;
  protected $error;
  protected $dbcon;
  protected $conResponse;
  protected $conType;
  
  /**
   * creates an instance of a DB class. This does NOT create a new database connection. 
   *
   * @param string $conName connection class name (MiSQL, MiPDO, ...)
   * 
   */
  function __construct(string $conName = DBCON){
     
    $conName = $this->mapConnName(trim($conName));  

    // allow only default supported connection names here.
    if(in_array($conName, self::conNames, true)){
      $conName = strtoupper($conName);
      self::$conNameStatic = $conName;
      if(!in_array($conName, self::$DBCON)) self::$DBCON[] = $conName;
      $this->newState = $conName; 
    }

  }
  
  /**
   * This method takes the database root query handler class name (MiSQL, MiPDO, ...)
   *
   * @param string $conName name of connector class
   * @return object of the connection
   */
  public function open(?string $conName = null){
   return $this->open_connection($conName);
  }

  /**
   * Remodify connection name
   *
   * @param string $conName connector class Name
   * @return string
   */
  private function mapConnName($conName = ''){
    return self::conNamesmap[strtolower($conName)] ?? $conName;
  }

  /**
   * open a new database connection
   *
   * @param object $conName instance of core\classes\DBBridge
   * @return void|DBHandler
   */
  private function open_connection( $conName ){

    //remodify conName where conName is the connector class Name
  	if($conName == null && isset($this->newState)){
      
      $conName = $this->newState;

  	}else{

      $conName = in_array($this->mapConnName($conName), self::conNames, true) ? $conName : DBCON;	

  	}
    
    $conName = $this->mapConnName($conName);

  	$conClass =  __NAMESPACE__ ."\DB\DBM\\". $conName;

    if( @class_exists($conClass) ) {

      $conn = new $conClass; 
      return $this->dbh = $this->selfUpdate($conn);    

    } else {

      $this->error = 'connection class not found!';

    }

  }

  //* All Helper methods------------(specific to current class)

  public function conName(){
      return $this->conName;
  }

  /**
   * Returns all or currently detected database connection handler names (e.g MySQL, PDO)
   *
   * @param boolean $current TRUE returns only the current database connection name while FALSE returns all names.
   * @return array|string
   */
  public static function DBCON(bool $current = false) : array|string {

    
      $conNames = ($current)? [self::$conNameStatic] : self::$DBCON;

      $conNames = array_unique(array_map(fn($conName) => strtolower($conName) , $conNames));
      $names = [];
      foreach($conNames as $conName){
        if(isset(self::conNamesmap[$conName])) $conName = self::conNamesmap[$conName];
        if(($name = array_search($conName, self::conNamesmap))!==false){
          $names[] = strtoupper($name);
        }
      }
      return $current? join('',$names) : $names;
  }

  public function conType(){
      return $this->conType;
  }  

  public function conResponse(){
    return isset($this->conResponse);
  } 

  public function currentDB(){
    return $this->currentDB;
  }

  public function isConnected(){
    return $this->isConnected;
  }

  /**
   * Connection error only specific to DB class
   *
   * @return string
   */
  public function error(){
    return $this->error?? '';
  }

  /**
   * Connection error only specific to DB class
   *
   * @return bool
   */
  public function error_exists(): bool {
    if(method_exists($this, 'error')){
      return $this->error? true : false;
    }
     return true;
  }

  /**
   * check dbport supplied is of a socket value
   *
   * @param string $value dbport or dbsocket value
   * @return string
   */
  private function testSock($value = ''){
    $value = ltrim($value, ":");
    $ext = pathinfo($value,PATHINFO_EXTENSION);

    return (strtolower($ext) === "sock");
  }

  /**
   * Update connection 
   *
   * @param DBBridge $connection
   * @return null|DBHandler
   */
  private function selfUpdate($connection) : null|DBHandler {

    $this->conName     = $connection->conName();
    $this->isConnected = $connection->isConnected();
    $this->currentDB   = $connection->currentDB();

    if( !$connection->isConnected() ){
      $this->error       =  $connection->conResponse();
      $this->conResponse = $connection->conResponse();
      return null;     
    }

    $this->conn = $connection;
    return new DBHandler($connection, $this); 

  }

  /**
   * Open a new database connection with default configurations or
   * with new configurations when parameters are supplied.
   *
   * @param string|array|null $dbname database name or full database connection parameters.
   * 
   * - $dbname (array): (indexed array must have least 4 keys in the order below)
   *      <pre>
   *         (array) => [
   *                     '[ 0 | NAME   | DBNAME ]'     => (string) DB NAME. Optional
   *                     '[ 1 | USER   | DBUSER ]'     => (string) DB USER. Required
   *                     '[ 2 | PASS   | DBPASS ]'     => (string) DB PASS. Required
   *                     '[ 3 | SERVER | DBSERVER ]'   => (string) DB SERVER. Required
   *                     '[ 4 | PORT   | DBPORT ]'     => (string) DB SERVER. Required (if using port)
   *                     '[ 5 | SOCKET | DBSOCKET ]'   => (string) DB SOCKET. Optional
   *               ]
   *      </pre>
   * 
   * @param string $dbname    Optional
   * @param string $dbuser    Required
   * @param string $dbpass    Required
   * @param string $dbserver  Required
   * @param string $dbport    Required (if using port)
   * @param string $dbsocket  Optional
   * @return null|DBHandler
   */
  public function openDB(
    array|string|null $dbname = null,
    string $dbuser = '', 
    string $dbpass = '', 
    string $dbserver = '',
    string $dbport = '', 
    string $dbsocket = ''
    ): null|DBHandler
  {

    if(isset($this->newState)){
      $conName = in_array($this->mapConnName($this->newState), self::conNames, true) ? $this->newState : DBCON;
    }else{
      $conName = DBCON; 
    }

    $conName = $this->mapConnName($conName);

    $dbconfig = $dbname; //note (dbname is modified below)      

    if(is_array($dbname)){
      $dbname   = $dbconfig[0]?? $dbconfig['DBNAME']   ?? $dbconfig['NAME']   ?? null;
      $dbuser   = $dbconfig[1]?? $dbconfig['DBUSER']   ?? $dbconfig['USER']   ?? null;
      $dbpass   = $dbconfig[2]?? $dbconfig['DBPASS']   ?? $dbconfig['PASS']   ?? null;     
      $dbserver = $dbconfig[3]?? $dbconfig['DBSERVER'] ?? $dbconfig['SERVER'] ?? null;
      $dbport   = $dbconfig[4]?? $dbconfig['DBPORT']   ?? $dbconfig['PORT']   ?? null;
      $dbsocket = $dbconfig[5]?? $dbconfig['DBSOCKET'] ?? $dbconfig['SOCKET'] ?? null;
    }


    //test socket connetions when paramters are only four
    if($this->testSock($dbport)){
      $dbsocket = $dbport;
      $dbport = '';
    }

    $conClass =  __NAMESPACE__ ."\DB\DBM\\". $conName;
    
    $params = [];
    if(func_num_args() > 0){ 
       
       //if only database name is supplied, use default connection parameters
       if(func_num_args() === 1 && defined('DBUSER') && !empty(trim($dbname) && !is_array($dbconfig))){ 
          $params = [$dbname, DBUSER, DBPASS, DBSERVER, DBPORT, DBSOCKET];
       }else{
          //use all method parameters supplied
          $params = [$dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket];
       }

     }
    
     $conn = new $conClass(...$params); 

     return $this->dbh = $this->selfUpdate($conn);
           
  }

  
  /**
   * Alias to {@see DB::openDB()}. Static method to open a new database connection with default configurations or
   * with new configurations when parameters are supplied.
   *
   * @param string|array|null $dbname database name or full database connection parameters.
   * 
   * - $dbname (array): (indexed array must have least 4 keys in the order below)
   *      <pre>
   *         (array) => [
   *                     '[ 0 | NAME   | DBNAME ]'     => (string) DB NAME. Optional
   *                     '[ 1 | USER   | DBUSER ]'     => (string) DB USER. Required
   *                     '[ 2 | PASS   | DBPASS ]'     => (string) DB PASS. Required
   *                     '[ 3 | SERVER | DBSERVER ]'   => (string) DB SERVER. Required
   *                     '[ 4 | PORT   | DBPORT ]'     => (string) DB SERVER. Required (if using port)
   *                     '[ 5 | SOCKET | DBSOCKET ]'   => (string) DB SOCKET. Optional
   *               ]
   *      </pre>
   * 
   * @param string $dbname    Optional
   * @param string $dbuser    Required
   * @param string $dbpass    Required
   * @param string $dbserver  Required
   * @param string $dbport    Required (if using port)
   * @param string $dbsocket  Optional
   * @return null|DBHandler
   */
  public static function boot(
    array|string|null $dbname = null,
    string $dbuser = '', 
    string $dbpass = '', 
    string $dbserver = '',
    string $dbport = '', 
    string $dbsocket = ''
    ): null|DBHandler
  {
    $db = new DB();
    return $db->openDB(...func_get_args());
  }

  /**
   * This method is used to connect to database in absence of a selected database name.
   *
   * @param string|array $dbuser The database user or database array list. When set as array, must either be indexed array or must have least 4 keys in the order below:
   *      
   *        -  (array) => [
   *        - - -     [0|USER|DBUSER] => (string) DB USER. (Required)
   *        - - -     [1|PASS|DBPASS] => (string) DB PASS. (Required)
   *        - - -     [2|SERVER|DBSERVER] => (string) DB SERVER. (Required)
   *        - - -     [3|PORT| DBPORT] => (string) DB SERVER. (Required if using port)
   *        - - -     [4|SOCKET|DBSOCKET] => (string) DB SOCKET. Optional
   *        - -   ]
   *      
   * 
   * @param string $dbpass    Optional but Required if $dbuser is string
   * @param string $dbserver  Optional but Required if $dbuser is string
   * @param string $dbport    Optional but Required if $dbuser is string and uses port. 
   * @param string $dbsocket  Optional
   * @return null|DBHandler
   */
  public function openTool(string|array $dbuser = '', string $dbpass = '', string $dbserver = '', string $dbport = '', string $dbsocket = '') : DBHandler|null {

    if(isset($this->newState)){
      $conName = in_array($this->mapConnName($this->newState), self::conNames, true) ? $this->newState : DBCON;
    }else{
      $conName = DBCON; 
    }

    $conName = $this->mapConnName($conName);

    if(is_array($dbuser)){
      if(func_num_args() > 1) {
        trigger_error('openTool should contain exactly 1 array argument or strings of connection parameters');
        return false;
      }
      $dbpass   = $dbuser[1]?? $dbuser['DBPASS']   ?? $dbuser['PASS']   ?? null;     
      $dbserver = $dbuser[2]?? $dbuser['DBSERVER'] ?? $dbuser['SERVER'] ?? null;
      $dbport   = $dbuser[3]?? $dbuser['DBPORT']   ?? $dbuser['PORT']   ?? null;
      $dbsocket = $dbuser[4]?? $dbuser['DBSOCKET'] ?? $dbuser['SOCKET'] ?? null;
      $dbuser   = $dbuser[0]?? $dbuser['DBUSER']   ?? $dbuser['USER']   ?? null;
    }

    if(arrInside([$dbuser, $dbpass, $dbserver, $dbport, $dbsocket])){
       trigger_error('invalid array supplied for openTool');
       return false;
    }

    $conClass =  __NAMESPACE__ ."\DB\DBM\\". $conName;

    if(count(func_get_args()) > 0){ 
      $conn = new $conClass('', $dbuser, $dbpass, $dbserver, $dbport, $dbsocket);
    }else{
      $conn = new $conClass(":tool");      
    }

    return $this->dbh = $this->selfUpdate($conn);

  }

  /**
   * check if the current database connection is connected to one active database name
   *
   * @return boolean
   */
  public function active(): bool {
    return ($this->isConnected() and ($this->currentDB != null))? true : false;
  }

  /**
   * connect to a new database using previously set connection
   *
   * @param string $dbname
   * @param  $handler reference variable that will anchor @core/classes/DBHandler
   * @return boolean
   */
  public function newDB(string $dbname, &$handler ){
    
    if(!$dbcon = $this->dbcon){
      trigger_error('no connection supplied');
      return false;
    }

    $conParams = $dbcon->getParams();

    $dbuser   = $conParams['DBUSER'];
    $dbpass   = $conParams['DBPASS'];
    $dbserver = $conParams['DBSERVER'];
    $dbport   = $conParams['DBPORT'];
    $dbsocket = $conParams['DBSOCKET'];    
    $dbinfo = [
      $dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket
    ];

    $newdb  = new DB();

    if($handle = $newdb->openDB(...$dbinfo)){
      $handler = $handle;
      return $newdb->error;
    }  else {
      $this->error = $newdb->error;
      return false;
    }

  }

  private function switchTo($conType){

    if(in_array($conType, ['MiSQL','MiPDO'])){ 
      $this->newState = $conType; 
    }
    
  }

  //switch connection type //This may be removed in future versions
  public function misql(){
    $this->switchTo("MiSQL");
  }

  //switch connection type //This may be removed in future versions
  public function mipdo(){
    $this->switchTo("MiPDO");
  }

  /**
   * Sets or formats a query to be executed
   *
   * @param array|string $query
   * @param array $data binded data or binded key and value pairs
   * @param boolean $usedata enables the use of data set pairs.
   * @return DBHandler|null 
   */
  public static function query(array|string $query, $data = [], bool $usedata = false): DBHandler|null {
    $db = new DB();
    $db = $db->openDB();
    if($db){
      return $db->query(...func_get_args());
    }
    return null;
  }


  /**
   * Creates a new connection instance using default configuration or newly supplied configuration parameters
   *
   * @param array|string|null|null $dbname
   * @param string $dbuser
   * @param string $dbpass
   * @param string $dbserver
   * @param string $dbport
   * @param string $dbsocket
   * @return DBHandler|False
   */
  public static function connection(
    array|string|null $dbname = null,
    string $dbuser = '', 
    string $dbpass = '', 
    string $dbserver = '',
    string $dbport = '', 
    string $dbsocket = ''
    ): DBHandler|False  {
    $db = new DB();
    return $db->openDB() ?? false;
  }

  /**
   * sets permission for enabling metrics or returns metrics data using  {@see DBHandler::metrics()}
   *
   * @param integer $mode optional [0|1|2]
   *  - 0: returns metrics data 
   *  - 1: enables simple metrics analysis 
   *  - 2: enable advanced metrics analysis
   * @return array
   */
  public static function metrics(int $mode = 0) : array {
    return DBHandler::metrics($mode);
  }
  
}