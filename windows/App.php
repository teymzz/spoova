<?php

namespace spoova\windows;

use spoova\windows\Docs\Routings;
use spoova\windows\Docs\Database;
use spoova\windows\Docs\Resource;
use spoova\windows\Frame\UserFrame;

class App extends UserFrame{
  
  protected static $indexed = true;
  
  public function __construct() {

    $base = window('base');
    
    $path = explode('/', window('path'))[0]; 

    /* handle defined paths*/
    self::call($this,
        [
            'tutorial'              => 'Tutorial',
            'tutorial/installation' => 'Installation', 
            'tutorial/live-server'  => 'LiveServer', 
            'download'              => 'Download', 
            //'tutorial/routings'  => 'Routings', //These will be handled by their classes
            //'tutorial/database'  => 'Database', //These will be handled by their classes
        ], false    
    );

    /* handle direct paths */
    $directs = ['home','about','download'];

    if(in_array($base, $directs) && method_exists($this, $base)){
        self::basecall($this, [
            $base => $base
        ]);
        return;
    }

    /* handle paths with root name of tutorial */
    else if(strtolower(window()) === 'tutorial') {

        if($path && !in_array($path, ['installation','live-server'])){
            $path = explode("/", $path)[0]?? '';
            $this->Tutor($path);
        }
        
        return;

    }
    
    //return a 404 page
    return self::close();
  }

  public function Tutorial() {

      $vars = [
          'title' => 'tutorial'
      ];

      self::load('tutorial', fn() => compile($vars) );
  }

  public function Installation() {

      $pointer = self::mapurl('Tutorial/Installation', ' <span class="bi-chevron-right"></span> ');

      $vars = [
          'title' => 'Installation',
          'pointer' => $pointer
      ];

      self::load('installation', fn() => compile($vars) );
  }

  public function LiveServer() {

      $pointer = self::mapurl('Tutorial/Live-Server', ' <span class="bi-chevron-right"></span> ');
        
      $vars = [
          'title' => 'Installation', 
          'pointer' => $pointer
      ];

      self::load('live-server', fn() => compile($vars) );
  } 
  
  public function Tutor($tutor){
      $class = 'spoova\windows\Docs\\'.$tutor;
     
      if(class_exists($class)){
         $exp = explode('/',self::wvm('path'), 2)[1]?? '';
         $newclass = new $class($exp);
         if(!$exp){
           if(method_exists($newclass, 'index')){
            
            $upClass = ucfirst($tutor);
            $pointer = self::mapurl('Tutorial/'.$upClass, ' <span class="bi-chevron-right"></span> ');
        
            $vars = [
                'title' => 'Tutorial - '.$upClass,
                'pointer' => $pointer
            ]; 

            $newclass->index($vars);

           }else{ 
             self::close();
           }
         }
          
      } else {
        self::close();
      }
  }

  public function Database() {

      //Handle all Database from the Database class
      new Database(self::wvm('path'));
  }  

  public function Routings(){

      //Handle all Routings from the Routings class
      new Routings(self::wvm('path'));    
  }

  public function Resource(){

      //Handle all Routings from the Routings class
      new Resource(self::wvm('path'));    
  }

  public function Home(){
        redirect('/');
  }

  public function About(){

    $pointer = self::mapurl('Home/About', ' <span class="bi-chevron-right"></span> ');

    $vars = [
        'title' => 'About',
        'pointer' => $pointer
    ];

    //Handle all Routings from the Routings class
    self::load('about', fn() => compile($vars));    

  }

  
  public function Download(){

    $pointer = self::mapurl('Home/Download', ' <span class="bi-chevron-right"></span> ');

    $vars = [
        'title' => 'Download',
        'pointer' => $pointer
    ];

    //Handle all Routings from the Routings class
    self::load('download', fn() => compile($vars)); 

  }

}