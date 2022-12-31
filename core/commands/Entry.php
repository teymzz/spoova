<?php

namespace spoova\core\commands;

use spoova\core\commands\Cli;
use spoova\core\classes\FileManager;

/**
 * class Entry
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 * @package core\commands
 * 
 * Entry point for all spoova commands
 */
class Entry extends Console{

    protected const max_commands_level = 6;

    protected const spack = 'spack_';
    protected const crest = self::spack.SP_VERSION;

    protected const root = [ 'version', 'support', 'features', 'cli', 'functions', 'classes', 'repack' ];

    /**
     * commands for configurations
     */
    protected const config = [
        'dbonline', 'dboffline', 'users_table', 'cookie_field', 'watch', 'meta', 'watch status'
    ];   


    /**
     * commands for installations
     */
    protected const install = [
        'install', 'install app', 'install db', 'install dbname'
    ];

    /**
     * Contain the list of acceptable first argument directives
     */
    protected const main = [
        'install', 'config', 'project'
    ];

    /**
     * list of directives (commands) and their functions
     */
    protected const directives = [     
        
        'INFO >' => '',
        '   version'   => 'returns the spoova version',
        '   features'  => 'returns a list of spoova features',
        '   support'   => 'returns supports',
        '   cli'       => 'returns list of supported commands',
        '   functions' => 'return list of custom functions and a brief description'.PHP_EOL,
        '   classes'   => 'return list of classes',
        '   class_methods <\'classnamespace\'>'   => 'return list of class methods. (Note the single quotes)',

        'CONFIGURATION >' => '',
        '   config' => 'configures the init file',
        '   config meta <option>' => 'configures the init meta option :

                                    on  > allow res to automatically load meta tags from environment settings
                                    off > disables res from automatically loading meta tags
                                    ',
        '   config watch <option>' => 'configures the init live server option :

                                    online   > enables watch both online and offline
                                    offline  > enables watch only offline
                                    disabled > disables watch totally
                                    ',
        '   config <dbonline|dboffline> <option>' => 'configures the init environment database connection parameters :

                                     <option> :  \'dbname dbuser dbpass dbserver dbport dbsocket\' \'optional_icore_directory\'
                                    ',
        '   config dbusers_table <tablename>'  => 'configures default database users table name',
        '   config dbcookie_field <fieldname>' => 'configures default cookie field name in database users table. This can be overwritten in development code ',
        '   config dbpass_field <fieldname>'   => 'configures default password field name in database users table. This can be overwritten in development code ',
                              
        'CLEAN >'          => '',
        '   clean storage' => 'Removes all unwanted storage files',

        'INSTALLATION >' => '',
        '   install'     => 'Tests and confirms connection to database using init parameters.',
        '   install app' => 'Install application by setting up basic files.',
        '   install db'  => 'Initializes "install" by trying to create default init database name using connection parameters',
        '   install dbname <name>' => 'Creates a new database using default connection parameters',                         
        
        'PROJECT >'      => '',
        '   <name>'      => 'Create a new project file',                                    
        '   backup_file <filepath>'   => 'backup update project installer file path :dev',                                    
        '   backup_folder <filepath>' => 'backup update project installer folder :dev',                                    

        // 'OTHERS >' => '',            
        // '   create' => 'creates a file',
        // '   create class <classpath>' => 'creates a class with a supplied class path',
        // '   create migration <classpath>' => 'creates a class with a supplied class path',
        // '   dbcreate' => 'used only after successful database connection to create a new database',
        // '   users_table' => 'configure default user fieldname in database (important)',
        // '   functions' => 'return list of functions',            
        // '   make::migration' => 'make migrations',
        // '   migrate' => 'run migrations',
        // '   meta' => 'enables Spoova to automatically load meta tags to the project file',
        // '   watch' => 'set the watchdog ++ ',
        // '   More Info' => ' To get more information about configurations use : >> info <name> ++    For example: "spoova info config" returns the information about config. '
    ];
    
    //list of usable methods in directives;
    protected static $syntaxes = [

        'config' => [ 
            'dbonline' => ' empty field should be replaced with dash "-" <optional_path>  >> config dboffline \'dbuser dbpass dbserver dbport dbsocket\' \'optional_directory\' ', //done
            'dboffline' => '  empty field should be replaced with dash "-" <optional_path> >> config dbonline \'dbuser dbpass dbserver dbport dbsocket\' \'optional_directory\' ', //done
            'users_table' => ' user fieldname in database (important) >> config user_table [ database_user_table_name ]', //done
            'cookie_field' => ' cookie fieldname in database (important) >> config cookie_field [ cookie_field_name_in_user_table ] ', //done
            'watch' => ' set default watch to offline, online or both environments >> config watch [ online | offline | both | disabled ]',  //done
            'watch_info' => ' returns information about resource watch >>  config watch info', //not done
            'meta' => ' set resource (Res) to automatically import configured meta tags at first Res::import() >> config meta [ on | off ]', //done
        ]

    ];


    public static function init_url(): string {
        return getDefined('docroot')."/icore/init";
    }

    public static function dbconfig_url(): string {
        return getDefined('docroot')."/icore/dbconfig.php";
    }        

    public static function get_init(){
    
        $init_url = self::init_url();
        $FileManager = new FileManager;
        $FileManager->setUrl($init_url);
        
        if(!$FileManager->openFile()){
            Console::log('init file is missing << create init file in the root icore folder');
            return false;
        }

        return $FileManager;

    }

    
    /**
     * Returns a specific cli code syntax using predefined format
     *
     * @param string $code cli code sample syntax
     * @param string $desc code description
     * @param string $divider sample/code separator character
     * @param string $pointer main left pointer 
     * @return string
     */
    static function mi($code, $desc = '', $divider = 'infinite-arrow', $pointer = 'ribbon-arrow'){

        $divider = !$divider? 'infinite-arrow' : $divider;

        $pointer = $pointer == '' ? '' : Cli::emo($pointer);
        return $pointer.
               Cli::btn(consoler, '1|1').
               Cli::color($code, 'blue').
               ($desc? Cli::emox($divider, 1).' '.$desc : '');

    }

    static function commandTitle($title, int $pause = 0){

        Cli::textView(Cli::danger(Cli::emo('point-list').' '.$title.' '));
        Cli::pause($pause);
        Cli::break();

    }

}

?>