<?php

 if(!defined("docBase")){
 	include_once "settings.php";
 }

 !defined("_ACCESS_")? header("location:/".constant('docBase')."/core/") : null;
