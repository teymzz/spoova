<?php

use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\SharedInfo;

/**
 * Manage and Control session
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
class Session extends SharedInfo {
  
  private $sessid;
  private $login = false;
  private $isLoggedIn = false;
  private $logid;
  private $autoRedirect = false;
  private $algo  = 'sha1';
  private static ?Session $stream = null;
  private static $secure = false;

  /**
   * properties for remeber me
   *
   * @var string
   */
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
   * This is the assumed main session key containing user info 
   *
   * @var string
   */
  protected static $sessionName;
  private static $counter = 0;
  private static $auto;

  /**
   * Default login url
   *
   * @var string|bool
   * 
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
    'expire' => 0,
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
   * @param string $sessionName, account key name. This will be assumed as the session ($_SESSION) access key
   * @param string $cookieName, a default cookieName. This will be assumed as the cookie ($_COOKIE) access key
   * @param bool $secure, This will strictly unset a session if the session's userid stored, does exist in the default 
   * configured user id field name set in the icore/init file
   */
  function __construct(string $sessionName = '', string $cookieName = '',  bool $secure = false){
    if($sessionName === '::instance' and $cookieName === '::init') return ;
    self::$counter++;
 
    $this->start(); //start session

    if(self::$dbh === null && self::$dbe === null && self::$counter == 1){
        parent::__construct(true); //start connection
    }

    if(!empty($cookieName)) self::$cookieName = $cookieName;
    if(self::$counter > 1){
      
      //check settings 
      if(empty(self::$init)){/* no configuration set */}
      
      //set values
      if(!empty($sessionName)){ self::$sessionName = $sessionName; } 
      if(!empty($cookieName)){ self::$cookieName = $cookieName; } 
      self::$stream = $this; 

      if(empty(self::$sessionName)) throw new \Error('No session account defined');

      $this->remember();
    }


    if(func_num_args() > 2) self::secure($secure);

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
  public function auto(string $redirType, ?string $url = null){
    if((func_num_args() > 1) && trim($url) == '') throw new Error('invalid argument supplied as parameter 2.');
    $redirType = strtolower(trim($redirType));
    
    if($redirType !== "login" && $redirType !== "logout") throw new Error('invalid argument supplied in as parameter 1. Value can only be login or logout');

    self::$auto = true; 

    if($redirType == "login"){
      $url = ($url === null)? self::$loginUrl : $url; 
      self::$loginUrl = $url;
      $this->autoLogin();
    }elseif($redirType == "logout"){
      $url = ($url === null)? self::$logoutUrl : $url; 
      self::$logoutUrl = $url;
      $this->autoLogout();
    }
  }

  /**
   * An auto redirection static method controlled by session availability
   * 
   * This only runs if the user session is initialized
   * 
   * @param string $redirType redirection type - options [login | logout].
   * @param $url url address of the redirection type
   *  
   *  - if $redirType is login and url is null, a default home is set as url
   *  - if $redirType is logout and url is null, a default index is set as url
   *  - if $url is set as false, no redirection is made
   *  - if $url is set as string, redirection is made to specified string based on $redirType.
   * 
   * @return void
   */
  public static function onauto(string $redirType, ?string $url = null){

    if(static::$stream){
      static::$stream->auto(...func_get_args());
    }

  }

  /**
   * Return current session class or bool false
   *
   * @return bool|Session
   * @Notice: stream can only return the session class when a session has been initiailized
   */
  public static function stream() {

    return self::$stream;

  }

  /**
   * This method is the same as session_set_cookie_params. This should be used before session is started,
   * preferably at the top of the application.
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
      'expire'   => $expire,
      'path'     => $path,
      'secure'   => $secure,
      'httponly' => $secure,
    ];

  }

  /**
   * This method is the same as session_cookie_parameters. Should be used before cookie() method is called
   *
   * @param string $expire expire time 
   * @param string $path session file path
   * @param boolean $secure 
   * @param boolean $httponly
   *   - @notice: $expire time (lifetime) should be left as zero
   * @return void
   */  
  public static function cookie_params(int $expire = 0, string $path='/', string $domain = '', bool $secure = true, bool $httponly = true){
    
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
   * This method is the similar to set_cookie. The cookie name will be pulled from session cookie name.
   * Hence, cookie name should not be defined!
   * 
   *
   * @param string $value
   * @param int $expire 
   * @param string $path
   * @param string $domain
   * @param boolean $secure
   * @param boolean $httponly
   * 
   *    - @notice: The $expireTime set will be added to the current time. Default is 86400 (1 day)
   *    - @notice: $expireTime cannot be set as zero (i.e 0). This will end the session
   * @return void
   */
  public function cookie(string $value, $expire = 86400, string $path='/', string $domain='', bool $secure = true, bool $httponly = true){

    //secure cookies
    if(self::$cookieName == ''){ throw new Error('cookie name has not been set'); }
    
    //merge settings with default
    if(func_num_args() > 1){

      $params = func_get_args();
      unset($params[0]); //remove $value from list 

      $cookie_params = self::$cookie_params;

      $lifeTime = '';

      $newparams = array_values($params);
      $cookie_params = array_values($cookie_params);
      $newparams = array_replace($cookie_params, $newparams);
      $newparams = array_values($newparams); 
    }else{
      $newparams = array_values(self::$cookie_params);
    }

    $expire = $newparams[0];
    $path   = $newparams[1];
    $domain = $newparams[2];
    $secure = $newparams[3];
    $httponly = $newparams[4];
    
    //$expire = (int) (!empty($expire)? $expire : time() + $expire); //(86400 * 365) => 1 year

    $expire = ($expire === 0)? -time() : time() + $expire; 

    $domain = is_dir($domain)? $domain : $_SERVER['HTTP_HOST'];

    setcookie(self::$cookieName, $value, $expire, $path, '', $secure, $httponly);

  }

  /**
   * checks if a cookie of the currently declared session exists
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
  public function logoutUser(string $url = '', bool $destroyCookie = false){ 
    $this->endSession($destroyCookie);
    $url = (self::$auto && empty($url))? self::$logoutUrl : $url;
    if($url != ''){ $this->autoLogout($url); } 
  }

  /**
   * protected function for logging user in
   *
   * @param array $logdata data to be stored in $sessionName
   * @param string|bool(false) $url, redirection url (if false, no auto redirection is done)
   * @return bool
   */
  protected function loginUser(array $logdata, $url = '', $lifeTime = 86400) : bool{
   return $this->internalLogin($logdata, $url, $lifeTime);
  } 

  /**
   * logs in user internally
   */
  /**
   * Sets the user data internally
   *
   * @param array $logdata user session data
   * @param string $url
   * @param integer $lifetime
   * @return bool
   */
  protected function internalLogin(array $logdata, string $url, $lifeTime = 86400) : bool{

    $this->checkSession();
    if(!isset($logdata['userid'])) {
      trigger_error('login failed: login data must contain userid key');
      return false;
    }
    if(!is_string($logdata['userid'])){
      trigger_error('userid must be a string');
      return false;    
    }
    
    if(!$logdata['userid']){
      trigger_error('userid cannot be empty');
      return false;         
    }
    
    $Request = new Request;

    $formdata = $Request->data();

    if(isset($formdata['remember']) && ($formdata['remember'] == 'on')) {
      
      //get the cookie field in database ... 
      $cookieFieldName = User::config('COOKIE_FIELDNAME');
      $userIdFieldName = User::idField();
      $userTableName = User::tableName();

      $dbh = self::$dbh; 
      
      $checkCookieField = true; //check if an old cookie field existed

      if(!$dbh->column_exists($userTableName, $cookieFieldName)) {

        //try to create a column
        $dbh->addColumn([$userTableName => $cookieFieldName], 'varchar(200)', '|password', 'NOT NULL', '');
        $checkCookieField = false;
      }

      $cookie = ''; $setCookie = true; $addNewCookie = false;

      //check if column exists
      if($dbh->column_exists($userTableName, $cookieFieldName)) {

        //get the value of the user cookie

        if($checkCookieField){

          $dbh->query("SELECT `{$cookieFieldName}` FROM `{$userTableName}` WHERE `{$userIdFieldName}` = ?", [$logdata['userid']]);

          if($dbh->read(1)){
            $cookie = $dbh->results(0)[$cookieFieldName];
            if(!$cookie) $addNewCookie = true;
          }else{
            $setCookie = false;
          }

        }else{
          
          $addNewCookie = true;

        }

       
        if($addNewCookie) {   
          
          //generate a new cookie value and insert into database... 
          $cookie = base_encode(randice(20));

          
          //update with a new cookie 
          $dbh->query("UPDATE $userTableName SET {$cookieFieldName} = ?", [$cookie]);
           
          if(!$dbh->update()) {
            Form::setError($dbh->error());
            return false;
          }
          
        }


        if($setCookie) $this->cookie($cookie, $lifeTime);
        $_SESSION[self::$sessionName] = $logdata;
        if($url === '') $url = self::$loginUrl;
        if($url !== false) $this->autoLogin($url);
 
        return true; 

      } else{

        return EInfo::view('Using remember me on undefined cookie field!');

      }

    }else {

      if(!isset($_SESSION[self::$sessionName])){
        $_SESSION[self::$sessionName] = $logdata;
        
        if($url === '') $url = self::$loginUrl;
        if($url !== false) $this->autoLogin($url);
      }

      return true;     

    }
    




  }

  private function endSession(bool $destroyCookie = false){
    $this->checkSession();
    $sessionName  = self::$sessionName;
    $_SESSION[$sessionName] = [];    
    unset($_SESSION[$sessionName]);
    if(isset(self::$cookieName)){
      $cookieName = self::$cookieName;
      if(isset($_COOKIE[$cookieName])){
        $this->cookie($cookieName, time() - 3600);
        if($destroyCookie) {

          //update database and remove cookie

           $dbh = self::$dbh;
           $cookieFieldName = User::config('COOKIE_FIELDNAME');
           $userTableName = User::tableName();

           //update with a new cookie 
           $dbh->query("UPDATE $userTableName SET {$cookieFieldName} = ?", [''])->update();

        }
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
        $this->endSession();
        $this->autoRedirect($url);      
     }elseif(self::$auto && empty($_SESSION[$sessionName]['userid'])){
        $this->endSession(); 
        $this->autoLogout(self::$logoutUrl);
     }
  }

  /**
   * session key(s) must contain a data that has userid value
   * returns userid key in session
   * @param string $sessionName session key
   * @return string
   */
  public function userid($sessionName): string{
    $sessionName = $this->checkSession();
    if(isset($_SESSION[$sessionName]) && isset($_SESSION[$sessionName]['userid'])) {

      return $_SESSION[$sessionName]['userid'];
    }
    return '';
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
   * 
   * @return string 
   */  
  public function checkSession(){
    if(self::$sessionName == '') throw new Error('no session name found'); 
    return self::$sessionName;
  }

  /**
   * remembers a defined session name binded with cookie value
   * This will execute with default "icore/init" parameters if no arguments is supplied
   * 
   * @param string $sessionColumn session identifier field/column in database table (e.g email , id)
   * @param string $sessionName session key name to be remembered 
   * @return Session
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
   * @return Session
   */
  public function algo(string $algo){

    if(!function_exists($algo)) {
      trigger_error('algo value is not a valid function', E_USER_ERROR);
    }

    $this->algo = $algo;

    return $this;
  }

  /**
   * Strictly Secure a session. This will unset a session if the session's 
   * userid stored, does exist in the default configured user id field name   
   * set in the icore/init file
   *  
   *
   * @param boolean|null $secure
   * @return bool|null
   */
  public static function secure(bool $secure = null){

    if(func_num_args() > 0){
      self::$secure = $secure;
    }

    return self::$secure;

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
   * Remembers the current session being used. 
   *   - Notice: Database table fields must contain COOKIE_FIELDNAME and  USER_ID_FIELDNAME values set in icore/init file
   *   - Notice: Cookie value cannot be empty. User::login() will generate this by default.
   * 
   * @param string $dbTable database table name of cookie and session id field
   * @return void|false
   */
  private function remUser($dbTable){

    if(!isset(self::$dbh)) return false; 

    $sessionF = self::$sessionColumn;
    
    $cookieKey = self::$cookieName; //cookie access key
    $sessionKey = self::$sessionName; //session access key

    if(empty($cookieKey) || empty($sessionKey)){
      trigger_error('cookie name or user id field cannot be empty!');
    }

    /* ensure that cookie key is not null */
    if(isset($_COOKIE[$cookieKey]) && $_COOKIE[$cookieKey]){

      //$security = $this->algo;//$security();
      $usercookie = $_COOKIE[$cookieKey]; 
 
      if(!isset(self::$dbh)){
        trigger_error('no stable connection found!');
        return false;
      }

      if(!empty($usercookie)){

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
          
            $userid = $userdetails[$this->idField()];
  
            $this->loginUser(['userid'=>$userid]);
  
        }else if($db->error_exists()) {
  
          trigger_error($db->error());
  
        }

      }

 
    }else{
        //$this->loginUser(['userid'=>$userid]);
    }

  }

}

/**
 * Documentation
 * Note 1 - session is automatically initialized / started upon the first Session() initialization
 * 
 * @method auto() monitors sessions for automatic login and logout
 *      @param string $redirType login | logout
 *      @param string $sessionName session key to monitor
 *      @param string $url redirection url
 * 
 * @method userid() return userid in user session array data
 *      @param string $sessionName session key
 *      Note:: to use this, session data must be in format session[$sessionName]['userid'=>'user_id_here']
 * 
 * @method remember() remembers an existing cookie
 *      @param string $sessionName session key
 * 
 * @method on() (optional if no parameter is supplied to remember() method), modifies the default database table for cookie and session id table
 * 
 *      @param string $remTab database table that contains cookie and session user id fields
 * 
 * @method cookie_exists() returns true if a the declared session cookie exists even if it is invalid
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