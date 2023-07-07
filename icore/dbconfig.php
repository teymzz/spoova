<?php
 
 // custom db configuration files for online and offline
 
 $_DBCONFIG['SOCKET'] = $_ENV['online']? '' : '';
 $_DBCONFIG['PORT']   = $_ENV['online']? '' : '';
 $_DBCONFIG['SERVER'] = $_ENV['online']? '' : ''; 
 $_DBCONFIG['USER']   = $_ENV['online']? '' : ''; 
 $_DBCONFIG['PASS']   = $_ENV['online']? '' : ''; 
 $_DBCONFIG['NAME']   = $_ENV['online']? '' : '';