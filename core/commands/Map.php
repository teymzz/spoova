<?php

/**
 * @package core/commands
 * @author Akinola Saheed <teymss@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 *  This may cause app to break or lead to other undesired errors.
 */
namespace spoova\core\commands;

use spoova\core\classes\FileManager;

class Map extends Entry{

    private $recompile;

    private $mapped = false;

    /**
     * array of arguments
     *
     * @param array $args
     */
    function __construct($args = [], $disp = true) {
 
        if(!$this->validate_arguments($args)) return;

        $fol = $args? $args[0] : trim(fol, '/ ');

        //format htaccess
        if(is_file(domroot().".htaccess")){

            $fdomroot = $args? dirname(domroot()).'/'.$args[0].'/' : $fol;
            
            //current file 404 settings
            $curDocText = $this->fetch404($fdomroot, $htaccess);

            //expected file 404 settings
            $errDocText  = $this->errorDocText($curDocText, $fol);

            if($errDocText){
                if($errDocText != $curDocText){
                    if($disp) $this->display('mapping project ...');

                    $htaccess = str_replace($curDocText, $errDocText, $htaccess);

                    $fp = fopen($fdomroot.'.htaccess', 'w');
                    fwrite($fp, $htaccess);
                    fclose($fp);

                    //try checking htaccess again
                    $curDocText = $this->fetch404($fdomroot, $htaccess);

                    if($curDocText == $errDocText){

                        $this->mapped = true;
                        $this->display($fol.' mapped successfully');

                    }else{

                        $this->mapped = false;   
                        
                        return;

                    }

                    if(!$args){
                        if(!server){
                            $this->display($fol.' >> '.'http://localhost/'.$fol.PHP_EOL);
                        }else{
                            $this->display($fol.' >> '.server.PHP_EOL);
                        }                    
                    }

                }
            }

        } else { 

            $this->addError('no htaccess file found!');

        }

    }

    /**
     * Fetch htaccess data
     *
     * @param string $dir directory of htaccess file
     * @param string $htaccess referenced variable for htaccess content
     * @return string
     */
    private function fetch404($dir, &$htaccess = ''){
        $htaccess = file_get_contents($dir.".htaccess");
        preg_match("@ErrorDocument[\s]+?404[\s]+\/[a-zA-Z-_/0-9.]+@", $htaccess, $matches);
        return setVar($matches[0]);
    }

    //get error document text
    private function errorDocText($matchesText, $fol) : string{
        $matches = str_replace("ErrorDocument 404","", trim($matchesText, " "));   
            
        $pathExp = explode("/", ltrim($matches,"/ "), 2); 
        if(isset($pathExp[1])){
            $path = $pathExp[1];
            
            if(online){
                $errDocText = 'ErrorDocument 404 /res/404.php'.$path;
            }else{
                $errDocText = 'ErrorDocument 404 /'.$fol.'/res/404.php';
            }
            return $errDocText;
        }
        return '';
    }

    private function validate_arguments($args){

        if(count($args) > 1) {

             $this->addError('invalid arguments count');
            return;
           
        }



        return true;
    }

}