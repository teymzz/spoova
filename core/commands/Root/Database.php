<?php

namespace spoova\mi\core\commands\Root;

class Database{


    function __construct($args)
    {
        
        Cli::textView(Cli::danger(Cli::emos('point-list', 1).'database '), 0, '0|2');
        Cli::textView(Cli::warn('Notice: ').("This interactive environment is under development."), 0, "|2");
        return false;

        if($args){

            Cli::textView(Cli::danger(Cli::emos('point-list', 1).'database '), 0, '0|2');

            Cli::textView(Cli::error("No arguments expected for this interactive session."), 0, "|2");
            return false;
        }

        Cli::save(1, fn() => Cli::textView(Cli::alert("What will you like to do?"), 0, "|2"), true);


        $options = ['Add a database', 'Set configuration parameters'];
        
        Cli::List($options, "0", "|2");

        Cli::textView(Cli::emo('ribbon-arrow'), "4|1");

        $response = Cli::q(array_keys($options), fn() => 
            [
                'init' => fn() => '',
                'test' => fn($input, $options) => in_array($input, $options),
                'failed' => function() {
                    return false;
                }
            ]
        );

        if(Cli::qFailed()) {
            Cli::textView(Cli::error("process aborted because invalid option was selected."), 4, "1|2");
            return false;
        }
        //Cli::textView();



    }


}
