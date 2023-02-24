<?php

namespace spoova\core\classes;

use ZipArchive;
use spoova\core\classes\Enlist;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

/**
 * This is a powerful class for managing files & folders
 */
class FileManager extends Enlist{

    private static string $envKey = ':ENV';
    private static array $envData = [];
    private string $url = '';
    private string $lastDir = '';
    private $zipName;
    private $response = '';
    private $error;

    /**
     * Set a url for reading content
     * 
     * @param string $url url of file or folder to be managed
     * @return class
    */
    public function setUrl(string $url = ''){
      $this->url = $url;
      $this->lastDir = $url;
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
      if($this->url == null){ return $this->response('invalid url supplied'); }

      $url   = $this->url;
      if(strpos(strlen($url), '/') === false){
        $url .="/";
      }

      $all   = glob($url."*");
      $dirs  = array_filter($all, 'is_dir'); //only directories

      if(!$fullPath){
        $dirs = array_map(function($folder){
          return pathinfo($folder, PATHINFO_BASENAME);
        }, $dirs);
      }

      return $dirs;
    }

    /**
     * Get the files existing in the url supplied
     *
     * @param boolean $fullPath 
     *  - false returns only the file names
     * @param boolean $addExtension false removes extension name of files 
     * @return array
    */
    public function getFiles(bool $fullPath = true, $addExtension = true){

      if($this->url == null){ return $this->response('invalid url supplied'); }
      
      $url   = $this->url;
      if(strpos(strlen($url), '/') === false){
        $url .="/";
      }
      
      $all   = glob($url."*");
      $files = array_filter($all, 'is_file');

      if(!$fullPath){
        $files = array_map(function($file) use($addExtension) {

          if(!$addExtension) return pathinfo($file, PATHINFO_FILENAME);
          return pathinfo($file, PATHINFO_BASENAME);
          
        }, $files);
      }

      return $files;
    }

    /**
     * - Reads a list of keys or key from a file and returns an array of keys and values
     * - Checks if a key exists in file if second argument is set as true.
     * 
     * @todo Add muliple delimiter support (currently using semicolon)
     * @param array|string $key list of key(s) to be fetched from file. Bool:true reads entire file
     * @param string|bool $separator A line key-to-value unique separator character
     *
     * @return array|bool :
     *        @return array array of keys and values => if @param $separator character is defined (NOT true) and @param array|string $key(s) exist in file
     *        @return bool(true)                     => if @param $separator === true and @param string $key exists in file
     *        @return bool(false)                    => if @param $separator === true and @param string $key does not exists in file or file in not readable
     *        @throw Notice Error                    => if file is not readable or separator is the same as delimiter
     */
    public function readFile($key = null, $separator= ":"){
      
      if(!is_readable($this->url)){
        trigger_error("url \"".$this->url."\" is not readable");
        return false;
      }   

      $delimiter = ";";
      if(trim($separator) === $delimiter) trigger_error("separator cannot be the same as delimiter", E_USER_ERROR);
      
      if(empty($key)) return false;
      $reading = fopen($this->url, 'r');
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
                  
                  $lineText = (empty(trim($lineText1)))? $lineText2 : $lineText1;

                  //* find key value using delimiter
                  $lineText = rtrim(trim($lineText), $delimiter.' ');

                  //* add space if necessary
                  if($lineText2) $textkey .= " ";
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
     *
     * @param bool $strict true creates directory if not exist
     * @param string $url optional url. When not supplied,uses default url
     * @return bool true if directory exists or is created successfully
     */
    public function openFile(bool $strict = false, string $url = '') : bool {
      
      //get default set directory
      $fileUrl = $url ? $url : $this->url;

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
        //if($open) fclose($open);
      }
      return is_readable($fileUrl);
    }

    /**
     * Create multiple paths at a go
     *
     * @Note: This will create directories if it does not exist
     * @param array|string[] $urls list of paths to be created
     * @return bool
     */
    public function openFiles(array|string $urls) : bool {

      if(func_num_args() > 1){
        $urls = func_get_args();
      }else{
        $url = (array) $urls;
      }

      if(!arrInside($urls)){
        $counter = 0;
        foreach($urls as $url){

          if(trim($url)) {

              if(!$this->openFile(true, $url)) {
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
      $separator = ($options['separator'])?? ":";
      $delimiter = ";";
      if($separator === $delimiter) trigger_error("separator cannot be the same as delimiter", E_USER_ERROR);

      foreach($data as $key => $value){
        if(is_numeric($key)) trigger_error('keys must have a string name',E_USER_ERROR);
        $newText .= " ".$key.$separator." ".(is_array($value)? "[".json_encode($value)."]" : $value).$delimiter."\n";  
      }
      //if(is_array($value)) $value = "[".json_encode($value)."]";

      //$newText = $key."".$value;
      $newText = rtrim(preg_replace('/[[:blank:]]+/',' ',$newText));
      $newText = $this->reFormat($newText);
      return $this->writerEngine($newText, $options, 'wFile');
    }

    /**
     * Updates a existing text key or adds a new text 
     *
     * @param string|array $data data of array key(s) with new values to be added to file
     * @param array $options postions to add new text [before, after]
     * @return boolean
     */
    public function textUpdate($data, &$upds = '', $separator = ":") : bool {

      $fileUrl = $this->url;
      if(!is_file($fileUrl)) return false;   

      $reading = fopen($fileUrl, 'r');
      $delimiter = ";";

      if(trim($separator) == '') trigger_error('separator cannot be null', E_USER_ERROR);

      $replaced = false;
      $replacements = [];
      $lines = '';
      $arrLines = [];

      while (!feof($reading)) {
        $line = fgets($reading);
        
        $line = ltrim($line);
        $line = (empty($line))? "\n" : " ".$line;

        foreach($data as $datakey => $dataValue){
          if(is_numeric($datakey)) trigger_error('data keys should not be integers', E_USER_ERROR);
          if(is_array($dataValue)){
            $dataValue = "[".json_encode($dataValue)."]";
          }
          
          if(empty(ltrim($datakey) || empty($line))) continue;
          $idatakey = !empty($datakey)? ltrim($datakey) : ' '.$datakey;
          
          if (stristr($line, $datakey.$separator)){        
            $replaced = true;
            $replacements[] = $datakey;
            $line = explode(":", $line, 2);
            $line = $line[0].$separator." ".$dataValue.$delimiter."\n";
            unset($data[$datakey]);
            break;
          }
        }
        $arrLines[] = ltrim(rtrim($line));
        
      }
    
      if(!empty($data)){
          $replaced = true;
          $newText = "";
          foreach($data as $key => $value){
            if(is_numeric($key)) trigger_error('keys must have a string name',E_USER_ERROR);

            //may later require trimming later...
            $arrLines[] = $key.$separator." ".(is_array($value)? "[".json_encode($value)."]" : $value);

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
     * @param int   $newline number of lines to be added
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
     * @param array|string $keys line key or array of lines keys
     * @param void $dels anchors/contains array of keys deleted keys
     * @param string $separator A key to value separator
     *  - A separator should not exist twice on a single line
     * @return bool true if any text was deleted
     */
    public function textDelete($keys, &$dels = [], $separator = ":"){
     
      $fileUrl = $this->url;
      if(!is_file($fileUrl)) return false;

      $reading = fopen($fileUrl, 'r');
      $lines   = '';
      $edited  = false;

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
          $lines .= $line;
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
     * @return array
     *   - Note that a delimiter of semicolon (i.e ";") will be trimmed off
     */
    public function readAll(string $separator = ':') {

      if(!is_readable($this->url)){
        trigger_error("url ".$this->url." is not readable");
        return false;
      }   

      $delimiter = ';';
      $lines = file($this->url, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $contents = [];

      foreach($lines as $line) {

        if (strpos(trim($line), '#')) continue;
        if(pathinfo($this->url, PATHINFO_EXTENSION) == 'php'){
          if( strstr($line, "<?php")  || strpos($line, "?>") || (strpos(trim($line), "//") === 0)){
            continue ;
          }
        }

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
     * @param string $newTexT text to be added to file
     * @param array $options postions to add new text [before, after]
     * @return boolean true if any text was added
     */
    private function writerEngine(string $newText = "", array $options = [], $type = '') : bool{
      $fileUrl = $this->url;
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
                //fputs($writing, $newText);
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
      
      $fileUrl = $this->url;
      if(!is_file($fileUrl)) return false;   

      $reading = fopen($fileUrl, 'r');
      $delimiter = ";";
      $lines = "";
      $arrLines = [];

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
     * @param string $url file url
     * @param string $separator a unique separator
     * @return array pair of keys and values
     */
    public static function load($url, $separator = ':'){
      $self = new self;

      $self->url = $url;
      $configs = $self->readAll($separator);
      
      return $configs;
    }    

    /**
     * Reads supplied url and saves into $_ENV
     *  
     * @param string $url file url
     * @param string $key 
     *  - $_ENV will localize data into $key if not empty. This will not be reflected in data returned by this method.
     *  - True will use global config keys from data returned that may overwrite any pre-existing key found in $_ENV.
     *  - False will use global config keys from data returned that will NOT overwrite any pre-existing key found in $_ENV
     * @param string $separator a unique key to value separator.
     * @return array pairs of keys and values
     */
    public static function loadenv($url, bool|string $key = ':ENV', string $separator = '='){

      $configs = self::load($url, $separator);
      
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
      $url = $this->url;

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
     *
     * @param string $path new directory to be created 
     * @return bool true if directory is created or exists else return false
     */
    public function addDir(string $path){
      if(pathinfo($path,PATHINFO_EXTENSION) != ''){
        return $this->response('invalid name supplied!');
      }

      if(!is_dir($path)){
        mkdir($path,0777,true);
      }
      
      return is_dir($path)? true : false;
    }


    /**
     * Zip a defined file or directory path
     *
     * @param string $output_name new name/path of zipped output file
     * @param array $exclude list of subdirectories or subfiles using relative paths
     * @notice method does not support encrypting zip file
     * @return bool|FileManager
     */
    public function zipUrl(string $output_name = '', array $exclude = []){

      //directory or file to be zipped
      $dir = realpath($this->url);

      if(!file_exists($dir)) {
        trigger_error('invalid zip source path');
        return false;
      }

      $output_name = ($output_name)? $output_name : $dir;

      //set the output extension
      if(pathinfo($output_name, PATHINFO_EXTENSION) != 'zip'){
        $output_name .= ".zip";
      }

      $zip = new ZipArchive();
      $zip->open($output_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);

      //recursive directory iterator
      $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir),
        RecursiveIteratorIterator::LEAVES_ONLY
        );

      $exclude = array_map(function($path) use($dir) {
        return str_replace('/','\\',(is_dir($dir) && is_string($path))? rtrim($dir, '/ ').'/'.ltrim($path, '/ ') : $path);
      }, $exclude);

      foreach($files as $name => $file){
        
         if(!$file->isDir()){

          //* Get real & relative path
          $path = $file->getRealPath();
          $relpath = substr($path, strlen($dir) + 1);

          //add excluded path or directory to array
          $exclusion = array_map(function($val) use($path, $dir) {
             return (substr($path, 0, strlen($val)) == $val)? $path : '';
          }, $exclude);

          if(!in_array($path, $exclusion)){
            //* Add current non-excluded file to archive  
            $DS = '\\';     
            $zip->addFile($path, str_replace(['\\','/',' '],[$DS,$DS,''], $relpath));
          }

         }
      }

      $zip->close();
      
      $this->lastDir = realpath($output_name); 
      $this->zipName = $output_name;
    
      return $this;
    }

    /**
     * Decompresses the zipped file path defined in the last directory.
     * The last directory needs to be updated to a zip file path using setUrl()
     * in order to use this method.
     * 
     * @param bool $del true deletes zip file path after decompressing it.     
     * @param bool $strict true prevents previous errors from stopping code execution
     * @notice - This decompresses an unencypted zipped file from a defined url to the url's direct parent directory. 
     * @return Filemanager
     */
    public function decompress(bool $del = false, bool $strict = false) : FileManager {

      //prevent or allow further code execution if has previous error
      if($this->error && !$strict) return $this;

      //modify error status on strict code execution if has previous error
      if($this->error && $strict) $this->error = false;    

      $curdir = realpath($this->lastDir);

      if(!is_file($curdir)){
        $this->error = ('invalid file to decompress');
        return $this;
      }

      $foldername = pathinfo($curdir, PATHINFO_DIRNAME). '/' .
                    pathinfo($curdir, PATHINFO_FILENAME);

      if(!is_dir($foldername)){

        if($this->addDir($foldername)) {
          //decompress zip file
          $zip = new ZipArchive;
          if($zip->open($curdir)){
              $zip->extractTo($foldername);
              $zip->close();
              if($del) unlink($curdir);            
              return $this; 
          } else {
            $this->error = ('cannot open zip file to decompress');
            return $this;        
          }          
        } else {
            $this->error = ('cannot decompress to missing directory: "'.$foldername.'"');
            return $this; 
        }

      } else {
            $this->error = ('cannot decompress to an existing folder');
            return $this;           
      }

    }

    /**
     * Returns true if the file or directory supplied was successfully zipped
     *
     * @return bool
     */
    public function zipped() : bool {
      return is_file($this->lastDir());
    }

    /**
     * Returns the last directory or last zip output file path 
     *
     * @return string
     */
    public function lastDir(){
      return $this->lastDir;
    }

    /**
     * Copy last declared file or folder to another location
     *
     * @param string $newdir new directory
     * @param string $newname new file name
     * @param bool $strict true prevents previous errors from stopping code execution
     * @return Filemanager
     */
    public function copyTo(string $newdir, string $newname = '', bool $strict = false) : Filemanager {

      //prevent or allow further code execution if has previous error
      if($this->error && !$strict) return $this;

      //modify error status on strict code execution if has previous error
      if($this->error && $strict) $this->error = false;      

      if(!file_exists($this->lastDir)) {
        $this->error = 'invalid source path "'.$this->lastDir.'"';
        return $this;
      }

      if(!is_dir($newdir)) {
        $this->error = 'invalid file destination path';
        return $this;
      }

      //set new path or directory
      $newDir = realpath($newdir)."\\";
      $newDir .= ($newname == '')? basename($this->lastDir) : $newname;

      if(!is_writable(realpath($newdir)."\\")){
        $this->error = 'copy destination path is not writeable';
        return $this;
      }

      copy($this->lastDir, $newDir);
      $this->lastDir = $newDir;
      return $this;
    }

    /**
     * move last declared file or folder to another location
     *
     * @param string $newdir new directory
     * @param string $newname new file name
     * @param bool $strict true prevents previous errors from stopping code execution
     * @return Filemanager
     */
    public function moveTo(string $newdir, string $newname = '', bool $strict = false) : FileManager {
      
      //prevent or allow further code execution if has previous error
      if($this->error && !$strict) return $this;

      //modify error status on strict code execution if has previous error
      if($this->error && $strict) $this->error = false;     
      
      if(!file_exists($this->lastDir)) {
        $this->error = ('invalid source path "'.$this->lastDir.'" ');
        return $this;
      }

      if(!is_dir($newdir)) {
        $this->error = ('invalid file destination path: "'.$newdir.'"');
        return $this;
      }

      //set new path or directory
      $newDir = realpath($newdir)."\\";
      $newDir .= ($newname == '')? basename($this->lastDir) : $newname;
  
      if(!is_writable(realpath($newdir)."\\")){
        $this->error = ('destination path "'.$newDir.'" is not writeable');
        return $this;
      }

      if(!file_exists($newDir)){
        rename($this->lastDir, $newDir);
      }else{
        $this->error = ('destination path "'.$newDir.'" already exists');
      }

      $this->lastDir = $newDir;
      return $this;
    }

    /**
     * Moves a folder or file to a new location function
     *
     * @param string $param1 first location as source or destination
     * @param string $param2 second (optional) location as destination
     * 
     * @return boolean true if $path is moved successfully.
     */
    public function move($param1 = '', $param2 = '') : bool{

      $selection = $this->url;

      
      if(!file_exists($selection)){ return false; }

      if(func_num_args() === 1){
        //move selection to a new location
        
        if(!is_dir($param1)){ return false; }
        rename($selection, $param1);
        return file_exists($param1."/".$param2);
      }

      if(func_num_args() === 2){
        //move $param1 in selection to $param2
        if(!file_exists($param2)){ return false; }
        if(file_exists($selection.'/'.$param1)){
          rename($selection.'/'.$param1, $param2.'/'.$param1);
          return file_exists($param2.'/'.$param1);
        }
        return false;
      }

      return false;
    }

    /**
     * Deletes a supplied file or folder directory
     *
     * @param string $dir
     *  - When not defined, deletes the last defined url.
     * @return boolean
     */
    public function deleteFile($dir = '') : bool {

      $path = realpath((func_num_args() > 0)? $dir : $this->url);


      if(file_exists($path)){

        //remove all items in folder first
        foreach(glob($path.'/*') as $file){
            if(is_file($file)){
                unlink($file);
            }elseif(is_dir($file)){
                $this->deleteFile($file);
            }
        }    

        //delete folder
        if(is_dir($path)) rmdir($path);

        return true;
      } else {
        $this->error = ('cannot delete from an invalid file or folder path "'.$dir.'"');
        return false;
      }

    }

    /**
     * removes a file from a directory only if it exists
     *   - Note: no response message is set
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
    public function response($message = null){

      if (func_num_args() < 1)  return $this->response; 

      $this->response = $message;
      return false;

    }

    /**
     * Returns an error message if an error exists during file transfer
     *
     * @return string
     */
    public function err(){
      return $this->error;
    }

    /**
     * Returns an error message if an error exists during file transfer
     *
     * @return boolean
     */
    public function fails() : bool {
      return $this->error? true : false;
    }

    /**
     * Returns true if no error exists during file transfer
     *
     * @returns boolean
     */
    public function succeeds(): bool{
      return !$this->error? true : false;
    }    

}