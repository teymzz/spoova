<?php
 
 require_once 'secure.php'; //secure file
 
 //online means live server, not online means on local server (e.g wamp, xamp ...)
 $_DBSOCKET = (online)? '' : '';
 $_DBPORT = (online)? '' : '';
 $_DBSERVER = (online)? '' : ''; 
 $_DBUSER = (online)? '' : ''; 
 $_DBPASS = (online)? '' : ''; 
 $_DBNAME = (online)? '' : '';
 
 // NOTE:
 // 1: This file should not be edited or used for connection, create a new copy instead, then include that copy in your project which will automatically update this
 // 2: Example of a copy dbconfig.php file is the dbconfig file located created in the root “icore” folder
 