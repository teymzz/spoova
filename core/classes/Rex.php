<?php

namespace spoova\mi\core\classes;

use Closure;
use Res;
use spoova\mi\core\classes\Resin;

/**
 * This class is created for 
 * handling Res Class Template methods
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
final class Rex extends Resx implements Resin{

    public static function load(string $url, Closure|String $callback = ''){
        
        print self::markup(...func_get_args());

    }
    
    /**
     * Get raw data of rendered rex file
     * 
     * @param $url url of markup
     * @param $callback call back function for markup
     *
     * @return string
     */
    public static function markup(string $url, Closure|String $callback = '') : string {

        return (string) self::compile(...func_get_args());

    }

    /**
     * Rex compiler function
     *
     * @param string|null $url
     * @param Closure|false $callback
     * @return Compiler|String
     */
    public static function compile(string $url, Closure|false $callback = false) : Compiler|String {

       return self::engine(...func_get_args());
    
    }

    /**
     * Get raw data of rendered rex file
     * 
     * @param $url url of markup
     * @param $callback call back function for markup
     *
     * @return Compiler
     */
    private static function engine(string $url, Closure|String $callback = '') : Compiler {
        
        if($callback instanceof Closure){
          $caller = $callback();
          if($caller instanceof Compiler){
            $caller->setBase($url);
            return $caller; 
          }else{
            $Compiler = new Compiler();
            $Compiler->setBase($url);
            $Compiler->body($callback());
            return $Compiler;
          }
        } else if (func_num_args() == 1) {
  
            $Compiler = new Compiler();
            $Compiler->setBase($url);
            $Compiler->compile([]);
            return $Compiler;        
  
        }
        
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
                $exec->setBase($url);
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