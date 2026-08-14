<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

/** Used in documentation of @see Entry::directives */ 
use spoova\mi\core\commands\Support\Info;  

/**
 * class Entry
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 * 
 * Entry point for all spoova commands
 */
class Entry extends Console{

    protected const max_commands_level = 6;

    protected const bool latent_mode = false;

    protected const spack = 'spack_';
    protected const crest = self::spack.SP_VERSION;

    /**
     * List of commands that may be applied directly
     */
    protected const root = [ 'mi', 'version', 'support', 'features', 'cli', 'functions', 'classes', 'repack', ':wiz', ':wizi' ];

    /**
     * List of commands for configurations
     */
    protected const config = [
        'dbonline', 'dboffline', 'users_table', 'cookie_field', 'watch', 'meta', 'watch status'
    ];   


    /**
     * List of commands for installations
     */
    protected const install = [
        'install', 'install app', 'install db', 'install dbname'
    ];

    /**
     * Contain the list of acceptable first argument directives
     */
    protected const main = [
        'install', 'use', 'config', 'project'
    ];

    /**
     * list of directives (commands) and their function. INFO available {@see Info} .
     */
    protected const directives = [     
        
        'INFO >' => '',
        '   version'   => 'returns the spoova version',
        '   features'  => 'returns a list of spoova features',
        '   support'   => 'returns supports',
        '   cli'       => 'returns list of supported commands',
        '   use'       => 'determines a list of files to be used',
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
        '   sanitize' => 'prepares project app for online deployment :

                                     reports class files the autoloader will miss on a
                                     case-sensitive (online) filesystem, offline database
                                     credentials still in icore/dbconfig.php, and storage
                                     files that are regenerated online.

                                     <option> :  \'-w\' apply changes (default reports only)
                                                 \'-r\' restore config files from backup/
                                                 \'-s\' leave database config files untouched

                                     originals are copied to backup/ before anything is
                                     overwritten — add that folder to .gitignore.
                                    ',
    ];
    
    //list of usable methods in directives;
    protected static array $syntaxes = [

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
        $Filemanager = new Filemanager;
        $Filemanager->setUrl($init_url);
        
        if(!$Filemanager->openFile()){
            Console::log('init file is missing << create init file in the root icore folder');
            return false;
        }

        return $Filemanager;

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
    static function mi($code, $desc = '', $divider = 'infinite-arrow', $pointer = 'bullet'){

        $divider = !$divider? 'infinite-arrow' : $divider;

        $pointer = $pointer == '' ? '' : Cli::emo($pointer);
        return $pointer.
               Cli::color(Cli::style(fn() => ' ['.consoler.'] ', ['']), 'inverse').
               Cli::color(Cli::style(fn() => $code, ['italic']), 'alert').
               ($desc? Cli::emox($divider, 1).' '.$desc.' ' : ($code? ' ' : ''));

    }

    /**
     * Display the title of a command. This is similar to {@Cli::headerView()} method 
     * and may be used to declare the title of a command. Headers are displayed by default using 
     * suitable icons.
     *
     * @param string $title
     * @param integer $pause delay after title is printed.
     * @return void
     */
    static function commandTitle(string $title, int $pause = 0){

        Cli::headerView($title);
        Cli::pause($pause);
        Cli::break();

    }

}

?>