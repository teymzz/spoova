<?php

namespace spoova\mi\core\commands\Root\Make;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\FileManager;
use spoova\mi\core\classes\Url;

/**
 * This class is used for adding commands into specified commands directory
 */
class MkCommand extends MkBase{
    
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
        $url = new Url;
        $classSpace = $url->path($classSpace)->pathmod(fn($val) => ucfirst($val)); 
        
        /* class namespace starting from windows folder  */
        $routedSpace  = to_namespace('commands/'.$classSpace);
        
        /* class full namespace */
        $nameSpace = scheme($routedSpace, false);

        /* class relative window directory */
        $fileDir  = to_frontslash($routedSpace.'\\');
        
        /* class absolute file path */
        $fileLoc   = $fileDir.$className.'.php'; /* relative file path */

        /* window routes' absolute file path */
        $filePath  = to_dirslash(domroot($fileLoc));        
        
        Cli::textView(Cli::danger(Cli::emo('point-list').' add:command ').Cli::warn($nameSpace));
        Cli::break(2);

        if(count($args) > 3){
            Cli::textView(Cli::error('Expecting a maximum of three(3) arguments!'), 1);
            Cli::break(2);
            return false;
        }

        // Build Session File ...

        if(((count($args) == 3) && $lastArg != '-O') || ((strlen($lastArg) == 2) && ($lastArg[0] == '-') && $lastArg != "-O" )){
            Cli::textView(Cli::error('Unknown directive "'.$lastArg.'" supplied'), 1);
            Cli::break(2);
            return false;
        }

        $extend = to_frontslash(($arg2 != '-O') ? $arg2 : '', true);
        $use[] = scheme("core/commands/Consoler/Consoler");
        $use[] = scheme("core/commands/Root/Cli");

        //try validating class, extends name
        $pattern1 = '~[^\w\/]~';

        if(!$class) {
            $this->display(Cli::danger('Error:').' no commands name supplied!');
            $this->display('Syntax:'.Cli::btn('mi','1|1').'add:command '.Cli::color('<commandName>', 'yellow', 0), 2);
            return false;
        }
        
        if(
            preg_match($pattern1, $class, $matches) || 
            preg_match($pattern1, $extend, $matches)
        ){
            Cli::textView(Cli::danger('Error:').' some invalid characters detected!', 1).Cli::break(2);
            return false;
        }

        $extends = $extend? $extend : 'Consoler';

        $Filemanager = new FileManager;


        /* create class directory & class file */
        if(!is_file($filePath) || ($lastArg == '-O')){

            $rexName = strtolower($className); //set className for method...
            $tmpName = str_replace(['/','\\'], '.',strtolower($classDir.'/'.$className));

            //create class file if not exist, return false if not created                  
            if($Filemanager->openFile(true, $filePath)) {

                $rexName = strtolower($className); //set className for method...
                $tmpName = str_replace(['/','\\'], '.',strtolower($classDir.'/'.$className));
                
                $content = <<<CContent
                    
                    /**
                     * Set the maximum number of arguments allowed. The 
                     * default minimum is 4 arguments.
                     */
                    protected static int \$args_max = 7;
                
                    /**
                     * Set arguments and options allowed on this command
                     *
                     * @return array
                     */
                    public static function setOps() : array {

                        return [
                            'test' => 'test',
                
                            fn() => [
                                'test' => [
                                    'i' => 'this is a dummy description',
                                    'x' => Cli::warn('php mi').' '.Cli::alert('catd::push').' '.Cli::valid('test'),
                                ]
                            ]
                        ];
                
                    }

                    /**
                     * This is a default dummy test command
                     */
                    public static function test() {
                        
                        Cli::textView(Cli::alert('Hi there, spoova is awesome!'), 2, '|2');
                
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
                    
                    file_put_contents($filePath, $format);
                    
                    Cli::textView(Cli::success('command').Cli::alert($className, 1)." added successfully", 2, '|1');
                    Cli::break(1);
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow')).' run: "'.Cli::warn('mi cat::'.strtolower($className).' test').'" to test command', 3);
                    Cli::break(2);

                    return true;
    
                } else {
                    Cli::textView('command'.Cli::alert($className, 1)." creation failed to create in ".Cli::danger($nameSpace));
                    Cli::break(2);                
                }
    
            } else {
                Cli::textView(Cli::error('cannot access directory', 1)." ".Cli::danger($nameSpace));
                Cli::break(2); 
            }

        } else {
            Cli::textView(Cli::error('namespace', 1).Cli::warn($nameSpace.'\\'.$className, 1).' | file already exists');
            Cli::break(2);  
            
            Cli::textView('Try using: '.Cli::btn('mi').Cli::warn('add:route '.trim($arg1.' '.$arg2.'-O'), 1).' | to overwrite file', 1);
            
            Cli::break(2);  
        }

        return false;

    }

}