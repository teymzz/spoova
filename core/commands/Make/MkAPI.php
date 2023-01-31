<?php

namespace spoova\core\commands\Make;

use ErrorHandler;
use spoova\core\classes\FileManager;
use spoova\core\commands\Cli;

/**
 * This class is an alias for MKWinRoute
 */
class MkAPI extends MkBase{

    public function build() : bool{

        /* Syntax: add:api <name> [\subdir] [-O]*/
        /* Syntax: add:api <name> [\subdir?] [extends:s?] [-O]*/
        
        /* Syntax: add:api <name> | Add api */
        /* Syntax: add:api <name> [-O] | Add api overwrite */

        /* Syntax: add:api <name> [extends] | Add api extends frame  */
        /* Syntax: add:api <name> [extends:s] | Add api extends frame (session format)*/
        
        /* Syntax: add:api <name> [\subdir] | Add api use subdirectory */
        
        /* Syntax: add:api <name> [extends] [-O] | Add api extends frame overwrite  */
        /* Syntax: add:api <name> [extends:s] [-O] | Add api extends frame (session format) overwrite*/
        /* Syntax: add:api <name> [\subdir] [-O] | Add api use subdirectory overwrite all*/
        /* Syntax: add:api <name> [extends] [\subdir] | Add api extends frame, use subdirectory*/
        /* Syntax: add:api <name> [extends] [\subdir] | Add api extends frame, use subdirectory*/
        /* Syntax: add:api <name> [extends:s] [\subdir] | Add api extends frame (session format), use subdirectory*/
        /* Syntax: add:api <name> [extends:s] [\subdir] | Add api extends frame (session format), use subdirectory*/
        
        /* Syntax: add:api <name> [extends:s] [\subdir] [-O] | Add api extends frame, use subdirectory overwrite all*/
        /* Syntax: add:api <name> [extends:s] [\subdir] [-O] | Add api extends frame, use subdirectory overwrite all*/
        /* Syntax: add:api <name> [extends:s] [\subdir] [-O] | Add api extends frame (session format), use subdirectory overwrite all*/
        /* Syntax: add:api <name> [extends:s] [\subdir] [-O] | Add api extends frame (session format), use subdirectory overwrite all*/
        
        /* Note: Subdirectory is preceeded by a slash or dot while extends is not.*/

        /* FootNote1: only when extends has slash before, it is regarded as subdir*/
        /* FootNote1: only when extends has :s, it uses session extension*/
        /* FootNote1: only when -O is supplied, overwrite comes to effect. */
        
        $args = static::$args;

        $arg1 = $args[0] ?? '';
        $arg2 = $args[1] ?? '';
        $arg3 = $args[2] ?? '';
        $arg4 = $args[3] ?? '';
        
        $lastArg = $args[count($args) - 1] ?? '';

        $argscount = count($args);

        $class = $arg1;
        $className = to_frontslash(ucfirst($class), true);

        if(!$class) {

            self::addTitle('add:api');
            Cli::textView(Cli::color('File Error:', 'red').' no api class name supplied!', 2);
            Cli::break();
            $this->display('Syntax: '.Cli::btn('mi').' '.Cli::alert('add:api').Cli::warn('<apiName>'.Cli::color('<extends?>', 'purple', 1).Cli::color('<subdir?>', 'green', 1).Cli::danger('[-O?]', 1), 1), 2);                                                         
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::warn('<apiName>').' | name of API class to be created.', 3);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::color('<extends?>', 'purple').' | optional: extended Frame class path in "'.WIN_FRAMES.'" directory.', 3);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::color('<\subdir?>', 'green').' | optional: "'.WIN.'" subdirectory.', 3);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::danger('[-O]').' | optional: overwrite existing file', 3);

            return false;
        }

        if($argscount > 4){

            self::addTitle('add:api');
            Cli::textView(Cli::error('Expecting a maximum of four(4) arguments!'), 1);
            Cli::break(2);
            return false;

        }


        $extends = '';
        $subdir = '';
        $overwrite = '';
        $format = '';

        /* set directive values based on structure supplied */
        if($argscount === 4){
            $class = $arg1;
            $extends = $arg2;
            $subdir = $arg3;
            $overwrite = $arg4;
        }elseif($argscount === 3) {

            /* last argument can either be -O or subdir */
            /* second argument can either be extends or subdir */

            if(self::isMinus($lastArg)){
                $overwrite = $lastArg;
                //get first argument
                if(self::isSubDir($arg2)){
                    $subdir = $arg2;
                }else{
                    $extends = $arg2;
                }
            }else{
                if(self::isMinus($lastArg)){
                    $subdir = $arg2;
                }else{
                    $extends = $arg2;
                    $subdir = $arg3;
                }
            }

        }  elseif($argscount === 2) {

            if(self::isMinus($lastArg)){
                $overwrite = $lastArg;
            }elseif(self::isSubDir($lastArg)){
                $subdir = $lastArg;
            }else{
                $extends = $lastArg;
            }

        }
        
        #validate subsequent arguments
        $ePattern = '~[^\w\/]~'; //likely accepted class pattern

        if(preg_match($ePattern, to_backslash($class))){
            //Note:: validate class to avoid slashes
            self::addTitle('add:api');
            Cli::textView(Cli::danger('Error:').' Invalid API name "'.Cli::warn($className).'" supplied', 1).Cli::break(2);
            return false;

        }

        if($extends) {

            $extendsKey = $extends; 

            $extend = ltrim(to_frontslash($extends, true), '/');
            $extend = explode(':', $extend);
            $format = $extend[1]?? '';
            $extends = $extend[0];

            if($format){
                if($format !== 's'){
                    self::addTitle('add:api');
                    Cli::textView(Cli::danger('Error:').' Invalid directive format "'.Cli::warn($format).'" supplied on extends "'.Cli::warn($extendsKey).'"', 1).Cli::break(2);
                    return false;
                }
            }

            //validate extends (class must use forward slash)
            if(preg_match($ePattern, $extends, $matches)){
                self::addTitle('add:api');
                Cli::textView(Cli::danger('Error:').' Invalid extends format "'.Cli::warn($className).'" supplied', 1).Cli::break(2);
                return false;
            }

        }

        if($subdir){

            $subdir = ltrim(to_frontslash($subdir, true), '/');

            if(!$subdir || preg_match($ePattern, $subdir)){
                //prevent single slashes or dot
                self::addTitle('add:api');
                Cli::textView(Cli::danger('Error:').' Invalid api subpath name "'.Cli::warn($subdir).'" supplied', 1).Cli::break(2);
                return false;
                
            }

        }

        if($overwrite && ($overwrite != '-O')){

            self::addTitle('add:api');
            Cli::textView(Cli::error('Unknown directive "'.Cli::warn($overwrite).'" supplied'), 1);
            Cli::break(2);
            return false;       

        }

        /* proceed with file creation */

        /* set extends */
        $extends = ltrim(to_backslash($extends), '\\');
        //$extends = basename($extends);

        $use = ($extends)? scheme(WIN_FRAMES.$extends, false) : 'Window';

        $extends = ($extends)?: 'Window';

        /* Note:: all space variables have no trail slash */

        /* class subnamespace in window\ if subnamespace exists */
        $classSpace = ''; 
        
        /* class namespace starting from windows folder  */
        $winSpace  = to_namespace(WIN_ROUTES.$classSpace);
        
        /* class full folder namespace */
        $nameSpace = scheme($winSpace, false);
        
        /* class full namespace */
        $fileNameSpace = $nameSpace.'\\'.$className;

        /* class relative window directory */
        $fileDir  = to_frontslash($winSpace.'\\');
        
        /* class absolute file path */
        $fileLoc  = $fileDir.$className.'.php'; /* relative file path */

        /* route api absolute base file path */
        $filePath = to_backslash(domroot($fileLoc)); 

        /* route api absolute folder path */
        $routeDir = to_backslash(domroot(WIN_ROUTES)); 

        /* route subapi absolute folder path (if supplied)*/
        $subrouteDir = $routeDir.to_backslash($subdir);

        /* freformat subdir to be subpath only of it contains a path structure */
        if(strpos($subdir, '/') !== false){
            $subdir = dirname($subdir);
            $handlerClass = ucfirst(basename($subrouteDir));
            $subrouteDir = dirname($subrouteDir);
        } else{
            # Set api subclass name
            $handlerClass = (strtolower($class) === 'api')? $class : $class.'API';
        }

        $APIFile = $subrouteDir.'\\'.$handlerClass.'.php';

        # Set api subdirectory if added
        $subdir = to_frontslash($subdir);

        # Set api subdirectory namespace if added
        $subnamespace = $subdir? '\\'.to_backslash($subdir) : $subdir;

        $subnamespace = scheme(WIN_ROUTES.ltrim($subnamespace,'\\'), false);

        # Set api subclass file namespace
        $subfilespace = $subnamespace.'\\'.$handlerClass;

        //print_r($subnamespace.br());

        if((strtolower($handlerClass) == 'api')){
            $asRootAPI = ' as RootAPI';
            $rootAPI = 'RootAPI';
        }else{
            $asRootAPI = '';
            $rootAPI = $handlerClass;
        }

        $content1 = <<<CONTENT1

            public static \$winAPI = 'ajax:json';

            public function __construct(){

                //initialize a call effect ...

                self::call(\$this,
                    [
                       // window('root') => 'root',
                    ]
                );

            }

            function root() {

                // self::load('index', fn() => compile());
                
            }

        CONTENT1;

        /* ...content for subAPI */
        $content2 = <<<CONTENT2

            public static \$winAPI = 'ajax:json';

            public function __construct(){

                //initialize API Handler Class...
                new $rootAPI();

            }            

        CONTENT2;

        /* set content based on arguments */
        self::addTitle('add:api');

        if($subdir) {

            $contentAPI = self::classFormat([
                'class' => $class,
                'namespace' => scheme(WIN_ROUTES, false),
                'use' => [$use, $subfilespace.$asRootAPI],
                'extends' => basename($extends),
                'methods' => $content2
            ]);

            $contentSubAPI = self::classFormat([
                'class' => $handlerClass,
                'namespace' => $subnamespace,
                'use' => $use,
                'extends' => basename($extends),
                'methods' => $content1
            ]);
            
        } else {

            $contentAPI = self::classFormat([
                'class' => $class,
                'namespace' => $nameSpace,
                'use' => $use,
                'extends' => basename($extends),
                'methods' => $content1
            ]);

        }

        $Filemanager = new FileManager;

        if($Filemanager->openFile(true, $routeDir)) {


            if(is_file($filePath) && !$overwrite){
               $this->display(Cli::color("NOTICE:", 'red').' Route file "'.$class.'" already exists!');
               return false;
            }

            if($Filemanager->openFile(true, $filePath)) {
                
                $file = fopen($filePath, 'w');
                fputs($file, $contentAPI);
                fclose($file);

                $class = ucfirst($class);

                $this->display(Cli::alert('NOTICE:').(' API Route "'.Cli::alert($class).'" created successfully in '.Cli::warn("windows\Routes\\$class.php")));

                if($subdir){
                    
                    if($Filemanager->addDir($subrouteDir)) {
                         $this->display(Cli::notice(' directory '.Cli::alert(ltrim(WIN_ROUTES.to_backslash($subdir),'/ ')).' was added'.Cli::valid('successfully'.Cli::emo('checkmark',1), 1)));     
                         
                         //create a new file and add contents
                         if($Filemanager->openFile(true,  $APIFile)){

                              $this->display(Cli::notice(' API Handler file '.Cli::alert(ltrim(WIN_ROUTES.to_backslash($subdir),'/ '))."\\".Cli::alert(ltrim(ucfirst($handlerClass),'/ ')).' was added'.Cli::valid('successfully'.Cli::emo('checkmark',1), 1)));     
                              $file = fopen($APIFile, 'w');
                              fputs($file, $contentSubAPI);
                              fclose($file);    
                              
                              if(!class_exists($fileNameSpace)){

                                  $eResponse =
                                  Cli::textIndent(Cli::danger("WARNING!!!")." File created was detected to have some problems").
                                  Cli::break(2, false).
                                  Cli::textIndent(Cli::warn(Cli::emo('eye').' Debug: ', 1).('Check that extended frame class "'.Cli::warn($extends).'" truly exists.')).
                                  Cli::break(2, false);
                                
                                  //set a response message before shutdown
                                  ErrorHandler::cliMessage($eResponse);
                                  
                              }

                         }
                         
                    }else{
                         $this->display(Cli::color('NOTICE:', 'red').' directory'.Cli::color(ltrim(WIN_ROUTES.to_backslash($subdir),'/ '),'blue').' failed to create');     
                         return false;
                    }

                }                
                return true;

            }


        } else {                                                  
            Cli::textView(Cli::error('cannot access directory', 1)." ".Cli::danger($nameSpace));
            Cli::break(2); 
        }

    }

    private function isSubDir($val) {
       return ((substr($val, 0, 1) == '.') || (substr($val, 0, 1) == '\\'));
    }

    private function isMinus($val) {
       return (substr($val, 0, 1) == '-');
    }

}