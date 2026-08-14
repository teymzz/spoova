<?php

 // custom db configuration files for online and offline  

 $_DBCONFIG['SOCKET']  = $_ENV['online']? '' : '';
 $_DBCONFIG['PORT']    = $_ENV['online']? '' : '3306';
 $_DBCONFIG['SERVER']  = $_ENV['online']? '' : 'localhost';
 $_DBCONFIG['USER']    = $_ENV['online']? '' : 'root';
 $_DBCONFIG['PASS']    = $_ENV['online']? '' : '';	
 $_DBCONFIG['NAME']    = $_ENV['online']? '' : 'teymzz';