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
!defined('SP_VERSION')? define('SP_VERSION', '2.6.1') : '';
!defined('SP_SPOOVA')? define('SP_SPOOVA', approot.DS.'spoova'.DS) : '';

//define spack file path
!defined('SP_SPACK')? define('SP_SPACK', approot.DS.'spoova'.DS.'core'.DS.'custom'.DS.'spack_'.SP_VERSION) : '';