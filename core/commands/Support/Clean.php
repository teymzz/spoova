<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class Clean extends Entry{


    /**
     * @param array $args installer arguments
     */
    function __construct($args = []){

        $arg = $args[0]?? false;

        self::commandTitle('clean '.Cli::warn($arg));

        if(empty($arg)){   

            $config = [];

            foreach (self::directives as $directive => $value) { 
                if(strstr($directive, 'clean') and (trim($directive) !== 'clean') ){
                    $config[trim($directive)] = $value;
                    Cli::textView(self::mi(trim($directive))." | ".$value, 2, '1|2');
                }
            }

            if(empty($config)){
                Cli::textView('No options found!', 0, 2);
            }
            
            return;   
        }  


        array_shift($args);
        $args = array_values($args);

        if(method_exists($this, $arg)){
            // $this->$arg(...$args);
            Cli::animeType('roller');
            Cli::runAnime([[$this, 'storage'], $args]);
            return;
        }

        Cli::break(1)->textView(Cli::error('command "'.Cli::warn($arg).'" not recognized.'));
        Cli::break(2);

    }

    /**
     * Configure the online parameters for database
     * 
     * @return void
     */
    public function storage(){
        
        yield from Cli::play(10, Cli::textIndent('clearing storage...'), function(){
            Cli::clearLine();
            Cli::stop(true);
        });
        
        $this->deleteAll(_core.'storage');

        Cli::textView(Cli::success('storage cleared successfully.'));
        
    }

    private function deleteAll(string $dir){

        $Filemanager = new Filemanager;

        $Filemanager->deleteFile($dir, ['exclude' => $dir]);

    }

}