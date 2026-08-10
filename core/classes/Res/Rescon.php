<?php

namespace spoova\mi\core\classes\Res;

use Res;
use spoova\mi\core\classes\Enums\live;
use spoova\mi\core\classes\Res\Resx;
use spoova\mi\core\classes\Livescript;

/**
 * This class is used to handle javascript resource watch. 
 * It was created specifically to enable code readability for Resource class 
 */
abstract class Rescon extends Resx{
    
    protected static $off = false; //sets the resource to off
    protected static $watched = 0; //detect if the resource has been watched at least once dynamic
    protected static $use_watch = false; //works with configuration
    protected static $initAutoload = false; //detects if the live script has been applied at least once
    protected static $initialized_watch = false; //detect if the web page has been monitored
    protected static $noheaders = false;
    
    /**
     * sets the watchdog function of the resource class
     * init configurations are loaded once from here
     *
     * @param string|integer $interval watchdog interval
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
        $watches = ['::watch', '::lock', '::console'];

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
     * prevent the use of cache headers
     */
    public static function noheaders(){

      self::$noheaders = true;
      
    }

    /**
     * Start a live server extension. Short access for Res::import('::watch')
     *
     * @param string $on optional [::watch|::watch-seek|::watch-poll|::lock|::console]
     * @return void
     */
    public static function live(string $on = 'seek', int $time = 40){
      //note: $param should be modified to ($on [poll|seek]) & ($time: interval)
      // $options = '::watch-'.$on.'-'.$time;
      if(!isCli()){

        $options = '::watch';
  
        if(func_num_args() > 0) {
  
          $options .= '-'.$on.'-'.$time;
        }
        
        Res::import($options); 
      }
    }

    /**
     * Enforces Resource class to turn off watch
     * This will overide all other settings.
     */
    public static function off(){
      self::$off = true;
    }

    /**
     * Enforces Resource class to turn on watch
     * This will overide all other settings.
     */
    public static function on(){
      self::$off = false; //set the off as false
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
     * Return true if monitor system is activated and{ is currently being used
     *
     * @return boolean
     */
    public static function isOnUse(){
      return (!self::$off || self::$watched > 1)? true : false;
    }

    /**
     * connect to another page for live state
     * @deprecated 1.5 This is a test method that is no longer functional and will be removed later.
     * @param string $url url of file
     * @param string $field section of page where response is delivered
     * @param array|string $settings options for request (string no currently supported)
     * @return string connector
     */
    public static function connect(string $field,string $url, array|string $settings = []){
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
     * @param string|int|array|live $interval set the interval in milliseconds or array of configs
     * @param $return determines if the live script is returned or directly printed. 
     * @return string|false
     *  - FALSE is returned if live server is previously initialized or if live server is not enabled for online mode while 
     *    project application is currently running in an online environment.  
     */
    protected static function watchFile(string|int|array|live $interval = '::lock', bool|int $return = false) : string|false { 
      
      if(!self::$initialized_watch) self::$initialized_watch = true;

      //if monitor is switched off return back
      if(self::$off === true) return false;

      $runtime = Livescript::key('RUNTIME') ?: 30;
      $control = Livescript::key('CONTROLS') ?: '';

      //control buttons
      $review  = Livescript::key('SEEKER') ?: '';
      $pauser  = Livescript::key('PAUSER') ?: '';
      $player  = Livescript::key('PLAYER') ?: '';
      $autoseek = Livescript::key('AUTOSEEK'); 
      $position = Livescript::key('POSITION') ?: '';
      $activity = Livescript::key('ACTIVITY'); //default is offline 
      $activity = is_numeric($activity)? (int) $activity : false;
      $overlay = Livescript::key('OVERLAY') ?: 2;

      if(($activity === 0) || (($activity === 1) && online)){
        return false;
      }

      $position = explode(" ", $position);
      $top = $position[0] ?? 0;
      $right = $position[1] ?? 0;

      if(is_string($interval) || is_int($interval)){
        if(is_string($interval)){
          $live_sets = explode('-', $interval, 3);
          $interval = $live_sets[0] ?? $interval;
          $control = $live_sets[1] ?? $control;
          $runtime = (int) ($live_sets[2] ?? $runtime);
        }

        $interval = [
          'mode' => $interval,
          'runtime'  => $runtime,
          'controls' => $control,
          'seeker'   => $review,
          'pauser'   => $pauser,
          'player'   => $player,
          'autoseek' => $autoseek,
          'position' => ['top' => $top, 'right' => $right],
          'overlay' => $overlay
        ];
      }
      $interval = json_encode($interval);

      $script = self::initAutoloader().'<script>if(typeof res != \'undefined\') res.monitor(\''.$interval.'\',\''.domurl().'\')</script>';
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