<?php

namespace spoova\core\commands;

class Info extends Entry{

    function __construct($args)
    {
        if(count($args) != 1) {
            $this->display('Warning: expecting exactly one(1) argument!'); 
            $this->display('>> Syntax <name>', 2); 
            return; 
        }

        if($this->hasDesc($args[0] ?? '')){
            $this->display(Anime::emos('point-list', 1).$args[0].'  ');
            $this->display($this->descs()[$args[0]]);
        } else {
            $this->display(Anime::emos('crossmark', 1).$args[0]);
            $this->display("No available information for this command!");
            $this->display("This command may not exist.");
            $this->display("Type \"spoova cli -lists\" to see a list of commands");
        }
    }


    public function descs() : array {

        return [

            'add'            => 'Creates a new file
            
 Syntax >> add:[controller|window|model|winmodel|rex] [name] [path]',

            #---------------------               
            'add:controller' => 'Adds a controller class into controllers folder

 Syntax >> add:controller <name> [path]',
            
            #---------------------            
            'add:window'     => 'Adds a window class into windows folder

 Syntax >> add:window <name> [path]

 Note: When path is supplied, the path is assumed to be a subdirectory of windows folder.
            ',
            
            #---------------------            
            'add:model'      => 'Adds a model class into models folder. When path is supplied, 
the model file is placed into the direct path supplied.

 Syntax >> add:model <name> [path]',

            #---------------------            
            'add:winmodel'   => 'Using Models folder as its file directory, It adds a Model file (class)
into the windows folder or into the windows\' subdirectory path supplied.

 Syntax >> add:winmodel <name> [subdir_path]',


            #---------------------           
            'add:rex'        => 'Adds a new rex file into the rex template folder
            
 Syntax >> add:rex [path].<filename>
 
 Note 1: Path when supplied should be a subdirectory of the rex template folder

 Note 2: Paths can be supplied using dots while the last name is assumed to be file name',

            #---------------------
            'config'             => 'Sets default configuration parameters for database, meta tags and live server

 Syntax >> config:<options> <args>            

 <options> : [dbonline|dboffline|usersTable|cookieField|idField|watch|watcher|meta]
',
            
            #---------------------
            'config:dbonline'    => 'Sets online database default connection parameters. 

 Syntax >> config:dbonline dbname dbuser dbpass dbserver dbsocket

 Note: Replace empty value with dash.',

            #---------------------
            'config:dboffline'   => 'Sets offline database default connection parameters. 

 Syntax >> config:dboffline dbname dbuser dbpass dbserver dbsocket

 Note: Replace empty value with dash.',
 
            #---------------------
            'config:usersTable'  => 'Sets database table name to be used for collecting users data
            
 Syntax >> config:usersTable <name>',
            
            #---------------------            
            'config:cookieField' => 'Sets database column in usersTable to be used for storing cookie
            
 Syntax >> config:idField <name>',
            
            #---------------------            
            'config:idField'     => 'Sets database column in usersTable for storing a unique user id (e.g email, id, ...)

 Syntax >> config:cookieField <name>',
            
            #---------------------            
            'config:watch'       => 'Configures live server for offline or online development, This can also be disabled
            
 Syntax >> config:watch [online|offline|both|disabled]',
            
            #---------------------            
            'config:watcher'     => 'Returns the status of liveserver
            
 Syntax >> config:watcher',
            
            #---------------------            
            'config:meta'        => 'Allows or disallow the autoloading of environment meta tags by the resource class when importing static urls
    
 Syntax >> config:meta[on|off]',
            
            #---------------------
            'cli'                => 'Displays a list of spoova cli commands
            
 Syntax >> cli [-lists]
 
 Note: When "-lists" is supplied, it displays additional details of each listed commands',
            
            #---------------------
            'features'           => 'Displays a list of spoova features
            
 Syntax >> features',
            
            #---------------------
            'functions'          => 'Displays some spoova function

 Syntax >> features',      

            #---------------------
            'info'           => 'provides information or description about acceptable cli syntaxes or commands

 Syntax >> features',   
 
            #--------------------- 
            'install'        => 'installs project app or database parameters supplied

 Syntax >> install|install:[app|db|dbname]
 
 Note: when no option is supplied, it runs test to detect if current project has been fully configured',   
            
            #---------------------  
            'install:app'    => 'installs project pack

 Syntax >> install:app',       
      
            #---------------------  
            'install:db'     => 'Completes database paramters installation if all parameters are set.

 Syntax >> install:db',
 
            #---------------------  
            'install:dbname' => 'Creates a new non-existing database using default configuration parameters
            
 Syntax >> install:dbname',
 
            #---------------------
            'project'        => 'Creates a new project application
            
 Syntax >> project <project name>',

            #---------------------
            'version'        => 'displays the current spoova version
            
 Syntax >> version'

        ];

    }

    private function hasDesc($syntax) {

        return (isset($this->descs()[$syntax]));

    }

}