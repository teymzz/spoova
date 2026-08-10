<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli\CliCat;
use spoova\mi\core\commands\Support\Handlers\Syntax;
use spoova\mi\core\commands\Root\Root;
use spoova\mi\core\commands\Root\Entry;

class MiCommands {

    /**
     * Undocumented function
     *
     * @param mixed $commands commands parsed
     * @param array $types retrieved from {@see Entry::main} and {@see Entry::root}
     */
    function __construct(mixed $commands, private array $types, private Entry $entry)
    {
        $command = ($commands)? $commands[0] : '';
        $tolower = strtolower((string)$command);

        $isCat = preg_match('/^(cat(?:d|x|i)?::)/', $command, $matches);

        if($command){

            if($isCat){ 
    
                // cat::, cati::, catd::, catx::
                return $this->handle_cats($matches[1], $command, $commands);
    
            }elseif(in_array($tolower, $types['root'])){
    
                /* Handle Root Commands (cli, cli -lists, ) */
                return $this->handle_roots($command, $commands);
            }else{
            
                $this->handle_support($command, $tolower, $commands);  

            }

        }

    }

    /**
     * Base handler method for all cat:: commands.
     *
     * @param string $cat name of cat command (i.e cat, cati, catd, catx)
     * @param string $command command received on cat
     * @param array $commands all commands received.
     * @return void
     */
    private function handle_cats(string $cat, string $command, array $commands){
        // new CliCat($cat, $command, $commands);
        return;
    }

    /**
     * Handles root CLI commands such as cli, and all other commands available from {@see Root::commands}. 
     * These commands mostly do not take extra arguments except the 'cli' which takes a '-list' flag.
     *
     * @param string $command
     * @param array $commands
     * @return bool
     */
    private function handle_roots(string $command, array $commands) : bool {

            if($command !== 'cli' && count($commands) > 1) {
                return Cli::response(false, 'Invalid argument count!', 'Error');
            }

            if($command === 'cli'){
                
                if(($commands[1]??'') === '-lists'){
                    Cli::clearUp(1000)->cls();
                    new Syntax(['-lists']);
                }elseif(count($commands) > 1){
                    return Cli::response(false, 'Invalid argument count!', 'Error');
                }
            }
            Cli::clearUp(1000)->cls();
            
            new Root($commands[0]);

            return true;
    }

    /**
     * Handles all commands from the commands support directory.
     *
     * @param string $command
     * @param string $tolower
     * @param array $commands
     * @return void
     */
    private function handle_support(string $command, string $tolower, array $commands){
        Cli::clearUp(1000)->cls();

        if(in_array($tolower, $this->types['main'])) {

            if($this->support_makes($command, $commands)) return ;
            $this->entry->addError('command '.implode(' ', $commands).' cannot be executed');

        } 

        if(strpos($command,":") != false) {
            $exp = explode(':', $command);    
            if(count($exp) === 2){
                array_shift($commands);
                array_unshift($commands, $exp[0], $exp[1]);
                $command = $exp[0];
            }
        }

        // Handle other supports declared as class in default Support directory
        array_shift($commands);
        $arguments = array_values($commands);
        $class = scheme('core\commands\Support\\'.$command);

        if(!$this->support_base($class, $arguments)){
            if($command) array_unshift($commands, $command);
    
            if($commands){
                Cli::textView(Cli::warning(' command "'.Cli::warn(implode(' ', $commands)).'" not recognized', '2'));
                Cli::textView('Type:'.$this->entry::mi('cli -lists', '', '', '').' to see a list of available commands.', '4');
            }  
        }
    }

    private function support_makes(string $command, array $commands) : bool {
        array_shift($commands);
        $arguments = array_values($commands);

        $command = $command === 'use'? 'Make\MkUse' : $command;
        
        $class = scheme('core\commands\Support\\'.$command, false);

        if(@class_exists($class)){
            if($class::latent_mode === true) Cli::silentErrors();
            (new $class($arguments));
            return true;
        }
        return false;
    }


    private function support_base(string $class, array $arguments) : bool {
        if(@class_exists($class)){
            if($class::latent_mode === true) Cli::silentErrors();
            (new $class($arguments));
            return true;
        }
        return false;
    }
    

}