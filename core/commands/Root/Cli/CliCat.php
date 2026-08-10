<?php

namespace spoova\mi\core\commands\Root\Cli;

use ReflectionMethod;
use ReflectionNamedType;
use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;
use spoova\mi\core\classes\Init; 
use spoova\mi\core\commands\Consoler\Consoler;
use spoova\mi\core\commands\Root\Cli;

/**
 * This class forms the base for all cat commands 
 * 
 * @uses Consoler
 */
class CliCat {


    public function __construct(string $cat, string $command, array $arguments)
    {

            $base = $command;

            $command = explode($cat, $command, 2)[1] ?? '';
            $command = ucfirst($command);
            $commands = $arguments;

            //invalid controller directories ...
            $reserved_directories = ['core','icore','migrations','res','vendor','windows'];

            $commands_directory = Init::key('CONSOLE_DIRECTORY', 'commands');

            $control_directory = docroot.DS.$commands_directory.DS;

            if(in_array($commands_directory, $reserved_directories)) {

                Cli::cls();
                Cli::break(1);
                Cli::headerView('php mi '.Cli::warn(basename($base)), break: 2);
                Cli::textView(Cli::error('init commands directory "'.Cli::warn($commands_directory).'" is reserved.'), break: 1);
                Cli::response(false, 'Failed to execute from a reserved directory!');

            }else if(is_dir($control_directory)){

                $controlSpace = scheme('commands');

                $appSpace = $commands_directory.'\\'.$command;
                
                /**
                 * @var Consoler|string $controller <TClass>
                 */
                $controller = $controlSpace.'\\'.$command;

                if(appExists($appSpace)) {

                    /** @var array */
                    $args = $commands;

                    // resort arguments ... 
                    unset($args[0]); $args = array_values($args);

                    if(method_exists($controller, 'setCat') && is_callable([$controller, 'setCat'])){
                        $controller::setCat($cat); // set cat command (available on Controller::setCat())
                    }

                    if(method_exists($controller, 'validate_console') && method_exists($controller, 'isAuto')){

                        if($controller::isAuto()){ 
                            $this->handleAutoCommands($controller, $args);
                        } else {
                            $this->handleInterfacedCommands($base, $cat, $controller, $args);
                        }

                    }else{
                        $this->handleDirectClass($controller, $args);
                    }

                } else {
                        
                    Cli::cls();
                    Cli::response(false);
                    Cli::headerView('php mi '.Cli::warn(basename($base)), break: 1);
                    Cli::textView(Cli::error('unrecognized command ['.Cli::warn($base).']'), break: '1|1');

                }

            } else {
                Cli::cls();
                Cli::response(false);
                Cli::textView(Cli::error('command directory "'.Cli::warn($commands_directory).'" does not exist.'));
                Cli::break(2);
            }

            return;
    }

    /**
     * Handles all automatic commands 
     *
     * @param Consoler|string $controller namespace of {@see Consoler}
     *  - Note type hinting was used for IDE intellisense
     * @param array $args prepared arguments from commands
     * @return void
     */
    private function handleAutoCommands($controller, array $args){

        // set auto interfaced controllers to use custom methods
        if($method = $controller::validate_console($args)){
            $arg = $args[count($args)-1]; // string argument
            
            $class = new $controller(); // instantiate the custom Auto controller

            if(is_array($method)){

                // parse method and arguments
                $args = $method;
                $method = $args[0];
                unset($args[0]); $args = array_values($args); // filter out and resort arguments

                if(method_exists($controller, $method)){
                    $class->$method($args); // parse only arguments to method (try resolving this with dependency)
                }else{
                    Cli::response(false);
                    Cli::textView(Cli::error('missing control method('.Cli::warn($method).') for "'.Cli::warn($arg).'"'), break: 1);
                }
            }elseif(method_exists($controller, $method)){
                $class->$method($arg); // parse the method as the only argument
            } else {
                Cli::response(false);
                Cli::textView(Cli::error('missing control method('.Cli::warn($method).') for "'.Cli::warn($arg).'".'), break: 1);
            }
        }
    }

    /**
     * Handle interfaced commands
     *
     * @param string $base base of command called.
     * @param string $cat cat typed called.
     * @param Consoler|string $controller
     *  - Type hinting was used for IDEs intellisense
     */
    private function handleInterfacedCommands(string $base, string $cat, $controller, array $args){
        // set non-auto interfaced controllers to use argument
        $class = new $controller($args);
        $cats = $class->getCats();
        $cat = substr($cat, 0, -2);

        $method  = $cats[$cat] ?? '';

        if(method_exists($class, $method)) return $class->$method($args);
        
        $meth = $method ? '('.Cli::warn($method).')' : '';
        Cli::response(false);
        Cli::textView(Cli::error('missing controller method'.$meth.' for "'.Cli::warn($base).'"'), break: '1|1');
    }

    /**
     * Handles direct custom classes that are not Auto or Interfaced.
     *
     * @param string $controller namespace of class to be triggered
     * @param array $args argumented parsed.
     * @return void
     */
    private function handleDirectClass(string $controller, array $args){
        if(defined("$controller::latent_mode")){
            if($controller::latent_mode === true){
                Cli::silentErrors(true); // disable (silence) warning errors before initializing class. (fatal error remains enabled)
                new $controller($args);
                Cli::silentErrors(false);
                Cli::consoleErrors(true); // ensure that all silent errors are always displayed. (displaying undisplayed errors later)
            }else{
                Cli::silentErrors(false); // enable all errors before initializing class.
                new $controller($args);
            }
        }else{
            //Cli::silentErrors(true);
            new $controller($args);
            HandleCliErrors::consoleErrors(false, false);
        }
    }

}