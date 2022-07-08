<?php
 
 use spoova\core\classes\Controller; 
 use spoova\core\classes\Request;
 use spoova\core\classes\UrlMapper;

/**
 * Controls view from windows frame
 * 
 * :Reserved Methods:
 * 
 * __contruct, channel, onOpen, loadBase,
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

        #url error - 404 error rsc file
        'error' => '404',

        #protect methods
        'protect' => [], //['class' => 'method']
        
        #variables
        'variables' => [],

        #authentications
        'secure' => ['GUEST' => [], 'AUTH' => []],
        
        #close window
        'close' => false, 
        
        #pend close window
        'pend' => false,

    ];

    private const folder = 'spoova\windows';
    private const Index  = self::folder.'\Index'; 
    
    #resolved classes
    protected $resolved = false;
    
    #inherent local variables
    protected static $variables = [];

    /**
     * privatize the Window's instance
     */
    private function __construct() {} 

    /**
     * Set or Fetches wvm windows paramters
     *
     * @param string $key wvm key to be set or fetched
     * @param string $value respective value to be set
     * @return array|string
     */
    public static function wvm(string $key = null, $value = null){
      if($key == '404') $key = 'error';
      if(func_num_args() == 0) return static::$wvm;
      if(func_num_args() == 1) return static::$wvm[$key]?? false;
      
      if(func_num_args() > 1) {
          if(static::$wvm ?? false) static::$wvm[$key] = $value; 
      }

    }
   
    /**
     * Open a new path
     *
     * @param string $path a new url path to be processed
     * @return void
     */
    public static function open($path = ''){
      static::loadBase($path);        
      static::onOpen($path);
    }

    /**
     * Converts a supplied url path to clickable splits
     *
     * @param string $url url to be mapped
     * @param string $separator url separator element
     * @return void
     */
    protected static function mapurl(string $url, string $separator = '/'){
      $urlmap = new UrlMapper;

      $base = DomUrl();
      $urlmap->setbase(DomUrl('/'));
      return $urlmap->map($url, $separator);
    }
   
    /**
     * Add a new channel from within windows
     *
     * @param string $channel
     * @return void
     */
    protected static function channel($channel){
        channel($channel);
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
    protected static function rootcall(Window $instance, array $windows = [], $close = true, bool $reclose = true){               
      
      if($instance->resolved()) return;

      $path = static::wvm('root'); //root path
      $class = get_class($instance);
      $reflect = new \ReflectionClass($class);
      
      $variables = is_array($close)? $close : self::$variables;
      
      //reset $close on extended arguments
      if(func_num_args() > 3) $close = $reclose;

      if($path == '') $path = 'index'; 
      /* window as window's url */
      foreach($windows as $window => $method) {

        if((strtolower($path) == strtolower($window)) && method_exists($class, $method)){
          if($reflect->getMethod($method)->isStatic()){
            $instance->resolved(true);
            call_user_func_array([$class, $method], $variables);
          } else {
            $instance->resolved(true);
            $instance->$method($variables);
          }
          return $instance->resolved();
        }

      } 

      if(array_key_exists(':404', $windows)){
        $method = $windows[':404'];
        if(method_exists($class, $method)){
          if($reflect->getMethod($method)->isStatic()){
            $instance->resolved(true);
            call_user_func_array([$class, $method], $variables);
          } else {
            $instance->resolved(true);
            $instance->$method($variables);
          }
        }
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
     * @param bool|array $close 
     *    (array) => as variables
     *    (bool) =>  close window 
     * 
     * @param bool $reclose close window when $close is array
     * 
     * @return void
     */
    protected static function call(Window $instance, array $windows = [], bool $close = true, bool $reclose = true){
      
      if($instance->resolved()) return;

      $base = static::wvm('base'); //root path
      $class = get_class($instance);
      $reflect = new \ReflectionClass($class);
      
      $variables = is_array($close)? $close : self::$variables;
      
      //reset $close on extended arguments
      if(func_num_args() > 3) $close = $reclose;

      if($base == '') $base = 'index'; 
      /* window as window's url */
      foreach($windows as $window => $method) {
        if((strtolower($base) == strtolower($window)) && method_exists($class, $method)){
          if($reflect->getMethod($method)->isStatic()){ 
            $instance->resolved(true);
            call_user_func_array([$class, $method], $variables);
          } else {
            $instance->resolved(true);
            $instance->$method($variables);
          }
          return $instance->resolved();
        }

      } 

      if(array_key_exists(':404', $windows)){
        $method = $windows[':404'];
        if(method_exists($class, $method)){
          if($reflect->getMethod($method)->isStatic()){
            $instance->resolved(true);
            call_user_func_array([$class, $method], $variables);
          } else {
            $instance->resolved(true);
            $instance->$method($variables);
          }
          return $instance->resolved();
        }
        return;
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
     * @param bool|array $close 
     *    (array) => as variables
     *    (bool) =>  close window 
     * 
     * @param bool $reclose close window when $close is array
     * 
     * @return void
     */
    protected static function basecall(Window $instance, array $windows = [], $close = true, bool $reclose = true){

      if($instance->resolved()) return;

      $base = static::wvm('base');

      $class = get_class($instance);
      $reflect = new \ReflectionClass($class);
      
      $variables = is_array($close)? $close : self::$variables;
      
      //reset $close on extended arguments
      if(func_num_args() > 3) $close = $reclose;
      
      foreach($windows as $window => $method) {

        if(method_exists($class, $method)){
          
            $win    = trim($window, '/ ');
            $winexp = explode('/', $win);
            $winexc = count($winexp); 

            $basexp = explode('/', trim($base, '/ '));

            $basex = implode('/', array_slice($basexp, 0, $winexc));
            if(strtolower($win) == strtolower($basex)) {
              if($reflect->getMethod($method)->isStatic()){
                  $instance->resolved(true);
                  call_user_func_array([$class, $method], $variables);
              } else {
                $instance->resolved(true);
                $instance->$method($variables); 
              }       
            }
        }

      } 

      if($instance->resolved()) return true;
      if($close) self::close();

    }
   
    /**
     * Resolves a direct path that comes after a windows' url
     *
     * @param Window $class
     * @param array $windows
     * @param array|bool|int $close 
     *    (array) => as variables
     *    (bool) =>  close window 
     * 
     * @return void
     */
    protected static function pathcall(Window $instance, array $windows = [], $close = true, bool $reclose = true){
      
      if($instance->resolved()) return;

      $path = static::wvm('path'); //root path

      $class = get_class($instance);
      $reflect = new \ReflectionClass($class);
      
      $variables = is_array($close)? $close : self::$variables;
      
      //reset $close on extended arguments
      if(func_num_args() > 3) $close = $reclose;
      
      /* window as window's url */
      foreach($windows as $window => $method) {
        
        if((strtolower($path) == strtolower($window)) && method_exists($class, $method)){
          if($reflect->getMethod($method)->isStatic()){ 
            $instance->resolved(true); 
            call_user_func_array([$class, $method], $variables);
          } else {
            $instance->resolved(true);
            $instance->$method($variables);
          }
          return $instance->resolved();
        }
      } 

      if(array_key_exists(':404', $windows)){
        $method = $windows[':404'];
        if(method_exists($class, $method)){
          if($reflect->getMethod($method)->isStatic()){
            $instance->resolved(true);
            call_user_func_array([$class, $method], $variables);
          } else {
            $instance->resolved(true);
            $instance->$method($variables);
          }
          return $instance->resolved();
        }
        return;
      }

      if($instance->resolved()) return true;

      if($close) self::close();

    } 

    public function resolved(bool $bool = false){
      if(func_num_args() > 0) $this->resolved = $bool;
      return $this->resolved;
    }

    private static function onOpen($path = '') {

      if($path) static::loadBase($path);
      $path = static::folder.'\\'.ucfirst(static::wvm('root'));
      
      if(@class_exists($path)){ 
        http_response_code(200);
        $path::protect();
        print (new $path(new Request)) ; 
        if(!static::wvm('close')) return;
      } 
      
      if(@class_exists(static::Index)){
        http_response_code(200); //default response
        if(method_exists(static::Index, 'usedoor')){
          (static::Index)::usedoor(new Request); 
          if(!static::wvm('close')) return;
        }
      }
      
      static::close();
      
    }

    /**
     * To add a protection layer to urls
     *
     * @todo Add a protection to urls
     * @param Window|null $Window
     * @param string $method
     * @return void
     */
    protected static function protect(Window $Window = null, $method = null) {
        
        $argsC = func_num_args();

        if($Window){
          $basename = (basename(get_class($Window))); 
          // if($argsC == 1 && !isUser() && ) redirect(Window::home);        
        }

    }
   

    public function __toString(){
      return static::wvm('page')? '' : ' ';
    }
   
    /**
     * Pend the closing of a window
     */
    protected static function pend(bool $bool = true) {
      self::wvm('pend', $bool);
    } 
   
    /**
     * Close a window
     *
     * @param boolean $bool force close
     * @return void
     */
    protected static function close(bool $bool = false) {
      
      if($bool) self::wvm('pend', false);

      if(self::wvm('pend')
          && (func_num_args() > 0)
          && (func_get_args()[0] === true)
          ) {
            self::wvm('pend', false);
            self::wvm('close', false);
      } 
      
      if(self::wvm('pend') && 
          (func_num_args() == 0)
        )
        {
            return;
      } 
      
      if(self::wvm('close')) return;
      static::wvm('close', true);
      Res::load(static::wvm('error'), fn() => compile());
      exit();
    }
   
    /**
     * set a new 404 error template file
     *
     * @param string $view rsc(resource) file path
     * @return void
     */
    protected function eview($view = '') {
      if($view == '404') $view = 'error';
      static::wvm('error', $view);
      return $this;
    }
   
    /**
     * Renders and Outputs the rex template files
     * 
     * @param string $url rex template url
     * @param mixed $callback template handler function
     * @return void
     */
    protected static function load($url, $callback){
      Res::load(...func_get_args());
    }

    /**
     * Renders and Returns the rex template files
     * @param string $url res template url
     * @param mixed $callback template handler function
     * @return string
     */
    protected static function markup($url, $callback){
      return Res::markup(...func_get_args());
    }  

    /**
     * Parses / Splits a url to a predifined structure recognized by wmv pattern
     *
     * @param string $url
     * @return void
     */
    public static function loadBase($url = '') {
     $uri  = (!$url)? uri : $url ;

     if(!online){
      $base = explode('/', rtrim(ltrim(uri, '/'),'/ ') , 2)[1]?? '';
      $path = explode('/', $base , 2)[1]?? '';   
      $open = explode('/', ltrim($base, '/') , 2)[0]?? '';       
     }else{
      $base = explode('/', rtrim(ltrim(uri, '/'),'/ ') , 2)[0]?? '';
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
     
    }
   
    protected static function secure($route, $session = ''){
      $session = strtoupper($session);
      static::$wvm['secure'][$session][] = $route;
    }

    /**
     * Sleep live server during error display
     * Notice:: this will send a success response header
     * 
     * @return void
     */
    protected static function sleep() {
        http_response_code(200); 
        \Res::live();
        self::close();
    }
   
 }   