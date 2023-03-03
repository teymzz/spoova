<?php

namespace teymzz\spoova\core\commands;

class Desc extends Entry{

    function __construct($args)
    {
        if(count($args) != 1) {
            $this->display(Cli::color('WARNING:').' expecting exactly one(1) argument!'); 
            $this->display('>> Syntax <name>', 2); 
            return; 
        }

        if($this->hasDesc($args[0] ?? '')){
            $this->display($args[0]." >> ".$this->descs()[$args[0]], 2);
        } else {
            $this->display("No available description for this command!");
        }
    }


    public function descs() : array {

        return [

            'add'            => 'Creates a new file',
            'add:window'     => 'Adds a window class into windows folder',
            'add:model'      => 'Adds a model class into models folder. When path is supplied, 
               the model file is placed into the path supplied.',
            
            'add:winmodel'   => 'Using Models folder as its file directory, It adds a Model file (class) 
                  into the windows folder or into the windows\' subdirectory path supplied.',
            
            'add:rex'        => 'Adds a new rex file into the rex template folder',

            'config'             => 'Configures database parameters, meta tag and live server default options',
            'config:dbonline'    => 'Sets online database default connection parameters. All empty parameters should be replaced with dashes.',
            'config:dboffline'   => 'Sets offline database default connection parameters. All empty parameters should be replaced with dashes.',
            'config:usersTable'  => 'Sets database table name to be used for collecting users data',
            'config:cookieField' => 'Sets database column in usersTable to be used for storing cookie',
            'config:idField'     => 'Sets database column in usersTable for storing a unique user id (e.g email, id, ...)',
            'config:watch'       => 'Configures live server for offline or online development, This can also be disabled',
            'config:meta'        => 'Allows or disallow the autoloading of environment meta tags by the resource class when importing static urls',

            'cli'                => 'Displays a list of spoova cli commands',

            'clean:storage'      => 'Removes all unwanted storage files',

            'features'           => 'Displays a list of spoova features',

            'info'           => 'provides information or description about acceptable cli syntaxes or commands',
            
            'install'        => 'installs',
            'install:app'    => 'install:app',
            'install:db'     => 'install:db',
            'install:dbname' => 'install:dbname',

            'project'        => 'project <project name>'

        ];

    }

    private function hasDesc($syntax) {

        return (isset($this->descs()[$syntax]));

    }

}