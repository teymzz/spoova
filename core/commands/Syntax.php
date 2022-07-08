<?php

namespace spoova\core\commands;

class Syntax extends Entry{

    function __construct($args)
    {
        if(count($args) != 1) {
            $this->display('Warning: expecting exactly one(1) argument!'); 
            $this->display('>> Syntax <name>', 2); 
            return; 
        }

        if($this->hasSyntax($args[0] ?? '')){
            $this->display("Syntax >> ".$this->syntaxes()[$args[0]], 2);
        } elseif(($args[0]??'') == '-lists'){
            $this->lists();
        } else {
            $this->display("No available syntaxes for this command!");
            $this->display(">> Type: \"syntax -list\" to see a list of available syntaxes ", 2);
        }
    }

    public function lists(){

        foreach ($this->syntaxes() as $syntax => $structure) {
            if($structure){
                $this->display($syntax .' => '. $structure, 2);
            }
        }

        Anime::textView('Type "spoova info <command>" to see description', 0, 2);

    }


    public function syntaxes() : array {

        return [

            'add'            => 'add:[controller|window|model|winmodel|rex] [name] [path]',
            'add:controller' => 'add:controller <name> [path]',
            'add:window'     => 'add:window <name> [path]',
            'add:model'      => 'add:model <name> [path]',
            'add:winmodel'   => 'add:winmodel <name> [subdir_path]',
            'add:rex'        => 'add:rex [path].<filename>',

            'config'             => 'config:<options> <args>',
            'config:dbonline'    => 'config:dbonline dbuser dbpass dbserver dbport dbsocket',
            'config:dboffline'   => 'config:dboffline dbuser dbpass dbserver dbport dbsocket',
            'config:usersTable'  => 'config:usersTable <name>',
            'config:cookieField' => 'config:cookieField <name>',
            'config:idField'     => 'config:idField <name>',
            'config:watch'       => 'config:watch [online|offline|both|disabled]',
            'config:watcher'     => 'config:watcher',
            'config:meta'        => 'config:meta',

            'cli'                => 'cli',

            'classes'            => 'classes',

            'classes_methods'    => 'classes_methods',

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

        ];

    }

    private function hasSyntax($syntax) {

        return (isset($this->syntaxes()[$syntax]));

    }

}