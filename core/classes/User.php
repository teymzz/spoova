<?php

use teymzz\spoova\core\classes\DB;
use teymzz\spoova\core\classes\DB\DBHandler;
use teymzz\spoova\core\classes\UserAuth;
use teymzz\spoova\core\classes\UserDB;
use teymzz\spoova\core\classes\UserIdResolver;

class User extends Session{

    private static $passField  = 'password';
    private static $userFields = ['username']; 
    private static array $data = [];

    
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
    public static function auth(DB $dbc = null, DBHandler $dbh = null){
        
        return new UserAuth(...func_get_args());
    
    }

    /**
     * Retrieves the current user session id value from session data (i.e ['userid'=>some_id])
     *
     * @return string|UserIdResolver
     *   - string returns current user id relative to user database configuration id field
     */
    public static function id(){

        return (new UserIdResolver);

    }

    /**
     * Retrieves the current user session id value from session data (i.e ['userid'=>some_id])
     *
     * @return string
     */
    public static function autoID() : string{

        $data = self::data();

        return $data['id'] ?? '';
    }    

    /**
     * Returns all user configuration settings
     * 
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
     * Initializes a new user session with data supplied which must contain a userid key and value pair
     *
     * @param array $logdata session data containing a userid(key) & userid value (e.g ['userid'=>some_id])
     * @param string|bool(false) $url redirection url (optional if already using Session auto), false prevents redirection
     * @param int $lifeTime maximum session time. This is only used if cookie is set
     * 
     * @return bool true if login is successful
     */
    public static function login($logdata, $url = false, int $lifeTime = 86400){

        $parent = new parent;
        return $parent->loginUser(...func_get_args());
    } 

    /**
     * Terminate or logs out current user account/session
     *
     * @param string $url redirection url
     * @param bool $revokeCookie remove cookie data from database
     * @return void
     */
    public static function logout(string $url = '', bool $revokeCookie = false){
        $parent = new parent;
        $parent->logoutUser(...func_get_args());
    }     
    
    /**
     * Returns true if current user session has a key
     * 
     * @param string $key session key
     * @return bool
     */
    public static function sessionHas($key) : bool{
      
      $sessname = self::$sessionName;
      
      if(!$sessname) return false;
      
      if(!isset($_SESSION[$sessname])) return false;
      if(!is_array($_SESSION[$sessname])) return false;
      
      return (array_key_exists($key, $_SESSION[$sessname]));
      
    }

    /**
     * Returns UserControl class or triggers error
     *
     * @param string $name datanase table name
     * @param string $arguments arguments 
     * @return void|userDB
     */
    public static function __callStatic($name, $arguments = null)
    {
       if(substr($name, 0, 2) === 'DB'){
            $name = substr($name , 2, strlen($name));
            $arguments = (array) $arguments;
            return self::UserDB($name, ...$arguments);
       }else{
        trigger_error('invalid method called on User class');
       }
    }

    private static function UserDB($name, $arguments = []){
       return new UserDB($name, $arguments);
    }


    /**
     * Return the data of a currently signed in user
     *
     * @param array $fields selected fields
     * @return array
     */
    final static function data(array $fields = []) {

        if(empty(self::$data)){            
            $userId      = User::id();
            return self::setUserData($userId);
        }

        if(empty(self::$data)) return [];
        if(empty($fields)) return self::$data;

        return (array_intersect_key(self::$data, array_flip($fields)));

    }

    /**
     * Check if a user data exists
     *
     * @return boolean
     */
    final static public function hasUserData(){
        return (self::$data)? true : false;
    }

    /**
     * Fetch user data using user config's userIdField's relative id.
     *
     * @param string $userId userIdField's relative id
     * @return str
     */
    final static protected function setUserData(string $userId) : array{
            $auth = User::Auth()->dbh();
            $userTable = User::tableName();
            $userIdField = User::config('USER_ID_FIELDNAME');

            $query = "SELECT * FROM {$userTable} WHERE $userIdField = ?";

            $auth->query($query, [$userId])->read();

            return self::$data = $auth->results(0);
    }

    final static protected function authenticate_session($session_user_id){
        if(!self::setUserData($session_user_id)){
            Res::setFlash(':user-error','user error: user id mismatch!');
            self::logout(false); 
        }
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