<?php

 // custom db connection file for online and offline environments

 $_DBCONFIG['SOCKET'] = (online)? '' : '';
 $_DBCONFIG['PORT'] = (online)? '' : '';
 $_DBCONFIG['SERVER'] = (online)? '' : '';
 $_DBCONFIG['USER'] = (online)? '' : '';
 $_DBCONFIG['PASS'] = (online)? '' : ''; 
 $_DBCONFIG['NAME'] = (online)? '' : ''; 