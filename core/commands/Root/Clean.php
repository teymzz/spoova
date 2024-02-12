<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\FileManager;

class Clean extends Entry{


    /**
     * @param array $args installer arguments
     */
    function __construct($args = []){

        $arg = $args[0]?? false;

        self::commandTitle('clean');

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

        $this->addError('command "'.$arg.'" not recognized');

    }

    /**
     * Configure the online parameters for database
     * 
     * @param array func_get_args() : arguments of online setup
     * @return void
     */
    public function storage(){
        
        yield from Cli::play(10, 2, 'Clearing storage', 2, 1);
        
        $this->deleteAll(_core.'storage');

        Cli::textView(Cli::success('storage cleared successfully', 2));
        Cli::break(1);
        
    }

    private function deleteAll($dir){

        $Filemanager = new FileManager;

        $Filemanager->deleteFile($dir, ['exclude' => $dir]);

    }

}