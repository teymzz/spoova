<?php

use spoova\mi\core\classes\Rex;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Compiler;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\UrlMapper;
use spoova\mi\core\classes\Controller;
use spoova\mi\core\classes\constants\CASTED;
use spoova\mi\core\classes\Container;
use spoova\mi\core\classes\Notice;

/**
 * Controls view from windows frame
 * 
 * :Reserved Methods:
 * 
 * __contruct, onOpen, loadBase,
 * open, close, call, sleep, eview, secure.
 * 
 */
class Window extends Controller{

  protected static $wvm = [
    
      #url mappers
      'window' => '', /* entry point */
      'root' => '',   /* alias for window */
      'path' => '',   /* direct path after widow */
      'base' => '',   /* window + path (fullpath) */

      #url error - 404 error rex file
      'error' => 'errors.404',

      #csrf error - 404 csrf error rex file
      'csrf'  => 'errors.e-csrf',

      
      #variables
      'variables' => null,

      #authentications - unused
      'secure' => ['GUEST' => [], 'AUTH' => []],
      
      #close window
      'close' => false, 
      
      #pend close window
      'pend' => false,

      #keep dot convention
      'keep' => false,

      #preloaded callbacks
      'preload' => [],

      'onCall' => [ 
        'cast' => [], 
        'root' => [], 
        'base' => [], 
        'path' => [],
        'e404' => []
      ],

      /**
       * store call responses
       * This will be added in future versions
       */
      'onCallResponse' => [
        'cast' => [], 
        'root' => [], 
        'base' => [], 
        'path' => [],
        'e404' => []
      ]

  ];

  protected static $this;

  public const ARG = ':ARG';
  public const PARAMS = ':ARG';
  public const ONCALL = ':ONCALL';
  public const STRICT = ':STRICT';

  /**
   * set window error response type
   *
   * @var string $e_response optional [direct|(api/json)|ajax]
   */
  protected static $e_response = 'direct'; //

  /**
   * set window response type
   *
   * @var string $winAPI optional [false|ajax|json|(ajax:json|true)]
   */
  protected static $winAPI = false;
  

  private const folder = 'windows';
  private const Server = 'Server';
  
  #resolved classes
  protected $resolved = false;
  
  #inherent local variables
  protected static $variables = null;

  private static string $lastCall = '';
  private static bool $isPended = false;
  private static string $pender = '';

  /**
   * privatize the Window's instance
   */
  private function __construct() {

  } 

  /**
   * Set or Fetches wvm windows paramters
   *
   * @param string $key wvm key to be set or fetched
   * @param string $value respective value to be set
   * @return array|string
   * @notice if key does not exists returns empty string
   */
  final public static function wvm(string $key = null, $value = null){
    if($key == ':404') $key = 'error';
    if($key == ':csrf') $key = 'csrf';
    if(func_num_args() == 0) return static::$wvm;
    if(func_num_args() == 1) {

      $marker = '';
      $firstChar = substr($key, 0, 1);

      if(($firstChar === '!') || ($firstChar === '@')){
        $key = substr($key, 1, strlen($key));
        $marker = $firstChar;
        //if($firstChar === '@') $marker = '';
      }

      if(strpos($key,':') !== false){
        /* resolve as path */
        $expkey = explode(":", $key, 2);
        $key = $expkey[0] ?: 'root';
        $path = $expkey[1]?? '';
        if(!self::wvm('keep')) $path = str_replace('.', '/', $path);
        $basepath = static::$wvm[$key]?? '';
        if(($firstChar ==='@')){
          $marker = '';
          if(!$basepath && $key !== 'path') {
            $basepath = 'index';
          }
        }
        
        $newpath = $basepath.'/'.$path;
        return $marker.rtrim($newpath, '/');
      }else{
        /* resolve as window key */
        $value = static::$wvm[$key]?? '';
        if($value === '' && $marker === '@' && $key !== 'path') $value = 'index';
        return $value;
      }

    }
    
    if(func_num_args() > 1) {
        if(static::$wvm ?? false) static::$wvm[$key] = $value; 
    }
    return  '';
  }

  /**
   * Set window error response type
   *
   * @param string $type optional [direct|(api/json)|ajax]
   * When no argument is supplied, it returns the current response type set.
   * @return string
   */
  final function e_response($type = '') {
      $response = static::$e_response ?? '';
      if(func_num_args() < 1) return $response;
      if(in_array($type, ['api','ajax','json','direct'])){
        return static::$e_response = $type;
      }
      return static::$e_response;
  }

  /**
   * Set window response type
   *
   * @param bool|string $type optional [false|ajax|json|(true|ajax:json)]
   * @param array $emessage error message returned when request is not ajax
   * @param array $ecode error code returned when request is not ajax
   * @return void|false
   * 
   * @Notice supplying arguments ($emessage) declares that the page request must be through ajax only
   */
  final static function integrateAPI(bool|string $type = false, $emessage = 'invalid request', int $ecode = 401) {

    $validsOptions = ['', 'ajax', 'json', 'ajax:json', 'json:ajax'];
    
    if(func_num_args() > 0) {


      if(!in_array($type, $validsOptions) && !is_bool($type)) {
        return EInfo::view('Invalid option supplied on argument 1 <i><u>integrateAPI()</u></i>'." in ".get_called_class());
      }
      static::$winAPI = $type;
    
    }

    $type = strtolower(static::$winAPI);

    if(!in_array($type, $validsOptions) && !is_bool($type)) {

      if($parentClass = get_parent_class(get_called_class())){
        $parentClass = br()."&nbsp;:: <b>Parent Class: </b>".$parentClass; 
      }
      return EInfo::view('Invalid option set for property <i><u>$winAPI</u></i> in '.get_called_class(). $parentClass);
      return false;

    }

    $args = [];

    if(func_get_args() > 1){
      $args = func_get_args();
      unset($args[0]);
      ksort($args);    
    }


    if($type){

      if($type === true || $type === 'json:ajax') $type = 'ajax:json';
      
      if($type === 'ajax') {
        if(Ajax::isAjax()) (new Ajax())->referred();
      }elseif($type === 'json'){
        //set as json, may be an ajax request    
        Ajax::withjson(...($args));
      }elseif($type === 'ajax:json'){
        //set as json and must be an ajax request
        Ajax::withJson(...($args)?: ['invalid request', 401]);
      }

    }

  }

  /**
   * Test if the current page or value supplied is index page
   *
   * @param string $Index
   * @return boolean
   */
  final static function isIndex($Index = ''){

    $root = window('root'); 
    return (!$root || ($root == 'index'));

  }

  /**
   * Loads a route from the Windows/Routes folder
   *
   * @param string $path
   * @return bool true if route file exists
   */
  final static function callRoute(string $path){

      $class = scheme.WIN_ROUTES.$path;

      if(routeExists($path)){

        $parents = class_parents($class);
        $parents = (array_reverse(array_unset($parents, [Window::class, Controller::class], true)));
        $parents[$class] = $class; 
        foreach($parents as $parent){
          $rfc = new ReflectionClass($parent);
          if($rfc->hasMethod('frame') && ($rfc->getMethod('frame')->getDeclaringClass()->getName() === $parent)){
            $parent::frame();
          }
        } 

        User::auth()->id()->main();

        $class::super();
          new $class(new Request);
          return true;          
      }

      return false;

  }

  /**
   * Checks if supplied path exists in the windows/Routes folder
   *
   * @param string $path 
   *  - Supplied path will be searched within the windows/Routes folder
   * @return bool true if route file exists
   */
  final static function inRoutes(string $path){

      return (routeExists($path));

  }


  /**
   * Open a new path
   *
   * @param string $path a new url path to be processed
   * @return void
   */
  final public static function open($path = ''){
    static::bindFormData(); //allow opening of new data
    static::loadBase($path);        
    static::onOpen($path);
  }

  /**
   * Converts a supplied url path to clickable splits
   *
   * @param string $url url to be mapped
   * @param string $separator url separator element
   * @return string
   */
  final protected static function mapurl(string $url, string $separator = '/'){
    $urlmap = new UrlMapper;

    $base = DomUrl();
    $urlmap->setbase(DomUrl('/'));
    return $urlmap->map($url, $separator);
  }

  /**
   * Defines a list of operations that must occur before a route is 
   * intialized
   *
   * @return void
   */
  static function super(){}

  /**
   * Defines a list of operations that must occur in sequence from the parent classes 
   * down to the child window (route) before it is initialized.
   *
   * @return void
   */
  static function frame(){}

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

    foreach($callTypes as $callType){
      if($callType == ':404') $callType = CASTED::E404;
      if(array_key_exists($callType, self::$wvm['onCall'])){
        self::$wvm['onCall'][$callType] = $urls;
      }
    }

  }

  /**
   * Allows single callbacks on different urls.
   *
   * @param array $urls - array of url values
   * 
   * @param \Closures $closures applied as presets on each defined url
   *
   * @notice Callback will run if the current url exists in list of urls even if the page is a 404
   * @return void
   */
  public static function preset(array $urls, \Closure $callback){

    if(in_array(window("base"), $urls)) {
      $callback();
    }

  }

  /**
   * Allows single callbacks on different urls only when url is resolved
   *
   * @param array $urls - array of url values
   * 
   * @param \Closures $closures applied as presets on each defined url
   *
   * @notice This will overide any previous presets and only runs when the url is resolved before the url is loaded
   * @return void
   */
  public static function preload(array $urls, \Closure $callback){

    if(in_array(window("base"), $urls)) {
      self::$wvm['preload'][window("base")] = $callback;
    }

  }

  /**
   * Resolves a parent url root name
   *
   * @param Window $class
   * @param array $windows
   * @param bool|array $close
   *    (array) => as variables
   *    (bool) =>  close window 
   * 
   * @param bool $reclose close window when $close is array
   * 
   * @return void
   */
  final protected static function rootcall(Window $instance, array $windows = [], bool $close = true){               
    
    if($instance->resolved()) return;

    $root = static::wvm('@root'); //root path
    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);
    $reflect = new \ReflectionClass($class);

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $arguments, $STRICT);

    static::integrateAPI();

    if($root == '') $root = 'index'; 
    /* window as window's url */
    foreach($windows as $window => $method) {
      
      if(!$window) { $window = static::wvm('@'); }

      if(substr($window, 0, 1) == '!'){
        $strict = true; //inverse strict
        $window = substr($window, 1, strlen($window));
      }else{
        $strict = false; //inverse strict
      }
      
      $nRoot = $root;
      $nWin = $window;

      if($STRICT){

        if($strict){
          $nRoot = strtolower($root);
          $nWin = strtolower($window);
        }
        
      }else{

        if(!$strict){
          $nRoot = strtolower($root);
          $nWin = strtolower($window);
        }

      }

      if(($nRoot == $nWin)) {
        if(method_exists($class, $method)) {
                      
          $onCall = self::wvm('onCall');

          if(array_key_exists($root, $onCall[CASTED::ROOT])){
            if($onCall[CASTED::ROOT][$root] instanceof \Closure){
              self::$wvm['onCallResponse'][CASTED::ROOT][$root] = $onCall[CASTED::ROOT][$root]();
            }
          }

          response(200, 'status ok');
          self::$lastCall = $root;
          static::$isPended = !$close;
          static::$pender = static::$isPended? 'root' : '';
          $Container = new Container($instance);

          if($ONCALL instanceof \Closure) $ONCALL();

          if($reflect->getMethod($method)->isStatic()){
            $Container::$method(...$arguments);
          } else {
            $Container->$method(...$arguments);
          }
          
          $instance->resolved(true);
          return $instance->resolved();

        }elseif(substr($method, 0, 4) == 'win:') {

          $class = substr($method, 4, strlen($method));
          $win   = scheme.WIN.$class;
    
          if(windowExists($class)){ 
            response(200, 'status ok');
            $instance->resolved(true);
            self::$lastCall = $root;
            static::$isPended = false;
            static::$pender = static::$isPended? 'root' : '';
            if($ONCALL instanceof \Closure) $ONCALL();
            $Container = new Container($win, ...$arguments);
            return $instance->resolved();
          }

        }elseif(is_object($method)) {
            response(200, 'status ok');
            $instance->resolved(true);
            self::$lastCall = $root;
            static::$isPended = false;
            static::$pender = static::$isPended? 'root' : '';
            if($ONCALL instanceof \Closure) $ONCALL();
            $Container = new Container(get_class($method), ...$arguments);
          //  new $method(...$arguments);
            return $instance->resolved();
        }

      }

    } 

    if(array_key_exists(':404', $windows)){
      $method = $windows[':404'];
      if(method_exists($class, $method)){
                      
        $onCall = self::wvm('onCall');

        if(array_key_exists($root, $onCall[CASTED::E404])){
          if($onCall[CASTED::E404][$root] instanceof \Closure){
            self::$wvm['onCallResponse'][CASTED::E404][$root] = $onCall[CASTED::E404][$root]();
          }
        }

        response(200, 'status ok');
        self::$lastCall = $root;
        static::$isPended = !$close;
        static::$pender = static::$isPended? 'root' : '';

        if($ONCALL instanceof \Closure) $ONCALL();          
        if($reflect->getMethod($method)->isStatic()){
          $Container = new Container($class);
          $Container::$method(...$arguments);
          //$class::$method(...$arguments);
        } else {
          $Container = new Container($instance, $variables);
          $Container->$method(...$arguments);
        }
      }
      $instance->resolved(true);
      return $instance->resolved();
    }

    if($close) self::close();

  }  

  
  /**
   * Include different acceptable routes on windows path url
   * The current page url (window + path) should match one of the lists
   * of supplied permitted urls else a 404 error page is activated
   *
   * @param Window $class
   * @param array $windows
   * @param bool $close 
   * @notice all preloads have the highest order of execution
   * 
   * @return void|bool
   */
  final protected static function call(Window $instance, array $windows = [], bool $close = true){   

    if($instance->resolved()) return;

    $base = static::wvm('@base'); //full path 
    
    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);
    $reflect = new \ReflectionClass($class);

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $arguments, $STRICT);

    static::integrateAPI();

    /* window as window's url */
    foreach($windows as $window => $method) {

      if(!$window) { $window = static::wvm('@'); }

      if(substr($window, 0, 1) == '!'){
        $strict = true; //inverse strict
        $window = substr($window, 1, strlen($window));
      }else{
        $strict = false; //inverse strict
      }

      if(!$window) $window = $base;

      $nBase = $base;
      $nWin = $window;

      if($STRICT){ 

        if($strict){
          $nBase = strtolower($base);
          $nWin = strtolower($window);
        }
        
      }else{

        if(!$strict){
          $nBase = strtolower($base);
          $nWin = strtolower($window);
        }

      }

      if($nBase === $nWin){
        
        if(method_exists($class, $method)){
          
          $onCall = self::wvm('onCall');
          $preload = self::wvm('preload');

          if(array_key_exists($base, $preload) ){
            $preload[$base]();
          }
          
          if(array_key_exists($base, $onCall[CASTED::CALL])){
            if($onCall[CASTED::CALL][$base] instanceof \Closure){
              self::$wvm['onCallResponse'][CASTED::CALL][$base] = $onCall[CASTED::CALL][$base]();
            }
          }

          $Container = new Container($instance);

          //handle method called
          response(200, 'status ok');
          self::$lastCall = $base;
          static::$isPended = !$close;
          static::$pender = static::$isPended? 'call' : '';
          if($ONCALL instanceof \Closure) $ONCALL();

          if($reflect->getMethod($method)->isStatic()){
            $Container::$method(...$arguments);
          } else {
            $Container->$method(...$arguments);
          }

          $instance->resolved(true); 
          return $instance->resolved();

        }elseif(substr($method, 0, 4) == 'win:') {

          $class = substr($method, 4, strlen($method));
          $win   = scheme.WIN.$class;
          
          if(windowExists($class)){ 
            response(200, 'status ok');
            $instance->resolved(true);
            self::$lastCall = $base;
            static::$isPended = false;
            static::$pender = static::$isPended? 'call' : '';
            if($ONCALL instanceof \Closure) $ONCALL();
            
            //call window
            new Container($win, $variables);

            return $instance->resolved();
          }

        }elseif(is_object($method)) {

            response(200, 'status ok');
            $instance->resolved(true);
            self::$lastCall = $base;
            static::$isPended = false;
            static::$pender = static::$isPended? 'call' : '';
            if($ONCALL instanceof \Closure) $ONCALL();
            
            //call window
            new Container($method, ...$arguments);

            return $instance->resolved();

        }
      }

    } 

    if(array_key_exists(':404', $windows)){
      $method = $windows[':404'];
                      
      $onCall = self::wvm('onCall');

      if(array_key_exists($base, $onCall[CASTED::CALL])){
        if($onCall[CASTED::CALL][$base] instanceof \Closure){
          self::$wvm['onCallResponse'][CASTED::CALL][$base] = $onCall[CASTED::CALL][$base]();
        }
      }

      if(method_exists($class, $method)){
        if($reflect->getMethod($method)->isStatic()){
          response(200, 'status ok');
          static::$isPended = !$close;
          static::$pender = static::$isPended? 'call' : '';
          self::$lastCall = $base;
          if($ONCALL instanceof \Closure) $ONCALL();

          //call window
          $Container = new Container($instance);
          $Container::$method(...$arguments);

          $instance->resolved(true);
        } else {
          response(200, 'status ok');
          self::$lastCall = $base;
          static::$isPended = !$close;
          static::$pender = static::$isPended? 'call' : '';
          if($ONCALL instanceof \Closure) $ONCALL();
          $Container = new Container($instance);
          $Container->$method(...$arguments);
          $instance->resolved(true);
        }
        return $instance->resolved();
      }
      return ;
    }

    if($close) self::close();

  }

  /**
   * Resolves a parent base url
   * The current page url must have a parent path that exist
   * within the list of permitted parent urls
   *
   * @param Window $class
   * @param array $windows
   * @param bool $close 
   * 
   * @return void|bool
   */
  final protected static function basecall(Window $instance, array $windows = [], bool $close = true){

    if($instance->resolved()) return;

    $base = static::wvm('@base');

    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);
    $reflect = new \ReflectionClass($class);
    
    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $arguments, $STRICT);

    static::integrateAPI();
    
    foreach($windows as $window => $method) {

      if(!$window) { $window = static::wvm('@'); }

      if(method_exists($class, $method)){

          $onCall = self::wvm('onCall');

          if(array_key_exists($base, $onCall[CASTED::BASE])){
            if($onCall[CASTED::BASE][$base] instanceof \Closure){
              self::$wvm['onCallResponse'][CASTED::BASE][$base] = $onCall[CASTED::BASE][$base]();
            }
          }

          if(!$window) $window = $base;
        
          $win    = trim($window, '/ ');
          $winexp = explode('/', $win);
          $winexc = count($winexp); 

          $basexp = explode('/', trim($base, '/ '));

          $basex = implode('/', array_slice($basexp, 0, $winexc));
          
          if(substr($window, 0, 1) == '!'){
            $strict = true; //inverse strict
            $window = substr($window, 1, strlen($window));
          }else{
            $strict = false; //inverse strict
          }
          
          $nBasex = $basex;
          $nWin = $window;

          if($STRICT){

            if($strict){
              $nBasex = strtolower($basex);
              $nWin = strtolower($window);
            }
          
          }else{

            if(!$strict){
              $nBasex = strtolower($basex);
              $nWin = strtolower($window);
            }

          }

          if($nBasex == $nWin) {

            response(200, 'status ok');
            static::$isPended = !$close;
            static::$pender = static::$isPended? 'base' : '';
            static::$lastCall = $basex;
            if($ONCALL instanceof \Closure) $ONCALL();
            
            //call window
            $Container = new Container($instance);

            if($reflect->getMethod($method)->isStatic()){
              $Container::$method(...$arguments);
            } else {
              $Container->$method(...$arguments); 
            }       
            $instance->resolved(true);
          }

      }elseif(substr($method, 0, 4) == 'win:') { 
        
        $win    = trim($window, '/ ');
        $winexp = explode('/', $win);
        $winexc = count($winexp); 

        $basexp = explode('/', trim($base, '/ '));

        $basex = implode('/', array_slice($basexp, 0, $winexc));

        if(strtolower($win) == strtolower($basex)) {
    
          $class = substr($method, 4, strlen($method));

          $win = scheme.WIN.$class;         

          if(windowExists($class)){
            response(200, 'status ok');
            $instance->resolved(true);
            static::$isPended = false;
            static::$pender   = '';
            static::$lastCall = $basex;
            if($ONCALL instanceof \Closure) $ONCALL();

            //call window
            $Container = new Container($win, $arguments);

            return $instance->resolved();
          }
        }

      }elseif(is_object($method)) {
        
        $win    = trim($window, '/ ');
        $winexp = explode('/', $win);
        $winexc = count($winexp); 

        $basexp = explode('/', trim($base, '/ '));

        $basex = implode('/', array_slice($basexp, 0, $winexc));

        response(200, 'status ok');
        $instance->resolved(true);
        static::$isPended = false;
        static::$pender   = '';
        static::$lastCall = $basex;
        if($ONCALL instanceof \Closure) $ONCALL();

        //call window
        new Container($win, ...$arguments);

        return $instance->resolved();

      }

    } 
    
    if(array_key_exists(':404', $windows)){
      $method = $windows[':404'];
      if(method_exists($class, $method)){
                      
        $onCall = self::wvm('onCall');

        if(array_key_exists($base, $onCall[CASTED::E404])){
          if($onCall[CASTED::E404][$base] instanceof \Closure){
            self::$wvm['onCallResponse'][CASTED::BASE][$base] = $onCall[CASTED::E404][$base]();
          }
        }

        response(200, 'status ok');
        self::$lastCall = $base;
        self::$isPended = !$close;
        if($ONCALL instanceof \Closure) $ONCALL();

        //call window
        $Container = new Container($win, $variables);

        if($reflect->getMethod($method)->isStatic()){
          $Container::$method(...$arguments);
        } else {
          $Container->$method(...$arguments);
        }
        $instance->resolved(true);
        return $instance->resolved();
      }
      return ;
    }

    if($instance->resolved()) return true;
    if($close) self::close();

  }
  
  /**
   * Resolves a direct path that comes after a url's entry point (or window)
   *
   * @param Window $class
   * @param array $windows
   * @param bool $close 
   * 
   * @return void|bool
   */
  final protected static function pathcall(Window $instance, array $windows = [], bool $close = true){
    
    if($instance->resolved()) return;

    $path = static::wvm('path'); //root path

    $class = get_class($instance);
    if(method_exists($class,'loadRoutes')) $class::loadRoutes($instance);
    
    $reflect = new \ReflectionClass($class);

    self::windowShutterVariables($Request, $windows, $variables, $ONCALL, $arguments, $STRICT);
    
    static::integrateAPI();
    
    /* window as window's url */
    foreach($windows as $window => $method) {

      if(substr($window, 0, 1) == '!'){
        $strict = true; //inverse strict
        $window = substr($window, 1, strlen($window));
      }else{
        $strict = false; //inverse strict
      }
      
      $nPath = $path;
      $nWin = $window;

      if($STRICT){

        if($strict){
          $nPath = strtolower($path);
          $nWin = strtolower($window);
        }
        
      }else{

        if(!$strict){
          $nPath = strtolower($path);
          $nWin = strtolower($window);
        }

      }

      if($nPath == $nWin){

        if(method_exists($class, $method)){       
                      
          $onCall = self::wvm('onCall');

          if(array_key_exists($path, $onCall[CASTED::PATH])){
            if($onCall[CASTED::PATH][$path] instanceof \Closure){
              self::$wvm['onCallResponse'][CASTED::PATH][$path] = $onCall[CASTED::PATH][$path]();
            }
          }

          response(200, 'status ok');
          static::$isPended = !$close;
          self::$lastCall = $path; 
          if($ONCALL instanceof \Closure) $ONCALL();

          //call window
          if($reflect->getMethod($method)->isStatic()){ 
            (new Container($class))::$method(...$arguments);
          } else {
            $Container = new Container($instance);
            $Container->$method(...$arguments);
          }

          $instance->resolved(true);
          return $instance->resolved();

        }elseif(substr($method, 0, 4) == 'win:') {

          $class = substr($method, 4, strlen($method));
          $win   = scheme.WIN.$class;
    
          if(windowExists($class)){ 
            response(200, 'status ok');
            $instance->resolved(true);
            static::$isPended = false;
            self::$lastCall = $path;
            if($ONCALL instanceof \Closure) $ONCALL();
            
            //call window
            $Container = new Container($win, ...$arguments);

            return $instance->resolved();
          }
        }elseif(is_object($method)){
            response(200, 'status ok');
            $instance->resolved(true);
            static::$isPended = false;
            self::$lastCall = $path;
            if($ONCALL instanceof \Closure) $ONCALL();
            $Container = new Container($method, ...$arguments);
            // new $method(...$arguments);
            return $instance->resolved();
        }

      }

    } 

    if(array_key_exists(':404', $windows)){
      $method = $windows[':404'];
      if(method_exists($class, $method)){
                      
        $onCall = self::wvm('onCall');

        if(array_key_exists($path, $onCall[CASTED::E404])){
          if($onCall[CASTED::E404][$path] instanceof \Closure){
            self::$wvm['onCallResponse'][CASTED::PATH][$path] = $onCall[CASTED::E404][$path]();
          }
        }
        
        response(200, 'status ok');
        static::$isPended = !$close;
        self::$lastCall = $path;
        if($ONCALL instanceof \Closure) $ONCALL();

        //call window
        if($reflect->getMethod($method)->isStatic()){
          $Container = new Container($class);
          $Container::$method(...$arguments);
        } else {
          $Container = new Container($instance);
          $Container->$method(...$arguments);
        }
        $instance->resolved(true);
        return $instance->resolved();
      }
      return;
    }

    if($instance->resolved()) return true;

    if($close) self::close();

  } 

  final public function resolved(bool $bool = false){
    if(func_num_args() > 0) $this->resolved = $bool;
    return $this->resolved;
  }

  /**
   * Resets the resolved marker. This should be used to run on shutter methods.
   *
   * @param \Closure|null $callback
   * @return boolean
   */
  final public function clearResolved(\Closure $callback = null) : bool {
      $this->resolved(false);
      if($callback instanceof \Closure)  return $callback();
      return false;
  } 

  private static function onOpen($path = '') {

    if($path) static::loadBase($path);
    $path = scheme(static::folder.'\\'.ucfirst(static::wvm('root')), false);

    if(@class_exists($path)){ 
      http_response_code(200);
      $path::protect();
      echo (new $path(new Request)) ; 
      if(!static::wvm('close')) return;
    } 
    
    if(@class_exists(static::Server)){
      http_response_code(200); //default response
      $index = (static::Server);
      new $index;
      if(!static::wvm('close')) return;
    }
    
    static::close();
    
  }  

  /**
   * Set a session & cookie keys for the session class
   *
   * @return array
   */
  final protected static function session() : array {

    //* Default Session and Cookie name
    return ['user', 'cookie'];

  } 

  public function __toString(){
    return static::wvm('page')? '' : ' ';
  }

  final static public function lastCall() : string {
    return static::$lastCall;
  }
  
  /**
   * Pend the closing of a window
   */
  final protected static function pend(bool $bool = true) {
    self::wvm('pend', $bool);
  } 
  
  /**
   * Close a window
   *
   * @param boolean $bool true forces close and stops any pending
   * @return void
   */
  final public static function close(bool $bool = false) {
    
    if($bool) self::wvm('pend', false);

    $argsc = func_num_args();
    $argss = func_get_args();

    if(self::wvm('pend') && ($argsc > 0) && ($argss[0] === true) ) {
      self::wvm('pend', false);
      self::wvm('close', false);
    } 
    
    if(self::wvm('pend') && ($argsc == 0)) return;

    if(self::wvm('close')) return;
    static::wvm('close', true);

    //set and return and array of response header
    $response = response(404, 'Page not found!');

    if(!static::$winAPI) {
      Rex::load(static::wvm(':404'), fn() => compile());
    } else{
      echo $response; /* print response header */
    }

    exit();

  }
  
  /**
   * set a new 404 error template file
   *
   * @param string $view rsc(resource) file path
   * @return void
   */
  final protected function eview($view = '') {
    if($view == '404') $view = 'error';
    static::wvm('error', $view);
    return $this;
  }

  /**
   * This method enforces window to add a non-existing rex file when the "load" method is used.
   *
   * @param string $template_path
   * @return void
   */
  final protected static function addRex(string $template_path = ''){
    Compiler::addRex(...func_get_args());
  }

  /**
   * Renders and Outputs the rex template files
   * 
   * @param string $path rex template path
   * @param mixed $callback template handler function
   * @return void
   */
  final protected static function load($path, $callback){
    Rex::load($path, $callback);
  }

  /**
   * Rex view function
   *
   * @param string $url
   * @param array|Closure|false|string $callback
   * @param array $args arguments
   * @return void
   */
  final protected static function view(string $url, array|Closure|false|string $callback = false, array $args = []) {
    
    if(func_num_args() > 2){
      echo Rex::view(...func_get_args())->setArgs($args);
    }else{
      echo Rex::view(...func_get_args());
    }
  }


  /**
   * Renders and Returns the rex template files
   * @param string $url res template url
   * @param mixed $callback template handler function
   * @return string
   */
  final protected static function markup($url, $callback){
    return Rex::markup(...func_get_args());
  }  

  /**
   * Parses / Splits a url to a predifined structure recognized by wmv pattern
   * If no url is supplied, the default uri constant is assumed
   *
   * @param string $url
   * @return void
   */
  final public static function loadBase($url = '') {
    
    $uri = (!$url)? uri : $url ;
    $uri = strtok($uri, '?');

    if(!online){
    $base = explode('/', rtrim(ltrim($uri, '/'),'/ ') , 2)[1]?? '';

    $path = explode('/', $base , 2)[1]?? '';   
    $open = explode('/', ltrim($base, '/') , 2)[0]?? '';       
    }else{ 
    $base = rtrim(ltrim($uri, '/'), '/ ');
    $path = explode('/', $base , 2)[1]?? '';   
    $open = explode('/', rtrim(ltrim($uri, '/'),'/ ') , 2)[0]?? '';  
  
    }

    if(!isset($_SERVER['SERVER_ADMIN'])){
    $base = rtrim(ltrim($_SERVER['PATH_INFO']?? 'index', '/'),'/ ');
    $path = explode('/', $base , 2)[0]?? '';   
    $open = explode('/', ltrim($base, '/') , 2)[0]?? ''; 
    }

    $mappers = [
      'window' => $open,
      'root' => $open,
      'base' => $base,
      'path' => $path
    ];

    static::$wvm = array_merge(static::$wvm, $mappers);

    //Set Error Default Directory
    $errorDir = docroot.'/windows/Rex/errors/';

    //Set 404 rex file at window initialization
    $rex404 = static::wvm(':404');
    if( ($rex404 === 'errors.e-404') || ($rex404 === 'errors.404') ){
      if(file_exists($errorDir.'e-404.rex.php')){
      $e404_file = 'errors.e-404';
      }elseif(file_exists($errorDir.'404.rex.php')){
      $e404_file = 'errors.404';
      }else{
      $e404_file = '::404';
    }
    static::wvm(':404',$e404_file);
    }

    //Set Csrf error rex file at window initialization
    $rexCsrf404 = static::wvm(':csrf');
    if( $rexCsrf404 === 'errors.e-csrf' ){
      if(!file_exists($errorDir.'e-csrf.rex.php')){  
      static::wvm(':csrf','::csrf');
      }
    }
    
  }
  

  final protected static function secure($route, $session = ''){
    $session = strtoupper($session);
    static::$wvm['secure'][$session][] = $route;
  }

  /**
   * Sleep live server during error display
   * Notice:: this will send a success response header
   * 
   * @return void
   */
  final protected static function sleep() {
      http_response_code(200); 
      Res::live();
      self::close();
  }

  /**
   * Automatically Re-binds route-to-route referred form data into accessible environment key. 
   * This data is pushed into enviroment key when 
   * Window::pushFormData() is called.
   * 
   * @return void
   */
  final protected static function bindFormData(){
    
    if(Session::base()->has(':FORM')){

      //fetch method 
      $FORM = Session::base()->value(':FORM');
      $method = $FORM['METHOD'];

      $_SERVER['REQUEST_METHOD'] = $method;
      
      //reference request data 
      if($method == 'POST'){
          $method = &$_POST;
      }elseif($method == 'GET'){
          $method = &$_GET;
      }        
      
      //reference request files
      $files  = &$_FILES;
      
      $formURI = $FORM['URI'];

      if($formURI != $_SERVER['REQUEST_URI']){
          $method = $FORM['DATA'];
          $files  = $FORM['FILES'];
      }

      //set 
      $_ENV[':FORM']['CSRF_REF'] = $FORM['CSRF_REF'];
      Session::base()->remove(':FORM');
    }
  }

  /**
   * This method is to push requested form data through an eternal route
   * back to the current route using an automatic redirection.
   *
   * @return void
   */
  final protected static function pushFormData(){
    if(isset($_SERVER['HTTP_REFERER'])){ 
      if($_SERVER['HTTP_REFERER'] != $_SERVER['REQUEST_URI']){
        $data = $_SERVER['REQUEST_METHOD'] == 'POST'? $_POST : $_GET;
        $file = $_FILES ?? [];

        //redirect action
        $action = $data[':form-action']?? '';
        $ref    = dirname(rtrim($_SERVER['HTTP_REFERER'], '/'));
        
        if($action){
          $action = $ref.'/'.$action;
        }else{
          $action = $_SERVER['HTTP_REFERER'];
        }

        $csrfSent = $data['CSRF_TOKEN'] ?? '';
        $csrfSess   = Session::base()->value('CSRF','TOKEN');

        $Request = new Request;

        $data = $Request->data();

        $CSRF_VALID = ($csrfSent && ($csrfSent === $csrfSess));
        $CSRF_TIME  = Session::base()->value('CSRF','TIME');

        $formdata['DATA']   = $data;
        $formdata['FILES']  = $file;
        $formdata['METHOD'] = $_SERVER['REQUEST_METHOD'];
        $formdata['URI']    = $_SERVER['REQUEST_URI'];
        $formdata['CSRF_REF'] = [
          'VALID'  => $CSRF_VALID, 
          'valid'  => $CSRF_VALID,
          'isValid'=> $CSRF_VALID,
          'time'   => $CSRF_TIME,
          'TIME'   => $CSRF_TIME,
        ];

        Session::base()->save(':FORM', $formdata);

        redirect($action);
      }
    }
  }

  /** This method is used for project application's caliberation */
  final static public function htcaliber($Server){
    $loader = (method_exists($Server, 'loader'))? $Server::loader() : '';
    if(self::isIndex()) htCaliber(true, $loader);  
  }

  /**
   * Set shutter variables
   *
   * @param [type] $STRICT
   * @return void
   */
  private static function windowShutterVariables(&$Request, &$windows, &$variables, &$ONCALL, &$arguments, &$STRICT){
    
    $Request = new Request;

    $arguments = [];
    
    $variables = $windows[SELF::ARG] ?? static::$variables;

    $ONCALL = $windows[SELF::ONCALL] ?? '';
    
    if($variables || isset($windows[SELF::ARG]) || isset(static::$variables)) {
      array_unshift($arguments, $variables);   
    }
    
    unset($windows[SELF::ARG], $windows[SELF::ONCALL]);

    $STRICT = $windows[SELF::STRICT] ?? false;

    unset($windows[SELF::ARG], $windows[SELF::ONCALL], $windows[SELF::STRICT]);

  }

  function __destruct()
  {
    $session = Session::base()->value();
    if(isset($session[Notice::FLASH_KEY])) {
        Session::base()->remove(Notice::FLASH_KEY);
    }
  }

}