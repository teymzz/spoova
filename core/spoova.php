<?php

//secure file access
if(!is_file('icore/filebase')) header('location:../');

//include core framework
include_once 'icore/filebase.php';

use spoova\core\commands\Info;
use spoova\core\commands\Root;
use spoova\core\commands\Entry;
use spoova\core\commands\Syntax;
use spoova\core\classes\FileManager;
use spoova\core\commands\Anime;

class spoova extends Entry{

    protected array $args = [];
    protected array $commands = [];

    /**
     * To detect if console is connected successfully
     *
     * @param string $appName
     */
    public function __construct($appName = '') {

        clearstatcache();

        if(!isCli()) redirect('/');
        
        parent::__construct($appName);

        if(!$this->commands){ 
            if($commands = self::commands()){

                $this->commands = $commands;
                return;

            }else{
                $this->cls();
                
                Anime::textView('', 0, 1);

                (new Root('version')); 
                
                Anime::textView('Type "spoova cli" to see a list of commands', 0, 2);
            }
        }

    }

    /**
     * start development server
     *
     * @return void
     */
    private function start(){

        $document_root = dirname(__DIR__);
        $pwd = $_SERVER['PWD'];
        $root = dirname($pwd);
        
        self::log('..spoova started successfully');
        
        //fetch configuration
        $FileManager = new FileManager;

        $FileManager->setUrl(self::init_url());
        
        if($FileManager->openFile()){

            //read the init file
            
            $init_config = $FileManager->readFile(
                ['RESOURCE_WATCH', 'SETUP_COMPLETE']
            );
            
            $watch  = (int) $init_config['RESOURCE_WATCH'];
            $status = (int) $init_config['SETUP_COMPLETE']; 

            $watchdog = ($watch == 1) ? ('offline (enabled)') : (($watch === 2)? 'online (enabled)' : 'disabled'); 
            
            $watch  = "  live server mode : ".$watchdog;

            $status = "  setup status : ".$status;
        
            self::log(' ');
            self::log($watch);
            self::log($status);
            self::log(' '); //add line break
        }

        //start development server
        exec('php -S localhost:8080 -t '.$document_root, $output);
    }

    /**
     * execute commands
     *
     * @param array $commands list of commands
     * @return void
     */
    protected function execute(array $commands = []){

        $command = ($commands)? $commands[0] : null;
        $tolower = strtolower($command);
    

        /* Handle Root calls */
        if(in_array($tolower, self::root)){

            if($command == 'cli' && count($commands) == 2){

                if($commands[1] == '-lists'){

                    $this->cls();
                    new Syntax(['-lists']);
                    return;

                }

            } else if(count($commands) > 1) {
                $this->display('Error: Invalid argument count!', 2);
                return;
            } else {

                $this->cls();
               
                new Root($commands[0]);

                return;

            }
        }

        if($command){
            $this->cls();

            if(in_array($tolower, self::main)){
            
                array_shift($commands);
                $arguments = array_values($commands);
                
                $class = 'spoova\core\commands\\'.$command;

                // $this->loading();
                // sleep(50);
                if(@class_exists($class)){
                    (new $class($arguments));
                    // $this->loading('', false);
                    return;
                }
                $this->addError('command '.implode(' ', $commands).' cannot be executed');
            
            }   

            // /* Handle Info */
            // if(in_array($command, self::info)){
            //     array_shift($commands);
            //     $arguments = array_values($commands);
            //     $command = $command;
            //     (new Info)->$command($arguments);
            //     return;            
            // }

            if(strpos($command,":") != false) {
                $exp = explode(':', $command);    
                if(count($exp) === 2){
                    array_shift($commands);
                    array_unshift($commands, $exp[0], $exp[1]);
                    $command = $exp[0];
                }
            }

            array_shift($commands);
            $arguments = array_values($commands);
            $class = 'spoova\core\commands\\'.$command;
        
            if(@class_exists($class)){
                (new $class($arguments));
                return;
            } else {
                if($command) array_unshift($commands, $command);
        
                if($commands){
                    $this->display('Warning: command "'.implode(' ', $commands).'" not recognized', 2);
                }
            }            
        }
        
            
    }

    /**
     * @inheritDoc \core\commands\console
     *
     * @return void
     */
    public function run(){

        /* start development server */
        if(self::commands(0) == 'start'){
            self::start(); 
            return;
        } 
        parent::run();        
    }

}

(new spoova('spoova'))->run();