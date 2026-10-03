<?php

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Container\Container;
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


    public const latent_mode = false; /* defined to silent errors */

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
                            /* Consoler Commands handled automatically with Consoler setOps */
                            $this->handleAutoCommands($controller, $args);
                        } else {
                            /* Consoler Commands handled manually with custom defined cat methods */
                           $this->handleInterfacedCommands($base, $cat, $controller, $args);
                        }

                    }else{
                         /* Commands handled using raw direct class without extension to Consoler */
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

            if (defined("$controller::latent_mode")) {
                /** @var CliCat $controller  */
                Cli::silentErrors($controller::latent_mode, forceBreak: true);
            }  
                      
            $class = new $controller(); // instantiate the custom Auto controller (Consoler)

            if(is_array($method)){

                // parse method and arguments with ellipsis
                $args = $method;
                $method = $args[0];
                unset($args[0]); $args = array_values($args); // filter out and resort arguments
        
                if(method_exists($controller, $method)){
                    self::resolveMethod($class, $method, $args, 'consoler_arguments');
                }else{
                    Cli::response(false);
                    Cli::textView(Cli::error('missing control method('.Cli::warn($method).') for "'.Cli::warn($arg).'"'), break: 1);
                }
            }elseif(method_exists($controller, $method)){
                self::resolveMethod($class, $method, $args, 'consoler_method');
            } else {
                Cli::response(false);
                Cli::textView(Cli::error('missing control method('.Cli::warn($method).') for "'.Cli::warn($arg).'".'), break: 1);
            }
        }
    }

    /**
     * Handle interfaced commands. Commands extended to Consoler but where auto is disabled and cat handler methods are defined manually,
     *   - These commands are execute through formatting the cat method triggers.
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

        if(method_exists($class, $method)){ 
            if (defined("$class::latent_mode")) {
                /** @var CliCat $class  */
                Cli::silentErrors($class::latent_mode, forceBreak: true);
            }
            return self::resolveMethod($class, $method, $args, 'consoler_formatter');
        }
        
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

        Cli::break(1); // applies line break after command is executed
        if(defined("$controller::latent_mode")){

            if($controller::latent_mode === true){
                Cli::silentErrors(true); // disable (silence) warning errors before initializing class. (fatal error remains enabled)
                Cli::silentErrors(forceBreak: true);
                self::resolveClass($controller, $args, 'direct_lantent_mode');
                Cli::silentErrors(false);
                Cli::consoleErrors(true); // ensure that all silent errors are always displayed. (displaying undisplayed errors later)
            }else{
                Cli::silentErrors(false); // enable all errors before initializing class.
                self::resolveClass($controller, $args, 'direct_lantent_none');
            }
        }else{
            self::resolveClass($controller, $args, 'direct_free_mode');
            HandleCliErrors::consoleErrors(false, false);
        }
    }

    /**
     * Resolve command methods with dependencies
     *
     * @param  object|string $class namespace of {@see Consoler}
     * @param string $method
     * @param array $args
     * @param string $handler Recieved as : 
     *    - consoler_formatter : Consoler command's handled using cat control methods' trigger.
     *    - consoler_arguments : Consoler command's handled using setOps argument parser. 
     *    - consoler_method : Consoler command's handled using direct method trigger.
     * @return mixed
     */
    private static function resolveMethod($class, string $method, array $args, string $handler){
        HandleCliErrors::launch();
        Container::instance()->with('dependencies?')->dispatch($class::class, $args); // use dependencies method to resolve if it exists
        return Container::instance()->callMethod($class, $method, $args); // using container to handle method
    }

    private static function resolveClass(string $class, array $args, string $handler){
        HandleCliErrors::launch();
        $Container = Container::instance();
        $Container->with('dependencies?')->dispatch($class); // use dependencies method to resolve if it exists
        $Container->make($class, [$args]);
        HandleCliErrors::consoleErrors(false, false);
    }

}