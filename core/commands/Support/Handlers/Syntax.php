<?php

namespace spoova\mi\core\commands\Support\Handlers;

use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

/**
 * This class contains all spoova cli syntaxes
 */
class Syntax extends Entry{

    function __construct(array $args)
    {
        if(count($args) != 1) {
            $this->display(Cli::color('WARNING:').' expecting exactly one(1) argument!'); 
            self::mi('Syntax', 2).Cli::warn('name', '1'); 
            return; 
        }

        if($this->hasSyntax($args[0] ?? '')){
            $this->display("Syntax >> ".$this->syntaxes()[$args[0]], 2);
        } elseif(($args[0]??'') == '-lists'){
            $this->lists();
        } else {
            $this->display("No available syntaxes for this command!");
            Cli::textView(Cli::emo('ribbon-arrow')."Type: \"syntax ".Cli::danger('-list')."\" to see a list of available syntaxes", '2');
        }
    }

    /**
     * Handle cli -lists directive. Print all cli commands with detailed description
     *
     * @return void
     */
    public function lists(){

        Cli::break();
        Cli::textView(Cli::danger(Cli::emos('point-list', 1).'cli -lists'), 0, '0|1');

        $length = 0;
        $function = new GhostFunction(['longest']);
        $function->longest(function($array) use(&$length) : int{
            $newlength = 0;
            foreach($array as $arr){
                $newlength = strlen($arr);
                if($newlength > $length){$length = $newlength;}
            }
            return $newlength;
        });

        $longest = $function->longest($this->syntaxes());

        foreach ($this->syntaxes() as $syntax => $structure) {
            if($structure){
                $this->display(Cli::color($syntax, 'warn') .' '. Cli::dots(25, $syntax) .' '. $structure, 2);
            }
        }




        Cli::textView('█ Type '.self::mi('info', pointer: 'colon'), break:'1');
        Cli::back(1);
        Cli::textView(Cli::danger('"<command>"','1').' to see description.', break: 1);

    }


    public function syntaxes() : array {

        return [

            'add'            => 'add:[window|route|model|api|frame|rex] [path] [extends?] [-O?]',
            'add:api'        => 'add:api <path> [extends?] [\subdir] [-O?]',
            'add:frame'      => 'add:frame <path> [extends?] [-O?]',
            'add:model'      => 'add:model <path> [-O]',
            'add:route'      => 'add:route <path> [extends?] [\subdir] [--live|--load?] [-O?]',
            'add:rex'        => 'add:rex [path.?]<filename>',
            'add:window'     => 'add:window <path> [extends?] [-O?]',
            'add:migator'    => 'add:migrator <name>',
            'add:seeder'     => 'add:seeder <name> count [-O|-I][:index]?',
            
            'backup'             => 'backup [project|:clear]',

            'config'             => 'config:<options> <args>',
            'config:all'         => 'config:all',
            'config:dbonline'    => 'config:dbonline "dbuser dbpass dbserver dbport dbsocket"',
            'config:dboffline'   => 'config:dboffline "dbuser dbpass dbserver dbport dbsocket"',
            'config:usersTable'  => 'config:usersTable <name>',
            'config:cookieField' => 'config:cookieField <name>',
            'config:idField'     => 'config:idField <name>',
            'config:watch'       => 'config:watch [online|offline|both|disabled]',
            'config:meta'        => 'config:meta',
            'config:init'        => 'config:init <key> <value>',
            'config:env'         => 'config:env <key> <value>',

            'clean'              => 'clean storage',

            'cli'                => 'cli',

            'database'           => 'database',

            'features'           => 'features',

            'info'               => 'info <command>',

            'logic'          => 'logic [standard|index|basic]',

            'migrate'        => 'migrate [up|down|status]',

            'notes'          => 'notes [<name>|:list|:view|:add|:save|:delete]',
            
            'routes'         => 'routes [--static?] [json?]',

            'seeder'         => 'seeder [seed|unseed] <table>[:index]?',

            'install'        => 'install:[db|dbname]',
            'install db'     => 'install db [folder?]',
            'install dbname' => 'install dbname [folder?]',

            'project'        => 'project <project_name>',
            'project sanitize' => 'project sanitize [-w|-r?] [-s?]',
            
            'start'          => 'start [port?]',
            'support'        => 'support',
            
            'use'            => 'use',
            'version'        => 'version',

            'watch'          => 'watch [online|offline|both|disabled]',

            'watch disable'  => 'watch disable',
            'watch offline'  => 'watch offline',
            'watch online'   => 'watch online',
            'watch status'   => 'watch status',

        ];

    }

    private function hasSyntax(string $syntax) : bool {

        return (isset($this->syntaxes()[$syntax]));

    }

}