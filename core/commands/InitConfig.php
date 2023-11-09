<?php 

namespace spoova\mi\core\commands;

use spoova\mi\core\classes\FileManager;
use spoova\mi\core\classes\Init;

class InitConfig { 

    function __construct($args) {
        
        Cli::textView(Cli::danger(Cli::emo('point-list')." initConfig")); 
        Cli::break(2);

        $Filemanager = new FileManager;

        $Filemanager->setUrl(_icore.'init');

        if(count($args) > 2){
            Cli::textView(Cli::error('Invalid maximum(2) number of arguments exceeded.'));
            Cli::break(2);
        }else{
            
            $key = $args[0];
            $val = $args[1];
            $Filemanager->textUpdate([$key => $val], $upds, ':');

            //read File... 
            if(Init::key($key) === $val) {
                Cli::textView(Cli::success('key "'.Cli::warn($key).'" configured successfully'));
                Cli::break(2);
            }else{
                Cli::textView(Cli::error('key "'.Cli::warn($key).'" configuration failed!'));
                Cli::break(2);
            }

        }

    }

}