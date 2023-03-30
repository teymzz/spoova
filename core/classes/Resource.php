<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Ress;
use spoova\mi\core\classes\Rescom;
use spoova\mi\core\classes\FileManager;

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
 * implemented through a the Res class, and the Res.js located in res folder. 
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

    private static $exts  = array("css","js","php","html");
    private static $extTags  = array("css","js");
    private static $extFils  = array("php","html");    
    private static $cpath = '';
    private static $dir;
    private static $xdir;
    private static $error = [];
    private static $resources = [];
    private static $resourceName;  
    private static $storeImports; 
    private static $currentImports = [];
    private static $resource_path;
    private static $prepend;
    private static $meta_on = true;
    private static $ignore;
    private static $called_static = null;

    /**
     * instantiate resource watch if configured
     */
    function __construct(){ 
      
      if(!defined('_core') || !defined('_icore')) return false;
      if(!defined('online')) return false;  
      if(!@class_exists(scheme('core\classes\FileManager', false))) return false;
      if(!method_exists($this,'watch')) return false;
      
      //read fileManager for resource watching
      $fileManager = new FileManager;
      $fileManager->setUrl(getDefined('_icore').'init');
      $fileManager->openFile(true, getDefined('_icore').'init');
      $monitor = (int)$fileManager->readFile('RESOURCE_WATCH');

      //resource enviroment controller(int) 
      if($monitor !== 1 && $monitor !== 2) return false; //not configured
      if(($monitor === 1) && (online)) return false; //disable for online configuration
      
      //initialize resource only once (from here) - prevent multiple initializations
      if(!self::$initialized_watch){   

        self::watch(); 

      }

    }
    
    public static function ignore(){
      //after every ignore remember to close
      self::$ignore = true;
    }

    /*
     * Sort and Build the url to be stored
     *
     * @param string $url file path
     * @param boolean $store tells resource class to store path or ignore storage when called
     * @return boolean | string sorted $url
     */
    private static function make_request(string $url,bool$store=false){

         if(!self::processUrl($url,$ext,$attrs,$store)){ return false; }
  
   	    if($script = self::call_script($url,$ext,$attrs)){
   	      
   	      if(self::is_script($script)){ 
   	        return $script;
   	      }else{ 
   	        return $url;
   	      }

   	    }else{
   	      return self::call_error("Resource :$url: was not found"); 
   	    }

    }

    /* 
     * filters out the extension of a file path using supplied extension (::: + ext) if no extension is found
     * @param  $url referenced variable url to be sorted
     * @param $colons reference variable to fetch customized or coloned extension
     * @return string
    */
    private static function getExt(&$url,&$colons = null,&$attrs = null){
        
        $attrs = explode("=>",$url);
        if(count($attrs) > 1){
          $url = $attrs[0];
          $attrs = " => ".$attrs[1];
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
        }
        return trim($ext);
    }


    private static function processUrl(&$url, &$ext = null, &$attrs = null,$store = false){
        
        $path = self::$resource_path; //get resource path
        //$done = false;
        $asterisk = self::$ignore ? "**" : "*";
        $asterisk = isset($asterisk)? $asterisk : "";
        if(substr($url, 0, 1) === '*'){ 
          //$done = true;
          if(substr($url, 0, 2) === '**'){
            $asterisk = "**";
            $url = ltrim ($url, '** ');
          }else{
            $asterisk = "*";
            $url = ltrim ($url, '* ');
          }
        } 

        //split url
        $ext = self::getExt($url, $colons, $attrs);
        
        
        // if(!$done && $asterisk !== '**' && !self::$ignore && !self::is_protocol($url)){

        //   if(self::is_ext($ext, self::$extTags)){
        //       // $url = DomUrl((defined('fol')? '/'.fol.$url : $url));
        //     }else{
        //       // $url = fol.$url; //php
        //   }
          
        // }else 
        
        if(self::is_ext($ext, self::$extTags) && !self::is_protocol($url)){
            if(realpath(docroot.'/'.$url)){
              $url = DomUrl($url);
            }
        }
         
        $asterisk = "*";
        

	    //store url and path forms (save memory)
	    $isProtoUrl  = self::is_protocol($url);
	    $isProtoPath = self::is_protocol($path);
	    $isDotUrl    = self::is_absolute($url);
	    $isDotPath   = self::is_absolute($path);    	
      
        //append resource path if neccessary
        if($path != null){
      	   $reurl = ltrim($url,"/");
      	   $repath = ($path == '/')? "/" : rtrim($path,"/");

           //append resource path before url is processed
      	   if($isProtoPath && !$isProtoUrl && !$isDotUrl){
      		  $url = $repath.DS.$reurl;
      	   }elseif($isDotPath && !$isProtoUrl){
         	  $url = $repath.DS.$reurl;
           }
        }

        //url: apply document root where necessary
        $xurl = $url;
       	if(!$isDotUrl && !$isProtoUrl){
           $xurl = getDefined('docroot').DS.$url;
       	}

       	//validate url supplied
        if($isProtoUrl){ 
          if(!filter_var($url,FILTER_VALIDATE_URL)){ 
            return self::call_error("Resource path :$url: is not valid"); 
          } 
        }else{
        	if(!is_file($xurl)) return self::call_error("Resource path :$url: is not found");         
        	$nurl = self::domify($url,$ext);
        }
               	   
        //resource: store url if neccessary
        if(self::$resourceName != null){
          if($store == true){self::$resources[self::$resourceName][] = $asterisk.$url.$colons.$attrs;}
        }else{
          if($store == true){self::$resources[] = $asterisk.$url.$colons.$attrs;}
        }

        if(isset($nurl)){ $url = $nurl; }
        

        //validate extension
        $files = self::$exts;         

        if(!in_array($ext,$files)){ 
        	return self::call_error("Resource file with $ext extension is not allowed"); 
        }
        
        //reconfigure configure $url if necessary
        $urlExt = self::getExt($url);
        if(!self::is_protocol($url) && self::is_ext($urlExt, self::$extFils)){ $url = str_replace("\\",'/',getDefined('docroot')).DS.$url; }
        
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
       $url = (string) $url;
    	 return ((substr($url, 0,4) == 'http') || (substr($url, 0,4) == 'www.'))? true : false;
    }

    /**
     * checks if url is a relative path
     *
     * @param string $url
     * @return boolean
     */
    private static function is_absolute($url){
      //isAbsolutePath: declared in functions.php
      return isAbsolutePath($url); 
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
     * @return [bool | string] 
     */
    private static function call_script(string $url,string $ext, string $attrs){

      if($ext == "css" || $ext == "js"){

        //internally defined default properties
        $indefsCss = ['rel'=>'stylesheet','type'=>'text/css','href'=>$url]; 


        if($attrs != ''){

          //process attrs
          $props = rtrim(str_replace('=>','',$attrs),"; ");
          $attrs = trim(rtrim(str_replace(';','"',str_replace(':','="',$props)),'" ').'"');
          if($ext == 'css'){
              $filprops = explode(';',trim($props));
              

              
              //$exdefs = []; //externally defined default properties

              foreach($filprops as $filprop){
                $def = explode(":",$filprop);//externally defined default properties
                $defKey = trim($def[0]);//internally defined default key
                $defVal = trim($def[1]);//internally defined default value
                
                if(!array_key_exists($defKey, $indefsCss)){
                  $indefsCss[$defKey] = $defVal; //externally defined updated value
                }
              }
          }

        }
        
        if($ext == "css"){
          $newdefs = '';
          foreach($indefsCss as $indefKey => $newdefVal){
            $newdefs .= " ".$indefKey.'="'.$newdefVal.'"';
          }

          return '<link '.$newdefs.'>';
        }

        if($ext == "js"){
          return "<script src='".$url."'></script>";
        }

      }

      if($ext == "php" || $ext == 'html'){
        return $url;
      }    
      return self::call_error("Resource path :$url: is not found");
    }

    /*
     * check if extension is of valid types
     *
     * @param string $ext extension name
     * @param string|array $exts
     * @return boolean
     */
    private static function is_ext(string $ext, $exts) : bool{
      $exts = (array) $exts;
      return (in_array($ext, $exts));
    }

    /*
     * Resets the resource class
     *
     * @param boolean $param 
     *  -- true resets the entire class properties
     *  -- false resets only the resource path property
     * @return void
     */
    private static function refresh($param = false){
      if($param === true){
        self::$resource_path = null;
        self::$error = [];  
        self::$resources = [];
        self::$resourceName = null; 
        self::$ignore = false;
      }else{
        self::$resource_path = null;
      }  
    }

    /*
     * renders content based on type
     *
     * @param string $script inclusion format (as file url | script tags) 
     * @param boolean $type
     * @return void|false
     */
    private static function execute(string $script,$type=false){
       
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

    /*
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
    public function dir($dir = ''){
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
    
    

    /*
     * sets a global path for all file urls
     *
     * @param string|void $path
     * @return void
     */
    public static function path($path = null){

      if(is_dir($path)){ 
        return self::call_error("Resource path :$path: is not found");
      } 

      self::$resource_path = $path;
    }

    /*
     * executes a url supplied immediately 
     *
     * @param string $url url to be executed immediately
     * @param boolean $store true directs the url to be stored
     * @param boolean $execute true returns the execution 
     *  -- when url is html / php, $execute shoul be set to false
     * @return void
     */
    public static function getFile(string $url, $store=false, $execute = true){

      $store = (bool) $store;
      $script = self::make_request($url,$store);

      if(self::$storeImports === true){ self::$currentImports[] = $script; }
    
      if(!$execute) return self::execute($script,$execute);
      
      self::execute($script,$execute);
    }

    /*
     * stores and returns a url stored (static)
     *
     * @param string $url file url to be processed
     * @param boolean $store true stores url supplied
     * @return string
     */
    public static function callFile(string $url, $store=true){
      $store = (bool) $store;
      
      $xdir = self::$xdir? '' : self::$dir;
      $url = self::is_protocol($url)? $url : $xdir.$url; 
    	$script = self::make_request($url, $store);
     	return $script;
    }

    /*
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
    
    /*
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
    
    

    /*
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
     * @return Rosource|Ress
     */
    public static function new(string $dir = '') : Resource|Ress {

      
      if(!self::$called_static){
        self::$called_static = new static();
      }     
      self::$dir = $dir;
      return new Ress(self::$called_static); 
      
    }
    
   /**
    * Static method for declaring a new group name 
    * selects (or declares a new) group name
    * Note :: This will create a new instance of Resource class if it does not exists 

    * @param string $name
    * @return Resource|null
    */
    public static function name($name=null) : Resource | null{
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
     * Non-static method for declaring a new group name
     */
    public function group($name = null){
      self::name($name);      
      return $this;
    }    

    /*
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

    /*
     * Export data from inside storage (with colon + group name)
     *
     * @param args < 1, $usename becomes $dpath && $dpath becomes null
     * @param args > 1 :
     *  -- $dpath as file path to be used for export (applied only on absolute urls)
     *  -- $usename as group name(s) to be exported (name(s) (array | string) of group(s) to be exported)
     * @return array
     */
    public static function export($dpath = null, $usename = null){
    	$values = ':lists';
    	if(count(func_get_args()) < 2){
    	  $usename  = $dpath;
    	  $dpath = null;
    	}
      self::import($dpath, $usename, $values);
    	return $values;
    }
    
    /*
     * applies a prefix on urls when importing
     * @return array|void
     */
    private static function prefixer($dpath=null,$usename=null,$execute=true){

    	if($usename == "" || $usename == null){ $usename = ":"; }
    	if($usename[0] != ":"){ return false; }
    	
    	$strlen  = strlen($usename);
    	$usename = ltrim($usename, ":");
    	$scripts = [];

    	if($usename != null && isset(self::$resources[$usename])){
    	  $selfResources = self::$resources[$usename];
    	}else{
    	  $selfResources = self::$resources;
    	}

    	foreach ($selfResources as $key => $resource){
    	  if(!is_array($resource)){
    	  	
    	  	$url = trim($resource);
    	    
    	    if(!self::processUrl($url,$ext,$attrs)){ return false; /*import prefixing failed!!!*/ }

    	    if(self::is_absolute($dpath) and is_dir($dpath) and !self::is_protocol($url)){
    	    	$dpath = rtrim($dpath,"/");
    	    	$url = ltrim($url,"/");
    	    	$url = self::is_ext($ext,self::$extTags)? $dpath.DS.$url : $url;
    	    }elseif(self::is_protocol($dpath) and !self::is_protocol($url)){
    	    	$url = str_replace("../", '' , $url);
    	    	$dpath = rtrim($dpath,"/");
    	    	$url = ltrim($url,"/");
    	    	$url =  self::is_ext($ext,self::$extTags)? $dpath.DS.$url : $url;
    	    }
            $script    = self::call_script($url,$ext,$attrs); 
            $scripts[] = self::execute($script,$execute);
    	  }
    	}
    	if(!$execute){ return $scripts; }
    }


    /*
      * import stored urls
      */
    private static function importer($dpath=null,$usename=null,$execute = true){
    	
    	if($usename == "" || $usename == null){ $usename = ":"; }
    	if($usename[0] != ":"){ return false; }
    	
    	$strlen = strlen($usename);
    	$usename = ltrim($usename, ":");
    	$script = [];

    	if($usename != null && isset(self::$resources[$usename])){
    	  $selfResources = self::$resources[$usename];
    	}else{
    	  $selfResources = self::$resources;
    	}
    	
    	foreach ($selfResources as $key => $resource) {
        
    	  if(!is_array($resource)){ 
    	    if(self::is_protocol($resource)){
    	      $resource = trim($resource);
    	    }else{
    	      if(strlen($dpath??'') > 0 and !is_dir($dpath)){ continue; }
    	      $resource = trim($dpath.$resource);
    	    }     

    	    if(!$execute){ 
    	    	$script[] = self::getFile($resource,"",false); 
    	    }else{
            self::getFile($resource,"",true); 
    	    }
    	    
    	  }
    	}

    	if(!empty($script)){ return $script; }
    } 

    /*
     * sets a parent root path to prepend on absolute urls
     *
     * @param boolean|string $path
     * @return void
     */
    public static function parent($path = false){
    	self::$prepend = $path;
    }

    /**
     * sort, executes and imports files in a group or lists of groups 
     *
     * @param string|array $dpath as $usename || as a prefix for $usename when args > 1
     * @param string|arrray $usename as name(s) of group(s) to be imported
     * @var $imports returns the imported urls if args > 2
     * @return string scripts
     */
    public static function import($dpath = null, $usename=null, &$imports=false){

      	self::$resource_path  = null;
      	self::$storeImports   = null;
        self::$currentImports = null;  

        //call watchFile if parameters are (::watch | ::lock ) and watch is not on
        $watches = ['::watch', '::lock', '<<console'];

        if(in_array($dpath, $watches)){
          //import watch script internally 
          return self::watchFile($dpath, false);
        }
        
        //variables that deal with importing of data
      	$exec = ($imports === ":values")? false : true; 
        if($imports === ":lists") $exec = false; 

     	  $scripts = [];

      	if($imports !== false and $imports != ":values"){ self::$storeImports = true; }

      	if(func_num_args() < 2){
      	  $usename  = $dpath;
      	  $dpath = null;
      	}else{
      		if(is_array($dpath)){
      			return ("import error: first arg must be a null or string (upper directory or domain url) if arg > 1");
      		}
      	}

        if(self::$prepend != null and substr($dpath, 0,5) != "pre::"){ 
           $dpath = $prep = "pre::".self::$prepend; 
        }

      	if($dpath != null and !is_array($dpath)){       
      	  
          $url = str_replace("pre::", '', $dpath);
      		$url = trim($url);
      		if(!self::is_protocol($url) and !is_dir($url)){
      			return self::call_error("path of '$dpath' does is not found");
      		}

      	}

      	if(substr($dpath??'', 0,5) == "pre::"){
      	  $dExp = explode("pre::", $dpath);
      	  $dpath = $dExp[1];
      	}

      	if(is_array($usename)){ 
      		foreach ($usename as $grpName) {
      		 $gpName = str_replace(":", '', $grpName);
      		 if($gpName == null || isset(self::$resources[$gpName])){
             $imp = isset($dExp)?  self::prefixer($dpath,$grpName,$exec) : self::importer($dpath,$grpName,$exec) ;
      		 	$scripts[$grpName] = $imp;
      		 }
      		}
      	}else
        {

          $usName = str_replace(":", '', $usename);
      		if(isset(self::$resources[$usName]) || $usName == null){
            $imp = isset($dExp)? self::prefixer($dpath,$usName,$exec) : self::importer($dpath,$usename,$exec);
      			$scripts[$usename] = $imp;
      		}

      	}

      	$imports = self::$currentImports;

      	self::$storeImports = null;
        self::$currentImports = null; 
        $watchFile = '';
        $meta = '';

        // on index import() :
        if(self::$use_watch and !self::$watched){ 
          
          //self::$use_watch watch init settings
          //self::$watched is when watch is activated (though may not be running)
          if(!$exec){ $watchFile = self::watchFile(self::$use_watch, !$exec); };
          if($exec) print self::watchFile(self::$use_watch);

        }

        if(self::$meta_on){

          $fileManager = new FileManager;
          $isMeta = $fileManager->setUrl(getDefined('_icore').'init')->readFile('RESOURCE_META');
        

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

        $imports = is_array($imports)? implode('',$imports): $imports;

      	if(!$exec){ return $meta.$watchFile.$imports; } 
    }
    
    /*
     * returns a json_encode format of all resources stored
     *
     * @return void
     */
    public static function used(){
      return json_encode(self::$resources);
    }

    /*
     * returns error found while importing resource urls
     *
     * @param $point:
     *  -- int return the error at index
     *  -- 'html' print errors out as a string
     *  -- null returns all errors as array format
     */
    public static function error($point=null){
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

    /*
     * open resource in safe mode by only closing active name
     *
     * @param [type] $param
     * @return void
     */
    public static function open($param = null){
        Resource::$resource_path = null; 
        
        if(Resource::active()) {
           Resource::close(false); 
        }elseif($param === true){
           Resource::close(true); 
        }

    }

    /*
     * performs the same function as open() but used only with chainable methods
     * since it is chained with name method, it can only come after a name is declared 
     */
    public function urlOpen(){
      $args = func_get_args();
      //get current name
      $name = self::$resourceName;
      self::open(...$args);
      self::name($name);
    }

    /*
     * Helps to unset declarations or to entirely free memory
     * @param string|bool $param
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

      }elseif(self::$resourceName != "" && $param === false){
        
        //@param ('*' | false)
        //unsets ignore, parent path and selected name only if 
        //an active name (or selection) exists 
        self::$resource_path = null;
        self::$ignore = false;
        self::$resourceName = false;

      }
      
    }

    /*
     * performs the same function as close() but used only with chainable methods
     */
    public function urlClose($param = '*'){

      $args = func_get_args();
      self::close(...$args);

    }   

    /*
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

/**
 *
 * RESOURCE METHODS
 *
 * UM (Url Methods)    => callFile(), addFile(), getFile()
 * CM (Control Methods) => Path(), name(), parent(), 
 * DM (Deploy Methods)  => import(), export()
 * OM (Other Methods)   => open(), close(), used(), active(), error(),
 *
 * CHM (chainable Methods) => url(), urlOpen(), urlClose();
 */
/**
 * METHODS AND EXPLANATION
 *
 * A) Resource::open(true | false)  //safely prepares the Resource class {optional}
 *  	@param (default): false
 *  	@param true   : referesh all urls / clears storage
 *  	@param false  : (1) safely exit selected group, (2) open resource in safe mode
 * 
 * B) Resource::Path($url | null)  // intialiazes or unsets a new directory for urls
 * 	 	@property: sets a general path or domain url to be used as prefix for any of the file methods
 *            
 *  	@param (default) null  : unset $url
 *  	@param $url   : pointer directory or domain url
 *
 *  	Note:: 1) This property ignores its $url if $url parameter supplied in #FM is a domain url
 *  	Note:: 2) The general url set by this property is exited by import(), close() and open() methods but not close('/')
 *
 * C) Resource::name($name) // creates new or selects/activate an existing group 
 * 	 	@param $name: group name to be created or selected
 * 
 * D) Resource::callFile($url), :getFile($url,$store), :addFile($grpname,$url) //adds url to be exectuted
 * 	 	
 *		@property callFile: stores a $url into existing group
 * 	 	@property getFile: executes $url and/or stores depending on $store[true|false] 
 * 	 	@property addFile: stores $url into an existing $grpname            
 *
 *  	@param $url   : local url from root folder space or domain url
 *
 *  	Note:: 1) domain url with no extension can be added using three colons + script extension e.g ($url.':::js'), ($url.':::css')
 *
 * E) Resource::close(true | '\' | '*' ) // closes selected group / clears resource class
 *		@property: stores a $url into existing group
 * 	 	
 *		Resource::close(true): // clears resource class
 * 	 	Resource::close('\') : // safely exits a selected group(s). same as Resource::open();
 *		Resource::close(): (close('*'))  // if a group is selected use close('\') else close(true) 
 * 
 * F)  Resource::parent($url | (default))
 * 	 	
 *		@property: prepends / prefix $url to a stored url which is about to be imported
 *
 * 	 	@param (default): false => exits prefixing
 * 	 	@param $url: $url could be a pointer out of a directory or a domain url
 *
 *  	Note:: 1) any stored domain $url will be ignored during prefixing.
 *
 *
 * G)  Resource::import()  // imports urls stored in groups with their group name
 *		@method 1  :import($grpname) 			 		   => imports a group or lists of groups
 *
 * 	 	@method 2A  :import($prefixUrl,$grpname)           => import:storedUrl($prefixUrl.$url)
 * 	 			2B  :import("pre::".$prefixUrl,$grpname))  => import:($prefixUrl.storedUrl($url)) //same as using :parent() but is safely exited;
 *
 *           foreach $url found in $grpname:
 *
 *              2A  :imports ($prefixUrl + $url) as a single $newurl, where $newurl is validated
 *              2B  :imports $prefixUrl + (($url) as a single url), where $prefixUrl is only a prefix but only $url is validated
 *
 * 	 	@method = 3 (:import($prefixUrl,$grpname,$imports)) $url: $url could be a pointer out of a directory or a domain url
 *  	Note:: 1) any already stored domain $url will not be ignored during prefixing.
 *
 *
 * I)  Resource::export()  //  Takes similar parameters as Resource::import() and returns similar response in array format.
 * 
 * J) Resource::used()       // lists all stored urls
 * K) Resource::active()     // returns group name of any group currently selected else returns false
 * L) Resource::error() // returns errors found when url is being stored called  
 * 
 * 
 * M) Chainable methods are used along with name() static method
 */



/*

  A - RESOURCE SAMPLES 

  NOTE: 
  
  host_protocol : means localhost protocol or server protocol depending on the environment.
  tag(val)      : means url is validated and returns javascript or css tag 
  tag(!val)     : means url is NOT validated and returns javascript or css tag
  :::css        : means return css tag when extenstion is not supplied
  :::js         : means return javascript tag when extenstion is not supplied

  //ungrouped (no name declared)
  Resource::open() //safely close any active name or settings.
  Resource::callFile("core/assets/css/design.css");          # host_protocol/core/assets/css/design.css   : css tag ( val )
  Resource::callFile("core/assets/css/colors.css");          # host_protocol/core/assets/css/colors.css   : css tag ( val )

  //grouped (with name) - active
  Resource::name('css'); 
  Resource::callFile("core/assets/css/design.css");          # host_protocol/core/assets/css/design.css   : css tag ( val )
  Resource::callFile("../core/assets/css/colors.css");       # host_protocol/upper_directory/core/assets/css/colors.css   : tag ( val )
  Resource::callFile("https://www.url.com/item.css");        # https://www.url.com/item.css     : css tag ( !val ) 
  Resource::callFile("https://www.url.com/item:::css");      # https://www.url.com/item         : css tag ( !val )

  //grouped
  Resource::name('js');  // javascript sample - active group
  Resource::callFile("core/assets/jquery/anime.js");         # /fol/core/assets/jquery/anime.js  : js tag ( val )  

  //unsets only the current selection
  Resource::close('/') // (Note: any url stored after this line goes into ungrouped space)
  
  //removes all default settings except stored urls and errors
  Resource::close(false);

  //clears all data stored.
  Resource::close(true);

  Resource::import(":css");                // import urls stored inside css
  Resource::import([":",":css"]);          // import urls stored in ungrouped, css respectively
  Resource::import([":",":css",":js"]);    // import urls stored in ungrouped, css, js respectively
  var_dump(Resource::export([":",":js"]))  // export urls stored in ungrouped & css respectively
  
  //url with protocols are exempted while the rest is prefixed with '../' and also validated when importing
  Resource::import('../',[":",":css"]); 
  Resource::import('pre::../',[":",":css"]);
  
  //set a general global default prefix '../'. All group imported will be affected afterward. 
  Resource::parent("../") // unset this with Resource::parent() 
  Resource::import([":",":css"]); //add ../ to relative urls, import  
  Resource::import("http://url/",[":",":css"]); //first parameter will overide default set by parent.
  Resource::import("pre::../",[":",":css"]); // when pre:: is used, no validation of prefix will be done
  Resource::parent(); // unsets default prefix

  B - AVOID CALLING RESOURCE EVERY TIME
  
  //Avoid calling Resource every time by using chainable methods
    
    Resource::name('some_name')
            ->openUrl()             //same as Resource::open();
            ->url('some_url')       //same as Resource::callFile('some_url'); 
            ->url('some_other_url') //same as Resource::callFile('some_other_url');
    Resource::name('new_name')
            ->url('some_new_url')       //same as Resource::callFile('some_url'); 
            ->url('some_other_url') //same as Resource::callFile('some_other_url');
            ->urlClose();           //same as Resource::close();
*/