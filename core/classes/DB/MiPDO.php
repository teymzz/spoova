<?php
namespace spoova\mi\core\classes\DB;

class MiPDO extends DBBridge{
  
  /**
   * PDO DEFAULT SETTINGS
   *
   * @var array
   */
  private $SETTINGS = [
  \PDO::ATTR_EMULATE_PREPARES => true, //turn off emulation mode for real prepared statements
  \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, //turn on errors in form of exceptions
  \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, //make default fetch to be in associative array
  \PDO::MYSQL_ATTR_FOUND_ROWS   => true
    ]; 

  /**
   * Determines when a connection is successful
   *
   * @var boolean
   */
  public bool $dbConnection;

  
  /**
   * modifies the settings of pdo connection
   * This method is only avaiblable when pdo connection is used
   * 
   * @param array $SETTINGS new settings
   * @return void
   */
  public function pdoSet($SETTINGS){
   $this->SETTINGS = is_array($SETTINGS)? $SETTINGS : $this->SETTINGS;
  }

  /**
   * Open a new pdo connection
   *
   * @return bool
   */
  protected function open_connection() : bool {      

    $this->conName  = "PDO"; //reset the connection name to PDO

    $SETTINGS = $this->SETTINGS;
 
    try{ 

      $DBSERVER = $this->DBSERVER;
      $DBSOCKET = $this->DBSOCKET;
      $DBPORT   = $this->DBPORT;
      $DBNAME   = $this->DBNAME;
      
      $dnshost = $dnsport = $dnssocks = $dnsname = "";

      if($DBSOCKET != ''){
        $dnssocks = ":unix_socket".$this->DBSOCKET;
      }else{
        if($DBSERVER != null){ $dnshost = ":host=".$this->DBSERVER; }
        if($DBPORT   != null){ $dnsport = ";port=".$this->DBPORT; }  
        if($DBNAME   != null){ $dnsname = ";dbname=".$this->DBNAME; }                      
      } 
      
      $DNS = "mysql:".$dnssocks.$dnshost.$dnsport.$dnsname;
      
      $this->isFailed = false;
      $db = new \PDO($DNS, $this->DBUSER, $this->DBPASS, $SETTINGS);
      $this->dbConnection = true;
      $this->conn = $db;
      $this->currentDB = $this->DBNAME;
      $this->conResponse = "connection successful:";    
      return true;
      
    }catch(\PDOException $e){
      $this->dbConnection = false;
      $this->conResponse = "connection failed:".$e->getMessage();
      $this->buildError($e->getMessage(), 'Connection Error');
      $this->isFailed = true;
      return false;

    }
  } 

  protected function newConnection($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket){

    $this->conName = "PDO"; //reset the connection name to PDO

    if($dbname == "_DEFAULT_" || $dbname == "D"){

      $this->open_connection();

      if($this->dbConnection == true){
        $this->conResponse = "switch back successful";
      }else{
        $this->conResponse = "switch back failed";        
      }

      return $this->dbConnection;

    }

    if(isset($dbuser, $dbpass, $dbname)){
     
       $dnssocks = $dnshost = $dnsport = $dnsname = ""; //initialize dns

       if($dbsocket != ""){
          $dnssocks = ":unix_socket".$dbsocket;
       }else{
         if($dbserver == null){ $dbserver = DBSERVER; }
         if($dbserver != null){ $dnshost = ":host=".$dbserver; }
         if($dbport   != null){ $dnsport = ";port=".$dbport; }  
         if($dbname   != null){ $dnsname = ";dbname=".$dbname; }        
       }
       
       $dns = "mysql:".$dnssocks.$dnshost.$dnsport.$dnsname;

       $SETTINGS = $this->SETTINGS;

       try{
         $this->isFailed = false;
         $db = new \PDO($dns,$dbuser,$dbpass,$SETTINGS);
         $this->dbConnection = true;
         $this->conn = $db;
         $this->conResponse = $dbname." connected";
         $this->currentDB   = $dbname;
         return true;
       }catch(\PDOException $e){
         $this->dbConnection = false;
         $this->conResponse = $dbname.": connection failed: ".$e->getMessage();
         $this->buildError($e->getMessage(), 'Connection Error');
         $this->isFailed = true;      
         return false;
       }

    }
      $this->conResponse = $dbname.": connection failed (something wrong)";
      return false;
  }
   
  public function close_connection() {
   $this->conn = null;
  }
  
  public function process_query($sql) : bool {

    if(!($con = $this->conn)){ return false; }
    $this->useData = false;
    $this->num_rows = '';

    $sqL = $sql;  
    $bindVals = $this->binder;    

    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query;
      
    $stmt = $con->prepare($sqL); 
    
    try{
      $stmt->execute($bindVals);
      $this->num_rows = $stmt->rowCount();
      return true;
    }catch(\PDOException $e){ 
      $this->num_rows = 0;
      $err  = $e->getMessage();
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
    MyIsset($dataString); //null (reason: doesn't implement where query)  

    $sqL .= " ".$dataString." ".$sqT;

    $sqL .= $this->limit;
    $this->previousLimit = $this->limit;

    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query;
    $stmt = $con->prepare($sqL); 
          
    try{
      $stmt->execute($bindVals);
      $this->num_rows = $stmt->rowCount();
      return true; 
    }catch(\PDOException $e){ 
      $err = $e->getMessage();
      $this->buildError($err, 'Error');
      return false;
    }
  }

  public function fetch_array($sql) {
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
    $sqL .= " ".$dataString." ";

    $sqL .= $this->limit;
    $this->previousLimit = $this->limit;

    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query;  
    $stmt = $con->prepare($sqL);

    try{
      $stmt->execute($bindVals);
      $this->num_rows = $stmt->rowCount();
      $assoc = [];
      while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
       $assoc[] = $result;
      }
      return $assoc;

    } catch(\PDOException $e) { 
      $err = $e->getMessage();
      $this->buildError($err, 'Error');
      return false;
    }
        
  }
   
  public function update_query($sql,$data=null) : bool {
    
    if(!($con = $this->conn)){ return false; }

    $sqL        = MyIsset($sql['sql']);
    $sqT        = MyIsset($sql['append']);
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

    MyIsset($bindVals);
    MyIsset($dataString);   

    $sqL .= " ".$dataString." ".$sqT;

    $sqL .= $this->limit;
    $this->previousLimit = $this->limit;

    $this->last_query = trim($sqL);
    self::$basequery  = $this->last_query;
    $stmt = $con->prepare($sqL); 
    
    try{
      $stmt->execute($bindVals);
      $this->num_rows = $stmt->rowCount();
      
      return true; 
    }catch(\PDOException $e){ 
      $err = $e->getMessage();
      $this->buildError($err, 'Error');
      return false;
    }     
    
  }

  public function delete_query($sql) : bool {
 
    if(!($con = $this->conn)){ return false; }

    $sqL = $sql['sql'];
    $sqT = MyIsset($sql['append']);
    $dataString = '';

    if(isset($sql['where'])){
      $dataString = $sql['where']; 
    }else{               
      if($this->useData === true){ 
       if($this->dataString != null){
          $dataString = " where ".$this->dataString;
       }
      }  
    }

    $bindVals = $this->binder;

    $sqL .= " ".$dataString." ".$sqT;
    $this->last_query = $sqL;
    self::$basequery  = $this->last_query;
    
    $stmt = $con->prepare($sqL); 
        
    try{
      $stmt->execute($bindVals);
      $this->num_rows = $stmt->rowCount();
      if($this->num_rows > 0){
        return true;
      } 
      return false;
    }catch(\PDOException $e){
      $err = $e->getMessage();
      $this->buildError($err, 'Error');
      return false;
    }    
    
  }

  public function insert_id(){
    return $this->conn->lastInsertId(); // pdo function
  }

  public function buildBind(&$data, $sqL) : bool{

    $this->data = $data;
    $this->dataString = null;
    $this->binder = array();
    $text = array();

    if(empty($data)){ return false; }

    if(count($data) > 0){
    
      foreach ($data as $key => $value) {
         $text[] = ($key."=?");
         $this->binder[] = &$data[$key];
      } 

      $sqL = strtolower($sqL);
    
      if(strpos($sqL, "select") !== false || strpos($sqL, 'delete') !== false){
        $implode = " and ";
      }elseif(strpos($sqL,"insert") !== false || strpos($sqL,'update') !== false){
        $implode = " , ";
      }

      if(isset($implode)){
        $this->dataString = implode(" $implode ",$text);
        return true;
      }
    }
    return false;
  }

}

?>