<?php
use spoova\mi\core\classes\Resin;
use spoova\mi\core\classes\Notice;
use spoova\mi\core\classes\Router;
use spoova\mi\core\classes\Resource;
use spoova\mi\core\classes\Application;
use spoova\mi\core\classes\FileManager;
use spoova\mi\core\classes\Rex;

/**
 * This class is an extension of Resource class
 * The main Resource class is loaded from this extension
 * @Warning: Absence of this file can break your application
 */
final class Res extends Resource implements Resin{

    private static ?Res $self = null;
    private static $body;
    private static $storepath = '';
    private static $content;
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
     * free variables
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
    * Renders and Outputs the res template files

    * @param string $url res template url
    * @param array|string|\Closure $callback template handler function
    * @return string
    */
    public static function load($url = '', $callback = '') : string {
        return (string) Rex::load(...func_get_args());
    }

   /**
    * Process and Returns the rex template files

    * @param string $url res template url
    * @param mixed $callback template handler function
    * @return string
    */
    public static function markup(string $url, string|false|Closure $callback = false) : string|false {

       return Rex::markup(...func_get_args());

    }

    /**
     * Saves stored template into a storage file
     *
     * @param string $storage template storage file path
     * @param array $args template arguments
     * @return string
     */
    public static function build(array $args = []) : string {

      $storage = self::$storepath;

      foreach(self::$locals as $locals => $value){
        $$locals = $value;
      }

      foreach($args as $arg => $argval){
        $$arg = $argval;
      }

      $content = self::$body;

      //create path in storage folder
      $Filemanager = new FileManager;
      $realFile    = docroot.'/core/storage/'.to_frontslash($storage).'.php';

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
              self::$content = $content;

            }
  
        }
        return $content;
    }

    /**
     * Determines if the template content is returned or printed on page
     *
     * @param boolean $display
     * @return string
     */
    public static function display(bool $display = true) : string {
       if($display) {

         print self::$content; 
         return '';

       } else {

        return self::$content;

       }

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
      $exc = [
        'router','app', 
        'self','notice', 
        'off', 'use_watch',
        'watched','initAutoload', 
        'noheaders','initialized_watch',
        'body'];
      
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

}


