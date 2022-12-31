<?php

namespace spoova\core\classes;

class DB implements DBHelpers{
  
  private ?DBBridge $conn = null; //dbconnection
  private ?DBHandler $dbh = null; //dbhandler
  private $conName;
  private $currentDB;
  private $isConnected = false;
  
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
   * @return void
   */
  private function open_connection( $conName ){

    //remodify conName where conName is the connector class Name
  	if($conName == null && isset($this->newState)){
      
      $conName = $this->newState;

  	}else{

      $conName = in_array($this->reloadName($conName), self::conNames, true) ? $conName : DBCON;	

  	}
    
    $conName = $this->reloadName($conName);

  	$conClass =  __NAMESPACE__ ."\\". $conName;

    if( @class_exists($conClass) ) {

      $conn = new $conClass; 
      return $this->dbh = $this->selfUpdate($conn);    

    } else {

      $this->error = 'connection class not found!';

    }

    //  $this->conName = '';
    //  $this->isConnected = false;
    //  $this->currentDB = '';   
    //  $this->dbcon = '';
    //  return $this->dbh = null;

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
   * @return void
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
   * @return void
   */
  private function testSock($value = ''){
    $value = ltrim($value, ":");
    $ext = pathinfo($value,PATHINFO_EXTENSION);

    return (strtolower($ext) === "sock");
  }

  /**
   * Undocumented function
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

    $conClass =  __NAMESPACE__ ."\\". $conName;
    
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
   * @return void|@core/classes/DBHandler
   */
  public function openTool($dbuser = '', $dbpass = '', $dbserver = '', $dbport = '', $dbsocket = ''){

    if(isset($this->newState)){
      $conName = in_array($this->reloadName($this->newState), self::conNames, true) ? $this->newState : DBCON;
    }else{
      $conName = DBCON; 
    }

    $conName = $this->reloadName();

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

    $conClass =  __NAMESPACE__ ."\\". $conName;

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


/**

  #documentations:

  @database handler => MYSQL (or API or MYAPI), PDO. default is PDO

     -parameters for PDO connection: PDO 
     -parameters for MySQL connection: MySQLi 


     #NOTE 1: anywhere "API" is used as parameter, it means either parameters for PDO or MySQL connection can be used.
     ----------------------------------------------------------------------------------------------------------------------------------------------
     #NOTE 2: @params "PDO" => "PDO" or "MyPDO" can be interswitched as the parameter for pdo connection
     #NOTE 3: @params "API" => "API" or "MyAPI" or "MYSQL" can be interswitched as the parameter for mysqli connection

  @connection parameters => $dbname,$dbuser,$dbpass,$dbserver,$dbport,$dbsocket 

  #Syntax:

  //initialize class
  1) $dbcon = new DB([API,MYSQL,MYAPI] | [PDO,MYPDO] | NULL); //initialize DB with defined db handler parameters or default db handler parameter

  //opening connection
  $db = $dbcon->open(); //open connection with default db handler parameters
  $db = $dbcon->open([API,MYSQL,MYAPI] | [PDO,MYPDO]); //open connection with defined default db handler parameter, OR

  $db = $dbcon->openDB(); //open connection with defined db connection parameters or default db connection parameter  
  $db = $dbcon->openDB(DBNAME, DBUSER, DBPASS, DBSERVER, DBPORT, DBSOCKET | NULL); //open connection with defined db connection parameters or default db connection parameters (FULL) (recommended)
  $db = $dbcon->openDB(DBNAME, DBUSER, DBPASS, DBSERVER, DBPORT); //same as above for four paramters (PORT) (recommended)
  $db = $dbcon->openDB(DBNAME, DBUSER, DBPASS, DBSERVER, DBSOCKET); //same as above four four paramters (SOCKET) (may need to supply full parameters if it doesn't work)

  //database operations will be discussed under #Methods

  //close connection
  $db->close();


  #Methods:

  $db->mypdo() // switch to PDO connection
  $db->myapi() // switch to MYSQL connection

  $db->switchDB(DBNAME, DBUSER, DBPASS, DBSERVER, ) // switch connection to a new database to a new database
  $db->switchDB("D") // switch connection back to default database connection
  $db->newDB(dbname,$handler); // creates an handler for a new database using the same connection 

  $db->conResponse() //returns connection response for $db->switchDB();

  $db->conType() // returns either PDO or MYSQLI

  $db->currentDB() // returns the current database being connected to. If none is found, it returns default database name set in core\dbconfig.php

  $db->query($sql, $bindedparamters | null) // run queries

  $db->process() // execute queries other than CRUD operations

  $db->setData([]) // sets an array of data.  


  //CRUD methods

  $db->insert_into($sql), $db->columns([$columns]), $db->values([$values]), $db->insert() // perform insert

  $db->select($sql), $db->read() // perform fetch  

  $db->do_update($sql), $db->update() // perform fetch  

  $db->do_delete($sql), $db->delete() // perform delete    

  //CRUD operators
  They are responsible for performing specific operations and cannot be replaced. These are listed below

  $db->insert() // for inserting data into database
  $db->read()   // for reading from database
  $db->update() // for updating table rows
  $db->delete() // for deleting from table

  //Execute operator
  Performs mainly non-crud operation.
  $db->process();

  NOTE: All crud operators  can all be used along with $db->query() to peform crud operations depending on type of operation to be performed. If used with $db->query(), crud operators must come immediately after $db->query().


  For example:

  $db->query($sql); //set query
  $db->read(); // execute query

  
  ..creating a connection (example)
  
  $dbcon = new \core\classes\DB();
  $toolmess = ($dbcon->openDB(dbuser, dbpass, dbserver, dbsocket, dbport))? ("tool connected") : ('tool connection failed'); //db tool : tool allows unspecified DB operations
  $opendb = ($dbcon->tool(dbuser, dbpass, dbserver, dbsocket, dbport))? ("tool connected") : ('tool connection failed'); //db tool : tool allows unspecified DB operations
  $connmess = ($dbcon->active())? ("connected") : ('connection failed'); //db active : active allowed specified DB operations
  print_r(json_encode(['tool'=>$toolmess,'conn'=>$connmess]));

*/