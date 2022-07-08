<?php

namespace spoova\windows;
use spoova\windows\App;
use spoova\core\classes\Rex;
use spoova\windows\Frame\UserFrame;

class Index extends UserFrame{
  
  protected static $indexed = true;
  
  public function __construct() {
    
    self::routes();
    
    $title = 'Spoova'; 
    
    $vars = compact('title');
    
    self::load('index',fn() => compile($vars));
     
  }
   
  public static function usedoor() {

    // Handle unexisting pages
    if(class_exists(__NAMESPACE__.'\App')){ 
      //Handle other no-existing pages using the Home Class
      new App();    
      return;
    }

    self::sleep();

  }
   
}

