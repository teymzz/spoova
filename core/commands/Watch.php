<?php

namespace spoova\core\commands;
use spoova\core\classes\DBConfig;
use spoova\core\classes\FileManager;

class Watch extends Entry{

    /* Database constants */
    private const DBCONSTANTS = [ 'USER', 'PASS', 'NAME', 'SERVER', 'PORT', 'SOCKET' ];

    /**
     * @param array func_get_args() : installer arguments
     */
    function __construct($args = []){

        $arg = $args[0]?? false; 

        array_shift($args);
        $args = array_values($args);

        if(method_exists($this, $arg)){
            $this->$arg(...$args);
            return;
        }

        $this->addError('command "'.$arg.'" not recognized');

    }

    function status(){
        
        if(is_file(self::init_url())){

            $FileManager = new FileManager;
            $FileManager->setUrl(self::init_url());

            $map = ['' => 'watch not configured', 0 => 'disabled', 1 => 'offline', 2 => 'online'];

            $status = $FileManager->readFile('RESOURCE_WATCH');

            if(!$status){
                if($status === false) {
                    $status = '';
                }else{
                    $status = 0;
                }
            }
            

            if($status){

                Anime::textView('status: '.$map[$status], 0, 2);      

            }else{

                Anime::textView(Anime::emos('crossmark', 1).'watch '.$map[$status], 0, 2);      
                
            }

            

        } else {
        
            Anime::textView(Anime::emos('crossmark', 1).'missing init configuration file!', 0, 2);

        }

    }

    function online() {

        if($FileManager = self::get_init()) {

            $FileManager->textUpdate(['RESOURCE_WATCH' => 2]);

            Anime::textYield('updating', 4, 2);

            if($watch = $FileManager->readFile('RESOURCE_WATCH')){
  
                if($watch === '2'){
                    Anime::textView('watch set to online mode!', 0, 2);
                } else {
                    Anime::textView(Anime::emos('crossmark', 1).'error updating init file', 0, 2);
                }

            }

        }

    }

    function offline() {

        if($FileManager = self::get_init()) {

            $FileManager->textUpdate(['RESOURCE_WATCH' => 1]);

            Anime::textYield('updating', 4, 2);

            if($watch = $FileManager->readFile('RESOURCE_WATCH')){
  
                if($watch === '1'){
                    Anime::textView('watch set to offline mode!', 0, 2);
                } else {
                    Anime::textView(Anime::emos('crossmark', 1).'error updating init file', 0, 2);
                }

            }

        }

    }

    function disable() {

        if($FileManager = self::get_init()) {

            $FileManager->textUpdate(['RESOURCE_WATCH' => 0]);

            Anime::textYield('updating', 4, 2);

            if($watch = $FileManager->readFile('RESOURCE_WATCH')){
  
                if($watch === '0'){
                    Anime::textView('watch disabled!', 0, 2);
                } else {
                    Anime::textView(Anime::emos('crossmark', 1).'error updating init file', 0, 2);
                }

            }

        }

    }

    private function meta(){
        $args = func_get_args();
        if(count($args) < 1){
            $syntax = self::$syntaxes['config']['meta']?? '';
            $this->log_syntax($syntax);
            return;
        }

        if($args[0] !== 'on' and $args[0] !== 'off'){
            Console::error("command not recognized", $args[0]);  
            return;
        }

        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['RESOURCE_META' => $args[0] ]);
            
            if($FileManager->readFile('RESOURCE_META')){
                Console::log('meta configured successfully');   
                $this->complete_setup();          
            } else {
                Console::log('meta configuration failed');                
            }            
        }

    }

    private function init(){
        $args = func_get_args();

        if(empty($args)){
            $syntax = self::$syntaxes['config']['init'];
            $this->log_syntax($syntax);
            return;
        }
    }

    private function log_syntax($syntax){

        $expSyntax = explode(">>", $syntax, 2)[1]?? '';
            
        if($expSyntax){
            Console::log(">> ".$expSyntax);
            return;
        }
        Console::log("no syntaxes found for this command");

    }

}