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
      //if(self::$off and self::$watched)
      if(self::$watched > 1){
        
      }
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
      return '<script src="'.DomUrl('res/res.js').'"></script>';
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


/*
 *
 * Res::watch() - switch on watch if initially switched off
 * Res::off - switch off watch if it has not been imported to the page
 * 
 * Note:: if configuration settings allows resource watch to be enabled, Res::import() will
 *        automatically import the watch to the page. To prevent this, Res::off() must be declared
 *        prior to the first importation. When Res::off() is used, Res::watch() will set back on and allow the
 *        appending import to import the watch. Res::import('::watch') will work fine
 * 
 * Resource::connect(url, respfield, settings) //javascript handler for connecting page components in a live state mode
 *      @url url path of component
 *      @respField a response field selector
 *      @settings (autoload.js) settings format below
 *        --all autoload keys can be supplied in array below. 
 *        --Strings as strings and Bools as Bools, Integers as Integers. 
 *        --Functions must be supplied as a string instead. This will be processed internally by the resource class. 
 *        -- the 'data' key can be written in array formats: 
 *              ['key'=>'value']  //send a post key 'key' with value 'value'
 *              
 *              ['key'=>['value1','value2']] //send a post key 'key' with packet values [value1, value2] (@ serialize == false)
 *              
 *              ['key'=>['value1','value2']] //send a post twice with key 'key' and values value1, value2 respectively (@ serialize == true)
 *              
 *              //*(@ serialize == true)  
 *                    -- send a post key 'first' with packet values [value1, value2], then
 *                    -- send a post key 'second' with packet values [value1, value2]
 *              [
 *                'first'=>['value1','value2'], 
 *                'second'=>['value1','value2']
 *              ] 
 *  
 *              --A sample format is written below.
 * 
 *              $sets = [   
 *                'beat'    => 10,
 *                'serialize' => true,
 *                'callfront' =>'
 *                    function done(){
 *                      ..javascript function here
 *                    }
 *                ',    
 *                'data' => [
 *                    'text' => 
 *                      [
 *                        'first',
 *                        'second',              
 *                      ]
 *                 ],
 *               ];
 * 
 *              // -- in the above, a post will be sent having a key of 'text' twice with different values 'first', then 'second';
 *              // -- note that an interval of 10 secs (beats) will be applied between the requests
 *              // -- as opposed to the methods above, supply the autoloader.js settings format as an alternative.
 *              // -- sample format is provided below. Please note that all quote needed to be escaped are escaped.
 *             
 *             //* start of code sample---------------------------------------------------------------------------------------------------------------------
 *             $sets = "
 *                      {   
 *                          
 *                          uiconsole: true, 
 *                          forwards: true, 
 *                          serialize: true,
 *                          callfront:
 *                              function done(){
 *                                  // $('#spinner').fadeIn(); 
 *                              },    
 *                          callback:
 *                              function done(){
 *                                  $('#spinner').fadeOut();
 *                              },
 *                          packetCut: 'terminate',
 *                          callfront:
 *                              function done(){
 *                                  alert('yeahw');     
 *                              }, 
 *                          'blendTime' : 200,
 *                          'blend'
 *                              :function anim(field, newHtml){
 *                                  $(field).children().wrapAll(\"<div></div>\").fadeOut(10,function(){
 *                                      $(field).html('<div style=\"display:none\">'+newHtml+'</div>').find('>div').fadeIn(10);
 *                                  });
 *                              }
 *                      }
 *                    ";
 *          //* end of code sample------------------------------------------------------------------------------------------------------------------------//
 * 
 *          //* other necessary documentations are provided in autoloader.js file.
 *
 */
?>