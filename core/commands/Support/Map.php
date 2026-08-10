<?php

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com>.
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 *  This may cause app to break or lead to other undesired errors.
 */
namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

class Map extends Entry{

    private $recompile;

    private $mapped = false;

    /**
     * array of arguments
     *
     * @param array $args
     */
    function __construct($args = [], $disp = true) {

        if($disp) Cli::headerView('map : calibrate', break: 1);
 
        if(!$this->validate_arguments($args)) return;

        $fol = $args? $args[0] : trim(fol, '/ ');
        $project_path = dirname(docroot).'/'.$fol;
        $htaccess = $project_path.'/.htaccess'; //htaccess text
        
        if(!is_file($htaccess)){
          // display missing htaccess file 
          Cli::clearView('missing htaccess file.', $disp ? 0 : '4')->pause(1)->clearLine();
          Cli::pulseView(Cli::textBuild('regenerating htaccess file ...', $disp ? 0 : '3'))->pulseToggle(3, 10);
          
          $mihtaccess = self::mihtaccess(); //htaccess text
          touch($htaccess);
          
          if(is_file($htaccess)){
            Cli::clearLine();
            Cli::pulseView(Cli::textBuild('htaccess file loading ...', $disp ? 0 : '3'))->pulseToggle(3, 10);
            file_put_contents($htaccess, $mihtaccess);
            Cli::clearLine();
            Cli::pulseView(Cli::textBuild('htaccess file loaded', $disp ? 0 : '3'))->pause(1);
            Cli::clearLine();
          }else{
            Cli::clearLine()->errorView('project mapping requires '.Cli::warn('.htaccess').' file', indent: $disp ? 0 : '3');
            return;
          }

        }
        
        //format htaccess
        if(is_file($htaccess)){

            //$fdomroot = $args? dirname(domroot()).'/'.$args[0].'/' : domroot();
            $fdomroot = $project_path.'/';

            //current file 404 settings
            $curDocText = $this->fetchErrDoc($fdomroot, $htaccess);

            //expected file 404 settings
            $errDocText  = $this->errorDocText($curDocText, $fol);
            
            if($errDocText){
                if($errDocText != $curDocText){
                    if($disp) $this->display('mapping project ...');

                    if(isset($htaccess)) $htaccess = str_replace($curDocText, $errDocText, $htaccess);

                    $fp = fopen($fdomroot.'.htaccess', 'w');
                    fwrite($fp, $htaccess);
                    fclose($fp);

                    //try checking htaccess again
                    $curDocText = $this->fetchErrDoc($fdomroot, $htaccess);

                    if($curDocText == $errDocText){

                        $this->mapped = true;

                    }else{

                        $this->mapped = false;

                        Cli::infoView(' Info ', 'project mapping failed!', break:'1|1');
                        
                        return;

                    }

                    if(!$args){
                        $text = server ?: 'http://localhost/'.$fol;
                        Cli::textView($fol.' >> '.$text, break: 1);
                    }

                }else{
                    Cli::infoView(' Info ', 'project already mapped!', break:'1|1');
                }
            }

        } else { 

            $this->addError('no htaccess file found!');

        }

    }
    
    public function mapped() : bool {
      return $this->mapped;
    }

    /**
     * Fetch htaccess data
     *
     * @param string $dir directory of htaccess file
     * @param string &$htaccess referenced variable for htaccess content
     * @return string
     */
    private function fetchErrDoc($dir, &$htaccess = ''){
        $htaccess = file_get_contents($dir.".htaccess");
        preg_match("@ErrorDocument[\s]+?404[\s]+\/[a-zA-Z-_/0-9.]+@", $htaccess, $matches);
        return setVar($matches[0]);
    }

    //get error document text
    private function errorDocText(string $matchesText, string $fol) : string{
        $matches = str_replace("ErrorDocument 404","", trim($matchesText, " "));   
        
        $fol = ($fol)? $fol."/" : $fol;

        $pathExp = explode("/", ltrim($matches,"/ "), 2); 
        if(isset($pathExp[1])){
            $path = $pathExp[1];
            $errDocPath = $_ENV['constants']['htErrors']['404'];
            if(online){
                $errDocText = 'ErrorDocument 404 /'.$errDocPath.$path;
            }else{
                $errDocText = 'ErrorDocument 404 /'.$fol.$errDocPath;
            }
            return $errDocText;
        }
        return '';
    }

    private function validate_arguments(array $args){

        if(count($args) > 1) {

             $this->addError('invalid arguments count');
            return;
           
        }

        return true;
    }
    
    private static function mihtaccess() : string {
      
      return <<<HT
             <IfModule mod_rewrite.c>
                
                #Basic Options -------------------------------------------------
                Options -Multiviews
                RewriteOptions inherit
                RewriteEngine on
            
                #ErrorDocuments: caution!!!
                # ErrorDocument 404 /spocs/res/errors/404.php
            
                #Advanced Options ----------------------------------------------
            
                # Block direct access to ALL php files
                # RewriteCond %{THE_REQUEST} \.php [NC]
                # RewriteRule ^ - [R=404,L]
                  
                #remove php file extension 
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteCond %{THE_REQUEST} ^[A-Za-z]{3,}\s([^.]+)\.php [NC]
                RewriteRule ^ %1 [R=301,L]
                
                #add php extension internally
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteCond %{REQUEST_FILENAME}.php -f
                RewriteRule ^(.*?)/?$ $1.php [L]   
            
                # Secure all directories - exempted directories must be ignored
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^([\/A-Za-z0-9][\/A-Za-z0-9-_\.]*?(^(.js))*?)$ index.php [NC,L]    
            
                # Secure and Re-Route resource folder php files only  
                RewriteRule ^(res/(.*\.php)?)$ index.php [NC,L]  
                RewriteRule ^(mi) index.php [NC,L]
                RewriteRule ^(composer\.json|composer\.lock) index.php [NC,L]
            
                # Ignore public folder and other file extensions
                RewriteRule ^(res)($|//) - [L]
                RewriteRule ^(\*\.!(php))($|//) - [L]
                
                # Secure specific core directories and its entire contents
                RewriteRule ^((core|icore|windows)(//.*?)?) index.php [NC,L]
            
                # Send all directories to the router file
                RewriteRule ^((//.*?)?([\/0-9a-zA-Z-_]*)?\.php) index.php [NC,L]   
            
                setEnv HTACCESS on
                setEnv LAUNCHER main
                setEnv ENVIRONMENT offline
              </IfModule>
              
              <IfModule headers.c>
                  
                  #Header add Access-Control-Allow-Origin: "*"
                  #Header add Access-Control-Allow-Methods: "GET,POST,OPTIONS,DELETE,PUT"
                  #Header add Access-Control-Allow-Headers: "Content-Type"
                  Header set X-Frame-Options "SAMEORIGIN"
                  Header set X-Content-Type-Options "nosniff"
                  Header set X-XSS-Protection "1; mode=block"
                  Header set X-Transport-Security "max-age=31536000; includeSubDomains; preload"
              
             </IfModule>
            HT;
      
    }

}