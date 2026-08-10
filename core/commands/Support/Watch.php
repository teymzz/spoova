<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Livescript;

class Watch extends Entry{

    /**
     * @param array $args : installer arguments
     */
    function __construct(array $args = []){

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
            
            $this->display(Cli::error('command "'.Cli::warn($arg).'" not recognized'), '1');
            
        }

        $this->display(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('watch','','','').Cli::warn('[status|online|offline|both|disable]', '1'), 1);

    }

    function status(){

        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch status'));   
        
        if(is_file(self::init_url())){

            $map = [
                '' => 'not configured', 
                0  => Cli::danger('disabled'), 
                1 => Cli::warn('offline'), 
                2 => Cli::color('online','green')
            ];

            $status = Livescript::key('ACTIVITY');

            if(!$status){
                if($status === false) {
                    $status = '';
                }else{
                    $status = 0;
                }
            }
            
            if($status){

                Cli::textView('status: '.$map[$status])->smartBreak(2);      

            }else{

                Cli::textView(Cli::emos('clock', 1).'watch '.$map[$status], 0, '0|2');      
                
            }

        } else {
        
            Cli::textView(Cli::emos('crossmark', 1).'missing init configuration file!', 0, '2');

        }

    }

    function online() {

        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch online')); 

        Cli::textYield('updating', 4, 2);

        
        if(Livescript::set('ACTIVITY', '2')) {

            Cli::textView(Cli::emo('checkmark', '1|1').Cli::success('watch set to '.Cli::valid('online').' mode!'));
            Cli::break(2);

        } else{ 
            Cli::textView(Cli::error('update failed because '.Livescript::message()), 0, '|2');
        }

    }

    function offline() {
        
        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch offline')); 

        Cli::textYield('updating', 4, 2);

        if(Livescript::set('ACTIVITY', '1')) {

            Cli::textView(Cli::emo('checkmark', '1|1').Cli::success('watch set to '.Cli::warn('offline').' mode!'));
            Cli::break(2);

        } else{ 
            Cli::textView(Cli::error('update failed because '.Livescript::message()), 0, '|2');
        }

    }

    function disable() {

        $this->display(Cli::danger(Cli::emo('point-list', '|1').'watch disable')); 
        
        if(Livescript::set('ACTIVITY', '0')) {

            Cli::textView(Cli::emo('checkmark', '1|1').Cli::success('watch').Cli::danger('disabled', '1'));
            Cli::break(2);

        } else{ 
            Cli::textView(Cli::error('update failed because '.Livescript::message()), 0, '|2');
        }

    }

}