<?php

namespace spoova\mi\core\classes\Bundle\Filemanager;

use Closure;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use spoova\mi\core\classes\Bundle\Filemanager\FileTransfer;
use spoova\mi\core\classes\Bundle\Filemanager\FileCompressor;
use spoova\mi\core\classes\Bundle\Enlist\Enlist;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use ZipArchive;

/**
 * This is a powerful class for managing files & folders
 */
class Filemanager extends Enlist{

    private const DS = DIRECTORY_SEPARATOR;

    /**
     * Contains defined configuration options
     *
     * @var array
     */
    private array $options = [

      // File compression settings
      'unzipper-allow-directories' => false, //allows decompression to existing directories

      // File encryption settings (legacy format - retained for reading old files)
      'file-encryption-method' => 'AES-256-CBC',
      'file-encryption-option' => OPENSSL_RAW_DATA,
      'file-encryption-algo' => 'SHA256',
      'file-encryption-binary' => TRUE,

    ];

    /**
     * Magic header written in front of every file encrypted with the current format.
     * Its presence is what tells {@see Filemanager::decryptPayload()} whether a payload
     * uses the current (salted, authenticated) format or the legacy one.
     */
    private const encHeader = "SPVE1\0";

    /** Length in bytes of the random per-file key derivation salt */
    private const encSaltLen = 16;

    /** Length in bytes of the random AES-GCM nonce */
    private const encIvLen = 12;

    /** Length in bytes of the AES-GCM authentication tag */
    private const encTagLen = 16;

    /** Cipher used by the current encryption format */
    private const encMethod = 'aes-256-gcm';

    /** PBKDF2 round count used to derive a file key from a password */
    private const encIterations = 210000;

    /**
     * Specifies the default storage key for environment data
     *
     * @var string
     */
    private static string $envKey = ':ENV';

    /**
     * Specifies the environment data (env)
     *
     * @var array
     */
    private static array $envData = [];

    /**
     * Determines the primary separator between a configuration 
     * key and its relative value
     *
     * @var string
     */
    private string $separator = ':'; // default used if not overridden

    /**
     * Determines when method execution constraint is overruled
     *
     * @var boolean
     */
    private bool $execute = false;
    
    /**
     * Callback function on each successful file added to zip
     *  - Closure takes {@see FileCompressor} as argument
     * @var Closure|null
     */
    private ?Closure $zipProgress = null;
    
    /**
     * Set a security key
     *
     * @var string|false
     */
    private string|false $security = false;

    /**
     * Defines the source url
     *
     * @var string
     */
    private string $path = '';

    /**
     * Determines the last url
     *
     * @var string
     */
    private string $lastDir = '';

    private string $delimiter = ';';

    /**
     * Determines the last tracked directory or file
     *
     * @var string
     */
    private string $lastPath = '';

    /**
     * Defines the delete state
     *
     * @var boolean|integer
     *  - False: not deleted 
     *  - 0: some items deleted 
     *  - 1: all items deleted
     */
    private false|int $deleteState = false; 

    /**
     * specifies a zip file output name
     *
     * @var string
     */
    private string $zipName;

    /**
     * specifies a zip file output destination path
     *
     * @var string
     */
    private ?string $zipPath = '';

    /**
     * specifies the directory to which a zip file is dumped.
     *
     * @var string
     */
    private string $zipDir = '';

    /**
     * specifies the directory to which an unzipped file is dumped.
     *
     * @var string
     */
    private string $unzipDir = '';

    /**
     * specifies when a zip is successfully unzipped
     *
     * @var boolean
     */
    private bool $unzipped = false;

    /**
     * specifies when a zip is successfully zipped
     *
     * @var boolean
     */
    private bool $zipped = false;

    /**
     * stores a zip error message
     *
     * @var string|false
     */
    private string|false $zipError = false;

    /**
     * Contains the last error response
     *
     * @var string
     */
    private string $response = '';

    /**
     * Contains the last error detected
     *
     * @var mixed
     */
    private $error;

    /**  
     * Contains information about transfer progress when copying or moving files 
     * @var array $fileTransfer 
     **/
    private array $fileTransfer;

    /**
     * Checks if an array exists inside another array
     *
     * @param array $value
     * @return bool
     */
    private function arrInside(array $value) : bool{
      //check if array exists inside another $value
      foreach ($value as $val) {
        if(is_array($val)) return true;
      }
      return false;
    }

    private function shouldDeletePath(string $path, array $excludes = [], array $includes = []) : bool {
      if($includes){
        return in_array($path, $includes, true);
      }

      if($excludes){
        return !in_array($path, $excludes, true);
      }

      return true;
    }

    private function countExpectedDeletions(string $path, array $excludes = [], array $includes = []) : int {
      if(!file_exists($path)) return 0;
      if(is_file($path)) return $this->shouldDeletePath($path, $excludes, $includes) ? 1 : 0;
      if(!is_dir($path)) return 0;

      if(!$this->shouldDeletePath($path, $excludes, $includes)) return 0;

      $count = 1;
      $items = array_diff(scandir($path), ['.','..']);

      foreach($items as $item){
        $itemPath = $path.'/'.ltrim(rtrim(self::normalize_path($item), '/'), '/');

        if(is_dir($itemPath) && !is_link($itemPath)){
          $count += $this->countExpectedDeletions($itemPath, $excludes, $includes);
        } elseif($this->shouldDeletePath($itemPath, $excludes, $includes)) {
          $count++;
        }
      }

      return $count;
    }

    private function setDeleteState(array $removals, int $expected) : void {
      $removedCount = count(array_unique($removals));

      if($removedCount === 0){
        $this->deleteState = false;
      } elseif($expected <= 0){
        $this->deleteState = 1;
      } elseif($removedCount >= $expected){
        $this->deleteState = 1;
      } else {
        $this->deleteState = 0;
      }
    }

    private static function normalize_path(string $path) : string {
      return \str_replace(['\\','/'], '/', $path);
    }

    /**
     * Determines whether a path sits inside (or is) an excluded path.
     *  - Both arguments must already be separator-normalized by {@see Filemanager::normalize_path()}.
     *  - Matching stops at a path boundary, so "vendor" cannot exclude "vendorlib".
     *  - Comparison follows the host filesystem: case-insensitive on Windows, case-sensitive elsewhere.
     * @param string $path normalized path of the file being tested
     * @param string $excluded normalized path of the excluded file or directory
     * @return boolean
     */
    private static function isSubPath(string $path, string $excluded) : bool {
      $excluded = \rtrim($excluded, '/');
      if($excluded === '') return false;

      $length = \strlen($excluded);
      $prefix = \substr($path, 0, $length);

      $matched = (\PHP_OS_FAMILY === 'Windows')
        ? (\strcasecmp($prefix, $excluded) === 0)
        : ($prefix === $excluded);

      if(!$matched) return false;

      // the excluded file itself, or a real segment boundary below it
      $next = \substr($path, $length, 1);
      return $next === '' || $next === '/';
    }

    /**
     * Returns TRUE for critical errors. Most zip operation 
     * related errors are not checked, however, if a zip file or extraction directory path is invalid, 
     * this will flag TRUE.
     *
     * @return boolean
     */
    private function hasError() : bool {
      //prevent or allow further code execution if has previous error
      if($this->error && !$this->execute) return true;

      //modify error status on strict code execution if has previous error
      if($this->error && $this->execute) $this->error = false; 
      return false;
    }

    /**
     * Sets a source path for reading content
     *  - Note: if only one argument is supplied, updates the value of {@see Filemanager::lastPath()}
     * @param string $url path of file or folder to be managed
     * @param array|bool|string $setSource when defined, uses {@see Enlist::source()} and sets the file extensions to be read from a directory.
     *    - If argument is manually defined as TRUE or '*', this will assume the default value of Enlist::source() 
     *    - Note that the character '*' or boolean(true) defines all extension as in the case of {@see Enlist::source()}
     * @return Filemanager|Enlist
     *    - Returns Filemanager class when only one argument is defined.
     *    - Returns Enlist class when argument 2 (i.e $setSource) is defined
    */
    public function setUrl(string $url = '', array|bool|string $setSource = '*') : Filemanager|Enlist {
      if(func_num_args() > 1) {
        if($setSource === true) return $this->source($url);
        return $this->source(...func_get_args());
      }
      $this->path = $url;
      $this->lastPath = $url;
      return $this;
    }


    /**
     * Sets source path primarily for directories and conditionally for files paths
     *  - Setting file paths is only useful with zipping and unzipping files and only one argument must be supplied.
     *  - Updates the file path returned by {@see Filemanager::lastPath()}
     * @param string $url source url primarily for directory paths but conditionally support file paths.
     *  - Note that $url will only accept file path that if only one argument is supplied and the file path supplied is valid
     * @param array|string $ext file extensions to be retrieved
       *  - Note that the character string '*' is used to denote all extensions.
     * @return Enlist
     */
    final public function source($url, array|string $ext = '*') : Enlist {

      if(is_file($url) && func_num_args() === 1){
        $this->allowProcess(true);
        parent::source($url);
        $this->allowProcess(false);
      }else{
        parent::source($url, $ext);
      }
      $this->path = $url;
      $this->lastPath = $url;
      return $this;
    }

    /**
     * Sets universal delimiter character
     * 
     * @param string $delimiter any of the characters ';' or '|' or empty string ''
     *  - Note that character defined as delimiter should not exist in any expected value.
     */
    public function delimiter(string $delimiter = '') {
      $this->delimiter = $delimiter;
      return $this;
    }

    /**
     * Sets universal separator character
     * 
     * @param string $separator separator character 
     */
    public function separator(string $separator = ':') {
      $this->separator = $separator;
      return $this;
    }

    /**
     * Get the folders existing in the url supplied
     *
     * @param boolean $fullPath 
     *  - false returns only the folder names
     * @return array
    */
    public function getFolders(bool $fullPath = true){
      if($this->path == null){ return $this->response('invalid url supplied'); }

      $dirs = $this->resolveDirectories();

      if(!$fullPath){
        $dirs = array_map(function($folder){
          return pathinfo($folder, PATHINFO_BASENAME);
        }, $dirs);
      }

      return array_values($dirs);
    }

    /**
     * Get the folder and file contents of a directory
     *
     * @param boolean $fullPath 
     *  - false returns only the content names
     * @param string $items optional [files|folders|all]
     * @return array
    */
    public function getContents(bool $fullPath = true, string $items = 'all'){
      if($this->path == null){ return $this->response('invalid url supplied'); }

      $files = $dirs = [];

      if(in_array($items,['files','all'])) $files = $this->resolveFiles();
      if(in_array($items,['dirs','all'])) $dirs = $this->resolveDirectories();

      $files = array_filter($files, 'file_exists'); //only files
      $contents = array_merge($files, $dirs);

      if(!$fullPath){
        $contents = array_map(function($item) {
          return pathinfo($item, PATHINFO_BASENAME);
        }, $contents);
      }

      return array_values($contents);
    }

    /**
     * Get the files (without folders) existing in the url supplied
     *  - Note that this will be affected if file extension is declared by default
     * @param boolean $fullPath 
     *  - false returns only the file names
     * @param boolean $addExtension false removes extension name of files 
     * @return array
    */
    public function getFiles(bool $fullPath = true, $addExtension = true){

      if($this->path == null){ return $this->response('invalid url supplied'); }
      
      $files = $this->resolveFiles();

      if(!$fullPath){
        $files = array_map(function($file) use($addExtension) {
          if(!$addExtension) return pathinfo($file, PATHINFO_FILENAME);
          $path = pathinfo($file, PATHINFO_BASENAME);
          return $path;
        }, $files, array_keys($files));
      }

      return array_values($files);
    }

    /**
     * - Reads a list of keys or key from a file and returns an array of keys and values
     * - Checks if a key exists in file if second argument is set as true.
     * - Generates E_USER_ERROR if file is not readable or separator is the same as delimiter (;)
     * 
     * @todo Add muliple delimiter support (currently using semicolon)
     * @param array|string $key list of key(s) to be fetched from file. Bool:true reads entire file
     * @param string|bool $separator A line key-to-value unique separator character
     *
     * @return array|string|bool returns an string, array or bool depending on arguments supplied
     *    - (array) array of keys and values => if type of $key is array and typeof $separator character is string.
     *    - (string)                         => if type of $key is string and type of $separator is string.
     *    - (bool) true                      => if $separator === true and string of $key exists in file
     *    - (bool) false                     => if $separator === true and string of $key does not exists in file or file in not readable
     * 
     */
    public function readFile(string|array|null $key = null, string|bool $separator= ":"){
      
      if(!is_readable($this->path)){
        trigger_error("url \"".$this->path."\" is not readable");
        return false;
      }   

      $delimiter = $this->delimiter;
      
      $separator = (func_num_args() < 2)? $this->separator : $separator;
      if(trim($separator) === $delimiter) trigger_error("separator cannot be the same as delimiter", E_USER_ERROR);
      
      if(empty($key)) return false;
      $reading = fopen($this->path, 'r');
      $line =  '';
      
      $isArrayKey = is_array($key);

      //load supplied keys
      if($key !== null) $key = (array) $key;  
  
      if( (empty($key) || !is_array($key)) ) return false;


      $key  = array_unique($key);
      $keyslen  = count($key);
      $data_array = [];

      //* set a textkey for single data types
      if($keyslen == 1){
        $nkey = $key;
        sort($nkey);
        $textkey = $nkey[0];
      }

      while (!feof($reading)) {
          $line = fgets($reading);
                
          if($separator != null && $separator !== true){
            
            $textkeys = $key;

            foreach($textkeys as $keyindex => $textkey){
              
              //* remove unecessary keys from $key list
              if(is_array($textkey)):

                unset($key[$keyindex]);
                continue;

              endif;
                
              if (
                  ($lineText1 = stristr($line, $textkey.$separator)) || 
                  ($lineText2 = stristr($line, $textkey." ".$separator))
                  ) 
                  { 
                  
                  $lineText = (empty(trim($lineText1)) && isset($lineText2))? $lineText2 : $lineText1;

                  //* find key value using delimiter
                  $lineText = rtrim(trim($lineText), $delimiter.' ');

                  //* add space if necessary
                  if(!empty($lineText2)) $textkey .= " ";
                  $lineText = explode($separator, $lineText, 2);
                  

                  if(in_array($textkey,$lineText) and array_key_exists(1,$lineText)){


                      if($keyslen === 1){
                        
                        $value = empty(trim($lineText[1]))? $lineText[1] : trim($lineText[1]);

                        if((substr($value, 0 , 1) === '[') and ($value[-1] === "]")){
                         
                          $value = ltrim(rtrim($value,"]"),"[");
                          if($isArrayKey){
                            fclose($reading);
                            return $data_array[$textkey] = json_decode($value);
                          }else{
                            fclose($reading);
                            return json_decode($value);
                          }
                          
                        }else{
                          if($isArrayKey){
                             $data_array[$textkey] = ltrim($value, " ");
                             fclose($reading);
                             return $data_array;
                          }else{
                            fclose($reading);
                            return ltrim($value," ");
                          }
                        }
                        fclose($reading);
                        return $data_array;
                      }else{
                        $data_array[$key[$keyindex]] = ltrim($lineText[1], " ");
                      } 
                  }

                //* remove found key from $keys list
                unset($key[$keyindex]);
              }else{
                $data_array[$key[$keyindex]] = '';
              }           
            }

          }elseif($separator === true){
            
            //* for reading single data

            if($keyslen == 1){
              if($lineText = stristr($line,$textkey)){
                fclose($reading);
                return (stristr($line,$textkey))?? false;
              }
            }else{
              foreach($key as $keyindex => $textkey){
                if ($lineText = stristr($line,$textkey)) { 

                    //* unset text key
                    unset($key[$keyindex]);

                    $data_array[$textkey] =  $lineText;
                  
                } 
              }              
            }

          }
      }

      if(!$isArrayKey){
        fclose($reading);
        return false;
      }
      fclose($reading);
      return (!empty($data_array))? $data_array : $this->response('no match key found in url supplied');
      
    }

    /**
     * Create a new file if not exists
     *  - Note that this will return false if the expected file is not readable even if it exists. 
     * @param bool $strict true creates directory if not exist
     *  - This specifies if a file's directory should be created when it does not exist where the directory name 
     *    is derived from the file path supplied. This will trigger an error if no directory name is detected.
     * @param string $url optional url path for the file to be created.
     *  - Note that when not supplied, this uses default url.
     * @return bool true if directory exists or is created successfully and accessible
     */
    public function openFile(bool $strict = false, string $url = '') : bool {
      
      //get default set directory
      $fileUrl = $url ? $url : $this->path;

      if(func_num_args() > 1){
        $fileUrl = func_get_args()[1];
      }

      $fileDir = pathinfo($fileUrl, PATHINFO_DIRNAME);
      
      //Test or try to enforce a directory creation
      if( !is_dir($fileDir) ){
        if($strict && $fileDir){
          if(!mkdir($fileDir, 0777, true)) return false;
        }else{
          if(!$fileDir){
            trigger_error('no directory name supplied');
          }
          return false;
        }
      }

      //create file if not already exist
      if( !is_file($fileUrl) ) {
        touch($fileUrl);
      }
      return is_readable($fileUrl);
    }

    /**
     * Create a new file if not exists without class instantiation. Allows the use of file paths.
     *  - Note that this will return false if a file is not readable even if it exists.
     *
     * @param string $filepath sets the path of the file to be created.
     * @param array $options sets a list of options 
     *  - mkdir : FALSE(disables) or TRUE(enables) a file path's directory creation if directory does not exist. Default (TRUE)
     *  - clean : FALSE(disables) or TRUE(enables) the overwriting of an existing file. Default (FALSE) 
     * 
     * @return int|false
     *    - false : if file exists and but is not accessible
     *    - 0 : if file does not exist and cannot be created
     *    - 1 : if file already exists
     *    - 2 : ONLY if a new file is created
     */
    public static function createFile(string $filepath, array $options = []) : int {
      
      //get default set directory
      $mkdir = $options['mkdir'] ?? true; 
      $overwrite = $options['clean'] ?? false; 

      $fileDir = pathinfo($filepath, PATHINFO_DIRNAME);
      
      //Test or try to enforce a directory creation
      if( !is_dir($fileDir) ){
        if($mkdir && $fileDir){
          if(!mkdir($fileDir, 0777, true)) return false;
        }else{
          if(!$fileDir){
            trigger_error('no directory name supplied');
          }
          return false;
        }
      }

      $status = false;

      //create file if not already exist
      if( !is_file($filepath) ) {
        $status = touch($filepath) ? 2 : 0;
      }else{
        if($overwrite){
          if(is_writable($filepath)){
            file_put_contents($filepath, '');
            if(is_readable($filepath)){
              return filesize($filepath) === 0;
            }else{
              return false;
            }
          }else{
            return false;
          }
        }else{
          $status = 1;
        }
      }

      return is_readable($filepath)? $status : false;

    }

    /**
     * Create multiple paths at a go
     *
     * @Note: This will create directories if it does not exist
     * @param string[] $urls list of paths to be created
     * @param array &$files contains referenced list of paths created
     * @return bool
     */
    public function openFiles(array|string $urls, &$files = []) : bool {

      if(func_num_args() > 1){
        $urls = func_get_args();
      }else{
        $url = (array) $urls;
      }

      if(!$this->arrInside($urls)){
        $counter = 0;
        foreach($urls as $url){

          if(trim($url)) {

            if($this->openFile(true, $url)) {
              $files[] = $url;
            }else{
              return false;
            }

          }

          $counter++;

        }

        return $counter == count($urls);

      } else {
        trigger_error('supplied url cannot contain arrays');
        return false;
      }

    }

    /**
     * Write a text into a file line
     *
     * @param array $data array list of keys and respective values to be added to file
     * @param array $options postions to add new text [before, after], settings
     * @return boolean returns true if any text is added
     */
    public function textWrite(array $data, array $options = []) : bool{
      
      //construct text format
      $newText = '';
      $separator = ($options['separator'])?? $this->separator;
      $delimiter = $this->delimiter;
      if($separator === $delimiter) trigger_error("separator cannot be the same as delimiter", E_USER_ERROR);

      foreach($data as $key => $value){
        if(is_numeric($key)) trigger_error('keys must have a string name',E_USER_ERROR);
        $newText .= " ".$key.$separator." ".(is_array($value)? "[".json_encode($value)."]" : $value).$delimiter."\n";  
      }

      $newText = rtrim(preg_replace('/[[:blank:]]+/',' ',$newText));
      $newText = $this->reFormat($newText);
      return $this->writerEngine($newText, $options, 'wFile');
    }

    /**
     * Updates an existing text key or adds a new text 
     *
     * @param string|array $data data of array key(s) with new values to be added to file
     * @param void|array $replacements reference to updated keys
     * @param string $separator separator character
     * @return boolean
     */
    public function textUpdate($data, &$replacements = '', string $separator = ":") : bool {

      $fileUrl = $this->path;
      if(!is_file($fileUrl)) return false;  

      $reading = fopen($fileUrl, 'r');
      $delimiter = $this->delimiter;

      $separator = (func_num_args() < 3)? $this->separator : $separator;

      if(trim($separator) == '') trigger_error('separator cannot be null', E_USER_ERROR);

      $replaced = false;
      $replacements = [];
      $arrLines = [];

      while (!feof($reading)) {
        $line = fgets($reading);
        
        $line = ltrim($line);
        $line = (empty($line))? "\n" : " ".$line;

        foreach($data as $datakey => $dataValue){
          if(is_numeric($datakey)) trigger_error('data keys should not be integers', E_USER_ERROR);
          if(is_array($dataValue)){
            //wrap array values as json in square brackets
            $dataValue = "[".json_encode($dataValue)."]";
          }
          
          if(empty(ltrim($datakey) || empty($line))) continue;
          
          if (stristr($line, $datakey.$separator)){        
            $replaced = true;
            $replacements[] = $datakey;
            $line = explode($separator, $line, 2);
            $line = $line[0].$separator." ".$dataValue.$delimiter."\n";
            unset($data[$datakey]);
            break;
          }
        }
        $arrLines[] = ltrim(rtrim($line));
        
      }
    
      if(!empty($data)){
          $replaced = true;
          foreach($data as $key => $value){
            if(is_numeric($key)) trigger_error('keys must have a string name',E_USER_ERROR);

            //may later require trimming...
            $arrLines[] = ($key.$separator." ".(is_array($value)? "[".json_encode($value)."]" : $value)).$delimiter;

          }
      }

      fclose($reading);

      if ($replaced) {
        $writing = fopen($fileUrl.'_.tmp', 'w');
        
        $newLines = '';
        foreach($arrLines as $arrLine){
          $newLines .= empty($arrLine)? "\n" : "\n ".$arrLine; 
        }
        $newLines = "\n ".ltrim($newLines, "\n ");
        
        sleep(1);
        fputs($writing, $newLines); 
        fclose($writing);
        rename($fileUrl.'_.tmp', $fileUrl);
      }

      return $replaced;

    }


    /**
     * Adds lines into a file
     *
     * @param int  $newline number of lines to be added
     * @param array $options postions to add new text [before, after]
     * @return bool true if any text is added
     */
    public function textLine(int $newline = 1, array $options = []) : bool {
     
      
      if($newline == 0) return false;
      
      $newText = '';

      for($i = 1; $i <= $newline; $i++){
       $newText .="\n";
      }

      return $this->writerEngine($newText, $options, 'wLine');

    }

    /**
     * Deletes a line or lists of lines using line key
     *
     * @param string[] $keys line key or array of lines keys
     * @param array &$dels anchors/contains array of keys deleted keys
     * @param string $separator A key to value separator
     *  - A separator should not exist twice on a single line
     * @return bool true if any text was deleted
     */
    public function textDelete(array|string $keys, &$dels = [], string $separator = ":"){
     
      $fileUrl = $this->path;
      if(!is_file($fileUrl)) return false;

      $separator = (func_num_args() < 3)? $this->separator : $separator;

      $reading = fopen($fileUrl, 'r');
      $lines   = '';
      $edited  = false;
      $keys = (array) $keys;

      foreach($keys as $key){
        if(is_array($key)) trigger_error('keys cannot be of array value', 'E_USER_ERROR');
      }

      $dels = [];

      while (!feof($reading)) {
        $line = fgets($reading);
        $found = false;
        
        $line = ltrim($line);

        foreach($keys as $linekey){
          
          if (stristr($line,$linekey.$separator)){
            $line = " ";
            $dels = [$linekey];
            $found = true;
            break;
          }
        }

        if(!$found){
          $lines .= " ".$line;
        }else{
          $edited = true;          
        }

      }
      
      fclose($reading);

      if ($edited) {
        $writing = fopen($fileUrl.'_.tmp', 'w');
        $lines = "\n ".ltrim(rtrim($lines));
        fputs($writing, $lines);
        fclose($writing);
        rename($fileUrl.'_.tmp', $fileUrl);
      }

      return $edited;
    }    

    /**
     * Read Entire File
     *
     * @param string $separator A key to value separator (e.g 'key: value' or  'key= value' )
     *  - A separator should not exist twice on a single line
     * @return array Returns array of keys and value pairs
     *  - Note that a delimiter of semicolon (i.e ";") will be trimmed off
     *  - It is better to specify the character separator to avoid any uncertainty
     */
    public function readAll(string $separator = ':') {

      if(!is_readable($this->path)){
        trigger_error("url ".$this->path." is not readable");
        return false;
      }   

      $delimiter = $this->delimiter;
      $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $contents = [];

      foreach($lines as $line) {

        if (strpos(trim($line), '#')) continue;
        if(pathinfo($this->path, PATHINFO_EXTENSION) == 'php'){
          if( strstr($line, "<?php")  || strpos($line, "?>") || (strpos(trim($line), "//") === 0)){
            continue ;
          }
        }

        $separator = (func_num_args() === 0)? $this->separator : $separator;

        $text = explode($separator, $line, 2)?? [];
        $key   = trim($text[0]?? ' ');
        $value = trim($text[1]?? ' ', ', ');
        if($key and array_key_exists(1, $text)){
          $contents[$key] = rtrim($value, $delimiter.' ');
        }

      }
      return $contents;

    }


    /**
     * Writer engine for textWrite and writeLine methods
     *
     * @param string $newText text to be added to file
     * @param array $options postions to add new text [before, after]
     * @return boolean true if any text was added
     */
    private function writerEngine(string $newText = "", array $options = [], $type = '') : bool{
      $fileUrl = $this->path;
      if(!is_file($fileUrl)) return false;    

      if(isset($options['before'])) $before =  $options['before'];
      if(isset($options['after'])) $after =  $options['after'];
      
      $added_before = false;
      $added_after  = false;
      $added_end    = false;

      $reading = fopen($fileUrl, 'r');
      $lines = "";
      $replaced = false;

      while (!feof($reading)) {
        $line = fgets($reading);

        if(isset($before)){
          if (stristr($line, $before)) {
              if($type == 'wLine'){
                $lines .= $newText;
              }else{
                $lines .= rtrim($newText,"\n")."/n";
              }
              $added_before = true;
              $replaced = true;
              unset($before);
          }
        }

        $lines .= $line; 
     
        if(isset($after)){
          if (stristr($line, $after)) {
            if($type == 'wLine'){
              $lines .= $newText;
            }else{
              $lines .= rtrim($newText,"\n")."/n";
            }
            $added_after = $replaced = true;
            unset($after);
          }
        }
      }

      if(!$added_before && !$added_after){
        $lines = $newText;
        $added_end = $replaced = true;
      }

      fclose($reading);
      
      if ($replaced) {
        $writing = fopen($fileUrl.'_.tmp', 'w');
        $lines = "\n ".ltrim(rtrim($lines));
        
        sleep(1);
        fputs($writing, $lines); 
        fclose($writing);
        rename($fileUrl.'_.tmp', $fileUrl);
      }

      return ($added_after || $added_before || $added_end);

    }
    
    /**
     * Replace a line with a new text
     *
     * @param array $data associative array containing old key having new values
     * @param string $separator key-to-value separator
     * @return array array of replacements made
     */
    public function textReplace(array $data, string $separator = ":") : array{
      
      $fileUrl = $this->path;
      if(!is_file($fileUrl)) return [];   

      $reading = fopen($fileUrl, 'r');
      $delimiter = $this->delimiter;
      $lines = "";
      $arrLines = [];

      $separator = (func_num_args() < 2)? $this->separator : $separator;

      if(trim($separator) == '') trigger_error('separator cannot be null', E_USER_ERROR);

      $replaced = false;
      $replacements = [];

      while (!feof($reading)) {
        $line = fgets($reading);
        
        $line = ltrim($line);
        $line = (empty($line))? "\n" : $line;

        foreach($data as $datakey => $dataValue){
          if(is_numeric($datakey)) trigger_error('data keys should not be integers', E_USER_ERROR);
          if(is_array($dataValue)){
            $dataValue = "[".json_encode($dataValue)."]";
          }
          
          if(empty(ltrim($datakey) || empty($line))) continue;
          $datakey = !empty($datakey)? ltrim($datakey) : ' '.$datakey;
          
          $datakey = ltrim($datakey);
          
          if (stristr($line, $datakey.$separator)){
            $replacements[] = $datakey;
            $replaced = true;
            $line = explode(":", $line, 2);
            $line = $line[0].$separator." ".$dataValue.$delimiter."\n";
            unset($data[$datakey]);
            break;
          }
        }
        $arrLines[] = ltrim(rtrim($line));
      }
    
      fclose($reading); 

      if ($replaced) {
          $newLines = '';
          foreach($arrLines as $arrLine){
            $newLines .= empty($arrLine)? "\n" : "\n ".$arrLine; 
          }
          $writing = fopen($fileUrl.'_.tmp', 'w');
          $newLines = "\n ".ltrim($newLines, "\n ");
          sleep(1);
          fputs($writing, $newLines);
          fclose($writing);
          rename($fileUrl.'_.tmp', $fileUrl);
      }

      return $replacements;

    }

    
    /**
     * Reads a file independent of class instance
     * using a defined key and separator. (delimiter as semicolon)
     * 
     * @param string $path file path
     * @param string $separator a unique separator
     * @return array pair of keys and values
     */
    public static function load($path, $separator = ':'){
      $self = new self;

      $self->path = $path;
      $configs = $self->readAll($separator);
      
      return $configs;
    }    

    /**
     * Reads supplied file path and saves into $_ENV
     *  
     * @param string $path file path
     * @param string $key 
     *  - $_ENV will localize data into $key if not empty. This will not be reflected in data returned by this method.
     *  - True will use global config keys from data returned that may overwrite any pre-existing key found in $_ENV.
     *  - False will use global config keys from data returned that will NOT overwrite any pre-existing key found in $_ENV
     * @param string $separator a unique key to value separator.
     * @return array pairs of keys and values
     */
    public static function loadenv($path, bool|string $key = ':ENV', string $separator = '='){

      $configs = self::load($path, $separator);
      
      //load data into the env 
      $DATA = [];

      self::$envKey = $key;

      foreach($configs as $config => $value){
          $DATA[$config] = $value;

          if(is_string($key) && trim($key)){

            $_ENV[$key][$config] = $value;

          }else{

            if(isset($_ENV[$config])){
              if($key === false){ continue; }
            }
            $_ENV[$config] = $value;

          }
          
      }
      self::$envData = $DATA;
      return $DATA;
    }

    /**
     * Returns the last environment key used by the Filemanager::loadenv() method.
     *
     * @return bool|string
     */
    public static function env_key():bool|string{
      return self::$envKey;
    }

    /**
     * Returns the last data obtained by Filemanager::loadenv() method.
     *
     * @return array
     */
    public static function env_data(): array{
      return self::$envData;
    }
  
    /**
     * reformats the structure of a text to be inserted 
     * into a file based on the contents of that file
     *
     * @param string $text
     * @return string
     */
    private function reFormat(string $text){
      $url = $this->path;

      if($text[0] != ' '){
        $text = " ".$text;
      }
      if(trim(file_get_contents($url)) == false){
        $text = "\n ".ltrim($text); //ltrim("\n ",$text);
      }else{
        $text = "\n".$text;
      }
      return $text;
    }

    /**
     * Adds a new directory if it does not exist to the current file directory or full path
     *  - Note : directory supplied is never stored.
     * @param string $path new directory to be created 
     * @return bool true if directory is created or exists else return false
     */
    public function addDir(string $path) : bool {

      if(is_file($path)){
        return $this->response('invalid existing file name supplied!');
      }
      
      if(!is_dir($path)){
       return mkdir($path,0777,true);
      }

      return is_dir($path);

    }


    /**
     * Zip a defined file or directory path.
     *
     * @param string|null $path new name/path of zipped output file.
     * @param array $exclude list of subdirectories or subfiles using relative paths.
     * @param int $enc sets encryption method. Use {@see ZipArchive::EM_TRAD_PKWARE} for wider PHP support during extraction.
     *   ##### Note: $enc can only work when this method is used within the {@see Filemanager::secure()} callback argument.
     *   - No encryption as {@see ZipArchive::EM_NONE}  weakest (avoid)
     *   - ZipCrypto encryption as {@see ZipArchive::EM_TRAD_PKWARE} Weak  
     *   - AES-128 encryption as {@see ZipArchive::EM_AES_128} medium but decent
     *   - AES-192 encryption as {@see ZipArchive::EM_AES_192} strong, rarely used
     *   - AES-256 encryption as {@see ZipArchive::EM_AES_256} strongest
     * @notice method does not support encrypting zip file unless defined within {@see Filemanager::secure()} method.
     * @return Filemanager
     */
    public function compress(?string $path = null, array $exclude = [], $enc = ZipArchive::EM_AES_256) : Filemanager {

      $this->zipped = false;
      $this->zipPath = '';
      $this->zipDir = '';
      if(!$this->path){
        $this->zipError = $this->error = ('invalid zip source path');
        trigger_error($this->zipError);
        return $this;
      }

      //directory or file to be zipped
      $dir = self::normalize_path(realpath($this->path));

      if(!file_exists($dir)) {
        $this->zipError = $this->error = ('invalid zip source path');
        trigger_error($this->zipError);
        return $this;
      }

      //use supplied path or directory path as output path
      $path = ($path)? $path : $dir;

      if(!$path){
        $this->zipError = $this->error = ('invalid zip output destination path defined');
        trigger_error($this->zipError);
        return $this;
      }

      //set the output extension
      if(pathinfo($path, PATHINFO_EXTENSION) != 'zip'){
        $path .= ".zip";
      }

      $zip = new ZipArchive();

      // open() answers TRUE on success or a non-zero error code, so a plain
      // truthy test never catches a failure and leaves an unusable archive.
      $opened = $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

      if($opened !== true){
        $this->zipError = $this->error = ('cannot open zip file for compression ('.$opened.') : '.$path);
        return $this;
      }

      if($this->security){
        if(!$zip->setPassword($this->security)){
          $this->zipError = $this->error = 'cannot set zip password for unsupported or bad ZIP';
          return $this;
        }
      }

      if(is_dir($dir)){
        //recursive directory iterator
        $files = new RecursiveIteratorIterator(
          new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
          RecursiveIteratorIterator::LEAVES_ONLY
          );

        $exclude = array_map(function($path) use($dir) {
          $dir = (is_dir($dir) && is_string($path))? rtrim($dir, '/ ').'/'.ltrim($path, '/ ') : $path;
          return self::normalize_path($dir);
        }, $exclude);
        
        $totalFiles = iterator_count($files);

        $compressed = (object)[
          'index' => 0,
          'count' => $totalFiles,
          'status' => 0,
          'file' => '',
          'zip' => $zip,
        ];

        $proxy = new GhostFunction(['index', 'count','status', 'zip', 'file']);

        $proxy->index(fn() => $compressed->index); 
        $proxy->status(fn() => $compressed->status); 
        $proxy->file(fn() => $compressed->file); 
        $proxy->count(fn() => $compressed->count); 
        $proxy->zip(fn() : ZipArchive => $compressed->zip); 

        /** @var FileCompressor */
        $FileCompressor = GhostProxy::new($proxy, fn(GhostDraft $draft) => new class($draft) extends FileCompressor{});
        
        $i = 0;
        foreach($files as $file){
          $i++;
          $compressed->index = $i;
          $compressed->status = intval(($i / $totalFiles) * 100);
          
          if(!$file->isDir()){

            //* Get real & relative path
            // NOTE: kept out of $path, which holds the output archive path that
            // $this->lastPath / zipName / zipPath are built from further below.
            $filepath = $file->getRealPath(); // filesystem path, passed to ZipArchive as-is
            if($filepath === false) continue; // unreadable / broken link

            // $exclude was normalized above, so the path must be normalized too before
            // it is compared, else separators never line up on Windows (\ vs /).
            $normpath = self::normalize_path($filepath);
            $relpath = substr($filepath, strlen($dir) + 1);

            //add excluded path or directory to array
            $exclusion = array_map(function($val) use($normpath) {
              return self::isSubPath($normpath, $val)? $normpath : '';
            }, $exclude);

            if(!in_array($normpath, $exclusion)){
              //* Add current non-excluded file to archive  
              $newRelPath = self::normalize_path($relpath); // normalized for better archiving
              $zip->addFile($filepath, $newRelPath);
              $compressed->file = $newRelPath;
              $compressed->zip = $zip;

              // set encryption name and method if security is applied
              if($this->security) $zip->setEncryptionName($newRelPath, $enc);

              if($this->zipProgress){
                $progress = $this->zipProgress;
                $FileCompressor->update();
                $progress($FileCompressor);
              }
            }

          }

        }
      }else if(is_file($dir)){
        // $dir as filepath, path in zip archive file
        if($zip->addFile($dir, basename($dir))) {
          
          if($this->security) $zip->setEncryptionName(basename($dir), $enc);

          $compressed = (object)[
            'index' => 1,
            'status' => intval((1 / 1) * 100),
            'file' => $dir,
            'zip' => $zip,
            'count' => 1
          ];
          
          $proxy = new GhostFunction(['index', 'count','status', 'zip', 'file']);

          $proxy->index(fn() => $compressed->index); 
          $proxy->count(fn() => $compressed->count); 
          $proxy->status(fn() => $compressed->status); 
          $proxy->file(fn() => $compressed->file); 
          $proxy->zip(fn() : ZipArchive => $compressed->zip); 

          /** @var FileCompressor */
          $FileCompressor = GhostProxy::new($proxy, fn(GhostDraft $draft) => new class($draft) extends FileCompressor{});
          
          if($this->zipProgress){
            $progress = $this->zipProgress;
            $FileCompressor->update();
            $progress($FileCompressor);
          }

        } else {
          $this->zipError = $this->error = ('cannot add file to zip archive : '.$dir);
          return $this;
        }
      }

      // close() is where the archive is actually written, since addFile() only
      // registers paths — a failure here means nothing usable reached disk.
      if(!$zip->close()){
        $this->zipError = $this->error = ('cannot write zip file : '.$path);
        return $this;
      }

      $this->zipped = true;
      $this->zipError = false;

      $this->lastPath = self::normalize_path(realpath($path));
      $this->zipName = $path;
      $this->zipPath = $this->lastPath;
    
      return $this;
    }

    /**
     * Throws error or triggers supplied callback if ZipArchive class is missing  
     *
     * @param Closure|null $missing callback triggered if ZipArchive is missing 
     * @throws Exception if ZipArchive is missing
     * @return void
     */
    public static function noZip(?Closure $missing = null){
      if(!class_exists('ZipArchive')){
        if(!$missing) throw new Exception('This operation requires ZipArchive extension');
        $missing();
      }
    }
    
    /**
     * Alias for compress (syntatic sugar method)
     *
     * @param string $to relative or absolute file path name for output file
     * @param array $exclude list of subdirectories or subfiles using relative paths.
     * @param int $enc sets encryption method. Use {@see ZipArchive::EM_TRAD_PKWARE} for wider PHP support during extraction.
     *   ##### Note: $enc can only work when this method is used within the {@see Filemanager::secure()} callback argument.
     *   - No encryption as {@see ZipArchive::EM_NONE}  weakest (avoid)
     *   - ZipCrypto encryption as {@see ZipArchive::EM_TRAD_PKWARE} Weak  
     *   - AES-128 encryption as {@see ZipArchive::EM_AES_128} medium but decent
     *   - AES-192 encryption as {@see ZipArchive::EM_AES_192} strong, rarely used
     *   - AES-256 encryption as {@see ZipArchive::EM_AES_256} strongest
     * @notice method does not support encrypting zip file unless defined within {@see Filemanager::secure()} method.
     * @return Filemanager
     */
    public function zip(string $to = '', array $exclude = [], $enc = ZipArchive::EM_AES_256) : Filemanager {
      return $this->compress(...func_get_args());
    }

    /**
     * Alias for compress 
     *
     * @param string $to path name for output zipped file
     * @param array $exclude list of subdirectories or subfiles using relative paths
     * @param int $enc sets encryption method. Use {@see ZipArchive::EM_TRAD_PKWARE} for wider PHP support during extraction.
     *   ##### Note: $enc can only work when this method is used within the {@see Filemanager::secure()} callback argument.
     *   - No encryption as {@see ZipArchive::EM_NONE}  weakest (avoid)
     *   - ZipCrypto encryption as {@see ZipArchive::EM_TRAD_PKWARE} Weak  
     *   - AES-128 encryption as {@see ZipArchive::EM_AES_128} medium but decent
     *   - AES-192 encryption as {@see ZipArchive::EM_AES_192} strong, rarely used
     *   - AES-256 encryption as {@see ZipArchive::EM_AES_256} strongest
     * @notice method does not support encrypting zip file unless defined within {@see Filemanager::secure()} method.
     * @return Filemanager
     */
    public function zipUrl(string $to = '', array $exclude = [], $enc = ZipArchive::EM_AES_256) : Filemanager {
      return $this->compress(...func_get_args());
    }

    /**
     * Sets extra configuration options for decompression
     * @param array $options options with keys and values.
     *  - allowed-directories : a boolean value of TRUE disables the extraction into existing directories. 
     * @return void
     */
    public function unzipper(array $options){
      $configs = ['allow-directories'];
      foreach($options as $key => $option){
        if(in_array($key, $configs)){
          $this->options['unzipper-'.$key] = $option;
        }
      }
    }

    /**
     * This method decompresses a zipped file defined through the source() or setUrl() methods.
     *  - When no directory is supplied, files are extracted into a folder named after the
     *    zip file, created beside it.
     *  - Previous error constraint prevents method execution under pre-existing errors
     *  - Override error constraint with {@see Filemanager::execute()} method.
     * @param string $path path of directory where decrypted files are extracted to
     *  - The directory is created when it does not already exist.
     * @param boolean $flush true deletes zip file path after decompressing it.
     * @param boolean $dirs enables decompression into a directory that already exists.
     *  - Note that setting this as TRUE will overwrite existing files.
     * @return Filemanager
     */
    public function decompress(?string $path = null, bool $flush = false, bool $dirs = false) : Filemanager {
      $this->unzipped = false;
      $this->unzipDir = '';

      if($this->hasError()) return $this;

      $curpath = self::normalize_path(realpath($this->lastPath));

      if(!is_file($curpath)){
        $this->zipError = $this->error = ('invalid file to decompress');
        return $this;
      }
      $foldername = pathinfo($curpath, PATHINFO_DIRNAME). '/' .
                    pathinfo($curpath, PATHINFO_FILENAME);

      if($path !== null){
        // tested before addDir() runs, else a destination created by this very
        // call reads back as pre-existing and is rejected by the check below.
        $folderExists = is_dir($path);
        if(!$this->addDir($path)){
          $this->zipError = $this->error = ('invalid decompression path ('.$path.') supplied');
          return $this;
        }
        $foldername = $path;
      }else{
        $folderExists = is_dir($foldername);
      }

      if(!$folderExists || $this->options['unzipper-allow-directories'] || $dirs){

        if($this->addDir($foldername)) {

          // decompress zip file
          $zip = new ZipArchive;

          if($zip->open($curpath) === TRUE){

              if($this->security){
                $zip->setPassword($this->security);
              }

              /* ........................ */
              $entries  = $zip->numFiles;
              $unzipped = ($entries === 0); // an empty archive has nothing left to fail on

              $compressed = (object)[
                'index' => 0,
                'count' => $entries,
                'status' => 0,
                'file' => '',
                'zip' => $zip,
              ];

              $proxy = new GhostFunction(['index', 'count','status', 'zip', 'file']);
              $proxy->index(fn() => $compressed->index);
              $proxy->count(fn() => $compressed->count);
              $proxy->status(fn() => $compressed->status);
              $proxy->file(fn() => $compressed->file);
              $proxy->zip(fn() : ZipArchive => $compressed->zip);

              /** @var FileCompressor */
              $FileCompressor = GhostProxy::new($proxy, fn(GhostDraft $draft) => new class($draft) extends FileCompressor{});

              for ($i = 0; $i < $entries; $i++) {

                  $filename = $zip->getNameIndex($i);
                  $filePath = $foldername .'/'. $filename;

                  // Make sure subdirectories exist
                  if (!is_dir(dirname($filePath))) {
                      mkdir(dirname($filePath), 0777, true);
                  }

                  // Extract this single file
                  $unzipped = $zip->extractTo($foldername, $filename);

                  $compressed->index = $i + 1;
                  $compressed->status = intval((($i + 1) / $entries) * 100);
                  $compressed->file = $filename;

                  if($this->zipProgress){
                    $progress = $this->zipProgress;
                    $FileCompressor->update();
                    $progress($FileCompressor);
                  }
                  if(!$unzipped) break;

              }
              /* ........................ */

              $this->unzipped = $unzipped;
              // $this->unzipped = $zip->extractTo($foldername);
              if($this->unzipped()) {
                $this->zipError = false;
                $this->unzipDir = $foldername;
              }
              $zip->close();
              if(!$this->unzipped && !$this->zipError) {
                if($this->security){
                  $this->zipError = $this->error = 'file access or password error.';
                }else{
                  $this->zipError = $this->error = 'file access restricted or corrupt.';
                }
              }
              if($flush && $this->unzipped) unlink($curpath); // delete zip file if successfully extracted
              return $this;
          } else {
            $this->zipError = $this->error = ('cannot open zip file for decompression : '.$zip->getStatusString());
            return $this;
          }

        } else {
            $this->zipError = $this->error = ('cannot decompress to missing directory: "'.$foldername.'"');
            return $this;
        }

      } else {
            $this->zipError = $this->error = ('cannot decompress to an existing folder');
            return $this;
      }

    }

    /**
     * Alternative method for decompressing zip file
     *  - Source file is declared through the source() or setUrl() method.
     * @param bool $flush TRUE deletes zip file path after decompressing it.     
     * @param string $to directory path for decrypted files.
     *  - Uses same path if destination path if not defined.
     * @param boolean $dirs enables decompression to existing directories. 
     *  - Note that setting this as TRUE will overwrite existing files.
     * @return Filemanager
     */
    public function unzip(bool $flush = false, ?string $to = null,  bool $dirs = false) : Filemanager {
      return $this->decompress(...[$to, $flush, $dirs]); //change definition order
    }

    /**
     * Wrapper method for compressing or decompressing a zip file with password
     *
     * @param \Closure $callback defines a closure where zip compression or decompression methods are applied
     * @param string $key defines a password key for compressing or decompressing a zip file
     * @return mixed 
     *  - Returns FALSE if $key is empty.
     */
    public function secure(\Closure $callback, string $key){

      if(!$key){
        trigger_error('no security key defined!');
        return false;
      }
      
      $this->security = $key;
      $exec = $callback($this);
      $this->security = false;
      return $exec;

    }
    
    /**
     * Define a callback handler to be triggered during zipping activity
     *
     * @param Closure|null $callback receives arguments : (FileCompressor $info)
     *  - $info->count : total number of files to be zipped
     *  - $info->index : current file index being zipped
     *  - $info->status : progress status in percentage (integer)
     *  - $info->file : current file name being zipped
     *  - $info->ZipArchive : ZipArchive instance
     * @return void
     */
    public function zipProgress(?Closure $callback = null){
      $this->zipProgress = $callback;
    }

    /**
     * Returns true if the file or directory supplied was successfully zipped
     *
     * @return bool
     */
    public function zipped() : bool {
      return $this->zipped && is_file($this->lastDir());
    }

    /**
     * Returns true if the file or directory supplied was successfully unzipped
     *
     * @return bool
     */
    public function unzipped() : bool {
      return $this->unzipped;
    }

    /**
     * Returns the last tracked path of a zipped or unzipped file
     *
     * @return string
     */
    public function zipPath() : string {
      return $this->zipPath;
    }

    /**
     * Returns the directory of a zipped or unzipped file
     *
     * @param string $type optional [zipped|unzipped]
     * @return string
     */
    public function zipDir(string $type) : string {
      if(!in_array($type, ['zipped','unzipped'])) return '';
      return ($type === 'zipped')? $this->zipDir : $this->unzipDir;
    }

    /**
     * Returns an error message if zip activity fails
     *
     * @return string|false returns error string if error is found or FALSE if no error is found.
     */
    public function zipError() : string|false {
      return $this->zipError;
    }

    /**
     * Returns the last tracked directory or file path 
     * 
     * @return string
     */
    public function lastDir(){
      return $this->lastPath;
    }

    /**
     * Alias for {@see Filemanager::lastDir()}
     *  - Returns the last tracked directory or file path 
     * @return string
     */
    public function lastPath(){
      return $this->lastPath;
    }

    /**
     * Moves a file from a directory to a new location function
     *  - Warning : this will overwrite an existing file in the destination path supplied
     *  - Source path is parent directory or source file path obtained from {@see Filemanager::source()} if defined.
     *  - Previous error constraint prevents method execution under pre-existing errors 
     *  - Override error constraint with {@see Filemanager::execute()} method. 
     * 
     * @param string $param1 acts as relative parent path or full destination path
     *  - Directory: acts as destination directory for source file path when $param2 is not defined
     *  - Full Path: acts a full destination path if $param2 is not defined where .
     *  - Relative Path: file path relative to {@see Filemanager::source()} parent directory when $param2 is defined
     * @param string $param2 second (optional) location as destination
     *  - If defined, acts as destination directory path for source file
     * @return boolean true if file is moved successfully.
     */
    public function copy(string $param1 = '', string $param2 = '') : bool{

      if($this->hasError()) return false;  

      $selection = rtrim($this->path,"/"); // parent path selected

      if(!file_exists($selection)){ return false; }

      if(func_num_args() === 1){

        // move a file to another path
        if(!is_dir($param1)){ 
          $this->error = ('invalid destination path "'.$selection.'" supplied as argument(#1) on Filemanager::copy() ');
          return false; 
        }

        $copied = copy($selection, $param1."/".basename($selection));
        
        if(!$copied){
          if(!is_dir($param1)){ 
            $this->error = ('invalid destination path "'.$selection.'" supplied as argument(#1) on Filemanager::copy() ');
            return false; 
          }
        }
       
        return $copied;

      }

      if(func_num_args() === 2){

        //move $param1 in selection to $param2
        if(!file_exists($param2)){ 
          $this->error = ('invalid destination path "'.$param2.'" supplied as argument(#2) on Filemanager::copy() ');
          return false; 
        }

        if(file_exists($selection.'/'.$param1)){  
          // copy a file in a source directory to another directory
          copy($selection.'/'.$param1, $param2.'/'.$param1);
          return file_exists($param2.'/'.$param1);
        }

        return false;
      }

      return false;
    }

    /**
     * Copy last declared file to another existing location
     *  - This updates the last directory path if successful.
     *  - Previous error constraint prevents method execution under pre-existing errors 
     *  - Override error constraint with {@see Filemanager::execute()} method. 
     * 
     * @param string $newdir new directory
     * @param string|null $newname new file name 
     *  - If empty string or null, uses the base name of source path defined
     *  - Should be a valid file name
     * @param bool $overwrite TRUE overwrites existing file.
     * @return bool TRUE only if file is copied successfully
     */
    public function copyTo(string $newdir, ?string $newname = null, bool $overwrite = false) : bool {

      if($this->hasError()) return false;   

      if(!file_exists($this->lastPath)) {
        $this->error = 'invalid source path "'.$this->lastPath.'"';
        return false;
      }

      if(!is_dir($newdir)) {
        $this->error = 'invalid file destination path';
        return false;
      }

      $newDir = realpath($newdir)."/";
      $newDir .= ($newname == '')? basename($this->lastPath) : $newname;

      if(!is_writable(realpath($newdir)."/")){
        $this->error = 'copy destination path is not writeable';
        return false;
      }

      if(is_file($newDir)){
          if(!$overwrite) {
            $this->error = ('existing destination path "'.$newDir.'" cannot be overwritten from Filemanager::copy() ');
            return false;
          }
      }
      $copied = copy($this->lastPath, $newDir);

      if($copied) {
        $this->lastPath = $newDir;
        return true;
      }
      
      $this->error('failed copying to destination path "'.$newDir.'"');
      return false;
    }

    /**
     * Stand alone method to copy files from one directory to another directory
     *  - Note that this copies files only and not folders (i.e directories).
     * @param string $fromDir source directory of files
     * @param string $toDir final directory of files
     * @param string[]|null $exts filter patterns for selecting files to be copied
     *   - If NULL, assumes the default extensions format supplied from the {@see Filemanager::source()} or all files within the specified directory
     * @param Closure $callback A callback to monitor progress.
     * @return void
     * @uses \copy()
     * @uses Filemanager::source()
     * @uses Filemanager::getFiles()
     */
    public function copyDirectFiles(string $fromDir, string $toDir, array|string|null $exts = null, ?Closure $callback = null){

        if(!is_dir($fromDir)) {
          $this->error = 'copyFiles: invalid source directory defined';
          return;
        }

        if($this->addDir($toDir)){
          
          $Filemanager = new Filemanager;

          // obtain files from the source directory
          $exts? $Filemanager->source($fromDir, $exts) : $Filemanager->source($fromDir);
          $files = $Filemanager->getFiles(true);

          $totalFiles = count($files);

          $info = (object) [
              'file' => '',
              'success' => false,
              'status' => '',
              'processed' => [],
              'total' => $totalFiles,
              'resolved' => [],
              'unresolved' => [],
              'overwrite' => true,
              'errors' => []
          ];
          
          $resolved = [];
          $unresolved = [];

          $Ghost = new GhostFunction(['::file','success','processed','total','resolved','unresolved']);

          $Ghost->file(fn() => $info->file); // old or new file path
          $Ghost->success(fn() => $info->success);
          $Ghost->processed(fn() => $info->processed);
          $Ghost->total(fn() => $info->total);
          $Ghost->resolved(fn($type) =>  $type === 'all'? $info->resolved : count($info->resolved));
          $Ghost->unresolved(fn($type) =>  $type === 'all'? $info->unresolved : count($info->unresolved));
          $Ghost->overwrite(fn($bool) => $info->overwrite = $bool);
          $Ghost->errors(fn() => $info->errors); // all errors compiled so far
          $Ghost->error(fn() => $info->error); // single error for currently iteratedd file
          
          $GhostProxy = GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends FileTransfer{});

          foreach($files as $count => $file){
            $error = null;
            $fileName = basename($file);
            $finalPath = $toDir.'/'.$fileName;
            if(is_file($finalPath)){
              if(!$info->overwrite) {
                $success = false;
                $unresolved[] = $file;
                $error = 'cannot overwrite: '.$file;
              }
            }
            
            if(!$error) {
              ($success = copy($file, $finalPath))? $resolved[] = $file : $unresolved[] = $file;
              if(!$success) $error = 'copy failed for: '.$file;
            }
            
            if($error) $info->errors[$file] = $error;

            $info->error = $error;
            $info->file = $success? $finalPath : $file;
            $info->success = $success;
            $info->processed = $count + 1;
            $info->resolved = $resolved;
            $info->unresolved = $unresolved;
            if($callback) $callback($GhostProxy);
          }

        }

        if($this->flushIgnoredPaths) $this->ignoredPaths([], false);
    }

    /**
     * Copy only matching files from a directory and its matching subdirectories to a destination directory
     *
     * @param string $dest
     * @param Closure|null $callback
     * @param boolean $overwrite
     * @return Filemanager
     * @uses Filemanager::copyContentsTo()
     */
    public function copyFilesTo(string|null $dest = '', ?Closure $callback = null, bool $overwrite = true) : Filemanager {
      $this->copyContentsTo($dest, $callback, ['overwrite'=>$overwrite, 'filesOnly' => true]);
      if($this->flushIgnoredPaths) $this->ignoredPaths([], false);
      return $this;
    }

    /**
     * Copies matching contents of a directory (i.e both files and subdirectories) to another directory 
     *  - Note that symlinks are skipped.
     *  - Pre-existing files in destination path are automatically overidden unless disabled through $option argument.
     *  - Previous error constraint prevents method execution under pre-existing errors 
     *  - Override error constraint with {@see Filemanager::execute()} method. 
     *  
     * @param string $dest destination directory path
     * @param array $options array list of options 
     *  - overwrite: boolean value FALSE disables default overwriting of files
     *  - filesOnly: copies only matching files and not directories.
     * @param Closure|null $callback an optional callback
     *  - Callback format: $callback(FileTransfer $file)
     * @return Filemanager
     */
    public function copyContentsTo(string|null $dest = '', ?Closure $callback = null, array $options = []) : Filemanager {

      $isRoot = !isset($this->fileTransfer);

      if($isRoot){
              
          if($this->hasError()) return $this;   

          $data = (object)[
              'resolved' => [], 'unresolved' => [], 'all' => null, // null = not yet counted
              'success' => 0, 'processed' => 0, 'file' => '', 'ok' => false,
          ];

          $Ghost = new GhostFunction(['::file','success','processed','total','resolved','unresolved']);

          $Ghost->file(fn() => $data->file); // current file
          $Ghost->success(fn() => $data->ok); // determines when copied file is successful
          $Ghost->processed(fn() => $data->processed); //

          // total number of files
          $Ghost->total(function() use ($data, $options) {
              return $data->all ??= $this->countContents($options);
          });
          $Ghost->resolved(fn($type = null) => $type === 'count' ? $data->success : $data->resolved);
          $Ghost->unresolved(fn($type = null) => $type === 'count' ? count($data->unresolved) : $data->unresolved);

          GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends FileTransfer{});

          $this->fileTransfer = ['data' => $data, 'proxy' => GhostProxy::object()];
      }

      ['data' => $data, 'proxy' => $file] = $this->fileTransfer;

      if($this->error){
          if($isRoot) unset($this->fileTransfer);
          return $this;
      }
      if(is_file($dest)){
          $this->error = "CopyContentsTo: destination path must be a directory and not a file path.";
          if($isRoot) unset($this->fileTransfer);
          return $this;
      }
      $destPath = realpath($dest);
      if($destPath === false) $this->addDir($dest);
      $destPath = realpath($dest);
      if(!is_dir($destPath) || !is_writable($destPath)){
          $this->error = 'CopyContentsTo: copy destination path "'.$dest.'" is not writeable';
          if($isRoot) unset($this->fileTransfer);
          return $this;
      }
      $destPath .= DIRECTORY_SEPARATOR;

      $overwrite = $options['overwrite'] ?? true;
      $filesOnly = $options['filesOnly'] ?? false;

      $contents = $this->getContents(true);

      if($contents && $callback) $callback($file);

      foreach($contents as $item){
          if(is_link($item)) continue;
          $target = $destPath.basename($item);

          if(is_dir($item)){
              if($filesOnly){
                  $created = $this->addDir($target);

                  if($created){
                      $sub = clone $this; // $this->fileTransfer already set — sub is never root
                      $sub->source($item, $this->filters());
                      $sub->copyContentsTo($target, $callback, $options);

                      // clean up: if nothing ended up inside, remove the now-useless empty folder
                      $entries = @scandir($target);
                      if($entries !== false && count($entries) <= 2) @rmdir($target);
                  } else {
                      $data->processed++;
                      $data->file = $item;
                      $data->ok = false;
                      $data->unresolved[] = $item;
                      if($callback) $callback($file);
                  }
              } else {
                  $success = $this->addDir($target);
                  $data->processed++;
                  $data->file = $item;
                  $data->ok = $success;
                  $success ? $data->resolved[] = $item : $data->unresolved[] = $item;
                  if($success) $data->success++;
                  if($callback) $callback($file);

                  if($success){
                      $sub = clone $this;
                      $sub->source($item, $this->filters());
                      $sub->copyContentsTo($target, $callback, $options);
                  }
              }
          } else {
              if(realpath($item) === realpath($target)){
                  $success = false;
              } elseif(!$overwrite && file_exists($target)){
                  $success = false;
              } else {
                  $success = copy($item, $target);
              }

              $data->processed++;
              $data->file = $item;
              $data->ok = $success;
              $success ? $data->resolved[] = $item : $data->unresolved[] = $item;
              if($success) $data->success++;
              if($callback) $callback($file);
          }
      }

      if($isRoot) unset($this->fileTransfer);
      if($this->flushIgnoredPaths) $this->ignoredPaths([], false);

      return $this;
    }

    /**
     * A method designed to overide error constraint by wrapping operations 
     * within the closure method.
     *  - Note: applying this method makes it harder to detect errors early.
     * @return void
     */
    public function execute(Closure $callback){
      $this->execute = true;

      $callback($this);

      $this->execute = false;
    }

    /**
     * Moves a file from a directory to a new location function
     *  - Warning : this will overwrite an existing file in the destination path supplied
     *  - Source path is parent directory or source file path obtained from {@see Filemanager::source()} if defined.
     *  - Existing errors prevents operation.
     * 
     * @param string $param1 acts as relative parent path or full destination path
     *  - Directory: acts as destination directory for source file path when $param2 is not defined
     *  - Full Path: acts a full destination path if $param2 is not defined.
     *  - Relative Path: file path relative to {@see Filemanager::source()} parent directory when $param2 is defined.
     * @param string $param2 second (optional) location as destination
     *  - If defined, acts as destination directory path for source file.
     * @return boolean true if file is moved successfully.
     * 
     */
    public function move(string $param1 = '', string $param2 = '') : bool{
        
      if($this->hasError()) return false;   

      $selection = rtrim($this->path,"/"); // parent path selected

      if(!file_exists($selection)){ return false; }

      if(func_num_args() === 1){

        // move a file to another path
        if(!is_dir($param1)){ 
          $this->error = ('invalid destination path "'.$selection.'" supplied as argument(#1) on Filemanager::move() ');
          return false; 
        }

        // rename a file path to another existing directory
        $renamed = rename($selection, $param1."/".basename($selection));
        
        if(!$renamed){
          if(!is_dir($param1)){ 
            $this->error = ('invalid destination path "'.$selection.'" supplied as argument(#1) on Filemanager::move() ');
            return false; 
          }
        }
       
        return $renamed;

      }

      if(func_num_args() === 2){

        //move $param1 in selection to $param2
        if(!file_exists($param2)){ 
          $this->error = ('invalid destination path "'.$param2.'" supplied as argument(#2) on Filemanager::move() ');
          return false; 
        }

        if(file_exists($selection.'/'.$param1)){  
          // rename a file in a source directory to another directory
          rename($selection.'/'.$param1, $param2.'/'.$param1);
          return file_exists($param2.'/'.$param1);
        }

        return false;
      }

      return false;
    }

    /**
     * Move last declared file to another location
     *  - Updates the last path if successful.
     *  - Previous error constraint prevents method execution under pre-existing errors 
     *  - Override error constraint with {@see Filemanager::execute()} method. 
     * @param string $newdir new directory
     * @param string $newname new file name 
     * @param boolean $overwrite TRUE overwrites existing file.
     * @return bool
     */
    public function moveTo(string $newdir, string $newname = '', bool $overwrite = TRUE) : bool {
      
      if($this->hasError()) return false;     

      if(!file_exists($this->lastPath)) {
        $this->error = ('invalid source path "'.$this->lastPath.'" ');
        return false;
      }

      if(!is_dir($newdir)) {
        $this->error = ('invalid file destination path: "'.$newdir.'"');
        return false;
      }

      // set new path or directory
      $newDir = $baseDir = self::normalize_path(realpath($newdir).self::DS);
      $newDir .= ($newname == '')? basename($this->lastPath) : $newname;
  
      if(!is_writable($baseDir)){
        $this->error = ('destination path "'.$newDir.'" is not writeable');
        return false;
      }

      if(is_file($newDir)){
        if(!$overwrite) {
          $this->error = ('existing destination path "'.$newDir.'" cannot be overwritten from Filemanager::move() ');
          return false;
        }
      }

      if(!is_file($newDir) && (strtolower($this->lastPath) !== strtolower($newDir))){
        $renamed = rename($this->lastPath, $newDir);
        if($renamed){
          $this->lastPath = $newDir;
          return true;
        }
      }else{
        $this->error = ('destination path "'.$newDir.'" already exists');
        return false;
      }
      return false;
    }

    
    /**
     * Stand alone method to copy files from one directory to another directory
     *  - Note that this copies files only and not folders (i.e directories).
     * @param string $fromDir source directory of files
     * @param string $toDir final directory of files
     * @param string[]|null $exts filter patterns for selecting files to be copied
     *   - If NULL, assumes the default extensions format supplied from the {@see Filemanager::source()} or all files within the specified directory
     * @param Closure $callback A callback to monitor progress.
     * @return void
     * @uses \copy()
     * @uses Filemanager::source()
     * @uses Filemanager::getFiles()
     */
    public function moveDirectFiles(string $fromDir, string $toDir, array|string|null $exts = null, ?Closure $callback = null){

        if(!is_dir($fromDir)) {
          $this->error = 'copyFiles: invalid source directory defined';
          return;
        }

        if($this->addDir($toDir)){
          
          $Filemanager = new Filemanager;

          // obtain files from the source directory
          $exts? $Filemanager->source($fromDir, $exts) : $Filemanager->source($fromDir);
          $files = $Filemanager->getFiles(true);

          $totalFiles = count($files);

          $info = (object) [
              'file' => '',
              'success' => false,
              'status' => '',
              'processed' => [],
              'total' => $totalFiles,
              'resolved' => [],
              'unresolved' => []
          ];
          
          $resolved = [];
          $unresolved = [];

          $Ghost = new GhostFunction(['::file','success','processed','total','resolved','unresolved']);

          $Ghost->file(fn() => $info->file); // old or new file path
          $Ghost->success(fn() => $info->success);
          $Ghost->processed(fn() => $info->processed);
          $Ghost->total(fn() => $info->total);
          $Ghost->resolved(fn($type) =>  $type === 'all'? $info->resolved : count($info->resolved));
          $Ghost->unresolved(fn($type) =>  $type === 'all'? $info->unresolved : count($info->unresolved));

          $GhostProxy = GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends FileTransfer{});

          foreach($files as $count => $file){
            $fileName = basename($file);
            $finalPath = $toDir.'/'.$fileName;
            ($success = rename($file, $finalPath))? $resolved[] = $file : $unresolved[] = $file;
            $info->file = $success? $finalPath : $file;
            $info->success = $success;
            $info->processed = $count + 1;
            $info->resolved = $resolved;
            $info->unresolved = $unresolved;
            if($callback) $callback($GhostProxy);
          }

        }

        if($this->flushIgnoredPaths) $this->ignoredPaths([], false);
    }

    /**
     * Move only matching files to a new directory
     *  - Depends on the source path defined with the {@see Filemanager::source()} method
     * @param string $dest destination directory path
     * @param ?Closure $callback Callback that takes {@see FileTransfer} object useful for monitoring transfer progress on CLI environments. 
     * @return Filemanager
     */
    public function moveFilesTo(string|null $dest = '', ?Closure $callback = null, bool $overwrite = true) : Filemanager {
      $this->moveContentsTo($dest, $callback, ['overwrite'=>$overwrite, 'filesOnly' => true]);
      if($this->flushIgnoredPaths) $this->ignoredPaths([], false);
      return $this;
    }

    /**
     * Move the contents (i.e files, subdirectories or both) from a directory to another directory
     *
     * @param string $dest
     * @param Closure|null $callback A callback that takes FileTransfer object
     * @param array $options determines the behaviour of contents moved 
     *  - overwrite : FALSE disables the defualt overwriting of files
     *  - filesOnly : TRUE move only relative files keeping path structure without affecting directories.
     * @return Filemanager
     */
    public function moveContentsTo(string|null $dest = '', ?Closure $callback = null, array $options = []) : Filemanager {

      $isRoot = !isset($this->fileTransfer);

      if($isRoot){
      
          if($this->hasError()) return $this; 

          $data = (object)[
              'resolved' => [], 'unresolved' => [], 'all' => null, // null = not yet counted
              'success' => 0, 'processed' => 0, 'file' => '', 'ok' => false,
          ];

          $Ghost = new GhostFunction(['::file','success','processed','total','resolved','unresolved']);
          
          $Ghost->file(fn() => $data->file); // current file
          $Ghost->success(fn() => $data->ok); // determines when moved file is successful
          $Ghost->processed(fn() => $data->processed); //
          
          // total number of files
          $Ghost->total(function() use ($data, $options) {
              return $data->all ??= $this->countContents($options);
          });
          $Ghost->resolved(fn($type) => $type === 'count'?  $data->success : $data->resolved);
          $Ghost->unresolved(fn($type) =>  $type === 'count'? count($data->unresolved) : $data->unresolved);

          GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends FileTransfer{});

          $this->fileTransfer = ['data' => $data, 'proxy' => GhostProxy::object()];
      }

      ['data' => $data, 'proxy' => $file] = $this->fileTransfer;

      if($this->execute) $this->error = false;
      if($this->error){
          if($isRoot) unset($this->fileTransfer);
          return $this;
      }
      if(is_file($dest)){
          $this->error = "MoveContentsTo: destination path must be a directory and not a file path.";
          if($isRoot) unset($this->fileTransfer);
          return $this;
      }
      $destPath = realpath($dest);
      if($destPath === false) $this->addDir($dest);
      $destPath = realpath($dest);
      if(!is_dir($destPath) || !is_writable($destPath)){
          $this->error = 'MoveContentsTo: move destination path "'.$dest.'" is not writeable';
          if($isRoot) unset($this->fileTransfer);
          return $this;
      }
      $destPath .= DIRECTORY_SEPARATOR;

      $overwrite = $options['overwrite'] ?? true;
      $filesOnly = $options['filesOnly'] ?? false;

      $contents = $this->getContents(true);

      if($contents && $callback) $callback($file);

      foreach($contents as $item){
          if(is_link($item)) continue;
          $target = $destPath.basename($item);

          if(is_dir($item)){
              if($filesOnly){
                  $created = $this->addDir($target);

                  if($created){
                      $sub = clone $this; // $this->fileTransfer already set — sub is never root
                      $sub->source($item, $this->filters());
                      $sub->moveContentsTo($target, $callback, $options);

                      $entries = @scandir($target);
                      if($entries !== false && count($entries) <= 2) @rmdir($target);

                      $stillFilled = @scandir($item);
                      if($stillFilled !== false && count($stillFilled) <= 2) @rmdir($item);
                  } else {
                      $data->processed++;
                      $data->file = $item;
                      $data->ok = false;
                      $data->unresolved[] = $item;
                      if($callback) $callback($file);
                  }
              } else {
                  $success = $this->addDir($target);

                  if($success){
                      $sub = clone $this;
                      $sub->source($item, $this->filters());
                      $sub->moveContentsTo($target, $callback, $options);

                      $stillFilled = @scandir($item);
                      $success = ($stillFilled !== false && count($stillFilled) <= 2) ? rmdir($item) : false;
                  }

                  $data->processed++;
                  $data->file = $item;
                  $data->ok = $success;
                  $success ? $data->resolved[] = $item : $data->unresolved[] = $item;
                  if($success) $data->success++;
                  if($callback) $callback($file);
              }
          } else {
              if(realpath($item) === realpath($target)){
                  $success = false;
              } elseif(!$overwrite && file_exists($target)){
                  $success = false;
              } else {
                  $success = copy($item, $target);
                  if($success && is_writable($item)){
                      $success = unlink($item);
                  } elseif($success){
                      $success = false;
                  }
              }

              $data->processed++;
              $data->file = $item;
              $data->ok = $success;
              $success ? $data->resolved[] = $item : $data->unresolved[] = $item;
              if($success) $data->success++;
              if($callback) $callback($file);
          }
      }

      if($isRoot) unset($this->fileTransfer);
      if($this->flushIgnoredPaths) $this->ignoredPaths([], false);

      return $this;
    }

    /**
     * Returns the total number of contents matched.
     *
     * @param array $options
     * @return integer
     */
    public function countContents(array $options = []) : int {
      $filesOnly = $options['filesOnly'] ?? false;
      $contents  = $this->getContents(true);
      $itemsHere = $filesOnly ? array_filter($contents, fn($i) => !is_dir($i)) : $contents;

      $count = count($itemsHere);

      foreach($contents as $item){
          if(is_link($item)) continue;
          if(is_dir($item)){
              $sub = clone $this;
              $sub->source($item, $this->filters());
              $count += $sub->countContents($options);
          }
      }

      return $count;
    }

    /**
     * Deletes a specified directory or file.
     *
     * @param string $dir source directory or file path
     *  - When not defined, deletes the last defined url.
     *  - This does not update the last url
     * @param array $selection defines an array list that can either be used to select a list of items to be removed or excluded 
     *  - array list should contain an "include" or "exclude" key but not both.
     *  - When using $selection, be conscious of case-sensitivity of file names and paths.
     * @param array $removals defines the list of removed items
     * @return boolean TRUE if at least one item was removed.
     */
    public function deleteFile(?string $dir = null, array $selection = [], &$removals = []) : bool {
      
      $this->deleteState = false;
      $dir = ($dir === null ? $this->path : $dir);

      if(!$dir){
        trigger_error('invalid path supplied for deleting');
        return false;
      }

      $path = realpath((func_num_args() > 0)? $dir : $this->path);

      if($path === false){
        $this->error = ('cannot delete from an invalid file or folder path "'.$dir.'"');

        return false;
      }

      $path = rtrim(self::normalize_path($path), '/');
      $expected = $this->countExpectedDeletions($path);
      $this->deleteState = false;

      // default variables 
      $includes = []; $excludes = [];

      if(file_exists($path)){

        // resolve files 
        if(is_file($path)) {
           if(unlink($path)){
            $removals[] = $path;
            $this->setDeleteState($removals, $expected);
            return true;
           }
           $this->setDeleteState($removals, $expected);
           return false;
        }

        // resolve directories
        if($selection){

          $excludes = (array) ($selection['exclude'] ?? []);
          $includes = (array) ($selection['include'] ?? []);

          if(is_dir($path)){
            $excludes = array_map(fn($value) => $path.'/'.ltrim(rtrim(self::normalize_path($value), '/'), '/'), $excludes);
            $includes = array_map(fn($value) => $path.'/'.ltrim(rtrim(self::normalize_path($value), '/'), '/'), $includes);
          }

          if($excludes && $includes){
            $this->error = ('Filemanager::deleteFile(#2) option can either be exlusive or inclusive but not both"');
            $this->setDeleteState($removals, $expected);
            return false;
          }

          // get path items and set default response
          $files = array_diff(scandir($path), ['.','..']);
          $response = false;

          if($excludes){

              foreach($files as $file){
                  $response = false;
                  $filePath = $path."/".$file;
                  if(is_file($filePath)){
                    if(!in_array($filePath, $excludes)) {
                      $response = unlink($filePath);
                      if($response) $removals[] = $filePath;
                    }
                  }elseif(is_dir($filePath)){
                    if(!in_array($filePath, $excludes)) {
                      $response = $this->deleteFile($filePath, $selection, $removals);
                      //check directory ... 
                      $fileItems = array_diff(scandir($filePath), ['.','..']);
                      if(count($fileItems) === 0){
                        $response = rmdir($filePath);
                        if($response) $removals[] = $filePath;
                      }
                    }
                  }
              }
              $this->setDeleteState($removals, $this->countExpectedDeletions($path, $excludes, $includes));
              return $removals ? true : false;
          }elseif($includes){

              foreach($files as $file){
                  $response = false;
                  $filePath = $path."/".$file;
                  if(is_file($filePath) && in_array($filePath, $includes)){
                    $response = unlink($filePath);
                    if($response) $removals[] = $filePath;
                  }elseif(is_dir($filePath) && in_array($filePath, $includes)){
                    $response = $this->deleteFile($filePath, $selection, $removals);
                    if($response) $removals[] = $filePath;
                    //check directory ... 
                    $fileItems = array_diff(scandir($filePath), ['.','..']);
                    if(count($fileItems) === 0){
                      $response = rmdir($filePath);
                      if($response) $removals[] = $filePath;
                    }
                  }
              }
              $this->setDeleteState($removals, $this->countExpectedDeletions($path, $excludes, $includes));
              return $removals ? true : false;
          }
          $this->setDeleteState($removals, $expected);
          return $response;
        }else{

            // remove all items in folder first
            $files = array_diff(scandir($path), ['.','..']);

            foreach($files as $file){
              $filePath = $path."/".$file;
                if(is_file($filePath)){
                    $deleted = unlink($filePath);
                    if($deleted) $removals[] = $filePath;
                }elseif(is_dir($filePath)){
                    $this->deleteFile($filePath, [], $removals);
                }
            }

            // delete folder
            if(is_dir($path)){
              $removed = rmdir($path);
              if($removed) $removals[] = $path;
              $this->setDeleteState($removals, $expected);
              return $removed;
            }
            $this->setDeleteState($removals, $expected);
            return true;
        }

      } else {
        $this->error = ('cannot delete from an invalid file or folder path "'.$dir.'"');
        $this->setDeleteState($removals, $expected);
        return false;
      }

    }

    /**
     * Defines the delete state when {@see Filemanager::delete()} is applied.
     *
     * @var boolean|integer
     *  - False: not deleted 
     *  - 0: some items deleted 
     *  - 1: all items deleted
     */
    public function deleteState() : false|int {
      return $this->deleteState;
    }

    /**
     * removes a file from a directory only if it exists
     *   - Note: no response message is set and the last url is also never updated.
     * @param string $path  path of file 
     * @param boolean $check 
     *    - if $check is set as true, method will return true if file does not exist
     *    - if $check is set as false, method will return true only if an existing file was unlinked
     * @return boolean
     */
    public function removeFile(string $path, bool $check = false) : bool {
      if(!is_file($path) && $check) return true;
      if(is_file($path)) return unlink($path);
      return false;
    }

    /**
     * Get the files in the url supplied
     *
     * @return mixed response
     *  - when argument is supplied, returns false
     *  - when argument is not supplied, returns the last error response
    */
    public function response(?string $message = null){

      if (func_num_args() < 1)  return $this->response; 

      $this->response = $message;
      return false;

    }

    /**
     * Specifically designed method for retrieving errors from Filemanager class. 
     * Returns an error message if an error exists during file transfer, file zipping
     *
     * @param boolean $all strictly returns detected errors from Enlist class too
     * @return mixed
     */
    public function err(bool $all = false) : mixed {
      if($all) return $this->error ?: $this->error();
      return $this->error;
    }

    /**
     * Returns TRUE on failure or FALSE on success during file transfer
     *
     * @return boolean
     */
    public function fails() : bool {
      return $this->error? true : false;
    }

    /**
     * Returns TRUE on success or FALSE on failure during file transfer. 
     *
     * @returns boolean
     */
    public function succeeds(): bool{
      return !$this->error? true : false;
    }    

    /**
     * Encrypt text files, images and other binary files
     *
     * @param string $file file path
     * @param string $output output path
     * @param string $password 
     * @return boolean - TRUE on success or FALSE on failure
     */
    public function encryptFile(string $file, string $output, string $password) {
      $data = file_get_contents($file);
      if($data === false){
        $this->error = 'file encryption cannot get file contents';
        return false;
      }

      $payload = $this->encryptPayload($data, $password);
      if($payload === false) return false;

      if(file_put_contents($output, $payload) === false){
        $this->error = 'file encryption cannot write output file';
        return false;
      }
      return true;
    }

    /**
     * Encrypt a string with a password using an authenticated cipher.
     *
     * The payload is laid out as:
     *  ```header | salt | iv | tag | ciphertext```
     * A random salt per payload means the same password never produces the same key
     * twice, and the AES-GCM tag makes a wrong password (or a tampered file) fail
     * loudly during decryption instead of yielding silent garbage.
     *
     * @param string $data
     * @param string $password
     * @return string|false encrypted payload or FALSE on failure
     */
    protected function encryptPayload(string $data, string $password) : string|false {

      if($password === ''){
        $this->error = 'file encryption requires a password';
        return false;
      }

      try{
        $salt = random_bytes(self::encSaltLen);
        $iv   = random_bytes(self::encIvLen);
      }catch(Exception){
        $this->error = 'file encryption cannot generate random bytes';
        return false;
      }

      $key = hash_pbkdf2('sha256', $password, $salt, self::encIterations, 32, true);
      $tag = '';
      $encrypted = openssl_encrypt($data, self::encMethod, $key, OPENSSL_RAW_DATA, $iv, $tag, '', self::encTagLen);

      if($encrypted === false){
        $this->error = 'file encryption failed';
        return false;
      }

      return self::encHeader . $salt . $iv . $tag . $encrypted;
    }

    /**
     * Decrypt a payload produced by {@see Filemanager::encryptPayload()}.
     *
     * Payloads without the current header are treated as the legacy
     * (unsalted SHA256 key, AES-256-CBC) format so that files encrypted by earlier
     * spoova versions can still be opened.
     *
     * @param string $payload
     * @param string $password
     * @return string|false decrypted string or FALSE on failure
     */
    protected function decryptPayload(string $payload, string $password) : string|false {

      $header = self::encHeader;
      $headLen = strlen($header);

      if(!str_starts_with($payload, $header)){
        // Legacy format : iv (16 bytes) followed by ciphertext.
        $options = $this->options;
        $iv = substr($payload, 0, 16);
        $encrypted = substr($payload, 16);
        $key = openssl_digest($password, $options['file-encryption-algo'], $options['file-encryption-binary']);
        $decrypted = openssl_decrypt($encrypted, $options['file-encryption-method'], $key, $options['file-encryption-option'], $iv);
        if($decrypted === false){
          $this->error = 'file decryption failed';
          return false;
        }
        return $decrypted;
      }

      $minimum = $headLen + self::encSaltLen + self::encIvLen + self::encTagLen;

      if(strlen($payload) < $minimum){
        $this->error = 'file decryption failed on incomplete or corrupt file';
        return false;
      }

      $offset = $headLen;
      $salt = substr($payload, $offset, self::encSaltLen); $offset += self::encSaltLen;
      $iv   = substr($payload, $offset, self::encIvLen);   $offset += self::encIvLen;
      $tag  = substr($payload, $offset, self::encTagLen);  $offset += self::encTagLen;
      $encrypted = substr($payload, $offset);

      $key = hash_pbkdf2('sha256', $password, $salt, self::encIterations, 32, true);
      $decrypted = openssl_decrypt($encrypted, self::encMethod, $key, OPENSSL_RAW_DATA, $iv, $tag);

      if($decrypted === false){
        $this->error = 'file decryption failed on wrong password or modified file';
        return false;
      }

      return $decrypted;
    }
    
   /**
     * Encrypt text files, images and other binary files
     *
     * @param string $file file path
     * @param string $output output path
     * @param string $password 
     * @param string|null $content references the decrypted file's content 
     * @return boolean - TRUE on success or FALSE on failure
     */
    public function decryptFile(string $file, string $output, string $password, &$content = null) {
      $data = file_get_contents($file);
      if($data === false){
        $this->error = 'file decryption cannot get file contents';
        return false;
      }

      $decrypted = $this->decryptPayload($data, $password);
      if($decrypted === false) return false;

      $content = $decrypted;
      return (file_put_contents($output, $decrypted) !== false);
    }
    
   /**
     * Encrypt text files, images and other binary files
     *
     * @param string $file file path
     * @param string $password 
     * @return string|false - decrypted string on success or FALSE on failure
     */
    public function decryptFrom(string $file, string $password) : string|false {
      $data = file_get_contents($file);

      if($data === false){
        $this->error = 'file decryption cannot get file contents';
        return false;
      }

      return $this->decryptPayload($data, $password);
    }

}