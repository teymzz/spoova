<?php

namespace spoova\core\commands;

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

            'add'            => 'add:[controller|window|model|winmodel|rex] [path] [extends?] [-O?]',
            'add:api'        => 'add:api <name> [extends?] [\subdir]',
            'add:frame'      => 'add:frame <name> [-S?] [-O?]',
            'add:model'      => 'add:model [path] [-O]',
            'add:rex'        => 'add:rex [path.?]<filename>',
            'add:window'     => 'add:window <path> [extends?] [-O?]',
            'add:route'      => 'add:route <path> [extends?] [-O?]',
            
            'backup'             => 'backup [project|:clear]',

            'config'             => 'config:<options> <args>',
            'config:dbonline'    => 'config:dbonline dbuser dbpass dbserver dbport dbsocket',
            'config:dboffline'   => 'config:dboffline dbuser dbpass dbserver dbport dbsocket',
            'config:usersTable'  => 'config:usersTable <name>',
            'config:cookieField' => 'config:cookieField <name>',
            'config:idField'     => 'config:idField <name>',
            'config:watch'       => 'config:watch [online|offline|both|disabled]',
            'config:watcher'     => 'config:watcher',
            'config:meta'        => 'config:meta',
            'clean'              => 'clean storage',

            'cli'                => 'cli',

            'classes'            => 'classes',

            'features'           => 'features',

            'functions'          => 'functions',

            'info'               => 'info <[version|features|support|cli|functions]|:command>',
            
            'install'        => 'install|install:[app|db|dbname]',
            'install:app'    => 'install:app',
            'install:db'     => 'install:db',
            'install:dbname' => 'install:dbname',

            'project'        => 'project <project_name>',

            'support'        => 'Display current spoova supports',

            'version'        => 'Displays spoova current version',

            'watch status'   => 'Returns the watch current settings',

        ];

    }

    private function hasSyntax($syntax) {

        return (isset($this->syntaxes()[$syntax]));

    }

}