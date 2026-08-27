<?php

use spoova\mi\core\classes\CSRF;
use spoova\mi\core\classes\DB\DBSessionHandler;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\RedisSessionHandler;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\Sessionbase;
use spoova\mi\core\classes\SharedInfo;

/**
 * Manage and Control session
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Session extends SharedInfo {
  
  private $sessid;
  private $login = false;
  private $isLoggedIn = false;
  private $logid;
  private $autoRedirect = false;
  private $algo  = 'sha1';
  private static ?Session $stream = null;
  /**
   * Overrides the SESSION_HANDLER init key when set.
   *
   * @var string|null
   */
  private static ?string $handler = null;
  private static $secure = false;

  /** how long a rotated remember me cookie is kept for, matching the login default */
  private const REMEMBER_LIFETIME = 86400;

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
  protected static $sessionName = '';
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
   * @param string $sessionName Session account access key name. This will be assumed as the session ($_SESSION) access key
   * @param string $cookieName A default cookieName. This will be assumed as the cookie ($_COOKIE) access key
   * @param bool $secure This is used to authenticate a session userid key that must exist in session data. This userid value must match the icore/init USER_ID_FIELDNAME field's value in database.
   */
  function __construct(string $sessionName = '', string $cookieName = '',  bool $secure = false){
    
    self::$counter++;

    if(!isset(self::$stream)){
      self::$stream = $this;

      if(self::$dbh === null && self::$dbe === null && self::$counter === 1){
          parent::__construct(true); //start connection & set init
      }

      $this->start(); //start session

    }

    if(self::$counter > 1){

      // check settings 
      if(empty(self::$init)){/* no configuration set */}
      
      // set values
      if(!empty($sessionName)){ 
        self::$sessionName = $sessionName; 
      }

      if(!empty($cookieName)){ 
        self::$cookieName = $cookieName; 
      } 

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

        /* Without strict mode PHP adopts whatever session id it is handed, including
           one it never issued. That is what makes a fixed id usable in the first
           place, so it is set before the session is opened rather than after. */
        @ini_set('session.use_strict_mode', '1');

        //register a storage handler when one has been configured
        self::attachHandler();

        session_set_cookie_params(...$session_params);
        //set storage name
        session_name(Session::storage_key());
        session_start();
        return true;
      }
    } 

  }

  /**
   * An auto redirection method
   * 
   * @param string $redirType redirection type - options [login | logout].
   * @param string|null $url url address of the redirection type
   */
  public function auto(string $redirType, ?string $url = null){
    if((func_num_args() > 1) && is_string($url) && trim($url) == '') throw new Error('invalid argument supplied as parameter 2.');
    $redirType = strtolower(trim($redirType));
    
    if($redirType !== "login" && $redirType !== "logout") throw new Error('invalid argument supplied in as parameter 1. Value can only be login or logout');

    self::$auto = true; 

    if($redirType === "login"){
      if($url === null) {
        $url = self::$loginUrl;
      } 
      self::$loginUrl = $url;
      $this->autoLogin();
    }elseif($redirType === "logout"){
      if($url === null) {
        $url = self::$logoutUrl;
      } 
      self::$logoutUrl = $url;
      $this->autoLogout();
    }
  }

  /**
   * An auto redirection static method controlled by session availability
   * 
   * This only runs if the user session is initialized
   * 
   * @param string $type redirection type - options [login|logout].
   *  - When set as "login", automatic redirection is made to a specified url when a 
   *    session is active. This is best used in signup or login pages to force an auto-redirection 
   *    to a home page when session becomes active.
   *  - When set as "logout", automatic redirection is made to a specified url when 
   *    session is not active. This is best used in user-related pages to force auto-redirection when user is logged out.
   * @param string $url defines the redirection destination url
   *  -If $url is not specified, and $type is "login", default destination url will be set as home
   *  -If $url is not specified, and $type is "logout", default destination url will be set as index
   *  -If $url is set as false, no redirection will be made
   * @return void
   */
  public static function onauto(string $type, ?string $url = null){

    if(static::$stream){
      if(self::$sessionName) static::$stream->auto(...func_get_args());
    }

  }

  /**
   * Return current session class or bool false
   *  - Notice: stream (i.e Session) can only return the session class when a session has been initiailized
   *
   * @return Session|false
   */
  public static function stream() : Session|false {

    return self::$stream ?? false;

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
   * @param boolean $domain 
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
      'httponly' => $httponly,
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
   * @param boolean $destroyCookie TRUE destroys while FALSE ignores.
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
   * @param string|false $url, redirection url (if false, no auto redirection is done)
   * @param integer $lifeTime expiry time
   * @return bool
   */
  protected function loginUser(array $logdata, string|false $url = false, $lifeTime = 86400) : bool{
   return $this->internalLogin($logdata, $url, $lifeTime);
  }

  /**
   * logs in user internally
   */
  /**
   * Sets the user data internally
   *
   * @param array $logdata user session data
   * @param string|false $url redirection url
   * @param integer $lifeTime expiry time
   * @return bool
   */
  protected function internalLogin(array $logdata, string|false $url, $lifeTime = 86400) : bool{

    $this->checkSession();
    if(!isset($logdata['userid'])) {
      trigger_error('login failed: login data must contain userid key');
      return false;
    }
    if(!is_string($logdata['userid']) && !is_integer($logdata['userid'])){
      trigger_error('userid must be of a valid string or integer format');
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

      if(!$dbh->column_exists($userTableName, $cookieFieldName)) {

        //try to create a column
        $dbh->addColumn([$userTableName => $cookieFieldName], 'varchar(200)', '|password', 'NOT NULL', '');
      }

      //check if column exists
      if($dbh->column_exists($userTableName, $cookieFieldName)) {

        /* A token is issued on every login that asks to be remembered. The stored value is
           only ever a hash of it, so there is no earlier token to hand back: the token
           itself lives in the visitor's browser and nowhere else. One account therefore
           holds one active token, and signing in elsewhere retires the previous one. */
        $cookie = self::rememberToken();

        /* The row being given this token must be named. Without the WHERE clause every
           account in the table received the same value, so the cookie no longer identified
           anybody: remUser() looks a user up by that value alone and would sign the
           returning visitor in as whichever row matched first, while every other user's
           remember-me token was destroyed on each login. */
        $dbh->query(
          "UPDATE `{$userTableName}` SET `{$cookieFieldName}` = ? WHERE `{$userIdFieldName}` = ?",
          [self::rememberHash($cookie), $logdata['userid']]
        );

        if(!$dbh->update()) {
          Form::setError($dbh->error());
          return false;
        }

        $this->cookie($cookie, $lifeTime);
        Session::save(self::$sessionName, $logdata);

        if($url === '') $url = self::$loginUrl;
        if($url !== false) $this->autoLogin($url);
 
        return true; 

      } else{

        return EInfo::view('Using remember me on undefined cookie field!');

      }

    }else {

      if(!Session::has(self::$sessionName)){

        /* A visitor's session id must not survive the moment they become somebody.
           Anyone who planted or observed the id beforehand would otherwise hold a
           logged-in session — session fixation. Issued before the account data is
           written, so the credentials only ever exist under the new id. */
        self::renewId();

        Session::save(self::$sessionName, $logdata);
        if($url === '') $url = self::$loginUrl;
        if($url !== false) $this->autoLogin($url);
      }

      return true;

    }

  }

  /**
   * Register a session storage handler, when one has been asked for.
   *
   * The store is named by the SESSION_HANDLER init key. "files" is PHP's own
   * handler and needs nothing registered, which is why it is also the default:
   * a project that has not chosen keeps working exactly as before.
   *
   *   files     — PHP's filesystem handler (default, fastest, single server only)
   *   database  — the project's database, so several servers share one store
   *   redis     — an in-memory store, if the redis extension is installed
   *
   * Anything that cannot be set up falls back to the filesystem rather than
   * failing the request: a session store that is momentarily unreachable should
   * log people out, not take the site down.
   *
   * @return string the handler actually in use
   */
  public static function attachHandler() : string {

    $handler = strtolower(trim((string) (self::handlerName())));

    if($handler === '' || $handler === 'files' || $handler === 'file') return 'files';

    if($handler === 'database' || $handler === 'db'){

      if(!class_exists(DBSessionHandler::class)) return 'files';

      try{
        return session_set_save_handler(new DBSessionHandler(), true)? 'database' : 'files';
      }catch(\Throwable){
        return 'files'; // no database yet, or it is unreachable
      }

    }

    if($handler === 'redis'){

      if(!RedisSessionHandler::available()){
        EInfo::view('SESSION_HANDLER is set to redis but the redis extension is not installed.');
        return 'files';
      }

      try{
        $redis = new RedisSessionHandler();
        // a store that cannot be reached must not take the site down with it
        if(!$redis->open('', '')) return 'files';
        return session_set_save_handler($redis, true)? 'redis' : 'files';
      }catch(\Throwable){
        return 'files';
      }

    }

    EInfo::view('Unknown SESSION_HANDLER "'.$handler.'". Falling back to file storage.');

    return 'files';

  }

  /**
   * Choose the session store at runtime, overriding whatever the configuration says.
   *
   *   Session::use('redis');      // default | files | database | redis
   *
   * Nothing above this changes. Handlers are registered with PHP itself, so
   * Session::save(), Session::remove(), User::login() and User::logout() keep
   * writing through $_SESSION exactly as before and land in whichever store is
   * active — the storage is a deployment choice, not something application code is
   * written against.
   *
   * Because the framework opens a session as it loads, this usually arrives after
   * the session is already running. It therefore migrates a live session rather
   * than refusing: the contents are carried across, the id is kept, and the old
   * store's copy is left to expire.
   *
   * @param string $handler default, files, database or redis
   * @return bool TRUE when the store is in use
   */
  public static function use(string $handler) : bool {

    $handler = strtolower(trim($handler));

    $known = ['default', 'files', 'file', 'database', 'db', 'redis'];

    if(!in_array($handler, $known, true)){
      EInfo::view('Session::use() expects one of '.implode(', ', $known).'.');
      return false;
    }

    self::$handler = ($handler === 'default')? 'files' : $handler;

    // not started yet — start() will pick this up when it registers the handler
    if(session_status() !== PHP_SESSION_ACTIVE) return true;

    if(headers_sent()){
      EInfo::view('Session::use() cannot change the session store after output has been sent.');
      return false;
    }

    /* Carried across by hand: the data belongs to the old store, and once the new
       handler is registered nothing would go back for it. */
    $data = $_SESSION ?? [];

    session_write_close();

    $applied = self::attachHandler();

    session_start();

    $_SESSION = $data;

    return $applied === self::$handler;

  }

  /**
   * The session store currently in use.
   *
   * @return string
   */
  public static function using() : string {

    $handler = self::handlerName();

    return ($handler === '' || $handler === 'file')? 'files' : $handler;

  }

  /**
   * The configured storage handler name.
   *
   * @return string
   */
  private static function handlerName() : string {

    if(self::$handler !== null) return self::$handler;

    // Init needs the project's icore directory, so it can only be asked once booted
    if(!defined('_icore') || !class_exists(Init::class)) return '';

    return (string) (Init::key('SESSION_HANDLER') ?: '');

  }

  /**
   * Issue a new session id, carrying the current data across to it.
   *
   * Called whenever the identity behind a session changes, which is the point at
   * which an id an attacker may already know has to stop being valid.
   *
   * @return bool TRUE when a new id was issued
   */
  public static function renewId() : bool {

    // nothing to renew before a session exists, and no way to send the new cookie afterwards
    if(session_status() !== PHP_SESSION_ACTIVE || headers_sent()) return false;

    // TRUE deletes the old record, so the previous id cannot be resumed
    return session_regenerate_id(true);

  }

  private function endSession(bool $destroyCookie = false){
    $this->checkSession();
    $sessionName  = self::$sessionName;

    /* Whose token is being revoked has to be established before the session is cleared.
       Matching on the cookie the browser presented is not enough: a visitor arriving on a
       remember me token is given a fresh one on the way in, so by the time they reach a
       logout the value they arrived with is no longer the value stored. */
    $accountId = $destroyCookie? (string) User::id(true) : '';

    Session::save($sessionName, []);
    Session::remove($sessionName);

    /* Logging out is the same change of identity in reverse. Renewing here stops a
       logged-out id from being reused for the next sign in on a shared machine. */
    self::renewId();

    if(isset(self::$cookieName)){
      $cookieName = self::$cookieName;
      if(isset($_COOKIE[$cookieName])){

        /* cookie() takes the value first and counts the expiry from now, so passing the
           cookie's own name and a past timestamp handed it a junk value with an expiry
           decades ahead instead of removing it. Zero is what ends a cookie here. */
        $this->cookie('', 0);

        if($destroyCookie) {

          //update database and remove cookie

           $dbh = self::$dbh;
           $cookieFieldName = User::config('COOKIE_FIELDNAME');
           $userTableName = User::tableName();
           $userIdFieldName = User::idField();

           /* One account's token, and only that one. Without a WHERE clause at all, a single
              logout cleared the remember-me token of every user in the table. Where the
              account could not be established, the token presented is the next best match. */
           if($accountId !== ''){
             $dbh->query(
               "UPDATE `{$userTableName}` SET `{$cookieFieldName}` = ? WHERE `{$userIdFieldName}` = ?",
               ['', $accountId]
             )->update();
           }else{
             $dbh->query(
               "UPDATE `{$userTableName}` SET `{$cookieFieldName}` = ? WHERE `{$cookieFieldName}` = ?",
               ['', self::rememberHash($_COOKIE[$cookieName])]
             )->update();
           }

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
  private function autoLogin(?string $url = null){

    if(isset(self::$sessionName)){
      $this->checkSession();
  
      if(Session::has(self::$sessionName)){
        if(Session::has(self::$sessionName, 'userid')){
            if($url === null) $url = self::$loginUrl;
            $this->autoRedirect($url);        
        } 
      }
    }
  }

  private function autoLogout(?string $url = null){
     $sessionName = $this->checkSession();
     if($url === null) $url = self::$logoutUrl;

     if(!Session::has($sessionName)){
        $this->endSession();
        $this->autoRedirect($url);      
     }elseif(self::$auto && !(Session::value($sessionName, 'userid'))){
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
    if(Session::has($sessionName) && Session::has($sessionName, 'userid')) {
      return Session::value($sessionName, 'userid');
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
  public static function cookieName(?string $cookieName = null){
    if((empty($cookieName)) and (func_num_args() > 0)) trigger_error('cookie name cannot be void', E_USER_ERROR);
    if(func_num_args() === 0){ return self::$cookieName; }
    self::$cookieName = $cookieName;
  }

  /**
   * returns the current session name if it exists
   */
  public static function sessionName(){
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
  public static function secure(?bool $secure = null){

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
  
        // only the hash of a token is stored, so the cookie is matched in that same form
        $presented = self::rememberHash($usercookie);

        $db->query('SELECT `'.$cookieF.'`, `'.$sessionF.'` FROM '.$dbTable.' WHERE '.$cookieF.' = ? ',[$presented]);
        $db->read(1);
        if($userdetails = $db->results(0)) {

            $userid = $userdetails[$sessionF] ?? $userdetails[$this->idField()] ?? '';

            /* A token is spent once it has been used. The visitor leaves with a new one, so
               a copy taken from their browser stops working the moment they return, and a
               token that turns up twice is no longer a token this account answers to. */
            $token = self::rememberToken();

            $db->query(
              'UPDATE `'.$dbTable.'` SET `'.$cookieF.'` = ? WHERE `'.$cookieF.'` = ?',
              [self::rememberHash($token), $presented]
            )->update();

            $this->cookie($token, self::REMEMBER_LIFETIME);

            $this->loginUser(['userid'=>$userid]);

        }else if($db->error_exists()) {
  
          trigger_error($db->error());
  
        }

      }

    }

  }

  /**
   * Returns a new remember me token.
   *
   * The token is the credential that signs a visitor back in, so it is drawn from the
   * system's cryptographic source. randice(), which stood here, is built on rand(), whose
   * next value can be worked out from the ones before it.
   *
   * @return string
   */
  private static function rememberToken() : string {

    return bin2hex(random_bytes(32));

  }

  /**
   * Returns the form a remember me token is stored in.
   *
   * Only the hash of a token is kept, so a copy of the user table cannot be used to sign in
   * as anybody: the token itself exists in the visitor's browser and nowhere else.
   *
   * @param string $token
   * @return string
   */
  private static function rememberHash(string $token) : string {

    return hash('sha256', $token);

  }

  public static function storage_key() : string {

    return self::$init['SESSION_STORAGE_KEY'] ?? '';

  }

  /**
   * Return true if the session storage contains a particular root key or a root key's direct subkey
   *
   * @param string $key a session key to be checked. 
   * @param string $value a subkey of session key (i.e $key) to be checked. 
   * @return boolean
   */
  public static function has(string $key, string $value = '') : bool{

    $storage = $_SESSION ?? [];
    
    if(is_array($storage) && array_key_exists($key, $storage)){
      if(func_num_args() > 1){
        $storage = $storage[$key];
        return (is_array($storage) && array_key_exists($value, $storage));
      }
      return true;
    }
    return false;
  }

  public static function save(string $key, mixed $value){
    $session = &$_SESSION ?? [];

    $session[$key] = $value;

    $_SESSION = $session;
  }

  public static function overwrite(array $value){
    $_SESSION = $value;  
  }

  /**
   * Returns the value in which a session contains in the application environment
   *
   * @param string $key Defines a specific key in session whose value is to be returned 
   *  - If not supplied, this will return the entire value in the session environment.
   * @param string|array $subkey If supplied, defines a subkey of $key whose value must be  returned. 
   *  - This is only useful if the value of the $key provided is an array that has a $subkey. The value 
   *    of that subkey will be returned. If the subkey does not exist, an empty string is returned.
   *  - If $subkey is set as an array, all corresponding values of that array will be searched and the value 
   *    returned as an array list.
   * @return mixed
   */
  public static function value(string $key = '', string|array $subkey = ''){

    $session = $_SESSION ?? [];

    if(func_num_args() === 0) return $session;
    if(func_num_args() > 1) {
      if(array_key_exists($key, $session) && is_array($session[$key])){
        if(is_array($subkey)){
          $value = [];
          foreach($subkey as $innerKey){
            $value[] = $session[$key][$subkey] ?? '';
          }
          return $value;
        }
        return $session[$key][$subkey] ?? '';
      }
      return '';
    }

    return $session[$key] ?? '';

  }

  /**
   * Returns the value of the current session as a stdClass object
   *
   * @return stdClass
   */
  public static function fetch() : stdClass {

    return toStdClass($_SESSION ?? []);

  }

  /**
   * Returns the Sessionbase class function
   *
   * @param bool $object defines if the session base value us returned
   * @return Sessionbase
   */
  public static function base(bool $object = false) : Sessionbase|StdClass {

    $Sessionbase = new Sessionbase;

    if($object) {
      return toStdClass($Sessionbase->value());
    }

    return $Sessionbase;

  }

  /**
   * Remove a key from the session or a subkey from a key that exists in session
   *
   * @return boolean true if value is successfully removed
   */
  public static function remove(string|bool $key, string $subkey = '') : bool {

    if($key === true){
      $session  = $_SESSION ?? [];
      foreach($session as $key => $value){
        unset($_SESSION[$key]);
      }
      return true;
    }

    $session = Session::value();

    if(func_num_args() === 1){

      
      if(self::has($key)) {
        unset($session[$key]);
      }

      Session::overwrite($session);
      return !self::has($key);
    }else{
      if(self::has($key, $subkey)){
        unset($session[$key][$subkey]);   
      }
      Session::overwrite($session);
      return !self::has($key, $subkey);
    }

  }

  static function control() {

    if(Session::has(Sessionbase::KEY)){
      $session = Session::base()->value();
  
      if($session){
        if(!CSRF::generated() && Session::base()->has('CSRF')){
          unset($session['CSRF']);
          Session::base()->overwrite($session);
        }  
      }      
    
      if(empty($session)){
        Session::base()->remove(true);
      }        
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