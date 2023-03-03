<?php
 
 namespace spoova\core\classes;

use spoova\core\classes\DB\DBHandler;
use \User;

/**
 * This class handles user account authentications 
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
class UserAuth extends SharedInfo{

  public $dbtable;
  private $info = false;
  private $message;
  private $error; 
  private $passField = 'password';
  private $password  = false;
  private string $fields  = '';
  private array $values  = [];
  private bool $primary;

  /**
   * Connect to database using a new custom connection
   *
   * @param DB|null $dbc
   * @param DBHandler|null $dbh
   */
  function __construct(DB $dbc = null, DBHandler $dbh = null){

    if(func_num_args() > 0){
      parent::__construct(...func_get_args());  
    }

    $this->dbtable = self::$init['USER_TABLE'];
    
  }

  /**
   * external connection to modify current class default connection
   *
   * @param  $connection will replace the default connection
   * @return void
   */

  public function db(DB $newdbc, DBHandler $newdbh){
    
    // if new connection matches
    if(($newdbc->currentDB() === $newdbh->currentDB()) && $newdbh->currentDB() != ''){           
          self::$dbc = $newdbc;
          self::$dbh = $newdbh;
          self::$dbe = '';
    }else{
          self::$dbc = '';
          self::$dbh = '';
          self::$dbe = 'invalid connection or connection mismatch';
    }
    
  }
  
  /**
   * @return DBHandler|null
   */
  public function dbh(){
    
    return self::$dbh;
    
  }

  /**
   * returns User class for a valid connection
   *
   * @return void|UserAuth
   */
  public function connected() {
    if($this->con()){
      return $this;
    }
  }
  
  /**
   * @param array|void|null
   * @return string
   */
  private function buildColumns($cols){
    if(empty($cols)) return false;
    return implode(', ',$cols);
  }

  /**
   * Builds fields and store values (if supplied) using “where” query
   * 
   * @param string|array
   */
  private function buildFields($fields){

    if(empty($fields)) return false;
    
    if(!is_array($fields)) { 
      $this->fields = ' WHERE '.$fields; 
      return;
    } 
    
    $sql = ' ';
    $values = [];

    $total  = count($fields);
    $count  = 1;

    $sql = ($total > 0)? ' WHERE ' : $sql;

    foreach($fields as $field => $value){
      
      //dealing with and (and: &)
      $fieldname = ltrim($field, '& ');
      $fieldExp = explode('and:', $fieldname, 2);
      $fieldname = $fieldExp[1]?? $fieldExp[0];

      //dealing with or (or: ||)
      $fieldname = ltrim($fieldname, '|| ');
      $fieldExp = explode('or:', $fieldname, 2);
      $fieldname = $fieldExp[1]?? $fieldExp[0];      

      //dealing with logical operators 
      $fieldname = trim($fieldname); //remove multiple spaces

      //explode spaces 
      $exp = explode(' ',$fieldname, 2);
      if($operator = $exp[1]?? ''){
          $fieldname = $exp[0];
      }else{
        $operator = " = ";
      }
      
      $fieldname .= " ".$operator." ?";

      //attach operator to field
      $sql .= $fieldname; 

      if($count < $total){
        $next = array_keys($fields)[$count];
        
        if(substr($next, 0, 1) === '&' || substr($next, 0, 4) === 'and:'){
          
          $sql .= ' and ';
          
        }else{
          
          $sql .= ' or ';
          
        }
        
      } 
      $values[] = $value;
      $count++;
    }

    $this->fields = $sql;
    $this->values = $values;
  }

  /**
   * counts information from database table field(s) supplied
   * 
   * @param $method processing method 
   * @param $columns array|string
   *  
   */
  private function counter(){

    $table = $this->dbtable;   
    $fields = $this->fields;
    $values = $this->values; 
    
    if($table == '') return $this->error_mess('invalid table');
    if($fields == '') return $this->error_mess('invalid fields');
    
    $dbh = self::$dbh;

    $dbh->query("select count(*) from $table $fields", $values)->read();
    return $dbh->results(0, 'count(*)');
  } 


  /**
   * finds information from database table field(s) supplied
   * 
   * @param $method processing method - options [find, findAll] 
   * @param $columns array|string
   * @param array|int $limit
   * @return array|string|false depending on data supplied or response obtained
   */
  private function finder($method, $columns, $limit = ''){

    $this->info = false;
    $columns = $this->sort_columns($columns); //sort as array|string 
    
    $isArray = is_array($columns);
    $cols = (array) $columns;
    $cols = $this->buildColumns($cols); //flatten
    $table = $this->dbtable;   
    $fields = $this->fields;
    $values = $this->values; 
    
    if($table == '') return $this->error_mess('invalid table');
    if($fields == '') return $this->error_mess('invalid fields');
    if($cols == '') return $this->error_mess('invalid column name');
    
    $dbh = self::$dbh;

    if($dbh){
      
      $dbh->query("SELECT {$cols} FROM $table $fields", $values);

      if($method === 'find'){
        
        $dbh->read(1);
        
        if($userinfo = $dbh->results(0)){

          $this->info = $userinfo;
          if(!$isArray && ($columns != '*')) $userinfo = $userinfo[$columns];
          
        } else {
          
          if($dbh->error_exists()) return $this->error_mess($dbh->error());

          $userinfo = ($columns === '*' || is_array($columns))? [] : '';
          
        }

        return $userinfo; 

      }elseif($method === 'findAll'){

        $limit = ($limit)? (array) $limit : [];

        $dbh->read(...$limit);
        
        if($dbh->error_exists()) return $this->error_mess($dbh->error());

        return $dbh->results();

      }
      
    }

    
  }

  /**
   * sort parameters for finder method
   * 
   * @param  string|array $columns
   * @return string|array
   */
  private function sort_columns($columns){
    
    if(is_array($columns)) return $columns;
    
    if(!is_string($columns)) throw new \Error('invalid argument supplied');
    
    $columns = trim($columns);
    if(count($fields = explode(',', $columns)) > 1){
      return $fields;
    }

    return $columns;
    
  }

  /**
   * checks a password field
   * caution: This method is under development. 
   */
  private function verify(){
    
    $table = $this->dbtable;   
    $fields = $this->fields;
    $values = $this->values;
    $passField = $this->passField;
    
    if($table == '') trigger_error('invalid table');
    if($fields == '') trigger_error('invalid fields');
    if($passField == '') trigger_error('invalid column name');
    
    $db = self::$dbh;

    $db->query("SELECT {$passField} FROM $table $fields", $values);
    $db->saveState('query1');

    $db->query("SELECT * FROM $table $fields", $values);
    $db->saveState('query2');

    if($db->stateSet(":query1")){ 
      $db->read(1);

      if($results = $db->results(0)){
        $this->password = $results[$passField];
        
        if($db->stateSet(':query2')){
            $db->read(1);
            $this->info = $db->results(0);
        }
      }
    }
    
  }


  /**
   * modify default database user table name
   *
   * @param string $tablename
   * @return UserAuth
   */
  public function table(string $tablename = ''){
    if($tablename == '') {
      $tablename = self::$init['USER_TABLE'];
    }
    $this->dbtable = $tablename;
    return $this;
  }

  /**
   * sets default database user table password field name
   *
   * @param string $tablename
   * @return UserAuth
   */
  public function passField(string $passField){
    $this->passField = $passField;
    return $this;
  }

  /**
   * sets row conditon that is fetched
   *
   * @param array|string $fields database columns (and values)
   *     (array) => key pairs of column and corresponding values
   *     (string) => sql string of columns + value (or value placeholders) 
   * @param array $values optional values if $field is string and uses blinded anchor placeholders
   * @return UserAuth
   */
  public function where($fields, array $values=[]){
    $this->password = false;
    $this->buildFields($fields); 
    if(func_num_args() > 1) {
      $this->values = $values; 
    }
    return $this;
  }

  /**
   * sets query order that is fetched
   *
   * @param $column string $array
   * @return $order - optional options [desc | asc]
   */
  public function order(string $column, string $order = ''){
    $stmt = ' ORDER BY '. $column;
    if(property_exists($this, 'fields')) {
      $this->fields .= " ".trim($stmt)." ".trim($order);
    }
    return $this;
  }


  /**
   * return counts of database from user's table
   * 
   * @param array|string $columns database table columns name
   * @return int
   */
  public function count(){
    
    return $this->counter();

  }

  /**
   * Find user information from the database
   * execute @property finder
   * Note: more than 1 results fetched will force find to return array
   * 
   * @param array|string $column columns to be fetched
   * @param array|string $limit limit of data to be fetched
   *  
   * @return array|string|false depending on argument supplied or data obtained
   */

  public function find($columns = '*'){
    
    return $this->finder('find', $columns);

  }

  /**
   * Find all related data from database columns
   * 
   * execute @property finder
   * @param array|string $columns  database columns
   * @param array|int|string $limit numeric limit of data to be fetched 
   * 
   * @return array depending on argument supplied
   */

  public function findAll($columns = '*', $limit = []) : array{
    
    return $this->finder('findAll', $columns, $limit);

  }


  /**
   * password fetch is disabled by default. 
   * This method makes it possible to verify password
   * 
   * Caution: This method is under development and should not be used
   * 
   * @param string $password
   * @return bool
   */
  public function verifies($password){
    $this->verify();
    return ($password === $this->password);
  }

  /**
   * Returns the data fetched results
   * 
   * @param string $infoname database table's column / field name 
   *
   * @return array|bool|mixed
   *    (array) => results if result or any key supplied is array
   *    (bool)  => returns false if (string) index key supplied does not exist
   *    (mixed) => returns value of the index key supplied if it exists
   */
  public function info($infoname = ''){
    
    $info = $this->info;
    if(func_num_args() == 0) {
      return $info; 
    }

    if(is_string($infoname)){
      if(empty(trim($infoname))){
          trigger_error('argument cannot be void');
          return false;
      }

      if(count(($exp = explode(',', str_replace(' ', '', $infoname)))) > 1){
        $infoname = $exp;
      }
    }

    if(is_array($infoname)){
      $newinfo = [];
      foreach($infoname as $infokey){
        
        if(isset($info[$infokey])){
          $newinfo[$infokey] = $info[$infokey];
        }else{
          $newinfo = [];
          if(trim($infokey) == ''){
            trigger_error('undefined argument index: " '.$infokey.' "');
          }else{
            trigger_error('undefined index: "'.$infokey.'"');
          }
          return;
        }   
      }
      return $newinfo;
    }

    return isset($info[$infoname])? $info[$infoname] : false;
  }
  
  /**
   * 
   * @param array $covals key pairs of columns and corresponding new values
   * @param bool $strict true returns true only if affected rows is not zero (0)
   *                     false returns true as long as no error occured, even if affected rows is less than one         
   * @return bool
   */
  public function set(array $covals = [], bool $strict = false) : bool {
    
    if(empty($covals)) {
      return $this->error_mess('empty data supplied');
    }
    
    $db = self::$dbh;

    $table = self::$init['USER_TABLE'];
    
    $where = $this->fields;
    $values = $this->values;
    
    $columns = array_keys($covals);
    $newvals = array_values($covals);

    //merge values with existing “where” values 
    $values = array_merge($newvals, $values);
    
    $sets = implode(' = ?, ', $columns). " = ? ";

    $db->query('UPDATE '.$table.' SET '.$sets.' '.$where, $values
    );
    
    $update = $db->update();
    
    if($error = $db->error()) return $this->error_mess($error);
    
    if($strict) return (bool) $db->num_rows();
    
    return $update; 
    
  }
  
  /**
   * Uses the set method. Only for strict types
   */
  public function sets(array $covals = []) : bool {
    return $this->set($covals, true);
  }

  /**
   * Updates database users table using 
   * relative configuration  parameters
   * Caution: This will return false if no current user id session exists
   * 
   * @param array $newdata data with key (database columns) and repective new values
   */
  public function updateUser(array $newdata){
      
      $init = self::$init;
      $userTable = User::config('USER_TABLE');
      $userField = User::config('USER_ID_FIELDNAME');
      
      $columns = array_keys($newdata);

      $thiss = new self;
      
      if(empty($columns)) {
        return $thiss->error_mess('empty data supplied');
      }
      
      if(empty($userTable)) {
        return $thiss->error_mess('invalid table name');
      }
      
      if(empty($userField)) {
        return $thiss->error_mess('invalid user field');
      }

      if(!User::id()) return false;
      
      $columns = implode(" = ? ", $columns).' = ? ';
          
      $values = array_values($newdata);
      
      $conn = User::auth()->con();

      $conn->query("UPDATE {$userTable} SET {$columns} WHERE {$userField} = '".User::id()."'", $values);
      
      return $conn->update() ;

  }

  /**
   * Set or fetch error messages
   *
   * @param string $message
   * @return false
   */
  public function num_rows($message = ''){
    return $this->dbh()->num_rows();
  }
  
  /**
   * Set or fetch error messages
   *
   * @param string $message
   * @return false
   */
  public function error_mess($message = ''){
    $this->message = $message;
    $this->error   = $message;
    return false;
  }

  /**
   * Return the last response message
   *
   * @return mixed
   */
  public function response(){
    return $this->message;
  }
  
  /**
   * Return the last error message
   *
   * @return mixed
   */
  public function error(){
    return $this->message;
  }

  /**
   * Defines if a primary key is returned.
   * This method should be used along with id() method
   *
   * @return UserAuth
   */
  public function primary(){
    $this->primary = true;
    return $this;
  }

  /**
   * Returns an authenticated user id
   *
   * @return string|UserIdResolver
   */
  public function id() {


    if(isset($this->primary)) {
      $this->primary = false;
      return User::id()->primary(); 
    }

    return User::id();

  }

}

 /*
  DOCUMENTATION FOR UserAuth CLASS

  //initialize with default connection
  $userAuth = new UserAuth;

  //initialize with a new connection
  $dbc = new DB(); $dbh = $dbc->openDB();
  $userAuth = new \core\classes\UserAuth($dbc, $dbh);

  Example 1: Getting Informations using default :init file

    $userAuth->table('table_name') //switch to a different table
    $userAuth->where(['email'=>$email]);
             
    $userAuth->find('firstname'); //return string
    $userAuth->find(['firstname']); //return array
    $userAuth->find('firstname, lastname'); //return array
    $userAuth->find(['*']); //return array
    $userAuth->find('*'); //return array
    $userAuth->find(); //return array
    var_dump($userAuth->response());

    if any error exists in query, an error is triggered (safe practice). Suppress error with @
    
    1) sample 1

      $response = ($username = @userAuth->find('username'))?? DBStatus::err();
      print $response;
      
    2) sample 2

      if($username = @userAuth->find('username')){
        print $username;
      }elseif($err = DBStatus::err()){
        print $err;
      }


 */