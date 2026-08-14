<?php

use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\constants\CASTED;
use spoova\mi\core\classes\Container\Container;
use spoova\mi\core\classes\ContainerFunction;
use spoova\mi\core\classes\Controller;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Enums\shutter;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\Notice;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\Res\Rex;
use spoova\mi\core\classes\RouteInspector;
use spoova\mi\core\classes\Sensor\Sensor;
use spoova\mi\core\classes\SETTER;
use spoova\mi\core\classes\TClass;
use spoova\mi\core\classes\UrlSlugs;
use spoova\mi\core\classes\WindowBase;

/**
 * Controls view from windows frame
 * 
 * :Reserved Methods:
 * 
 * __contruct, onOpen, loadBase,
 * open, close, call, sleep, eview, secure.
 */
class Window extends WindowBase{

  #define private variables only
  private static string $lastCall = '';
  private static bool $isPended = false;
  private static bool $transmute = false;
  private static bool $isCaseSensitive = false;
  private static string $pender = '';
  private static array $reserves;
  private static array $metrics = [];
  private static string $lastWindow = '';
  private static object|false $lastWindowInstance = false;
  private static array $windowInstances = [];
  private static bool $INIT_TRUNK = false;
  private static ?string $origin = null;
  private static ?Window $Window = null;

  /**
   * protect the root Window's instance
   */
  protected function __construct() {}

  /**
   * Defines a list of operations that must occur before a route is 
   * intialized
   *
   * @return void
   */
  public static function super() {}

  /**
   * Defines a list of operations that must occur in sequence from the parent classes 
   * down to the child window (route) before it is initialized.
   *
   * @return void
   */
  public static function frame() {} 


  /**
   * Loads a route from the Windows/Routes folder
   *
   * @param string $path
   * @return bool true if route file exists
   */
  final static function callRoute(string $path) : bool {

      $class = scheme(WIN_ROUTES.$path, false);

      if(!defined('thisUri') && function_exists('thisUri')) define('thisUri', thisUri());

      if(routeExists(strtolower($path))){ 
        $class = (TClass::class($class)->getString());
        $parents = class_parents($class);
        $parents = (array_reverse(array_unset($parents, [WindowBase::class, Window::class, Controller::class], true)));
        $parents[$class] = $class;
        
        foreach($parents as $parent){
          $rfc = new TClass($parent);
          if($rfc->hasDirectStaticMethod('frame')){
            Container::callMethod($parent, 'frame');
          }
        } 
        // Apply this on the main route controller class only...
        if(TClass::class($class)->hasDirectStaticMethod('__onEntry')){
          Container::callMethod($class, '__onEntry');
        }
        if(TClass::class($class)->hasStaticMethod('__onEvery')){
          Container::callMethod($class, '__onEvery');
        }

        // changed from hasDirectMethod('__nOnce') to match parent controller static method
        // if hasDirectMethod is required to support instance $this, consider updating documentation @site:docs/wvm/routes/magic_methods/nonce
        if(TClass::class($class)->hasDirectStaticMethod('__nonce')){
          if(!SETTER::EXISTS('__nonce')){
            Container::callMethod($class, '__nonce');
            SET('__nonce', true, true);
          }
        }

        User::auth()->id()->main();

        Container::instance()->with('dependencies')->dispatch($class); // dependencies rates higher than super
        Container::instance()->callMethod($class, 'super'); // using container to handle super
        // $Container = new Container($class);
        return true;     

      }

      return false;

  }

  /**
   * Return the last window controller class triggered
   *
   * @return Window|string - This will always return a string but provides a smart IDE method detection
   */
  public static function getLast() {
    return self::$lastWindow;
  }


  /**
   * set onCall presets on urls.
   *
   * @param string|array $callType - optional string argument or array keys [main|base|root|path] 
   *  - If argument(1) supplied is an array, default callType "call" is assumed while array is assumed as urls.
   * 
   * @param array $urls 
   *  - urls should only take closures as arguments
   *
   * @note This removes any previous onCall presents on url
   * @return void
   */
  public static function ONCALL($callType = 'cast', array $urls = []){
    
    if(is_array($callType)){
      if(func_num_args() > 1) {
        return EInfo::view('If arg(#1) supplied for "onCall()" is array, only a single argument must be supplied.');
      }
      $urls = $callType; 
      $callType = CASTED::CALL;
    }
    $callTypes = (array) $callType;

    foreach($callTypes as $type){
      if($type == ':404') $type = CASTED::E404;
      if(array_key_exists($type, self::$wvm['onCall'])){
        self::$wvm['onCall'][$type] = $urls;
      }
    }

  }

  /**
   * Allows single callbacks on different urls.
   *
   * @param array $urls - array of url values
   * @param Closure $callback applied as presets on each defined url
   *
   * @notice Callback will run if the current url exists in list of urls even if the page is a 404
   * @return void
   */
  public static function preset(array $urls, Closure $callback){

    if(in_array(window("base"), $urls)) {
      Container::instance()->callFunction($callback);
    }

  }

  /**
   * Allows single callbacks on different urls only when url is resolved
   *
   * @param array $urls - array of url values
   * 
   * @param Closure $callback applied as presets on each defined url
   *
   * @notice This will overide any previous presets and only runs when the url is resolved before the url is loaded
   * @return void
   */
  final public static function preload(array $urls, Closure $callback){

    if(in_array(window("base"), $urls)){
      self::$wvm['preload'][window("base")] = $callback;
    }elseif(in_array(strtolower(window("base")), $urls)) {
      self::$wvm['preload'][strtolower(window("base"))] = $callback;
    }

  }
  
  /**
   * Returns the list of reserved methods
   *
   * @param string $method
   * @return boolean
   */
  static private function inReservedMethods(string $method) : bool {
 
    if(!isset(self::$reserves)){

      $parentClass = get_parent_class(static::class);

      if($parentClass){
        $reserves = new ReflectionClass($parentClass);
        $methods = $reserves->getMethods();

        self::$reserves = array_map(function($value){
          $name = strtolower($value->name);
          if(!in_array($name, ['__construct', '__tostring', '__destruct'])){
            return $name;
          }
          return '';
        },$methods);

        self::$reserves = array_delete(self::$reserves, '');

      }else{
        self::$reserves = [];
      }
    }  

    return in_array($method, self::$reserves);
    
  }

  /**
   * Resolves all shutter methods
   *
   * @param array $caller
   * @param boolean $success
   * @return boolean
   */
  final protected static function resolveShutterCalls(array $caller, bool $success) : bool {

    $instance    = $caller['instance']; //window instance

    if($success) {

      //required variables
      $callName    = $caller['name'];     // root, call, path, base
      $callType    = $caller['type'];     // method, class, object
      $handler     = $caller['handler'];  // method, class or object reference
      $arguments   = $caller['arguments']; // shutter shutdown function
      $close       = $caller['close'];    // close application
      $path        = $caller['lastcall']; // last route called ($base, $path, $root)
      $ONCALL      = $caller['ONCALL'][0]??'';   // shutter boot function
      $SHUTDOWN    = $caller['SHUTDOWN']; // shutter shutdown function
      
      $response = [200,'status ok'];

      if(http_response_code() !== $response[0]){
        response(...$response); // throws error if content is printed earlier 
      }else{
        if(ob_get_length() < 0) response(...$response);
      }

      if($callType === 'method') {
        self::$lastCall = $path;
        static::$isPended = !$close;
        static::$pender = static::$isPended? $callName : '';

        Container::instance()->callFunction($ONCALL); // resolve ONCALL key

        self::validate_response_headers($close, $SHUTDOWN);

        $Container = Container::instance();
        
        if(self::inReservedMethods($handler)){
          
          // fetch all polyfill methods
          $polyfills = $Container->callMethod($instance, 'polyfill', [$handler]);

          if(!array_key_exists($handler, $polyfills)){
            self::close(false, ":reserved"); //closes with reserved space template if not online.
            return false;
          }
        
          if(!($polyfills[$handler] instanceof Closure)){
            EInfo::trigger('Route method "'.$handler.'" called has an invalid polyfill that should be a Closure object.');
            return false;
          }
        
          self::$metrics[] = 'polyfill.'.$handler.'()';
          self::integrate_windows_api();
          Container::instance()->callFunction($polyfills[$handler], $arguments);
        
        } else {
          
          self::$metrics[] = $handler.'()';

          self::integrate_windows_api();
          $Container->callMethod($instance, $handler, $arguments);
        
        }
        
        return $instance->resolved(true);

      } else {
        //resolve for array or object (i.e string of class objects instantiated, closure)...
        
        $resolved = $instance->resolved(true);
        self::$lastCall = $path;
        static::$isPended = false;
        static::$pender = static::$isPended? $callName : '';
        self::integrate_windows_api();
        Container::instance()->callFunction($ONCALL, $arguments);
        self::validate_response_headers($close, $SHUTDOWN);
    
        if($handler instanceof Closure){
          self::$metrics[] = 'closure()';
          Container::instance()->callFunction($handler, $arguments);
        } else{
          
          $Container = Container::instance();
          if($callType === 'object') {
            //'Note: Remove object support for window shutter controllers to avoid eager class loading'
            $handler = get_class($handler); // handler is expected to be a string 
          }
          
          self::$metrics[] = $handler;
          $class = TClass::class($handler);
          
          // Executed before other magicals
          if($class->hasDirectStaticMethod('__nonce')){
            if(!SETTER::EXISTS('__nonce')){
              $Container->callMethod($handler, '__nonce', $arguments);
              SET('__nonce', true, true);
            }
          }
          
          if($class->hasDirectStaticMethod('__onEntry')){
            $Container->callMethod($handler, '__onEntry', $arguments);
          }
          if($class->hasStaticMethod('__onEvery')){
            $Container->callMethod($handler, '__onEvery', $arguments);
          }

              
          // note exiting in class stops code
          Container::instance()
              ->with('dependencies')  
              // Allow registering dependencies with subroutes using the 'dependencies()' method note that exiting in class will stop code
              ->register($handler, fn() => $arguments)
              ->make($handler, $arguments);
    
          if($class->hasDirectStaticMethod('__onExit')){
            $Container->callMethod($handler, '__onExit', $arguments);
          }
        }
        return $resolved;

      }

    }

    return $instance->resolved(false);

  }
    
  /**
   * Resolves a parent url root name
   *
   * @param Window $instance
   * @param array $windows
   * @param bool|array $close
   *    (array) => as variables
   *    (bool) =>  close window 
   * 
   * @param bool $close closes window
   *   - shutter::open or 0 or false pends shutter
   *   - shutter::close or 1 or true closes shutter
   *   - shutter::sleep or 2 sleeps shutter (live mode)
   * 
   * @return void
   */
  final protected static function rootcall(Window $instance, array $windows = [], bool|shutter $close = true){               
    
    if($instance->resolved()) return;

    $root = static::wvm('@root'); //root path
    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);

    $extras = ['instance' => $instance, 'shutter' => __FUNCTION__];

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $SHUTDOWN, $arguments, $USE_CASE, $SLUGS, extras: $extras);

    static::integrateAPI();

    $onCall = self::wvm('onCall'); 
    
    //anonymous on shutter boot function
    $boot = function($root, $cast) use($onCall) {
      if(array_key_exists($root, $onCall[$cast])){
        if($onCall[$cast][$root] instanceof Closure){
          self::$wvm['onCallResponse'][$cast][$root] = $onCall[$cast][$root]();
        }
      }
    }; 

    if($root == '') $root = 'index';

    $caller['instance'] = $instance; //window instance
    $caller['name'] = 'root';     //root, call, path, base
    $caller['arguments'] = $arguments; //shutter shutdown function
    $caller['ONCALL'] = $ONCALL;   //shutter boot function
    $caller['SHUTDOWN'] = $SHUTDOWN; //shutter shutdown function
    $caller['close'] = $close;    //close application
    $caller['lastcall'] = $root; //last route called ($base, $path, $root)

    /* window as window's url */
    foreach($windows as $window => $method) {

      if(is_string($method)) $method = str_replace('-','_', $method);
      
      if(!$window) { $window = static::wvm('@'); }

      if(substr($window, 0, 1) == '!'){
        $strict = true; //inverse strict
        $window = substr($window, 1, strlen($window)); //update window
      }else{
        $strict = false; //inverse strict
      }

      //apply case sensitivity 
      if($USE_CASE) $strict = !$strict;

      if($strict){
        $rootPath = $root;
        $winPath = $window; //new window
        static::$isCaseSensitive = true;
      }else{
        $rootPath = strtolower($root);
        $winPath = strtolower($window);
        static::$isCaseSensitive = false;
      }

      $rootPath = preg_replace('/\?.*/','', $rootPath);
      
      if($rootPath === $winPath) {

        if(is_string($method)){

          if(method_exists($class, $method)) {

            self::resolve_preloaded_middlewares();
  
            $boot($root, CASTED::ROOT); //rootcall success shutter boot function
  
            $caller['type'] = 'method';   
            $caller['handler'] = $method;   
  
          }elseif(substr($method, 0, 4) === 'win:') {
  
            $class = substr($method, 4, strlen($method));
            $win   = scheme.WIN.$class;
      
            if(windowExists($class)){
              $caller['type'] = 'class';   
              $caller['handler'] = $win;   
              if(($ONCALL[1]??'') === false){
                $caller['ONCALL'] = [];
              }
            }
  
          }

        }elseif(is_object($method)){

          if(is_closure($method)){
            self::resolve_preloaded_middlewares();
          }
          $caller['type'] = 'object';   
          $caller['handler'] = $method; 

        }
        
        if(isset($caller['type'])) return self::resolveShutterCalls($caller, true);

      }

    } 

    if(array_key_exists(':404', $windows)){

      $method = $windows[':404'];
      $caller['type'] = 'method';   
      $caller['handler'] = $method;

      if(is_string($method) && method_exists($class, $method)){
        $boot($root, CASTED::E404); // rootcall shutdown boot function
        $resolved = self::resolveShutterCalls($caller, true);
      }
      return $resolved ?? false;
    }

    self::shutdown($close, $SHUTDOWN);

  }  

  
  /**
   * Resolves a direct path that comes after a url's entry point (or window)
   *
   * @param Window $instance 
   * @param array $windows list of acceptable urls
   * @param bool $close 
   *   - shutter::open or 0 or false pends shutter
   *   - shutter::close or 1 or true closes shutter
   *   - shutter::sleep or 2 sleeps shutter (live mode)
   * 
   * @return void|bool
   */
  final protected static function pathcall(Window $instance, array $windows = [], bool|shutter $close = true){

    if(RouteInspector::capturing()){ RouteInspector::capture(get_class($instance), __FUNCTION__, $windows); return; }

    if($instance->resolved()) return;

    $path = static::wvm('path'); //root path

    $onCall = self::wvm('onCall'); 

    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);

    $extras = ['instance' => $instance, 'shutter' => __FUNCTION__];

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $SHUTDOWN, $arguments, $USE_CASE, $SLUGS, extras: $extras);
    
    static::integrateAPI();

    $boot = function($path, $cast) use($onCall) {
      if(array_key_exists($path, $onCall[$cast])){
        if($onCall[$cast][$path] instanceof Closure){
          $booted = Container::instance()->callFunction($onCall[$cast][$path]);
          self::$wvm['onCallResponse'][CASTED::PATH][$path] = $booted;
        }
      }
    };

    $caller['instance'] = $instance; //window instance
    $caller['name'] = 'path';     //root, call, path, base
    $caller['arguments'] = $arguments; //shutter shutdown function
    $caller['ONCALL'] = $ONCALL;   //shutter boot function
    $caller['SHUTDOWN'] = $SHUTDOWN; //shutter shutdown function
    $caller['close'] = $close;    //close application
    $caller['lastcall'] = $path; //last route called ($base, $path, $root
    
    /* window as window's url */
    foreach($windows as $window => $method) {

      if(is_string($method)) $method = str_replace('-','_', $method);

      if(substr($window, 0, 1) == '!'){
        $strict = true; //inverse strict
        $window = substr($window, 1, strlen($window)); //update window
      }else{
        $strict = false; //inverse strict
      }

      // apply case sensitivity 
      if($USE_CASE) $strict = !$strict;

      if($strict){
        $pathPath = $path;
        $pathWin = $window; //new window
        static::$isCaseSensitive = true;
      }else{
        $pathPath = strtolower($path);
        $pathWin = strtolower($window);
        static::$isCaseSensitive = false;
      }

      $pathPath = preg_replace('/\?.*/','', $pathPath);
      $matched = false;
      
      if(preg_match('/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',$window)) {
        $i = ($i ?? -1) + 1;
        if($matches = self::gets_url_slug($path, $pathPath, $pathWin, $window)){
        
          if($path === $matches[0] && (isset($matches[1]))) { 
              
              unset($matches[0]);
              $callex = (array_unique($matches));
              $callex = array_map(fn($val)=> explode('?',$val)[0], $callex);
              $caller['arguments'] = array_merge(array_values($callex), $caller['arguments']);
  
              if($SLUGS && ($SLUGS()[$i] ?? '')){
  
                // resolve this if SLUGS constant key is applied.
              
                UrlSlugs::save(array_values($callex));
                $matched = $SLUGS()[$i];
                if($matched instanceof Closure){
                  $matched = Container::instance()->callFunction($matched, $caller['arguments']);
                }else if(is_array($matched) && count($matched) === 2){
                  $vclass = $matched[0];
    
                  $wclass = substr($vclass, strlen(scheme(WIN))-1);
    
                  if(windowExists($wclass)) {
                    if(method_exists($vclass, $matched[1])){
                      if(array_key_exists($vclass, self::$windowInstances)){
                        $matched[0] = self::$windowInstances[$vclass];
                      }
                      $matched = Container::instance()->callMethod($matched[0], $matched[1], $caller['arguments']);
                    }else{
                      return EInfo::trigger('invalid url validator method "'.$matched[1].'()" supplied');
                    }
                  }else{
                    return EInfo::view('invalid url validator supplied');
                  }
                }
                if($matched instanceof UrlSlugs){
                  $matched = $matched::response();
                }
              }else{
                $matched = true;
              }
            }
        }
      }

      if(($pathPath == $pathWin) || $matched){

        if(is_string($method)){

          if(method_exists($class, $method)){ 

            self::resolve_preloaded_middlewares();
            
            $boot($path, CASTED::PATH); //shutter boot function
            
            $caller['type'] = 'method';   
            $caller['handler'] = $method;  

          }elseif(substr($method, 0, 4) == 'win:') {

            $class = substr($method, 4, strlen($method));
            $win   = scheme.WIN.$class;
      
            if(windowExists($class)){ 
              $caller['type'] = 'class';   
              $caller['handler'] = $win;  
              
              if(($ONCALL[1]??'') === false){
                $caller['ONCALL'] = [];
              } 
            }

          }    

        }elseif(is_object($method)){

          if(is_closure($method)){
            self::resolve_preloaded_middlewares();
          }

          $caller['type'] = 'object';   
          $caller['handler'] = $method;  

        }

        if(isset($caller['type'])) {
          return self::resolveShutterCalls($caller, true);
        }

      }

    } 

    if(array_key_exists(':404', $windows)){

      $method = $windows[':404'];
      $caller['type'] = 'method';   
      $caller['handler'] = $method;  

      if(is_string($method) && method_exists($class, $method)){

        $boot($path, CASTED::E404); //boot shutter for shutdown
        
        $resolved = self::resolveShutterCalls($caller, true);

      }
      return $resolved ?? false;
    }

    if($instance->resolved()) return true;

    self::shutdown($close, $SHUTDOWN);

  } 

  final protected static function origin(?string $origin = null): Window|string {
    if(!self::$Window) self::$Window = new self();
    
    if(func_num_args() > 0) self::$origin = rtrim($origin, '/').'/';

    return (func_num_args() === 0) ? self::$origin ?? '' : self::$Window;
  } 
  
  /**
   * Include different acceptable routes on windows path url
   * The current page url (window + path) should match one of the lists
   * of supplied permitted urls else a 404 error page is activated.
   *
   * @param Window $instance window instance
   * @param array $windows accepted routes and route conditions
   * @param bool $close 
   *   - shutter::open or 0 or false pends shutter
   *   - shutter::close or 1 or true closes shutter
   *   - shutter::sleep or 2 sleeps shutter (live mode)
   * @notice all preloads have the highest order of execution
   * 
   * @return void|bool
   */
  final protected static function call(Window $instance, array $windows = [], bool|shutter $close = true){

    if(RouteInspector::capturing()){ RouteInspector::capture(get_class($instance), __FUNCTION__, $windows); return; }

    if($instance->resolved()) return;
    $base = static::wvm('@base'); //full path 
          
    $onCall = self::wvm('onCall');

    $origin = rtrim($windows[self::ORIGIN] ?? '', '/');

    $oinverse = '';

    if(substr($origin, 0, 1) === '!'){
      $oinverse = '!';
      $origin = substr($origin, 1);
    }

    $superStrict = $windows[Window::STRICT]??false; 
    if($oinverse){
      $ostrict = ($superStrict)? !$superStrict : true; 
    }else{
      $ostrict = $superStrict;
    }

    // define a filter function to determine if supplied window is considered valid
    $filter_windows = function($windows, &$authorization = []) use($base, $origin, $ostrict){
      return array_filter($windows, function($key) use($base, $origin, $ostrict, &$authorization){ 
            $isShutterKey = in_array($key, Window::SHUTTER_KEYS);
            $useOrigin = !$isShutterKey ? (static::$origin ?? $origin) : '';
            $authorized = (self::authorizes($base, $key, $ostrict, $useOrigin, $authorizer) !== false) || $isShutterKey;
            $authorization[$key] = $authorizer;
            return $authorized;
          }, ARRAY_FILTER_USE_KEY);
    };

    // Get global trunk ...
    $windows = self::identify_truncation_for($windows, $filter_windows, $authorization);       

    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);

    $extras = ['instance' => $instance, 'shutter' => __FUNCTION__];

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $SHUTDOWN, $arguments, $USE_CASE, $SLUGS, extras: $extras);

    static::integrateAPI();

    $boot = function ($base, $cast) use($onCall) {
      if(array_key_exists($base, $onCall[$cast])){ 
        $booted = Container::instance()->callFunction($onCall[$cast][$base]);
        self::$wvm['onCallResponse'][CASTED::CALL][$cast] = $booted;
      }
    };

    $caller['instance'] = $instance; //window instance
    $caller['name'] = 'call';     //root, call, path, base
    $caller['arguments'] = $arguments; //shutter shutdown function
    $caller['ONCALL'] = $ONCALL;   //shutter boot function
    $caller['SHUTDOWN'] = $SHUTDOWN; //shutter shutdown function
    $caller['close'] = $close;    //close application
    $caller['lastcall'] = $base; //last route called ($base, $path, $root

    /* window as window's url */
    foreach($windows as $window => $method) {

      if(is_string($method)) $method = str_replace('-','_', $method);
      
      //set windows when origin is not defined
      $windowkey = $window;
      if(!$window && !$origin) { $window = static::wvm('@');  }
      if(!$window && !$origin) $window = $base;
      
      $prefix = substr($window, 0, 5); 
      $modifier = 'base?';

      //handle modifier call (base?) with the basec method
      if($prefix === $modifier){
        $winmethod = rtrim(substr($window, 0, 4), 'e').'ec';
        if(method_exists(Window::class, $winmethod)){
          $caller['name'] = $winmethod;     //pathex, basex, rootex
          $caller['onCall'] = $onCall;     //pathex, basex, rootex
          $caller['windows'] = $windows;     //pathex, basex, rootex
          $caller['base'] = $base;     //pathex, basex, rootex
          $caller['USE_CASE'] = $USE_CASE;     //pathex, basex, rootex
          $resolved = self::basec($instance, [$window, $method, $origin], 'basc', $caller); //handles inline path resolving
          if($resolved) return ($resolved);
        }
        continue;
      }
      
      // remove inverse signal and keep supplied path clean
      $wstrict = substr($window, 0, 1) === '!';
      $strict = ($wstrict && $ostrict) || (!$wstrict && !$ostrict)? false : true;
      if($wstrict) $window = substr($window, 1);

      // prepend origin to window path since origin does not use inverse operator
      $window = $origin && $window ? $origin.'/'.$window : $origin.$window;


      if($strict){
        $basePath = $base;
        $baseWin = $window; //new window
        static::$isCaseSensitive = true;
      }else{
        $basePath = strtolower($base);
        $baseWin = strtolower($window);
        static::$isCaseSensitive = false;
      } 

      $basePath = preg_replace('/\?.*/','', $basePath);
      $matched = false;

      if(preg_match('/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',$window)) {
        $i = ($i ?? -1) + 1; //determines the called index of slug function


        if($matches = self::gets_url_slug($base, $basePath, $baseWin, $window)){

          if($base === $matches[0]) {
            unset($matches[0]);
            $callex = (array_unique($matches));
            $callex = array_map(fn($val)=> explode('?',$val)[0], $callex);
            $caller['arguments'] = array_merge(array_values($callex), $caller['arguments']);

            if($SLUGS && ($SLUGS()[$i] ?? '')){
              UrlSlugs::save(array_values($callex));
              $matched = $SLUGS()[$i];
              if($matched instanceof Closure){
                $matched = Container::instance()->callFunction($matched, $caller['arguments']);
              }else if(is_array($matched) && count($matched) === 2){
                $vclass = $matched[0];
                $wclass = substr($vclass, strlen(scheme(WIN))-1); // remove app root namespace from matched class for checking if class exists.
    
                if(windowExists($wclass)) { 
                  if(method_exists($vclass, $matched[1])){
                    $Container = Container::instance();
                    if(array_key_exists($vclass, self::$windowInstances)){
                      $matched[0] = self::$windowInstances[$vclass];
                    }
                    $matched = $Container->callMethod($matched[0], $matched[1], $caller['arguments']);
                  }else{
                    return EInfo::trigger('invalid url validator method "'.$matched[1].'()" supplied');
                  }
                }else{
                  return EInfo::view('invalid url validator supplied');
                }
              }
              if($matched instanceof UrlSlugs){
                $matched = $matched::response();
              }
            }else{
              $matched = true;
            }
          }
  
        }
      }
      if(($basePath === $baseWin) || $matched){

        if(is_string($method)){
          if(method_exists($class, $method)){

            self::resolve_preloaded_middlewares();
            
            $boot($base, CASTED::CALL);
            $caller['type'] = 'method';   
            $caller['handler'] = $method;  

          }elseif(substr($method, 0, 4) === 'win:') {

            $class = substr($method, 4, strlen($method));
            $win   = scheme.WIN.$class;
            
            if(windowExists($class)){ 

              $caller['type'] = 'class';   
              $caller['handler'] = $win; 
              if(($ONCALL[1]??'') === false){
                $caller['ONCALL'] = [];
              } 

            }

          }          
        }elseif(is_object($method)) {

          if(is_closure($method)){
            self::resolve_preloaded_middlewares();
          }

          $caller['type'] = 'object';   
          $caller['handler'] = $method;   

        }

        if(isset($caller['type'])) return self::resolveShutterCalls($caller, true);

      }

    } 

    if(array_key_exists(':404', $windows)){

      $method = $windows[':404'];

      $caller['type'] = 'method';   
      $caller['handler'] = $method;  

      if(is_string($method) && method_exists($class, $method)){

        $boot($base, CASTED::E404); //boot shutter for shutdown
        
        $resolved = self::resolveShutterCalls($caller, true);

      }
      return $resolved ?? false;

    }

    self::shutdown($close, $SHUTDOWN);

  }

  /**
   * Resolves a parent base url
   * The current page url must have a parent path that exist
   * within the list of permitted parent urls
   *
   * @param Window $instance 
   * @param array $windows acceptable route urls
   * @param bool|shutter $close 
   *   - shutter::open or 0 or false pends shutter
   *   - shutter::close or 1 or true closes shutter
   *   - shutter::sleep or 2 sleeps shutter (live mode)
   * 
   * @return void|bool
   */
  final protected static function basecall(Window $instance, array $windows = [], bool|shutter $close = true){

    if($instance->resolved()) return;

    $base = static::wvm('@base');

    $onCall = self::wvm('onCall');
    
    $index = static::wvm('@');

    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);

    $extras = ['instance' => $instance, 'shutter' => __FUNCTION__];

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $SHUTDOWN, $arguments, $USE_CASE, $SLUGS, extras: $extras);

    static::integrateAPI();

    // anonymous on shutter call function
    $boot = function($base, $cast) use($onCall) {

        if(array_key_exists($base, $onCall[$cast])){
          if($onCall[$cast][$base] instanceof Closure){
            self::$wvm['onCallResponse'][CASTED::BASE][$base] = $onCall[$cast][$base]();
          }
        }
    };

    // predefine anonymous filter function
    $filter = function(&$window, &$basex, &$strict) use($base, $USE_CASE) {

      $win    = trim($window, '/ ');
      $winexp = explode('/', $win);
      $winexc = count($winexp); // number of paths for supplied window

      $uripaths = explode('/', trim($base, '/ ')); // number of paths for window base

      //fetch the length of supplied path in current url address
      $basex = implode('/', array_slice($uripaths, 0, $winexc));
      $basex = preg_replace('/\?.*/','', $basex);

      if(substr($window, 0, 1) === '!'){
        $strict = true; //inverse strict
        $window = substr($window, 1, strlen($window)); //update window
      }else{
        $strict = false; //inverse strict
      }

      //apply case sensitivity 
      if($USE_CASE) $strict = !$strict;

    };

    $caller['instance'] = $instance; //window instance
    $caller['name'] = 'basecall';     //root, call, path, base
    $caller['arguments'] = $arguments; //shutter shutdown function
    $caller['ONCALL'] = $ONCALL;   //shutter boot function
    $caller['SHUTDOWN'] = $SHUTDOWN; //shutter shutdown function
    $caller['close'] = $close;    //enable the closing (i.e exit) of application
    $caller['lastcall'] = $base; //last route called ($base, $path, $root

    //process and validate windows
    foreach($windows as $window => $method){

      $window = $window ?: $index; //redefine window for empty window supplied

      $isMethod = !($isClass = (is_string($method) && (substr($method, 0, 4) === 'win:')));

      $basex = $strict = ''; //define default filter variables

      $filter($window, $basex, $strict); //filter window path and obtain required variables

      if($strict){
        $nBasex = $basex;
        $nWin = $window;
        static::$isCaseSensitive = true;
      }else{
        $nBasex = strtolower($basex);
        $nWin = strtolower($window);
        static::$isCaseSensitive = false;
      }
      
      $caller['lastcall'] = $basex; //update last route 

      $nBasex = preg_replace('/\?.*/','', $nBasex);
      $matched = false;
      
      if(preg_match('/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',$window)) {
        $i = ($i ?? -1) + 1;
        if($matches = self::gets_url_slug($basex, $nBasex, $nWin, $window)){
          
          if($basex === $matches[0] && (isset($matches[1]))) { 
              
              unset($matches[0]);
              $callex = (array_unique($matches));
              $callex = array_map(fn($val)=> explode('?',$val)[0], $callex);
              $caller['arguments'] = array_merge(array_values($callex), $caller['arguments']);
  
              if($SLUGS && ($SLUGS()[$i] ?? '')){
  
                // resolve this if SLUGS constant key is applied.
              
                UrlSlugs::save(array_values($callex));
                $matched = $SLUGS()[$i];
                if($matched instanceof Closure){
                  $matched = Container::instance()->callFunction($matched, $caller['arguments']);
                }else if(is_array($matched) && count($matched) === 2){
                  $vclass = $matched[0];
    
                  $wclass = substr($vclass, strlen(scheme(WIN))-1);
    
                  if(windowExists($wclass)) {
                    if(method_exists($vclass, $matched[1])){
                      if(array_key_exists($vclass, self::$windowInstances)){
                        $matched[0] = self::$windowInstances[$vclass];
                      }
                      $matched = Container::instance()->callMethod($matched[0], $matched[1], $caller['arguments']);
                    }else{
                      return EInfo::trigger('invalid url validator method "'.$matched[1].'()" supplied');
                    }
                  }else{
                    return EInfo::view('invalid url validator supplied');
                  }
                }
                if($matched instanceof UrlSlugs){
                  $matched = $matched::response();
                }
              }else{
                $matched = true;
              }
            }
        }
      }

      if(($nBasex === $nWin) || $matched) {

        if($isMethod){
          
          if(!method_exists($class, $method)) break; //proceed to shutdown

          $preload = self::wvm('preload');
          $bsx = static::wvm('@base');

          if(($a = array_key_exists($bsx, $preload)) || ($b = array_key_exists($bsx, $preload))){
            if($a){
              ContainerFunction::resolve($preload[$bsx], [$bsx]);
            }else{
              ContainerFunction::resolve($preload[strtolower($bsx)], [$bsx]);
            }
          }

          $boot($base, CASTED::BASE); //apply boot function when shutter is triggered

          $caller['type'] = 'method';   
          $caller['handler'] = $method;  
          
        } else if ($isClass) {
    
          $class = substr($method, 4, strlen($method));

          $win = scheme.WIN.$class;         

          if(windowExists($class)){

            $caller['type'] = 'class';   
            $caller['handler'] = $win;
            
            if(($ONCALL[1]??'') === false){
              $caller['ONCALL'] = [];
            }

          }
          
        }else if (is_object($method)) {

          $caller['type'] = 'object';   
          $caller['handler'] = $method;   
          
        }

        if(isset($caller['type'])) {
          $resolved =  self::resolveShutterCalls($caller, true);
          return $resolved;
        }

      }

    }
    
    if(array_key_exists(':404', $windows)){

      $method = $windows[':404']; //fetch 404 method

      $resolved = false;

      if(is_string($method) && method_exists($class, $method)){

        $boot($base, CASTED::E404);
        
        $resolved = self::resolveShutterCalls($caller, true);

      }
      return $resolved;
    }

    if($instance->resolved()) return true;

    self::shutdown($close, $SHUTDOWN);

  }

  /**
   * Resolves a parent base url
   * The current page url must have a parent path that exist
   * within the list of permitted parent urls
   *
   * @param Window $instance 
   * @param array $route acceptable route urls
   * @param string $type type of shutter resolve
   * @param array $state provides information used to resolve route.
   * @return void|bool
   */
  private static function basec(Window $instance, $route, string $type, array $state = []){

    // anonymous on shutter call function
    $boot = function($base, $cast) {
        $onCall = self::wvm('onCall');

        if(array_key_exists($base, $onCall[$cast])){
          if($onCall[$cast][$base] instanceof Closure){
            self::$wvm['onCallResponse'][CASTED::BASE][$base] = $onCall[$cast][$base]();
          }
        }
    };

    // update the last shutter metrics data
    $last_metrics = count(self::$metrics[':keys']) - 1;
    $shutter_data = array_values(self::$metrics[':keys'][$last_metrics]);
    self::$metrics[':keys'][$last_metrics] = [$type => $shutter_data[0]];
    $class = get_class($instance);

    $window = substr($route[0], 5);
    $method = $route[1];
    $origin = $route[2] ?? '';

    //Resolve window with its inverse operator
    $inverse = '';
    if($window && (substr($window, 0, 1) === '!')){
      $inverse = '!';
      $window = substr($window, 1);
    }

    $index = static::wvm('@');
    
    $base = $state['base'];
    $onCall = $state['onCall'];
    $USE_CASE = $state['USE_CASE'];
    $windows = $state['windows'];
    $caller['instance'] = $instance;
    $caller['name'] = $state['name'];
    $caller['arguments'] = $state['arguments'];
    $caller['close'] = $state['close'];
    $caller['ONCALL'] = $state['ONCALL'];
    $caller['onCall'] = $state['onCall'];
    $caller['SHUTDOWN'] = $state['SHUTDOWN'];
    $ONCALL = $caller['ONCALL'];

    if($type === 'basc'){
      //for call method
      $window = $window ?: $index; //redefine window for empty window supplied
    }else{
      //for smartcall
      if($origin){
        if($window){
          $window = lastCall()? lastCall().'/'.$origin.'/'.$window : $origin.'/'.$window;
        }else{
          $window = lastCall()? lastCall().'/'.$origin : $origin;
        }
      }else{
          $window = lastCall()? lastCall().'/'.$window : $window;
      }
      $origin = ''; // prevent origin from being used in authorization
    }

    if(self::authorizes($base, 'base?'.$inverse.$window, $USE_CASE, $origin) !== false){
 
      //predefine anonymous filter function
      $filter = function($window, &$basex, &$strict) use($base, $USE_CASE, $inverse) {

        $win    = trim($window, '/ ');
        $winexp = explode('/', $win);
        $winexc = count($winexp); //number of paths for s3upplied window

        $uripaths = explode('/', trim($base, '/ ')); //number of paths for window base

        //fetch the length of supplied path in current url address
        $basex = implode('/', array_slice($uripaths, 0, $winexc));
        
        $basex = preg_replace('/\?.*/','', $basex);

        $strict = ($inverse)? true : false;

        //apply case sensitivity 
        if($USE_CASE) $strict = !$strict;

      };

      $basex = $strict = ''; //define default filter variables

      $filter($window, $basex, $strict); //filter window path and obtain required variables

      if($strict){
        static::$isCaseSensitive = true;
      }else{
        static::$isCaseSensitive = false;
      }
      
      $caller['lastcall'] = $basex; //update last route 

      if(is_string($method)){

        if(substr($method, 0, 4) === 'win:'){
          // resolve classes .........................
          $class = substr($method, 4, strlen($method));

          $win = scheme.WIN.$class;         

          if(windowExists($class)){

            self::$lastWindow = $win;

            $caller['type'] = 'class';   
            $caller['handler'] = $win; 
            $caller['SHUTDOWN'] = false;
            if(($ONCALL[1]??'') === false){
              $caller['ONCALL'] = [];
            }

          }
        
        }elseif(method_exists($class, $method)){
          
          self::resolve_preloaded_middlewares();

          $caller['type'] = 'method';   
          $caller['handler'] = $method;
          $caller['SHUTDOWN'] = false;
          $boot($base, CASTED::BASE); //apply boot function on methods when shutter is triggered  
        }

      }elseif(is_object($method)){
          
          if(is_closure($method)){
            self::resolve_preloaded_middlewares();
          }
          $caller['type'] = 'object';   
          $caller['handler'] = $method;
          $caller['SHUTDOWN'] = false;   
      }else{
        return false;
      }

      if(isset($caller['type'])) return self::resolveShutterCalls($caller, true);
      
    }

    if($instance->resolved()) return true;

  }
  
  /**
   * Include different acceptable routes on windows path url
   * The current page url (window + path) should match one of the lists
   * of supplied permitted urls else a 404 error page is activated.
   *
   * @param Window $instance window instance
   * @param array $windows accepted routes and route conditions
   * @param bool $close 
   *   - shutter::open or 0 or false pends shutter
   *   - shutter::close or 1 or true closes shutter
   *   - shutter::sleep or 2 sleeps shutter (live mode)
   * @notice all preloads have the highest order of execution
   * 
   * @return void|bool
   */
  final public static function smartcall(Window $instance, array $windows = [], bool|shutter $close = true){

    if(RouteInspector::capturing()){ RouteInspector::capture(get_class($instance), __FUNCTION__, $windows); return false; }

    if($instance->resolved()) return false;

    $base = static::wvm('@base'); //full path 
          
    $onCall = self::wvm('onCall');

    //get supplied origin as string
    $origin = rtrim($windows[self::ORIGIN] ?? '', '/');

    //get default STRICT case for shutter 
    $superStrict = $windows[Window::STRICT]??false; 

    //remove all cases of inverse from origin
    if(substr($origin, 0, 1) === '!'){
      $oinverse = '!';
      $origin = substr($origin, 1);
    }else{
      $oinverse = '';
    }

    //use inverse to negate default STRICT level
    if($oinverse){
      $ostrict = ($superStrict)? !$superStrict : true; 
    }else{
      $ostrict = $superStrict;
    }


    if($origin){
      $origin_slash = $origin.'/';
      $slash_origin = '/'.$origin;
      $slash_origin_slash = '/'.$origin.'/';
    }else{
      $slash_origin_slash = $origin_slash = $slash_origin = '';
    }

    $windows = self::identify_truncation_for($windows);
    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);

    $extras = ['instance' => $instance, 'shutter' => __FUNCTION__];

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $SHUTDOWN, $arguments, $USE_CASE, $SLUGS, extras: $extras);

    static::integrateAPI();

    // Handle Boot Middleware Trigger
    $boot = function ($base, $cast) use($onCall) {
      if(array_key_exists($base, $onCall[$cast])){ 
        $booted = Container::instance()->callFunction($onCall[$cast][$base]);
        self::$wvm['onCallResponse'][CASTED::CALL][$cast] = $booted;
      }
    };

    $caller['instance'] = $instance; //window instance
    $caller['name'] = 'call';     //root, call, path, base
    $caller['arguments'] = $arguments; //shutter shutdown function
    $caller['ONCALL'] = $ONCALL;   //shutter boot function
    $caller['SHUTDOWN'] = $SHUTDOWN; //shutter shutdown function
    $caller['close'] = $close;    //close application
    $caller['lastcall'] = $base; //last route called ($base, $path, $root)
    $lastCall = lastCall();

    /* window as window's url */
    foreach($windows as $window => $method) {

      $prefix = substr($window, 0, 5); 
      $modifier = 'base?';
      if(is_string($method)) $method = str_replace('-','_', $method);

      if($prefix === $modifier){
        $winshutter = rtrim(substr($window, 0, 4), 'e').'ec';
        if($winshutter === 'basec'){
          $caller['name'] = $winshutter;     //pathex, basex, rootex
          $caller['onCall'] = $onCall;     //pathex, basex, rootex
          $caller['windows'] = $windows;     //pathex, basex, rootex
          $caller['base'] = $base;     //pathex, basex, rootex
          $caller['USE_CASE'] = $USE_CASE;     //pathex, basex, rootex 
          
          $resolved = self::basec($instance, [$window, $method, $origin], 'basx', $caller); //handles inline path resolving
          if($resolved) return ($resolved);
        }
        continue;
      }
      //redefine case-sensitivity based on child negation
      if($window && ($window[0] === '!')) {
        $strict = !$ostrict;
        $window = substr($window,1);
      }else{
        $strict = $ostrict;
      }
      if($window){
        // Append the last tracked url if route path is supplied
        $window = $lastCall? ($lastCall.($slash_origin_slash?:'/').$window) : $origin_slash.$window;
      }else{
        // Use the last tracked url or index URL if no route path is supplied
        if(!($window = $lastCall ?: window(':'))){
          $window = static::wvm('@').$slash_origin; 
        }else{
          $window .= $slash_origin;
        }

      }
      if($strict){
        $basePath = $base;
        $baseWin = $window; //new window
        static::$isCaseSensitive = true;
      }else{
        $basePath = strtolower($base);
        $baseWin = strtolower($window);
        static::$isCaseSensitive = false;
      }

      $basePath = preg_replace('/\?.*/','', $basePath);

      $matched = false;

      // resolve URL Slugs 
      if(preg_match('/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',$window)) {
        $i = ($i ?? -1) + 1;
        if($matches = self::gets_url_slug($base, $basePath, $baseWin, $window)){
  
          if($base === $matches[0] && (isset($matches[1]))) { 
              
              unset($matches[0]);
              $callex = (array_unique($matches));
              $callex = array_map(fn($val)=> explode('?',$val)[0], $callex);
              $caller['arguments'] = array_merge(array_values($callex), $caller['arguments']);
  
              if($SLUGS && ($SLUGS()[$i] ?? '')){
  
                // resolve this if SLUGS constant key is applied.
              
                UrlSlugs::save(array_values($callex));
                $matched = $SLUGS()[$i];
                if($matched instanceof Closure){
                  $matched = Container::instance()->callFunction($matched, $caller['arguments']);
                }else if(is_array($matched) && count($matched) === 2){
                  $vclass = $matched[0];
    
                  $wclass = substr($vclass, strlen(scheme(WIN))-1);
    
                  if(windowExists($wclass)) {
                    if(method_exists($vclass, $matched[1])){
                      if(array_key_exists($vclass, self::$windowInstances)){
                        $matched[0] = self::$windowInstances[$vclass];
                      }
                      $matched = Container::instance()->callMethod($matched[0], $matched[1], $caller['arguments']);
                    }else{
                      return EInfo::trigger('invalid url validator method "'.$matched[1].'()" supplied');
                    }
                  }else{
                    return EInfo::view('invalid url validator supplied');
                  }
                }
                if($matched instanceof UrlSlugs){
                  $matched = $matched::response();
                }
              }else{
                $matched = true;
              }
            }
        }
      }

      if(($basePath === $baseWin) || $matched){

        if(is_string($method)){

          if(method_exists($class, $method)){

            self::resolve_preloaded_middlewares();
            
            $boot($base, CASTED::CALL);
            $caller['type'] = 'method';   
            $caller['handler'] = $method;  

          }elseif(substr($method, 0, 4) === 'win:') {

            $class = substr($method, 4, strlen($method));
            $win   = scheme.WIN.$class;
            
            if(windowExists($class)){ 

              $caller['type'] = 'class';   
              $caller['handler'] = $win;
            
              if(($ONCALL[1]??'') === false){
                $caller['ONCALL'] = [];
              }   

            }

          }

        }elseif(is_object($method)) {

          if(is_closure($method)){
            self::resolve_preloaded_middlewares();
          }

          $caller['type'] = 'object';   
          $caller['handler'] = $method; 

        }

        if(isset($caller['type'])) {
          $resolved = self::resolveShutterCalls($caller, true);
          return $resolved;
        }

      }

    } 

    if(array_key_exists(':404', $windows)){

      $method = $windows[':404'];

      $caller['type'] = 'method';   
      $caller['handler'] = $method;  

      if(is_string($method) && method_exists($class, $method)){

        $boot($base, CASTED::E404); //boot shutter for shutdown
        
        $resolved = self::resolveShutterCalls($caller, true);

      }
      return $resolved ?? false;

    }

    self::shutdown($close, $SHUTDOWN);

  }

  private static function resolve_preloaded_middlewares() {
    $preload = self::wvm('preload');
    $bsx = static::wvm('@base');

    if(($a = array_key_exists($bsx, $preload)) || (array_key_exists(strtolower($bsx), $preload))){
      if($a){
        ContainerFunction::resolve($preload[$bsx], [$bsx, $bsx]);
      }else{
        ContainerFunction::resolve($preload[strtolower($bsx)], [$bsx, strtolower($bsx)]);
      }
    }
  }

  private static function identify_truncation_for(array $windows, ?Closure $filter = null, &$authorizer = []) : array {

    $windows = self::set_truncation_for($windows);
    $isTrunked = $windows[self::TRUNK];
    unset($windows[self::TRUNK]);
    if($isTrunked) {    
      if($filter) {
        $windows = $filter($windows, $authorizer);

      }else{
        $windows = iTrunk($windows);
      }
    }
    return $windows;
  }

  private static function set_truncation_for(array $windows) : array {
    
    if(($test1 = array_key_exists(self::TRUNK, $windows)) || (in_array(self::TRUNK, $windows))){
      if($test1) return $windows;
      $key = array_search(self::TRUNK, $windows);
      unset($windows[$key]);
      $windows[self::TRUNK] = true;
      return $windows;
    }
    
    if(!isset(self::$TRUNKED)){
      self::$INIT_TRUNK = false;
      if(strtolower(Init::key('SHUTTERS')?:'') === 'trunk'){
        self::$INIT_TRUNK = true;
      }
    }
    $windows[self::TRUNK] =  self::$INIT_TRUNK;
    return $windows;
  }

  private static function gets_url_slug(string $base, string $weburl, string $windowurl, string $window) : array {

    $splitWeb = explode('/', $weburl); // url base (full path)
    $splitWindow = explode('/', $windowurl); // supplied shutter url
    $countBase = count($splitWeb);
    $countWindow = count($splitWindow);

    if(($countBase === $countWindow) && $countBase){
       // replace placeholders using window paths.
       $pattern = '~^'.str_replace(['{','}'], ['(?P<','>[^\/]+)'], $window).'$~';
       
       // resolve checkmate slugs format with base format
       if(preg_match($pattern, $base, $matches)){
        return $matches;
       }
    }

    return [];

  }
  
  /**
   * Returns the last called route before the current one or uses 
   * the last called route to resolve shutters 
   *
   * @return string
   */
  final public static function lastCall() : string {
    return static::$lastCall;
  }

  /**
   * This method is used to overide reserved window methods 
   * that are call on route methods. Reserved window methods cannot be  
   * easily called, hence, the need for a polyfill 
   *
   * @param string $method
   * @return array
   */
  static function polyfill(string $method) : array {

    return [];

  }

  
  /**
   * Pend the closing of a window
   */
  final protected static function pend(bool $bool = true) {
    self::wvm('pend', $bool);
  }

  public function __toString(){
    return static::wvm('page')? '' : ' ';
  } 

  /**
   * Set shutter variables
   *
   * @param Request $Request
   * @param array $windows
   * @param array $variables
   * @param Closure|null $ONCALL
   * @param Closure|null $SHUTDOWN
   * @param array $arguments
   * @param bool $STRICT
   * @param array $extras contains extra data such as window instance and shutter method
   * @return void
   */
  final protected static function windowShutterVariables(&$Request, &$windows, &$variables, &$ONCALL, &$SHUTDOWN, &$arguments, &$STRICT, &$SLUGS = [], array $extras = []){
    
    $Request = new Request;

    $arguments = [];

    $instance = $extras['instance'];
    $shutter = $extras['shutter'];

    $controller = $instance ? get_class($instance) : '';
    if(strlen($controller) > 0 && $controller[0] !== '\\') $controller = '\\'.$controller;

    self::$lastWindow = $controller;
    self::$lastWindowInstance = $instance ?: false;
    if($instance) self::$windowInstances[get_class($instance)] = $instance; 
    
    $variables = $windows[self::ARG] ?? static::$variables;

    $ONLOAD = $windows[self::ONLOAD] ?? [];
    $ONCALL = $windows[self::ONCALL] ?? [];
    $INCALL = $windows[self::INCALL] ?? [];

    if($INCALL && $ONCALL) throw new ErrorException('Both INCALL and ONCALL middleware cannot be applied together'); 
    if($ONCALL && $ONLOAD) throw new ErrorException('Both ONCALL and ONLOAD middleware cannot be applied together');
    $ONCALL = $ONCALL ?: $ONLOAD;
    
    if($INCALL || $ONCALL){
       // false as limited, true as global middleware
       $ONCALL = $ONCALL? [$ONCALL, false] :  [$INCALL, true];
    }
    $SHUTDOWN = $windows[self::ONSHUT] ?? null;
    $TYPE = $INCALL ? 'INCALL' : 'ONLOAD';
    if($SHUTDOWN && $ONLOAD) throw new ErrorException('Both ONSHUT and '.$TYPE.' middleware cannot be applied together');
    $SHUTDOWN = $SHUTDOWN ?: (!empty($ONLOAD)? $ONLOAD : null);

    $SLUGS =  $windows[self::SLUGS] ?? [];
    
    if($variables || isset($windows[self::ARG]) || isset(static::$variables)) {
      array_unshift($arguments, $variables);   
    }
    
    $STRICT = $windows[self::STRICT] ?? false;

    unset($windows[self::ARG], $windows[self::ONCALL], $windows[self::ONLOAD],  $windows[self::INCALL], $windows[self::STRICT], $windows[self::ORIGIN]);

    self::$metrics[':keys'] = self::$metrics[':keys'] ?? [];
    self::$metrics[':keys'][] = [$shutter => ['controller' => is_closure($controller)? 'closure()' : (is_object($controller) ? get_class($controller) : $controller), 'routes' => $windows, 'origin' => $windows[self::ORIGIN]??null]];
    self::$metrics[] = $controller;
  }

  /**
   * Authorizes a path relative to window shutters using a parent url format and returns the path supplied if authorized.
   *
   * @param string $haystack parent url
   * @param string $needle test url
   * @param boolean $strictness determines the strictness level of path autorized
   * @param string $origin sets a parent path origin for $needle. If you are setting this, ensure to end the string with a forward slash.
   * @param array|null $authorization get authorization data.
   * @return string|false
   */
  final public static function authorizes(string $haystack, string $needle, $strictness = false, string $origin = '', &$authorization = []) : string|false {
    
    $oneedle = $needle;
    
    $key = substr($needle, 0, 5); 
    $modifier = ['base?','basc?']; $mode = '';
    if(in_array($key,$modifier)){
      $mode = substr($needle, 0, 4);
      $needle = substr($needle, 5);
    }

    if(substr($needle, 0, 1) === '!'){
      $strict = true; //inverse strict
      $oneedle = $needle = substr($needle, 1); //update window
    }else{
      $strict = false; //inverse strict
    }

    if($origin){
      if($origin[0] === '!'){
        $origin = substr($origin, 1);
        $strict = !$strict;
      }
      $needle = ($needle)? $origin.'/'.$needle : $origin;
    }
    //apply case sensitivity 
    if($strictness) $strict = !$strict;

    $uriA = $uriHay = $haystack; 
    $uriB = $uriNeed = $needle;  

    if(!$strict){
      // reduce strictness level of urls
      $uriA = $uriHay = strtolower($uriA);
      $uriB = $uriNeed = strtolower($uriB); 
    }
    // test the correlation of both urls
    $handshake = $uriA === $uriB;

    $authorization['haystack'] = $haystack;
    $authorization['needle'] = $needle;
    $authorization['clean-needle'] = $oneedle;
    $authorization['authorized-haystack'] = $uriHay;
    $authorization['authorized-needle'] = $uriNeed;
    $authorization['authorized-strictness'] = $strict;
    $authorization['authorized'] = false;

    if(!$handshake){
       // test for url slugs

       if(in_array($mode, ['base','basc'])){

        // Handle bases 
        if($mode === 'base'){
          $uriA = url($uriA)->first(count(explode('/', $uriB)));
        }

       }


       $splitWeb = explode('/', $uriA); // url base (full path)
       $splitWindow = explode('/', $uriB); // supplied shutter url
       $countBase = count($splitWeb);
       $countWindow = count($splitWindow);

       if(($countBase === $countWindow) && $countBase){ 
          $pattern = '~^'.str_replace(['{','}'], ['(?P<','>[^\/]+)'], $uriNeed).'$~';
          if($mode === 'base') $pattern = '~^'.str_replace(['{','}'], ['(?P<','>[^\/]+)'], $uriNeed).'(.*)?$~';
          // resolve checkmate slugs format with base format
          if(preg_match($pattern, $uriHay, $matches)){
            $authorization['authorized'] = true;
           return $needle;
          }
       }
   
    }else{
      $authorization['authorized'] = true;
      return $needle;
    }
    return false;
  }

  /**
   * Handle a window shutdown
   *
   * @param shutter|bool $close
   * @param Closure|false|null $SHUTDOWN
   * @return void
   */
  final protected static function shutdown(shutter|bool $close, Closure|false|null $SHUTDOWN = null) {

    // during route introspection, skip render/exit so the scan can continue
    if(RouteInspector::capturing()) return;

    //execute shutdown function ...
    if($SHUTDOWN instanceof Closure) {
      if(http_response_code() === 200) response(404);
      self::$shutdown = true;
      $SHUTDOWN();
    }


    if(self::$transmute) {

      $translations = static::wvm('translations'); 

      $code = http_response_code();

      $codeTemplate = $translations[$code] ?? self::wvm('error');

      Rex::load($codeTemplate, fn() => compile());

      return;
    }
    match($close){
      shutter::pend, false => null,
      shutter::close, true => self::close(),
      shutter::sleep => self::sleep(),
    };
  }

  
  /**
   * Sleep live server during error display
   * Notice:: this will send a 423 response header code
   * 
   * @return void
   */
  final protected static function sleep(bool $pend = false) {

    // during route introspection, skip render/exit so the scan can continue
    if(RouteInspector::capturing()) return;

    Res::live();

    if($pend) self::wvm('pend', true);

    //set and return and array of response header
    $response = response(423, 'Page in lock mode!');

    if(!static::$winAPI) {
      Rex::load(static::wvm(':404'), fn() => compile());
    } else{
      echo $response; /* print response header */
    }

    if(!$pend) exit();
  }

  final static function transmute(array $codes = []) {

    self::$transmute = true;

    if(func_get_args() > 0) {

      foreach($codes as $code => $template){
        self::$wvm['translations'][$code] = $template;
      }

    }

  }

  final protected static function validate_response_headers(shutter|bool $close, Closure|false|null $SHUTDOWN = null) {
    $responseHeaders = self::$wvm['headers'];
    $acceptedHeaders = $responseHeaders['accepted'];
    $rejectedHeaders = $responseHeaders['rejected'];
    $responseHeader  = http_response_code();

    if((in_array($responseHeader, $rejectedHeaders) && !empty($rejectedHeaders)) || 
        (!in_array($responseHeader, $acceptedHeaders) && !empty($acceptedHeaders)) ){
        self::shutdown($close, $SHUTDOWN);
        return ;
    }
  }

  /**
   * Resets the resolved marker. This should be used to run on shutter methods.
   *
   * @param Closure|null $callback
   * @return boolean
   */
  final public function clearResolved(?Closure $callback = null) : bool {
      $this->resolved(false);
      return Container::instance()->callFunction($callback);
  } 
  
  /**
   * Returns true when a shutter is resolved
   *
   * @param boolean $bool 
   *  - If argument is defined, this sets and updates the value to be returned by this method.
   *  - If argument is NOT defined, this returns the last status of shutter where TRUE means resolved and FALSE as unresolved
   * @return boolean
   */
  final public function resolved(bool $bool = false) : bool {
    if(func_num_args() > 0) $this->resolved = $bool;
    return $this->resolved;
  }

  /**
   * Determines if the current url is case sensitive
   * @return boolean
   */
  final public static function IsCaseSensitive() : bool {
    return static::$isCaseSensitive;
  }

  /**
   * Returns lower case for current path supplied if window is case insensitive
   * @return string
   */
  final public static function case(string $path) : string {
    return (!static::$isCaseSensitive)? strtolower($path) : $path;
  }

  /**
   * Returns all detected controller information
   * @return array
   */
  final public static function metrics() : array {
    return self::$metrics;
  }

  /**
   * Returns all detected controller information
   * @return boolean
   */
  final public static function isShut() : bool {
    return self::$shutdown;
  }

  /**
   * Returns all detected controller information
   * @return array
   */
  final public static function controllers() : array {
    $controllers = self::$metrics;
    $shutters = $controllers[':keys']; 
    unset($controllers[':keys']);
    $controllers = array_map(function($value){
      return url($value)->pathmod(function($value){
        return ucfirst($value);
      }, -(count(explode(scheme('', false).'\\', $value, 2))-1) );
    }, $controllers);
    $controllers = array_values(array_unique($controllers));
    return $controllers;
  }

  function __destruct()
  {
    $session = \Session::base()->value();
    if(isset($session[Notice::FLASH_KEY])) {
        \Session::base()->remove(Notice::FLASH_KEY);
    }
  }

  /**
   * Resolves route dependencies
   *
   * @param Container $class
   * @return void
   */
  public static function dependencies(Container $class) {

  }

  /**
   * Follows a chained channel activity line where activities are executed on every main controller and subroute  
   * that has this method as a either inherited or direct method. 
   *  - Note: supports only automatic depedencies argumentes.
   */
  // static function __onEvery() : void{}

  /**
   * Follows a chained channel activity line where activities are executed on every controller 
   * that has this method as a direct method. 
   *  - Note: supports only automatic depedency arguments.
   */
  // static function __onEntry() : void{}

  /**
   * Follows a chained channel activity line where only the first detected activity line is allowed to be executed
   *  - Note: supports only automatic depedency arguments.
   */
  // static function __nOnce() : void{ }
  
  /**
   * Follows a chained channel activity line where only the last activity line is allowed to execute this after all activities have been 
   * processed. This is usually triggered as the last activity to occur by the last route (or subroute) controller class. 
   *  - Note that this method will not run if a parent controller class is terminated abruptly even after a shutter method has been triggered.
   *
   * @return void
   */
  // public static function __onFinal() : void {}
}