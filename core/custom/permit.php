<?php

 !defined('_ACCESS_')? define("_ACCESS_",true) : null;

 $f1 = str_replace("\\","/",$_SERVER['SCRIPT_FILENAME']);
 $f2 = str_replace("\\","/",__FILE__);

 if($f1 == $f2 ){ include_once "core_settings.php"; header("location:/".docBase."/core/"); }