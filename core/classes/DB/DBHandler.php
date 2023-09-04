<?php
namespace spoova\mi\core\classes\DB;

use DBStatus;
use ReflectionClass;
use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\UserAuth;

/**
 * Database handler for managing or modifying connections
 * Currently Supports Mysqli and PostGreSql database system
 * Database Connections: While default is PDO, it also supports Mysqli connections
 * 
 * Handler is capable of storing queries in static states than can be executed or used later.
 * Future feature will support MongoDB connection
 */

//-------------------------------------DBHANDLER CLASS ----------------------------------------
class DBHandler Implements DBHelpers{
	
  use StrictRules, Helpers, DBQuery, 
	    DBState, DBSelect, 
	    DBInsert, DBUpdate,
	    DBDelete, OSql,
	    DBDATA, DBLimit,
	    DBError, SQLJoin;

  /**
   * Connection is an instance of DBBridge
   *
   * @var DBBridge|null
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
	private $sqlquery;

  /**
   * Allows the use of setData function on query method
   *
   * @var bool
   */
  private $usedata;

  public $fetched;
  
  /**
   * set the instance of a new connection
   *
   * @param DBBridge $conn connection instance of DBBridge
   */
  function __construct(DBBridge $conn, DB $db = null){
    if($conn->isConnected()){

      $this->conn = $conn;
      $this->DB = $db;

    }else{
      return $this->call_error("no database connected:");        
    }

  }


  /**
   * swicth to a new database
   */
  public function switchDB($dbname,$dbuser = null,$dbpass = null, $dbserver = null){
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
  public function conResponse(){
    return $this->conn->conResponse();
  }

  /**
   * Connection type as MySQLi or PDO
   *
   * @return string
   */
  public function conType(){
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
  private function array_pick(&$array, $arraykey, $return = null){
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
    
  private function checkdb($db){

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
        $strictvars =  array('conn','sqlquery','data','strict','where','into','statename','queryState');
    }else{
        $strictvars =  array('conn');     
    }

    $class  = new ReflectionClass(__CLASS__);
    $statics     = $class->getStaticProperties();

    foreach ($classvars as $key => $value) {
        if(!in_array($key,$strictvars) && !array_key_exists($key, $statics)){
          
          if(isset($this->$key)) {
            if(is_array($this->$key)){
              $this->$key = [];
            }else{
              $this->$key = null;
            }
          }
        
        }  else if(array_key_exists($key, $statics)){

            if($key === 'queryState' || $key === 'statedata') continue;
            if(isset(self::$$key)) {
              if(is_array(self::$$key)){
                self::$$key = [];
              }else{
                self::$$key = null;
              }
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
trait DBQuery{

  /**
   * sets sql queries
   *
   * @param array $query sql query
   * @param array $data binded parameters
   * @param boolean $usedata true disables the use of binded parameters for raw sql queries
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
    if($this->sqlquery == null){ return $this->call_error("Error: no query not Supplied"); return false; }

    $this->conn->buildBind($this->data, $this->sqlquery);

    $process = $this->conn->process_query($this->sqlquery);
    
    if($process === false){
      if($this->conn->error_exists()){ 
        return  $this->call_error("Failed:".$this->conn->error()); 
      }else{
        return  $this->call_error("Failed: Something went wrong");
      }      
    }
    
    if($this->conn->error_exists()){
      return  $this->call_error("Failed:".$this->conn->error());
    } 

    return true;
  }

}

//-----------------------------------FETCH DATA TRAIT----------------------------------------------
trait DBSelect {
    private $select;
    private $numrows;
    private $results = [];
    private $fetches = false;

   /**
    * short-hand method for performing select queries
    *
    * @param string $sql as sql query to be supplied
    * @return self
    */
    public function select($sql){
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
     * @param string $limit1
     * @param string $limit2
     * @return array|bool
     *  - Boolean false is returned if error occurs
     *  - Array is returned if no error occurs
     */
    public function read(string $limit1 = null, string $limit2 = null) {
       
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
       if(($array = $this->conn->fetch_array($sql)) !== false){
           $this->numrows = $this->conn->num_rows();
           $this->limit   = $this->buildLimit(false);
           $this->results = $array;
           $this->fetches = $array;
           return $array;        
       }else{
	        if($this->conn->error() != null){ 
            $error = $this->conn->error(true);
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
       * @param int|string $param - options [null | int | ':count' | ':shuffle' | ':MAX_LENGTH' (e.g ':2')]
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
trait DBInsert{

  private $insert_into;
  private $column_keys;

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
   * @return DBhandler
   */
  public function insert_into(string $table, $data = null){

      $this->freeVars(true);
      $this->limit = $this->buildLimit(false);
      $this->insert_into = " insert into ".$table;

      if(!$table){
        trigger_error('invalid (empty) table name supplied for database insertion');
      }

      $this->sqlquery .= $this->insert_into;
    
      if($data != null && is_array($data)){
        $this->setData($data);
        $this->prepare_insert();
      }
      return $this;

	}

  /**
   * sets the insertion columns
   * 
   * @param string func_get_args(), database table columns for inserting data 
   * @return DBHandler
   */
	public function columns(){

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
   * sets the insert values
   * 
   * @param string func_get_args(), values to be inserted into columns 
   * @return DBHandler
   */
	public function values(){

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
   *
   * @return void
   */
  public function prepare_insert(){

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
              
  }

  /**
   * Performs insert operation
   *
   * @return bool
   */
	public function insert() : bool{
        
    if($this->usedata){ $this->prepare_insert(); }
    $sql['sql'] = $this->sqlquery;  //sets sql['sql']

    $this->conn->buildBind($this->data,$this->sqlquery); //binds data
       
    //check if connection is not false
    if(($this->conn->insert_query($sql)) == false){

      if($this->conn->error() != null){ 

        return  $this->call_error("Failed: Something is wrong");  

      }else{

        return  $this->call_error("Failed: Something went wrong");

      }

    }else{

      $this->connID = $this->conn->insert_id();
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
trait DBUpdate{

  private  $update;

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
       
    //check if connection is not false
      //if false check if there is error
         //if error is found return the error log
    if(($array = $this->conn->update_query($sql))!==false){
     
       $this->freeVars(); //free variables except few         
       return true;    

    }else{

      if($this->conn->error() != null){ 
        return  $this->call_error('Error');        
      }else{
        return $this->call_error("Something is wrong!!! Try again later");     
      }

    }   
     
   }  

}

//---------------------------------DELETE DATA TRAITS------------------------------------------------
trait DBDelete{ 

  private $delete;

	public function do_delete($tbname = null){

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
   * @param int $limit1 sql optional limit
   * @return bool
   */
  public function delete($limit1 = null) : bool {

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
      
    //check if connection is not false
      //if false check if there is error
          //if error is found return the error log
    if(($array = $this->conn->delete_query($sql)) !== false ){

      $this->freeVars(); //free variables except few         
      return true;        

    }else{

      if($this->conn->error() != null){ 
        return  $this->call_error($this->conn->error());        
      }else{
        return $this->call_error("Something is wrong!!!");     
      }

    }  

  }

}

//---------------------------------JOIN DATA TRAITS------------------------------------------------
trait SQLJoin{

	private $join;
  private $sqljoin;
	
	public function joins($param,$sqljoin=''){
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

	public function on($param){
		if($this->sqlquery == null){return $this; }
		if($this->sqljoin  == null){return $this; }
		$this->join_on = " ".$param;
		return $this;
	} 

}

//-------------------------------- LIMIT DATA TRAITS -------------------------------------------------
trait DBLimit{
    private $limit;


    private function limit($lim1, $lim2 = null){

		  if($this->sqlquery == null){ return $this; }
    
      if($lim1 != null && !is_numeric($lim1)){
        return $this->call_error("invalid limit: Parameter 1");
      }

      if($lim2 != null && !is_numeric($lim2)){
        return $this->call_error("invalid limit: Parameter 2");
      }
    
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
   * Build the limit used. Supports only a maximum of two limits range
   *
   * @param array|bool(false) $limit [from, to]
   * {@see DBBridge::buildLimit()}
   * @return bool|string
   */
  private function buildLimit(){
    $this->conn->buildLimit(...func_get_args());
  }
}

//-------------------------COMMANDS WHERE, FROM ---SQL CONJUCTION---------------------------------
trait OSql{

	private $where;
	private $from;
  private $order;

  public function from($param){
    if($this->sqlquery == null){ return $this; }
    $frm =  " from ".$param;
    $this->sqlquery .= $frm;
    if(!empty($this->from)){ $this->call_error('use of from more than once');  return $this; }
    $this->from  = $frm;
    return $this;
  }


	public function where($param){ 
	    if($this->sqlquery == null){ return $this; }
      if(($this->update != null)&&($this->set==null)){
        return $this->call_error("cannot perform where before set query");
      }
		$this->where = " where ".$param;
		$this->sqlquery .= $this->where;
    	return $this;
	}
   
  public function order($param){
    if($this->sqlquery == null){ return $this; }
    $ord =  " order by ".$param;
    $this->sqlquery .= $ord;
    $this->order  = $ord;
    return $this;
  }

}


//--------------------------- DATA TRAITS ------------------------------------------------ 
trait DBDATA{
  
  private array $data = [];

  public function setData($arr = array()){
    if($this->sqlquery == null){return $this->call_error("No Sql query found yet");}
    $this->data = $this->trimAll($arr);
  }
    
	private function trimAll($data) : array {
    
		if($data == null){ return array(); }

    $filtered = array();

    foreach ($data as $key => $value) {
      $filtered[$key] = $value;
    }

    return $filtered;

  }

}

//* HELPER TRAITS: Contains all helper methods @see DBHelper
//* This methods will only be accessible on the class instance via successful connection

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
   * @return string connection name
   */
  public function conName(){
    if(!$this->conn) return false;
    return $this->conn->conName();
  }

  /**
   * Returns the connection type (e.g MySQL, PDO)
   *
   * @return string connection type
   */
  public function conType(){
    if(!$this->conn) return false;
    return $this->conn->conType();
  }  

  /**
   * Returns the connection response after a connection to database is tried
   *
   * @return string response
   */
  public function conResponse(){
    if(!$this->conn) return false;
    return $this->conn->conResponse();
  } 

  /**
   * Returns the currently selected database name
   *
   * @return string response
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
   * @return boolean true if database was created or already exists, else it returns false
   */
  public function createDB(string $dbname){
    
    $db = $this->clone();
    $db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ? ", [$dbname]);
    $db_exists = $db->read()? true : false;

    if($db_exists) return true;
    
    if(!$db->error_exists()){
      return $db->query("CREATE DATABASE IF NOT EXISTS $dbname")->process();
    }

    return false;

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
  public function tables(string $dbname = '', string $tbname = ''){

    if(func_num_args() == 0){
      $dbname = $this->currentDB();
    }

    $db = $this->clone();


    if(func_num_args() < 2){

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
   * Returns the clone of the current handler
   *
   * @return DBhandler
   */
  public function clone(){

    return clone $this;

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

    // if(empty($column)) return false;

    // $db = $this->clone();

    // $db->query("SHOW COLUMNS FROM `".$table."` LIKE '".$column."' ");
    
    // return $db->read()? true : false;

  }

  /**
   * Drop a table or Column
   *
   * @param array|bool|string $tableName name of table to be dropped
   *  -if $tableName is bool current connected database will be dropped 
   * @param bool|string $column in $tableName of table to be dropped
   *     - string value will drop column if it exists
   *     - boolean (true) will drop database
   * 
   *  - @notice: $tableName will not be dropped if $tableName is not declared unless $columnName is set as true
   *  - @Notice: If $columnName is declared, then $tableName must be a string
   * 
   * @return bool
   *  - true is returned if table is successfully dropped
   */
  public function drop(array|bool|string $tableName, string|bool $columnName = null) : bool {

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


}

//* STATE TRAITS: Methods tha keep the state of a query ----------------------------------- 
trait DBState{
  
  private static $queryState = [];
  private static $statename;
  private static $statequery;
  private static $statedata;
  private static $statemessage;
  

  /**
   * Sets (and stores) a query for use later
   *
   * @param string $query sql query
   * @param array|null $data
   * @param string|null $statename
   * @return void
   */
  public function queryState($query, array $data = null, string $statename = null){
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
   * @return DBHandler
   */
  public function saveState($statename = null){
    
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
  public function endState(string $statename = ''){
    
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
   * $param $statemod , a new set of binded parameters with equal number of existing binded parameters.
   *        -note : statemod will not overide the default binded parameters. 
   * @return bool|DBHandler checks if a state already exists to return a boolean of true | false
  */
  public function stateSet(string $statename = '', array $statemod = []) {

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
   */
  public function stateFind($infoname){
      
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
   * @return array|bool
   */
  public function states($statekey = ''){

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
   * @return string|bool
  */
  public function stateMessage(){
    return self::$statemessage?? false;
  }

  /**
   * State Error returns error found
   *
   * @param boolean:true $param return array
   * @return string|array
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
   * @return bool false
   */
	private function call_error($uerror){ 
    $uerror = trim($uerror);
    if(!empty($uerror)){
        $this->errlog['error']      = true;
        $this->errlog['message']    = $uerror;
        $this->errlog['core'] = isset($this->conn)? $this->conn->error(true) : null;  
    }
    $nerror[] =  $this->errlog;
    return false;
  }

  /**
   * Returns the last error logged
   * By default core error is not displayed unless true is supplied as argument
   *
   * @param null|bool (true) 
  * @return array|string
   */
  public function getError($param = null){ 

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
  public function error(bool $status = false){
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
?>