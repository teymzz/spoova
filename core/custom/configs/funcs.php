<?php

//check php environment
function isCli(){ return (php_sapi_name() == 'cli') ; }

//define function undefined
function _define($name, $value){ if(!defined($name)) define($name,$value); }

//define environment constants
function _envdefine($name, $onvalue, $offvalue = ''){ 
    if(!defined($name)) 
      ((online)? define($name,$onvalue): define($name,$offvalue)); 
  }
  
//set items only when on live server
function setOnline(&$var, $value){
    if(defined('online')){
        if(online) $var = $value;
    }
}

//set items only when on local server
function setOffline(&$var, $value){
    if(defined('online')){
        if(!online) $var = $value;
    }
}

//set post in ajax requests using phpInput()
function phpInput(){
    if(empty($_POST)){
        if(!empty(file_get_contents('php://input'))){
            $phpInput = @json_decode(file_get_contents('php://input'), true); 
            if(!empty($phpInput))
            $_POST = $phpInput;
        }
    }
}

//define function for light file inclusion
function _includeOnce($path){
    if(is_file($path)) include_once $path;
} 