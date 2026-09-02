<?php

/**
 * This file contains custom helper functions in which most are used internally 
 * by spoova classes. These functions should not be modified or removed as removal 
 * may break the application
 */
use spoova\mi\core\classes\Url;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\DomUrl;
use spoova\mi\core\classes\SETTER;
use spoova\mi\core\classes\Spoova;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\DB\DBViewer;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\ModelOptimizer;
use spoova\mi\core\classes\Win;
use spoova\mi\core\functions\Functions;

if(!function_exists('scheme')){
  /**
   * Converts Path supplied to app's namespace prefixed or non-prefixed with a backslash
   *  - Warning: trailing slashes will be removed.
   * @param string $classPath path to class
   * @param bool $prefixed true adds a backslash prefix to returned value 
   * @return string
   */
  function scheme(string $classPath, bool $prefixed = true) : string {
    $appbase = ltrim(scheme, ' \\');

    $classPath = str_replace('/','\\',$classPath);
    $classPath = trim($classPath,' \\');
    return to_dotspace($appbase.$classPath, $prefixed);
  }
}

if(!function_exists('unscheme')){
  /**
   * Removes app's namespace prefix from namespaced path supplied.
   * @param string $classPath path to class
   * @return string
   */
  function unscheme(string $classPath) : string {
    $appbase = scheme;
    $classPath = str_replace('/','\\',$classPath);
    if(substr($classPath, 0, 1) !== '\\'){ $classPath = '\\'.$classPath; }
    if(strtolower(substr($classPath, 0, strlen($appbase))) === strtolower($appbase)){
      $classPath = substr($classPath, strlen($appbase));
    }
    return trim($classPath,' \\');
  }
}

if(!function_exists('suppress_error')){
  /**
   * Suppress errors as alternative for the @ symbol
   *
   * @param int|false $error_levels 
   *  - False uses {@see restore_error_handler()} to restores back the error handler
   *  - Other error levels use {@see set_error_handler()} to suppress error.
   * @param Closure|null $test a callback used to suppress a function
   * @return mixed value depends on what is returned by $test
   */
  function suppress_error(int|false $error_levels = E_ALL, ?Closure $test = null){
    if($test){
      set_error_handler(function () {/* Do nothing */}, $error_levels);
      $response = $test();
      restore_error_handler();
      return $response;
    }
    if($error_levels === false){
      restore_error_handler();
    }else{
      set_error_handler(function () {/* Do nothing */}, $error_levels);
    }
  }
}

if(!function_exists('thisUri')){
  /**
   * Get current url address or use as a prefix
   * 
   * @string $path path on which current url address is prepended.
   */
  function thisURI(string $path = '') : string {
    return domurl(window('base'));
  }
}

if(!function_exists('pathbase')){
  /**
   * Get the base name of the path supplied regardless of frontslash or backslash 
   */
  function pathbase(string $path) : string {
    return basename(to_dirslash($path));
  }
}

if(!function_exists('functions')){
  /**
   * This function is designed for loading custom defined functions
   * 
   * @param string $path - path of the application to be loaded 
   *  - See documentation at [functions](https://spoova.com/docs/helpers/functions/functions)
   * @param Closure $callback if supplied will be applied on any value resolved before the value is returned.
   * 
   * @return array|boolean|string|Functions 
   *   - array returns a list of callable functions from a queried file's path if that file's path exists.
   *   - boolean FALSE is returned when a queried function's path or file's path does not exist.
   *   - string returns the equivalent namespace for a supplied function's path if that function's path exists
   *   - Functions returns the instance of the [Functions](https://spoova.com/docs/helpers/classes/Functions) class.
   */
  function functions(string $path, ?Closure $callback = null) : mixed {
    if(substr($path, 0, 1) === '@'){
      $path = to_dotspace($path);
      $query = false; $trigger = false;
      if(substr($path, -1) === '?'){
        $path = substr($path, 0, strlen($path)-1);
        if(substr($path, -1) === '?'){
          $path = substr($path, 0, strlen($path)-1);
          $trigger = true;
        }
        $query = true;
      }
      $path = explode('::', $path, 2);
      $file = substr($path[0], 1);
      $isFile = is_file(to_dirslash($file.'.php'));

      $callback = $callback ?: function($argument){
        return $argument;
      };

      if($isFile){
        if($query) {

          //test file path: return functions in queried file's path 
          if(!isset($path[1])) return Functions::functions($file, $callback);

          //test function path: check if specified function name exists
          if(in_array($path[1], Functions::functions($file))){
            Functions::load($file);
            $path = Functions::main(to_dirslash($file.'\\'.($path[1]??'')));
            if($trigger) return $path();
            return $path;
          }

          return false; //function's path does not exist
        }

      } else {
        if($query) return false; //function's file does not exist
      }

      // resolve unqueried paths................................................... 
      Functions::load($file);
      $functionNamespace = Functions::main(to_dirslash($file.'\\'.($path[1]??'')));
      
      return $functionNamespace;

    }else if(substr($path, 0, 1) === '\\'){
      $path = substr($path, 1);
      $functionNamespace = Functions::main($path);
      return $functionNamespace;
    } else {
      $autoloadNamespace = Functions::autoloaded($path); //get autoload namespace
      return $autoloadNamespace;
    }
  }
}

if(!function_exists('domlink')){

  function domlink(string $link = '', bool $modified = true){

     if(!isHTTP($link)){
       $link = str_replace(['\\','.'], '/', $link);
     }

     return domUrl($link, $modified);

  }

}

if(!function_exists('monitor')){
  /**
   * Short function for setting on live server.
   */
  function monitor(?string $option = null) {
    if(class_exists('Res')) {
      if(func_num_args() > 1 && $option){
        \Res::live($option);
      } else {
        \Res::live();
      }
    }
  }
}

if(!function_exists('recall')){
  /**
   * Helper function for loading resource pre-named scripts discussed in [recall documentation](https://spoova.com/docs/helpers/functions/core/recall).
   *  - Scripts loading is through resource classes Ress or Res depending on init file 'RESOURCE_HANDLER' configuration
   * 
   * @param $args resource files unique names
   */
  function recall($args) : string {
    $args = func_get_args();
    $resource = '';
    // Ress is the default handler; Res is used only when the init file asks for it
    $key = Init::value('RESOURCE_HANDLER', fn($val) => $val && in_array(strtolower($val),['res', 'ress'])? $val : 'Ress');
    if(strtolower((string) $key) === 'res'){
      $Res = 'Res'; $method = 'recall';
    }else{
      $Res = 'Ress'; $method = 'import';
    }
    foreach($args as $res) {
      $resource .= $Res::$method($res);
    }
    return $resource;
  }
}

if(!function_exists('import')){
  /**
   * Imports resource files based on configuration settings
   *  - Any pre-imported script file by {@see \Ress::import()} will not be returned by this function. This 
   *    behaviour stems from the {@see \Ress::import()} class.
   *  @uses \Ress::import()
   *  @uses \Ress::pull()
   *  @uses \Res::recall()
   *  @uses \Res::pull()
   */
  function import(string $caller) : string|null {

    $key = Init::key('RESOURCE_HANDLER');
    $path = Init::key('RESOURCE_PATH');
    $path .= ($path)? FS : '';

    $isHash  = in_array(substr($caller, 0 , 1), ['#',':']);
    $isColon = strpos($caller, ':') !== false;
    
    if(strtolower((string) $key) === 'res') {
      //Use Old Resource Handler
      if($isHash || $isColon) {

        if($isHash) {
          //format: import('# foo, bar, baz'), import(': foo, bar, baz')
          $caller = substr($caller, 1);
          $names = explode(',',$caller);
          array_trim($names);
        } else {
          //format: import('file: foo, bar, baz')
          $caller = explode(':', $caller, 2);
          $file = trim($caller[0]);
          $names = $caller[1];
          $names = explode(',',$names);
          array_trim($names);
          if($file) \Res::pull($path.$file);
        }

        $res = '';
        foreach($names as $name) {
          $res .= \Res::recall($name);
        }
        return $res;        

      } else {

        \Res::pull($path.$caller);

      }
      
    } else {

      //Use New Resource Handler {Default}
      if($isHash || $isColon) {

        if($isHash) {
          //format: import('# foo, bar, baz'), import(': foo, bar, baz')
          $caller = substr($caller, 1);
          $caller = explode(',',$caller);
          array_trim($caller);
          return ($caller)? \Ress::import($caller) : '';
        } else {

          //format: import('file: foo, bar, baz')
          $caller = explode(':', $caller, 2);
          $file = trim($caller[0]);
          $ress = $caller[1];
          $ress = explode(',', $ress);

          if($file) \Ress::pull($path.$file);

          array_trim($ress);
          return ($ress)? \Ress::import($ress) : '';
        }

      } else {

         \Ress::pull($path.$caller);

         return '';

      }    

    }

    return null;

  }
}

if(!function_exists('SET')){
  /**
   * Set a top level key that can be retrieved with {@see \GET()} function.
   * @param $key the key to be used to set a value
   * @param $value the value stored under the key defined.
   * @param string|float|int|bool|array|object $lock determines security key of the value stored. 
   * @uses SETTER::SET() 
   * @uses SETTER::MOD()
   * @param string $key
   * @return void
   */
  function SET(string $key, $value, string|float|int|bool|array|object $lock = false){
    if(SETTER::EXISTS($key)) {
      SETTER::MOD($key, $value, $lock);
    }else{
      SETTER::SET($key, $value, $lock);
    }
  }
}

if(!function_exists('GET')){
  /**
   * Retrieve a top level key initially defined through the {@see \SET()} function.
   * @uses SETTER::GET()
   * @param string $key
   * @param mixed $secureKey secure hash key for hash-locked values
   * @return mixed
   */
  function GET(string $key, mixed $secureKey = ''){
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

    \Window::wvm('keep', $keepUrl);
    $response = \Window::wvm($type);
    \Window::wvm('keep', false);

    return $response;

  }

}

if(!function_exists('win')){

  /**
   *
   * @param \Window $window
   * @return Win
   */
  function win(\Window $window) : Win{

    return new Win($window);

  }

}

if(!function_exists('trunk')){

  /**
   * Returns a division of the current page url away from the path supplied
   * @param string $prefix a prefix added to the returned division
   */
  function trunk($prefix) : string {

    return Win::subpath(window('base'), $prefix);

  }

}

if(!function_exists('getTrunk')){

  /**
   * Filters out a url trunk(or branch) from a route list supplied. In this case, the url trunk refers to the branch of the last tracked url 
   * corresponding to the branch of the current web url address. 
   *  - Note that only one trunk is expected to be returned at a time. If multiple trunks are colliding, the first trunk will accepted while susbsequent trunks are denied.
   * @ues 
   * @param string $source source url where branch is mounted (or exists)
   * @param array $routes sets list of route url trunks (or branches) to be matched with the source url.
   * @param array $strict if set as TRUE, filters out all specially reserved key constants (e.g Window::ARGS, Window::ONCALL etc.)
   * @param array $multiples if set as TRUE, allows the return of multiple trunk. This should only be used for test purposes.
   * @return array
   */
  function getTrunk(string $source, array $routes, bool $strict = false, bool $multiples = false) : array {

    //get the branch of the currently visited URL from the source
    $trunk = trunk($source);

    //Function to keep or filter out Shutter constant keys
    $keys = [];
    $origin = $routes[\Route::ORIGIN] ?? '';

    $filter = array_filter($routes, function($key) use($trunk, $routes, $strict, $multiples, $origin, &$keys){ 

      if(in_array($key, \Window::SHUTTER_KEYS)){
          return ($strict)? false : true; // determine if shutter's constant keys are kept
      }else{
         //resolve route keys .... 
         $authorized = (\Window::authorizes($trunk, $key, $routes[\Window::STRICT]??false, $origin) !== false);

         if($authorized){
           if($keys) {
             if(!$multiples) return false;
           }else{
             $keys[] = $key; // save one authorized key only
           }
         }
         return $authorized; //keep authorized keys..
      }

    }, ARRAY_FILTER_USE_KEY);

    return $filter;

  }

}

if(!function_exists('iTrunk')){

  /**
   * Filters out a url trunk(or branch) from a route list supplied. In this case, the url trunk refers to the branch of the last tracked url 
   * corresponding to the branch of the current web url address. 
   *  - Note that only one trunk is expected to be returned at a time. If multiple trunks are colliding, the first trunk will accepted while susbsequent trunks are denied.
   * 
   * @param array $routes sets list of route url trunks (or branches) to be matched with the source url.
   * @param bool $strict if set as TRUE, filters out all specially reserved key constants (e.g \Window::ARGS, \Window::ONCALL etc.)
   * @param string $origin sets the route origin for a truncated route.
   * @return array
   * @uses lastCall()
   * @uses getTrunk()
   */
  function iTrunk(array $routes, bool $strict = false, string $origin = '') : array {

    return getTrunk(lastCall(), $routes, $strict);

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
    $routes = \Window::loadRoutes();
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
    $lastCall = \Window::lastCall() ?: window(':');
    if($routeName && ($routeName[0] !== '/')) {
      $routeName = '/'.$routeName;
    }
    return $lastCall.$routeName;
  }
}

if(!function_exists('invoked')){

  /**
   * Checks if the current window url matches the supplied url (case sensitive)
   *  - Warning: it requires the supply of the full route path.
   * 
   * @param string $url url to be tested
   *  - Note: This will not convert dots to slashes.
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
   * @param DBViewer|Collection $data
   * @param boolean $strict determines the strictness lvel of optimized data. 
   * @return ModelOptimizer|Collection
   */
  function Optimize(DBViewer|Collection $data, bool $strict = true): ModelOptimizer|Collection {

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
    return !\User::id();
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
    return ((string) \User::id())? true : false;
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

  /**
   * This is used for testing the current web url against the last tracked url (i.e after Domurl function is called)
   *  - The Domurl function is an in-built function that is designed to automatically track the last called url. 
   *
   * @param string $value sets the returned value when match is valid or set a custom url address that overides the default current web url addressed used.
   *     - when one argument is supplied, this assumes that $value is returned when the current web url parent structure matches the last tracked path.
   *     - when two arguments are supplied, this assumes that $value is the web url address whose parent structure matches last tracked path
   * @param string $value2 if defined, this assumes that $value2 is returned when $value1 (custom url address) parent structure matches the last tracked path
   * @return string
   */ 
  function inPath(string $value, string $value2 = '') : string { 

    $args = func_get_args();
    $case = true; //use case

    if(func_num_args() === 1) {
      $dpath = $args[0];
      $args[0] = ':dom-path';
      $args[1] = $dpath;
    }

    if(substr($args[1], 0, 2) === 'i:'){
      $args[1] = substr($args[1], 2);
      $case = false;
    }else{
      $case = \Window::IsCaseSensitive();
    }

    $path = $args[0];   

    if($path === ':dom-path'){
      $path = \GET(DomUrl::Name(), DomUrl::Hash());
    }
    $path = rtrim(ltrim(to_frontslash($path, true), '/'), '/');
    $pathSlashes = substr_count($path, '/');
    $paths = $pathSlashes + 1;
    $eqvUrl = url(window('base'))->first($paths);     

    $return = $args[1] ?? '';

    if(!$case){
      $match = (strtolower($path) === strtolower($eqvUrl));
    }else {
      $match = ($path === $eqvUrl);
    }
    if($match) return $return;
    return '';
  }   
 
}

if(!function_exists('isPath')){

  /**
   * This is used for testing the current web url against the last tracked url (i.e after Domurl function is called)
   *  - The Domurl function is an in-built function that is designed to automatically track the last called url. 
   *
   * @param string $value sets the returned value when match is valid or set a custom url address that overides the default current web url addressed used.
   *     - when one argument is supplied, this assumes that $value is returned when the current web url address matches the entire structure of the last tracked path.
   *     - when two arguments are supplied, this assumes that $value is the web url address that must match the entire structure of the last tracked path.
   * @param string $value2 if defined, this assumes that $value2 is returned when $value1 (custom url address) matches the entire structure of the last tracked path.
   * @return string
   */  
  function isPath($url) : string {

    $args = func_get_args();
    $case = true; //use case

    if(func_num_args() === 1) {
      $dpath = $args[0];
      $args[0] = ':dom-path';
      $args[1] = $dpath;
    }  

    if(str_starts_with($args[1], 'i:')){
      $args[1] = substr($args[1], 2);
      $case = false;
    }else{
      $case = \Window::IsCaseSensitive();
    }

    $path = $args[0];  
    
    if($path === ':dom-path'){
      $path = \GET(DomUrl::Name(), DomUrl::Hash());
    }

    $path = rtrim(ltrim(to_frontslash($path, true), '/'), '/');
    $return = $args[1] ?? '';

    $eqvUrl = window('base');

    if(!$case){
      $match = (strtolower($path) === strtolower($eqvUrl));
    }else {
      $match = ($path === $eqvUrl);
    }
    if($match) return $return;
    return '';
  }   
}

if(!function_exists('authDirect')){

  /**
   * Redirect to another url on user account
   *
   * @param string $url
   * @param Closure $boot sets a boot function that is called before redirection is made
   * @return void
   */
  function authDirect(string $url, ?Closure $boot = null){
    if(isUser()) {
      if($boot instanceof Closure){
        $boot();
      }
      redirect($url);
    }
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
    \Res::setFlash(...func_get_args());
  }   
}

if(!function_exists('guestDirect')){

  /**
   * Redirect to another url on guest account
   *
   * @param string $url
   * @param Closure $boot sets a boot function that is called before redirection is made
   * @return void
   */
  function guestDirect(string $url, ?Closure $boot = null){
    if(isGuest())  {
      if($boot instanceof Closure){
        $boot();
      }
      redirect($url);
    }
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
    \Window::wvm('error',$arg);
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
  function onHide(string $name, ?string $args = null) : string {
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
  function onShow(string $name, ?string $args = null) : string {
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
    
    $formErrors = \Form::errors();

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
   * @param string $castedName access key name used to store error through \Form::castError
   * @param string $errorKey key may be form input name or within specified options below 
   *   - - "csrf:title" - returns the csrf error title
   *   - - "csrf:info" - returns the csrf error info
   *   - - "flash:[name]" - returns the specified flash key notice
   *   - - "flash:user-error" - returns the user error usually defined when a session is forcefully ended due to invalid session id
   *   
   * @return string
   */
  function formerror(string $castedName, string $errorKey) : string {
    
    return \Form::castedError($castedName, $errorKey);

  }

}

if(!function_exists('flash')) {
  
  /**
   * Displays flash notice error using the specified key. 
   *
   * @param string $key error key for fetching error 
   * @param string $message custom message if error is displayed
   * @return string
   *  - If the supplied error key does not exist, an empty string is returned
   */
  function flash(string $key, $message = '') : string {

    return \Res::flash(...func_get_args());
    
  }

}

if(!function_exists('ress')) {
  
  /**
   * Returns urls from res folder
   *
   * @return string
   */
  function ress(string $path){
    return DomUrl('res/'.ltrim($path,'/ '));
  }
  
}

if(!function_exists('redirect')){
  
  /**
   * Spoova redirection function (using predefined options)
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
      $type = ($type === 'header')? $type : 'java';

      // $eUrl=isHTTP($url)? $url : domUrl($url)

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

      // docdir is assembled with DS, so on Windows $loc arrives here as a
      // backslash path. A URL must use forward slashes either way, and the
      // "java" branch below embeds $loc in a single quoted JS string where a
      // backslash starts an escape sequence ("\testa\install" reads back as
      // "\testainstall"), which silently rewrites the destination.
      $loc = str_replace('\\', '/', $loc);

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
   * This function sets header response codes within the valid range of 1xx to 5xx codes as 
   * strictly defined by the HTTP specification (RFC 9110, RFC 7231. e.t.c) and returns a 
   * JSON response data string based on the type of error code defined. In this case all 4xx and 5xx 
   * are by default considered as error codes while others are termed as success codes in the response data returned
   * 
   *  - Note that the json string returned (by default) is based on error codes unless the behaviour
   * is modified by a third argument. All 4xx and 5xx responses 
   * by default sets the error index as true and success as false
   * unless a third argument is supplied to overide this behaviour
   *  
   * @param int   $code header code (e.g 404, 301) 
   * @param mixed $message custom response message. 
   * @param boolean  $success sets the error or success index key of json text. 
   *              -when set as true returns ['success' => true, 'error' => false]
   *              -when set as false returns ['success' => false, 'error' => true]
   * @params boolean $coded TRUE allows the automatic application of http_response_code().
   * @throws Error if headers have already been sent.
   * @return string json response 
   *         
   */  
  function response($code = 0, $message = '', bool $success = false, bool $coded = true) : string {
    if(isCli()) return '';
    // accept only numeric strings
    if(!is_numeric($code)){
      trigger_error('first argument must be of numeric value!');
      return '';
    }

    $void = ($code < 100 || $code > 599);

    if($code !== 0 && $void){
      trigger_error('Error codes must be of type 1xx or 5xx. Invalid code "'.$code.'" supplied');
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

    if(in_array($headercode, $headercodes) && !$void)
    {
      //default responses
      $addheader  = true;
      
      if($headercode === 1) {
        $error = false;
      } elseif ($headercode === '2') {
        $type = 'success';
        $error = false;
      } elseif ($headercode === '3') {
        $type = 'redirection';
        $error = false;
      } elseif ($headercode === '4') {
        $error = true;
      } elseif ($headercode === '5') {
        $error = true;
      }
      
    } elseif (($code === 0) || ($void)) {
        $error = true;
    }
    
    //set valid response header
    if ($addheader && $coded) http_response_code($code); 

    if(isCli()) return json_encode([]);
    
    if(func_num_args() < 3) {
        //modify success message with response code
        $success = !$error;
    }
    
    //set array of response data
    if(func_num_args() > 1) {
      
      $response = [
        'status'  => $code,
        'success' => $success, 
        'error'   => !$success, 
        'message' => $message, 
      ];

      if(is_array($message)) $message = json_encode($message);
      
    }
    if(headers_sent($file, $line)) {
      throw new Error("This page view cannot be resolved due to early output sent in {$file} on line {$line}");
    }
    header("HTTP/1.1 $code $message");
    
    return json_encode($response);
    
  }
}

if(!function_exists('HTERDOC')) {
  
  /**
   * Load urls from res folder
   * 
   * @param string $name name of error code (e.g 404, 503)
   * @return string $filepath path of error file in rex folder
   */
  function HTERDOC(string $name, string $filepath = ''){
    \Res::name($name)
		->url('js/local/debug/debug.js => x-debug:res-js;type:module')
		->url('res/main/css/local/debug/res.css => x-debug:res-css');
    $filepath = trim($filepath)? $filepath : $name;
    \Window::wvm(':404', $filepath);
    \Window::open();
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
  function spoovaLoaded(mixed $arg1 = null, mixed $arg2 = null){
    
    if(func_get_args() > 0){
      return (Spoova::isConfigured())? $arg1 : $arg2;
    }
    return Spoova::isConfigured();

  }

}
