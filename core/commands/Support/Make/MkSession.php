<?php

namespace spoova\mi\core\commands\Support\Make;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Url;

/**
 * This class is an alias for MKWinRoute
 */
class MkSession extends MkBase{
    
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
        $routedSpace  = to_namespace(WIN.'Sessions'.$classSpace);
        
        /* class full namespace */
        $nameSpace = scheme($routedSpace, false);

        /* class relative window directory */
        $fileDir  = to_frontslash($routedSpace.'\\');
        
        /* class absolute file path */
        $fileLoc   = $fileDir.$className.'.php'; /* relative file path */

        /* window routes' absolute file path */
        $filePath  = to_dirslash(domroot($fileLoc));        
        
        Cli::textView(Cli::danger(Cli::emo('point-list').' add:session ').Cli::warn($fileLoc));
        Cli::break(2);

        if(count($args) > 3){
            Cli::textView(Cli::error('Expecting a maximum of three(3) arguments!'), '1');
            Cli::smartBreak(2);
            return false;
        }

        $response = Cli::q('', function() use(&$value) {

            return [

                'init' => function() {
                    Cli::textView(Cli::alert('Please enter your session and cookie name'), '2', '|1');
                    
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow').' ', '2'));
                },

                'test' => function($input) {

                    $response = explode(' ', $input, 2);

                    $sessionName = trim($response[0] ?? '');
                    $cookieName = trim($response[0] ?? '');

                    if(!$sessionName && $cookieName) return false;

                    if($sessionName) return true;

                    return false;
                },

                'success' => function($input) use(&$value) {
                    
                    $response = explode(' ', $input, 2);

                    $sessionName = trim($response[0] ?? '');
                    $cookieName = trim($response[1] ?? '');

                    $value = [$sessionName, $cookieName];

                    Cli::textView(Cli::success('session name "'.$sessionName.'" declared successfully'), '2' , 1);

                    if($cookieName){
                        Cli::textView(
                            Cli::success('cookie name "'.$cookieName.'" declared successfully'), 2, '1|2'
                        );
                    }

                }, 

                'failed' => function($input, $options, $counter) {
                    Cli::clearUp(1);
                    Cli::textView(Cli::danger(Cli::emo('ribbon-arrow')).' '.Cli::error('invalid session or cookie name supplied'), '2', '|2');
                    return true;
                },

                'maximum' => function() {
                    Cli::clearUp(1);
                    Cli::textView( Cli::danger(Cli::emo('ribbon-arrow')).' '.Cli::error('maximum reached!') , '2', '|2');
                }

            ];

        }, 3);

        if(!isset($value)) return false;
        $sessionName = $value[0] ?? '';
        $cookieName = $value[1] ?? '';
        // Build Session File ...

        if(((count($args) == 3) && $lastArg != '-O') || ((strlen($lastArg) == 2) && ($lastArg[0] == '-') && $lastArg != "-O" )){
            Cli::textView(Cli::error('Unknown directive "'.$lastArg.'" supplied'), '1');
            Cli::smartBreak(2);
            return false;
        }

        $extend = to_frontslash(($arg2 != '-O') ? $arg2 : '', true);
        $use[] = "Window";

        //try validating class, extends name
        $pattern1 = '~[^\w\/]~';

        if(!$class) {
            $this->display(Cli::danger('Error:').' no session name supplied!');
            $this->display('Syntax:'.Cli::btn('mi','add:session').Cli::color('<className>', 'yellow'), 2);
            return false;
        }
        
        if(
            preg_match($pattern1, $class, $matches) || 
            preg_match($pattern1, $extend, $matches)
        ){
            Cli::textView(Cli::danger('Error:').' some invalid characters detected!', '1').Cli::break(2);
            return false;
        }

        if($extend) $use[0] = scheme(WIN_FRAMES.$extend, false);
        $use[] = 'Session';

        $extends = $extend? $extend : 'Window';

        $Filemanager = new Filemanager;


        /* create class directory & class file */
        if(!is_file($filePath) || ($lastArg == '-O')){

            $rexName = strtolower($className); //set className for method...
            $tmpName = str_replace(['/','\\'], '.',strtolower($classDir.'/'.$className));

            //create class file if not exist, return false if not created                  
            if($Filemanager->openFile(true, $filePath)) {

                $rexName = strtolower($className); //set className for method...
                $tmpName = str_replace(['/','\\'], '.',strtolower($classDir.'/'.$className));
                
                $content = <<<CContent
                
                    public static function frame(){
    
                        new Session('$sessionName', '$cookieName');
    
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
                    
                    Cli::textView('class'.Cli::alert($className, '1')." created successfully in ".Cli::warn($fileLoc));
                    Cli::smartBreak(2);

                    return true;
    
                } else {
                    Cli::textView('class'.Cli::alert($className, '1')." creation failed to create in ".Cli::danger($nameSpace));
                    Cli::smartBreak(2);                
                }
    
            } else {
                Cli::textView(Cli::error('cannot access directory', 1)." ".Cli::danger($nameSpace));
                Cli::smartBreak(2); 
            }

        } else {
            Cli::textView(Cli::error('namespace', 1).Cli::warn($nameSpace.'\\'.$className, '1').' | file already exists');
            Cli::smartBreak(2);  
            
            Cli::textView('Try using: '.Cli::btn('mi').Cli::warn('add:route '.trim($arg1.' '.$arg2.'-O'), '1').' | to overwrite file', '1');
            Cli::smartBreak(2);  
        }

        return false;

    }

}