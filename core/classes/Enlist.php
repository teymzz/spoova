<?php

namespace teymzz\spoova\core\classes;

/**
 * This class is used mainly to Rename multiple images at once
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
class Enlist{

	private $action;
	private $url;
	private $prefix;
	private $active = false;
	private $error;
	private $ext;
	private $counter = 1;
	private $espace;
	private $reNumber;
	public $smartUrl;

	private function processUrl($url){
       
       if(!is_dir($url)){ $this->error("invalid url supplied"); return false; } 
       $url = str_replace("\\", "/", $url);    
       $this->url = rtrim($url,"/");
       return true;	

	}

	/**
	 * set source path
	 *
	 * @param string source $url
	 * @param string source $ext
	 * @return void
	 */
	public function source($url, $ext=null){
       
       if(!$this->processUrl($url)){ return false; }

       $this->ext  = $ext;

       $this->active = true;

	}

	/**
	 * Add a prefix to a naming convention
	 *
	 * @param string $prefix
	 * @return void
	 */
	public function prefix($prefix){
		$this->prefix = $prefix;
	}

	/**
	 * Point from which an incremental naming should start from
	 *
	 * @param integer $startpoint
	 * @return void
	 */
	public function startFrom(int $startpoint){
       $startpoint = $startpoint == 0 ? 1 : $startpoint;
       $this->counter = $startpoint;
	}

	/**
	 * Replace space with character during renaming process
	 *
	 * @param string $replace
	 * @return void
	 */
	public function reSpace($replace = null){
		$replace = ($replace == null)? "_" : $replace;
		if($replace == "_" || $replace = "-"){
			$this->espace = $replace;
		}
	}

	/**
	 * Reduce special character in old file name when renaming
	 *
	 * @return void
	 */
	public function smartUrl(){
		$this->smartUrl = true;
	}

	/**
	 * Allow renaming to re-number the files in a directory
	 *
	 * @param boolean $reNumber
	 * @return void
	 */
	public function reNumber($reNumber = true){
		$this->reNumber = (bool) $reNumber;
	}

	/**
	 * Resolve renaming to display mode without any active renaming process
	 *
	 * @param string $type
	 * @return void
	 */
	public function view(bool $bool = true){
		$this->action = ($bool)? 'view' : '';
	}

	/**
	 * Display files in a directory
	 *
	 * @param array $extension allowed file extensions
	 * @param boolean $fullpath show full file path when set as true
	 * @return array
	 */
	public function dirFiles($extension = [], $fullpath = false) : array {
		$url  = $this->url;
		$files = [];
		$ext = (array) $extension;

		foreach(glob($url.'/*') as $ifile) {

			if(!empty($ext) and is_file($ifile)){
				$fileExt = pathinfo($ifile,PATHINFO_EXTENSION);
				if(in_array($fileExt,$ext)){
					$files[] = ($fullpath === true)? $ifile : str_replace(str_replace("\\","/",docroot.DS), '', $ifile);
				}
			}elseif(empty($ext)){
				$files[] = $ifile;
			}	

		}
		return $files;
	}

	/**
	 * Renaming directive
	 *
	 * @param boolean $finalExt
	 * @return array
	 */
	public function reName($finalExt = true) : array {

	  if(!$this->active){ return false; }
	  $url  = $this->url;
	  $ext  = (array) $this->ext;
	  $counter = $this->counter;
	  $prefix = $this->prefix;
	  $action = $this->action;
	  $espace = $this->espace;
	  $reNumber = $this->reNumber;
      $files = [];

	  foreach(glob($url.'/*') as $ifile) {

	  	if(is_file($ifile)){
	  		$files[] = $ifile;
	  	}	

	  }

	  natsort($files);

      $fUrls = []; $count = 0;

	  foreach ($files as $file) {
	  	$fileExt = ($finalExt === true)? pathinfo($file,PATHINFO_EXTENSION) : $finalExt;

	  		if(!empty($ext) and in_array($fileExt, $ext)){
	  			//explode the first names
	  			$directory = explode("/",$file, -1);
	  			$dir = implode("/", $directory);

	  			if($reNumber){
	  				$newfile =  $prefix.$counter; 
	  			}else{
	  				$newfile = str_replace($dir."/", '', $file);
	  				$newfile = pathinfo($newfile,PATHINFO_FILENAME);
	  			}

	  			$newfile = ($espace)? preg_replace("/\s+/", $espace, $newfile) : $newfile;
	  			if(isset($this->smartUrl)){
	  				//strip off unnecessary characters from url.
	  				$newfile = preg_replace('~[^0-9a-z_]+~i', '_', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($newfile, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
	  				$newfile = rtrim(preg_replace('/_+/', '_', $newfile),"_");
	  			}	  			
	  			
	  			$newfile = $dir.'/'.$newfile.'.'.$fileExt;
	  			
	  			$fUrls[] = $newfile;

	  			if($action != 'view'){
	  				rename($file,$newfile);
	  			}
	  		}elseif(empty($ext)){
				if($count == 0) print '<font color="red">Note: set file extension of files to be renamed.</font> <br><br> Listing Files: <br>';
	  			print $file.'<br>';
	  		}
			$count++;
	  	$counter++;
	  }

	  return $fUrls;
      
	}

	/**
	 * Sets error encountered during processing
	 *
	 * @param string $error
	 * @return void
	 */
	public function error($error){
		$this->error = $error;
	}

}

/**
 *
 *$Enlist = new Enlist;
 *$Enlist->source($fullpath,$selected_extensions);
 *         @param string $fullpath: full directory of item to be renamed
 *
 *$Enlist->startFrom($counter);
 *         @param string $counter: dynamic unique filename;
 *
 *$Enlist->prefix($labelName);
 * 	       @param string $labelName: static prefix name for $counter
 *
 *$Enlist->reName($extension_of_ouput); 
 *         @param string $extension_of_output (optional)
 *
 */
/**
 *
 * @example:
 *
 * $Enlist = new \core\tools\Enlist;
 * $Enlist->source(dirname(__FILE__)."/main/images/pexels","jpg"); 
 * $Enlist->prefix("list"); //static name of files (prefix)
 * $Enlist->startFrom(0); //dynamic counter appended to prefix to make file unique
 * $Enlist->reName('jpg'); //rename files to jpg. if parameter is not defined, default file extension is used
 *
 */ 



