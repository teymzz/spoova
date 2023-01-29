<?php

namespace spoova\core\classes;

/**
 * This class contains interfaces implemeted by 
 * both Res and Rex classes 
 * 
 */
Interface Resin{

    /**
     * Renders the res templates files using the get method
     *
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return string
     */
    public static function load($url, $callback);

    /**
     * Renders the res templates files using the get method
     *
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return Res|string
     */
    public static function gett($url, $callback);

    /**
     * Renders the res templates files using the post method
     *
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return Res|string
     */
    public static function postt($url, $callback);

    /**
     * Router get method
     * 
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return Res|string
     */
    public static function get($url, $callback);

    /**
     * Router post method
     * 
     * @param string $url rex template url
     * @param array|string|\Closure $callback template handler function
     * @return void     *    parameter 1 (string)         => file name in the rex folder
     *    parameter 2 (string|closure) => string or callback function 
     *
     * @return Res|string routed component
     */
    public static function post($url, $callback);

}