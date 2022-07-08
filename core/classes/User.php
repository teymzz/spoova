<?php

use spoova\core\classes\DB;
use spoova\core\classes\DBHandler;
use spoova\core\classes\UserAuth;

class User extends Session{

    private static $passField  = 'password';
    private static $userFields = ['username']; 

    
    function __construct(){
        $args = func_get_args();
        parent::__construct(...$args);
    }

    /**
     * modify the user fields to be validated
     * 
     * @param string|array $fields name of fields
     * @return void
     */
    public static function userFields($fields, $passField = ''){
        if(is_string($fields)) $fields = (array) trim($fields);
        if(!is_array($fields) || empty($fields)) trigger_error('invalid paramter supplied', E_USER_ERROR) ;

        self::$userFields = $fields;

        if(func_get_args() > 1){
            self::passField($passField);
        }
    }

    /**
     * modifies only the default password field name
     * 
     * @param string $passField
     * @return void
     */
    public static function passField(string $passField){
        if(empty(trim($passField))) trigger_error('invalid password field name supplied', E_USER_ERROR);

        self::$passField = $passField;
    }


    /**
     * Returns the UserAuth class
     *
     * {@see UserAuth::__construct()}
     * @return UserAuth
     */
    public static function Auth(DB $dbc = null, DBHandler $dbh = null){
        
        return new UserAuth(...func_get_args());
    
    }

    /**
     * Returns the current User session custom Id value 
     *
     * @return void
     */
    public static function id(){
        if(isset($_SESSION[self::$sessionName])){
            if(empty($_SESSION[self::$sessionName]['userid'])) {
                self::logout();
                return '';
            }else{
              return ($_SESSION[self::$sessionName]['userid'])?: null;  
            }
        }
    }
    
    /**
     * Returns all user configuration settings
     * @param string $param defined key name exiting in configuration settings
     * @return [array | string]  
     */
    public static function config(string $param = ''){
        $init = self::$init;
        $init['DBNAME'] = isset(self::$dbh)? self::$dbh->currentDB() : '';
        if(self::id()){
            $init['ID'] = self::id() ;
        }
        
        $auth = new static("::instance", "::init");

        $init['SESSION_NAME'] = $auth->sessionName();
        $init['COOKIE_NAME']  = $auth->cookieName();
    
        if(func_num_args() > 0){
            return $init[$param];
        }
        return $init;
    }

    /**
     * protected function for logging user in
     *
     * @param array $logdata session data containing a userid & userid value 
     * @param string|bool(false) $url redirection url (optional if already using Session auto), false prevents redirection
     * @return boolean if login is successful
     */
    public static function login($logdata, $url = ''){

        $parent = new parent;
        return $parent->loginUser(...func_get_args());
    } 

    /**
     * protected function for logging user out
     *
     * @param array, @param string $url redirection url
     * @return void
     */
    public static function logout(string $url = ''){
        $parent = new parent;
        $parent->logoutUser(...func_get_args());
    }     
    
    /**
     * Returns true if current user session has a key
     */
    public static function sessionHas($key) : bool{
      
      $sessname = self::$sessionName;
      
      if(!$sessname) return false;
      
      if(!isset($_SESSION[$sessname])) return false;
      if(!is_array($_SESSION[$sessname])) return false;
      
      return (array_key_exists($key, $_SESSION[$sessname]));
      
    }


}

/** 
 * This method is used along with Session Class
 * 
 * SAMPLES FOR SETTING UP A LOGIN SYSTEM
 * 
 * SAMPLE A - USING NEW ARGUMENTS
 * 
 * #Start a new Session by supplying a session name and cookie name
 * #cookie name will be used for remember me.
 * $Session  = new Session('session_name','cookie_name');
 * 
 * #setting up a remember me. This will redirect if all parameters are suppied
 * $Session->remember('session_name','session_field_name_in_database')
 *         ->on('cookie_and_session_database_field_name_in_database');
 * 
 * $userdata = ['userid'=>'some_id', 'name'=>'some_name'];
 * 
 * if(User::login($userdata)){
 *     
 *    //a data is only set if it contains a userid. 
 *    print User::id(); //returns session userid value  
 *   
 * }
 * 
 * User::logout('index.php'); // logs out a current user session and redirects to index.php
 * 
 * SAMPLE B- USING DEFAULT CONFIGURATIONS
 * 
 * $Session  = new Session('session_name','cookie_name');
 * $Session->remember();
 *  
 * $userdata = ['userid'=>'some_id', 'name'=>'some_name'];
 * 
 * User::login($userdata,'index.php')// save data into session_name and redirect. (Or) used as sample 1 above
 * User::logout() //logs out a current user session without redirection
 * 
*/