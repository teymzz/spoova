<?php
namespace teymzz\spoova\core\classes\DB;

use mysqli;
use mysqli_sql_exception;

class MiSQL extends DBBridge{

  /**
   * Determines when a connection is successful
   *
   * @var boolean
   */
  public bool $dbConnection;

  public $connection;

  /**
   * Open a new MySQLi connection
   *
   * @return boolean
   */
  protected function open_connection() : bool {

    //set the real connection type
    $this->conType = "MYSQLI";

    try{
      $this->isFailed = false;

      mysqli_report(MYSQLI_REPORT_STRICT);
      $db = @(new mysqli($this->DBSERVER, $this->DBUSER, $this->DBPASS, $this->DBNAME, intval($this->DBPORT), $this->DBSOCKET));
      

      if(!$db){
        throw new mysqli_sql_exception(mysqli_connect_error());
      }

      $this->dbConnection = true;
      $this->conn = $db;
      $this->currentDB = $this->DBNAME;
      return true;
    }catch(\mysqli_sql_exception $e){  
      $this->dbConnection = false;      
      $this->isFailed = true;
      $this->conResponse = "connection failed:".$e->getMessage();   
      return false;
    }

  }

  protected function newConnection($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket){

    $this->conType  = "MYSQLI";
    $this->conName  = "MiSQL";

    //* Switch to a new connection/
    if($dbname == "_DEFAULT_" || $dbname == "D"){
      $this->open_connection();
      if($this->dbConnection == true){
        $this->conResponse = "switch back successful";
      }else{
        $this->conResponse = "switch back failed";        
      }
      return $this->dbConnection;
    }

    if(isset($dbname,$dbuser,$dbpass)){
       $dbserver = ($dbserver == null)? DBSERVER : $dbserver;
     
     try{ 
       $this->isFailed = false;
       $dbport = intval($dbport);
       $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname, $dbport, $dbsocket);

       if(!$db){throw new \Exception(mysqli_connect_error());} 
       
       $this->dbConnection = true;
       $this->conn = $db;
       $this->conResponse = $dbname." connected";
       $this->currentDB = $dbname;
       return true;
     }catch(\Exception $e){
       $this->conResponse = "connection failed:".$e->getMessage();
       $this->isFailed = true;
       return false;
     }  
    }

    $this->conResponse = $dbname.": connection failed (something wrong)";
    return false;
  }
   
  public function close_connection() {
    if(isset($this->connection)) {
      mysqli_close($this->connection);
      unset($this->connection);
    }
  }

  public function process_query($sql) : bool{

    if(!($con = $this->conn)){ return false; }  
    $this->num_rows = '';

    $sqL = $sql;  
    $bindVals = $this->binder;   
    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query;

    if(!($stmt = $con->prepare($sqL))){
      $err = "Sql Error: ".mysqli_error($this->conn);
      $this->buildError($err, 'Error');
      return false; 
    }

    $data = is_array($this->data)? $this->data : [];

    if(count($data) > 0) {call_user_func_array(array($stmt,'bind_param'), $bindVals);} 

    if($stmt->execute()){
     $this->num_rows = $stmt->affected_rows;
     return true;
    }else{ 
     $this->num_rows = 0;
     $err = $stmt->error;
     $this->buildError($err, 'Error');
     return false;
    }  

  }

  public function insert_query($sql) : bool{

    if(!($con = $this->conn)){ return false; }
    $sqL = $sql['sql'];
    $sqT = MyIsset($sql['append']);
    $bindVals    = $this->binder;     
       
    MyIsset($bindVals);
    MyIsset($dataString);  //null: never implement where query
    $sqL .= " ".$dataString." ".$sqT;
    $this->last_query = $sqL;
    self::$basequery  = $this->last_query;

    if(!($stmt = $con->prepare($sqL))){
      $err = "Sql Error: ".mysqli_error($this->conn);
      $this->buildError($err, 'Error');
      return false;
    }
      
    $data = $this->data;
      
    if(count($data)>0) {call_user_func_array(array($stmt,'bind_param'), $bindVals);}
      
      if($stmt->execute()){
          $this->num_rows = ($this->conn->sqlstate == "00000")? 1 : 0;
          return true;
      }else{
        $sqlError = mysqli_error($this->conn);
        if(!empty($sqlError)){
          $this->buildError($sqlError, 'Error');
        }elseif(isset($stmt->error)){
          $this->buildError($stmt->error, 'Error');
        }        
      }

      return false;
  }

  public function fetch_array($sql){

    if(!($con = $this->conn)){ return false; }
    $sqL        = MyIsset($sql['sql']);
    $sqT        = MyIsset($sql['append']);
    $dataString = null;

    if(isset($sql['where'])){
      $dataString = $sql['where']; 
    }else{               
      if($this->useData === true){ 
       if($this->dataString != null){
          $dataString = " where ".$this->dataString;
       }
      }  
    }

    $bindVals    = $this->binder;     
    $sqL .= " ".$dataString." ".$sqT;

    $sqL .= $this->limit;
    $this->previousLimit = $this->limit;

    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query; 

    if(!($stmt = $con->prepare($sqL))){
      $err = "Sql Error: ".mysqli_error($this->conn);
      $this->buildError($err, 'Error');
      return false;
    }

    $data = $this->data;
    $data = !is_array($data)? array() : $data;

    if(count($data)>0) { call_user_func_array(array($stmt,'bind_param'), $bindVals); }
    
    if($stmt->execute()){
      $this->num_rows = $stmt->num_rows();
      $result = $stmt->get_result();
      $assocs = array();
         $i = 0;
       while($assoc = $result->fetch_array(MYSQLI_ASSOC)){
          $assocs[] = $assoc;
          $i++;
         }
      $this->num_rows = $i;
      if($i > 0){
       return $assocs;
      }else{
       $n = array();
       return $n;
      } 
    }else{
      $err  = $stmt->error;
      $this->buildError($err, 'Error');
      return false;
    }
      
  }
   
  public function update_query($sql) : bool {
    
    if(!($con = $this->conn)){ return false; }
    $sqL        = MyIsset($sql['sql']);
    $sqT        = MyIsset($sql['append']);
    $dataString = null;

    if(isset($sql['where'])){
      $dataString = $sql['where']; 
    }else{               
      if($this->useData === true){ 
       if($this->dataString != null){
          $dataString = " where ".$this->dataString;
       }
      }  
    }


    $bindVals    = $this->binder;     
    $sqL .= " ".$dataString." ".$sqT;

    $sqL .= $this->limit;
    $this->previousLimit = $this->limit;

    $this->num_rows = null;
    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query; 
    
    if(!($stmt = $con->prepare($sqL))){ 
      $err = "Sql Error: ";
      $err .= mysqli_error($this->conn);
      $this->buildError($err, 'Error');
      return false;
    }

    $data = $this->data;

    if(count($data)>0) {call_user_func_array(array($stmt,'bind_param'), $bindVals);}
    if($stmt->execute()){
     $this->num_rows = $stmt->affected_rows;
     return true;
    }else{ 
     $this->num_rows = 0;
     $err = $stmt->error;
     $this->buildError($err, 'Error');
     return false;
    }

  }

  public function delete_query($sql) : bool{
    
    if(!($con = $this->conn)){ return false; }
    $sqL = $sql['sql'];
    $sqT = MyIsset($sql['append']);
    $dataString = null;

    if(isset($sql['where'])){
      $dataString = $sql['where']; 
    }else{               
      if($this->useData === true){ 
       if($this->dataString != null){
          $dataString = " where ".$this->dataString;
       }
      }  
    }

    $bindVals    = $this->binder;    
    $sqL .= " ".$dataString." ".$sqT;

    $sqL .= $this->limit;
    $this->previousLimit = $this->limit;

    $this->num_rows = null;
    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query; 
    
    if(!($stmt = $con->prepare($sqL))){ 
      $err = "Sql Error: ";
      $err .= mysqli_error($this->conn);
      $this->buildError($err, 'Error');
      return false;
    }
    
    if(count($this->data)>0) {call_user_func_array(array($stmt,'bind_param'), $bindVals);}

    if($stmt->execute()){ 
      $this->num_rows = $this->conn->affected_rows;
      return true;
    }else{

      if($stmt->error != null){
        $err = $stmt->error;
      }elseif(!empty(mysqli_error($this->conn))){
        $err = mysqli_error($this->conn);
      }else{
        $err = "unknown error";
      }
      $this->buildError($err, 'Error');
      return false;

    } 

  }

  public function insert_id(){
      return mysqli_insert_id($this->conn);
  }

  public function buildBind(&$data, $sqL) : bool{
    
    $this->data = $data;
    $this->dataString = null;
    $text = array();
    $sm   = array();
    $this->binder = array();

    if(empty($data)){ return false; }

    if(count($data) > 0){

      foreach ($data as $key => $value) {
        $text[] = ($key."=?");
        $this->binder[] = &$data[$key];
         $dataType = gettype($value);
         if($dataType == 'string'){
          $sm[] = 's';
         }elseif($dataType == 'integer'){
          $sm[] = 'i';
         }elseif($dataType == 'double'){
          $sm[] = 'd';
         }else{
          $sm[] = 'b';
         }
      } 
      
      $sqL = strtolower($sqL);

      if(strpos($sqL,"select") !== false || strpos($sqL,'delete') !== false){
        $implode = " and ";
      }elseif(strpos($sqL,"insert") !== false || strpos($sqL,'update') !== false){
        $implode = " , ";
      }

      if(isset($implode)){
        $this->dataString = implode(" $implode ",$text);
        $dataTypes  = implode('', $sm);
        array_unshift($this->binder, $dataTypes);
        return true;
      }
    }

    return false;

  }

}


?>
