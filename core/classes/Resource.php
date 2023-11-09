<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Rescom;

/**
 * Resource class was mainly built to properly link css and javascript urls.
 * However, it extends to linking php and html files too.
 * For this reason it performs advanced and complex operations
 * This include validation of local urls or urls with absolute paths thereby nullifying
 * or rejecting invalid local url until they are available for access or properly mapped
 * However, http protocols cannot be validated so are ignored during validation
 * 
 * It stores urls into groups which can be manipulated and later imported in a dynamically
 * specific way into the webpage.
 * 
 * Through configuration files, resource is capable of loading meta tags, provide live server support along with
 * a light error debugging notification system when developing your site. The live server is
 * implemented through a the Res class, and the Live.js located in res folder. 
 * 
 * Through the power of Resource, Setup Installation, File Structuring and Control, and other functions and constant,
 *  a merging of offline and online development is hereby achieved.
 * 
 * With Good understanding of how Resource works, web development becomes faster with more dynamic control structures. 
 * The downside of this class is that more urls only means more validations which can slow the system down. For this reasons, developers
 * may try to limit local urls to a maximum of 100 urls or what works for them.
 * 
 * NOTE:: Rescom is extended to Rescon (Resource connectors)
 */
class Resource Extends Rescom{

    private static bool $boot = false;

    /**
     * Allow meta tags autoloading
     *
     * @var boolean
     */
    private static $meta_on = true;

    /**
     * Valid extensions
     *
     * @var array
     */
    private static $exts  = array("css","js","php","html");

    /**
     * Extensions for static resources
     *
     * @var array
     */
    private static $extTags  = array("css","js");

    /**
     * Extensions for hypertext files
     *
     * @var array
     */
    private static $extFils  = array("php","html");    
    private static $cpath = '';

    /**
     * Prefix directory
     *
     * @var string
     */
    private static string $dir = '';

    /**
     * Escaped prefix directory. Overide $dir
     *
     * @var boolean|string
     */
    private static bool|string $xdir = '';

    /**
     * Stores all errors encountered during validation
     *
     * @var array
     */
    private static $error = [];

    /**
     * Contains all stored resources
     *
     * @var array
     */
    private static array $resources = [];

    /**
     * Current resource name pointer
     *
     * @var boolean|string
     */
    private static bool|string $resourceName;  

    /**
     * Allow the storage of imported resources
     *
     * @var boolean
     */
    private static bool $storeImports = false; 

    /**
     * Contains all current importations made
     *
     * @var array
     */
    private static array $currentImports = [];

    /**
     * Pulled resource files only
     *
     * @var array
     */
    private static array $pulls = [];
    
    private static string $prepend = '';
    private static ?Resource $called_static = null;
    private static string $currentScript = '';
    private static array $namedFiles = [];
    private static array $namedGroup = [];

    private static array $processed_urls = [];
    private static array $url_filters = [];

    /**
     * All supplied urls
     *
     * @var array
     */
    private static array $urls = [];

    /**
     * instantiate resource watch if configured
     */
    function __construct(){ 
      
        $this->bootResource();

    }

    /**
     * Boot resource class
     *
     * @return void
     */
    private function bootResource() {

        if(!self::$boot) {
            if(!$this->validRequirements()) return false; 

            //get watch value from Init class
            $watch = (int) Init::key('RESOURCE_WATCH');

            //set valid environment for resource watch...
            $watch_disabled = (!in_array($watch, [1, 2]));
            $watch_offline = (($watch === 1) && (online));

            if($watch_disabled || $watch_offline){
                return false;
            }

            //initialize live script only once
            if(!self::$initialized_watch) self::watch();
            self::$boot = true;
            self::$called_static = $this;
        }


    }

    /**
     * Validate basic requirements needed by the class.
     *
     * @return boolean
     */
    private function validRequirements() : bool {
              
        //set required constants
        $constants = ['_core','_icore','online'];
  
        foreach($constants as $constant){
          if(!defined($constant)) return false;
        }
  
        //check class availability
        if(!@class_exists(scheme('core\classes\FileManager', false))) {
          return false;
        }
  
        //check method availability 
        if(!method_exists($this,'watch')) return false;  
  
        return true;
  
    }

    /**
     * Sort and Build the url to be stored
     *
     * @param string $url file path
     * @param boolean $store tells resource class to store path or ignore storage when called
     * @return boolean | string sorted $url
     */
    private static function make_request(string $url, bool $store = false){

         // sort out url supplied 
         $filter = self::filterUrl($url);

         if(!array_key_exists($url, self::$urls)){

           self::$urls[$url] = ''; //save filtered url

           //Url Validation
           if(!self::processUrl($url, $store)){ return false; } 

           // return script or processed urls
           if($script = self::call_script($url, $filter['ext'], $filter['attrs'])){
             
              if(self::is_script($script)){ 
                return self::$urls[$url] = $script;
              }else{ 
                return self::$urls[$url] = $url;
              }
 
           }else{
              return self::call_error("Resource :$url: was not found"); 
           }
           
         } else {

           return self::$urls[$url];

         }

    }

    /** 
     * filters out the extension of a file path using supplied extension (::: + ext) if no extension is found
     * @param string|null $url referenced variable url to be sorted
     * @param string|null $colons reference variable to fetch customized or coloned extension
     * @return string
    */
    private static function filterUrl(&$url){
        
        $attrs = explode("=>",$url);
        if(count($attrs) > 1){
          $url = $attrs[0];
          $attrs = $attrs[1];
        }else{
          $attrs = "";
        }

        $ext = '';
        $split = explode(":::",$url);
        $url = trim($split[0]);
        if(isset($split[1])){
           $colons = ":::".$ext;
        }else{
           $ext = pathinfo($split[0],PATHINFO_EXTENSION);
           $colons = '';
        }

        return self::$url_filters = [
          'colons' => $colons,
          'attrs' => $attrs,
          'ext'   => trim($ext)
        ];

    }


    private static function processUrl(&$url, bool $store = false){

        self::$processed_urls[$url] = '';

        //Get url filters
        $filter = self::$url_filters;

        //redefine variables
        $colons = $filter['colons'];
        $attrs  = $filter['attrs'];
        $ext    = $filter['ext'];

        //sets the parent path to be prefixed on $url
        $dir = self::$xdir? '' : self::$dir;

        //validate path && url 
        $isDomainUrl = self::is_protocol($url);
        $isStaticUrl = self::is_ext($ext, self::$extTags);
        $isHyperUrl  = self::is_ext($ext, self::$extFils);
        $isDomainDir = ($dir && self::is_protocol($dir));

        $url_supplied = $url.$colons.$ext.$attrs;

        //reset url filtered 
        self::$url_filters = [];

        if( ($domify = (!$isDomainUrl && $isStaticUrl)) || (!$isDomainUrl && !$isDomainDir)) {
          //append directory to url for only accepted formats
          $url = str_replace(['//','\\'], '/', to_frontslash($dir.DS.$url)); 
          if($domify) {
            //modify static url online to document root
            $newurl = self::domify($url, $ext);
          }
          if($isDomainDir) $isDomainUrl = true;
        }

        if(!in_array($ext, self::$exts)){ 
        	return self::call_error("Resource file with $ext extension is not allowed"); 
        }

        if(isset($newurl)) $url = $newurl;
        
        if($isStaticUrl && !$isDomainDir){
            if(realpath(docroot.DS.$url)){
              $url = DomUrl($url); //change url to protocol format
              $isDomainUrl = true;
            }else if(!is_file($url)){
                return self::call_error("Resource path :$url: is not found");
            }
        }
        
        if($isDomainUrl && (!filter_var($url,FILTER_VALIDATE_URL))){
          return self::call_error("Resource path :$url: is not valid"); 
        }    
               	   
        //resource: store url if neccessary
        if($store === true){
          if(self::$resourceName ?? ''){
            self::$resources[self::$resourceName][] = $url_supplied;
          }else{
            self::$resources[] = $url_supplied; //save to unnamed space
          }
        }
        
        //convert url to full path for html & php files
        if(!$isDomainUrl && $isHyperUrl){ $url = to_dirslash(docroot.DS.$url); }
        
        return true; //return true if all checks are successfully done

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
     * checks if url is a relative path
     *
     * @param string $url
     * @return boolean
     */
    private static function is_absolute($url){
      return isAbsolutePath($url); // declared in functions.php
    }    

    /**
     * check if the script is made of tags (for: css  javascript)
     *
     * @param string $script
     * @return boolean
     */
    private static function is_script($script){
      return ($script != strip_tags($script));
    }

    /**
     * replace script(css, js) urls while online
     *
     * @param string $url
     * @param string $ext
     * @return string
     */
    private static function domify(string $url,string $ext){

      if(online === true and in_array($ext, self::$extTags)){ 
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
     * return the type of tag for the scripts
     *
     * @param string $url file url / path
     * @param string $ext file extension
     * @param string $attrs attributes
     * @return [bool|string] 
     */
    private static function call_script(string $url, string $ext, string $attrs){

      if($ext == "css" || $ext == "js"){

        //internally defined default properties
        $indefsCss = ['rel'=>'stylesheet','type'=>'text/css']; 

        if($attrs != ''){
            if($ext === 'css') {
                $css = ['rel'=>'stylesheet','type'=>'text/css']; 
                $attrs = Attribs::update($css, $attrs);
            } else {
                $attrs = Attribs::split($attrs); // convert urx to attributes string format
            }

        }else {
            if($ext === 'css') {
                $attrs = Attribs::join(['rel'=>'stylesheet','type'=>'text/css']);
            }
        }
        
        if($ext == "css"){
          return '<link href="'.$url.'"'.$attrs.'>';
        }

        if($ext == "js"){
          return '<script src="'.$url.'"'.$attrs.'></script>';
        }

      }

      if($ext == "php" || $ext == 'html'){
        return $url;
      }    
      return self::call_error("Resource path :$url: is not found");
    }

    /**
     * check if extension is of valid types
     *
     * @param string $ext extension name
     * @param string|array $exts{
     * @return boolean
     */
    private static function is_ext(string $ext, $exts) : bool{
      $exts = (array) $exts;
      return (in_array($ext, $exts));
    }

    /**
     * Resets the resource class
     *
     * @param boolean $param 
     *  -- true resets the entire class properties
     *  -- false resets only the resource path property
     * @return void
     */
    private static function refresh($param = false){
      if($param === true){
        self::$error = [];  
        self::$resources = [];
        self::$dir = '';
        self::$xdir = '';
        self::$error = [];
        self::$resourceName = '';
        self::$storeImports = false;
        self::$currentImports = [];
        self::$currentScript = '';
        self::$namedFiles = [];
        self::$namedGroup = [];
      } 
    }

    /**
     * renders content based on type
     *
     * @param string $script inclusion format (as file url | script tags) 
     * @param boolean $type
     * @return void|false
     */
    private static function execute(string $script, bool $type = false){
       
        if($type === true){
        	if(self::is_script($script)){
        	 	print $script;
        	}elseif($script != null){
        	 	include_once($script);
        	}else{
        	 	return false;
        	}
        }else{

        	if(self::is_script($script)){
        	 	return $script;
        	}elseif($script != null){
        	 	return "include_once(".$script.")";
        	}else{
        	 	return false;
        	}

        }

    }

    /**
     * stores or logs error in error lists
     *
     * @param array|string $error
     * @return boolean false (always)
     */
    private static function call_error($error) : bool {
      self::$error[] = $error;
      return false;
    }
    
    /**
     * sets a root directory for absolute paths
     */
    public function dir(string $dir = ''){
      self::$dir = $dir; 
      return $this;
    }
    
    /**
     * Removes a previously set root directory for absolute paths
     */
    public function dirClose(){
      self::$dir = '';
      return $this;
    }

    /**
     * executes a url supplied immediately 
     *
     * @param string $url url to be executed immediately
     * @param boolean $store true directs the url to be stored
     * @param boolean $execute true returns the execution 
     *  -- when url is html / php, $execute shoul be set to false
     * @return void
     */
    public static function getFile(string $url, $store = false, $execute = true){

      $store = (bool) $store;
      $script = self::make_request($url, $store);

      if(self::$storeImports === true){ self::$currentImports[] = $script; }
    
      if(!$execute) return self::execute($script,$execute);
      
      self::execute($script, $execute);
    }

    /**
     * stores and returns a url stored (static)
     *
     * @param string $url file url to be processed
     * @param boolean $store true stores url supplied
     * @return string
     */
    public static function callFile(string $url, $store=true){
      $store = (bool) $store;
      
    	$script = self::make_request($url, $store);
      self::$currentScript = $script;
     	return $script;
    }

    /**
     * stores and returns a url stored similarly as callFile() method ...
     * ...but employs a chainable structure
     * chainable only with name() method chains: url(), urlOpen() and urlClose() methods !!!
     * 
     * @return Resource
     */
    public function url() : Resource{
      $args = func_get_args();
      self::callFile(...$args);
      return $this;
    }

    /**
     * This is used immediately after url() method is called to bind a name to a called url.
     * @return Resource
     */
    public function named(string $name) : Resource{
      $current = self::$currentScript;
      if($current) {
        if(!isset(self::$namedFiles[$name])){
          self::$namedFiles[$name] = $current;
          self::$namedGroup[] = $name;
        }
      }
      return $this;
    }

    /**
     * This is use to fetch a named file.
     * 
     * @param string $name name of file
     * @param bool $array when set as true, data returned will be in array format
     * @return String
     */
    public static function recall(string $name, bool $array = false) : Array|String {

      $file = self::$namedFiles[$name] ?? '';

      if(is_array($file)){
        if($array) return $file;
        $file = implode("\n", $file);
        if(trim($file)) $file = "\n".$file."\n";
      }elseif($array) {
        $file = $file? [$file] : [] ;
      }

      return $file;

    }

    /**
     * Load all local css files
     *
     * @return void
     */
    public static function local() : string {
      self::new('res/main/')->name('local-css')->url('css/local/spi.css')->named('local-css')->urlClose();
      return recall('local-css');
    }

    /**
     * This is use to bind named files together into a new unique group name
     * @param String[] $names names of named files
     * @return Resource
     */
    public function bind($name, array $names) : Resource {

      $resources = [];

      foreach($names as $resource){
        $resources[] = self::recall($resource);
      }

      if(isset(self::$namedFiles[$name])) {

        return EInfo::view('binded name "'.$name.'" already exists for resource group!');

      }else{
        self::$namedFiles[$name] = $resources;
      }


      return $this;

    }

    /**
     * Binds previously named urls to new named group and flushes the binded values.
     * @param String[] $names names of named files
     * @return Resource
     */
    public function bindTo(string $group, array $names = []) : Resource {

      $resources = self::$namedFiles; //get all unique names
      $FileLists = self::$namedGroup; //get recently decalared names

      if(func_num_args() < 2){

        //bind previously named urls to new unique group
        $newList = array_intersect_key($resources, array_flip($FileLists));

        if(!isset(self::$namedFiles[$group])) {
          self::$namedFiles[$group] = $newList; 
        }else{
          EInfo::view('binded "'.$group.'" already exists in unique group!'); 
        }

        self::$namedGroup = []; //flush declarations
      }elseif(func_num_args() > 1){
        
        $resources = [];

        foreach($names as $resource){
          $resources[] = self::recall($resource);
        }

        $oldResources = self::$namedFiles[$group] ?? [];
        $newResources = array_merge($oldResources, $resources);
        self::$namedFiles[$group] = $newResources; 

      }

      return $this;

    }
    
    /**
     * stores and returns a url stored similarly as url() method ...
     * ...but prevents the use of base url set by (new()) method
     * chainable only with name() method chains: url(), urlOpen() and urlClose() methods !!!
     */
    public function xurl(){
      self::$xdir = true;
      $args = func_get_args();
      self::callFile(...$args);
      self::$xdir = false;
      return $this;
    }
    
    

    /**
     * stores a url to a named existing group
     *
     * @param string $name
     * @param string|void $url
     * @return void|false
     */
    public static function addFile($name, $url=null){
       
      $id = $name;
      if(func_num_args() == 2 && $name === true){
        if(($name = self::$resourceName) == '') return;
      } 
      
      //few tweak settings
      if(func_num_args() == 1 && trim($name) != null){
        $url  = $name;
        $name = "";
      }
      
      //execute method with few tweaks
      if($url != null){
        if(isset(self::$resources[$name])){
          self::$resourceName = $name;
        }
        if(trim($name) != "" && !isset(self::$resources[$name])){
          return false;
        } 
        self::callFile($url);
        if(($id !== true) && ($id !== self::$resourceName)) self::$resourceName = ''; 
      }
    }
    
    

    /**
     * This method:
     *   - Adds a new parent path if argument is supplied
     *   - This will create a new instance of Resource class if it does not exist.
     *
     * @param string $new a new parent path if supplied.
     * 
     * @return Resource
     */
    public static function new(string $dir = '') : Resource {

        if(!self::$called_static){
            self::$called_static = new static();
        }     
        self::$dir = $dir;
        return self::$called_static;
      
    }
    
    /**
     * Static method for including external file resource 
     *
     * @param string $path Php file path without the php extension name. Supports dot convention
     * @return Resource|null
     */
    public static function pull(string $path) : Resource | null {
      
      $folder = Init::key('RESOURCE_FOLDER');
      
      $path = to_dirslash(domroot($folder.'.'.$path), true). '.php';
      
      if(!in_array($path, self::$pulls)){
          if(!is_file($path)){
            trigger_error("Resource file '{$path}' does not exist!", E_USER_ERROR);
            return self::$called_static;
          }
    
          include_once($path);
    
          self::$pulls[] = $path;
      }

      return self::$called_static;
    }
    
    /**
     * Static method for declaring a new group name 
     * selects (or declares a new) group name
     * Note :: This will create a new instance of Resource class if it does not exists 
     * @param string $name Unique group name of urls
     * @return Resource|null
     */
    public static function name(string $name = '') : Resource | null{
      self::$resourceName = $name; 
      if(!isset(self::$resources[$name])){
        self::$resources[$name] = [];
      }	
      if(!self::$called_static){
        self::$called_static = new static();
      }
      return self::$called_static;
    }  

    /**
     * returns the plain format of a url return type for viewing purpose
     *
     * @param string $url return format
     * @return void
     */
    public static function getFormat($url){

      $script = self::make_request($url);

      if(!self::is_script($script)){
		    return "include_once(".ltrim($script).")";
      }else{
		    return htmlentities($script);
      }

    }

    /**
     * Export data from inside storage (with colon + group name)
     *
     * @param args < 1, $usename becomes $dpath && $dpath becomes null
     * @param args > 1 :
     *  -- $dpath as file path to be used for export (applied only on absolute urls)
     *  -- $usename as group name(s) to be exported (name(s) (array | string) of group(s) to be exported)
     * @return array
     */
    public static function export($usename = null) : array {
    	$values = ':lists';
      self::import($usename, $values);
    	return (array) $values;
    }


    /**
      * import stored urls
      */
    private static function importer($usename = null, bool $execute = true){
    	
    	if($usename == "" || $usename == null){ $usename = ":";}
    	if($usename[0] != ":"){ return false; }
    	
    	$usename = ltrim($usename, ":");
    	$script = [];

    	if($usename != null && isset(self::$resources[$usename])){
    	  $selfResources = self::$resources[$usename];
    	}else{
    	  $selfResources = self::$resources;
    	}
    	
    	foreach ($selfResources as $resource) {
        
    	  if(!is_array($resource)){ 

    	    if(!$execute){ 
    	    	$script[] = self::getFile($resource, false, false); //return
    	    }else{
            self::getFile($resource, false, true); //execute
    	    }
    	    
    	  }
    	}

    	if(!empty($script)){ return $script; }
    } 

    /**
     * sort, executes and imports files in a group or lists of groups 
     *
     * @param string|array $name This can be the names of groups or option for watch to be imported
     *  - When used as watch option, options are [::watch|::lock|<<console]
     * @param string|false $imports references all imported urls. 
     *  - The ':values' option returns
     * @return string scripts
     */
    public static function import(string|array $name = null, string|false &$imports = false){

      	self::$storeImports   = false;
        self::$currentImports = [];  

        //call watchFile if parameters are (::watch | ::lock ) and watch is not on
        $watches = ['::watch', '::lock', '<<console'];

        if(in_array($name, $watches)){
          //import watch script internally 
          return self::watchFile($name, false);
        }
        
        //variables that deal with importing of data
        $exec = !in_array($imports, [':values',':lists']);
        $store = !in_array($imports, [':values', false]);

     	  $scripts = [];

      	if($store){ self::$storeImports = true; }

        $name = (array) $name;

        foreach ($name as $grpName) {
          $gpName = str_replace(":", '', $grpName);
          if($gpName == null || isset(self::$resources[$gpName])){
            $imp = self::importer($grpName, $exec) ;
            $scripts[$grpName] = $imp;
          }
        }

      	$imports = self::$currentImports;

      	self::$storeImports = false;
        self::$currentImports = []; 
        $watchFile = '';
        $meta = '';

        // on index import() :
        if(self::$use_watch and !self::$watched){ 
          
          //self::$use_watch watch init settings
          //self::$watched is when watch is activated (though may not be running)
          if(!$exec){ $watchFile = self::watchFile(self::$use_watch, !$exec); };
          if($exec) echo self::watchFile(self::$use_watch);

        }

        if(!self::$meta_on){

          $isMeta = Init::key('RESOURCE_META');

          if($isMeta === "on"){
            if(isset($_ENV['meta'])){
              if(method_exists($_ENV['meta'],'dump')){
                self::$meta_on = true;
                $meta = $_ENV['meta']->dump();
                if($exec) print $meta;
              }              
            }

          }

        }

        $iports = is_array($imports)? implode('',$imports): $imports;
        if(is_string($imports)) $imports  = (array) $imports;

      	if(!$exec){ return $meta.$watchFile.$iports; } 
    }
    
    /**
     * returns a json_encode format of all resources stored
     *
     * @return void
     */
    public static function used(){
      return json_encode(self::$resources);
    }

    /**
     * returns error found while importing resource urls
     *
     * @param int|string $point:
     *  - int return the error at index
     *  - 'first' sets error index as zero. Same as supplying zero as integer.
     *  - 'last' sets error index as as the last error index and returns the value.
     *  - 'html' print errors out as a string
     *  - null returns all errors as array format
     */
    public static function error(string|int $point = null){
      $errorsCount = count(self::$error);

      if($point === 'first') $point = 0;
      if($point === 'last') $point = $errorsCount  - 1;

      if(is_int($point)){
        return (self::$error[$point])?? false;
      }

      if($point === null){
        return self::$error;
      }
      
      if($point === 'html'){
        for($i=0; $i<count(self::$error); $i++){
            echo self::$error[$i]."<br>";
        }
        return $errorsCount;
      }   
    }

    /**
     * open resource in safe mode by only closing active name
     *
     * @param bool $reset when set as true will clear any previous declarations
     * @return void
     */
    public static function open(bool $reset = false){
        
        if(Resource::active()) {
           Resource::close(false); 
        }elseif($reset === true){
           Resource::close(true); 
        }

    }

    /**
     * performs the same function as open() but used only with chainable methods
     * since it is chained with name method, it can only come after a name is declared 
     *
     * @param bool $reset when set as true will clear any previous declarations
     * @return void
     */
    public function urlOpen(bool $reset = false){
      $args = func_get_args();
      //get current name
      $name = self::$resourceName;
      self::open(...$args);
      self::name($name);
    }

    /**
     * Helps to unset declarations or to entirely clears any previous declarations
     * @param string|bool $param
     *  - A false or string value "*" peforms the same function as false value which 
     *    if an active name is selected, unsets default values such as ignore, parent path and the selected name. 
     *    This will not clear or reset stored urls. 
     *  - A string value "/" unsets only the currently selected resource name (safe mode) 
     *  - A true value resets the entire previously stored urls and default values. (strict mode)
     * @return void
     */
    public static function close($param = false){  

      $param = ($param === '*')? false : $param;
      
      self::$dir = '';
      
      if($param === true){

        //@param true
        self::refresh(true); //clear all data

      }elseif($param === "/"){
        
        //@param / unset only currently selected name
        self::$resourceName = false;

      }elseif(((self::$resourceName ?? '') != "") && $param === false){
        
        //@param ('*' | false)
        //unsets ignore, parent path and selected name only if 
        //an active name (or selection) exists 
        self::$resourceName = false;

      }
      
    }

    /**
     * performs the same function as close() but used only with chainable methods
     */
    public function urlClose($param = '*'){

      $args = func_get_args();
      self::close(...$args);

    }   

    /**
    * returns active resource if it exists else false
    *
    * @return [bool | string]
    */
    public static function active(){
      if(self::$resourceName != ""){
        return self::$resourceName;
      }else{
      return false;
      }
    }

}