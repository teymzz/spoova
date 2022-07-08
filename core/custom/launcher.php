<?php

 
 $f1 = str_replace('\\','/',$_SERVER['SCRIPT_FILENAME']);
 $f2 = str_replace('\\','/',__FILE__);

 if($f1 == $f2 ){ header('location: ../'); exit(); }
 
 $base = basename($_SERVER['REQUEST_URI']);

 if($base == 'setup-dev'){  header('location: dev'); exit(); }

 if($base == 'dev' || $base == 'setup' || strpos($base, 'dev') !== false){

   if($base == 'setup'){
     
     $base = realpath('./icore').'/filebase.php';
     
     if(is_file($base)){
       include_once $base;
     }
     
     include_once 'install.php'; 

   }else{

      include_once 'core/custom/dev.php';

   }

   exit();
 }

 header('location: setup');