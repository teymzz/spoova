<?php

namespace teymzz\spoova\windows\Routes\Docs;

use Window;

class Setters extends Window {


    function __construct($vars)
    {

        self::call($this, [

            window(':setters') => 'index',

            SELF::ARG => $vars
        ]);

    }

    function index($vars){

        self::load('docs.setters.setters', fn() => compile($vars));

    }




}