<?php

namespace spoova\core\classes;

use Res;
use spoova\core\classes\Resin;

/**
 * This class is created for 
 * handling Res Class Template methods
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
 */
final class Rex extends Resx implements Resin{

    /**
     * Renders and Outputs the res template files
     * 
     * @param string $url rex template url
     * @param array|\Closure $callback template handler function
     * @return void
     */
    public static function load($url = '', $callback = ''){
        Res::load(...func_get_args());   
    }

    /**
     * Renders the res templates files using the get method (wvm)
     *
     * @param string $url rex template url
     * @param array|\Closure $callback callback function
     * @return void
     */
    public static function gett($url = '', $callback = ''){
        Res::gett(...func_get_args());   
      }
      
    /**
     * Renders the res templates files using the post method (wvm)
     *
     * @param string $url rex template url
     * @param array|\Closure $callback => callback function
     * @return void
     */
    public static function postt($url = '', $callback = ''){
        Res::postt(...func_get_args());   
    } 
  
    /**
     * Router get method
     * 
     * @param string $url rex template url
     * @param array|\Closure $callback callback function
     * @return void
     */
    public static function get($url = '', $callback = ''){
        Res::get(...func_get_args());   
    }
  
    /**
     * Router post method
     * 
     * @param string $url rex template url
     * @param array|\Closure $callback callback function
     * @return void
     */
    public static function post($url = '', $callback = ''){

        Res::post(...func_get_args());   

    }

}

