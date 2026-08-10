<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\commands\Root\MiHelper;

/* Used in the documentation of this class */
use spoova\mi\core\commands\Support\Handlers\Syntax;

/**
 * This class contains basic information on available cli commands and their syntaxes. 
 * The information is displayed when "info" command is used with a valid command name as argument. 
 * All commands lists and their descriptions are also available in the {@see Syntax} class.
 */
class Info extends Entry{

    function __construct(array $args)
    {
        if(count($args) != 1) {
            Cli::clearUp()->cls();
            Cli::headerView('info', break: 2);
            Cli::textView(Cli::color('WARNING:', 'red').' expecting exactly one(1) argument!', break: 1); 
            $this->display('Syntax:'.self::mi('info', '','','').'"'.Cli::warn('<command>').'"', 2); 
            return; 
        }

        if($this->hasDesc($args[0] ?? '')){
            Cli::headerView($args[0]);
            Cli::break(1);
            $this->display($this->descs()[$args[0]]);
        } else {
            $this->display(Cli::emos('times-big', 1, 'danger').$args[0].'?');
            Cli::break(1);
            $this->display(Cli::warn('No available information for this command!'));
            Cli::break(1);
            $this->display('This command may not exist or no description provided.');
            Cli::break(1);
            MiHelper::run(Cli::warn('-lists').' to see a list of available commands.', '1', 1);
        }
    }


    public function descs() : array {

        return [

            'add'            => 'Creates a new file
            
 Syntax :'.self::mi('add:{option}','','','').Cli::warn('<dir?>[name] [extends?] [subdir?]').Cli::textIndent(Cli::color('[-O]','red'), 1).Cli::break(1, false).'
 '.' Where: '.cli::alert('{option}').' ~ '.Cli::alert('[window|frame|route|api|model|rex|command|migrator]')
  .Cli::br(2)
  .Cli::notice(' Syntax above may not be true for all options.', 2)
  .Cli::br(2)
  .Cli::textIndent(' Use '.Cli::danger('info').' '.Cli::warn('add:{option}', '').' to see specified option\'s descriptions.', 1)
 ,

            
            #---------------------            
            'add:api'      => 'Adds an api class into windows folder.

 Syntax :'.self::mi('add:api','','','').Cli::warn('<dir?><name> [extends?] [\Dir?] [-O?]').Cli::br(2). 
 Cli::textIndent(Cli::warn('dir'), 1).' ........ optional: directory of api file'.Cli::br(2). 
 Cli::textIndent(Cli::warn('name'), 1).' ....... name of api file (or class)'.Cli::br(2). 
 Cli::textIndent(Cli::warn('extends'), 1).' .... optional: extend api class to a frame file'.Cli::br(2). 
 Cli::textIndent(Cli::warn("\\Dir").' .......... optional: add a connected file subdirectory path (uses backslash)', '1'),       
 Cli::textIndent(Cli::warn("\\-O").' ........... optional: overwrite existing file', '1'),       

            
            #---------------------               
            'add:frame'      => 'Adds a frame into the windows frame folder

 Syntax :'.self::mi('add:frame','','','').Cli::warn('<dir?><name> [-O?]').Cli::br(2) 
 .Cli::textIndent(Cli::warn('dir'). ' ...... optional: directory of frame file', 1).Cli::br(2)
 .Cli::textIndent(Cli::warn('name'). ' ..... name of frame file', '1').Cli::br(2)
 .Cli::textIndent(Cli::warn('-O'). ' ....... optional: overwrite existing file', 1),
            

            #---------------------            
            'add:migrator'   => 'Adds a migration file (class) into \'db/migrations\' directory.

 Syntax :'.self::mi('add:migrator','','','').Cli::warn('<name>').Cli::br(2)
 .Cli::textIndent(Cli::warn('name').' ..... name of migration file to be added in \'migrations\' directory ', 1).Cli::br(2)
 .Cli::textIndent(Cli::alert('Notice: ').'a name with prefix "'.Cli::warn('create_').'" will try to use a creation code syntax', 1).Cli::br(2)
 .Cli::textIndent(Cli::alert('Notice: ').'a name with prefix "'.Cli::warn('alter_').'" will try to use an alter code syntax', 1).Cli::br(2)
 .Cli::textIndent(Cli::alert('Notice: ').'supplied name will have an auto generated prefix', 1)
 ,
            #---------------------            
            'add:model'   => 'Adds a model file (class) into \'windows/models\' directory or subdirectory.

 Syntax :'.self::mi('add:model','','','').Cli::warn('<dir/?><name> [-O?]').Cli::br(2)
 .Cli::textIndent(Cli::warn('dir').' ...... optional: directory of Model file within \'windows/Models\' directory ', '1').Cli::br(2)
 .Cli::textIndent(Cli::warn('name').' ..... name of Model file within \'windows/Models\' directory ', '1').Cli::br(2)
 .Cli::textIndent(Cli::warn('-O').' ....... overwrite existing file', '1')
 ,

            #---------------------           
            'add:rex'        => 'Adds a new template file into the rex template directory
            
 Syntax : '.Cli::danger('add:rex').' '.Cli::warn('[path?]').Cli::alert('[filename]').'[:ext?]
 
 '.Cli::alert('Note 1 :').' Path when supplied, will be a subdirectory of the rex template directory.

 '.Cli::alert('Note 2 :').' Paths can be supplied using dots while the last name is assumed to be file name.

 '.Cli::alert('Note 3 :').' Supported file extensions are php, css or js while default is php.',

            #---------------------           
            'add:route'      => 'Adds a new route file into the "window/Routes" directory
            
 '.Cli::emo('ribbon-arrow').' Syntax :'.self::mi('add:route','','','').Cli::warn('<dir/?><name>', '1').Cli::danger('[-O]').Cli::br(2)
 .Cli::textIndent(Cli::warn('dir').' ...... optional: directory of route file within \'windows/Routes\' directory ', '1').Cli::br(2)
 .Cli::textIndent(Cli::warn('name').' ..... name of route file (or class) ', '1').Cli::br(2)
 .Cli::textIndent(Cli::danger('-O').' ....... overwrite existing file', '1').Cli::br(2)

 .Cli::textIndent(Cli::alert('Note :').' Paths can be supplied using dots while the last name is assumed to be file (or class) name', '1'),
            
 
            #---------------------            
            'add:seeder'   => 'Adds a seeder file (class) into \'db/seeders\' directory.

 Syntax :'.self::mi('add:seeder','','','').Cli::warn('<name>', 1).Cli::danger('count', 1).Cli::color('[-O|-I][:index]?','purple').Cli::br(2)
 .Cli::textIndent(Cli::warn('name').' ..... existing database table name for generating seeder file to be added in \'db/seeders\' directory ', 1).Cli::br(2)
 .Cli::textIndent(Cli::danger('count').' ....... number of seeds to be generated for table', '1').Cli::br(2)
 .Cli::textIndent(Cli::color('-O', 'purple').' ....... overwrite existing file', '1').Cli::br(2)
 .Cli::textIndent(Cli::color('-I', 'purple').' ....... creates new file by appending number to existing file name.', '1').Cli::br(2)
 .Cli::textIndent(Cli::color(':index', 'purple').' ....... overwites a file using its target index .', '1').Cli::br(2)
 .Cli::textIndent(Cli::alert('Notice: ').'prefix name "'.Cli::warn('seed_').'" are attached to each seeder file', 1).Cli::br(1)
 ,
            #---------------------            
            'add:window'     => 'Adds a window class into windows folder

 '.Cli::warn('Syntax').' :'.self::mi('add:window','','','').Cli::warn('<dir/?><name>'.Cli::textIndent(Cli::color('<extends?>', 'purple'), '1').' '.Cli::danger('[-O?]'), '1').
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::warn('<dir/?>', '1'). ' ............. optional: subdirectory of windows folder', '2').
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::warn('<name>', '1'). ' .............. name of window Class', '2').
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::textIndent(Cli::color('<extends?>', 'purple'), 1). ' ......... optional: extend to frame path within '.Cli::warn(WIN_FRAMES).' directory', '2').
 Cli::br(2).
 Cli::textIndent(Cli::emo('ribbon-arrow').Cli::danger('[-O?]', '1'). ' .............. optional: overwrite existing file', '2')
 ,
            #---------------------            
            'add:command'     => 'Adds a command controller class into commands folder

 '.Cli::warn('Syntax').' :'.self::mi('add:command','','','').Cli::warn('<name>'.Cli::textIndent(Cli::color('[-lite?]', 'purple'), 1).' '.Cli::danger('[-O?]'), 1).
 Cli::br(2).
 Cli::textIndent(Cli::emo('bullet').Cli::warn('<name>', '1'). ' .............. name of controller class', 2). 
 Cli::br(2).
 Cli::textIndent(Cli::emo('bullet').Cli::textIndent(Cli::color('[-lite?]', 'purple'), 1). ' .............. optional: use simple template format', '2').
 Cli::br(2).
 Cli::textIndent(Cli::emo('bullet').Cli::danger('[-O?]', '1'). ' .............. optional: overwrite existing file', 2)
 ,


            #---------------------           
            'backup'        => 'Creates or remove project backups
            
 Syntax : '.Cli::danger('backup').Cli::warn('[project|:clear]', '1').'
 
 '.Cli::alert('Note 1 :').' A root project folder "backup" is used as default folder for project backups

 '.Cli::alert('Note 2 :').' '.Cli::warn('Project').' ... compresses current project file into root backup folder

 '.Cli::alert('Note 3 :').' '.Cli::warn(':clear ').' ... removes the entire backup folder and its contents.'.Cli::danger('Trend carefully', '1'),

            #---------------------
            'clean'          => 'Cleans the storage template files

 '.Cli::emo('ribbon-arrow').' Syntax :'.self::mi('clean', '', '', '').Cli::warn('storage').'
            ',

            #---------------------
            'config'         => 'Sets default configuration parameters for database, meta tags and live server

 Syntax :'.self::mi('config:', '','','').Cli::color('[option]','cyan').Cli::warn('<args>', '1').'            

  '.Cli::color('[option]','cyan').' : [all|dbonline|dboffline|usersTable|cookieField|idField|watch|watcher|meta]

  '.Cli::emo('ribbon-arrow').' Type'.self::mi('config:', '', '', '').Cli::color('[option]', 'cyan').' to see the supplied option descriptions
',

            #---------------------
            'config:all'         => 'An interactive console guide line for setting up all essential configurations at once

 Syntax :'.self::mi('config:', '','','').Cli::color('all','cyan').'',
            
            #---------------------
            'config:dbonline'    => 'Sets online database default connection parameters. 

 Syntax :'.self::mi('config:dbonline', '','','').Cli::warn('dbname dbuser dbpass dbserver [dbsocket?]').'

 '.self::mi('config:dbonline', '','').Cli::warn('"dbname dbuser dbpass dbserver"').' 

 '.self::mi('config:dbonline', '','').Cli::warn('"dbname - dbpass - -"').' [where dashes mean undefined]',

            #---------------------
            'config:dboffline'   => 'Sets offline database default connection parameters. 

 Syntax :'.self::mi('config:dboffline', '','','').Cli::warn('"dbname dbuser dbpass dbserver [dbsocket?]"').'
 
 '.self::mi('config:dboffline', '','').Cli::warn('"dbname dbuser dbpass dbserver"').'

 '.self::mi('config:dboffline', '','').Cli::warn('"dbname - dbpass - -"').' [where dashes mean undefined]',
 
            #---------------------
            'config:usersTable'  => 'Sets database table name to be used for collecting users data
            
 Syntax :'.self::mi('config:usersTable', '','','').Cli::warn('<name>'),
            
            #---------------------            
            'config:cookieField' => 'Sets database column in usersTable to be used for storing cookie
            
 Syntax :'.self::mi('config:cookieField','','','').Cli::warn('<name>'),
            
            #---------------------            
            'config:idField'     => 'Sets database column in usersTable for storing a unique user id (e.g email, id, ...)

 Syntax :'.self::mi('config:idField','','','').Cli::warn('<name>'),
            
            #---------------------            
            'config:init'     => 'Configures an init file with a key and value pair

 Syntax :'.self::mi('config:init','','','').Cli::warn('<key>').' <value>',
            
            #---------------------            
            'config:env'     => 'Configures a .env file with a key and value pair

 Syntax :'.self::mi('config:env','','','').Cli::warn('<key>').' <value>',
            
            #---------------------            
            'config:watch'       => 'Configures live server for offline or online environment.
 
 Syntax :'.self::mi('watch','','','').Cli::warn('[online|offline|both|disable|status]').'
            
 '.Cli::notice('').Cli::warn('status').' returns the current watch settings',
            
            #---------------------            
            'config:meta'        => 'Allows or disallow the autoloading of environment meta tags by the resource class when importing static urls
    
 Syntax :'.self::mi('config:meta ','','','').Cli::warn('[on|off]'),
            
            #---------------------
            'cli'                => 'Displays a list of spoova cli commands
            
 Syntax :'.self::mi('cli','','','').Cli::warn('[-lists?]').' 
 
 Note: When "-lists" is supplied, it displays additional details of each listed commands',
            
            #---------------------
            'database'           => 'Opens database assistant feature
            
 Syntax :'.self::mi('database','','','').'',   
            
            #---------------------
            'features'           => 'Displays a list of spoova features
            
 Syntax :'.self::mi('features','','','').'',   

            #---------------------
            'info'           => 'Provides information or description about acceptable cli syntaxes or commands

 Syntax :'.self::mi('info','','','').' <command>',   
 
            #--------------------- 
            'install'        => 'test database connection parameters or create the default database name using config parameters.

 Syntax :'.Cli::alert('install', '1').Cli::warn('[db|dbname]', '1').' 
 
 '.Cli::alert('install').Cli::warn('db', '1').Cli::emo('infinite-arrow', '1|1').'runs test to detect if current project "icore/dbconfig.php" connection parameters are valid '.'

 '.Cli::alert('install').Cli::warn('dbname', '1').Cli::emo('infinite-arrow', '1|1').'creates database name using '.Cli::color('"icore/dbconfig.php"', '#111111').' connection parameters.'.'

 '.Cli::alert('install').Cli::warn('[db|dbname]', '1').Cli::danger('folder', '1').Cli::emo('infinite-arrow', '1|1').'executes operation from custom folder having '.Cli::color('"icore/dbconfig.php"', '#111111').' file
 '
 ,   

            #---------------------  
            'install db'     => 'Runs test to detect if current project "icore/dbconfig.php" connection parameters are valid.

 Syntax :'.self::mi('install','','','').Cli::warn('db').Cli::danger('[folder?]', '1').'
 
  Where '.Cli::danger('[folder?]').' - optional custom folder name that must contain "icore/dbconfig.php" configuration parameters',
 
            #---------------------  
            'install dbname' => 'Uses "icore/dbconfig.php" connection parameters to create its default database name if it does not exist.

 Syntax :'.self::mi('install','','','').Cli::warn('dbname').Cli::danger('[folder?]', '1').'
 
  Where '.Cli::danger('[folder?]').' - optional custom folder name that must contain "icore/dbconfig.php" configuration parameters'
 ,
 
            #---------------------
            'live'   => 'Displays or sets a live server key\'s value

 Syntax :'.self::mi('live', '','','').'controls'.Cli::warn('[poll|seek|--]', '1').'

  '.Cli::warn('poll').': enables live server on poll mode
  '.Cli::warn('seek').': enables live server on seek mode
  '.Cli::warn('--').': removes live server configuration.',

            #---------------------
            'logic'   => 'Set app routing logic

 Syntax :'.self::mi('logic', '','','').Cli::warn('[standard|index|basic]').'',

            #---------------------
            'migrate'   => 'Run migration files

 Syntax :'.self::mi('migrate', '','','').Cli::warn('[up|down|status]').Cli::textIndent(Cli::color('[times?]', 'red'), '1').'
 
 '.self::mi('migrate up', '','').'

 '.self::mi('migrate down', '','').Cli::warn('[times?]').Cli::emo('infinite-arrow', '1').' where times is number of down migrations

 '.self::mi('migrate status', '','').'',
 
            #---------------------
            'migrate down'   => 'Run migration files down

 Syntax :'.self::mi('migrate', '','','').Cli::warn('down').Cli::textIndent(Cli::color('[times?]', 'red'), '1').'

 '.self::mi('migrate', '','').Cli::warn('down').Cli::emo('infinite-arrow', '1').' run all migration files down

 '.self::mi('migrate', '','').Cli::warn('down').Cli::textIndent(Cli::color('4', 'red'), '1').Cli::emo('infinite-arrow', '1').' run 4 recent migration files down
 ',
 
            #---------------------
            'migrate up'   => 'Run migration files up

 Syntax :'.self::mi('migrate', '','','').Cli::warn('up', '1').'',
 
            #---------------------
            'migrate status'   => 'Displays migration file status

 Syntax :'.self::mi('migrate', '','','').Cli::warn('status', '1').'',
 
            #---------------------
            'notes'   => 'Generates, reads, protects and deletes development note files.

 Notes live in the '.Cli::warn('notes/').' directory, which is added to .gitignore on first use.
 Note names may only contain letters, numbers, dots, dashes and underscores.

 Syntax :'.self::mi('notes', '','','').Cli::warn('<arg1>').Cli::textIndent(Cli::color('<arg2?>', 'red'), '1').'

 '.self::mi('notes', '','','bullet').Cli::warn('<name>').' | create new or open existing note file in your editor.

 '.self::mi('notes', '','','bullet').Cli::warn(':list').' | list all note files
 '.self::mi('notes', '','','bullet').Cli::warn(':list -s').' | list all note files with file size

 '.self::mi('notes', '','','bullet').Cli::warn(':view').Cli::danger('<name>', '1').' | print a note in the terminal
 '.self::mi('notes', '','','bullet').Cli::warn(':add').Cli::danger('<name> "<message>"', '1').' | append a timestamped entry to a note

 '.self::mi('notes', '','','bullet').Cli::warn(':save').Cli::danger('<name>', '1').' | store a note in a password protected file under '.Cli::warn('notes/enc/').'
                       a forgotten password cannot be recovered.

 '.self::mi('notes', '','','bullet').Cli::warn(':delete').Cli::danger('<name>', '1').' | delete note file using its relative name
 '.self::mi('notes', '','','bullet').Cli::warn(':delete *').' | delete all note files (protected copies are kept)',
 

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
            'use'        => 'sets internal resources required
            
 Syntax :'.self::mi('use','','','').Cli::warn('<resource>').'

 '.self::mi('use', '','').Cli::warn('map', '1').Cli::emo('infinite-arrow', '1').' adds a map file ',

            #---------------------
            'ss'        => 'imports, updates or compiles light javascript packages  

 Syntax :'.Cli::textBuild(Cli::underline(Cli::warn('mi')), '1|1').Cli::danger('ss', '|1').Cli::alert('{option}').' '.Cli::warn('<resolver>').'

 '.' Where: '.Cli::alert('{option}').' ~ '.Cli::alert('[import|update|compile]').'
            
 '.self::mi('ss','','').Cli::warn('import').' ..... Imports package from repository

 '.self::mi('ss','','').Cli::warn('update').' ..... Updates existing package

 '.self::mi('ss','','').Cli::warn('compile').' .... Compiles existing package to ssmodule

 Type :'.self::mi('info', '','','').Cli::warn('"ss [option]"', '1').' to see specified option\'s description  
 ',

            #---------------------
            'ss import'        => 'import javascript files from repository

'.Cli::bgWarn(' Syntax ').Cli::textBuild(Cli::underline('mi'), '1|1').Cli::alert('ss', '|1').Cli::danger('import').Cli::warn('&folder::repo@version --module', 1).Cli::br(2). 
 Cli::bgWarn(' Syntax ').Cli::textBuild(Cli::underline('mi'), '1|1').Cli::alert('ss', '|1').Cli::danger('import').Cli::warn('dir::repo@version --module', 1),

            #---------------------
            'ss update'        => 'updates existing javascript files from repository

'.Cli::bgWarn(' Syntax ').Cli::textBuild(Cli::underline('mi'), '1|1').Cli::alert('ss', '|1').Cli::danger('update').Cli::warn('&folder::repo@version --module', 1).Cli::br(2). 
 Cli::bgWarn(' Syntax ').Cli::textBuild(Cli::underline('mi'), '1|1').Cli::alert('ss', '|1').Cli::danger('update').Cli::warn('dir::repo@version --module', 1).Cli::br(2). 
 Cli::textIndent(' Where:').Cli::textBuild(Cli::warn('folder').' ........', '1|1').'is destination folder name as "res/'.Cli::italics('folder').'/js".',
 Cli::textIndent(' Where:').Cli::textBuild(Cli::warn('folder').' ........', '1|1').'references "res/folder/js" in which "folder" points to folder name.'
 ,

            #---------------------
            'ss compile'        => 'compiles javascript files to ssmodules

'.Cli::bgWarn(' Syntax ').Cli::textBuild(Cli::underline('mi'), '1|1').Cli::alert('ss', '|1').Cli::danger('compile').Cli::warn('&dest::path --module', 1).Cli::br(2). 
 Cli::bgWarn(' Syntax ').Cli::textBuild(Cli::underline('mi'), '1|1').Cli::alert('ss', '|1').Cli::danger('compile').Cli::warn('dest::path --module', 1),

            #---------------------
            'start'        => 'start development server on port 8080
            
 Syntax :'.self::mi('start','','','').'',

            #---------------------
            'watch'        => 'Handles watch related commands.

 '.Cli::notice('This command replaces').Cli::warn('config:watch', '1|1').' entirely
            
 '.self::mi('watch','','').Cli::warn('status').' ..... Returns watch status

 '.self::mi('watch','','').Cli::warn('online').' ..... Sets watch to online mode

 '.self::mi('watch','','').Cli::warn('offline').' .... Sets watch to offline mode

 '.self::mi('watch','','').Cli::warn('both').' ....... Sets watch for both environments

 '.self::mi('watch','','').Cli::danger('disable').' .... Disables watch entirely

 Type :'.self::mi('info', '','','').Cli::warn('config:watch', '1').' to see description  
 ',
            #---------------------
            'watch disable'       => 'Disables the live watch',
            'watch offline'       => 'Sets the watch to offline mode',
            'watch online'        => 'Sets the watch to online mode',

            #---------------------
            'watch status'        => 'Returns the current watch (liveserver) configuration
            
 Syntax :'.self::mi('watch','','','').Cli::warn('status').'
 
  To set watch status '.Cli::emo('ribbon-arrow').' Type :'.self::mi('config:watch', '','','').Cli::warn('[option]', '1').'  
  
   '.Cli::emo('ribbon-arrow').' Type :'.self::mi('info', '','','').Cli::warn('watch').' to learn more  
 ',

        ];

    }

    private function hasDesc(string $syntax) {

        return (isset($this->descs()[$syntax]));

    }

}