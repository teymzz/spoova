<?php

namespace spoova\core\commands\Make;

use spoova\core\commands\Cli;
use spoova\core\classes\FileManager;

/**
 * This class is an alias for MKWinRoute
 */
class MkRoute extends MkBase{
    
    public function build() : bool{
        
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

        /* class subnamespace in Routes if subnamespace exists */
        $classSpace = to_namespace($classDir); 
        
        /* class namespace starting from windows folder  */
        $routedSpace  = to_namespace(WIN_ROUTES.$classSpace);
        
        /* class full namespace */
        $nameSpace = scheme($routedSpace, false);

        /* class relative window directory */
        $fileDir  = to_frontslash($routedSpace.'\\');
        
        /* class absolute file path */
        $fileLoc   = $fileDir.$className.'.php'; /* relative file path */

        /* window routes' absolute file path */
        $filePath  = domroot($fileLoc);        
        
        Cli::textView(Cli::danger(Cli::emo('point-list').' add:routes ').Cli::warn($fileLoc));
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

        //try validating class, extends name
        $pattern1 = '~[^\w\/]~';

        if(!$class) {
            $this->display(Cli::danger('Error:').' no route name supplied!');
            $this->display('Syntax:'.Cli::btn('mi','add:route', '','', '').Cli::color('<className> [frame?]', 'yellow', 0), 2);
            return false;
        }
        
        if(
            preg_match($pattern1, $class, $matches) || 
            preg_match($pattern1, $extend, $matches)
        ){
            Cli::textView(Cli::danger('Error:').' some invalid characters detected!', 1).Cli::break(2);
            return false;
        }

        if($extend) $use = scheme(WIN_FRAMES.$extend, false);

        $extends = $extend? $extend : 'Window';

        $Filemanager = new FileManager;

        /* create class directory & class file */
        if(!is_file($filePath) || ($lastArg == '-O')){
            
            if($Filemanager->openFile(true, $filePath)) {
    
                $content = <<<CContent
                
                    public function __construct(){
    
                        self::call(\$this,
                            [
                                window('root') => 'root'
                            ]
                        );
    
                    }
    
                    function root() {
    
                        //self::load('index', fn() => compile() );
                        
                    }
    
                    /**
                     * Add name of routes
                     *
                     * @return void
                     */
                    public static function addRoutes(array \$array = []) : array {
    
                        return [
                            // 'routeName' => 'routePath'
                        ];
    
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
                    
                    Cli::textView('class'.Cli::alert($className, 1)." created successfully in ".Cli::warn($fileLoc));
                    Cli::break(2);

                    return true;
    
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
            
            Cli::textView('Try using: '.Cli::btn('mi').Cli::warn('add:route '.$arg1.' '.$arg2.' -O', 1).' | to overwrite file', 1);
            
            Cli::break(2);  
        }

        return false;

    }

}