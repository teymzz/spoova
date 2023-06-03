<?php

//directory settings
if(!defined('docroot')) define('docroot', dirname(dirname(__FILE__))); #project folder path (D:\SITES\wamp2\www\project folder name)
if(!defined('docBase')) define('docBase', basename(docroot)); # project folder name      
if(!defined('approot')) define('approot', dirname(docroot));

//directory separator
!defined('DS')? define('DS', '/') : '';

//define app details
!defined('SP_VERSION')? define('SP_VERSION', '2.1.0') : '';
!defined('SP_SPOOVA')? define('SP_SPOOVA', approot.DS.'spoova'.DS) : '';

//define spack file path
!defined('SP_SPACK')? define('SP_SPACK', approot.DS.'spoova'.DS.'core/custom/spack_'.SP_VERSION) : '';

//WIN_REX files inclusion
!defined('WIN_REX')? define('WIN_REX', 'windows/Rex'.DS) : '';