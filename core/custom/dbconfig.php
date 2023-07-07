<?php
 
 require_once 'secure.php'; //secure file
 
 //online means live server, not online means on local server (e.g wamp, xamp ...)
 $_DBSOCKET = $_ENV['online']? '' : '';
 $_DBPORT   = $_ENV['online']? '' : '';
 $_DBSERVER = $_ENV['online']? '' : ''; 
 $_DBUSER   = $_ENV['online']? '' : ''; 
 $_DBPASS   = $_ENV['online']? '' : ''; 
 $_DBNAME   = $_ENV['online']? '' : '';
 
 // NOTE:
 // 1: This file should not be edited or used for connection, create a new copy instead, then include that copy in your project which will automatically update this
 // 2: Example of a copy dbconfig.php file is the dbconfig file located created in the root “icore” folder
 