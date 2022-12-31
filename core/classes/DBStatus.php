<?php

use spoova\core\classes\DBBridge;

class DBStatus extends DBBridge{
  
  /**
   * Returns true if any error is found
   *
   * @return boolean true if any last known error occurs
   */
  static function failed() : bool{
    return !empty(self::$baseerror);
  }
  
  /**
   * Returns last error occurrence (editable)
   * Modifies default database error with a new custom error if an existing database error is detected
   * 
   * @param string $custom_error 
   * @param bool $update 
   *    - $custom_error cannot be an empty value if supplied unless $update is set as true
   *    - @WARNING: TRUE will overwrite previous response message even if it is empty (i.e even if no error occurs).
   * @return mixed
   */
  static function err(string $custom_error = '', bool $update = false){

    $error = self::$baseerror;
    if($error && $custom_error){
      if(!empty(trim($custom_error))) self::$baseerror = $custom_error;
    }

    if($update) {
      
      self::$baseerror = $custom_error;
      return false;

    }
    
    return $error;
  }

  /**
   * returns default database error occurrence (uneditable)
   *
   * @return mixed
   */
  static function baseErr(){

    return self::$basequeryerr;
    
  }  

  /**
   * return last query executed
   *
   * @return void
   */
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