<?php
  
namespace spoova\core\classes;

use spoova\core\classes\DB\DBMigrator;

 /**
  * @package spoova\core\classes
  */
 class Application
 {
   
   public static $ROOT_DIR;
   private Router $router;
   public Request $request;
   public Response $response;
   public Notice $notice;
   public static $app;
   public Controller $controller;
   public DBMigrator $dbbot;

   
   /**
    * 
    */
   public function __construct($rootDir = '')
   {
     self::$ROOT_DIR = (func_num_args() == 0)? domroot() : $rootDir;
     self::$app = $this;
     $this->request = new Request();
     $this->response = new Response(); 
     $this->notice   = new Notice();
     $this->router = new Router($this->request, $this->response);
     $this->setController(new Controller); 
     // code...

     $this->dbbot = new DBMigrator();
   }
   
   public function run() {
      return $this->router->resolve(); 
   }
   
   public function setController(Controller $controller) {
     $this->controller = $controller;
   }
   
   public function getController(): Controller {
     return $this->controller;
   }

   public function router(){
     return $this->router;
   }

   public function notice(){
     return $this->notice;
   }
   
 }