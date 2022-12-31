<?php
 
 // This file (config.php) should not be edited or removed
 // under no circumstances must any file be removed
 // editable files: path.php, dbconfig edited

 
 if(is_file(dirname(domroot()).'/core/server.php')){
    require_once(dirname(domroot()).'/core/server.php');
 }else{
    require_once domroot().'core/server.php'; //connect to server  
 }

 //import all configuration files
 include_once "dbconfig.php"; //database configuration

 //set database configuration files 
 $_CONFIG['DB'] = isset($_DBCONFIG)? $_DBCONFIG : '';

 //set header configuration files