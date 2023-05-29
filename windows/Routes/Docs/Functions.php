<?php

namespace spoova\mi\windows\Routes\Docs;

use Res;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Url;
use spoova\mi\windows\Frames\UserFrame;

class Functions extends UserFrame {

    function __construct($vars){

        self::call($this, 
          [
              window(':functions')         => 'root',
              SELF::ARG => $vars
          ], false
        );

        self::addRex(); //add template files if needed
        self::basecall($this, [              
          window(':functions.core')   => 'core',
          window(':functions.modal')  => 'modal',
          window(':functions.lite')   => 'lite',
          window(':functions.script') => 'script',
          SELF::ARG => $vars
        ]);
        
    }

    function root($vars){
      
      self::load('docs.functions.index', fn() => compile($vars));

    }
    
    function routings(){
        self::load('docs.functions.routings', fn() => compile());
    }

    private static function coreHandler() {

      $lists = [

        '', //root page (core)

        //data-related
        'scheme', 
        'webClass', 
        'env', 
        'response', 
        'setVar', 
        'vdump',

        //window-related
        'window',
        'route',
        'appExists',
        'windowExists',
        'routeExists',
        'inPath',
        'invoked',
        'lastcall',
        'windowIncludes',
        'windowExcludes',
        'eview',

        //url-related
        'isHTTP',
        'isHTTPS',
        'domurl',
        'domlink',
        'isAbsolutePath',
        'to_backslash',
        'to_frontslash',
        'to_namespace',
        'to_dotspace',
        'urlParams',
        'url',
        'redirect',

        //session-related
        'isGuest',
        'isUser',
        'domlink',
        'authDirect',
        'guestDirect',

        //resource-related
        'recall',
        'ress',
        'monitor',

        //template-related
        'template',
        'compile',
        'view',
        'rex',
        'raw',

      ]; 

      $lastcall = lastCall();
      $urls = array_map(fn($val) => $lastcall.'/'.$val, $lists);
      $files = array_map(fn($val) => 'docs.functions.'.$val, $lists);

      foreach($lists as $list){

        $url = $lastcall;
        $file = 'docs.functions.core';
        
        if($list) {
          $url .=  '/'.$list;
          $file .= '.'.$list;
        }
        
        $pageloader[strtolower($url)] = $file;

      }  
      
      return $pageloader;

    }
    
    function core($vars){
      // print "hey";
      monitor();
// as + 3;
      // var_dump(Res::export());
      $base = strtolower(window('base'));
      $pageLoader = self::coreHandler();

      if(array_key_exists($base, $pageLoader)){

        $var['title'] = 'Tutorial - Functions';
        self::load($pageLoader[$base], fn() => compile($vars));

      } else {

       self::close(true);

      }

    
    }

    private function modalHandler() {

      $lists = [

        '', //root page (core)

        'br', 
        'refil', 
        'encodeUriComponent', 
        'inRange', 
        'randice', 
        'is_empty',

        'not_empty',

        'combine',
        'compare',
        'arrInside',
        'arrVoid',
        'arrGetsVoid',
        'arrSort',
        'array_trim',
        'array_get',
        'array_object',
        'tostdClass',
        'array_delete',
        'array_unset',
        'inflect',
        'reitemize',

      ]; 

      $lastcall = lastCall();
      $urls = array_map(fn($val) => $lastcall.'/'.$val, $lists);
      $files = array_map(fn($val) => 'docs.functions.'.$val, $lists);

      foreach($lists as $list){

        $url = $lastcall;
        $file = 'docs.functions.modal';
        
        if($list) {
          $url .=  '/'.$list;
          $file .= '.'.$list;
        }
        
        $pageloader[strtolower($url)] = $file;

      }  
      
      return $pageloader;

    }
    
    function modal($vars){

      $base = strtolower(window('base'));
      $pageLoader = self::modalHandler();

      if(array_key_exists($base, $pageLoader)){

        $var['title'] = 'Tutorial - Functions';
        self::load($pageLoader[$base], fn() => compile($vars));

      } else {

        self::close();

      }

    }

    function liteHandler() {


      $lists = [

        '', //root page (core)

        'base_encode', 
        'base_decode', 
        'toJson', 
        'fromJson', 
        'enplode', 
        'toSingular',

        'inflect',

        'to_lgts',
        'href',
        'scriptName',
        'striplastSlash',
        'redirectTo',
        'limitText',
        'limitChars',
        'limitWord',

      ]; 

      $lastcall = lastCall();
      $urls = array_map(fn($val) => $lastcall.'/'.$val, $lists);
      $files = array_map(fn($val) => 'docs.functions.'.$val, $lists);

      foreach($lists as $list){

        $url = $lastcall;
        $file = 'docs.functions.lite';
        
        if($list) {
          $url .=  '/'.$list;
          $file .= '.'.$list;
        }
        
        $pageloader[strtolower($url)] = $file;

      }  
      
      return $pageloader;      

    }

    function lite($vars){

      $base = strtolower(window('base'));
      $pageLoader = self::liteHandler();

      if(array_key_exists($base, $pageLoader)){

        $var['title'] = 'Tutorial - Functions';
        self::load($pageLoader[$base], fn() => compile($vars));

      } else {

        self::close();

      }

    }  

    private function scriptHandler(){


      $lists = [

        '', //root page (core)

        'alert', 
        'javaconsole', 
        'script', 

      ]; 

      $lastcall = lastCall();
      $urls = array_map(fn($val) => $lastcall.'/'.$val, $lists);
      $files = array_map(fn($val) => 'docs.functions.'.$val, $lists);

      foreach($lists as $list){

        $url = $lastcall;
        $file = 'docs.functions.script';
        
        if($list) {
          $url .=  '/'.$list;
          $file .= '.'.$list;
        }
        
        $pageloader[strtolower($url)] = $file;

      }  
      
      return $pageloader;   
    }

    function script($vars){
      $base = strtolower(window('base'));
      $pageLoader = self::scriptHandler();

      if(array_key_exists($base, $pageLoader)){

        $var['title'] = 'Tutorial - Functions';
        self::load($pageLoader[$base], fn() => compile($vars));

      } else {

        self::close();

      }
    }

}