<?php

use spoova\core\classes\EInfo;
use spoova\core\classes\Resin;
use spoova\core\classes\Notice;
use spoova\core\classes\Router;
use spoova\core\classes\Slicer;
use spoova\core\classes\Request;
use spoova\core\classes\Resource;
use spoova\core\classes\Application;
use spoova\core\classes\FileManager;

/**
 * This class is an extension of Resource class
 * The main Resource class is loaded from this extension
 * @Warning: Absence of this file can break your application
 */
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
     * This defines that a rex file should be created if it does not exist. 
     * String argument should be an existing rex file that should be imported through the template directive.
     *
     * @var boolean|string
     */
    private static bool|string $addRex = false;
    
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
     * Start a live server extension
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
    * @return string
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
     * @return string
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
     *  -If string is supplied, it must be a valid rex file that will be rendered into request url
     *  -If Closure or array is supplied,  
     * @return Res|void
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
     * @return void     
     *    parameter 1 (string)         => file name in the rex folder
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
  
    }

   /**
    * Process and Returns the rex template files

    * @param string $url res template url
    * @param mixed $callback template handler function
    * @return string
    */
    public static function markup($url, $callback) : string|false {
            
        self::$inload = true;
        self::$parse = true;
        $result = self::engine(...func_get_args());
        self::$parse = false;
        self::$inload = false;
        return $result;
    }


    /**
     * Defines that a rex file should be created if it does not exist
     *
     * @param boolean $add
     * @return void
     */
    public static function addRex(bool|string $add = true){
      self::$addRex = $add;
    }

   /**
    * Renders the res template files

    * @param string $url res template file url
    * @param mixed $callback res template handler function
    * @return string
    */
    private static function engine($url, $callback) : string|false { 

      // //set call scope if first argument is instance of router
      if((func_get_args()[0]?? false) instanceof Router){
        self::$call_scope = 'router';
        return '';
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

      $isCompile = false; //compile marker

      $template  = ''; //template item
      
      //process only if not in router scope
      if(!self::isRouter()){

        //sort file supplied
        $url = $args[0];

        //Slicer::sort_url($url, $sorted, $id); //do this later

        $reserved = ['::404', '::csrf'];

        $isScreen = ((substr($url, 0, 2) == '::') && !in_array($url, $reserved));
 
        if($isScreen){
          $url = substr($url, 2, strlen($url));
        }

        $escape = false;
        $rexpath = rtrim($url,'/');
        $rexpath = str_replace('.','/', $rexpath);
        
        if(strpos($url, docroot, 0) === false){        
          $file = $fileUrl = docroot.DS.WIN_REX.$rexpath;
        }else{
          $file = $fileUrl = $url; $escape = true;
          $rexpath = explode(docroot, rtrim($file, '.rex.php'), 2)[1];
        }

        if($rexpath == '::404'){
          $data = file_get_contents(E_404.'.rex.php');
          $template = Slicer::slice($data)->data();
          $fileUrl = E_404;
          $rexpath = 'errors/e-404';
        }elseif($rexpath == '::csrf'){
          $data = file_get_contents(E_CSRF.'.rex.php');
          $template = Slicer::slice($data)->data();
          $fileUrl = E_CSRF;
          $rexpath = 'errors/e-csrf';          
        }
        
        $file = !$escape? Slicer::sliceUrl($fileUrl): $file;

        if(!$isScreen && !is_file($file)) {
          $addRex = self::$addRex;
          if($addRex){
            //create rex file... 
            $Filemanager = new FileManager;
            if($Filemanager->openFile(true, $file)){
                
              if(is_string($addRex) && is_file(docroot.'/windows/Rex/'.to_frontslash($addRex, true).".rex.php") ) {          
                
                  $template = <<<Template
                    @template('$addRex')
    
                    @template;
                  Template;
  
              }  else {

                $template = "@live";

              }   
              
              file_put_contents($file, $template);
            }
            monitor();
          }
          return EInfo::view('Template file: <i><u>'.Slicer::sliceUrl($rexpath).'</u></i> does not exists. Ensure your template file is of php extension within "rex" directory');
        }

        if($num_args > 1){
          
          //process a second argument if it exists

          $string  = $args[1];

          //test string
          if($string instanceof \Closure || (is_array($string))) {
            
            if(is_array($string)){
              if($string[0]?? false){
                $string[0] = new $string[0];
              }else{
                trigger_error( 'array must contain at least 1 callback' );
                return '';
              }
            }

            $Request = new Request;
            $string = call_user_func($string, $Request);
            
            if($isScreen && self::$compile){
              return EInfo::view('invalid compile() function called on screen view');
            }

            if($string and self::$compile) {
              $string = self::$compilebody;
              if(!$isScreen) $template = Slicer::loadTemplate($file, self::$locals);
            }

            Slicer::setLocals(self::$locals);
          }
        } else {
          if(!$isScreen) $template = Slicer::loadTemplate($file, self::$locals);
        }
        
        $string  = $string?? '';
        $template = $string.$template;
      }
 
      if($template?? false){

        //run the slice Tool  
        $body = Slicer::slice($template)->data(true);    

        self::$body = $body;

      }

      if(self::$parse) return self::$body;
    
      foreach(self::$locals as $locals => $value){
        $$locals = $value;
      }

      $content = self::$body;

      //create path in storage folder
      $Filemanager = new FileManager;
      $realFile    = docroot.'/core/storage/'.$rexpath.'.php';

      if($Filemanager->openFile(true, $realFile)){
  
            //get lastmodified of $path;
            if(file_exists($realFile)){
              
              //get contents of real file
              $realcontents = file_get_contents($realFile);

              clearstatcache(true, $realFile);

              if($realcontents !== $content){

                file_put_contents($realFile, $content);

              }
                
              ob_start();
              include($realFile);
              $content = ob_get_clean();
              print $content;

            }
  
        }
        return '';
    } 

    /**
     * Resolves routing if method is validated and run by Router
     *
     * @param Router $router
     * @return Res|void
     */
    private static function loadRoute(Router $router){ 
      
      //prevent the use of view outside load scope

      self::$inload = false;
      
      //resolve only if request url has not been 
       // previously set on defined request method.
      if($router->methodset()){

          self::$body = $router->resolve();
          return self::loadView();
        
      }

    }

    /**
     * Restrict method to "view" scope
     *
     * @return Res|void
     */
    private static function loadView(){
      
      //set the self if not already set
      if(!self::$self){ self::$self = new self; }

      if(!self::isView()){
        $self = self::$self;
        if(self::$body !== false) return $self;   
      }

    }    


    private static function freeVars(){

      $ref = new ReflectionClass(__CLASS__);
      $props = $ref->getProperties();
      $exc = ['router','app', 'self','notice', 'off', 'use_watch','watched','initAutoload', 'noheaders','initialized_watch','locals', 'addRex'];
      
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

    /**
     * Sets the scope of call
     *
     * @param boolean $view
     * @return string|false
     */
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
      return '';
    }

    /**
     * compile strings for unrouted files
     *
     * @param string|array $arg1 body or arguments
     * @param array|string $arg2 arguments or body
     * @return string|false
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
           return '';
        }
        $locals = (array) $arg2;
      } else {
        $body = $arg2;
        if($arg1 === null){
           trigger_error("argument 1 cannot be null or void.");
           return '';          
        }
        if(!is_array($arg1)){
           trigger_error("Both arguments of compile cannot be null or array. One must be a string, while the other an array.");
           return '';
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


