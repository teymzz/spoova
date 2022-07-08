<?php

include_once '../icore/filebase.php';
//Res::off();

$arrd = [1,2,3];

Res::ignore();
Res::name('404')
		->url('res/main/js/config.js')
		->url('res/main/css/res.css')
		;

Window::open();
 
?> 