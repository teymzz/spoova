<?php

namespace spoova\mi\core\commands;

/**
 * This class contains all spoova cli syntaxes
 */
class Syntax extends Entry{

    function __construct($args)
    {
        if(count($args) != 1) {
            $this->display(Cli::color('WARNING:').' expecting exactly one(1) argument!'); 
            self::mi('Syntax', 2).Cli::warn('name', 1); 
            return; 
        }

        if($this->hasSyntax($args[0] ?? '')){
            $this->display("Syntax >> ".$this->syntaxes()[$args[0]], 2);
        } elseif(($args[0]??'') == '-lists'){
            $this->lists();
        } else {
            $this->display("No available syntaxes for this command!");
            Cli::textView(Cli::emo('ribbon-arrow')."Type: \"syntax ".Cli::danger('-list')."\" to see a list of available syntaxes", 2);
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

        foreach ($this->syntaxes() as $syntax => $structure) {
            if($structure){
                $this->display(Cli::color($syntax, 'red') .' => '. $structure, 2);
            }
        }

        Cli::textView('Type '.self::mi('info').Cli::danger('<command>','1').' to see description. Use quotes for spaces.', 0, '|2');

    }


    public function syntaxes() : array {

        return [

            'add'            => 'add:[window|route|model|api|frame|rex] [path] [extends?] [-O?]',
            'add:api'        => 'add:api <path> [extends?] [\subdir] [-O?]',
            'add:frame'      => 'add:frame <path> [extends?] [-O?]',
            'add:model'      => 'add:model <path> [-O]',
            'add:route'      => 'add:route <path> [extends?] [\subdir] [-O?]',
            'add:rex'        => 'add:rex [path.?]<filename>',
            'add:window'     => 'add:window <path> [extends?] [-O?]',
            'add:route'      => 'add:route <path> [extends?] [-O?]',
            'add:migator'    => 'add:migrator <name>',
            
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
            'clean'              => 'clean storage',

            'cli'                => 'cli',

            'features'           => 'features',

            'info'               => 'info <command>',

            'migrate'          => 'migrate [up|down|status]',
            
            'install'        => 'install:[db|dbname]',
            'install db'     => 'install db [folder?]',
            'install dbname' => 'install dbname [folder?]',

            'project'        => 'project <project_name>',
            
            'start'          => 'start',
            'support'        => 'support',

            'version'        => 'version',

            'watch'          => 'watch [online|offline|both|disabled]',

            'watch disable'  => 'watch disable',
            'watch offline'  => 'watch offline',
            'watch online'   => 'watch online',
            'watch status'   => 'watch status',

        ];

    }

    private function hasSyntax($syntax) {

        return (isset($this->syntaxes()[$syntax]));

    }

}