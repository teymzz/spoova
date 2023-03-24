<?php

namespace spoova\mi\windows\Routes\Docs;

use spoova\mi\windows\Frames\UserFrame;

class Template extends UserFrame {

    function __construct($vars){

      self::addRex('template.t-tut');

      self::call($this, 
          [
              lastCall() => 'index',
              lastCall('/compilers') => 'compilers',
              lastCall('/files') => 'files',
              lastCall('/directives') => 'directives',
              lastCall('/window') => 'window',
              lastCall('/on_the_go') => 'on_the_go',

              SELF::ARG => $vars
          ]
      );  
        
    }

    function index($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.template.template', fn() => compile($vars));

    }

    function compilers($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.template.compilers', fn() => compile($vars));

    }

    function files($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.template.files', fn() => compile($vars));

    }

    function directives($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.template.directives', fn() => compile($vars));

    }

    function window($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.template.window', fn() => compile($vars));

    }

    function on_the_go($vars){
  
      $vars['fit'] = 'fit';
      self::load('docs.template.on_the_go', fn() => compile($vars));

    }

}