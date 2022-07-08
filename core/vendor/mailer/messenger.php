<?php

include_once 'filebase.php';
include_once 'mail-config.php';
include_once 'user-info.php';

//initialize mailer with cssInliner;
//update class with PHP server configurations as set in mail-server php file
$mailer = new \mailer($cssInliner);
$mailer->init($mail); //set mail configurations

$mypost = $_POST['mail'] = 'link';
$username = USER['username'];

$mailer->set('client',['mail'=>USER['email'],'name'=>$username]);


if($mypost == 'welcome' || $mypost == 'link'){

  if($mypost == 'welcome'){
    //generate your link here
    $mailer->load('dm-user.php');
    $mailer->set('header','welcome to our site'); //set header from here
  }elseif($mypost == 'link'){
    $link = '<a href="https://www.mercyspeaks.com.ng" class="bold" style="color: #3d8cc6;">https://www.mercyspeaks.com?'.randomKey(30).'</a>';
    $mailer->load("dm-link.php"); 
    $mailer->set('header','your download link is ready');     
  }
  $mailer->sendmail(online); //send mail only when online. 'online' returns true when online and false when offline
}else{
     $mailer->set('header','no file was loaded'); 
     $mailer->load('format.php');
     $mailcontent = '<br> <div class="mybox-full">This is just a format page</div> <br> <br>';
}
$mailer->render();

//print $mailer->response('json'); //print mail response in json format
print $mailer->content(); //print mail content



