<?php

/**
 * Manage and Control session
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
 */
class Session extends spoova\core\classes\SharedInfo{
  
  private $sessid;
  private $login = false;
  private $isLoggedIn = false;
  private $logid;
  private $autoRedirect = false;
  private $algo  = 'sha1';
  private $new = false;

  // properties for remember me
  private static $sessionColumn;

  /**
   * User cookie key name in $_COOKIE
   * This value set in this variable will used for setting remember me
   *
   * @var string
   */
  private static $cookieName;

  /**
   * User session key name in $_SESSION
   * This is the assumed main session key containin user info 
   *
   * @var string
   */
  protected static $sessionName;
  private static $counter = 0;
  private static $auto;

  /**
   * Default login url
   *
   * @var string
   */
  private static $loginUrl = 'home';

  /**
   * Default logout url
   *
   * @var string
   */
  protected static $logoutUrl = 'index';
  
  /**
   * session cookie parameters
   *
   * @var array
   */
  private static $session_params = [
    'expire' => '86400',
    'path' => '/', 
    'domain' => '', 
    'secure' => false, 
    'httponly' => true
  ];
  
  /**
   * Cookie parameters
   *
   * @var array
   */
  private static $cookie_params = [
    'expire' => '',
    'path' => '/', 
    'domain' => '', 
    'secure' => true, 
    'httponly' => true
  ];  

  /**
   * automatically initialize session  
   * 
   * @param $sessionName, account key name
   * @param $cookieName, a default cookieName
   */
  function __construct(string $sessionName = '', string $cookieName = ''){
    if($sessionName === '::instance' and $cookieName === '::init') return ;
    self::$counter++;
 
    $this->start(); //start session

    if(self::$dbh === null && self::$dbe === null && self::$counter == 1){
        parent::__construct(true); //start connection
    }

    if(!empty($cookieName)) self::$cookieName = $cookieName;
    if(self::$counter > 1){
      
      //check settings 
      if(empty(self::$init)){
        //die('<div style="padding:30px; background-color:#efefef;">Please install or configure your setup file <a href="/install"> install </a> </div>');
      }
      
      //set values
      if(!empty($sessionName)){ self::$sessionName = $sessionName; } 
      if(!empty($cookieName)){ self::$cookieName = $cookieName; }  

      if(empty(self::$sessionName)) throw new Error('no account supplied');

    }
  }

  /**
   * start or initializes session
   *
   * @return void
   */
  private function start(){
    if(!isset($_SESSION)){
      //get cookie parameters
      self::$session_params['secure'] = function_exists('isSecure')? isSecure() : self::$session_params['secure'];
      $session_params = array_values(self::$session_params);
      if(!headers_sent()){
        session_set_cookie_params(...$session_params);
        session_start();  
      }
      
    }  
  }

  /**
   * An auto redirection method
   * 
   * @param string $redirType redirection type - options [login | logout].
   * @param $url url address of the redirection type
   */
  public function auto(string $redirType, string $url = null){
    if((func_num_args() > 1) && trim($url) == '') throw new Error('invalid argument supplied as parameter 2.');
    $redirType = strtolower(trim($redirType));
    
    if($redirType !== "login" && $redirType !== "logout") throw new Error('invalid argument supplied in as parameter 1. Value can only be login or logout');

    self::$auto = true; 

    if($redirType == "login"){
      self::$loginUrl = $url;
      $this->autoLogin();
    }elseif($redirType == "logout"){
      self::$logoutUrl = $url;
      $this->autoLogout();
    }
  }

  /**
   * This method is the same as session_set_cookie_params
   *
   * @param string $expire expire time
   * @param string $path session file path
   * @param boolean $secure 
   * @param boolean $httponly
   * @return void
   */
  public static function session_params($expire = '', string $path='/', bool $secure = false, bool $httponly = false){
    
    //secure session
    self::$session_params = [
      'expire' => $expire,
      'path'   => $path,
      'secure' => $secure,
      'httponly' => $secure,
    ];

  }

  /**
   * This method is the same as session_cookie_parameters
   *
   * @param string $expire expire time
   * @param string $path session file path
   * @param boolean $secure 
   * @param boolean $httponly
   * @return void
   */  
  public static function cookie_params($expire = '', string $path='/', string $domain = '', bool $secure = true, bool $httponly = true){
    
    //secure session
    self::$cookie_params = [
      'expire' => $expire,
      'path'   => $path,
      'domain' => $domain, 
      'secure' => $secure,
      'httponly' => $secure,
    ];

  }

  /** 
   * This method is the same as set_cookie
   *
   * @param string $value
   * @param int $expire
   * @param string $path
   * @param string $domain
   * @param boolean $secure
   * @param boolean $httponly
   * @return void
   */
  public function cookie(string $value, $expire = '', string $path='/', string $domain='', bool $secure = true, bool $httponly = true){
    
    //secure cookies
    if(self::$cookieName == ''){ throw new Error('cookie name has not been set'); }
    
    //merge settings with default
    if(func_num_args() > 1){
      $cookie_params = self::$cookie_params;
      $params = func_get_args();
      unset($params[0]);
      $newparams = array_values($params[0]);
      $newparams = array_merge($cookie_params, $newparams);
    }else{
      $newparams = self::$cookie_params;
    }
    
    $expire = $newparams[0];
    $path   = $newparams[1];
    $domain = $newparams[2];
    $secure = $newparams[3];
    $httponly = $newparams[4];
    
    $expire = (int) (!empty($expire)? $expire : time() + (86400 * 365)); //1 year
    $expire = ($expire === 0)? time() - (86400 * 365) : $expire;
    $domain = is_dir($domain)? $domain : $_SERVER['HTTP_HOST'];
    $expire = 100000;
    setcookie(self::$cookieName, $value, $expire, $path, $domain, $secure, $httponly);
    
  }

  /**
   * checks if a cookie of the curren declared session exists
   *
   * @return boolean returns true if cookie exists even if it is invalid
   */
  public function cookie_exists(): bool{
    return isset($_COOKIE[self::$cookieName]);
  }

  /**
   * logout user
   * 
   * @param string $url redirection url
   * @return void
   */
  public function logoutUser(string $url = ''){ 
    $this->endSession();
    $url = (self::$auto && empty($url))? self::$auto : $url;
    if($url != ''){ $this->autoLogout($url);}
  }

  /**
   * protected function for logging user in
   *
   * @param array, @param string $logdata data to be stored in $sessionName
   * @param string|bool(false) $url, redirection url (if false, no auto redirection is done)
   * @return void
   */
  protected function loginUser($logdata, $url = ''){
   return $this->internalLogin($logdata, $url);
  } 

  /**
   * logs in user internally
   */
  protected function internalLogin($logdata, $url){

    $this->checkSession();
    if(!isset($logdata['userid'])) {
      trigger_error('login failed: login data must contain userid key');
      return false;
    }
    if(!is_string($logdata['userid'])){
      trigger_error('userid must be a string');
      return false;    
    }
    $_SESSION[self::$sessionName] = $logdata;
    if($url === '') $url = self::$loginUrl;
    if($url !== false) $this->autoLogin($url);
    return true;
  }

  private function endSession(){
    $this->checkSession();
    $sessionName  = self::$sessionName;
    $_SESSION[$sessionName] = [];    
    unset($_SESSION[$sessionName]);
    if(isset(self::$cookieName)){
      $cookieName = self::$cookieName;
      if(isset($_COOKIE[$cookieName])){
        $this->cookie($cookieName,null,time() - 3600);
      }
    }
  }
  
  /**
   * automatically redirect users to a login url supplied, default: 'home'
   *
   * @param string $url
   * @return void
   */
  private function autoLogin(string $url = null){

    $this->checkSession();
    if(isset($_SESSION[self::$sessionName])){
        $url = $url == null ? self::$loginUrl : $url;
        
        if(isset($_SESSION[self::$sessionName]['userid'])){
          if($url === null) $url = self::$loginUrl;
          $this->autoRedirect($url);
        }
    }
  }

  private function autoLogout($url = null){
     $sessionName = $this->checkSession();
     if($url === null) $url = self::$logoutUrl;

     if(empty($_SESSION[$sessionName])){
        $this->endSession($sessionName);
        $this->autoRedirect($url);      
     }elseif(self::$auto && empty($_SESSION[$sessionName]['userid'])){
        $this->endSession($sessionName); 
        $this->autoLogout(self::$logoutUrl);
     }
  }

  /**
   * session key(s) must contain a data that has userid value
   * returns userid key in session
   * @param string $sessionName session key
   * @return void
   */
  public function userid($sessionName){
    $sessionName = $this->checkSession();
    if(isset($_SESSION[$sessionName]['userid'])){
      return $_SESSION[$sessionName]['userid'];
    }
  }

  private function autoRedirect($page){
    if($page == "/"){ $page = ""; }
    $url = (online)? DomUrl(fol.$page) : $page;
    redirect($url);
    die();
  }

  /**
   * set the rememberMe cookie name if used
   *
   * @param string $cookieName
   * @return void
   */
  public function cookieName(string $cookieName = null){
    if((empty($cookieName)) and (func_num_args() > 0)) trigger_error('cookie name cannot be void', E_USER_ERROR);
    if(func_num_args() === 0){ return self::$cookieName; }
    self::$cookieName = $cookieName;
  }

  /**
   * returns the current session name if it exists
   */
  public function sessionName(){
    return self::$sessionName;
  }

  /**
   * returns the current session name if it exists, else throws a new error;
   */  
  public function checkSession(){
    if(self::$sessionName == '') throw new Error('no session name found'); 
    return self::$sessionName;
  }

  /**
   * remembers a defined session name binded with cookie value
   * This will execute if no arguments is supplied
   * 
   * @param string $sessionColumn session identifier field/column in database table (e.g email , id)
   * @param string $sessionName session key name to be remembered 
   * @return void
   */
  public function remember(string $sessionColumn = '', string $sessionName = ''){

    if(empty($sessionColumn)) $sessionColumn = self::$sessionColumn = self::$init['USER_ID_FIELDNAME'];
    if(empty($sessionName)) $sessionName = self::$sessionName;    

    if(empty(trim($sessionColumn))){
      throw new Error('session database table id column name cannot be null');
    }

    if(empty(trim($sessionName))){
      throw new Error('session name cannot be null');
    }    

    //if no argument is supplied, proceed to use default table to remember user
    if((func_num_args() < 2) && (self::$init['USER_TABLE'] != '')){

      $this->on(self::$init['USER_TABLE']);

    }
    
    return $this;

  }
  
  /**
   * change the algorithm for hashing cookie
   *  
   * @param string $algo cookie hashing algorithm
   * @return void
   */
  public function algo(string $algo){

    if(!function_exists($algo)) {
      trigger_error('algo value is not a valid function', E_USER_ERROR);
    }

    $this->algo = $algo;

    return $this;
  }
  
  /**
   * for setting remember me. Works along with remember
   * 
   * @param string $dbTable database table name where cookie is stored. 
   *              (table name supplied above must contain session id field)
   * @return void
   */
  public function on(string $dbTable = ''){

    if(trim($dbTable) == '') $dbTable = self::$init['USER_TABLE'];

    if(trim($dbTable) == '') trigger_error('no database table set for cookie');

    if($dbTable != "") $this->remUser($dbTable);

  }

  /**
   * this function helps to remeber the current session being used
   *
   * @param string $dbTable database table name of cookie and session id field
   * @return void
   */
  private function remUser($dbTable){
  
    //for this to work, database table must contain cookie and email fields
    //this class is binded with session class
    if(!isset(self::$dbh)) return false; 

    $sessionF = self::$sessionColumn;
    $cookieKey = self::$cookieName;//admin, user e.t.c
    $sessionKey = self::$sessionName;

    if(empty($cookieKey) || empty($sessionKey)){
      trigger_error('cookie name or user id field cannot be empty!');
    }
   
    if(isset($_COOKIE[$cookieKey])){
      $security = $this->algo;
      $usercookie = $security($_COOKIE[$cookieKey]);

      if(!isset(self::$dbh)){
        trigger_error('no stable connection found!');
        return;
      }

      $db = self::$dbh;
      $init = self::$init;
      $cookieF = $init['COOKIE_FIELDNAME'];

      if(!$db->column_exists($dbTable, $sessionF)){ 
        trigger_error($sessionF. ' does not exists in current database'); 
        return false;
      }

      $db->query('SELECT `'.$cookieF.'`, `'.$sessionF.'` FROM '.$dbTable.' WHERE '.$cookieF.' = ? ',[$usercookie]);
      $db->read(1);
      if($userdetails = $db->results(0)) {
        
          $userid    = $userdetails[$this->idField()];

          //login the user
          $this->loginUser($sessionKey,['userid'=>$userid]);
      }else if($db->error_exists()) {

          trigger_error($db->error());

      }
 
    }

  }

}

/**
 * Documentation
 * Note 1 - session is automatically initialized / started upon the first Session() initialization
 * 
 * @property auto monitors sessions for automatic login and logout
 *      @param string $redirType login | logout
 *      @param string $sessionName session key to monitor
 *      @param string $url redirection url
 * 
 * @property userid return userid in user session array data
 *      @param string $sessionName session key
 *      Note:: to use this, session data must be in format session[$sessionName]['userid'=>'user_id_here']
 * 
 * @property remember remembers an existing cookie
 *      @param string $sessionName session key
 * 
 * @property on (optional if no parameter is supplied to remember() method), modifies the default database table for cookie and session id table
 * 
 *      @param string $remTab database table that contains cookie and session user id fields
 * 
 * @property cookie_exists() returns true if a the declared session cookie exists even if it is invalid
 */

/**
 * Sample of Usage
 * 
 * $Session  = new Session('session_name','cookie_name');
 * $Session2 = new Session(); //uses the default set above if not supplied
 * 
 * $userdata = ['userid'=>'some_id', 'name'=>'some_name'];
 * User::login($userdata, 'home'); //auto redirect to home
 * User::login($userdata, false); //prevent redirect to home
 * 
 * Note: 1) $userdata above will be stored in $_SESSION['session_name'];
 *       2) data supplied (e.g $userdata) should contain a key (userid) having a userid value;
 * 
 * #Monitor the session key 'admin' above
 * $Session->auto('login', 'home.php'); //redirect to home.php when admin is logged in
 * $Session->auto('logout', 'index.php'); //redirect to index.php when admin is logged out 
 * 
 * #Remember session key from an existing cookie
 * Note 1 - For this to work, database table selected must contain cookie field
 *      2 - cookie should be a unique hashed data generated from data but cannot be traced back 
 * 
 * In below,
 *  1: email is the session id identifier field in the database 
 *  2: session_name name is the session key name
 * 
 * $Session->remember('email','session_name')->on('users');
 * 
 * Since the session id field name and user table already exist in our init configuration
 * file, and the session name has been supplied as the first argument of our
 * Session class, then, using these configurations, we can say:
 * 
 * $Session->remember();
 * 
 * All redirections will be managed by $Session->auto();
 * 
 */


 new Session; //session has been initialized