<?php

namespace spoova\mi\core\classes\Res;

use Res;
use Closure;
use spoova\mi\core\classes\Res\Resin;
use spoova\mi\core\classes\Compiler;

/**
 * This class is created for 
 * handling Res Class Template methods
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
final class Rex extends Resx implements Resin{

    public static function load(string $url, Closure|False $callback = false){
        
        print self::engine(...func_get_args());

    }
    
    /**
     * Get raw data of rendered rex file
     * 
     * @param string $url url of markup
     * @param Closure|false $callback call back function for markup
     *
     * @return string
     */
    public static function markup(string $url, Closure|False $callback = false) : String {

        return (string) self::compile(...func_get_args());

    }

    /**
     * Rex compiler function
     *
     * @param string|null $url
     * @param Closure|False $callback
     * @return Compiler|String|False
     */
    public static function compile(string $url, Closure|False $callback = false) : Compiler|String|False {

       return self::engine(...func_get_args());
    
    }

    /**
     * Get raw data of rendered rex file
     * 
     * @param string $url url of markup
     * @param Closure|False|String $callback call back function for markup
     *
     * @return Compiler|String
     */
    private static function engine(string $url, Closure|False|String $callback = '') : Compiler|String {
        
        // $url names the source rex file, so it is handed to setFile(). Passing it to
        // setBase() instead marked it as an explicit storage path, which took the
        // storage decision away from the compiler and dumped the compiled file at the
        // application root. Leaving the base unset lets Compiler::rexdata() apply its
        // own default, as it already does for templates loaded via Compiler::read().
        if($callback instanceof Closure){
          $caller = $callback();
          if($caller instanceof Compiler){
            $caller->setFile($url);
            return $caller;
          }else{
            $Compiler = new Compiler();
            $Compiler->setFile($url);
            $Compiler->body($callback());
            return $Compiler;
          }
        } else if (func_num_args() == 1) {

            $Compiler = new Compiler();
            $Compiler->setFile($url);
            $Compiler->compile([]);
            return $Compiler;

        }
        return '';

    }

    /**
     * Rex view function
     *
     * @param string $url
     * @param array|Closure|false|string $callback
     * @return Compiler
     */
    static function view(string $url, array|Closure|false|string $callback = false) : Compiler {

        $Compiler = new Compiler();

        if($callback instanceof closure){

            $exec = $callback();
            if($exec instanceof Compiler){
                $exec->setFile($url);
            }
            return $exec;
        } else { 
            
            $Compiler->setFile($url);

            if(is_string($callback)){
                $Compiler->body($callback);
            } elseif(is_array($callback)) {
                $Compiler->setArgs($callback);
            }
        }
        
       return $Compiler;
    
    }

}

// echo Rex::view('url', ['some_url']);

// echo Rex::view('url', '{{$this}}')->setArgs([]);

// echo Rex::view('url', fn() => compile( [] ));

// echo Rex::view('url')->raw();

// $element = self::view('url', ['some_url'])->raw();