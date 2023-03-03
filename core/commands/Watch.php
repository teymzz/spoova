<?php

namespace teymzz\spoova\core\commands;
use teymzz\spoova\core\classes\FileManager;

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

        $this->display(Cli::danger(Cli::emo('point-list').' watch '));

        if(!$arg) {

            $this->display(Cli::error('expecting at least one(1) argument'), 1);
            
        } else {
            
            $this->display(Cli::error('command "'.Cli::warn($arg).'" not recognized'), 1);
            
        }

        $this->display(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('watch','','','').Cli::warn('[status|online|offline|both|disable]', 1), 1);

    }

    function status(){

        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch status'));   
        
        if(is_file(self::init_url())){

            $FileManager = new FileManager;
            $FileManager->setUrl(self::init_url());

            $map = ['' => 'not configured', 0 => Cli::danger('disabled'), 1 => Cli::warn('offline'), 2 => Cli::color('online','green')];

            $status = $FileManager->readFile('RESOURCE_WATCH');

            if(!$status){
                if($status === false) {
                    $status = '';
                }else{
                    $status = 0;
                }
            }
            
            if($status){

                Cli::textView('status: '.$map[$status], 2).Cli::break(2);      

            }else{

                Cli::textView(Cli::emos('clock', 1).'watch '.$map[$status], 0, '0|2');      
                
            }

        } else {
        
            Cli::textView(Cli::emos('crossmark', 1).'missing init configuration file!', 0, 2);

        }

    }

    function online() {

        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch online')); 

        if($FileManager = self::get_init()) {

            $FileManager->textUpdate(['RESOURCE_WATCH' => 2]);

            Cli::textYield('updating', 4, 2);

            if($watch = $FileManager->readFile('RESOURCE_WATCH')){
  
                if($watch === '2'){
                    Cli::textView(Cli::emo('checkmark', [1,1]).Cli::success('watch set to '.Cli::color('online', 'green').' mode!'));
                    Cli::break(2);
                } else {
                    Cli::textView(Cli::emos('crossmark', 1).'error updating init file', 0, 2);
                }

            }

        }

    }

    function offline() {
        
        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch offline')); 

        if($FileManager = self::get_init()) {

            $FileManager->textUpdate(['RESOURCE_WATCH' => 1]);

            Cli::textYield('updating', 4, 2);

            if($watch = $FileManager->readFile('RESOURCE_WATCH')){

                if($watch === '1'){
                    Cli::textView(Cli::emo('checkmark', '1|1').Cli::success('watch set to '.Cli::warn('offline').' mode!'));
                    Cli::break(2);
                } else {
                    Cli::textView(Cli::emos('crossmark', 1).'error updating init file', 0, 2);
                }

            }

        }

    }

    function disable() {

        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch disable')); 

        if($FileManager = self::get_init()) {

            $FileManager->textUpdate(['RESOURCE_WATCH' => 0]);

            Cli::textYield('updating', 4, 2);

            if($watch = $FileManager->readFile(['RESOURCE_WATCH'])){
                
                $watch = $watch['RESOURCE_WATCH'];

                if($watch === '0'){
                    Cli::textView(Cli::emo('checkmark', '1|1').Cli::success('watch').Cli::danger('disabled!', 1));
                    Cli::break(2);
                } else {
                    Cli::textView(Cli::emos('crossmark', 1).'error updating init file', 0, 2);
                }
                    
            }else{

                Cli::textView(Cli::emos('crossmark', 1).'error fetching config data', 0, 2);
                Cli::textView('Ensure that init config file is not missing and is accessible', 0, 2);

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