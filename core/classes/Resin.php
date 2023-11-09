<?php

namespace spoova\mi\core\classes;

use Closure;

/**
 * This class contains interfaces implemeted by 
 * both Res and Rex classes 
 * 
 */
Interface Resin{

    /**
     * Renders rex templates files
     *
     * @param string $url rex template url
     * @param Closure|False $callback template handler function
     * @return string
     */
    public static function load(string $url, Closure|False $callback = false);

}