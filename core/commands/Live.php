<?php

namespace spoova\mi\core\commands;
use spoova\mi\core\commands\Cli;
use spoova\mi\core\classes\Livescript;

class Live extends Entry{

    function __construct(array $args = []){

        Cli::textView(Cli::danger(Cli::emo('point-list').' live '. Cli::warn(implode(' ', $args))));
        Cli::break(2);

        if(!$args) {
            
            Cli::textView('This displays or sets a live server key\'s value', 2);
            Cli::break(2);

            return;

        }

        if(count($args) === 1) {

            $key = strtoupper($args[0]);
            if($key !== 'CONTROLS'){
                if($value = Livescript::key($key)){
                    Cli::textView(Cli::valid($key).': '.Cli::warn($value), 2);
                    Cli::break(2);
                }else{
                    Cli::textView(Cli::warn($key).': '.Cli::danger('key is undefined'));
                    Cli::break(2);
                }
            }else{
                $args[1] = 'poll';
            }

        }

        if(isset($args[1]) && $args[0] === 'controls' && !in_array($args[1], ['poll', 'seek', '--'])){
            Cli::textView(Cli::error('live key value("'.Cli::warn($args[1]).'") unknown.'));
            Cli::break(2);
            Cli::textView(Cli::emo('ribbon-arrow').' valid options: ['.Cli::warn('poll').'|'.Cli::warn('seek').'|'.Cli::warn('--').']', 2);
            Cli::break(2);
            return;
        }
        
        if(count($args) === 2) {
            $key = $args[0];
            $value = $args[1];

            if($value === '--'){
                if(Livescript::key($key)){
                    if(Livescript::unset($key)){
                        Cli::textView(Cli::valid($key).': '.Cli::danger('key deleted successfully.'));
                        Cli::break(2);
                    } else {
                        Cli::textView(Cli::error('live key "'.Cli::warn($key).'" failed to delete.'));
                        Cli::break(2);
                    }
                }
                else{
                    Cli::textView(Cli::danger('Notice: ').'undefined key "'.Cli::warn($key).'"');
                    Cli::break(2);
                }
            }else{
                if(Livescript::set($key, $value)){
                    Cli::textView(Cli::valid($key).': '.Cli::danger('key configured successfully.'),);
                    Cli::break(2);
                }else{
                    Cli::textView(Cli::warn($key).': '.Cli::danger('key configuration failed.'),);
                    Cli::break(2);
                }
            }
        } else {

            Cli::textView(Cli::warn('Warning').': '.'invalid number('.count($args).') of max(3) arguments count.',);
            Cli::break(2);

        }

    }

    function addFile() {

    }

}