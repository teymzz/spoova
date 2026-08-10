<?php
namespace spoova\mi\core\classes\DB;

use Closure;
use DBStatus;
use ErrorException;
use ReflectionClass;
use spoova\mi\core\classes\Activity;
use spoova\mi\core\classes\Container\Container;
use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\DB\DBBridge;
use spoova\mi\core\classes\DB\DBHelpers;
use spoova\mi\core\classes\UserAuth;

//-------------------------------------DBHANDLER CLASS ----------------------------------------
/**
 * Database handler for managing or modifying connections
 * Currently Supports Mysqli and PostGreSql database system
 * Database Connections: While default is PDO, it also supports Mysqli connections
 * 
 * Handler is capable of storing queries in static states than can be executed or used later.
 * Future feature will support MongoDB connection
 */
class DBHandler Implements DBHelpers{
	
  use StrictRules, Helpers, DBQuery, 
	    DBState, DBInsert, DBSelect, DBUpdate, DBDelete, DBCrud, OSql,
	    DBDATA, DBLimit,
	    DBError, SQLJoin;

  /**
   * Connection is an instance of DBBridge
   *
   * @var DBBridge|null $conn
   */
	private ?DBBridge $conn = null;
  
  /**
   * 
   *
   * @var DB
   */
  private ?DB $DB = null;

  /**
   * sqlquery compiled
   *
   * @var string
   */
	private string $sqlquery;

  /**
   * Allows the use of setData function on query method
   *
   * @var bool
   */
  private $usedata;

  /**
   * Refers to an applied CRUD helper method name (i.e insert, read, update, delete, process)
   *
   * @var string
   */
  private ?string $crud_name = null;

  public ?bool $fetched = null;
  
  /**
   * set the instance of a new connection
   *
   * @param DBBridge $conn connection instance of DBBridge
   * @param DB $db 
   */
  function __construct(DBBridge $conn, ?DB $db = null){

    if($conn->isConnected()){

      $this->conn = $conn;
      $this->DB = $db;

    }else{
      return $this->call_error("no database connected:");        
    }

  }


  /**
   * switch to a new database
   */
  public function switchDB(string $dbname, ?string $dbuser = null, ?string $dbpass = null, ?string $dbserver = null){
    if($this->conn != null){
      if($this->conn->switchDB($dbname,$dbuser,$dbpass, $dbserver)){
        return true;
      }
    }

    return false;
    
  }
  
  /**
   * return base connection
   *
   * @return DBBridge|null
   */
  public function dbcon(){
    return $this->conn != null ? $this->conn->dbcon() : null;
  }
  
  /**
   * return connection controller
   *
   * @return DB
   */
  public function db(){
    return $this->DB;
  }

  /**
   * Return current connection
   *
   * @return string
   */
  public function currentDB() : string {
    return $this->conn->currentDB();
  }

  /**
   * return a success or error response for a new connection
   *
   * @return string
   */
  public function conResponse() : string {
    return $this->conn->conResponse();
  }

  /**
   * Connection type as MySQLi or PDO
   *
   * @return string
   */
  public function conType() : string {
    return $this->conn->conType();
  }    

  /**
   * picks a key from a $array.Supplied. All none arrays are converted to empty strings
   *
   * @param mixed $array
   * @param int|string $arraykey
   * @param mixed $return
   * @return array|boolean|$return
   */
  private function array_pick(&$array, $arraykey, mixed $return = null){
    // picks out a key and its values from an array
    // sets $array as $array[$arrayKey] if $arrayKey exists in $array and (returns true)
    // sets $array as $return (if supplied) and array key cannot be found (returns false)
    $getArray = is_array($array)? $array : [] ;

    if( array_key_exists($arraykey, $getArray) ){

      $array = $array[$arraykey];
      return true;

    }else{

      $array = ($return != null)? $return : $array;
      return false;

    }
  }
    
  private function checkdb(mixed $db){

    $con = $db;

    if(is_object($con)){

        $ncon = (array) $con;

        if(is_array($ncon)){
        
          foreach ($ncon as $key => $value) {

          if(is_object($value)){
            $value = (array) $value;
          }
          $n[$key] = $value;
        }

        $n = $n ?? '';
        $n = !is_array($n)? array() : $n;

        foreach($n as $x => $r){
          if(is_array($r)){
            $p[] = $r;
          }
        }
      
      if(isset($p[0])){
        $this->array_pick($p, 0);
        if(array_key_exists("client_info",$p)){
          $x = true;
        }else{
          $x = false;
        }
      }else{
        $x = false;
      }
        }else{
           $x = false;
      }
    }else{
      $x = false ;
    }

    if($x == true){
    	return true;
    }else{
        return $this->call_error('Database connect error'); 	
    }
  }

  /**
   * Returns the last sql query. Used for debugging
   *
   * @return string
   */
  public function expose_sql(){
    echo "<br>".$this->sqlquery; 
  }

  /**
   * prints out the sql parameters
   *
   * @return void
   */
  public function expose_vars(){
    return false;
    $classvars = get_class_vars(__CLASS__);
    echo "<br><br><pre>";
    foreach ($classvars as $key => $value) {
        
          if($key !='conn'){
            print_r($key." : ".json_encode($this->$key)."<br><br>");
          }else{
              echo $key." : This is connection <br> ";
          }
    }
    echo "</pre>"; 
  }


  #--------------------------------Clean / Unset all variables initially set by queries--------------------------------------

  private function freeVars($param = false){

    $classvars = get_class_vars(__CLASS__);
    if($param == false){
        $strictvars =  ['conn','sqlquery','data','strict','where','into','statename','queryState','metrics','metrics_mode'];
    }else{
        $strictvars =  ['conn'];     
    }

    $class  = new ReflectionClass(__CLASS__);

    foreach($class->getProperties() as $property){

      if(in_array($property->getName(), $strictvars, true)) continue;

      $property->setAccessible(true);
      $defaultProperties = $class->getDefaultProperties(); 

      if(array_key_exists($property->getName(), $defaultProperties)){
        if($property->isStatic()){
          $property->setValue(null, $defaultProperties[$property->getName()]);
        }else{
          $property->setValue($this, $defaultProperties[$property->getName()]);
        }
      }


    }

    $this->limit  = null;
    $this->errlog = array();
    $this->results = array();
    $this->fetches = false;
    return true;
  }

  public function close(){

    if($this->checkdb($this->conn)){
      $this->conn->close_connection();
      $this->conn = null;  	
    }

    $this->conn = null;
    $classvars  = get_class_vars(__CLASS__);
    $class      = new ReflectionClass(__CLASS__);
    $statics    = $class->getStaticProperties();

    foreach ($classvars as $key => $value) {
      
      if(in_array($key, $statics)) {
        if(is_array(self::$$key)){
          self::$$key = [];
        }else{
          self::$$key = null;
        }
      }else{
        if(is_array($this->$key)){
          $this->$key = [];
        }else{
          $this->$key = null;
        }
      }
    }

    $this->errlog = array();

  }

}


//* ALl DBHandler Traits -----------------------------------------------------------------------------------------
/**
 * Trait of DBHandler. Provide helper methods for certain strict rules.
 */
trait StrictRules{

  private $strict = false;

  /**
   * Prevents an all appending database 
   * operations from running if an error occurs
   * This method should be defined before running queries
   *
   * @return void
   */
  public function use_strict(){
     $this->strict = true;
  }

  /**
   * This method modifies the global UserAuth connection with the
   * instance of this class connection.
   * 
   * -This method should only be used when the global connection needs to change
   * -It is important to note that this method will affect how the UserAuth class responds
   * -When UserMod is called, then there is absolutely no need to create a new instance of UserAuth where
   * connection will be supplied.
   *
   * @return void
   */
  public function UserMod(){
    if($this->conn->isConnected()){
      new UserAuth($this->DB, $this); 
    }
  }
}


//-----------------------------------FLAT QUERY TRAIT----------------------------------------------
/**
 * Trait of DBHandler. Handles raw query operations
 */
trait DBQuery{

  private ?Closure $crud_exec_callback = null;

  /**
   * executes crud_exec_callback's closure function.
   *
   * @return array
   */
  private function crud_exec_callback() {
    
    Container::feeder(['db' => $this, 'dbh' => $this, 'name' => $this->crud_name], function(){
      Container::instance()->callFunction($this->crud_exec_callback);
    });

  }
  /**
   * sets sql queries
   *
   * @param array $query sql query
   * @param array $data binded parameters
   * @param boolean $usedata TRUE disables the use of binded parameters for raw sql queries
   * @return DBHandler
   */
  public function query($query, array $data = [], $usedata = false){
    $this->freeVars();
    $this->sqlquery = $query;
    $this->data     = $data;

    if($usedata === true){
       //use along with global scope of setData Method
       $this->usedata  = true;
    }else{
      //use only data supplied within this scope (i.e $data)
      $this->conn->useData(false);
    }
    return $this;
  }

  /**
   * method for executing CRUD and non-CRUD operations
   *
   * @return true if query is successful else, it returns false
   */
  public function process() : bool {
    
    $this->crud_name = __FUNCTION__;
    if($this->sqlquery == null){ return $this->call_error("Error: no query not Supplied"); return false; }

    $this->conn->buildBind($this->data, $this->sqlquery); // sets data for DBM

    $sql['sql'] = $this->sqlquery;
    
    Activity::bench($uid = uniqid());
    $process = $this->conn->process_query($this->sqlquery);


    if($process === false){
      $this->add_metrics($sql, $uid, 'failed');
      if($this->conn->error_exists()){ 
        return  $this->call_error("Failed:".$this->conn->error()); 
      }else{
        return  $this->call_error("Failed: Something went wrong");
      }      
    }
    
    if($this->conn->error_exists()){
      return  $this->call_error("Failed:".$this->conn->error());
    } 

    if ($this->crud_exec_callback) {
      $this->add_metrics($sql, $uid, 'failed');
      $this->crud_exec_callback(); // process executed.
    }

    return $process;
  }

  /**
   * Executes a callback function on any CRUD operation successfully performed
   *
   * @param Closure $callback
   * @return void
   */
  public function onCRUD(Closure $callback){

    $this->crud_exec_callback = $callback;
    return $this; 
  }

}

//-----------------------------------FETCH DATA TRAIT----------------------------------------------

/**
 * Trait of DBHandler. Handles select operations
 *  @mixin DBHandler
 */
trait DBSelect {
    private string $select;
    private int|string $numrows;
    private $results = [];
    private $fetches = false;

   /**
    * short-hand method for performing select queries
    *
    * @param string $sql as sql query to be supplied
    * @return self
    */
    public function select(string $sql) : self{
      if($this->strict != true){
        $this->freeVars();
      }

      $this->limit = $this->buildLimit(false);
      $this->sqlquery  = null;
      $this->data = [];
      $this->where = null;

      //$this->expose_vars();
      $this->select    = "select ".$sql;
      $this->sqlquery  =  $this->select;
      return $this;
    }

    /**
     * preferred method for execting fetch queries
     *
     * @param string|null $limit1
     * @param string|null $limit2
     * @return array|false
     *  - Boolean false is returned if error occurs
     *  - Array is returned if no error occurs
     */
    public function read(?string $limit1 = null, ?string $limit2 = null): array|false {
       
       $this->crud_name = __FUNCTION__;
       //This line stops query once error is found in previous connections
       if(($this->find_error())  == true){ 
      	return $this->call_error("no results found: previous connection error");  //cannot read (strict)
       }

       // This line calls error for no connection found!!!
       if($this->conn == null){
        return  $this->call_error("no connection found");
       }
	     
	     $this->fetched = true;
	 
       $sql['sql'] = $this->sqlquery;  //sets sql['sql']
       if(!empty($this->where)){$sql['where'] = '';}  //sets sql['where']
       $this->conn->buildBind($this->data, $this->sqlquery); //binds data
       $this->limit($limit1, $limit2);

       //check if connection data return is not false (or empty)
         //if false check if there is error
            //if error is found return the error log
       Activity::bench($uid = uniqid());
       if(($array = $this->conn->fetch_array($sql)) !== false){
           $this->numrows = $this->conn->num_rows();
           $this->limit   = $this->buildLimit(false);
           $this->results = $array;
           $this->fetches = $array;
           
           $this->add_metrics($sql, $uid, 'success');
           $this->crud_exec_callback();
          //  ContainerFunction::resolve($this->crud_exec_callback, [$this, $this->crud_name], 'test');
           return $array;        
       }else{
	        if($this->conn->error() != null){ 
            $error = $this->conn->error(true);
            $benchtime = Activity::benched($uid);
            
            $this->add_metrics($sql, $uid, 'failed');
            return  $this->call_error($error);        
         }else{
            return $this->call_error("no results found: error in connection");       	
         }
       }

      }
      //return the number of rows
      public function num_rows(){ 
        return $this->conn->num_rows();
      }

      /**
       * Returns the results of read / fetched data directly from source.
       *  - Note: coloned integers are strings that contains integers that have colon (:) as prefix ( e.g ':20' )
       *
       * @param int|string $param - options [null|int|':count'|':shuffle'|':MAX_LENGTH' (e.g ':2')]
       * @param string $key optional [subkey|':shuffle']
       *  - where $key is data column name existing as a subkey of data[$param] 
       *  - where ':shuffle' is the same as when $param is set as ':shuffle'
       * @return mixed
       * 
       *  -     @return int 
       *  - -   when counted (i.e $param = ':count')
       *  -     @return array
       *  - -   when no arguments supplied, returns all data
       *  - -   when data shuffled (i.e ($param = ':shuffle')) 
       *  - -   when data shuffled (i.e ($param = '', $key = ':shuffle'))
       *  - -   when data indexed (i.e ($param is a number preceded by colon character))
       *  -     @return string 
       *  - -   when $param is a valid data index and $key is a valid column name.
       * 
       */
      public function results($param = '', string $key = ''){
        $results = $this->results; //array
        $count   = count($results); //int
        
        //return results if no argument is supplied
        if(func_num_args() === 0){
          return $results;
        }  

        //return counts if requested as argument
        if($param === ':count'){
        	return $count;
        }
        
        //return shuffled results if : 
        // case1: $param is set as ':shuffle' or 
        // case2: $param is empty string and $key is set as ':shuffle'
        if( ($param === ':shuffle') || ($param === '' && $key === ':shuffle') ){
          shuffle($results);
          return $results; //array
        }        
        
        //resort argument by splitting coloned integers
        if(!is_numeric($param)){

          if(substr($param, 0, 1) === ':'){

            $exp = explode(":", $param);

            if(count($exp) === 2){
              if(is_numeric($exp[1])){
                $firstIndices = ":";
                $param = $exp[1];
              }else{
                trigger_error('invalid argument format supplied');
                return [];
              }
            }

          }

        }
        
        //if $param is invalid or does not exist in result, return empty array
        if(!is_numeric($param) || !array_key_exists($param, $results)) return [];
        
        //if $param is not an integer with a colon as prefix, 
        // resolve as a data's index (or key)
        if(!isset($firstIndices)){
          
          if(!empty(trim($key))) {
            if(array_key_exists($key, $results[$param])){
              //if both $param and $key is supplied, return the value of $key where 
              // $key is a subkey of $param
              return $results[$param][$key]; //string
            }
            return [];
          }
          
          //if $key is not supplied, return value of $param
          return $results[$param]; //array

        } else {
          
          //if is $param is an integer preceded by colon, 
          //get the first array keys using the maximum length of $param.          
          $iresults = []; $i = 0;
					foreach($results as $result){
						if($i === $param){ break; } //where $param is indices stopping point
						$iresults[] = $result;
						$i++;
					}
					
					if($key === ':shuffle') shuffle($iresults);
          return $iresults; //array
          
        }

      }

}


//---------------------------------INSERT DATA TRAITS------------------------------------------
/**
 * Trait of DBHandler. Handles insert operations
 */
trait DBInsert{

  private string $insert_into;
  private array $column_keys;

  /**
   * Connection insertion id
   *
   * @var null|int
   */
  private $connID;

  /**
   * Constructs the insertion query
   *
   * @param string $table name of database table
   * @param array $data array of binded pair key(column) and values(values) parameters
   * @return DBHandler
   */
  public function insert_into(string $table, ?array $data = null) : DBHandler {

      $this->freeVars(true);
      $this->limit = $this->buildLimit(false);
      $this->insert_into = " insert into ".$table;

      if(!$table){
        trigger_error('invalid (empty) table name supplied for database insertion');
      }

      $this->sqlquery = $this->insert_into;
    
      if($data != null && is_array($data)){
        $this->setData($data);
        $this->prepare_insert();
      }
      return $this;

	}

  /**
   * sets the data insertion columns
   * 
   * @uses \func_get_args(), to specify database table columns for inserting data 
   * @return DBHandler|false
   */
	public function columns() : DBHandler|false {

		if($this->sqlquery == null){ return $this->call_error('no query found earlier'); }

    $args = func_get_args();
    $hasArray = array_filter($args,'is_array')? true : false;
    
    if(count($args) > 1 && $hasArray == true){
      return ($this->call_error('cannot accept both arrays and columns'));
    }

    if($hasArray == true){
      //split array argument;
      $new_args = $args[0];
    }else{
      // values argument
      $new_args = $args; 
    }
    $this->column_keys = $new_args;
    return $this;

	}
	

  /**
   * Sets the insertion values based on the number of arguments supplied.
   * 
   * @uses \func_get_args(), string values to be inserted into columns 
   * @return DBHandler|false
   */
	public function values(): DBHandler|false {

		if($this->sqlquery == null){ return $this->call_error('no query found earlier'); }

		if($this->sqlquery == null){ return $this->call_error('no fields found earlier'); }		

    $args = func_get_args();
    $hasArray = array_filter($args,'is_array')? true : false;
    if(count($args)>1 && $hasArray == true){
      return ($this->call_error('Invalid Data Supplied'));
    }

    if($hasArray == true){
      //split array;
        $new_args = $args[0];
    }else{
        //split arguments
        $new_args = $args;
    } 

    if(count($this->column_keys)!=count($new_args)){
      return $this->call_error('Fields and values do not match');
    }

    $ckeys   = $this->column_keys;
    $newkeys = array_combine($ckeys, $new_args);
    $this->data = $newkeys;

    return $this;

	}

  /**
   * prepares an insert query before execution
   *  - This only saves the SQL query structure. It does not trigger any SQL error. 
   *    Any error being retrieved must be from previously executed queries.
   * @return bool
   *  - TRUE : if query was stored in DBHandler.
   *  - FALSE : if any pre-existing error stops query from being stored.
   */
  public function prepare_insert() : bool {

    //This line stops query once error is found in previous connections
    if(($err = $this->find_error())  == true){ 
      return $this->call_error("Something went wrong");
    }

    // This line calls error for no connection found!!!
    if($this->conn == null){
      return  $this->call_error("no connection found");
    }

    $data = $this->data;
    $i = 0;

    $Fields = $FVals = [];

    $Fields = array_keys($data);
    $values = array_values($data);

    $values = array_map(function($value){

      return (array) $value;

    }, $values);

    $output = []; $params = [];

    $columnCount  = count($values[0]);

    for($i = 0; $i < $columnCount; $i++){
      $output[] = array_column($values, $i);
    }

    $placeholders = array_map(function($val) use(&$params){
      $count = count($val);

      $val = array_map(function($v){
        if(is_string($v)){
          return str_replace("'now()'","now()", $v);
        }
        return $v;
      }, $val);

      array_push($params, ...$val);
      return '('.rtrim(str_repeat('?, ', $count), ' ,').')';

    }, $output);

    $keys = "`".implode("`,`",$Fields)."`" ;
    $values = (implode(', ',$placeholders));

    $this->data = $params;

    $this->sqlquery = $this->sqlquery." ($keys) values {$values}"; //sets sql insert (full query)
    return true;
  }

  /**
   * Performs insert operation
   *
   * @return bool
   */
	public function insert() : bool{
    
    $this->crud_name = __FUNCTION__;    
    if($this->usedata){ $this->prepare_insert(); }
    $sql['sql'] = $this->sqlquery;  //sets sql['sql']

    $this->conn->buildBind($this->data,$this->sqlquery); //binds data
    
    Activity::bench($uid = uniqid());  

    //check if connection is not false
    if(($this->conn->insert_query($sql)) == false){

      if($this->conn->error() != null){ 

        $message = $this->call_error("Failed: Something is wrong");  

      }else{

        $message = $this->call_error("Failed: Something went wrong");

      }

      $this->add_metrics($sql, $uid, 'failed');
      return $message;

    }else{

      $this->connID = $this->conn->insert_id();
      $this->add_metrics($sql, $uid, 'success');

      $this->crud_exec_callback();

      return true;
    
    } 
   
  }

  /**
   * Connection insert id
   *
   * @return string|int
   */
  public function insertID(){
    return $this->connID ?? '';
  }	

}


//---------------------------------UPDATE DATA TRAITS------------------------------------------------
/**
 * Trait of DBHandler. Handles update operations
 */
trait DBUpdate{

  private string $update;
  private string $set;

  /**
   * for contructing update queries
   *
   * @param string $tableName database table name
   * @return DBHandler
   */
  public function do_update(string $tableName){

    $this->freeVars(true);    
    $this->limit = $this->buildLimit(false);
    $this->update = " update ".$tableName;
    $this->sqlquery .= $this->update;
    return $this;

  }
  
  /** 
   * for contructing update queries
   *
   * @param string $values queries after the "set" word
   * @return DBHandler
   */
  public function set(string $values){

    if($this->sqlquery == null){return $this->call_error("no query found earlier");}
    $this->data = [];
    $this->set = $values;
    $this->sqlquery .= " set ".$values;
    return $this;

  }

  /**
   * Perform update operations
   *
   * @return bool
   */
  public function update() : bool {

    $this->crud_name = __FUNCTION__;

    //This line stops query once error is found in previous connections
    //This prevents uneccessary data insertions
    if(($err = $this->find_error())  == true){ 
     return $this->call_error("no results found, previous connection error");  //cannot read
    }

    // This line calls error for no connection found!!!
    if($this->conn == null){
     return  $this->call_error("no connection found");
    }

    $sql['sql'] = $this->sqlquery;  //sets sql['sql']
    if(!empty($this->where)){$sql['where'] = '';}  //sets sql['where']

    $this->conn->buildBind($this->data,$this->sqlquery); //binds data
       
    Activity::bench($uid = uniqid());
    
    //check if connection is not false
      //if false check if there is error
         //if error is found return the error log 
    if(($this->conn->update_query($sql))!==false){
     
       $this->freeVars(); //free variables except few  

       $this->crud_exec_callback();
       $this->add_metrics($sql, $uid, 'success');
       
       return true;    

    }else{

      if($this->conn->error() != null){ 
        $message = $this->call_error('Error');        
      }else{
        $message = $this->call_error("Something is wrong!!! Try again later");     
      }
      $this->add_metrics($sql, $uid, 'failed');

      return $message;

    }   
     
   }  

}

//---------------------------------DELETE DATA TRAITS------------------------------------------------
/**
 * Trait of DBHandler. Handles delete operations
 */
trait DBDelete{ 

  private string $delete;

	public function do_delete(?string $tbname = null){

     if($this->strict != true){
       $this->freeVars();
     }    

     $this->limit = $this->buildLimit(false);
     $this->sqlquery  = null;
     $this->data = [];
     $this->where = null;

     $this->delete    = " delete ".$tbname;
     $this->sqlquery  =  $this->delete;
     return $this;

  }

  /**
   * Performs delete operation
   *
   * @param string|int|null $limit1 sql optional limit
   * @return bool
   */
  public function delete(string|int|null $limit1 = null) : bool {

    $this->crud_name = __FUNCTION__;

    //This line stops query once error 
    //is found in previous connections
    //This prevents uneccessary data from deleting, hence prevents loss of data
    if($this->find_error()){ 
      return $this->call_error("no results found, previous connection error");  //cannot read
    } 
    
    // This line calls error for no connection found!!!
    if($this->conn == null){
      return  $this->call_error("no connection found");
    }

    $sql['sql'] = $this->sqlquery;  //sets sql['sql']
    if(!empty($this->where)){$sql['where'] = '';}  //sets sql['where']

    $this->conn->buildBind($this->data,$this->sqlquery); //binds data

    if($this->limit == null){
      //This line sets limit by limit method validation
      if($this->limit($limit1, null) === false){
        return false; 
      }        
    }else{
      //This line prevents multiple instantiations of limit
      return  $this->call_error("limit cannot be applied more than once");        
    }
    
    Activity::bench($uid = uniqid());

    //check if connection is not false
      //if false check if there is error
          //if error is found return the error log
    if(($this->conn->delete_query($sql)) !== false){

      $this->freeVars(); //free variables except few     
      
      $this->add_metrics($sql, $uid, 'success');
      $this->crud_exec_callback();
      
      return true;        

    }else{

      if($this->conn->error() != null){ 
        $message = $this->call_error($this->conn->error());        
      }else{
        $message = $this->call_error("Something is wrong!!!");     
      }

      $this->add_metrics($sql, $uid, 'failed');

      return $message;
    }  

  }

}

/**
 * Trait of DBHandler. Relative to metrics and retrieving information
 */
trait DBCrud{
  
  private static array $metrics = [];
  private static int $metrics_mode = 0;
  private static bool $analyze = false;

  /**
   * Add benchtime metrics
   *
   * @param array $sql sql info
   * @param string $uid benchmark id
   * @param string $status optional [success|failed]
   * @return void
   */
  private function add_metrics($sql, string $uid, string $status) {
    if(self::$metrics_mode === 0) return;
    $benchtime = Activity::benched($uid);
    static::$metrics[] = [
      'query' => $sql['sql'],
      'conName' => strtoupper(DB::DBCON(true)),
      'timeframe' => $benchtime['timeframe'],
      'runtime' => $benchtime['runtime'],
      'status' => $status,
      'response' => $this->error(true),
    ];
    if(self::$metrics_mode === 2){
      $analyses = $this->explain($sql);
      $dataAnalyzed = [];
      foreach($analyses as $analysis){
          $dataAnalyzed[] = array_filter($analysis, fn($value) => $value !== NULL);
      }
      static::$metrics[count(static::$metrics)-1]['analysis'] = $dataAnalyzed;

    }
  }
  
  /**
   * Apply inline configuration within a chained structure
   *
   * @param Closure $config
   * @return DBHandler
   */
  public function apply(Closure $config): DBHandler{
    $config();
    return $this;
  }

  /**
   * Explain specified SQL query
   *
   * @param array $sql
   * @return array|false
   */
  public function explain(array $sql): array|false {
    $sql['sql'] = 'EXPLAIN '.$sql['sql'];
    return $this->conn->fetch_array($sql) ?: [];
  }

  /**
   * Returns all applied CRUD queries
   *
   * @return array
   */
  public static function queries() : array {
    $metrics = static::$metrics; $queries = [];
    foreach($metrics as $query){
      $queries[] = $query['query'];
    }
    return $queries;
  }

  /**
   * sets permission for enabling metrics or returns metrics data
   *
   * @param integer $mode optional [0|1|2]
   *  - 0: returns metrics data 
   *  - 1: enables simple metrics analysis 
   *  - 2: enable advanced metrics analysis
   * @return array
   */
  public static function metrics(int $mode = 0): array {
    if(!in_array($mode, [0, 1, 2])) throw new ErrorException('argument(#1) must be set at 0, 1 or 2.');
    if(in_array($mode, [1, 2])){
      self::$metrics_mode = $mode;
      return [];
    }
    return static::$metrics; 
  }

  /**
   * Returns the metrics mode
   *  - 0: disabled
   *  - 1: simple
   *  - 2: advanced
   * @return integer
   */
  public static function metrics_fetch_mode(): int {
    return static::$metrics_mode; 
  }

}

//---------------------------------JOIN DATA TRAITS------------------------------------------------
/**
 * Trait of DBHandler. Provides query join helper methods (join, on).
 */
trait SQLJoin{

	private string $join;
	private string $join_on;
  private array $sqljoin;
	
	public function joins(string $param, string $sqljoin = ''){
		if($this->sqlquery == null){return $this;}
		if($this->where != null){ $this->call_error("cannot perform a join after 'where' query"); return $this;}

    $valid_joins[] = "CROSS JOIN";
    $valid_joins[] = "JOIN";        
    $valid_joins[] = "FULL JOIN";
    $valid_joins[] = "INNER JOIN";
    $valid_joins[] = "LEFT OUTER JOIN";
    $valid_joins[] = "LEFT JOIN";       
    $valid_joins[] = "RIGHT JOIN";       
    $valid_joins[] = "CARTESIAN";

    if(in_array($sqljoin,$valid_joins)){
      if($sqljoin != "CROSS JOIN" and $sqljoin != "CARTESIAN"){

        $this->join = " $sqljoin ".$param;
        $this->sqljoin[]  = $sqljoin;
        $this->sqlquery .= $this->join;
      }
    }
		return $this;
	} 

	public function on(string $param){
		if($this->sqlquery == null){return $this; }
		if($this->sqljoin  == null){return $this; }
		$this->join_on = " ".$param;
		return $this;
	} 

}

//-------------------------------- LIMIT DATA TRAITS -------------------------------------------------
/**
 * Trait of DBHandler
 */
trait DBLimit{
    private string|false|null $limit;

    private function limit(string|int|null $lim1 = null, string|int|null $lim2 = null){

		  if($this->sqlquery == null){ return $this; }
    
      if($lim1 != null && !is_numeric($lim1)){
        return $this->call_error("invalid limit: Parameter 1");
      }

      if($lim2 != null && !is_numeric($lim2)){
        return $this->call_error("invalid limit: Parameter 2");
      }
        
      $limArr = [];
      if($lim1 != null && is_numeric($lim1)){
        $limArr[0] = $lim1;
      }
    
      if($lim2 != null && is_numeric($lim2)){
        if($lim1 == null){ $limArr[0] = "0"; }
        $limArr[1] = $lim2;
      }

      if($lim1 == $lim2 && $lim2 == null){
        $limArr = [];
      }
      
      $this->limit = $this->buildLimit($limArr);
   
		return $this;
	}

  
  /**
   * Build the limit used. Supports only a maximum of two limits range. See {@see DBBridge::buildLimit()}
   *  - depends on the argument supplied which can be : 
   *    - array: [from, to]
   *    - false: unsets the limit 
   * 
   * @return string|false|null
   */
  private function buildLimit(array|false $limit) : string|false|null {
    /** @var DBBridge $conn */
    $conn = $this->conn;
    return $conn->buildLimit(...func_get_args());
  }
}

//-------------------------COMMANDS WHERE, FROM ---SQL CONJUCTION---------------------------------
/**
 * Trait of DBHandler. Provides conditional methods (from, where, order)
 */
trait OSql{

	private string $where;
	private string $from;
  private string $order;

  public function from(string $param){
    if($this->sqlquery == null){ return $this; }
    $frm =  " from ".$param;
    $this->sqlquery .= $frm;
    if(!empty($this->from)){ $this->call_error('use of from more than once');  return $this; }
    $this->from  = $frm;
    return $this;
  }


	public function where(string $param) : DBHandler { 
    if($this->sqlquery == null){ return $this; }
    if(($this->update != null)&&($this->set == null)){
      return $this->call_error("cannot perform where before set query");
    }
		$this->where = " where ".$param;
		$this->sqlquery .= $this->where;
    return $this;
	}
   
  /**
   * Sets the table sorting order
   *
   * @param string $param order to be used to sort table.
   * @return DBHandler
   */
  public function order(string $param) : DBHandler {
    if($this->sqlquery == null){ return $this; }
    $ord =  " order by ".$param;
    $this->sqlquery .= $ord;
    $this->order  = $ord;
    return $this;
  }

}


//--------------------------- DATA TRAITS ------------------------------------------------ 
/**
 * Trait of DBHandler. Provides global setData method.
 */
trait DBDATA{
  
  private array $data = [];

  /**
   * Sets SQL parameters
   *   - Note: keys and parameters may both be applied where necessary
   * @param array $arr
   * @return void|false
   */
  public function setData($arr = array()) {
    if($this->sqlquery == null){return $this->call_error("No Sql query found yet");}
    $this->data = $this->trimAll($arr);
  }
    
	private function trimAll(array $data) : array {
    
		if($data == null){ return array(); }

    $filtered = array();

    foreach ($data as $key => $value) {
      $filtered[$key] = $value;
    }

    return $filtered;

  }

}

/**
 * Trait of DBHandler. Contains all helper methods {@see DBHelpers}
 * Methods provided by this trait will only be accessible on the class 
 * instance via successful connection.
 * Trait of DBHandler
 */
trait Helpers {

  /**
   * Returns true if connection is connected
   *
   * @return boolean
   */
  public function isConnected(){
    if(!$this->conn) return false;
    return $this->conn->isConnected();
  }

  /**
   * Returns the connection name
   *
   * @return string|false connection name
   */
  public function conName(){
    if(!$this->conn) return false;
    return $this->conn->conName();
  }

  /**
   * Returns the connection type (e.g MySQL, PDO)
   *
   * @return string|false connection type
   */
  public function conType(){
    if(!$this->conn) return false;
    return $this->conn->conType();
  }  

  /**
   * Returns the connection response after a connection to database is tried
   *
   * @return string|false response
   */
  public function conResponse(){
    if(!$this->conn) return false;
    return $this->conn->conResponse();
  } 

  /**
   * Returns the currently selected database name
   *
   * @return string|false response
   */
  public function currentDB(){
    if(!$this->conn) return false;
    return $this->conn->currentDB();
  }

  /**
   * Calls the connection active method
   * Method is specific to DBHandler 
   * @see DB class 
   *
   * @return bool
   */
  public function active() : bool {
    if(!$this->conn) return false;
    return $this->conn->active();
  }

  /**
   * checks if a database exists using the current connection
   *
   * @param string $database_name
   * @return bool
   */
  public function db_exists(string $database_name) : bool {  
    if(empty($database_name)) return false;

    $db = $this->clone();
    $db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ? ", [$database_name]);
    return $db->read()? true : false;
  }

  /**
   * creates a new database by supplying the database name
   * Database connection must be active to do this
   *
   * @param string $dbname name of new database to be created
   * @return boolean TRUE if database was created or already exists, else it returns FALSE
   */
  public function createDB(string $dbname) : bool {
    
    $db = $this->clone();
    $db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ? ", [$dbname]);

    if($db->read()) return true;

    if($db->error_exists()) return false;
    
    return $db->query("CREATE DATABASE IF NOT EXISTS $dbname")->process();

  }

  /**
   * Get tables from database.
   * Gets columns from table name if argument 1 is supplied
   *
   * @param string $dbname database name (if not supplied, it assumes the currently connected database name)
   *        - $db->tables()           fetches tables of current current database
   *        - $db->tables($dbname)    fetches tables of custom database $dbname
   * 
   * @param string $tbname if supplied returns columns in table $tbname of database $dbname
   *        - $db->tables($dbname, $tbname) fetches columns in table name of custom database $dbname. 
   * 
   * @return array
   */
  public function tables(?string $dbname = null, ?string $tbname = '') : array {

    if($dbname === null){
      $dbname = $this->currentDB();
    }

    $db = $this->clone();


    if(func_num_args() < 2 && ($dbname !== null)){

      // Return tables from currently selected or defined database name $dbname
      $db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '".$dbname."';");

      $results = $db->read()? $db->results() : [];

      $result = [];
      foreach($results as $table){
        $result[] = $table['TABLE_NAME'];
      }
      return $result;  
    }

    if(func_num_args() === 2){
      $db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$dbname."' AND TABLE_NAME = '".$tbname."'");
      $results = $db->read()? $db->results() : [];
      $result = []; 
      foreach($results as $table){
        $result[] = $table['COLUMN_NAME'];
      }
      return $result;
    }

    return [];
  }

  /**
   * Check if a table exists in the database
   *
   * @param string $tablename
   * @return bool
   */
  public function table_exists(string $tablename) : bool{
    
    if(empty($tablename)) return false;
    if(func_num_args() > 1){ throw new \Error('table_exists method only takes a single parameter'); }

    $db = $this->clone();
    $db->query("DESCRIBE `".$tablename."`");
    
    return $db->read()? true : false;

  }

  /**
   * checks if a column exist in a database table
   *
   * @param string $table current connection database table name
   * @param string $column  database table column to be tested
   * @return bool true if column exists, else false
   */
  public function column_exists(string $table, string $column) : bool {

    if(empty($column)) return false;

    $db = $this->clone();

    $db->query("SHOW COLUMNS FROM `".$table."` LIKE '".$column."' ");
    
    return $db->read()? true : false;

  }

  /**
   * Add a new column to existing table
   *
   * @param array $map table and new column key pairs.
   *    - array key as table name 
   *    - array value as new column name
   * @param string $type  type (and length) of column e.g varchar(200), datetime, e.t.c 
   * @param string $pipe  column position. After can be replaced with a pipe (e.g '|email' means AFTER email)
   * @param string $definition  NULL, NOT NULL, e.t.c (default is NOT NULL if empty)
   * @param string $default  Default value for column. This should be supplied only if needed
   *      - when default is set as '0', then the datetime '1970-01-01 00:00:00' will be set as default which is equivalent to zero.
   * ``- @notice Unique
   * @return bool
   *    - Returns true if column is added. 
   * 
   *  
   */
  public function addColumn(array $map, string $type, string $pipe, string $definition = 'NOT NULL', string $default = '') : bool {

    if($map){

      $setdefault = $default;

      $type = strtolower($type);
      
      $tableName = array_key_first($map);
      $columnName = $map[$tableName];
      
      if(strpos($pipe, '|') !== false) {
        $pipe = explode('|', $pipe, 2);
        
        $pipe = 'AFTER '.$pipe[1];
      }

      $definition = trim($definition)? $definition : 'NOT NULL';
      
      $sql = "ALTER TABLE `{$tableName}` ADD `{$columnName}` {$type} {$definition} {$pipe}";

      $db = $this->clone();

      $process = $db->query($sql)->process();

      if(!$process) return false;

      if(func_num_args() > 4) {
        //proceed with default settings

        if(($default === '0') && ($type === 'datetime')){
          $setdefault = '1970-01-01 00:00:00';
        }

        $setdefault = "SET DEFAULT '{$setdefault}'";

        $sql = "ALTER TABLE `{$tableName}` ALTER `{$columnName}` {$setdefault}";

        $db->query($sql)->process();

        if(!$db->error()){

          if(($type === 'datetime')){

            //change field back to NOT NULL
            $sql = "ALTER TABLE `{$tableName}` CHANGE `{$columnName}` `{$columnName}` DATETIME DEFAULT {$setdefault}";
            $process = $db->query($sql)->process();
      
            if($db->error(true)){
                //Remove the created column
                $db->drop($tableName,  $columnName);
                return false;
            }
            
          }
          

        }else{

          //Remove the created column
          $db->drop($tableName,  $columnName);

          return false;

        }

        return true;
      }
      return true;
    }

    return false; // No map supplied

  }

  /**
   * Drop a table or Column
   *
   * @param array|string|bool $tableName name of table to be dropped
   *  -if $tableName is bool current connected database will be dropped 
   * @param string|bool|null $columnName in $tableName of table to be dropped
   *     - string value will drop column if it exists
   *     - boolean (true) will drop database
   * 
   *  - @notice: $tableName will not be dropped if $tableName is not declared unless $columnName is set as true
   *  - @Notice: If $columnName is declared, then $tableName must be a string
   * 
   * @return bool
   *  - true is returned if table is successfully dropped
   */
  public function drop(array|string|bool $tableName, string|bool|null $columnName = null) : bool {

    $db = $this->clone();
    $sql= '';
    if($tableName === true){
      $sql = "DROP DATABASE IF EXISTS `".$db->currentDB()."`";
    }else{

      if($columnName === true){
  
  
        $tableName = (array) $tableName;
        $tables = implode(', ', $tableName);
  
        $sql = "DROP TABLE IF EXISTS `{$tables}`";
  
  
      }elseif(is_string($columnName)) {
  
        $sql = "ALTER TABLE `{$tableName}` DROP COLUMN {$columnName}";
  
      }
    
    }


    $db->query($sql);
    return $db->process();

  }

  /**
   * Returns the clone of the current handler
   *
   * @return DBHandler
   */
  public function clone() : DBHandler {

    return clone $this;

  }

}

/**
 * Trait of DBHandler. Provides methods that keep the state of a query
 */
trait DBState{
  
  private static array $queryState = [];
  private static string $statename = '';
  private static ?string $statequery = null;
  private static array $statedata = [];
  private static string $statemessage;
  

  /**
   * Sets (and stores) a query for use later
   *
   * @param string $query sql query
   * @param array|null $data
   * @param string|null $statename
   * @return void
   */
  public function queryState($query, ?array $data = null, ?string $statename = null) : void{
    self::$statequery = $query;
    if($data === null) $data = [];
    self::$statedata  = $data;

    if($statename != null) $this->saveState($statename);
  }

  /**
   * Saves a state. 
   * This method can be applied on queryState() or query() methods
   * 
   * @param string $statename name of state
   * @return DBHandler|false
   */
  public function saveState(?string $statename = null) : DBHandler|false {
    
    if(trim($statename) == null){
      //set statename from class property (declared by stateSet) if it exists
      if(self::$statename == null) return false;
      $statename = self::$statename;
    }

    //if error exists save error in state name
    if($this->error_exists()){
       self::$queryState[$statename]['error'] = $this->error();
    }

    if(self::$statequery != null){

      //use queryState() properties if they exists (only query is stored)
      self::$queryState[$statename]['sql'] = self::$statequery;
      self::$queryState[$statename]['data'] = self::$statedata;

    } else {
      
      //use sqlquery if no statequery is found
      
      if($this->insertID() != null){
         self::$queryState[$statename]['insertID'] = $this->insertID();
      }
      
      if(isset($this->fetched)){
        self::$queryState[$statename]['fetches'] = $this->fetches;
      }
      
      self::$queryState[$statename]['sql'] = $this->sqlquery;
      self::$queryState[$statename]['data'] = $this->data;

    }
    self::$statemessage = 'state name "'. $statename. '" has been saved';
    return $this;

  }
  
  /**
   * @param string $statename 
   *   - If NOT defined, the method will unset the current state name
   *   - If defined, it removes the $stateName key from saved queryStates 
   * 
   * @return void
  */
  public function endState(string $statename = '') : void {
    
    //unset a declared state
    if($statename != ''){
      if(isset(self::$queryState[$statename])){
        if(self::$statename === $statename) {
          self::$statename = '';
        }
        unset(self::$queryState[$statename]);
      }
    }
    
    //unset current state
    if(func_num_args() === 0){
      self::$statename = '';
    }
    
  }

  /**
   * 1) This method is used to set a saved state (i.e an existing state name )
   * 2) When colon is applied before the state name parameter, it prepares the 
   *    state name for execution by using the state sql and data supplied
   * 3) Caution: stateSet will not modify an existing query unless two conditons are met
   *            - 1) A colon is attached before the state name
   *            - 2) The state name supplied exists.
   *  Hence it is always good to check if a state exists. stateSet will return an instance of the class 
   *  only if the state name supplied exists. If it doesn't exist, statename returns false. 
   * 
   * @param string $statename name of state
   * @param array $statemod , a new set of binded parameters with equal number of existing binded parameters.
   *        -note : statemod will not overide the default binded parameters. 
   * @return DBHandler|false checks if a state already exists to return a boolean of true | false
  */
  public function stateSet(string $statename = '', array $statemod = []): DBHandler|false {

    if(substr($statename, 0, 1) == ':'){
      
      $statename = ltrim($statename,": ");

      if(isset(self::$queryState[$statename])){

        $this->freeVars();

        $qState = self::$queryState[$statename];

        if(func_num_args() > 1) {

          $qParamsCount = count($qState['data']);

          if(count($statemod) == $qParamsCount) {
              $qState['data'] == $statemod;
          } else {
            trigger_error('"'.$statename.'" bind parameters does not match the default set as ('.$qParamsCount.')');
            return false;
          }
        }
        $this->query($qState['sql'], $qState['data']);
      } 

    }
    
    self::$statename = $statename;
    
    if(!isset(self::$queryState[self::$statename])){
       self::$statemessage = 'state: "'.$statename.'" not set!';
    }

    return isset(self::$queryState[$statename])? $this : false;
  }
  
  /**
   * To find a state data, the state must be actively selected
   * using stateSet() method. 
   * State data returns the data attached to a particular state name.
   * 
   * @param string $infoname - options [sql | data | fetches | error ]
   *  - sql : to fetch sql query
   *  - data : to fetch sql data
   *  - fetches : to fetch sql results
   *  - error : to fetch sql error
   * @return array|false
   *  - FALSE : if $infoname does not exist
   *  - Array : if $infoname exists
   */
  public function stateFind($infoname) : array|false {
      
      //if state does not exist return false
      if(!isset(self::$queryState[self::$statename])){
        self::$statemessage = 'state:  "'.self::$statename.'" not set!';
        return false;
      }

      if(array_key_exists($infoname, self::$queryState[self::$statename])){
        
        //if key exists in state name (array) , return key [ data | sql | fetches | error]
        $infoResult = self::$queryState[self::$statename][$infoname];

        return $infoResult;

      }else{
        self::$statemessage = 'state: '.self::$statename.'['.$infoname.'] not found';
      }
    return false;
  }
  
  /**
   * returns all stored states or specific states if a state key is supplied
   *
   * @param string $statekey
   * @return array|false
   */
  public function states($statekey = ''): array|false {

    $queryStates = self::$queryState;

    //return all states
    if(func_num_args() == 0){
      return $queryStates;
    }
    
    //return specific states
    $states = false;

    if(in_array($statekey, $queryStates)){
      $states = $queryStates[$statekey];
    }
      
    return $states;

  }

  /**
   * state message returns the last message of the currently selected state
   * 
   * @return string|false
  */
  public function stateMessage(): string|false {
    return self::$statemessage?? false;
  }

  /**
   * State Error returns error found
   *
   * @return string
   */
  public function stateError() : string {

    if(isset(self::$queryState[self::$statename]['error'])){

      $errlog = self::$queryState[self::$statename]['error'];

    }else{
      $errlog = '';
    } 
    return $errlog;    
  }
  
}

//--------------------------- ERROR TRAITS ------------------------------------------------ 
/**
 * Trait of DBHandler. Contains Error related methods
 */
trait DBError{
  
  /**
   * Contains all error messages
   *
   * @var array
   */
	private $errlog = array();


  /**
   * Sets the error message and returns a false value
   *
   * @param string $uerror
   * @return false
   */
	private function call_error($uerror) : false{ 
    $uerror = trim($uerror);
    if(!empty($uerror)){
        $this->errlog['error']      = true;
        $this->errlog['message']    = $uerror;
        $this->errlog['core'] = isset($this->conn)? $this->conn->error(true) : null;  
    }
    $nerror[] =  $this->errlog;
    if ($this->crud_exec_callback){
      $this->crud_exec_callback();
    }
    return false;
  }

  /**
   * Returns the last error logged
   * By default core error is not displayed unless true is supplied as argument
   *
   * @param string|bool|null 
   *  - TRUE gets all errors including core errors 
   *  - string gets error using specified key name
  * @return array|string
   */
  public function getError(string|bool|null $param = null){ 

    if($param === true){

      $errlog = $this->errlog;

    }else{
      $errlog = $this->errlog;
      
      if($param == null){
        unset($errlog['core']);
      }

      if($param !== true and $param != null){
        $errlog = $errlog[$param] ?? '';
      }
    }
    
    return $errlog;
  }

  /**
   * Return errors found in executed queries
   * This will only work when a direct 
   * instance of DBHandler is connected to. 
   * 
   * @param bool $status 
   *   - @notice: setting $status as true will return DBStatus::err() if no error exists in instance.
   *
   * @return string
   */
  public function error(bool $status = false) : string {
    $core  = $this->getError('core');
    if($core) return $core;
    if($status) return DBStatus::err();
    return $core;
  }

  /**
   * Detects if an error exists in query
   *
   * @param bool|string $type 
   *   - Setting $type as state uses state to find error
   *   - Setting $type as true returns will return true if DBStatus::err() exists even if no error exists in instance
   *   - Setting $type as true will not affect error state
   * @return bool
   */
  public function error_exists(bool|string $type = '') : bool{

    if(strtolower($type) === "state"){

      return $this->stateFind('error')? true : false;

    }
    $err = $this->find_error(); 
    if($err) return $err;
    if($type === true) return DBStatus::err()? true : false;
    return $err;
  }

  /**
   * Returns true if an error exists in error log
   *
   * @return bool
   */
  private function find_error() : bool {  //finds if error exists
  	return isset($this->errlog['error']);
  } 

}