<?php

/* Custom Helper Functions for classes only */

use spoova\core\classes\Secure;
use spoova\core\classes\Url;

if(!function_exists('webClass')){
  /**
   * Load a class from the classes folder
   * @throws error if class does not exist
   *
   * @param string $className
   * @return void
   */
  function webClass(string $className){
    $args = func_get_args();
    unset($args[0]);
    $args = array_values($args);
    $class =  'spoova\core\classes\\'.$className;
    if(class_exists($class)){
        return new $class(...$args);
    }
  }
}

if(!function_exists('webTool')){
  /**
   * Load a class from the tools folder
   * @throws error if class does not exist
   *
   * @param string $className
   * @return object|void
   */
  function webTool(string $className, $args){
    $args = func_get_args();
    unset($args[0]);
    $args = array_values($args);
    $class = 'spoova\core\tools\\'.$className;
    if(class_exists($class)){
      return new $class(...$args);
    }
  }
}

if(!function_exists('window')){

  /**
   * Returns a division of the current page url.
   * by using the window class.
   *
   * @param string $type options [window/root|path|base]
   * @return string
   */
  function window($type = 'root'){

    return Window::wvm($type);

  }

}

if(!function_exists('route')){
  /**
   * Get a named route
   *
   * @param string $routeName
   * @return void
   */
  function route(string $routeName){
    $routes = Window::routes();
    return ($routes[$routeName])?? '';
  }
}

if(!function_exists('isGuest')){
  /**
   * This function works with User Class
   * 
   * @return bool
   */
  function isGuest(){
    return !User::id();
  }
}

if(!function_exists('isUser')){
  /**
   * This function works with User Class
   * 
   * @return bool
   */
  function isUser(){
    return User::id()? true : false;
  }
}

if(!function_exists('secure')){
  /**
   * secure windows
   *  
   * @param array|string $locations locations to protect 
   * @return void
   */
  function secure($locations){
    Secure::locations($locations);
  }
}

if(!function_exists('url')){
  /**
   * Handle urls by using the Url class
   * 
   * @param $url
   */  
  function url($url){
    $Url = new Url;
    return $Url->path($url);
  }   
}

if(!function_exists('authDirect')){

  /**
   * Redirect to another url on user account
   *
   * @param string $url
   * @return void
   */
  function authDirect(string $url){
    if(isUser()) redirect($url);
  }

}

if(!function_exists('setFlash')){
  /**
   * Handle urls by using the Url class
   * 
   * @param $url
   */  
  function setFlash(){
    $args = func_get_args();
    \Res::setFlash(...$args);
  }   
}

if(!function_exists('guestDirect')){

  /**
   * Redirect to another url on guest account
   *
   * @param string $url
   * @return void
   */
  function guestDirect(string $url){
    // vdump($url);
    if(isGuest()) redirect($url);
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
    Window::wvm('error',$arg);
  }
  
}

if(!function_exists('ress')) {
  
  /**
   * Load urls from res folder
   *
   * @return string
   */
  function ress($path){
    return DomUrl('res/'.ltrim($path,'/ '));
  }
  
}
