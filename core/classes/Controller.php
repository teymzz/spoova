<?php


/**
 * @package spoova\core/controllers/
 * @author Akinola Saheed <github teymzz>
 */
 namespace spoova\core\classes;

 class Controller
 {

   public $layout = '';

   protected static array $routes = [

   ];

   public function __construct(){
     $this->usingLayout = false;
   }
   
   public function setLayout($layout){
     $this->usingLayout = true;
     $this->$layout = $layout;
   }

   public function usesLayout(){
     return $this->usingLayout;
   }
   
   /**
    * 
    */
   public function render()
   {
        return view(...func_get_args()) ;                              
   }

   /**
    * Defines or returns a list of named routes
    *
    * @param array $routes list of named routes
    * @return array
    */
    public static function routes(array $routes = []) {
      if(func_num_args() > 0){
        foreach($routes as $routeName => $routeLink){
          if(is_string($routeLink)){
            self::$routes[$routeName] = $routeLink;
          }
        }
      }
      return self::$routes;
    }

    public function loadRoutes(){
        $routes = self::routes();
        foreach($routes as $routeName => $routeLink){
          if(is_string($routeLink)){
            self::$routes[$routeName] = $routeLink;
          }
        }
    }
   
 }