<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Cli extends UserFrame{

    function __construct()
    {
        
    }

    function index($vars) {
       
        self::load('docs.cli.index', fn() => compile() );

    }

}