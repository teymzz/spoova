<?php

//directory settings
if(!defined('docroot')) define('docroot', dirname(dirname(__FILE__))); #project folder path (document root)
if(!defined('docBase')) define('docBase', basename(docroot)); # project folder name      
if(!defined('approot')) define('approot', dirname(docroot));  # project folder directory (project files root)

//directory separator
!defined('DS')? define('DS', DIRECTORY_SEPARATOR) : '';

//slash separator
!defined('BS')? define('\\', '/') : '';
!defined('FS')? define('FS', '/') : '';

//define app details
!defined('SP_VERSION')? define('SP_VERSION', '3.0.0') : '';
!defined('SP_SPOOVA')? define('SP_SPOOVA', approot.DS.'spoova'.DS) : '';

!defined('SP_PHP_VERSION')? define('SP_PHP_VERSION', '8.5.0') : '';
!defined('SP_MYSQL_VERSION')? define('SP_MYSQL_VERSION', '8.4.7') : '';
!defined('SP_APACHE_VERSION')? define('SP_APACHE_VERSION', '2.4.65') : '';

//define spack file path
!defined('SP_SPACK')? define('SP_SPACK', approot.DS.'spoova'.DS.'core'.DS.'custom'.DS.'spack_'.SP_VERSION) : '';