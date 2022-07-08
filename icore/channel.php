<?php

//define path to channels folder
$channel = dirname(dirname(__FILE__));

define('channels', $channel.'/channels/');

function channel($channel){
    include_once channels.$channel.".php";
}