<?php

use spoova\core\classes\Resin;
use spoova\core\classes\Notice;
use spoova\core\classes\Router;
use spoova\core\classes\Slicer;
use spoova\core\classes\Request;
use spoova\core\classes\Resource;
use spoova\core\classes\Application;

/**
 * This class is an extension of Resource class
 * The main Resource class is loaded from this extension
 * Absence of this file will break your application
 * */
final class Res extends Resource implements Resin{

    private static ?Res $self = null;
    private static $body;
    private static $compile;
    private static $compilebody = '';
    private static $inload;
    private static ?Router $router = null;
    private static ?Application $app = null;
    private static $parse;
    private static $method;
    
    /**
     * store local varibles for use
     */
    public static array $locals = [];

    /**
     * initialize notice with Res Instance
     * 
     * @return void
     */
    public function __construct(){
      parent::__construct();
      self::$notice = self::notice();
      self::$locals = [];
    }

    /**
     * Load the init configuration file
     *
     * @return void
     */
    private static function init(){
        self::freeVars();
        Res::noheaders();      
    }

    /**
     * Start a live server
     *
     * @param string $param options
     * @return void
     */
    public static function live($param = '::watch'){
      parent::live($param);
    }  


    /**
     * Returns the instace of application
     * Note: Application handles router
     *
     * @return @core\classes\router
     */
    public static function router(){
      return self::app(...func_get_args());
    }
    
    /**
     * Initializes the application class and 
     * returns router class
     *
     * @return \core\classes\router
     */
    public static function app(){
      
        self::init();
        if(!self::$router instanceof Router){
          self::$app = new Application(...func_get_args());
          self::$router = self::$app->router(); 
          self::$notice = self::$app->notice();    
        }
        self::$call_scope = 'router';
        return self::$router;
    }

    /**
     * creates an instance of the notice class
     *
     * @return \core\classes\notice
     */
    public static function notice(){
      return (new Notice());
    }

   /**
    * Renders and Outputs the res template files

    * @param string $url res template url
    * @param array|string|\Closure $callback template handler function
    * @return void
    */
    public static function load($url = '', $callback = ''){
        self::init();       
        self::$inload = true;    
        return self::engine(...func_get_args());   
    }

    /**
     * Renders the res templates files using the get method
     *
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return void
     */
    public static function gett($url = '', $callback = ''){
      self::freeVars();
      self::$method = 'get';
      self::load(...func_get_args());
    }
    
    /**
     * Renders the res templates files using the post method
     *
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return void
     */
    public static function postt($url = '', $callback = ''){
      self::freeVars();
      self::$method = 'post';
      self::load(...func_get_args());
    } 

    /**
     * Router get method
     * 
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return void
     */
    public static function get($url = '', $callback = ''){
      self::app();
      self::$method = 'get';
      $router = self::$router;
      $router->get(...func_get_args());
      return self::loadRoute($router);
    }

    /**
     * Router post method
     * 
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return void     *    parameter 1 (string)         => file name in the rex folder
     *    parameter 2 (string|closure) => string or callback function 
     *
     * @return string routed component
     */
    public static function post($url = '', $callback = ''){

      self::app();
      self::$method = 'post';
      $router = self::$router;
      $router->post(...func_get_args());
      return self::loadRoute($router);

    }

    /**
     * This method returns a rendered component
     *
     * @param boolean $view
     * @return void
     */
    public function view($view = true){

      if($view) echo self::$router->data();
      self::freeVars();
      return;
  
    }

   /**
    * Process and Returns the rex template files

    * @param string $url res template url
    * @param mixed $callback template handler function
    * @return string
    */
    public static function markup($url, $callback){
            
        self::$inload = true;
        self::$parse = true;
        $result = self::engine(...func_get_args());
        self::$parse = false;
        self::$inload = false;
        return $result;
    }

   /**
    * Renders the res template files

    * @param string $url res template file url
    * @param mixed $callback res template handler function
    * @return void
    */
    private static function engine($url, $callback){ 

      // //set call scope if first argument is instance of router
      if((func_get_args()[0]?? false) instanceof Router){
        self::$call_scope = 'router';
        return;
      }

      //process arguments if first argument is not instance of router
      self::$call_scope = 'res';

      $args = func_get_args();
      $num_args = func_num_args();

      if(empty($num_args)){ 
        $xbody = self::$body;
        self::$body = '';
        self::$compile = '';
        self::$compilebody = '';
        self::$inload = '';
        if(self::$parse) return $xbody;
        print $xbody;
        return ''; 
      } 

      $isCompile = false;
      
      // //process only if is not in router scope
      if(!self::isRouter()){
        
        //sort file supplied
        $url = $args[0];
        //Slicer::sort_url($url, $sorted, $id); //do this later

        $file = $fileUrl = docroot.DS.scheme.$args[0];
        
        // $file1 = rtrim($file,'.html').'.rex.html';
        // $file2 = rtrim($file,'.php').'.rex.php';
        
        // $file = is_file($file2)? $file2 : $file1;

        $file = Slicer::sliceUrl($fileUrl);

        if(!is_file($file)) {
          trigger_error($file.' does not exists. Ensure your template file is of php or html extension within the rex folder'); 
          return false;
        }

        //process a second argument if it exists
        if($num_args > 1){
          $string  = $args[1];

          //test string
          if($string instanceof \Closure || (is_array($string))) {
            if(is_array($string)){
              if($string[0]?? false){
                $string[0] = new $string[0];
              }else{
                trigger_error('array must contain at least 1 callback');
                return;
              }
            }

            $Request = new Request;
            $string = call_user_func($string, $Request);
            if($string and self::$compile) {
              $string = self::$compilebody;
              $template = Slicer::loadTemplate($file, self::$locals);
            }else{
              $template = '';
            }
            Slicer::setLocals(self::$locals);
          }
        } else {
          $template = Slicer::loadTemplate($file, self::$locals);
        }
        
        $string  = $string?? '';
        $template = $string.$template;
      }

     
      //run process for routers and not routers
      if($template?? false){
    
        //run the slice Tool
        $body = Slicer::slice($template)->data(); 

        self::$body = $body;

      }
  
      if(self::$parse) return self::$body;
      // echo self::$body; --replaced with eval+
    
      foreach(self::$locals as $locals => $value){
        $$locals = $value;
      }
      //vdump(self::$body);
      eval(' ?>'.self::$body.'<?php ');

    } 

    //resolve routing if method is validated and run by Router
    private static function loadRoute(Router $router){
      
      //prevent the use of view outside load scope

      self::$inload = false;
      //resolve only if method was set (i.e has not been previously declared)
      if($router->methodset()){

          self::$body = $router->resolve();
          return self::loadView();
        
      }

    }

    private static function loadView(){
      
      //set the self if not already set
      if(!self::$self){ self::$self = new self; }

      if(self::isView()){
        //print self::$body;        
      }else{
        $self = self::$self;
        if(self::$body !== false) return $self;   
      }    

    }    


    private static function freeVars(){

      $ref = new ReflectionClass(__CLASS__);
      $props = $ref->getProperties();
      $exc = ['router','app', 'self','notice', 'off', 'use_watch','watched','initAutoload', 'noheaders','initialized_watch','locals'];
      
      foreach($props as $prop){
          $key = $prop->getName();
          if(!in_array($key, $exc)){
            self::$$key = '';               
          }
      }

    }

    public static function endVars(){
      self::freeVars();
    }

    static function setView($view = true){
      if(!self::isRouter()){ 
        trigger_error('view should be used within resource or route scope');
        return false;
      }
      if($view === false) {
        self::$viewType = '';
        return false;
      }
      if(!self::$viewType) self::$viewType = 'view';
    }

    /**
     * compile strings for unrouted files
     *
     * @param string|array $arg1 body or arguments
     * @param array|string $arg2 arguments or body
     * @return void
     */
    static function compile($arg1 = '', $arg2 = ''){      
      
      if(is_array($arg1) and is_array($arg2)){
        trigger_error("compile can only have a single array as first or second argument");
        return false;
      }

      if(is_string($arg1)){ 
        $body = $arg1;        
        if(func_num_args() > 1 and !is_array($arg2)){
           trigger_error("Both arguments of compile cannot be null or array. One must be a string, while the other an array.");
           return;
        }
        $locals = (array) $arg2;
      } else {
        $body = $arg2;
        if(!is_array($arg1)){
           trigger_error("Both arguments of compile cannot be null or array. One must be a string, while the other an array.");
           return ;
        }
        $locals = (array) $arg1;
      }

      self::$viewType = (!self::$viewType)? 'compile' : self::$viewType;

      if(!self::$inload){
        trigger_error(self::$viewType.' should be used within resource or route scope');
        return false;
      }

      self::$compile = 1;
      self::$compilebody = $body;

      $compileLocals = [];

      foreach ($locals as $key => $value) {
        $compileLocals[$key] = $value;
      }
    
      self::$locals = $compileLocals;

      //keep to use later -not working
      foreach (self::$locals as $key => $value) {
        $$key = $value;
      }   

      $var = print(Res::$body) ;
      return $var;

    }

}


