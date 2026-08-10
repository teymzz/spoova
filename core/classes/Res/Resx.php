<?php

namespace spoova\mi\core\classes\Res;

use Window;
use spoova\mi\core\classes\Notice;

/**
 * This class contains methods 
 * needed by both the Res and Rex classes
 */
abstract class Resx{

    protected static $call_scope;
    protected static $viewType;
    protected static ?Notice $notice = null;

    
    /**
     * Sets the notice flash
     *
     * @param string $key
     * @param mixed $message
     * @return void
     */
    final public static function setFlash(string $key, mixed $message = null){
        if(!self::$notice){
          trigger_error('notice not initialized');
          return false;
        }
        self::$notice->setFlash(...func_get_args());
    }

    /**
     * @see Notice
     *
     * @param string $key 
     * @return boolean
     */ 
    final public static function hasFlash(string $key) : bool {
        if(static::$notice){
          return static::$notice->hasFlash(...func_get_args());
        }
        return false ;
    }
    
    /**
     * Add a new flash message if the key supplied exists in the list of flash notices
     *
     * @param string $key
     * @param mixed $message
     * @return string|void
     */ 
    final public static function flash(string $key = '', $message = ''){
        if(static::$notice){
          return static::$notice->flash(...func_get_args());
        }
        return '';
    }    

    /**
    * Defines or returns a list of named routes for controller or window files
    *
    * @param args list of named routes
    * @return array
    */    
    public static function addRoutes(){
        Window::addRoutes(...func_get_args());
    }
  
    /**
     * Returns TRUE if called on Res class
     *
     * @return boolean
     */    
    final public static function isRes() : bool {
        return (static::$call_scope === 'res');
    } 
  
    /**
     * Returns TRUE within within windows class
     *
     * @return boolean
     */
    final public static function isRouter() : bool {
        return (static::$call_scope === 'router');
    }
      
    /**
     * Returns TRUE if in view mode
     *
     * @return boolean
     */
    final public static function isView() : bool {
        return (static::$viewType === 'view');
    }    

}