<?php

namespace spoova\mi\core\commands\Root;
use spoova\mi\core\classes\FileManager;

class Watch extends Entry{

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

}