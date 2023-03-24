<?php

namespace spoova\mi\core;
use spoova\mi\core\classes\FileManager;

class Spv {

    static function init(){

        $dir = './vendor/spoova';
        if(is_dir($dir)){
            $FileManager = new FileManager;
    
            $FileManager->setUrl($dir.'/mi');
    
            if($FileManager->moveContentsTo('./', ['vendor', 'mi', 'composer.json'])){
    
                //$FileManager->deleteFile($dir);
    
            }

        }elseif(is_file('core/spoova.php')){

            include_once "core/spoova.php";

        }


    }

}