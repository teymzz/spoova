<?php

spl_autoload_register(function($class){
   $class = str_replace("\\","/",$class);
   $xclass = explode('/',$class, 2);
   if($xclass[0] == 'app' && ($xclass[1]??'')){
      $class = $xclass[1];
   }
   $dir1 = dirname(dirname(dirname(__FILE__)))."/".$class.".php";
   include_once $dir1;
});

require_once 'secure.php';
?>
