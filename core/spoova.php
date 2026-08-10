<?php

//include core framework
include_once 'icore/filebase.php';

use spoova\mi\core\commands\Root\Cli\CliCat;
use spoova\mi\core\commands\Root\Root;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\MiServer;
use spoova\mi\core\commands\Root\MiSupport;

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
                Cli::cls();
                Cli::cls(); (new Root('version'));
            }
        }

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

        /* Handle Cat Commands */
        $catDescs = ['cati::','catd::','catx::'];
        if(($isCat = str_starts_with($command, 'cat::')) || in_array(($catx = substr($command, 0, 6)), $catDescs)){

            $cat = ($isCat)? 'cat::' : ($catx ?? '');

            new CliCat($cat, $command, $commands);

            return;

        }

        /* Handle Root Commands */
        if(in_array($tolower, self::root)) return Root::initalize($commands);

        if($command){
            Cli::clearUp(1000);

            if(in_array($tolower, self::main)) {
                array_shift($commands);
                $command = $command === 'use'? 'Make\MkUse' : $command;
                $class = scheme('core\commands\Support\\'.$command, false);

                if(@class_exists($class)) return MiSupport::initialize($class, $commands, $command);
            }   

            if(strpos($command,":") != false) {
                $exp = explode(':', $command);    
                if(count($exp) === 2){
                    array_shift($commands);
                    array_unshift($commands, $exp[0], $exp[1]);
                    $command = $exp[0];
                }
            }
            
            /* Handle support commands through MiSupport class */
            array_shift($commands);
            $class = scheme('core\commands\Support\\'.$command);
            if(@class_exists($class)) return MiSupport::initialize($class, $commands, $command);

            /* Display error for other unsupported commands */
            if($command) array_unshift($commands, $command);
    
            if($commands){
                Cli::textView(Cli::warning(' command "'.Cli::warn(implode(' ', $commands)).'" not recognized'), break: '1|1');
                $this->display('Type:'.self::mi('cli -lists', '', '', '').' to see a list of available commands.', 4);
            }
        }
        
            
    }


    /**
     * @inheritDoc spoova\mi\core\commands\Root\console
     *
     * @return void
     */
    public function run(){

        $command = self::commands(0) ?? '';

        // Check and run development server syntax first 
        if(in_array($command, ['start', 'stop'])){
            new MiServer($command);
            return;
        }
        parent::cliRun();  // Console::cliRun(), self::execute().    
    }

}

(new spoova('spoova'))->run();