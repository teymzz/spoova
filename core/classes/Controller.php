<?php

namespace teymzz\spoova\core\classes;

use Session;

/**
 * @author Akinola Saheed <github teymzz>
 * 
 * This class contains core methods inherited by the Window class.
 */
class Controller{

  public $layout = '';
  public bool $usingLayout;

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
   * Returns a rendered a view
   * 
   * @return string|void
   */
  public function render()
  {
        return view(...func_get_args()) ;                              
  }

  protected static function streamSession(){
    new Session(...static::buildSession());
  }

  /**
   * Stream a session from the session class
   *
   * @return array
   */
  protected static function buildSession() : array {

    return ['user', 'cookie'];

  } 

 /**
  * Defines or returns a list of named routes
  *
  * @param array $routes list of named routes
  * @return array
  */
  public static function addRoutes(array $routes = []): array{
    if(func_num_args() > 0){
      foreach($routes as $routeName => $routeLink){
        if(is_string($routeLink)){
          static::$routes[$routeName] = $routeLink;
        }
      }
    }
    return static::$routes;
  }

  /**
   * Returns Defined lists of named routes
   *
   * @return array
   */
  public static function getRoutes(): array{
    return static::$routes;
  }

  /**
   * loads the routes supplied from addRoute method
   *
   * @return array
   */
  final static public function loadRoutes(Controller $Class = null) : array {

    if(!$Class) { $Class = "Window"; }
   
    $routes = $Class::addRoutes();

    foreach($routes as $routeName => $routeLink){
      if(is_string($routeLink)){
        $Class::$routes[$routeName] = $routeLink;
        static::$routes[$routeName] = $routeLink;
      }
    }

    return $routes;

  }
  
}