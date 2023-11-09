<?php 

use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Rescon;
use spoova\mi\core\classes\Attribs;
use spoova\mi\core\classes\Enums\live;
use spoova\mi\core\classes\Meta;

class Ress extends Rescon {

    private static Ress $instance;

    /**
     * Path of resource file
     *
     * @var string
     */
    private static string $path = '';

    /**
     * Unique custom name of resource file
     *
     * @var string
     */
    private static string $name = '';

    /**
     * Unique internal name of resource file
     *
     * @var string
     */
    private static string $unique = '';
    
    /**
     * Maps unique names to custom specified names
     *
     * @var array
     */
    private static array $tracked = [];

    /**
     * All called urls
     *
     * @var array
     */
    private static array $urls = [];

    /**
     * Defines the currently or last added url value
     *
     * @var array
     */
    private static array $current_url = [];
    
    /**
     * All names and their respective url values
     *
     * @var array
     */
    private static array $named = [];
    
    /**
     * All named urls
     *
     * @var array
     */
    private static array $named_urls = [];
    
    /**
     * Maps unique names to custom specified names
     *
     * @var array
     */
    private static array $mapped_names = [];

    /**
     * Stores all error encountered while importing script
     *
     * @var array
     */
    private static array $errors = [];

    private static array $validated_paths = [];
    
    /**
     * Stores imported items to save rendering process
     *
     * @var array
     */
    private static array $imports = [];
    
    /**
     * Stores imported items to be used as exports
     *
     * @var array
     */
    private static array $exports = [];

    /**
     * Collection of php pulled files
     *
     * @var array
     */
    private static array $pulls = [];   

    /**
     * Collection of urls checked
     *
     * @var array
     */
    private static array $collections = [];

    
    /**
     * Collection of urls that have gone at least once through Ress::makescript()
     *
     * @var array
     */
    private static array $makescripts = [];

    /**
     * Extensions for static resources
     *
     * @var array
     */
    private static $extTags = ['css','js'];

    private static bool $metaLoad = false;

    private static int $metaStatus = 0;

    /**
     * Extensions for hypertext files
     *
     * @var array
     */
    private static $extFils = ['php','html'];  

    public static function new(string $path = '') : Ress {
        self::$path = $path;
        return self::instance();
    } 

    /**
     * instantiate resource watch if configured
     */
    function __construct(){ 
      
      if(!defined('_core') || !defined('_icore')) return false;
      if(!defined('online')) return false;  
      if(!@class_exists(scheme('core\classes\FileManager', false))) return false;
      if(!method_exists($this,'watch')) return false;
      
      //read fileManager for resource watching
      $monitor = (int) Init::key('RESOURCE_WATCH');


      //resource enviroment controller(int) 
      if($monitor !== 1 && $monitor !== 2) return false; //not configured
      if(($monitor === 1) && (online)) return false; //disable for online configuration
      
      //initialize resource only once (from here) - prevent multiple initializations
      if(!self::$initialized_watch){   

        self::watch(); //auto play

      }

    }


    /**
     * Stores a url
     *
     * @param string $path path of resource file
     * @return Ress
     */
    public static function url(string $path) : Ress {
        $unique = randice(10);
        self::$tracked[] = $unique;

        $url = [
            'name' => self::$name,
            'dir'  => trim(to_frontslash(self::$path), '/ '),
            'url'  => trim(to_frontslash($path), '/ '),
        ];
        
        self::$urls[(self::$unique = $unique)] = $url;

        self::$current_url = $url;
        
        return self::instance();
    }

    public static function urx($path) {
        $unique = randice(10);

        $url = [
            'name' => self::$name,
            'dir'  => '',
            'url'  => $path,
        ];

        self::$tracked[] = $unique;

        self::$urls[(self::$unique = $unique)] = $url;

        self::$current_url = $url;

        return self::instance();
    }

    public static function named(string $name) {

        if(!trim($name)) {
            EInfo::trigger('Resource unique names cannot be empty strings');
            return self::instance();
        }

        if(in_array($name, self::$mapped_names)) {
            if(self::$named[$name] !== self::$current_url){
              EInfo::trigger('Resource unique name "'.$name.'" already exists');
            }
            return self::instance();
        }
        
        self::$named[$name] = self::$current_url;

        self::$mapped_names[self::$unique] = $name;

        $search = array_search(self::$unique, self::$tracked);
        
        // Update tracked unique keys
        self::$tracked[$search] = $name;
        
        //add name key to url saved
        self::$urls[self::$unique]['name'] = $name;
        
        // save url data to named urls
        self::$named_urls[$name] = [self::$urls[self::$unique]];
        return self::instance();

    }

    /**
     * Creates an instance of Resource class
     *
     * @return Ress
     */
    private static function instance() : Ress {
        if(!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Binds unique group names together
     *
     * @param array $unique new group name to be assigned for merged items
     * @param array $names existing names of items to be merged
     * @return Ress
     */
    public static function bind(string $unique, array $names) : Ress {
        if(!in_array($unique, $names)){

            if(!isset(self::$named_urls[$unique])){

                $self_urls = self::$named_urls;

                // self::$named_urls[$unique] = ['::bind' => true];
                self::$named_urls[$unique] = [];
               
                foreach($names as $name){
                    if(isset($self_urls[$name])){
                        $named_urls = $self_urls[$name];
                        if(!in_array($named_urls[0], self::$named_urls)){
                            self::$named_urls[$unique][] = $named_urls[0];
                        }
                    }
                } 
                //vdump(self::$named_urls);
                // self::$named_urls = array_unique(self::$named_urls);
            }else {
                EInfo::trigger('Resource unique name "'.$unique.'" already exists');
            }
        }else{
                EInfo::trigger('Resource unique name "'.$unique.'" cannot bind to itself');
        }

        return self::instance();

    }
    
    /**
     * Binds previously named urls to new named group and flushes the binded values.
     * @param String[] $names names of named files
     * @return Ress
     */
    public function bindTo(string $group, array $names = []) : Ress {

        if(func_num_args() < 2){

            //get previous named urls 
            $tracks = self::$tracked; 

            //bind all tracks to a new group name
            self::bind($group, $tracks);

            self::$tracked = [];  
            // self::$mapped_names[self::$unique];

        }else {

            $all_groups = self::$named_urls;

            if(!isset($all_groups[$group])){
                if($names){
                    self::bind($group, $names); //bind as a new group
                }
            }else{

                //get exsiting group data
                $groups = $all_groups[$group];

                // var_dump($named_urls[$name]);
                
                foreach($names as $name){

                    if(isset($all_groups[$name])){

                        foreach($all_groups[$name] as $subitem){
                            if(!in_array($subitem, $groups)){
                                $groups[] = $subitem;
                            }
                        }

                    }
                    //get group data of $name
                    
                }
                self::$named_urls[$group] = $groups; 
                //if(!in_array($group, $names)){
               // }
               // self::bind($group, $new_group);
            }

        }

        return $this;
    }

    /**
     * Static method for including external file resource 
     *
     * @param array|string $list This may be a valid PHP file path (dot convention only) without the php extension name returning an array. 
     *  - If string is supplied, the valid PHP File must return an array of name and file url.
     *  Supports dot convention
     * @return Ress|null
     */
    public static function pull(array|string $list) : Ress | null {

        $instance = self::instance();

        $load = false; 

        if(is_string($list)){
          $path = to_dirslash(domroot($list), true). '.php';
          if(!in_array($path, self::$pulls)){
            self::$pulls[] = $path; 
            $load = true;
            if(!is_file($path)){
              trigger_error("Resource file '{$path}' does not exist!", E_USER_ERROR);
              return self::instance();
            }else{ 
                $list = include($path);
            }
          }else{
              trigger_error("Resource file '{$list}' has been previously pulled", E_USER_ERROR);
          }
        } else {
            if(!in_array($list, self::$pulls)){
                $load = true;
                self::$pulls[] = $list;       
            }      
        }


        if(is_array($list) && $load) {

            foreach($list as $name => $path){
    
                if(is_array($path)){
                    self::bind($name, $path);
                }else{ 
                    self::urx($path)->named($name);
                }
            }

        }

        
        return self::instance();
      }
      

    /**
     * Imports all required scripts depending on arguments supplied
     *
     * @param array $names
     *  - [null]: returns all saved scripts once 
     *  - [string,array]: returns scripts for only specified groups
     * @return Ress|null
     */
    public static function import(string|array|null|live $names = null) : string {

        $resolve = [];

        if(func_num_args()  === 0) {
            foreach(self::$named_urls as $url) {

                foreach($url as $bind){
                    $full_url = $bind['dir'].FS.$bind['url'];
                    if(!in_array($full_url, self::$makescripts)){
                        if($resolved = self::makescript($bind)){
                          self::$exports[] = $resolve[] = $resolved;
                        }
                    }
                }
    
            }
        }else{
          
            if($names instanceof live){
                //import watch script internally 
                return self::watchFile($names, false) ?: '';
            }
            
            $names = (array) $names;

            foreach($names as $name) {
                
                if(isset(self::$named_urls[$name])){

                    if(!isset(self::$imports[$name])){

                        self::$imports[$name] = [];
    
                        $url = self::$named_urls[$name]; // group name
                            
                        foreach($url as $bind){
                            $full_url = $bind['dir'].FS.$bind['url'];
                            if(!in_array($full_url, self::$makescripts)){
                                if($resolved = self::makescript($bind)){
                                  self::$imports[$name][] = self::$exports[] = $resolve[] = $resolved;
                                }
                            }
                        }
                        
                    }else{
                        foreach(self::$imports[$name] as $scripted){
                            $resolve[] = $scripted;
                        }
                    }

                }else{

                    self::call_error('import error: no specified group name "'.$name.'" found');

                }

            }

        }

        $meta = '';

        //Resolve meta tags 
        if(self::$metaStatus == 0){
          $isMeta = Init::key('RESOURCE_META');
          self::$metaStatus = 1;
          
          if($isMeta === "on"){
            if(isset($_ENV['meta']) && ($envMeta = $_ENV['meta'])){
              if($envMeta instanceof Meta){
                self::$metaLoad = true;
                $meta = $envMeta->dump();           
              }
            }

          }

        }

        $resolve = implode("\n", $resolve);

        if(trim($resolve)) $resolve = "\n".$resolve."\n";

        return $meta.$resolve;
        
    }

    public static function export() {

        $exports = self::$exports;

        var_dump($exports);

    }
    
    public static function close(){

      self::$tracked = [];
      return self::instance();

    }
    
    public static function errors(){

        return self::$errors;

    }

    private static function makescript(array $url) {

        $dir = $url['dir'];
        $url = $url['url'];
        $urc = $url;

        self::$makescripts[] = $dir.FS.$url;

        $uri = explode('=>', $url, 2);
        $url = rtrim($uri[0], ' ');
        $urx = $uri[1] ?? '';
        $colons = ''; $ext = null;

        if(preg_match('/:::(css|js)$/', $url, $matches)){
            $ext = $matches[1]; // update url extension name
            $url = substr($url, 0, strlen($url) - strlen(':::'.$ext));
            $colons = ':::'.$ext;
        }

        $uext = pathinfo($url, PATHINFO_EXTENSION);

        $ext = $ext ?: $uext;

        if($ext === 'js' && $uext !== 'js' && $uext !== ''){
            return self::call_error('Resource url extension for js file "'.$url.$colons.'" is not valid');
        }


        if(!self::validate_link($dir, $url, $ext, $colons)){
            return '';
        }

        if($urx){
           if($ext === 'css'){
               $props = ['rel'=>'stylesheet','type'=>'text/css']; 
               $urx = Attribs::update($props, $urx);
            } else {
               $urx = Attribs::split($urx); // convert urx to attributes string format
            }  
        } else {
            if($ext === 'css'){
                $urx = Attribs::join(['rel'=>'stylesheet','type'=>'text/css']);
            }
        }

        if($ext === "css"){
            return '<link href="'.$url.'"'.rtrim($urx).'>';
        }

        if($ext === "js"){
            return '<script src="'.$url.'"'.rtrim($urx).'></script>';
        }
        return $url;
    }

    private static function validate_link(string $dir, string &$url, string $ext, string $colons){

        $isDomainDir = self::is_protocol($dir);
        $isDomainUrl = self::is_protocol($url);

        $isHyperFile = in_array($ext, ['php','html']);
        $isScriptExt = in_array($ext, ['css','js']);

        // prevent unknown script
        if(!$isScriptExt && !$isHyperFile){
            return self::call_error('Resource url extension for "'.$url.$colons.'" is not valid');
        }

        if($dir && !array_key_exists($dir, self::$validated_paths)){
            // Do a directory validation 
            if(!$isDomainDir){
                self::$validated_paths[$dir] = is_dir(to_dirslash($dir));
                if(!self::$validated_paths[$dir]) {
                    self::call_error('Resource path "'.$dir.'" is not valid');
                }
            }
        }

        if($isHyperFile) {

            if($colons) {
                return self::call_error('Resource colons not supported for "'.$ext.'" files');
            }

            if($isDomainUrl){
                return self::call_error('Resource url format for "'.$url.'" is not supported');
            }

            if(!$isDomainDir){
                $url = $dir.DS.$url;

                $uri = realpath(to_dirslash($url));
                if(!in_array($url, self::$collections) && !in_array($url, self::$collections)){
                    self::$collections[] = $url;
                    self::$collections[] = $uri;
                    if(!$uri) return false;
                }
            } else {
                self::$collections[] = $url;
            }

            return true;

        }

        if($isScriptExt) {

            if($dir){
                if( ($isDomainDir && !$isDomainUrl) || (!$isDomainDir && !$isDomainUrl)){
                    if($dir) $url = $dir.FS.$url;
                    if($isDomainDir) $isDomainUrl = true;
                }
            }
    
            if($isDomainUrl && !in_array($url, self::$collections)) {
                self::$collections[] = $url;
                return true;
            }

            $urx = self::domify($url);
            $uri = realpath($urx);

            if(!in_array($url, self::$collections) && !in_array($url, self::$collections)){
                self::$collections[] = $url;
                self::$collections[] = $uri;
                if(!$uri) {
                    return self::call_error('Resource path for "'.$urx.$colons.'" is not valid');
                }
            }else{
                return false;
            }

            $url = DomUrl($urx);

            return true;
        }

        return false;

    }

    /**
     * replace script(css, js) urls while online
     *
     * @param string $url
     * @param string $ext
     * @return string
     */
    private static function domify(string $url){

      if((online === true)) { 
        //get domain folder
        $url = ltrim($url,'/');

        //replace urls starting with domain folder
        $expUrl = explode('/',$url,2);
        if(basename($_SERVER['DOCUMENT_ROOT']) == $expUrl[0]){
          return isset($expUrl[1])? $expUrl[1] : $url ;
        }
      }

      return $url;
    }

    /**
     * checks if url is an http(s) protocol or starts with www
     *  --sorts only by using prefix. May be reconfigured to use isAbsolutePath in future
     * 
     * @param string $url file url 
     * @return boolean
     */
    private static function is_protocol($url) : bool{
        return (preg_match('/^https?:\/\//i', $url) || preg_match('/^www\./i', $url));
    }
    
    /**
     * stores or logs error in error lists
     *
     * @param array|string $error
     * @return boolean false (always)
     */
    private static function call_error($error) : bool {
        self::$errors[] = $error;
        return false;
    }

}