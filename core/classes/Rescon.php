<?php

namespace spoova\mi\core\classes;

use Res;
use spoova\mi\core\classes\Resx;

/**
 * This class is used to handle javascript resource watch method class
 * It was created specifically to enable code readability for Resource class 
 * Documentations are also included to thr
 */
abstract class Rescon extends Resx{
    
    protected static $off = false; //sets the resource to off
    protected static $use_watch = false; //works with configuration
    protected static $watched = 0; //detect if the resource has been watched at least once dynamic
    protected static $initialized_watch = false; //detect if the resource has been watched at least once static
    protected static $initAutoload = false;
    protected static $noheaders = false;
    /**
     * sets the watchdog function of the resource class
     * init configurations are loaded once from here
     *
     * @param [string | integer] $interval watchdog interval
     * @return string|void|false
     */
    public static function watch($interval = '::lock'){ 

        //set headers if not already set 
        if(!self::$noheaders and $_SERVER['DOCUMENT_ROOT']){
          header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
          header("Cache-Control: post-check=0, pre-check=0", false);
          header("Pragma: no-cache");     
        }

        //if monitor already running prevent access modifications or settings
        if(self::$watched === 1 and !self::$off){ 
          return false; 
        }

        //if monitor is switched off after being on, allow watch to run
        // if resource was set off
        if( (self::$off === true) ){
          self::$off = false; //set resource back on
          return;
        }

        //watches (note convert interval to acceptable name or variable)
        $watches = ['::watch', '::lock', '<<console'];

        if(in_array($interval, $watches)){
            self::$use_watch = $interval;
            return ; 
        }

        $interval = (int) $interval;

        if($interval != false){
            self::$use_watch = $interval;
            return ; 
        }

        self::$use_watch = false;
    }
    
    /**
     * prevent the use of headers
     */
    public static function noheaders(){

      self::$noheaders = true;
      
    }

    /**
     * Short method for resource watch
     */
    public static function live($param = '::watch'){
      Res::import($param); 
    }

    /**
     * Enforces Resource class to turn off watch
     * This will overide all other settings.
     */
    public static function off(){
      self::$off = true;
      //self::$watched = (self::$watched > 0)? self::$watched - 1 : 0;
    }

    /**
     * Enforces Resource class to turn on watch
     * This will overide all other settings.
     */
    public static function on(){
      self::$off = false; //set the off as false
      //self::$watched = (self::$watched < 1)? 1 : self::$watched; 
    }    

    /**
     * Returns true if monitor is activated although may not be in use
     *
     * @return boolean
     */
    public static function isOn(){
      return (self::$off === false) ? true : false;
    }

    /**
     * Return true if monitor system is activated an is currently being used
     *
     * @return boolean
     */
    public static function isOnUse(){
      print self::$off;
      return (!self::$off || self::$watched > 1)? true : false;
    }

    /**
     * connect to another page for live state (connect)
     *
     * @param string $url url of file
     * @param string $field section of page where response is delivered
     * @param [array | string ] $settings options for request (string no currently supported)
     * @return string connector
     */
    public static function connect(string $field,string $url, $settings = []){
        if($url == '') return false;
        
        $object = '';
  
        if(is_array($settings)){
  
          //create object format
          foreach($settings as $setting => $value){
  
            $funcs = ['callfront','callback','data','beats', "blend"];
  
            if(!in_array($setting, $funcs) || is_array($value)){
              $value = json_encode($value);
            }
  
            $object .= $setting .':'. $value. ',';
          }
  
          if($object != ''){
              //remove last comma
              $object = rtrim($object, ', ');
                   
          }          
        }
        $object = '{'.$object.'}';
        if(is_string($settings)){
          $object = ltrim(rtrim($settings,"}"), "{" );
        } 

        
        return (
          
          self::initAutoloader().'
          <script>
            res.connect(\''.$url.'\',\''.$field.'\','.$object.')
          </script>
          ' 

        );
    }

    private static function initAutoloader(){
      if(self::$initAutoload) return;
      self::$initAutoload = true;
      return '<script src="'.DomUrl('res/main/js/local/debug/live.js').'"></script>';
    }

    /*
     * Watches or monitors a page (live server)
     *
     * @param string $interval
     * @return string
     */
    protected static function watchFile($interval = '::lock', $return = false){ 
      
      if(!self::$initialized_watch) self::$initialized_watch = true;
 
      //if monitor is switched off return back
      if(self::$off === true) return false;

      $script = self::initAutoloader().'<script>if(typeof res != \'undefined\') res.monitor("'.$interval.'","'.domurl().'")</script>';
      if($return) { return $script; } 

      if(self::$watched > 0) return false;
      
      //if not actively running or it was switched on after it was off (i.e 2)
      if(self::$watched === 0){
         self::$off = true; //set the monitor to on
         self::$watched += 1;
         print $script;
      }
      
      return '';
    }

}


?>