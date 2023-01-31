<?php

namespace spoova\core\commands;

/**
 * This class contains basic information on avaialable cli commands
 */
class Info extends Entry{

    function __construct($args)
    {
        if(count($args) != 1) {
            $this->display(Cli::color('WARNING:', 'red').' expecting exactly one(1) argument!'); 
            $this->display('Syntax:'.self::mi('info', '','','').Cli::warn('<command>', 1), 2); 
            return; 
        }

        if($this->hasDesc($args[0] ?? '')){
            $this->display(Cli::danger(Cli::emos('point-list', 1).$args[0]));
            $this->display($this->descs()[$args[0]]);
        } else {
            $this->display(Cli::emos('crossmark', 1).$args[0]);
            $this->display('No available information for this command!');
            $this->display('This command may not exist or no description provided.');

            $this->display('Type '.self::mi('cli').Cli::danger('-lists', 1).' to see a list of commands', 1);
        }
    }


    public function descs() : array {

        return [

            'add'            => 'Creates a new file
            
 Syntax :'.self::mi('add:{options}','','','').Cli::warn('<dir?>[name] [extends?] [subdir?] [-O?]', 1).Cli::color('[-O]','red', 1).Cli::break(1, false).'
 '.Cli::emo('ribbon-arrow').' Where: '.cli::alert('{options}').' ~ '.Cli::alert('[controller|window|model|winmodel|rex]')
  .Cli::br(2)
  .Cli::notice(' Struture above may not be true for all options.', 1)
  .Cli::br(2)
  .Cli::textIndent('Type'.self::mi('add:{option}', '','', '').' To see specific descriptions.', 1)
 ,

            
            #---------------------            
            'add:api'      => 'Adds an api class into windows folder.

 Syntax :'.self::mi('add:api','','','').Cli::warn('<dir?><name> [extends?] [\Dir?] [-O?]', 1).Cli::br(2). 
 Cli::textIndent(Cli::warn('dir'), 1).' ........ optional: directory of api file'.Cli::br(2). 
 Cli::textIndent(Cli::warn('name'), 1).' ....... name of api file (or class)'.Cli::br(2). 
 Cli::textIndent(Cli::warn('extends'), 1).' .... optional: extend api class to a frame file'.Cli::br(2). 
 Cli::textIndent(Cli::warn("\\Dir").' .......... optional: add a connected file subdirectory path (uses backslash)', 1),       
 Cli::textIndent(Cli::warn("\\-O").' ........... optional: overwrite existing file', 1),       

            
            #---------------------               
            'add:frame'      => 'Adds a frame into the windows frame folder

 Syntax :'.self::mi('add:frame','','','').Cli::warn('<dir?><name> [-O?]', 1).Cli::br(2) 
 .Cli::textIndent(Cli::warn('dir'). ' ...... optional: directory of frame file', 1).Cli::br(2)
 .Cli::textIndent(Cli::warn('name'). ' ..... name of frame file', 1).Cli::br(2)
 .Cli::textIndent(Cli::warn('-O'). ' ....... optional: overwrite existing file', 1),
            

            #---------------------            
            'add:model'   => 'Adds a model file (class) into \'windows/models\' directory or subdirectory.

 Syntax :'.self::mi('add:model','','','').Cli::warn('<dir/?><name> [-O?]', 1).Cli::br(2)
 .Cli::textIndent(Cli::warn('dir').' ...... optional: directory of Model file within \'windows/Models\' directory ', 1).Cli::br(2)
 .Cli::textIndent(Cli::warn('name').' ..... name of Model file within \'windows/Models\' directory ', 1).Cli::br(2)
 .Cli::textIndent(Cli::warn('-O').' ....... overwrite existing file', 1)
 ,

            #---------------------           
            'add:rex'        => 'Adds a new rex file into the rex template folder
            
 Syntax : '.Cli::color('add:rex', 'red').' [path?].<filename>
 
 '.Cli::alert('Note 1 :').' Path when supplied should be a subdirectory of the rex template directory

 '.Cli::alert('Note 2 :').' Paths can be supplied using dots while the last name is assumed to be file name',

            #---------------------           
            'add:route'     => 'Adds a new route file into the "window/Routes" directory
            
 Syntax : '.Cli::color('add:route', 'red').' <routeName>
 
 '.Cli::alert('Note 1 :').' Path when supplied should be a subdirectory of the windows/Routes directory

 '.Cli::alert('Note 2 :').' Paths can be supplied using dots while the last name is assumed to be file name',

            
            #---------------------            
            'add:window'     => 'Adds a window class into windows folder

 '.Cli::warn('Syntax').' :'.self::mi('add:window','','','').Cli::warn('<dir/?><name>'.Cli::color('<extends?>', 'purple', 1).' '.Cli::danger('[-O?]'), 1).
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::warn('<dir/?>', 1). ' ............. optional: subdirectory of windows folder', 2).
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::warn('<name>', 1). ' .............. name of window Class', 2).
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::color('<extends?>', 'purple', 1). ' ......... optional: extend to frame path within '.Cli::warn(WIN_FRAMES).' directory', 2).
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::danger('[-O?]', 1). ' .............. optional: overwrite existing file', 2)
 ,


            #---------------------           
            'backup'        => 'Creates or remove project backups
            
 Syntax : '.Cli::danger('backup').Cli::warn('[project|:clear]', 1).'
 
 '.Cli::alert('Note 1 :').' A root project folder "backup" is used as default folder for project backups

 '.Cli::alert('Note 2 :').' '.Cli::warn('Project').' ... compresses current project file into root backup folder

 '.Cli::alert('Note 3 :').' '.Cli::warn(':clear ').' ... removes the entire backup folder and its contents.'.Cli::danger('Trend carefully', 1),

            #---------------------
            'clean'          => 'Cleans the storage template files

 '.Cli::emo('ribbon-arrow').' Syntax :'.self::mi('clean', '', '', '').Cli::warn('storage', 1).'
            ',

            #---------------------
            'config'         => 'Sets default configuration parameters for database, meta tags and live server

 Syntax :'.self::mi('config:', '','','').Cli::color('[option]','cyan').Cli::warn('<args>', 1).'            

  '.Cli::color('[option]','cyan').' : [dbonline|dboffline|usersTable|cookieField|idField|watch|watcher|meta]

  '.Cli::emo('ribbon-arrow').' Type'.self::mi('config:', '', '', '').Cli::color('[option]', 'cyan').' to see the supplied option descriptions
',
            
            #---------------------
            'config:dbonline'    => 'Sets online database default connection parameters. 

 Syntax :'.self::mi('config:dbonline', '','','').Cli::warn('dbname dbuser dbpass dbserver [dbsocket?]', 1).'

 '.self::mi('config:dbonline', '','').Cli::warn('dbname dbuser dbpass dbserver','yellow').'

 '.self::mi('config:dbonline', '','').Cli::warn('dbname - dbpass - -', 1).Cli::emo('point-list', 1).' where dbuser, dbserver, dbsocket are not defined

 Note: Replace empty value with dash.',

            #---------------------
            'config:dboffline'   => 'Sets offline database default connection parameters. 

 Syntax :'.self::mi('config:dboffline', '','','').Cli::warn('dbname dbuser dbpass dbserver [dbsocket?]', 1).'
 
 '.self::mi('config:dboffline', '','').Cli::warn('dbname dbuser dbpass dbserver', 1).'

 '.self::mi('config:dboffline', '','').Cli::warn('dbname - dbpass - -', 1).Cli::emo('point-list', 1).' where dbuser, dbserver, dbsocket are not defined

 '.Cli::color('Note:','blue').' Replace empty value(s) with dash.',
 
            #---------------------
            'config:usersTable'  => 'Sets database table name to be used for collecting users data
            
 Syntax :'.self::mi('config:usersTable', '','','').Cli::warn('<name>', 1),
            
            #---------------------            
            'config:cookieField' => 'Sets database column in usersTable to be used for storing cookie
            
 Syntax :'.self::mi('config:cookieField','','','').Cli::warn('<name>',  1),
            
            #---------------------            
            'config:idField'     => 'Sets database column in usersTable for storing a unique user id (e.g email, id, ...)

 Syntax :'.self::mi('config:idField','','','').Cli::warn('<name>', 1),
            
            #---------------------            
            'config:watch'       => 'Configures live server for offline or online environment.
 
 Syntax :'.self::mi('watch','','','').Cli::warn('[online|offline|both|disable|status]', 1).'
            
 '.Cli::notice('').Cli::warn('status').' returns the current watch settings',
            
            #---------------------            
            'config:watcher'     => 'Returns the status of liveserver
            
 Syntax :'.self::mi('config:watcher','','','').'',
            
            #---------------------            
            'config:meta'        => 'Allows or disallow the autoloading of environment meta tags by the resource class when importing static urls
    
 Syntax :'.self::mi('config:meta[on|off]','','','').'',
            
            #---------------------
            'cli'                => 'Displays a list of spoova cli commands
            
 Syntax :'.self::mi('cli','','','').Cli::warn('[-lists?]', 1).' 
 
 Note: When "-lists" is supplied, it displays additional details of each listed commands',
            
            #---------------------
            'features'           => 'Displays a list of spoova features
            
 Syntax :'.self::mi('features','','','').'',
            
            #---------------------
            'functions'          => 'Displays some spoova function

 Syntax :'.self::mi('functions','','','').'',      

            #---------------------
            'info'           => 'Provides information or description about acceptable cli syntaxes or commands

 Syntax :'.self::mi('info','','','').'',   
 
            #--------------------- 
            'install'        => 'Installs project app or database parameters supplied

 Syntax :'.self::mi('install','','','').Cli::danger('or', 1).Cli::alert('install:[app|db|dbname]', 1).' 
 
 '.Cli::alert('Note:').' when no option is supplied, it runs test to detect if current project has been fully configured',   
            
            #---------------------  
            'install:app'    => 'Installs project pack

 '.Cli::emo('ribbon-arrow', '|1').'Syntax :'.self::mi('install:app','','','').'',       
      
            #---------------------  
            'install:db'     => 'Finalizes database parameters installation if all parameters have been set.

 Syntax :'.self::mi('install:db','','','').Cli::warn('[path?]', 1).'
 
  Where '.Cli::warn('[path?]').' - optional dbconfig.php file directory from project folder

 ',
 
            #---------------------  
            'install:dbname' => 'Creates a new non-existing database using default configuration parameters
            
 Syntax :'.self::mi('install:dbname','','','').'',
 
            #---------------------
            'project'        => 'Creates a new project application
            
 Syntax :'.self::mi('project','','','').Cli::warn('<project name>'),

            #---------------------
            'version'        => 'displays the current spoova version
            
 Syntax :'.self::mi('version','','','').'',

            #---------------------
            'support'        => 'displays apps and language version supported
            
 Syntax :'.self::mi('support','','','').'',

            #---------------------
            'start'        => 'start development server on port 8080
            
 Syntax :'.self::mi('start','','','').'',

            #---------------------
            'watch'        => 'Handles watch related commands.

 '.Cli::notice('This command replaces').Cli::warn('config:watch', '1|1').' entirely
            
 '.self::mi('watch','','').Cli::warn('status', 1).' ..... Returns watch status

 '.self::mi('watch','','').Cli::warn('online', 1).' ..... Sets watch to online mode

 '.self::mi('watch','','').Cli::warn('offline', 1).' .... Sets watch to offline mode

 '.self::mi('watch','','').Cli::warn('both', 1).' ....... Sets watch for both environments

 '.self::mi('watch','','').Cli::danger('disable', 1).' .... Disables watch entirely

 Type :'.self::mi('info', '','','').Cli::warn('config:watch', 1).' - to see description  
 ',
            #---------------------
            'watch status'        => 'Returns the current watch (liveserver) configuration
            
 Syntax :'.self::mi('watch','','','').Cli::warn('status', 1).'
 
  To set watch status '.Cli::emo('ribbon-arrow').' Type :'.self::mi('config:watch', '','','').Cli::warn('[option]', 1).'  
  
   '.Cli::emo('ribbon-arrow').' Type :'.self::mi('info', '','','').Cli::warn('watch', 1).' - to learn more  
 ',



        ];

    }

    private function hasDesc($syntax) {

        return (isset($this->descs()[$syntax]));

    }

}