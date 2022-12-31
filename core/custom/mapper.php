<?php
 
 require_once "secure.php";
 include_once 'assets.php' ; 
 Resource::import(":headers");

 function viewPathContents($content = ''){ 
	print '
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Dev</title>
		</head>
		<body>
			'.pathContents($content).'
		</body>
		</html>
 	';
 };
 
 if(fol == "" and !online){
	if(isset($_POST['bsc-run'])){
		viewPathContents($_POST['bsc-url']);
	}elseif(isset($_GET['urlrq'])){
		viewPathContents($_GET['urlrq']); 	
	}elseif(isset($_GET['view'])){
		include_once "viewer.php";
	}else{
		viewPathContents();
	}
 }else{
	//installation files...
	include_once "install.php";
	//viewPathContents();			 
 }
