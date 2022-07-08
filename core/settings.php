<?php

//declare charset
@ini_set('default_charset', 'UTF-8');

//app installer
function _install($redirection_url = ''){
  define('spoova', $redirection_url); 
  include_once 'installer.php';
}

//include app constants
include_once 'app.php';

//include configuration files
include_once 'server.php';

//include configuration files
include_once 'custom/configs/inc.php';
