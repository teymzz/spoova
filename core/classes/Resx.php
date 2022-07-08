<?php

namespace spoova\core\classes;

use Window;

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
    public static function setFlash(string $key, $message = null){
        if(!self::$notice){
          trigger_error('notice not initialized');
          return false;
        }
        self::$notice->setFlash(...func_get_args());
    }

    /**
     * @see \core\classes\Notice
     *
     * @param string $key 
     * @param [type] $message
     * @return string | void
     */ 
    public static function hasFlash(string $key) : bool {
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
    public static function flash(string $key = '', $message = ''){
        if(static::$notice){
          return static::$notice->flash(...func_get_args());
        }
        return '';
    }    

    public static function routes(){
        Window::routes(...func_get_args());
    }
    
    public static function isRes(){
        return (static::$call_scope === 'res');
    } 
  
    public static function isRouter() {
        return (static::$call_scope === 'router');
    }
    
    public static function isView() {
        return (static::$viewType === 'view');
    }    

}