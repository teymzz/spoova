<?php

namespace spoova\mi\core\commands\Root\Make;

use ErrorHandler;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\FileManager;

class MkWindow extends MkBase{

    public function build() : bool{

        /* Syntax: mi add:window <path?><windowName> <extends?> -O */
        
        $args = static::$args;

        $arg1 = $args[0] ?? '';
        $arg2 = $args[1] ?? '';
        
        $lastArg = $args[count($args) - 1] ?? '';
        
        $class = $arg1;
        $class = ltrim(to_frontslash($class, true), '/');
        $class = to_frontslash($class, true);
        $classDir  = dirname($class);
        $classDir  = ($classDir == '.')? '' : $classDir;
        $className = ucfirst(basename($class));


        /* Note:: all space variables have no trail slash */

        /* class subnamespace in window\Models if subnamespace exists */
        $classSpace = to_namespace($classDir); 
        
        /* class namespace starting from windows folder  */
        $modelledSpace  = to_namespace(WIN.$classSpace);
        
        /* class full folder namespace */
        $nameSpace = scheme($modelledSpace, false);
        
        /* class full namespace */
        $fileNameSpace = $nameSpace.'\\'.$className;

        /* class relative window directory */
        $fileDir  = to_frontslash($modelledSpace.'\\');
        
        /* class absolute file path */
        $fileLoc  = $fileDir.$className.'.php'; /* relative file path */

        /* window absolute file path */
        $filePath = domroot($fileLoc);        

        Cli::textView(Cli::danger(Cli::emo('point-list').' add:window ').Cli::warn($fileLoc));
        Cli::break(2);
        
        if(count($args) > 3){
            Cli::textView(Cli::error('Expecting a maximum of three(3) arguments!'), 1);
            Cli::break(2);
            return false;
        }

        if(((count($args) == 3) && $lastArg != '-O') || ((strlen($lastArg) == 2) && ($lastArg[0] == '-') && $lastArg != "-O" )){
            Cli::textView(Cli::error('Unknown directive "'.$lastArg.'" supplied'), 1);
            Cli::break(2);
            return false;
        }

        $extend = to_frontslash(($arg2 != '-O') ? $arg2 : '', true);

        $use = "Window";

        /* try validating class */
        $ePattern = '~[^\w\/]~';
        if(
            preg_match($ePattern, $class, $matches) || 
            preg_match($ePattern, $extend, $matches) 
        ){
            Cli::textView(Cli::danger('Error:').' some invalid characters detected!', 1).Cli::break(2);
            return false;
        }

        if(!$class) {
            Cli::textView(Cli::color('File Error:', 'red').' no window name supplied!', 2);
            Cli::break();
            $this->display('Syntax: '.Cli::btn('mi').' '.Cli::alert('add:window').Cli::warn('<dir?><windowName>'.Cli::color('<extends?>', 'purple', 1).Cli::danger('[-O?]', 1), 1), 2);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::warn('<dir?>').' | optional subdirectory of windows folder.', 3);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::warn('<windowName>').' | name of Window to be created.', 3);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::color('<extends?>', 'purple').' | optional extended Frame class path within Windows\Frames folder.', 3);
            $this->display(Cli::emos('ribbon-arrow', 1).Cli::danger('[-O]').' | overwrite existing file', 3);
            $this->display(Cli::notice('Subdirectory supports the use of dot or slashes'),3);

            return false;
        }

        if($extend) $use = scheme(WIN_FRAMES.$extend, false);

        $extends = $extend? $extend : 'Window';
        
        /* create class directory & class file */
        if(!is_file($filePath) || ($lastArg == '-O')){
            
            $Filemanager = new FileManager;

            if($Filemanager->openFile(true, $filePath)) {

                /* create a new frame file */

                $content = <<<Frame

                    public function __construct(){

                        //your code here...

                    }

                Frame;
    
                $format = self::classFormat([
                    'namespace' => $nameSpace, 
                    'class'     => $className, 
                    'use'       => $use, 
                    'extends'   => basename($extends),
                    'methods'   => $content
                ]);

                if($Filemanager->openFile(true, $filePath)) {
                    
                    $file = fopen($filePath, 'w');
                    fputs($file, $format);
                    fclose($file);

                    sleep(2);

                    $eResponse =
                    
                        Cli::textIndent(Cli::danger("WARNING!!!")." File created was detected to have some problems").
                        Cli::break(2, false).
                        Cli::textIndent(Cli::warn(Cli::emo('eye').' Debug: ', 1).('Check that extended frame class "'.Cli::warn($extends).'" truly exists.')).
                        Cli::break(2, false);
                
                    
                    //set a response message before shutdown
                    ErrorHandler::cliMessage($eResponse);

                    if(appExists($modelledSpace.'\\'.$className)) {
                        $class = $fileNameSpace;

                        Cli::textView(Cli::success('window').Cli::alert($className, 1)." created successfully in ".Cli::warn($fileLoc));
                        Cli::break(2);

                        new $class;
                        return true;

                    } else {
                        Cli::textView('window'.Cli::alert($className, 1)." creation failed to create in ".Cli::danger($nameSpace));
                        Cli::break(2);  
                        return false; 
                    }
                }

            } else {
                Cli::textView(Cli::error('cannot access directory', 1)." ".Cli::danger($nameSpace));
                Cli::break(2); 
            }

        } else {
            Cli::textView(Cli::error('namespace', 1).Cli::warn($nameSpace.'\\'.$className, 1).' | file already exists');
            Cli::break(2);  
            
            Cli::textView('Try using: '.Cli::btn('mi').Cli::warn('add:route '.$arg1.' '.$arg2.' -O', 1).' | to overwrite file', 1);
            Cli::break(2);  
        }

        return false;

    }

}