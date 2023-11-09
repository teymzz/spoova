<?php

namespace spoova\mi\core\classes;

class Compiler {

    private $base;
    private $file;
    private $content = '';
    private static $addRex = '';
    private $activity = 'default';
    private array $args = [];
    private array $rexdata = [];
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

    function addmanager(CompilerManagers $Manager) {

      $this->managers[] = $Manager;

    }
    
    /**
     * This is used to specify the storage path for rex file only. 
     * This should only be used after Compiler::setFile() is called.
     *
     * @param string $filebase storage path for rex file
     * @return Compiler
     */
    function setBase(string $filebase) : Compiler{
        $this->base = $filebase;
        return $this;   
    }

    /**
     * This will set the source rex file path and storage path by default.
     *
     * @param string $file path of rex file
     * @return Compiler
     */
    function setFile(string $file) : Compiler {
        $this->file = $this->base = $file;   
        return $this;
    }
    
    /**
     * Instance of compiler
     *
     * @param array $args
     * @return Compiler
     */
    function setArgs(array $args) : Compiler {
        $this->args = $args;        
        return $this;   
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

      foreach($this->managers as $manager) {

        $content = $manager->render($content);

      }
      
      $this->content = $content;

      return $this;
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

        $template = $this->raw($rexFile);
        
        //create file, buffer and return data... 
       return $this->create_storage($rexFile['storage'], $template);

    }

    /**
     * Returns the raw data obtained from template file before processing
     *
     * @return string
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
            if(is_dir($fileUrl) && is_file($fileUrl.DS.basename($fileUrl).'.rex.php')){
              $file = $fileUrl.DS.basename($fileUrl).'.rex.php';
            }elseif((Init::key('WEBVIEW') === 'NO_BLANKS') && is_file(_core.'/custom/errors/e-blank')){

              $file = _core.'/custom/errors/e-blank';

            }elseif(self::$addRex){
              //create a rex file if it does not exist (use template or throw error)
              if(!self::useTemplate($file, $fileLoc)) return false;
            }
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

        $Filemanager = new FileManager;
        $realFile    = $storage;

        if($Filemanager->openFile(true, $realFile)){
    
            //get lastmodified of $path;
            if(file_exists($realFile)){
            
            //get contents of real file
            $realcontents = file_get_contents($realFile);

            clearstatcache(true, $realFile);

            if($realcontents !== $content){

                file_put_contents($realFile, $content);

            }

            //for each
            foreach($this->args as $arg => $argval){
              if($arg != 'this'){
                $$arg = $argval;
              }
            }
                
            ob_start();
            include($realFile);
            $content = ob_get_clean(); //updated content
            $this->content = $content;

            }
    
        }

        return $content;
    }

    private function rexdata() : array {        
        
        $file = $this->file ?: $this->base;
        $base = to_frontslash($this->base ?: '', true); //storage base

        if(empty($file)){
          EInfo::trigger('no file supplied for compiler', true);
          return [];
        }

        //set default url format
        $format = '';

        //reserved screens
        $reserved = ['::404', '::csrf'];

        //set default determinant for escaped rex file url
        $escape = false;

        //determine screen and load ... 
        $isScreen = ((substr($base, 0, 2) === '::') && !in_array($base, $reserved));
 
        if($isScreen){ $file = substr($base, 2, strlen($base)); }

        $rexpath = rtrim($file,'/');
        $rexpath = str_replace('.','/', $rexpath);
        
        if(strpos($file, docroot, 0) === false){        
          $file = $fileUrl = docroot.DS.WIN_REX.$rexpath;
        }else{
          //allow full paths
          $file = $fileUrl = $file; $escape = true;
          $rexpath = explode(docroot, rtrim($file, '.rex.php'), 2)[1];
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

        $storage = _core.'storage/'.$storage.'.php';
             
        //convert file url to full rex file path
        $file = !$escape? Slicer::sliceUrl($fileUrl): $file;

        return $this->rexdata = [
          'location' => to_dirslash($rexpath), //assumed path of file within rex folder (without extension)
          'path' => to_dirslash($fileUrl), // rex path (rex directory + location)
          'file' => to_dirslash($file),    // rex file (rex path + rex extension)
          'isScreen' => $isScreen,
          'format' => $format,
          'storage' => to_dirslash($storage)
        ];

    }

    /**
     * Use default template syntax
     *
     * @param string $file
     * @param string $fileName
     * @param string $addRex
     * @return bool
     */
    private function useTemplate($file, $rexpath) : bool {

        $addRex = self::$addRex;
  
        if($addRex){

          self::$addRex = false;

          //create rex file... 
          $Filemanager = new FileManager;
          if($Filemanager->openFile(true, $file)){
  
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $fileName = substr($fileName, 0, strlen($fileName) - 4);
  
            if(is_string($addRex) && is_file(docroot.'/windows/Rex/'.to_frontslash($addRex, true).".rex.php") ) {          
                      
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
  
          }
          monitor();
        }
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

}