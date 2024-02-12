<?php

namespace spoova\mi\core\commands\Root\Make;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\FileManager;

class MkModel extends MkBase{

    public function build() : bool{

        /* Syntax: mi add:winModel <path.?><modelName> -O */

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
        $modelledSpace  = to_namespace(WIN_MODELS.$classSpace);
        
        /* class full folder namespace */
        $nameSpace = scheme($modelledSpace, false);
        
        /* class full namespace */
        $fileNameSpace = $nameSpace.'\\'.$className;

        /* class relative window directory */
        $fileDir  = to_frontslash($modelledSpace.'\\');
        
        /* class absolute file path */
        $fileLoc  = $fileDir.$className.'.php'; /* relative file path */

        /* window models' absolute file path */
        $filePath = domroot($fileLoc);        

        Cli::textView(Cli::danger(Cli::emo('point-list').' add:winmodel ').Cli::warn($fileLoc));
        Cli::break(2);

        if(count($args) > 2){
            Cli::textView(Cli::error('Expecting a maximum of two(2) arguments!'), 1);
            Cli::break(2);
            return false;
        }

        if(((count($args) == 2) && $lastArg != '-O') || ((strlen($lastArg) == 2) && ($lastArg[0] == '-') && $lastArg != "-O" )){
            Cli::textView(Cli::error('Unknown directive "'.$lastArg.'" supplied'), 1);
            Cli::break(2);
            return false;
        }

        $ePattern = '~[^\w\/]~';

        if(
            preg_match($ePattern, $class, $matches) 
        ){
            Cli::textView(Cli::danger('Error:').' some invalid characters detected!', 1).Cli::break(2);
            return false;
        }

        if(!$class) {
            Cli::textView(Cli::color('Error:', 'red').' no model name supplied!');
            Cli::break();
            $this->display('Syntax: '.Cli::btn('mi').' '.Cli::alert('add:winmodel', '','', '').Cli::warn('<path?><modelName>'.Cli::danger('[-O?]', 1), 1), 2);
            return false;
        }

        $use = scheme('core/classes/Model', false);
        $extends = "Model";

        $Filemanager = new FileManager;
        
        /* create class directory & class file */
        if(!is_file($filePath) || ($lastArg == '-O')){

            if($Filemanager->openFile(true, $filePath)) {

                /* create a new model file */

                $content = <<<CContent

                    public function __construct(){

                        //your code here...

                    }

                    /**
                     * Validation rules
                     *
                     * @return array
                     */
                    public function rules(): array {

                        return [];

                    }

                    /**
                     * set table name where data is inserted
                     *
                     * @return string
                     */
                    public static function tablename(): string {

                        //default table name
                        return \User::config('USER_TABLE');
                
                    }

                    /**
                     * input fields with relative database column name key pairs 
                     *
                     * @return string
                     */
                    public static function mapform(): array {

                        return [];
                
                    }

                CContent;

                $format = self::classFormat([
                    'namespace' => $nameSpace, 
                    'class'     => $className, 
                    'use'       => $use, 
                    'extends'   => basename($extends),
                    'methods'   => $content
                ]);

                /* re-check if file exists */
                if($Filemanager->openFile(true, $filePath)) {
                    
                    $file = fopen($filePath, 'w');
                    fputs($file, $format);
                    fclose($file);

                    sleep(1);

                    if(@appExists($modelledSpace.'\\'.$className)) {
                        Cli::textView('class'.Cli::alert($className, 1)." created successfully in ".Cli::warn($fileLoc));
                        Cli::break(2);
                        return true;
                    } else {
                        print br(appExists($fileNameSpace));
                        print br($fileNameSpace);
                        Cli::textView('class'.Cli::alert($className, 1)." creation failed to create in ".Cli::danger($nameSpace));
                        Cli::break(2);   
                    }
    
                } else {
                    Cli::textView('class'.Cli::alert($className, 1)." creation failed to create in ".Cli::danger($nameSpace));
                    Cli::break(2);                
                }
    
            } else {
                Cli::textView(Cli::error('cannot access directory', 1)." ".Cli::danger($nameSpace));
                Cli::break(2); 
            }

        } else { 

            Cli::textView(Cli::error('namespace', 1).Cli::warn($nameSpace.'\\'.$className, 1).' | file already exists');
            Cli::break(2);  
            
            Cli::textView('Try using: '.Cli::btn('mi').Cli::warn('add:model '.$arg1.' -O', 1).' | to overwrite file', 1);
            
            Cli::break(2);  

        }

        return false;

    }

}