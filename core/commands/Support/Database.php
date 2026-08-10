<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\Init;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliList;
use spoova\mi\core\commands\Root\Cli\CliPrompt;
use spoova\mi\core\commands\Root\Cli\CliPulser;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliOffset;
use spoova\mi\core\commands\Root\Cli\CliQuery;
use spoova\mi\core\classes\ErrorHandlers\GhostCliMsg;

/**
 * This cla
 */
class Database{

    function __construct(array $args){

        if(online){
            Cli::headerView('database message:', break: 1);
            return Cli::response(false, 'This operation is not available in this environment');
        }
        
        Cli::textView(Cli::danger(Cli::emos('point-list', 1).'database '), break: 2);

        $lists = ['create database?', 'check if database exists?', 'set database config?'];
        Cli::infoView('query','what will you like to do? ', color: '|danger', break: 2);
        Cli::List($lists, break: 1, callback: function(CliList $list){
              Cli::pulseView($list->sn().'. '.$list->value(), 100, fn(CliPulser $pulse) =>
                $pulse->offset(4, function(CliOffset $posix){
                    return Cli::warn($posix->char());
                })
              );
              Cli::wait(500);
        });
        Cli::break(1);
        Cli::textView('option [');
        Cli::List($lists, callback: fn(CliList $list)=> $list->sn().',');
        Cli::back();
        Cli::textView(']? ');

        $option = Cli::prompt([1, 2, 3], function(CliPrompt $prompt){

           if($prompt->invalid() && $prompt->inactive()) {
                Cli::response(false, 'program terminated due to invalid option!');
                Cli::exit();
           }

        }, 1)->i();

        if($option === '1'){
            Cli::cls();
            Cli::headerView('database:', break : 2);
            Cli::pulseView('checking database connection ...', 10000)-> pulseToggle(3, 10);
            Cli::clearLine();
            
            [$dbuser, $dbpass, $dbserver, $dbport, $dbsocket] = [DBUSER, DBPASS, DBSERVER, DBPORT, DBSOCKET];
            
            $db = new DB();
            
            if(!($dbTool = $db->openTool([$dbuser, $dbpass, $dbserver, $dbport, $dbsocket]))) {
              return Cli::errorView('database connection failed '.Cli::valid('✔'))->pause(1)->clearLine(); 
            }

            Cli::hideCursor();
            Cli::textView('database connection successful '.Cli::valid('✔'))->pause(1)->clearLine(); 
            Cli::showCursor();
            Cli::textView('database name: ');

            $continue = false;
            $name = Cli::prompt(terminate: true);

            $continue = preg_match('/^[a-zA-Z_][a-zA-Z_0-9]+$/', $name);

            if(!$continue) {
                Cli::response(false, 'Program terminated due to invalid name.');
                exit;
            }
           
            // create the database.

            if($dbTool->db_exists($name)){
                return Cli::response(false, 'database name "'.Cli::warn($name).'" exists!');
            }elseif(!$dbTool->error(true) && $dbTool->createDB($name)){
                Cli::textView('database "'.Cli::warn($name).'" created successfully!');
                Cli::break(1);
            }elseif($dbTool->error(true)){
                Cli::textView(Cli::danger($dbTool->error(true)), break: '1|1');
            }

            return ;
        }else if($option === '2'){
            Cli::clearUp(9);
            Cli::headerView('database check: ', break : 2);
            Cli::pulseView('checking database connection ...', 10000)-> pulseToggle(3, 10);
            Cli::clearLine();
            
            [$dbuser, $dbpass, $dbserver, $dbport, $dbsocket] = [DBUSER, DBPASS, DBSERVER, DBPORT, DBSOCKET];
            
            $db = new DB();
            
            if(!($dbTool = $db->openTool([$dbuser, $dbpass, $dbserver, $dbport, $dbsocket]))){
              Cli::errorView('database connection failed.')->pause(1)->clearLine(); 
              return Cli::errorView('process aborted due to failed connection.');
            }

            Cli::showCursor();
            
            $name = Cli::textView('database name: ')->prompt();

            $continue = false;
            $continue = preg_match('/[a-zA-Z0-9][\w+]+/', $name);

            if(!$continue) return Cli::response(false, 'Program terminated due to bad database name.');
           
            // create the database.

            if($dbTool->db_exists($name)){
                return Cli::response(false, function(GhostCliMsg $msg) use($name) {
                   $msg->onInfo('database name "'.Cli::valid($name).'" exists!', color: "#158315|white");
                });
            }else{
                return Cli::response(false, 'cannot find database "'.Cli::warn($name).'"!');
            }

        }else if($option === '3'){
            Cli::cls();
            Cli::headerView('database configuration :', break: 2);

            Cli::textView('Please set the configuration parameters', break: 2);

            [$dbname, $dbuser, $dbpass, $dbserver, $dbport] = ['dbname:','dbuser:','dbpass:','server:','dbport:'];
            
            Cli::textView(Cli::warn($dbname).' '.Cli::dots(5, $dbname, ' '));
            $dbname = Cli::prompt(terminate: true) ?: '-';

            Cli::textView(Cli::warn($dbuser).' '.Cli::dots(5, $dbuser, ' '));
            $dbuser = Cli::prompt(terminate: true) ?: '-';
            
            Cli::textView(Cli::warn($dbpass).' '.Cli::dots(5, $dbpass, ' '));
            $dbpass = Cli::prompt(terminate: true) ?: '-';

            Cli::textView(Cli::warn($dbport).' '.Cli::dots(5, $dbport, ' '));
            $dbport = Cli::prompt(terminate: true) ?: '-';

            Cli::textView(Cli::warn($dbserver).' '.Cli::dots(5, $dbserver, ' '));
            $dbserver = Cli::prompt(terminate: true) ?: '-';

            $arguments = ['dboffline', "$dbname $dbuser $dbpass $dbserver $dbport"];

            Cli::cls();
            new Config($arguments);
        }

    }

    private function test10(){
        $options = ['yes','no','y','n','q']; // valid options to be entered.

        $trials = 3; //maximum number of failed trials before termination.

        $response = Cli::q($options, function(){

            return [
                'init' => function(CliQuery $input) {
                    
                    if($input->trials() > 0){
                        if($input->trials() > 1) Cli::clearUp();

                        Cli::clearLine();
                        Cli::textView('Please input a valid option or (q + Enter) to quit: ');
                    }else{
                        Cli::textView('Will you like to continue? [Y/N] ');
                    }
                },
                'test' => fn(CliQuery $input) => in_array(strtolower($input), ['y','yes']),
                'max' => fn() => Cli::textView( Cli::error('maximum reached!') ),
                'success' => fn(CliQuery $input) => $input,
                'failed' => fn(CliQuery $input) => !in_array(strtolower($input), ['y','yes','n','no','q']),
            ];

        }, 3);

        if(Cli::qValid()){
            print $response;
        }

        if(Cli::qFailed()){
            // Y or YES was not the submited input from user. 
            Cli::textView('The user input value is '.$response, break: 1);
        }
        if(Cli::qmax()){
            // Y or YES was not the submited input from user. 
            Cli::textView('Max reached! '.$response, break: 1);
        }
    }

    private function test9(){
        $options = ['y','n']; // input options acceptable.
        $trials = 3; // maximum trials before termination.
    
        $response = Cli::q($options, fn() =>  [

                'init' => fn() =>  Cli::textView("Will you like to continue? [Y/N] "),

                'test' => fn(CliQuery $input) => $input->matches(case_sensitive: false),

                'failed' => function(CliQuery $input){
                    if( !Cli::qmax() ) return !$input->matches(case_sensitive: false);
                } 

            ], $trials
        );

        if(Cli::qValid()){

            Cli::textView( Cli::success('input '.$response.' is valid') )->break(1);

        }elseif(Cli::qmax()){

            Cli::textView( Cli::error('maximum trials reached!') )->break(1);
            
        }else{ 
            
            Cli::textView( Cli::error('invalid options supplied!') )->break(1);

        }
    }

    private function test8() {

        $options = ['yes','no','y','n']; // valid options to be entered.

        $trials = 3; //maximum number of failed trials before termination.

        Cli::q($options, function(){

        return [
            'init' => function($input) {
                
                if($input->trials() > 0){
                    if($input->trials() > 1) Cli::clearUp();

                    Cli::clearLine();
                    Cli::textView('Please input a valid option or (q + Enter) to quit: ');
                }else{
                    Cli::textView('Will you like to continue? [Y/N] ');
                }
            },
            'test' => function($input) {
                return in_array(strtolower($input), ['y','yes','q']);
            },
            'max' => fn() => Cli::textView( Cli::error('maximum reached!') ),
            'success' => fn($input) => $input,
            'failed' => fn($input) => !in_array(strtolower($input), ['y','yes','n','no']),
        ];

        });
    }

    // Cli::prompt() tests .....................................................................................
    private function test7() {
    
        $options= ['Y', 'N', '::nocase'=>true];
    
        Cli::setText(Cli::textBuild("Will you like to continue? [Y/N] "));
    
        Cli::prompt($options, function(CliPrompt $prompt){

            if($prompt->maximum()) return Cli::textView('maximum reached!'); // terminate after maximum trials is exceeded.
            if($prompt->valid()) return Cli::textView( Cli::success('valid response obtained'), 0, "1|1");
      
            if(!$prompt->active()) return Cli::textView( Cli::error('maximum number of trials was exeeded!'), 0, "1|1");
                
            Cli::clearView(Cli::text()); // get saved text
    
            /* if($prompt->valid()){
                Cli::textView( Cli::success('valid response obtained'), 0, "1|1");
                return true;
            }

            if(!$prompt->trials('active')){
                Cli::textView( Cli::error('maximum reached after '.$prompt->trials().' trials'), 0, "1|1");
                return true;
            }

            Cli::clearView(Cli::text()); // get saved text */

            // if($prompt->invalid()){
            //     print 1;
            //     if($prompt->active()) {
            //         Cli::clearView(Cli::text()); // get saved text
            //     }else{
            //         Cli::textView(Cli::error('maximum number of trials was exeeded!'), 0, "1|1");
            //     }
            // }else{
            //     Cli::textView( Cli::success('valid response obtained'), 0, "1|1");
            // }

        }, 3);


        // if( Cli::promptIsMax() && Cli::promptInvalid() ) {

        //     Cli::textView( Cli::error('maximum number of trials was exeeded!'), 0, "1|1");

        // } elseif( Cli::promptInvalid() ) {

        //     Cli::textView( Cli::error('invalid response obtained'), 0, "1|1");      
            
        // }else{

        //     Cli::textView( Cli::success('valid response obtained'), 0, "1|1");  

        // }
    }

    private function test6() {
    
        $options= ['Y', 'N', '::nocase'=>true];
    
        Cli::setText(Cli::textBuild("Will you like to continue? [Y/N] "));
    
        $response = Cli::prompt($options, function(CliPrompt $prompt){

            if($prompt->valid()) return Cli::textView( Cli::success('valid response obtained'), 0, "1|1");
            if($prompt->maximum()) return Cli::errorView('maximum reached!', break: '1|1'); // terminate after maximum trials is exceeded.
            if($prompt->inactive()) return true; // terminate after maximum trials is exceeded.
            if($prompt->invalid()) Cli::clearView(Cli::text()); // get saved text

        }, 3);


        // if( Cli::promptIsMax() && Cli::promptInvalid() ) {

        //     Cli::textView( Cli::error('maximum number of trials was exeeded!'), 0, "1|1");

        // } elseif( Cli::promptInvalid() ) {

        //     Cli::textView( Cli::error('invalid response obtained'), 0, "1|1");      
            
        // }else{

        //     Cli::textView( Cli::success('valid response obtained'), 0, "1|1");  

        // }
    }

    private function test5() {

        $options = ['y','n', '::nocase' => true]; // specify options to allow all text casings (e.g lowercase, uppercase)

        //Cli::break(); // applies line break first 
        $response = Cli::prompt($options, function(CliPrompt $input){

            if($input->trials('active')){

                //if($input->trials() === 2) return true; // terminate after four trials.

                // Display this text before the first input attempt or when an invalid option is supplied 

                Cli::clearLine()->textView("Will you like to continue? [Y/N] ");

            }elseif($input->maximum()){
               Cli::textView('Ended because of max reached!', break: '1|1');
            }

        }, 3);
    }


    private function test4() {
        $options= ['y', 'n', '::nocase'=>true];
        Cli::break();
        $response = Cli::prompt($options, function(CliPrompt $input){

            if($input->trials('active')){

                Cli::clearLine()->textView("Will you like to continue? [Y/N] ", 0);

            }else{
                Cli::textView('Who'.Cli::errorView('Error: exited after 3 trials.', break: '1|1').'Hey', break: '1|1');
            }

        }, 3);

        print $response;
    }

    private function test3() {

        $options = [];  // when there are no options
        $response = Cli::prompt($options, function(CliPrompt $input){

            if($input->trials('active')){
                if($input->trials() === 2) return true; // run for 0, 1 prevents 2
                Cli::clearLine()->textView("Will you like to continue? [Y/N] ".$input->trials(), 0);
            }else{
                Cli::textView('maximum reached!');
            }

        });
    
        Cli::exit($response);
    }

    private function test2() {
        $response = Cli::prompt([], fn(CliPrompt $prompt) => $prompt->trials()?: Cli::clearView('Please write your name: '));
        print $response;
    }

    private function test1() {
       Cli::clearView('What is your name? '); 
       $name = Cli::prompt(); // prompt once and returns CLI user input
       print $name->i();
    }
}
