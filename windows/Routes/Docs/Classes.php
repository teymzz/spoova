<?php

 namespace spoova\windows\Routes\Docs;
 
 use spoova\windows\Frames\UserFrame;

 class Classes extends UserFrame{

    function __construct($vars)
    {

        self::pathcall($this,
            [
                'classes' => 'root',
                
                 SELF::ARG => $vars
            ],
            false 
        );

        $path = (url(window('path'))->first(2));

        self::pathcall($this,
            [
                $path => basename(window('path')),
                SELF::ARG => $vars
            ]
        );

    }

    function root($vars){
        self::load('docs.classes.index', fn()=> compile($vars));
    }

    function meta($vars) {
        self::load('docs.classes.meta', fn() => compile($vars) );
    }

    function ajax($vars) {
        self::load('docs.classes.ajax', fn() => compile($vars) );
    }

    function input($vars) {
        self::load('docs.classes.input', fn() => compile($vars) );
    }

    function fileuploader($vars) {
        self::load('docs.classes.fileuploader', fn() => compile($vars) );
    }
    
    function imageclass($vars) {
         self::load('docs.classes.imageclass', fn() => compile($vars) );
     }

    function filemanager($vars) {
        self::load('docs.classes.filemanager', fn() => compile($vars) );
    }

    function jwstoken($vars) {
        self::load('docs.classes.jwstoken', fn() => compile($vars) );
    }

    function jsonfy($vars) {
        self::load('docs.classes.jsonfy', fn() => compile($vars) );
    }

    function hasher($vars) {
        self::load('docs.classes.hasher', fn() => compile($vars) );
    }

    function notice($vars) {
        self::load('docs.classes.notice', fn() => compile($vars) );
    }

    function forms($vars) {

        self::load('docs.classes.forms', fn() => compile($vars) );
    }

    function url($vars) {
        self::load('docs.classes.url', fn() => compile($vars) );
    }

    function urlmapper($vars) {
        self::load('docs.classes.urlmapper', fn() => compile($vars) );
    }

    function timeclass($vars) {
        self::load('docs.classes.timeclass', fn() => compile($vars) );
    }

 }