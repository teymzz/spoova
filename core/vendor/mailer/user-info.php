<?php

if(isset($_SESSION['user']['userid'])){
  $email = $_SESSION['user']['userid'];

  //DATABASE CONNECTION
  $dbcon = new \core\classes\DB;
  $dbcon->enForce(false);
  
  $db = $dbcon->openDB();
  if($dbcon->active()){
    $db->query("select * from users where email = ?",[$email]);

    if($user = $db->read(1)){
      $user = $user[0];
      !defined('USER')? define('USER', $user) : '';
    }else{
         die("Account for {$email} seems invalid");
    }
  }
}else{
  //die("Please login first");
}