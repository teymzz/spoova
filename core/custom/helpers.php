<?php

/* Custom Helper Functions: Mainly for classes */
// NOTICE : These functions should not be modified

use spoova\core\classes\Collectibles;
use spoova\core\classes\Collection;
use spoova\core\classes\Url;
use spoova\core\classes\DomUrl;
use spoova\core\classes\EInfo;
use spoova\core\classes\FileManager;
use spoova\core\classes\ModelOptimizer;
use spoova\core\classes\SETTER;
use spoova\core\classes\Spoova;
use spoova\core\classes\UserDB;

if(!function_exists('env')){
  /**
   * Reads the last data obtained from Filemanager::loadEnv() method
   * @param $key an access key
   * @param $super defines environment where data should be pulled.
   *  - When $super is not defined or set as false, data returned may be from global scope and if not found, from Filemanager::env_data() 
   *  - When $super is set as true, $key must exist as a global key only or empty value is returned.
   *  - When $super is set as a string, $key must be a subkey of $super or empty value is returned.
   * @return array|string
   */
  function env(string $key, bool|string $super = false) : array|string {

    if((func_num_args() === 1) | ($super === false)){
      $data = FileManager::env_data();
      return $_ENV[$key] ?? $data[$key] ?? '';
    }else{
      if($super === true){
        return $_ENV[$key] ?? '';
      }else{

        if(isset($_ENV[$super])){
          return $_ENV[$super][$key] ?? '';
        }

        return '';
      }
    }
    
    
  }
}

if(!function_exists('scheme')){
  /**
   * Converts Path supplied to app's namespace prefixed or non-prefixed with a backslash
   * @param $classPath path to class
   * @param $prefix true adds a backslash prefix to returned value 
   * @return string
   */
  function scheme(string $classPath, $prefixed = true) : string {
    $appbase = $prefixed? scheme : ltrim(scheme, ' \\');

    $classPath = str_replace('/','\\',$classPath);
    $classPath = ltrim(rtrim($classPath,' \\'),' \\');
    return $appbase.$classPath;
  }
}

if(!function_exists('domlink')){

  function domlink($link, bool $modified = true){

     $link = str_replace(['/','\\','.'], '/', $link);

     return domUrl($link, $modified);

  }

}

if(!function_exists('monitor')){
  /**
   * Short function for setting on live server.
   */
  function monitor() {
    \Res::live();
  }
}


if(!function_exists('SET')){
  /**
   * Load a class from the classes folder
   * @throws error if class does not exist
   *
   * @param string $className
   * @return void
   */
  function SET(string $key, $value, bool|string $lock = false){
    if(SETTER::EXISTS($key)) {
      SETTER::MOD($key, $value, $lock);
    }else{
      SETTER::SET($key, $value, $lock);
    }
  }
}

if(!function_exists('GET')){
  /**
   * Load a class from the classes folder
   * @throws error if class does not exist
   *
   * @param string $className
   * @param string $secureKey secure hash key for hash-locked values
   * @return mixed
   */
  function GET(string $key, $secureKey = ''){
    if(SETTER::EXISTS($key)) return SETTER::GET($key, $secureKey);
    EInfo::view("key \"$key\" does not exist in getter");
    return;
  }
}



if(!function_exists('webClass')){
  /**
   * Load a class from the classes folder
   * @throws error if class does not exist
   *
   * @param string $className
   * @return object|void
   */
  function webClass(string $className){
    $args = func_get_args();
    unset($args[0]);
    $args = array_values($args);
    $class =  scheme('\core\classes\\'.$className);
    if(class_exists($class)){
        return new $class(...$args);
    }
  }
}

if(!function_exists('webTool')){
  /**
   * Load a class from the tools folder
   * @throws error if class does not exist
   *
   * @param string $className
   * @return object|void
   */
  function webTool(string $className, $args){
    $args = func_get_args();
    unset($args[0]);
    $args = array_values($args);
    $class = scheme('\core\tools\\'.$className);
    if(class_exists($class)){
      return new $class(...$args);
    }
  }
}

if(!function_exists('window')){

  /**
   * Returns a division of the current page url.
   * by using the window class and also appends url
   * divisions to supplied argument
   *
   * @param string $type options [window/root|path|base]
   * @return string
   */
  function window($type = 'root'){
    
    return Window::wvm($type);

  }

}

if(!function_exists('route')){
  /**
   * Get a named route
   *
   * @param string $routeName
   * @return string
   */
  function route(string $routeName){
    $routes = Window::loadRoutes();
    if(substr($routeName, 0, 2) === '::'){
      return DomUrl(window('base:'.substr($routeName, 2, strlen($routeName))));
    }
    return ($routes[$routeName])?? '';
  }
}

if(!function_exists('lastCall')){
  /**
   * Return the last called route on a logic
   *
   * @param string $routeName (optional) new route path to be added to last called route
   *  - Note: This will not convert dots to slashes.
   * 
   * @return string
   */
  function lastCall(string $routeName = ''): string {
    return Window::lastCall().$routeName;
  }
}

if(!function_exists('invoked')){

  /**
   * Checks if the current window url matches the supplied url (case sensitive)
   *
   * @param string $url url to be tested
   *  - Note: This will not convert dots to slashes.
   * 
   * @return string
   */
  function invoked(string $url): string {
    if($url === '/'){
      return in_array(window('base'), ['','index']);
    }
    return window('base') === $url;
  }
}

if(!function_exists('windowIncludes')){
  /**
   * Checks if the current window url exists within the list of specified urls
   *
   * @param array|string $url url base paths to be tested
   *  - Note: This will NOT convert dots to slashes.
   *  - Note2: a single forward slash "/" can be used to denote index page
   * 
   * @return string
   */
  function windowIncludes(array|string $url): string {

    $url = (array) $url;

    if(($index = array_search('/', $url)) !== false){
      unset($url[$index]);
      $url = array_merge($url, ['','index']);
    }

    return in_array(window("base"), $url);

  }
}

if(!function_exists('windowExcludes')){

  /**
   * Checks if the current window url does NOT exists within the list of specified urls
   *
   * @param array|string $url url base paths to be tested
   *  - Note: This will NOT convert dots to slashes.
   *  - Note2: a single forward slash "/" can be used to denote index page
   * 
   * @return string
   */
  function windowExcludes(array|string $url): string {

    $url = (array) $url;

    if(($index = array_search('/', $url)) !== false){
      unset($url[$index]);
      $url = array_merge($url, ['','index']);
    }

    return !in_array(window("base"), $url);

  }
}

if(!function_exists('Optimize')){

  /**
   * This is an helper tool for the ModelOptimizer Class
   *
   * @param Collectibles|Collection $data
   * @return ModelOptimizer|Collection
   */
  function Optimize(Collectibles|Collection $data, bool $strict = true): ModelOptimizer|Collection {

    return ModelOptimizer::optimize($data, $strict);

  }
}

if(!function_exists('session')){

  /**
   * Load session account files from the 
   * windows/Sessions folder only.
   *
   * @return void
   */
  function session(string $file_name){

    if(is_file(domroot('windows/Sessions/'.$file_name.".php"))){
      include_once domroot('windows/Sessions/'.$file_name.".php");
    }else{
      trigger_error("\"{$file_name}\" file does not exist within the ".domUrl()."windows/Sessions directory");
    }

  }

}

if(!function_exists('formUrl')){
  /**
   * Add a form url to form action
   *
   * @param string $path
   * @return string
   */
  function FormUrl(string $path){
    if( is_dir($path) && (substr_count($path, '/') === 0) ) {
      $path .= "/";
    }

    return DomUrl($path);
  }
  
}

if(!function_exists('isGuest')){
  /**
   * This function works with User Class to check 
   * if a session id is not active
   * 
   * @return bool
   */
  function isGuest(){
    return !User::id();
  }
}

if(!function_exists('isUser')){
  /**
   * This function works with User Class to check 
   * if a session id is active
   * 
   * @return bool
   */
  function isUser(){
    return User::id()? true : false;
  }
}

if(!function_exists('user')){
  /**
   * This function returns the userDB class.
   * It Handles only queries specific to the current user session id
   * 
   * @param $tableName database user relational table
   *    - default uses the user default table name
   * @return UserDB
   */
  function user($tableName = ''){
    if(!$tableName) $tableName = User::tableName();
    return new UserDB($tableName);
  }
}

if(!function_exists('url')){
  /**
   * Handle urls by using the Url class
   * 
   * @param string $url path to be tested
   * @return \spoova\core\classes\Url
   */  
  function url($url){
    $Url = new Url;
    return $Url->path($url);
  }   
}

if(!function_exists('inPath')){

  function inPath($path) : string { 

    $args = func_get_args();

    if(func_num_args() === 1) {
      $dpath = $args[0];
      $args[0] = ':dom-path';
      $args[1] = $dpath;
    }

    $path = $args[0];   

    if($path === ':dom-path'){
      $path = GET(DomUrl::Name(), DomUrl::Hash());


    }

    $path = rtrim(ltrim(to_frontslash($path, true), '/'), '/');
    $pathSlashes = substr_count($path, '/');
    $paths = $pathSlashes + 1;
    $eqvUrl = url(window('base'))->first($paths);     

    $return = rtrim(ltrim($args[1]?? '', ' '),' ');

    if($path == $eqvUrl) return $return;
    return '';
  }   
 
}

if(!function_exists('isPath')){
 
  function isPath($url) : string {

    $args = func_get_args();

    if(func_num_args() === 1) {
      $dpath = $args[0];
      $args[0] = ':dom-path';
      $args[1] = $dpath;
    }

    $path = $args[0];  
    
    if($path === ':dom-path'){
      $path = GET(DomUrl::Name(), DomUrl::Hash());
    }

    $path = rtrim(ltrim(to_frontslash($path, true), '/'), '/');
    $return = rtrim(ltrim($args[1]?? '', ' '),' ');

    $pathSlashes = substr_count($path, '/');
    $paths = $pathSlashes + 1;

    $eqvUrl = window('base');

    if($path == $eqvUrl) return $return;
    return '';
  }   
}

if(!function_exists('authDirect')){

  /**
   * Redirect to another url on user account
   *
   * @param string $url
   * @return void
   */
  function authDirect(string $url){
    if(isUser()) redirect($url);
  }

}

if(!function_exists('setFlash')){
  /**
   * Handle urls by using the Url class
   * 
   * @param $url
   */  
  function setFlash(){
    $args = func_get_args();
    \Res::setFlash(...$args);
  }   
}

if(!function_exists('guestDirect')){

  /**
   * Redirect to another url on guest account
   *
   * @param string $url
   * @return void
   */
  function guestDirect(string $url){
    if(isGuest()) redirect($url);
  }

}

if(!function_exists('eview')) {
  
  /**
   * Sets error view for windows
   *
   * @return void
   */
  function eview(){
    $arg = func_get_args()[0];
    Window::wvm('error',$arg);
  }
  
}


if(!function_exists('onHide')) {
  
  /**
   * Returns a hidden attribute on html element 
   * only when a function returns an mon-empty result
   *
   * @return string
   */
  function onHide(string $name, $args = null) : string {
    $args = func_get_args();

    if(func_num_args() > 1){
      $name = array_shift($args);
      ksort($args);
      $show = call_user_func_array($name, $args);
      return ($show)? 'hidden' : '';      
    }else{

      return (trim($name))? 'hidden' : '';

    }

  }
  
}

if(!function_exists('onShow')) {

  /**
   * Returns a hidden attribute on html element
   * only when a function returns an empty result
   *
   * @return string
   */
  function onShow(string $name, $args = null) : string {
    $args = func_get_args();

    if(func_num_args() > 1){
      $name = array_shift($args);
      ksort($args);
      $hide = !call_user_func_array($name, $args);
      return ($hide)? 'hidden' : '';      
    }else{
      return (!trim($name))? 'hidden' : '';
    }

  }

}

if(!function_exists('error')) {
  
  /**
   * Returns first encountered error for form inputs
   *
   * @param $error error or input name (or key)
   * @param $subkey subkey of $error
   * @return string
   */
  function error($error, $subkey = '') : string {
    
    $formErrors = Form::errors();

    if(isset($formErrors[$error])) {
      if(func_num_args() > 1){
        if(isset($formErrors[$error][$subkey])){
          if(substr($error, 0, 1) == ':'){
            $error = $formErrors[$error][$subkey] ?? '';
          }else{
            $error = $formErrors[$error][$subkey][0] ?? '';
          }          
        }
      }else{

        if(substr($error, 0, 1) == ':'){
          $error = $formErrors[$error] ?? '';
        }else{
          $error = $formErrors[$error][0] ?? '';
        }
      }
    }else{
      $error = '';
    }
    return $error;
    
  }

}


if(!function_exists('flash')) {
  
  /**
   * Displays flash notice errors
   *
   * @param $error key to fetch error 
   * @param $message custom message if error is displayed
   * @return string
   */
  function flash($key, $message = '') : string {

    return Res::flash(...func_get_args());
    
  }

}

if(!function_exists('ress')) {
  
  /**
   * Returns urls from res folder
   *
   * @return string
   */
  function ress($path){
    return DomUrl('res/'.ltrim($path,'/ '));
  }
  
}

if(!function_exists('redirect')){
  
  /**
   * Spoova redirection function (using declared constants)
   * Redirects a page using php header or javascript window.location
   * Javascript redirection may be needed when an output is already set
   * When no url is set , redirects to current page
   *
   * @param string $url
   * @param string $type java as javascript redirection
   * @return void
   */
  function redirect( string $url = '', string $type = 'header' ){

    if (!$url) $loc = $_SERVER['PHP_SELF'];
    if ($url) {

      $isOffline = defined('online') ? !online : false;

      $url = ($url == "/" && $isOffline)? '' : $url;

      if(!in_array($url, [':uri', ':self', ':this'])){
          
          if(isHTTP($url)){
            $eUrl = $url;
          } else {
            $eUrl = domUrl($url);

            $headers = @get_headers($eUrl);

            //if(strpos($headers[0], '404')){ return false;}
          }

      }

      $type = ($type === 'header')? $type : 'java';


      $self  = $_SERVER['PHP_SELF'];
      $rqUri = $_SERVER['REQUEST_URI'];
      $scUri = $_SERVER["SCRIPT_URI"]?? '';

      $mod = [
        ':self' => $loc = $self?? '', //redirect to self
        ':this' => $loc = $rqUri?? '', //redirect to current uri
        ':uri'  => $loc = $scUri?? $rqUri,
      ];

      $url = $mod[$url]?? $url;

      $loc = $loc?? '';
      $loc = !$loc? (isHTTP($url)? $url : docdir.$url) : $loc; 

      $query = explode( "?", $loc );
      $loc = $query[0]?? '';          
      $linkquery = $query[1]?? '';

      $linkquery = ($linkquery != null)? "?".$linkquery : null;

      $pathExt = pathinfo($loc, PATHINFO_EXTENSION);
      if($pathExt == "php" && fext == ""){
        $loc = str_replace(".php", "", $loc);
      }elseif($pathExt == "" && strtolower(fext) === ".php"){
        $loc .= ".php";
      }

      $loc .= $linkquery;

    }

    if($type === "header"){
      if(!isCli()) header("location: $loc");
    }else{
      if(!isCli()) echo " <script> window.location = '$loc' </script> ";
    }

    exit;    

  }

}

if(!function_exists('redirectTo')){

  /**
   * redirect to another page using header Location
   *
   * @param string $url
   * @return void
   */
  function redirectTo(string $url){
    if(strtolower($url) == ":referer") $url = $_SERVER['HTTP_REFERER'];
    header("location: ".$url);
  }  
  
}

if(!function_exists('response')){
  
  /**
   * This function enables a standard structure 
   * for building ajax responses. The json string returned 
   * (by default) is based on error codes unless the behaviour
   * is modified by a third argument. All 4xx and 5xx responses 
   * by default sets the error index as true and success as false
   * unless a third argument is supplied to overide this behaviour
   *  
   * @param int   $code header code (e.g 404, 301) 
   * @param mixed $message custom response message. 
   * @param bool  $success sets the error or success index key of json text. 
   *              -when set as true returns ['success' => true, 'error' => false]
   *              -when set as false returns ['success' => false, 'error' => true]
   * @return string json response 
   *         
   */  
  function response($code = 0, $message = '', bool $success = false) : string {
    
    // accept only numeric strings
    if(!is_numeric($code)){
      trigger_error('first argument must be of numeric value!');
      return '';
    }

    //convert negative integers to positive
    $code = abs($code);
    
    $headercodes = [1, 2, 3, 4, 5];
    $headercode  = substr($code, 0, 1); //get first number     
    
    $error = true;
    $addheader  = false;
    $response   = [];
    
    //convert header code to integer
    $headercode !== 0 ? floor(log10($code) + 1) : 1;

    if(in_array($headercode, $headercodes))
    {
      //default responses
      $addheader  = true;
      
      if($headercode === '1') {
        $error = false;
      } elseif ($headercode === '2') {
        $error = false;
      } elseif ($headercode === '3') {
        $error = false;
      } elseif ($headercode === '4') {
        $error = true;
      } elseif ($headercode === '5') {
        $error = true;
      }
      
    } elseif ($code === 0) {
        $error = true;
    }
    
    //set valid response header
    if ($addheader) http_response_code($code);
    
    if(func_num_args() < 3) {
        //modify success message with response code
        $success = !$error;
    }
    
    //set array of response
    if(func_num_args() > 1) {
      
      $response = [
        'success' => $success, 
        'error'   => !$success, 
        'message' => $message, 
        'response_code' => $code,
        ];
      
    }
    
    return json_encode($response);
    
  }
}

if(!function_exists('HTERDOC')) {
  
  /**
   * Load urls from res folder
   * 
   * @param string $name name of error code (e.g 404, 503)
   * @return string  $filepath path of error file in rex folder
   */
  function HTERDOC(string $name, string $filepath = ''){
    //Res::off();
    Res::ignore();
    Res::name($name)
		->url('res/main/js/config.js')
		->url('res/main/css/res.css');
    $filepath = trim($filepath)? $filepath : $name;
    Window::wvm(':404', $filepath);
    Window::open();
  }
  
}

if(!function_exists('spoovaLoaded')){

  /**
   * Checks if spoova is configured and all connection is set
   *
   * @param mixed $arg1
   * @param mixed $arg2
   * 
   * @return mixed
   *   - if no argument is supplied, a boolean of true or false is returned 
   *   - if arguments are supplied then first argument is returned if configured, else second argument is returned.
   */
  function spoovaLoaded($arg1 = null, $arg2 = null){
    
    if(func_get_args() > 0){
      return (Spoova::isConfigured())? $arg1 : $arg2;
    }
    return Spoova::isConfigured();

  }

}
