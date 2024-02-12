<?php

//include core framework
include_once 'icore/filebase.php';

use spoova\mi\core\commands\Root\Root;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\commands\Root\Syntax;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\FileManager;
use spoova\mi\core\classes\Init;

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
        
        parent::__construct($appName); //sets the app name

        if(!$this->commands){ 
            if($commands = self::commands()){

                $this->commands = $commands;
                return;

            }else{
                $this->cls();

                (new Root('version')); 

                Cli::clearUp(2);
                
                Cli::textView('Type '.self::mi('cli','','').' to see a list of commands', 0, 2, 3).Cli::break(2);
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

        $command = ($commands)? $commands[0] : '';
        $tolower = strtolower((string)$command);

        $catDescs = ['cati::','catd::','catx::'];

        if(($isCat = (substr($command, 0, 5) === 'cat::')) || in_array(($catx = substr($command, 0, 6)), $catDescs)){

            $cat = ($isCat)? 'cat::' : $catx;

            $base = $command;
            $command = explode($cat, $command, 2)[1] ?? '';
            $command = ucfirst($command);

            //invalid control directories ...
            $reserved_directories = ['core','icore','migrations','res','vendor','windows'];

            $commands_directory = Init::key('CONSOLE_DIRECTORY', 'commands');

            $control_directory = docroot.DS.$commands_directory.DS;

            if(in_array($commands_directory, $reserved_directories)) {
                
                Cli::clearUp();
                Cli::break(2);
                Cli::textView(Cli::error('commands directory "'.Cli::warn($commands_directory).'" is reserved.'));
                Cli::break(2);

            }else if(is_dir($control_directory)){
                
                $controlSpace = scheme('commands');

                $appSpace = $commands_directory.'\\'.$command;
                $controller = $controlSpace.'\\'.$command;

                if(appExists($appSpace)) {
                    //parse other arguments ...

                    $args = $commands;

                    //resort arguments ... 
                    unset($args[0]); $args = array_values($args);

                    if(method_exists($controller, 'setCat')){
                        $controller::setCat($cat);
                    }

                    if(method_exists($controller, 'validate_console') && method_exists($controller, 'isAuto')){
                        
                        if($controller::isAuto()){
                            if($method = $controller::validate_console($args)){
                                $arg = $args[count($args)-1];
    
                                $class = new $controller();
    
                                if(is_array($method)){
                                    $args = $method;
                                    $method = $args[0];
                                    unset($args[0]); array_values($args);
                                    if(method_exists($controller, $method)){
                                        $class->$method($args);
                                    }else{
                                        Cli::textView(Cli::error('missing control method('.Cli::warn($method).') for "'.Cli::warn($arg).'"'));
                                        Cli::break(2);
                                    }
                                }elseif(method_exists($controller, $method)){
                                    $class->$method($arg);
                                } else {
                                    Cli::textView(Cli::error('missing control method('.Cli::warn($method).') for "'.Cli::warn($arg).'"'));
                                    Cli::break(2);
                                    return;
                                }
                            }else{
                                return;
                            }
                        } else {
                            $class = new $controller($args);
                            $cats = $class->getCats();
                            $cat = substr($cat, 0, -2);
             
                            $method  = $cats[$cat] ?? '';

                            if(!method_exists($class, $method)){
                                $meth = $method ? '('.Cli::warn($method).')' : '';
                                Cli::break();
                                Cli::textView(Cli::error('missing controller method'.$meth.' for "'.Cli::warn($base).'"'));
                                Cli::break(2);
                                return;
                            }
                            $class->$method($args);

                        }
                    }else{
                        $class = new $controller($args);
                    }

                } else {

                        
                    Cli::clearUp();
                    Cli::break(2);
                    Cli::textView(Cli::danger(Cli::emo('point-list').' php mi '.Cli::warn($base)));
                    Cli::break(2);
                    Cli::textView(Cli::error('unrecognized command ['.Cli::warn($base).']'));
                    Cli::break(2);

                }

            } else {
                Cli::clearUp();
                Cli::break(2);
                Cli::textView(Cli::error('commands directory "'.Cli::warn($commands_directory).'" does not exist.'));
                Cli::break(2);
            }

            
            return ;
        }

        /* Handle Root Commands */
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
                
                $class = scheme('core\commands\Root\\'.$command, false);

                if(@class_exists($class)){
                    (new $class($arguments));
                    return;
                }
                $this->addError('command '.implode(' ', $commands).' cannot be executed');
            
            }   

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
            $class = scheme('core\commands\Root\\'.$command);
        
            if(@class_exists($class)){
                (new $class($arguments));
                return;
            } else {
                if($command) array_unshift($commands, $command);
        
                if($commands){
                    $this->display(Cli::warning(' command "'.Cli::warn(implode(' ', $commands)).'" not recognized', 2));
                    $this->display('Type'.self::mi('cli -lists', '', '', '').' to see a list of available commands.', 4);
                }
            }            
        }
        
            
    }

    /**
     * @inheritDoc \core\commands\Root\console
     *
     * @return void
     */
    public function run(){
        /* start development server */
        if(self::commands(0) == 'start'){
            self::start(); 
            return;
        } 
        parent::cliRun();        
    }

}

(new spoova('spoova'))->run();