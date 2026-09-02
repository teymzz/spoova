<?php

namespace spoova\mi\core\classes;

use Error;
use Closure;
use Throwable;
use ErrorHandler;
use ReflectionFunction;
use spoova\mi\core\classes\Slicer;
use spoova\mi\core\classes\CompilerManager;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class Compiler {

    /**
     * Defines the base dump or storage compilation directory for rex file 
     *
     * @var string|boolean
     *  - FALSE (default) : uses the rex file storage directory (i.e core/storage).
     *  - TRUE : uses the rex file current directory
     *  - string: uses the custom directory specified 
     */
    private string|bool $base = false;
    private string $file = '';
    private $content = '';
    private static $addRex = '';
    private bool $addTemplate = false;
    private static $rexFile = '';
    private static $failedRex = '';
    private $activity = 'default';
    private array $args = [];
    private array $rexdata = [];

    /**
     * Stores internal compiler managers
     *
     * @var CompilerManager[]
     */
    private array $managers = [];

    /**
     * Instance of compiler
     *
     * @param string $rex path of rex file  
     * @param array $args
     */
    function __construct(string $rex = '', array $args = [])
    {

      $fargs = func_num_args();

      if($fargs > 0){
        $this->setFile($rex);
        if($fargs > 1) $this->setArgs($args);
        $this->setActivity();
      }
        
    }

    function addmanager(CompilerManager $Manager) {

      $this->managers[] = $Manager;

    }
    
    /**
     * This is used to specify the base or real storage path for the compiled rex file only. 
     *  - This should only be used after Compiler::setFile() is called.
     *
     * @param string|bool $filebase storage path for rex file
     *  - TRUE: specifies the dumping to the same directory as the rex file
     *  - FALSE or empty string: dumps to the default storage directory
     *  - '...': ellipses string dumps to the path defined or assumed (from base file) 
     *    using a global path format (i.e starting from the root of the application)
     * @return Compiler
     */
    function setBase(string|bool $filebase) : Compiler{
        $this->base = $filebase;
        return $this;   
    }

    /**
     * This will set the source rex file path and storage path by default.
     *  - Rex files should not have any dots in their file names except the '.rex.php' reserved extension name.
     *   
     * @param string $file path of rex file 
     *  - By default path supplied is assigned a prefix of 'windows/Rex' directory unless a suffix of three 
     *    dots '...' is appended on the path forcing the direct use of path supplied.
     * 
     * @param string|bool $base compiled file storage path.
     *  - Storage path for compiled file. 
     * 
     * @return Compiler
     */
    function setFile(string $file, string|bool $base = false) : Compiler {
        self::$rexFile = $file;
        $this->file = $this->base = $file;   
        $this->base = $base;
        return $this;
    }

    /**
     * This will return the rex base file path .
     *
     * @return string
     */
    function getFile() : string {
        return $this->file;
    }

    /**
     * This will return the source rex file path.
     *
     * @return string
     */
    static function currentFile() : string { 
        return self::$rexFile;
    }

    static function failedRex() : string { 
        return self::$failedRex;
    }
    
    /**
     * Parses arguments into compiler
     *
     * @param array $args
     * @return Compiler
     */
    function setArgs(array $args) : Compiler {
        $this->args = $args;        
        return $this;   
    }
    
    /**
     * Retrieves arguments parsed into compiler
     *
     * @return array
     */
    function getArgs() : array {
        return $this->args ?? [];
    }

    /**
     * Compile is a function used to compile rex files.
     * 
     * {@See Res::compile()}
     *
     * @param string|array $arg1 rex file path or arguments
     * @param array|string $arg2 rex file path or arguments
     *   - File paths are assumed to be within the WIN_REX directory
     * @return Compiler|False
     */
    function compile(array|string $arg1 = [], array|string $arg2 = ''): Compiler|False {

      // no template compilation / scaffolding / cache-write during a route scan
      if(RouteInspector::capturing()) return false;

      //slice data into url ...
      $fargs = func_num_args();

      if($fargs == 1){
        if(is_string($arg1)){
          $this->setFile($arg1);
        }elseif(is_array($arg1)) {
          $this->setArgs($arg1);
        }
      } else if ($fargs == 2) {

        if( is_string($arg1) && is_array($arg2) ){
          $this->setFile($arg1);
          $this->setArgs($arg2);
        } else if( is_string($arg2) && is_array($arg1) ) {   
          $this->setFile($arg2);
          $this->setArgs($arg1);
        } else {
          return EInfo::view('Both arguments of compile(#1, #2) cannot be of the same data type');
        }
        
      } else if ($fargs > 2) {
        return EInfo::view('Invalid count number of arguments supplied on compiler');    
      }

      $this->setActivity('default');

      return $this;

    }

    /**
     * This function sets a string for rendering
     *
     * @param string $content content to be rendered
     *
     * @return Compiler
     */
    function body(string $content) : Compiler {
      //slice data into url ... 
      $this->setActivity('body');
      
      $this->content = $content;

      return $this;
    }

    /**
     * Defines new custom directives
     *
     * @param string $name name of directive
     * @param callable $callback handler 
     * @return void
     */
    public static function directive(string $name, callable $callback){
      $directives = Slicer::directives();
      if(!$name || (strpos($name, ' ') !== false)) throw new Error('directive name "'.$name.'" is not allowed');
      $directiveName = strtolower($name);
      if(in_array($directiveName, $directives)){
        throw new Error('directive name "'.$name.'" already exists');
      }
      Slicer::new_directive($name, $callback);
    }

    /**
     * Determine the activity to be processed
     *
     * @param string $activity
     * @return void
     */
    private function setActivity(string $activity = 'default') { 

      $this->activity = $activity;

    }

    protected function resolve() : string {

        $rexFile = $this->rexdata();

        self::$rexFile = $rexFile['location'];
      
        $template = $this->fetchraw($rexFile);
       //create file, buffer and return data... 
       return $this->create_storage($rexFile['storage'], $template);

    }

    /**
     * Returns the raw data obtained from template file before processing
     *
     * @return string
     * 
     */
    public function raw() : string {
      return $this->fetchraw();
    }

    private function fetchraw($data = '') : string {

      $args = $this->args; 
      $nargs = func_num_args();

      $rexFile  = ($nargs > 0)? $data : $this->rexdata();

      $fileLoc  = $rexFile['location'];
      $fileUrl  = $rexFile['path'];
      $file     = $rexFile['file'];
      $format   = $rexFile['format'];
      $isScreen = $rexFile['isScreen'];
      $template = '';
      
      Slicer::setlocals($args);

      if( ($this->activity == 'body') || ($isScreen)) { 

        $template = Slicer::slice($this->content)->data();

      } else { 

        if($format == '::404'){  
          $data = file_get_contents(E_404.'.rex.php');
          $template = Slicer::slice($data)->data();
        }elseif($format == '::csrf'){
          $data = file_get_contents(E_CSRF.'.rex.php');
          $template = Slicer::slice($data)->data();  
        }elseif(!$isScreen) {
          if(!is_file($file)) {
            if((Init::key('COMPONENT_DIRECT') === 'FALSE') && is_dir($fileUrl) && is_file($fileUrl.DS.basename($fileUrl).'.rex.php')){
              $file = $fileUrl.DS.basename($fileUrl).'.rex.php';
            }elseif((Init::key('COMPONENT_VIEW') === 'NO_BLANKS') && is_file(_core.'/custom/errors/e-blank.rex.php')){

              self::$failedRex = $file;
              $file = _core.'/custom/errors/e-blank.rex.php';

            }elseif(self::$addRex || $this->addTemplate){
              //create a rex file if it does not exist (use template or throw error)
              if(!self::useTemplate($file, $fileLoc)) return false;
            }
          }elseif($this->addTemplate){
              //create a rex file if it does not exist (use template or throw error)
              if(!self::useTemplate($file, $fileLoc)) return false;
          }

          $template = Slicer::slice(Slicer::loadTemplate($file, $args))->data();

        }

      }

      foreach($this->managers as $manager) {

        $template = $manager->render($template);

      }      
      
      Slicer::unsort_escapes($template);

      return $template;

    }

    function __toString()
    {
      
      return $this->resolve();
        
    }

    private function create_storage(string $storage, string $content) : string
    {

        //push to file and return data 

        $Filemanager = new Filemanager;
        $realFile    = $storage;

        if($Filemanager->openFile(true, $realFile)){
    
            //get lastmodified of $path;
            if(file_exists($realFile)){
            
              //get contents of real file
              $realcontents = file_get_contents($realFile);

              clearstatcache(true, $realFile);
              
              if($realcontents !== $content){
                  file_put_contents($realFile, $content);
                  clearstatcache(true, $realFile);
              }

              foreach($this->args as $arg => $argval){
                if($arg != 'this'){
                  $$arg = $argval;
                }
              }
              
              try{
                ob_start();
                include($realFile);
                $content = ob_get_clean();
              }catch(Throwable $e){
                ErrorHandler::handleTemplate($e);
              }

              $this->content = $content;

            }
    
        }

        return $content;
    }

    private function rexdata() : array {        
        
        $file = $this->file ?: $this->base;
        $base = $this->base; //storage base
        if(str_ends_with($file, '....')) throw new Error('invalid rex file path format');
        $fpath = to_dirslash(trim($file,'./\\'), true);
        $folderPath = 'default'; // use 'core/storage' default path

        if($base === FALSE){
          $base = $fpath? $fpath : '';
        }elseif($base === TRUE){
          // use current rex path (same)
          $folderPath = 'same';
          $prefix = str_ends_with($file,'...')? '' : WIN_REX;
          $base = $prefix.$fpath; // use same rex folder (default rex path + relative path) ->
        }elseif(is_string($base)){
          $folderPath = 'global'; // use the custom path defined along with the file name 
          $base = trim(to_frontslash($base, true), '/');
          if($base) $base .= DS;
          $base .= basename($fpath);
        }

        if(empty($file)){
          throw new Error('no file supplied for compiler'); // used because EInfo not showing debugger info box
          return [];
        }

        //set default url format
        $format = '';

        //reserved screens
        $reserved = ['::404', '::csrf'];

        //set default determinant for escaped rex file url
        $escape = false;
        $createFile = false;

        //determine screen and load ... 
        $isScreen = ((str_starts_with($base, '::')) && !in_array($base, $reserved));
 
        if($isScreen){ $file = substr($base, 2); }

        $rexpath = rtrim($file,'./');
        $rexpath = str_replace('.','/', $rexpath);

        if(($global = str_ends_with($file,'...')) || (str_ends_with($file,'..'))) {
          if($global){
            $file = docroot.DS.substr($file, 0, strlen($file) - 3);
          }else{
            $file = docroot.DS.WIN_REX.substr($file, 0, strlen($file) - 2);
          }
          $file = to_dirslash($file, true);
          $createFile = true;
        }

        if(strpos($file, docroot, 0) === false){      
          $file = $fileUrl = docroot.DS.WIN_REX.ltrim($rexpath,'/\\'); 
        }else{
          //allow full paths
          $file = $fileUrl = $file; $escape = true;
          $trimFile = str_ends_with($file, '.rex.php')? substr($file, 0, strlen($file) - 8) : $file;
          $trimFile = to_frontslash($trimFile);

          $rexPath = to_frontslash(docroot.DS.WIN_REX);
          $rootPath = to_frontslash(docroot);

          if(str_starts_with($rexPath, $trimFile)){
            $rexpath = explode($rexPath, $trimFile, 2)[1];
          }else{
            $rexpath = explode($rootPath, $trimFile, 2)[1];
          }

        }

        if($rexpath == '::404'){
          $format = '::404';
          $fileUrl = E_404;
          $storage = $rexpath = 'errors/e-404';      
        }elseif($rexpath == '::csrf'){
          $format = '::csrf';
          $fileUrl = E_CSRF;
          $storage = $rexpath = 'errors/e-csrf';          
        }else{
          $storage = $base;
        }
        $storage = DS.ltrim($storage, '/\\');

        if($folderPath === 'default'){
          $storage = _core.'storage'.$storage.'.php';
        }else{
          $storage = _root.$storage.'.php';
        }
        $storage = to_dirslash($storage);
        //convert file url to full rex file path
        $file = !$escape || $createFile? Slicer::sliceUrl($fileUrl): $file;

        if($createFile && !is_file($file)){
          $this->addTemplate = true;
          $Filemanager = new Filemanager;
          if(!$Filemanager->openFile(true, $file)){
            throw new Error('auto template file creation denied.');
          }
        }
   
        $rexdata = $this->rexdata = [
          'location' => to_dirslash($rexpath), //assumed path of file within rex folder (without extension)
          'path' => to_dirslash($fileUrl), // rex path (rex directory + location)
          'file' => to_dirslash($file),    // rex file (rex path + rex extension)
          'isScreen' => $isScreen,
          'format' => $format,
          'storage' => to_dirslash($storage)
        ];
        return $rexdata;
    }

    /**
     * Use default template syntax
     *
     * @param string $file
     * @param string $rexpath path of rex file 
     * @return bool
     */
    private function useTemplate($file, $rexpath) : bool {

        $addRex = self::$addRex;
        $addRex2 = $this->addTemplate;

        if($addRex || $addRex2){

          self::$addRex = false;
          $this->addTemplate = false;

          //create rex file... 
          $Filemanager = new Filemanager;
          if($Filemanager->openFile(true, $file)){
  
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $fileName = substr($fileName, 0, strlen($fileName) - 4);
            
            if(is_string($addRex) && ((str_ends_with($addRex,'...') && is_file(_root.substr($addRex, 0, -3).'.rex.php')) || (is_file(_root.'/windows/Rex/'.to_frontslash($addRex, true).".rex.php"))) ) {          
              $template = <<<Template
              @template('$addRex')
  
  
  
              @template;
              Template;
            }  else {
  
              $template = <<<Template
              <!DOCTYPE html>
              <html lang="en">
                <head>
                    @live
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>$fileName</title>
                </head>
                <body>
                    
                </body>
              </html>
              Template;
  
            }   
          
            file_put_contents($file, $template);
            redirect(window('base'));
          }
          monitor();
        }
        if($addRex2) return false;
        return EInfo::view('Template file: <i><u>'.Slicer::sliceUrl($rexpath).'</u></i> does not exists. Ensure your template file is of php extension within "rex" directory');                
  
      }
    
      /**
       * Defines that a rex file should be created if it does not exist
       *
       * @param boolean $add
       * @return void
       */
      public static function addRex(bool|string $add = true){
        self::$addRex = $add;
      }

      /**
       * Return a rendered rex file
       *
       * @param string $path  path to rex file
       * @param Closure|False|String $callback
       * @return Compiler|String
       */
      public static function read(string $path, Closure|False|String $callback = '') : Compiler|String {

        // return nothing during a route scan (no compile/scaffold/cache)
        if(RouteInspector::capturing()) return '';

        if($callback instanceof Closure){

          $reflection = new ReflectionFunction($callback);
          $parameters = $reflection->getParameters();
          $dependencies = [];

          foreach($parameters as $parameter){

            $dependenceClass = (string) $parameter->getType();

            if(class_exists($dependenceClass) && !in_array($dependenceClass, ['bool','float','int','string', 'mixed'])){
              $dependencies[] = new $dependenceClass();
            }

          }

          //execute callback and return value

          $caller = $reflection->invokeArgs($dependencies);
          
          if($caller instanceof Compiler){
            $caller->setFile($path)->setBase(false);
            return $caller; 
          }else{
            $Compiler = new Compiler();
            $Compiler->setFile($path)->setBase(false);
            $Compiler->body($caller);
            return $Compiler;
          }
          
        } else if (func_num_args() == 1) {
  
            $Compiler = new Compiler();
            $Compiler->setFile($path)->setBase(false);
            $Compiler->compile([]);
            return $Compiler;        
  
        }
        return '';
        
      }

}