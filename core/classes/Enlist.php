<?php

namespace spoova\mi\core\classes;

use ErrorException;
use Exception;
use Closure;
use spoova\mi\core\classes\Ghost\GhostFunction;

/**
 * This package is provides features such as listing files in a directory, 
 * renaming multiple files at once and assigning number to file names in a directory.
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Enlist{

	private $action = '';
	private string $url = '';
	private string $prefix = '';
	private bool $strictPrefix = false;
    private bool|int $debug;
	private bool $active = false;
	private mixed $error = '';
	private array $ext;
	private int $counter = 1;
	private $espace = '';
	private bool|Closure $reNumber = false;
    private bool $allowProcess = false;
	public bool $smartUrl = false;
	public string $session_name;
    public array $backTrace = [];
    public array $result = [];

    /**
     * Format key names automatically categorized - Optional [none,all,all-dot,hidden,dot-ext,name] with pairable as:
     *  - all, hidden|dot-ext (i.e specified hidden file names)
     *  - name(specified), dot-ext|ext(specifed), hidden|dot-ext (i.e specified hidden file names)
     *  - name, ext|all-dot, hidden | dot-ext (i.e specified hidden file names), 
     *  - all, hidden | dot-ext (i.e specified hidden file names)
     *  - name, name-ext, ext, hidden | dot-ext (i.e specified hidden file names), all-dot, 
     * 
     * @var array
     */
    private array $extFormats = [];

    /**
     * Validates the file path supplied
     *
     * @param string $url
     * @return void
     */
	private function processUrl(string $url){
       
        if($this->allowProcess){
            if(!is_dir($url) && !is_file($url)){
                $this->error("invalid path supplied"); 
                return false;
            }
            return true;
        }
        if(!is_dir($url)){ 
            $this->active = false;
            $this->error("invalid url supplied"); 
            return false; 
        } 

        $url = str_replace("\\", "/", $url);    
        $this->url = rtrim($url,"/");
        return true;	

	}

    protected function allowProcess(bool $process){
        $this->allowProcess = $process;
    }

    /**
     * Ensures that there are no conflicting extension names. For example using 
     * '.*' or '*' with normal extension names will return false. 
     *
     * @param array $ext
     * @return boolean
     *  - FALSE when '.*' or '*'  is used with other extension names.
     */
    private function validate_extension(array &$ext = []) : bool {

        $extCount = count($ext);
        
        $namedGroups = [];
        $pattern1 = '/^(?!.+\.$)(([a-zA-Z0-9_\-]+)?\.(\*|[a-zA-Z0-9_\-]*)|\*|[a-zA-Z0-9_\-]+)$/';
        $pattern2 = '/^#([a-zA-Z0-9_\-]*)(\.)?([a-zA-Z0-9_\-]*)?$/';
        $invalid = false;

        $ext = array_map(fn($val) => \strtolower($val), $ext);
        $ext = \array_unique($ext);

        \array_map(function ($item) use($pattern1, $pattern2, &$invalid, &$namedGroups){
            
            $item = trim($item);
            $matched1 = preg_match($pattern1, $item);
            $matched2 = preg_match($pattern2, $item);

            if((!$matched1 && !$matched2 && ($item !== '') && ($item !== '*.'))){
                $invalid = $item; 
                return;
            }else{
                
                if($item === '' || $item === '#'){
                    $namedGroups['none'] = true; //  (all files having name without extension)
                }elseif($item === '*'){
                    $namedGroups['all'] = $item; // name.ext? (all files having names with or without extension excluding hidden)
                }else if($item === '*.'){
                    $namedGroups['all-dot'][] = $item; // name.ext (all files having names with extension excluding hidden)
                }elseif($item === '.'){
                    $namedGroups['hidden'] = true; // .ext (all files having hidden extension names)
                }elseif(\str_starts_with($item, '.')){
                    $namedGroups['dot-ext'][] = substr($item, 1); // .ext (specified hidden extension names)
                }elseif(\str_starts_with($item,'#')){
                    if(\str_ends_with($item,'.')){
                        $namedGroups['name-ext'][] = \substr($item, 1, -1); // specified file names having extension
                    }else{
                        $namedGroups['name'][] = \substr($item, 1); // specified file names having no extension
                    }
                }elseif(strpos($item, '.') === false){
                    $namedGroups['exts'][] = $item; // name (specified file extension names)
                }
            }
        }, $ext);

        // checkd($namedGroups);

        // Ensure real extension names does not end in dot.
        if($invalid) {
            $this->error('invalid extension name format "'.$invalid.'" names detected');
            return false;  
        }

        // checkd($invalid);
        // Proceed with other validations 

        if((array_key_exists('hidden',$namedGroups) && array_key_exists('dot-ext',$namedGroups))){
            $this->error('select all hidden "." and select specified hiddens ".'.implode(', .',$namedGroups['dot-ext']).'" cannot be paired');
            return false;  
        }

        $keys = array_keys($namedGroups);
        $keys_exists = in_array('hidden', $keys) && in_array('all', $keys);
        
        if($keys_exists && \count($keys) > 2){
            $this->error('select all "*" with hiddens "." cannot both be paired with other formats');
            return false;       
        }

        if(array_key_exists('all',$namedGroups)){

            if(array_key_exists('all-dot',$namedGroups)){
                $this->error('extension name formats "*" and "*." cannot be paired');
                // $this->error('invalid extension name formats "*" and "'.$namedGroups['dot-ext'][0].'" cannot be paired');
                return false;  
            }elseif(($test1 = isset($namedGroups['none'])) || isset($namedGroups['name'])){
                $flag = $test1? '#' : '#'.implode(', #',$namedGroups['name']);
                $this->error('select all "*" flag and selection having name only flags ('.$flag.') cannot be paired');
                return false;  
            }elseif(isset($namedGroups['name-ext'])){
                $namedGroups['name-ext'] = array_map(fn($val) => "#".$val.'.', $namedGroups['name-ext']);
                $this->error('select all "*" flag and selection with name flags ('.implode(', ',$namedGroups['name-ext']).') cannot be paired');
                return false; 
            }elseif(isset($namedGroups['exts'])){
                $this->error('select all "*" flag and extension name flags ('.implode(', ',$namedGroups['exts']).') cannot be paired');
                return false; 
            }

        }

        $this->extFormats = $namedGroups;
        return true;

    }

    /**
     * Detect files selection filters pre-defined with {@see Enlist::source()}
     *
     * @return array|string
     */
    final public function filters() : array|string {
        return $this->ext;
    }

    private function exists(string $item){

       $ext = $this->ext;
       return in_array(pathinfo($item, PATHINFO_EXTENSION), $ext);

    }

	/**
	 * set source path
	 *
	 * @param string $url source path
	 * @param array|string $ext sets file extension to be fetched
     *  - Note that the character string '*' is used to denote all extensions.
	 * @return Enlist
	 */
	public function source(string $url, array|string $ext = '*') : Enlist {

       $this->result = [];
       $this->error = ''; // sets error as null everytime source is applied
       $this->ext = [];
       
       if(!$this->processUrl($url)) return $this;

       $ext = (array) $ext;

       if(func_num_args() > 1){

        if(!$this->validate_extension($ext)) {
            $this->active = false;
            return $this;
        }

       }

       $this->ext  = $ext;

       $this->active = true;

       return $this; 

	}

    /**
     * Returns true is the supplied source url (directory path) is valid
     *  - Note that this will not work if the source url is a file path and not a directory path.
     * @return boolean
     */
    public function sourceValid() : bool {
        return $this->active;
    }

	/**
	 * Add a prefix to a naming convention
	 *
	 * @param string $prefix string which is prepended to file name. This should not contain invalid file characters or slashes.
     * @param bool $strict By default, prefix is only added when the old file path is different from the 
     * final resolved file path. Setting this as true ensures that a prefix is always added even when no such difference is encountered 
	 * @return Enlist
	 */
	public function prefix($prefix, bool $strict = false) : Enlist {
		$this->prefix = $prefix;
        $this->strictPrefix = $strict;
        return $this;
	}

	/**
	 * Point from which an incremental naming should start from
	 *
	 * @param integer $startpoint
	 * @return Enlist
	 */
	public function startFrom(int $startpoint) : Enlist {
       $startpoint = $startpoint == 0 ? 1 : $startpoint;
       $this->counter = $startpoint;
       return $this;
	}

	/**
	 * Replace space with character during renaming process
	 *
	 * @param string $replace character to be used to replace spaces
	 * @return Enlist
	 */
	public function reSpace(?string $replace = null) : Enlist {
		$replace = ($replace == null)? "_" : $replace;
		if($replace == "_" || $replace = "-"){
			$this->espace = $replace;
		}
        return $this;
	}

	/**
	 * Reduce special character in old file name when renaming
	 *
     * @param boolean $smart allow smart naming
	 * @return Enlist
	 */
	public function smartUrl(bool $smart = true) : Enlist {
		$this->smartUrl = $smart;
        return $this;
	}

	/**
	 * Allow renaming to re-number the files in a directory
	 *
	 * @param boolean $reNumber
	 * @return Enlist
	 */
	public function reNumber(bool|Closure $reNumber = true) : Enlist{
		$this->reNumber = $reNumber;
        return $this;
	}

	/**
	 * Configures {@see Enlist::rename()} mode to return files only without any active renaming process. 
     * This is useful for checking the expected final names of files to be renamed before they are renamed.
	 * 
	 * @param bool $bool Setting this as true ensures that no active renaming is done.
	 * @return Enlist
	 */
	public function view(bool $bool = true) : Enlist {
		$this->action = ($bool)? 'view' : '';
        return $this;
	}

	/**
	 * Display files in a directory
	 *
	 * @param string|array $extension allowed file extensions
	 * @param boolean $fullpath show full file path when set as true
	 * @return array
	 */
	public function dirFiles(string|array $extension = [], $fullpath = false) : array {

        if(!$this->active) return [];
        $this->result = [];

		$url  = $this->url;
		$files = [];
		$ext = (array) $extension;
        $ext = $ext?: ['*'];
        $dirHidden = [];

        if($this->validate_extension($ext)) {

            $dirNormal = glob($url.'/*')?: [];
    
            if(!empty($ext) && ($ext[0] !== '*')){
                $dirHidden = array_filter(glob($url.'/.*')?: [], 'is_file');
            }
    
            $dirFiles = array_merge($dirHidden, $dirNormal);
    
            foreach($dirFiles as $ifile) {
    
                $baseName = basename($ifile);
    
                if(!empty($ext) and is_file($ifile)){
                    $fileExt = pathinfo($ifile,PATHINFO_EXTENSION);
                    if(in_array(".*", $ext) || in_array("*", $ext)){
                        $files[] = ($fullpath === true)? $ifile : str_replace(str_replace("\\","/",$url.'/'), '', $ifile);
                    }elseif(in_array($fileExt, $ext)){
                        $files[] = ($fullpath === true)? $ifile : str_replace(str_replace("\\","/",$url.'/'), '', $ifile);
                    }elseif(in_array('.', $ext) && (substr($baseName, 0, 1) === '.')){
                        $files[] = ($fullpath === true)? $ifile : str_replace(str_replace("\\","/",$url.'/'), '', $ifile);
                    }
                }elseif(empty($ext)){
                    $files[] = $ifile;
                }	
    
            } 

        }

		return $this->result = $files;
	}

	/**
	 * Renaming directive
     *  - Note that hidden files starting with dot character will not be renamed.
	 *
	 * @param string|boolean $finalExt 
     *  - string is file extension name without a dot prefix
     * @param array $results references the final path name of expected renamed files.
     * @param Closure|null $callback callback to run for every renamed file.
     * @throws Exception if extension supplied is not accepted
	 * @return array|false
     *  - false is returned if error occurs.
	 */
	public function rename(string|bool $finalExt = true, &$results = [], ?Closure $callback = null) : array|false {

        if(!$this->active) return false;

        $this->result = [];
        $url  = $this->url;
        $ext  = $this->ext;
        $counter = $this->counter;
        $prefix = $this->prefix;
        $strictPrefix = $this->strictPrefix;
        $action = $this->action;
        $espace = $this->espace;
        $reNumber = $this->reNumber;
        $files = []; 
        $hiddenMap = [];

        $files = $this->resolveFiles();

        // ensure final extension name supplied looks valid without bad characters.
        if(!preg_match('@^[a-zA-Z0-9_]+$@', $finalExt, $matches)){
            $this->error('invalid character file extension "'.$finalExt.'" supplied on "Elist::rename(#1)"'); 
            return false;
        }

        natsort($files);

        $fUrls = []; $count = 0;

        $countex = 0; $inc = 0;
        foreach ($files as $file) {

            $countex++;
            $file_ext =  pathinfo($file, PATHINFO_EXTENSION);
            $fileExt = ($finalExt === true)? $file_ext : $finalExt;

            $invalidExts = ['*',':','?','|','.', ' '];
            $excludes = ['.','*','.*'];

            if((!empty($ext) && in_array($file_ext, $ext)) || ((in_array($ext[0], $excludes)))) {
                //explode the first names
                $directory = explode("/",$file, -1);
                $dir = implode("/", $directory);

                if($reNumber){
                    $newfile =  $prefix.$counter; 
                }else{
                    $newfile = str_replace($dir."/", '', $file);
                    $newfile = pathinfo($newfile, PATHINFO_FILENAME);
                    if($strictPrefix) $newfile = $prefix.$newfile;
                }

                $newfile = ($espace)? preg_replace("/\s+/", $espace, $newfile) : $newfile;

                if($this->smartUrl){
                    //strip off unnecessary characters from url.
                    $newfile = preg_replace('~[^0-9a-z_]+~i', '_', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($newfile, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
                    $newfile = rtrim(preg_replace('/_+/', '_', $newfile),"_");
                }	  

                $newfile = $dir.'/'.$newfile.'.'.$fileExt;

                if(array_key_exists($file, $hiddenMap)) { 
                    $newfile = $dir.'/'.$hiddenMap[$file];            

                    if($reNumber) $newfile .= $counter;
                    if($fileExt && ($fileExt !== pathinfo($newfile, PATHINFO_EXTENSION))) $newfile .= ".".$fileExt;                
                    $lasthChar = substr($newfile, -1);
                    if(in_array($lasthChar, $invalidExts)){
                        $this->error('invalid character file extension "'.$lasthChar.'" supplied on "Elist::rename()" for renaming "'.basename($file).'"'); 
                        return false;
                    }                
                }

                $lastChar = substr($fileExt, -1);

                if(in_array($lastChar, $invalidExts)){
                    $this->error('invalid character file extension "'.$lastChar.'" supplied on "Elist::rename()" for renaming "'.basename($file).'"'); 
                    return false;
                }

                $fUrls[$file] = $newfile;

                if($action != 'view'){
                    if(strtolower($file) !== strtolower($newfile)){
                        if(isset($this->session_name)){
                            $_SESSION[$this->session_name][$file] = $newfile;
                        }
                       if(is_file($file)) {
                        $inc++;
                        rename($file, $newfile);
                       }
                    }
                }
                if(isset($callback)) {
                    $GhostFunction = new GhostFunction(['files','renamed','done','status']);
                    $GhostFunction->files(fn() => count($files));
                    $GhostFunction->renamed(fn() => $inc); // truly renamed items;
                    $GhostFunction->done(fn() => $countex === count($files));
                    $GhostFunction->status(fn() => round(($countex / count($files)) * 100));
                    $callback($GhostFunction);
                }
            }elseif(empty($ext)){

                if($count == 0){
                    $this->error('Since "Enlist::source(#2)" has no definitive extension name, "Enlist::rename()" cannot be used');
                    return false;
                }
            }
            $count++;
            $counter++;
	    }

        return $results = $this->result = $fUrls;
      
	}

    /**
     * Sets a session storage key for reversing changes when session is active
     *
     * @param string $session_name 
     * @return Enlist
     */
    public function withSession(string $session_name) : Enlist {

        if(!$this->active) return $this;
        if(!isset($_SESSION)) session_start();
        $this->session_name = $session_name;

        return $this;

    }

    /**
     * Reverse renamed files through session storage
     *
     * @param array|null &$reversals
     * @param string $session_name specify a session name
     * @return void
     */
    public function reverse(array|null &$reversals = [], string $session_name = '') {

        if(!$this->active) return ;
        if(isset($_SESSION)){    
            $session_name = (func_num_args() > 1)? $session_name : $this->session_name;
            
            $reversed_items = $_SESSION[$this->session_name] ?? [];
    
            foreach($reversed_items as $old => $new){
    
                if(is_file($new)){
                    $reversals[] = $new;
                    rename($new, $old);
                }
                
            }

            $this->result = $reversals;
    
            if($reversed_items) unset($_SESSION[$this->session_name]);
        }
        
    }

    /**
     * This returns the last data obtained for dirFiles, rename and reverse method depending on if the 
     * source directory url is valid.
     * @param array $data
     * @return void
     */
    public function data(&$data) {

        return $data = $this->result;

    }

	/**
	 * Sets and returns an error encountered during processing for Enlist class
	 *  
	 * @param mixed $error  
     *  If argument is supplied, sets $error by overiding last error, if any. 
	 * @return mixed 
     *  - If not modified, default error is returned as a string.
	 */
	public function error(mixed $error = null) : mixed {
        if(func_num_args() > 0){

            $this->error = $error;

            if(isset($this->debug)) {
                $backTraces = [];
                $backTrace = (debug_backtrace()); 
                $coreTraces = [];

                foreach($backTrace as $Trace){
                    if(isset($Trace['file']) && ($Trace['file'] !== __FILE__)){
                        $backTraces[] = $Trace;
                    }else{
                        $coreTraces[] = $Trace;
                    }
                }

                $backTrace = array_merge($backTraces, $coreTraces);

                $backTrace = array_values($backTrace);

                $this->backTrace = ($backTrace);

                if($this->error && ($this->debug === 2)) {
                   throw new ErrorException ($backTrace[0]['object']->error, 0, E_USER_NOTICE, $backTrace[0]['file'], $backTrace[0]['line']);
                }
            }

        }
		return $this->error;
	}

    /**
     * Turns debugging on. 
     *  This must be used before  Enlist::rename() function is called.
     *
     * @param boolean|integer $debug
     *  - if $debug is set as true, debugging will store all available errors and can be fetched from Enlist::all_errors() method. 
     *  - if $debug is set as 2, an ErrorException will be thrown if error occurs 
     * @return Enlist
     */
    public function debug(bool|int $debug = true) : Enlist {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Returns all back traces where error exists.
     *
     * @param array &$debugs array list of debugs
     * @return array
     */
    public function debugs(&$debugs = []) : array {

        if(!isset($this->debug)) trigger_error('debug should be turned on before "rename()" to use "all_errors()"');

        $backTraces = $this->backTrace; 
        $traces = count($backTraces);

        $errors = [];

        for($i = 0; $i<= $traces; $i++){

            if(isset($backTraces[$i]['object']->error)){
                $traced = $backTraces[$i];
                $errors[$i]['file'] = $traced['file'] ?? '';
                $errors[$i]['line'] = $traced['line'] ?? '';
                $errors[$i]['function'] = $traced['function'] ?? '';
                $errors[$i]['class'] = $traced['class'] ?? '';
                $errors[$i]['error'] = $backTraces[$i]['object']->error;
            }

        }

        return $debugs = $errors;

    }

    /**
     * Resolves selected files using character patterns 
     *
     * @return array
     */
    protected function resolveFiles() : array {

        $url  = $this->url;
        $extFormats = $this->extFormats;
        $files = [];

        $uri = (\str_ends_with($url,'/'))? $url : $url.'/';

        $allHidden =  $extFormats['hidden'] ?? false;
        $allNormalFiles =  $extFormats['all'] ?? false; // non hidden 

        if($allHidden && $allNormalFiles){
            $files = \array_filter(\glob($uri.'{,.}*', \GLOB_BRACE), 'is_file'); // [., *], 
        }elseif($allNormalFiles || $allHidden){

            if($allNormalFiles){
                if(isset($extFormats['dot-ext'])){
                    $namedHiddens = $extFormats['dot-ext'];
                    $files =  \array_filter(\glob($uri.'*', \GLOB_BRACE), 'is_file');
                    $hiddenFiles = \array_filter(\glob($uri.'.{'.implode(',', $namedHiddens).'}*', \GLOB_BRACE), 'is_file');

                    $files = \array_merge($files, $hiddenFiles);
                }else{
                    $files =  \array_filter(\glob($uri.'*', \GLOB_BRACE), 'is_file');
                }
            }else{

                $hasExts = $extFormats['exts'] ?? false; // specified extension names for unhidden files
                $hasOnlyName = $extFormats['none'] ?? false;
                $hasNameInc = $extFormats['name'] ?? false;
                $hasNameExt = $extFormats['name-ext'] ?? false;
                $hasExtOn = $extFormats['all-dot'] ?? false; // non specified extension names for unhidden files
                $flags = compact('hasExts','hasExtOn','hasOnlyName','hasNameInc','hasNameExt');

                // [., ext, #|#name], [., ext, #|#name|#name.] [., ext|#|#name|#name.]
                if(\array_all([$hasExts, $hasExtOn, $hasOnlyName, $hasNameInc, $hasNameExt], fn($value) => $value === false)){
                    $files = \array_filter(\glob($uri.'.*', \GLOB_BRACE), 'is_file');
                }else{
                    $files = \array_filter(\glob($uri.'{,.}*', \GLOB_BRACE), function($file)use($flags){
                        if(is_file($file)){
                            if(\str_starts_with(basename($file),'.')) return true;
                            if($flags['hasOnlyName'] && \pathinfo($file, \PATHINFO_EXTENSION) === '') return true;
                            if($flags['hasNameInc'] && \pathinfo($file, \PATHINFO_EXTENSION) === '' && in_array(strtolower(basename($file)), $flags['hasNameInc'])) return true;
                            if($flags['hasNameExt'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_FILENAME)), $flags['hasNameExt'])) return true;
                            if($flags['hasExts'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_EXTENSION)), $flags['hasExts'])) return true;
                            if($flags['hasExtOn'] && (pathinfo($file, \PATHINFO_EXTENSION) !== '')) return true;
                        }
                        return false;
                    });
                }
            }
        }else{
                // other combinations for unhidden files
                $hasExts = $extFormats['exts'] ?? false; // specified extension names for unhidden files
                $hasOnlyName = $extFormats['none'] ?? false;
                $hasNameInc = $extFormats['name'] ?? false;
                $hasNameExt = $extFormats['name-ext'] ?? false;
                $hasExtOn = $extFormats['all-dot'] ?? false; // non specified extension names for unhidden files
                $flags = compact('hasExts','hasExtOn','hasOnlyName','hasNameInc','hasNameExt');

                $files = \array_filter(\glob($uri.'{,.}*', \GLOB_BRACE), function($file)use($flags){
                    if(is_file($file)){
                        if(\str_starts_with(basename($file),'.')) return false;
                        if($flags['hasOnlyName'] && \pathinfo($file, \PATHINFO_EXTENSION) === '') return true;
                        if($flags['hasNameInc'] && \pathinfo($file, \PATHINFO_EXTENSION) === '' && in_array(strtolower(basename($file)), $flags['hasNameInc'])) return true;
                        if($flags['hasNameExt'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_FILENAME)), $flags['hasNameExt'])) return true;
                        if($flags['hasExts'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_EXTENSION)), $flags['hasExts'])) return true;
                        if($flags['hasExtOn'] && (pathinfo($file, \PATHINFO_EXTENSION) !== '')) return true;
                        return false;
                    }
                    return false;
                });
        }
        
        return $files;
    }

    protected function resolveDirectories() : array {

        $url  = $this->url;
        $extFormats = $this->extFormats;
        $files = [];

        $uri = (\str_ends_with($url,'/'))? $url : $url.'/';

        $allHidden =  $extFormats['hidden'] ?? false;
        $allNormalFiles =  $extFormats['all'] ?? false; // non hidden 

        if($allHidden && $allNormalFiles){
            $files = \array_filter(\glob($uri.'{,.}*', \GLOB_BRACE), fn($file) => is_dir($file) && !in_array(basename($file), ['.','..'])); // [., *], 
        }elseif($allNormalFiles || $allHidden){

            if($allNormalFiles){
                if(isset($extFormats['dot-ext'])){
                    $namedHiddens = $extFormats['dot-ext'];
                    $files =  \array_filter(\glob($uri.'*', \GLOB_BRACE), fn($file) => is_dir($file) && !in_array(basename($file), ['.','..']));
                    $hiddenFiles = \array_filter(\glob($uri.'.{'.implode(',', $namedHiddens).'}*', \GLOB_BRACE), fn($file) => is_dir($file) && !in_array($file, ['.','..']));

                    $files = \array_merge($files, $hiddenFiles);
                }else{
                    $files =  \array_filter(\glob($uri.'*', \GLOB_BRACE), fn($file) => is_dir($file) && !in_array(basename($file), ['.','..']));
                }
            }else{

                $hasExts = $extFormats['exts'] ?? false; // specified extension names for unhidden files
                $hasOnlyName = $extFormats['none'] ?? false;
                $hasNameInc = $extFormats['name'] ?? false;
                $hasNameExt = $extFormats['name-ext'] ?? false;
                $hasExtOn = $extFormats['all-dot'] ?? false; // non specified extension names for unhidden files
                $flags = compact('hasExts','hasExtOn','hasOnlyName','hasNameInc','hasNameExt');

                // [., ext, #|#name], [., ext, #|#name|#name.] [., ext|#|#name|#name.]
                if(\array_all([$hasExts, $hasExtOn, $hasOnlyName, $hasNameInc, $hasNameExt], fn($value) => $value === false)){
                    $files = \array_filter(\glob($uri.'.*', \GLOB_BRACE), fn($file) => is_dir($file) && !in_array(basename($file), ['.','..']));
                }else{
                    $files = \array_filter(\glob($uri.'{,.}*', \GLOB_BRACE), function($file)use($flags){
                        if(is_dir($file)){
                            $baseName = basename($file);
                            if(in_array($baseName,['.','..'])) return false;
                            if(\str_starts_with($baseName,'.')) return true;
                            if($flags['hasOnlyName'] && \pathinfo($file, \PATHINFO_EXTENSION) === '') return true;
                            if($flags['hasNameInc'] && \pathinfo($file, \PATHINFO_EXTENSION) === '' && in_array(strtolower($baseName), $flags['hasNameInc'])) return true;
                            if($flags['hasNameExt'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_FILENAME)), $flags['hasNameExt'])) return true;
                            if($flags['hasExts'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_EXTENSION)), $flags['hasExts'])) return true;
                            if($flags['hasExtOn'] && (pathinfo($file, \PATHINFO_EXTENSION) !== '')) return true;
                        }
                        return false;
                    });
                }
            }
        }else{
                // other combinations for unhidden files
                $hasExts = $extFormats['exts'] ?? false; // specified extension names for unhidden files
                $hasOnlyName = $extFormats['none'] ?? false;
                $hasNameInc = $extFormats['name'] ?? false;
                $hasNameExt = $extFormats['name-ext'] ?? false;
                $hasExtOn = $extFormats['all-dot'] ?? false; // non specified extension names for unhidden files
                $flags = compact('hasExts','hasExtOn','hasOnlyName','hasNameInc','hasNameExt');

                $files = \array_filter(\glob($uri.'{,.}*', \GLOB_BRACE), function($file)use($flags){
                    if(is_dir($file)){
                        $baseName = basename($file);
                        if(in_array($baseName,['.','..']) || \str_starts_with($baseName,'.')) return false;
                        if($flags['hasOnlyName'] && \pathinfo($file, \PATHINFO_EXTENSION) === '') return true;
                        if($flags['hasNameInc'] && \pathinfo($file, \PATHINFO_EXTENSION) === '' && in_array(strtolower(basename($file)), $flags['hasNameInc'])) return true;
                        if($flags['hasNameExt'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_FILENAME)), $flags['hasNameExt'])) return true;
                        if($flags['hasExts'] && in_array(\strtolower(\pathinfo($file, \PATHINFO_EXTENSION)), $flags['hasExts'])) return true;
                        if($flags['hasExtOn'] && (pathinfo($file, \PATHINFO_EXTENSION) !== '')) return true;
                        return false;
                    }
                    return false;
                });
        }
        
        return $files;
    }

    

}

?>