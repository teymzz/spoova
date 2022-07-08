<?php

 // custom db configuration files for online and offline

 $_DBCONFIG['SOCKET'] = (online)? '' : '';
 $_DBCONFIG['PORT']   = (online)? '' : '';
 $_DBCONFIG['SERVER'] = (online)? '' : '127.0.0.1';
 $_DBCONFIG['USER']   = (online)? '' : 'root';
 $_DBCONFIG['PASS']   = (online)? '' : ''; 
 $_DBCONFIG['NAME']   = (online)? '' : ''; 