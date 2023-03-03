<?php

 namespace teymzz\spoova\windows\Routes\Docs;

 use teymzz\spoova\windows\Frames\UserFrame;

 class Mails extends UserFrame {
     
     function __construct($vars) {
            
            $subject = ucfirst(basename(self::wvm('path')));
            $path = url(window('path'))->first(2);

            $vars = [
                'title'   => 'Tutorial - '.$subject, 
                'subject' => $subject,
                'pointer' => $vars['pointer']
            ];

            self::pathcall($this,
                [
                   'mails'  => 'index',    
                    SELF::ARG => $vars
                ], false
            );

            self::pathcall($this,
               [
                    $path  => basename(window('path')),       
                    SELF::ARG => $vars
               ],
            );  

     }
     
     function index($vars){
        
        self::load('docs.mails.index', fn() => compile($vars));
        
     }

     function setup($vars){

         self::load('docs.mails.setup', fn() => compile($vars));

     }

     function server($vars){

         self::load('docs.mails.server', fn() => compile($vars));

     }

     function content($vars){

         self::load('docs.mails.content', fn() => compile($vars));

     }

     function sync($vars){

         self::load('docs.mails.sync', fn() => compile($vars));

     }

     function inject($vars) {

         self::load('docs.mails.inject', fn() => compile($vars));

     }

     function authorize($vars) {

         self::load('docs.mails.authorize', fn() => compile($vars));

     }

     function authorized($vars) {

         self::load('docs.mails.authorized', fn() => compile($vars));

     }

     function pull($vars) {

         self::load('docs.mails.pull', fn() => compile($vars));

     }

     function info($vars) {

         self::load('docs.mails.info', fn() => compile($vars));

     }

     function attempted($vars) {

         self::load('docs.mails.attempted', fn() => compile($vars));

     }

     function casted($vars) {

         self::load('docs.mails.casted', fn() => compile($vars));

     }

     function sent($vars) {

         self::load('docs.mails.sent', fn() => compile($vars));

     }

     function response($vars) {

         self::load('docs.mails.response', fn() => compile($vars));

     }

     function templating($vars) {

         self::load('docs.mails.templating', fn() => compile($vars));

     }
     
 }
 
 /* variable inheritance - global  & specific*/