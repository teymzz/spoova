<?php

use spoova\core\classes\DBBridge;

class DBStatus extends DBBridge{
  
  //@return boolean true if any last known error occurs
  static function failed(){
    return !empty(self::$baseerror);
  }
  
  //returns last error occurrence (editable)
  static function err(string $custom_error = ''){

    $error = self::$baseerror;
    if($error && (func_num_args() > 0)){
      if(!empty(trim($custom_error))) self::$baseerror = $custom_error;
    }
    
    return $error;
  }

  //returns last error occurrence (uneditable)
  static function baseErr(){

    return self::$basequeryerr;
    
  }  

  //return last query executed
  static function query(){
    return self::$basequery;
  }


  /* Methods Below will not perform any function */
  public function process_query($sql) : bool { return false; }

  public function insert_query($sql) : bool { return false; }

  public function insert_id() : bool { return false; }

  public function fetch_array($sql) : bool { return false; }
   
  public function update_query($sql) : bool { return false; }

  public function delete_query($sql) : bool { return false; }

  public function buildBind(&$data, $sqL) : bool { return false; }

  protected function newConnection($dbname, $dbuser, $dbpass, $dbserver, $dbport, $dbsocket){}

  protected function open_connection(){}

  public function close_connection(){} 
  
}