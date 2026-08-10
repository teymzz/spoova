<?php

namespace spoova\mi\core\functions;

use Closure;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class Functions
{

    /**
     * Load a function's file using supplied file path only if the $path argument is supplied.
     * 
     * @param string $path path of the function's file without PHP extension name
     * 
     * @return void
     */
    function __construct(?string $path = null)
    {
       if($path){
            self::load(to_dirslash('functions/'.$path));
       }
    }

    /**
     * Autoloads all files from the "functions/autoload" reserved 
     * directory
     *
     * @return void
     */
    static function autoload() : void
    {
        if(is_dir('functions/autoload')){
        
            $Filemanager = new Filemanager;
            
            $Filemanager->source('functions/autoload');
    
            $files = $Filemanager->getFiles();
    
            foreach($files as $file){
                include_once($file);
            }

        }
    }

    /**
     * Load a function's file using supplied file path.
     *
     * @param string $path path of the function's file without PHP extension name
     * @return void
     */
    static function load(string $path) : bool
    {
        $file = to_dirslash($path.'.php');
        if(is_file($file)){
            include_once($file);
            new Functions();
            return to_namespace($path);
        }
        return false;
    }

    /**
     * Determines if the path of a function supplied exists in the "autoload" directory.
     *
     * @param string $path
     * @return string|false
     *  - a full namespace of $path is returned if the function path is callable while FALSE is returned if the function path is not callable.
     */
    static function autoloaded(string $path) : string|false
    {

        $function = @scheme('functions/autoload/'.$path);
        if(is_callable($function)){
            return $function;
        }
        return false;
    }

    /**
     * Returns spoova equivalent namespace structure for the supplied file path
     *
     * @param string $path file path of functions file without its PHP extension name 
     * @return string
     */
    static function main(string $path) : string
    {
        return @scheme($path);
    }

    /** 
     * Return path from functions directory
     *
     * @param string $path
     * @return string
     */
    static function root($path) : string
    {
        return @scheme('functions/'.$path);
    }

    /**
     * Return the functions in a specified function's file
     *
     * @param string $path path of function's file without PHP extension name.
     * @param Closure $callback if supplied will be applied on all retured function names.
     * 
     * @return array|false
     *  - FALSE is returned only if the file does not exist.
     */
    static function functions(string $path, ?Closure $callback = null) : array|false {

        $phpFile = to_dirslash($path).'.php';
        if(is_file($phpFile)){
            $contents = file_get_contents($phpFile);
            $tokens = token_get_all($contents);
            
            foreach($tokens as $key => $token){
                if(is_array($token) && $token[0] === T_FUNCTION){
                    $function = $tokens[$key + 2][1];
                    $functions[] = $callback? $callback(new FunctionsList($path, $function)) : $function;
                }
            }

            return $functions ?? [];

        }

        return false;

    }

}
