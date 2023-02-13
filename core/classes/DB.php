<?php

namespace spoova\core\classes;

use spoova\core\classes\DB\DBBridge;
use spoova\core\classes\DB\DBHandler;
use spoova\core\classes\DB\DBHelpers;

class DB implements DBHelpers{
  
  private ?DBBridge $conn = null; //dbconnection
  private ?DBHandler $dbh = null; //dbhandler
  private $conName;
  private $currentDB;
  private $isConnected = false;

  protected $newState;
  protected $error;
  protected $dbcon;
  protected $conResponse;
  protected $conType;
  
  /**
   * creates an instance of a new DB 
   *
   * @param string $conName connection class name (MiSQL, MiPDO, ...)
   * 
   */
  function __construct(string $conName = ''){
     
    $conName = trim($conName);  

    if(in_array($conName, self::conNames, true)){
      $this->newState = $conName; 
    }

  }
  
  /**
   * This method takes the database root 
   * query handler class name (MiSQL, MiPDO, ...)
   *
   * @param $conName name of connector class
   * @return object of the connection
   */
  public function open(string $conName = null){
   return $this->open_connection($conName);
  }

  /**
   * Remodify connection name
   *
   * @param string $conName connector class Name
   * @return string
   */
  private function reloadName($conName = ''){
    if(strtolower($conName) === 'misqli') $conName = 'MiSQL';
    if(strtolower($conName) === 'pdo')    $conName = 'MiPDO';
    return $conName;
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

      $conName = in_array($this->reloadName($conName), self::conNames, true) ? $conName : DBCON;	

  	}
    
    $conName = $this->reloadName($conName);

  	$conClass =  __NAMESPACE__ ."\DB\\". $conName;

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
  private function selfUpdate($connection){

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
   * open a new database connection with default configurations or
   * with new configurations when parameters are supplied
   *
   * @param string|array $dbname
   * 
   *    @param array $dbname: (indexed array must have least 4 keys in the order below)
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
   * @return void|DBHandler
   */
  public function openDB(
    $dbname = null,
    string $dbuser = '', 
    string $dbpass = '', 
    string $dbserver = '',
    string $dbport = '', 
    string $dbsocket = ''
    )
  {

    if(isset($this->newState)){
      $conName = in_array($this->reloadName($this->newState), self::conNames, true) ? $this->newState : DBCON;
    }else{
      $conName = DBCON; 
    }

    $conName = $this->reloadName($conName);

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

    $conClass =  __NAMESPACE__ ."\DB\\". $conName;
    
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
   * This method is only used to connect when no database name is supplied
   *
   * @param string|array $dbname
   * 
   *    @param array $dbname: (indexed array must have least 4 keys in the order below)
   *      <pre>
   *         (array) => [
   *                     '[ 0 | USER   | DBUSER ]'     => (string) DB USER. Required
   *                     '[ 1 | PASS   | DBPASS ]'     => (string) DB PASS. Required
   *                     '[ 2 | SERVER | DBSERVER ]'   => (string) DB SERVER. Required
   *                     '[ 3 | PORT   | DBPORT ]'     => (string) DB SERVER. Required (if using port)
   *                     '[ 4 | SOCKET | DBSOCKET ]'   => (string) DB SOCKET. Optional
   *               ]
   *      </pre>
   * 
   * @param string $dbuser    Required
   * @param string $dbpass    Required
   * @param string $dbserver  Required
   * @param string $dbport    Required (if using port)
   * @param string $dbsocket  Optional
   * @return void|DBHandler
   */
  public function openTool($dbuser = '', $dbpass = '', $dbserver = '', $dbport = '', $dbsocket = ''){

    if(isset($this->newState)){
      $conName = in_array($this->reloadName($this->newState), self::conNames, true) ? $this->newState : DBCON;
    }else{
      $conName = DBCON; 
    }

    $conName = $this->reloadName($conName);

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

    $conClass =  __NAMESPACE__ ."\DB\\". $conName;

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
   * @return boolean|@\core\classes\handler
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

  //switch connection type //This may be removed in future version
  public function misql(){
    $this->switchTo("MiSQL");
  }

  //switch connection type //This may be removed in future version
  public function mipdo(){
    $this->switchTo("MiPDO");
  }
  
}