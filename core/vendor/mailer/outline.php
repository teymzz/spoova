<?php

  /* THIS IS THE MAIL STRUCTURE FOR SENDING MAILS

     #Connect to your mail client from mail-connect.php
     #Create a default configuration for your emails in mail-setup.php
     #Create any file php of your choice and follow the structure below.    

     include_once 'filebase.php';
     include_once 'mail-config.php';

     $mailer = new /mailer; //initialize your mailer

     ...your code here

     include_once 'sender.php';

  */

  /* THIS SECTION CONTAINS SAMPLE OF MAIL STRUCTURE


     //example 1 -----------------------------------

     include_once 'filebase.php';
     include_once 'mail-config.php';  

     $mailer = new /mailer; //initialize your mailer

     #The next 3 lines of code will overide the default set from mail-setup.php 
      #But not one (if set) in format.php in method 1 below unless declared after $mail->load() method as in example 2
     
     $mailer->set("header","This is my email header");
     $mailer->set("webmail","website@info.com"); //site's mail address 
     $mailer->set("webname","somesite_name"); //site's name (optional)
     $mailer->set("usermail","send_to_user@gmail.com"); //user's email
     $mailer->set("username","name of user"); //user's name (optional)

     #loading email content

     //method 1
     $mailer->load('format.php'); //load email structure from format.php. Any configuration in this file will update the default in mail-setup

     //method 2 
     $mailer->load('This is my text file'); //load email structure directly

     #loading content with replaceable anchors {{}}
     
     $text = 'Adeola';

     $_POST['text'] = 'my book';

     $mailer->load('This is {{$text}}'); //returns 'This is Adeola' (works similarly for files. Note the dollar sign in $username means variable)  

     $mailer->load('This is {{text}}'); //returns 'This is my book' -  absence of dollar sign takes the order $_POST['text']; $_GET['text']; $_REQUEST['text']
     
     $mailer->sendmail(false); //set as true to use this to send mail only on live server else it will return error page

     include_once 'sender.php';

     print_r($mailer->response()); // print the response in array format
     print $mailer->response('json'); //print the response in json format (for ajax)
     print $mailer->content(); //displays the mail's content as an html format.
     $mailer->refresh();       //refreshes the whole class

     //example 2 ----------------------------------- Recommended    
     $mail->load('yourfile.php');

     //overide previous configurations (if others have been previously configured in 'mail-setup.php' or in 'yourfile.php')
     $mailer->set("usermail","send_to_user@gmail.com"); //user's email
     $mailer->set("username","name of user"); //user's name (optional)

     //example 3 ----------------------------------- Explanation   

     $mailer->set("usermail","send_to_user@gmail.com"); //overides usermail value in mail-setup.php
     $mail->load('yourfile.php');
     $mailer->set("usermail","send_to_user@gmail.com"); //overides usermail value either in mail-setup.php or yourfile.php


     # ALL SET METHODS ---------------------------
     # $mailer->set('webmail','');                    //website email (from)*
     # $mailer->set('webname','');                    //website name   
     # $mailer->set('usermail','');                   //user's email (to)*   
     # $mailer->set('username','');                   //user's name              
     # $mailer->set('reply',['mail'=>'','name'=>'']); //reply to 
     # $mailer->set('cc',['mail'=>'','name'=>'']);    //cc 
     # $mailer->set('bcc',['mail'=>'','name'=>'']);   //bcc
     # $mailer->set('file',['file1','file2', ...]);   //attachment
     
     all asteriks must be not be empty. configure this using any 'set' methods listed above or $webmail array variable in mail-setup.php or yourfile.php.
  */

