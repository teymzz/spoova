<?php

namespace spoova\mi\core;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Bundle\Filemanager\FileTransfer;
use spoova\mi\core\commands\Root\Cli;

class Spv {

    static function init(){

        $dir = './vendor/spoova/mi';
        
        if(is_dir($dir)){
            $Filemanager = new Filemanager;

            if(!defined('br')) include_once 'core/basics.php';
    
            $Filemanager->source($app, ['*','.']);
    
            $Filemanager->ignoredPaths([$app.'/vendor', $app.'/composer.json']);
            
            $Filemanager->moveContentsTo('./', function(FileTransfer $file) use(&$response){ $response = $file; });
            
            /** @var FileTransfer $response */
            if($response->unresolved('count') > 1) {
                Cli::errorView('some files were unresolved');
            }
            

        }elseif(is_file('core/spoova.php')){

            include_once "core/spoova.php";

        }


    }

}