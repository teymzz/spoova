<?php

  require_once 'secure.php'; //secure file

  !defined("online")? define("online",false) : null;

  //database config settings
  if(isset($_DBCONFIG)){
      
    $_DBSOCKET = MyIsset($_DBCONFIG['SOCKET']); 
    $_DBPORT   = MyIsset($_DBCONFIG['PORT']);
    $_DBUSER   = MyIsset($_DBCONFIG['USER']); 
    $_DBSERVER = MyIsset($_DBCONFIG['SERVER']);
    $_DBPASS   = MyIsset($_DBCONFIG['PASS']); 
    $_DBNAME   = MyIsset($_DBCONFIG['NAME']);

  }else{
    include_once "dbconfig.php";
  }


  //declare database parameters

  defined("DBSOCKET")? null : define("DBSOCKET",$_DBSOCKET);  
  defined("DBSERVER")? null : define("DBSERVER",$_DBSERVER);
  defined("DBPORT")? null : define("DBPORT",$_DBPORT);
  defined("DBUSER")? null : define("DBUSER",$_DBUSER);
  defined("DBPASS")? null : define("DBPASS",$_DBPASS);
  defined("DBNAME")? null : define("DBNAME",$_DBNAME);

  define("DBCON","MiSQL"); //MiSQL or MiPDO

  //database constants
  $dbconstants = [
    "encrypt" => "md5",  
    "autoDateTime" => false, 
    "conType" => DBCON,
    "dbcon" => DBCON,   
  ];

  //$_ENV environment variables
  $_ENV['DBCONFIG'] = [
    'NAME'   => $_DBNAME,
    'USER'   => $_DBUSER,
    'PASS'   => $_DBPASS,
    'SERVER' => $_DBSERVER,
    'PORT'   => $_DBPORT,
    'SOCKET' => $_DBSOCKET
  ];

  include_once 'dbconfig.php';

  $_ENV['DBDEFAULT'] = [
    'NAME'   => $_DBNAME,
    'USER'   => $_DBUSER,
    'PASS'   => $_DBPASS,
    'SERVER' => $_DBSERVER,
    'PORT'   => $_DBPORT,
    'SOCKET' => $_DBSOCKET,
  ];  