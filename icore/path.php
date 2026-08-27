<?php 

/* NOTE: This file must be included on every subdomain folder */
if(!defined('basefolder') || empty($_SERVER['DOCUMENT_ROOT'])){
  define("basefolder",dirname(dirname(dirname(__FILE__)))."/"); //path to site domain folder (editable)
  define("fol",basename(dirname(__DIR__)).'/');  //the parent folder for icore folder (not editable) 
  define("bfol",basefolder.fol); //sub folder root path;
  define("broot",rtrim($_SERVER['DOCUMENT_ROOT'],"/ ").'/'); //root path;
  
  /**
   * Returns the document root OR 
   * prepends the document root to supplied argument
   */
  function domroot($path = ''){
      $ds = DIRECTORY_SEPARATOR;
      $broot = str_replace(["/","\\"], $ds, realpath(broot).'/');
      $bfol = str_replace("\\",$ds, str_replace("/", $ds, bfol));

      if(empty($_SERVER['DOCUMENT_ROOT'])){
       
        return dirname(__DIR__).str_replace(['/','\\'], DIRECTORY_SEPARATOR, '/'.$path);
        
      }
      $broot = (!in_array($_SERVER['REMOTE_ADDR'],['127.0.0.1','::1','']))? dirname($broot) : $broot;
      $surl = ($broot != $ds)? str_replace($broot,'',$bfol) : $bfol;
      $surl = explode($ds,str_replace($ds.$ds, $ds, $surl));
      $xbfol = $surl[0];
      $xbfol .= !empty(trim($xbfol))? '/' : '';
      return str_replace("//","/",broot.$xbfol).$path; 
  }
  
  (function(){
      $resPath = dirname(dirname(__DIR__))."/res"; 
      $symPath = dirname(__DIR__)."/res";
      $corePath = dirname(dirname(__DIR__))."/core"; 
      $coresymPath = dirname(__DIR__)."/core";      
      
        if(!is_file($symPath) && file_exists($resPath)){
          if(function_exists('symlink')) {
            /** only for supported devices */
            @symlink($resPath, $symPath);
          }
        }  
        
        if(!is_file($coresymPath) && file_exists($corePath)){
          if(function_exists('symlink')) {
            /** only for supported devices */      
            @symlink($corePath, $coresymPath);
          }
        }         
        
  })(); 
  
  /**
   * Defines and returns the required base file
   */
  function filebase($directory = __DIR__){ 
    return is_file(realpath(dirname($directory))."/core/custom/base.php")?
      realpath(dirname($directory)).'/core/custom/base.php' : domroot().'icore/filebase.php';
  }

  /**
   * Determines whether a request is for a public file the web server should serve itself.
   *
   * A real web server answers a request for an existing file before the application is ever
   * reached, and the rewrite rules in ".htaccess" decide what may be reached at all. PHP's
   * built-in server has neither, so every request arrives at the router file and this is the
   * only place the two rules can be applied: hand over the public files, and keep the
   * application's own files off the web.
   *
   * @return bool TRUE when the file exists and may be served directly
   */
  function staticRequest() : bool {

    if(php_sapi_name() !== 'cli-server') return false;

    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    $path = trim(urldecode($path), '/');

    if($path === '') return false;

    // a php file is the application itself and is never handed over
    if(preg_match('/\.php$/i', $path)) return false;

    $segments = explode('/', str_replace('\\', '/', $path));

    foreach($segments as $segment){
      // dot files (i.e ".htaccess", ".env") and any attempt to climb out of the project
      if($segment === '' || $segment === '.' || $segment === '..') return false;
      if(str_starts_with($segment, '.')) return false;
    }

    // directories holding the framework, the project's code and its configuration
    $reserved = ['core', 'icore', 'windows', 'commands', 'notes', 'migrations', 'tests', 'vendor'];

    if(in_array(strtolower($segments[0]), $reserved, true)) return false;

    // and the files that belong to the project rather than to its visitors
    $private = ['mi', 'composer.json', 'composer.lock', 'phpunit.xml'];

    if((count($segments) === 1) && in_array(strtolower($segments[0]), $private, true)) return false;

    return is_file(dirname(__DIR__).DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $path));

  }

}


if(function_exists('domroot')){
  /* Re-caliberate Evironment */
  function htCaliber(bool $load = false, $loader = ''){
   
    if(!defined('online')){
      /** Refers to app deployment environment.*/
      define('online', !in_array($_SERVER['REMOTE_ADDR'] ?? '',['127.0.0.1','::1','']));
    }    
    $ENVIRONMENT = $_SERVER['ENVIRONMENT'] ?? $_SERVER['REDIRECT_ENVIRONMENT'] ?? '';
    //format htaccess
    if(is_file(domroot().".htaccess")){
      if($ENVIRONMENT){
        if(
          ($ENVIRONMENT == 'offline' && online) ||
          ($ENVIRONMENT == 'online' && !online) ||
          $load
          ){ 

          if(isset($_ENV['constants'])){

            $htCaliber = $_ENV['constants']['htErrors'];
            $htaccess = file_get_contents(domroot().".htaccess");
            $sp = str_repeat(' ', 4);
            
            if(is_array($htCaliber)){
              foreach($htCaliber as $error => $errorFile){
    
                $addLine = (!stristr($htaccess, 'ErrorDocument '.$error) && $errorFile);
                $errLine = "ErrorDocument ".$error." /";
    
                preg_match("@ErrorDocument[\s]+?".$error."[\s]+\/[a-zA-Z-_/0-9.]+@", $htaccess, $matches);
                $matchesText = $matches[0]?? '';
                $matches = str_replace("ErrorDocument ".$error,"", trim($matchesText, " "));   
             
                $pathExp = explode("/", ltrim($matches,"/ "), 2); 
                if(isset($pathExp[1]) || $addLine){
                  $path = $pathExp[1]?? '';
        
                  $enviroText = 'setEnv ENVIRONMENT ';	
                  $errdocpath = $errorFile; 
      
                  if(online){
                    $errDocText = $errLine.$errdocpath;
                    $htaccess = str_replace($enviroText.' offline', $enviroText.' online', $htaccess);
                  }else{
                    $errDocText = $errLine.fol.$errdocpath;
                    $htaccess = str_replace($enviroText.' online', $enviroText.' offline', $htaccess);
                  }
    
                  if(!$errorFile) { 
                    $errDocText = ""; 
                    $matchesText = "\n".$sp.$matchesText;
                  }
    
                  if($errDocText !== $matchesText){
                    if($loader) echo $loader; usleep(500000); 
                    $htaccess = str_replace($matchesText, $errDocText, $htaccess);
                    if($addLine){ 
                      $htaccess = str_replace("#ErrorDocuments","#ErrorDocuments\n".$sp.$errDocText, $htaccess);
                    }
                    $fp = fopen(domroot().'.htaccess', 'w+');
                    if(fwrite($fp, $htaccess));
                    fclose($fp);
                    if($load){
                      echo "<script>setTimeout(()=>{window.location.reload()},1000)</script>";
                      exit;
                    }
                  }             
                }			
              }
            }
          }
          
        }
      }
    }

  }
  htCaliber();
}