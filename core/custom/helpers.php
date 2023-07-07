<?php

/* Custom Helper Functions: Mainly for classes */
// NOTICE : These functions should not be modified
use spoova\mi\core\classes\Url;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\DomUrl;
use spoova\mi\core\classes\SETTER;
use spoova\mi\core\classes\Spoova;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\Collectibles;
use spoova\mi\core\classes\ModelOptimizer;

if(!function_exists('scheme')){
  /**
   * Converts Path supplied to app's namespace prefixed or non-prefixed with a backslash
   * @param string $classPath path to class
   * @param bool $prefix true adds a backslash prefix to returned value 
   * @return string
   */
  function scheme(string $classPath, bool $prefixed = true) : string {
    $appbase = $prefixed? scheme : ltrim(scheme, ' \\');

    $classPath = str_replace('/','\\',$classPath);
    $classPath = ltrim(rtrim($classPath,' \\'),' \\');
    return $appbase.$classPath;
  }
}

if(!function_exists('domlink')){

  function domlink(string $link, bool $modified = true){

     $link = str_replace(['\\','.'], '/', $link);

     return domUrl($link, $modified);

  }

}

if(!function_exists('monitor')){
  /**
   * Short function for setting on live server.
   */
  function monitor() {
    Res::live();
  }
}

if(!function_exists('recall')){
  /**
   * Short function for setting on live server.
   */
  function recall($args) : string {
    $args = func_get_args();
    $resource = '';
    foreach($args as $res) {
      $resource .= Res::recall($res);
    }
    return $resource;
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
   * @return object|false
   */
  function webClass(string $className) : object|false {
    $args = func_get_args();
    unset($args[0]);
    $args = array_values($args);
    $class =  scheme('\core\classes\\'.$className);
    if(class_exists($class)){
        return new $class(...$args);
    }
    return false;
  }
}

if(!function_exists('window')){

  /**
   * Returns a division of the current page url.
   * by using the window class and also appends url
   * divisions to supplied argument
   *
   * @param string $type options [window/root|path|base]
   * @param bool $keepUrl true prevents the conversion of dots to slashes
   * @return string
   */
  function window($type = 'root', bool $keepUrl = false){

    Window::wvm('keep', $keepUrl);
    $response = Window::wvm($type);
    Window::wvm('keep', false);

    return $response;

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
    if(substr($url, 0, 1) === '!') {
      $url = strtolower(substr($url, 1, strlen($url)));
      $base = strtolower(window('base'));
      return $url === $base;
    }
    return window('base') === $url;
  }
}

if(!function_exists('windowIncludes')){
  /**
   * Checks if the current window url exists within the list of specified urls
   *
   * @param array|string $url url base paths to be tested
   *  - This will NOT convert dots to slashes.
   *  - A single forward slash "/" can be used to denote index page
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
    return ((string) User::id())? true : false;
  }
}

if(!function_exists('url')){
  /**
   * Handle urls by using the Url class
   * 
   * @param string $url path to be tested
   * @return \spoova\mi\core\classes\Url
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
   * Sets a flash using the Res::flash() class
   * 
   * @param string $key flash key
   * @param string $message flash message
   */  
  function setFlash(string $key, $message){
    Res::setFlash(...func_get_args());
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
   * @param string $name - function name
   * @param string $args - function argument
   *  - Each argument should be declared separately not as an array
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
   * @param string $name - function name
   * @param string $args - function argument
   *  - Each argument should be declared separately not as an array
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
   * Returns the first validation error of specified input fields or specfied from 
   *
   * @param string $error form error access key name (or input field name)
   * @param mixed $subkey subkey of $error or a message 
   *  - If $subkey is a string starting with a colon, $subkey will be the returned string 
   *  - If $subkey is a string that does not start with a colon, $subkey is assumed to be a subkey of $error
   * @return array|string
   */
  function error(string $error, $subkey = '') : array|string {
    
    $formErrors = Form::errors();

    if(isset($formErrors[$error])) {
      if(func_num_args() > 1){
        if(substr($subkey, 0, 1) === ':'){
          if(isset($formErrors[$error])){
            $error = substr($subkey, 1, strlen($subkey));        
          }else{
            $error = '';
          }          
        } else if(isset($formErrors[$error][$subkey])){
          if(substr($error, 0, 1) == ':'){
            $error = $formErrors[$error][$subkey] ?? '';
          }else{
            $error = $formErrors[$error][$subkey][0] ?? '';
          }          
        }else{
          $error = '';
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

if(!function_exists('formerror')) {
  
  /**
   * Returns form casted errors which are defined through the Form::castError() method 
   *
   * @param string $castedName access key name used to store error through Form::castError
   * @param string $errorKey key may be form input name or within specified options below 
   *   - - "csrf:title" - returns the csrf error title
   *   - - "csrf:info" - returns the csrf error info
   *   - - "flash:[name]" - returns the specified flash key notice
   *   - - "flash:user-error" - returns the user error usually defined when a session is forcefully ended due to invalid session id
   *   
   * @return string
   */
  function formerror(string $castedName, string $errorKey) : array|string {
    
    return Form::castedError($castedName, $errorKey);

  }

}

if(!function_exists('flash')) {
  
  /**
   * Displays flash notice error using the specified key. 
   *
   * @param string $error key to fetch error 
   * @param string $message custom message if error is displayed
   * @return string
   *  - If the supplied error key does not exist, an empty string is returned
   */
  function flash(string $key, $message = '') : string {

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
