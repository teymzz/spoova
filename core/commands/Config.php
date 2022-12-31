<?php

namespace spoova\core\commands;
use spoova\core\classes\FileManager;
use spoova\core\classes\DBConfig;

class Config extends Entry{

    /* Database constants */
    private const DBCONSTANTS = [ 'USER', 'PASS', 'NAME', 'SERVER', 'PORT', 'SOCKET' ];

    /* methods that are allowed to be called directly on config */
    private $direct = [
        'meta', 'watch', 'init', 'install', 'users_table', 'cookie_fieldname'
    ];   

    private static array $offline = []; 
    private static array $online = [];

    /**
     * @param array func_get_args() : installer arguments
     */
    function __construct($args = []){

        $arg = $args[0]?? false;

        if(empty($arg)){   

            $config = [];

            Cli::textView(Cli::danger(Cli::emo('point-list', '|1').'mi config'));
            Cli::textView(Cli::emos('hot', 1).'sets configuration', 0, '2|1');
            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('config','','','').Cli::warn('<options>', 1), 0, '1|2');

            foreach (self::directives as $directive => $value) {
                if(strstr($directive, 'config') and (trim($directive) !== 'config') ){
                    $config[$directive] = $value;
                }
            }

            if(empty($config)){
                $this->addLog('No options found!');
            } else {
                $this->addLog($config);
            }
            
            return;   
        }  

        array_shift($args);
        $args = array_values($args);

        if(method_exists($this, $arg)){
            $this->$arg(...$args);
            return;
        }

        $this->addError('command "'.$arg.'" not recognized');

    }

    /**
     * Configure the online parameters for database
     * 
     * @param array func_get_args() : arguments of online setup
     * @return void
     */
    public function dbonline(){

        $args = func_get_args();

        $url = $args[1]?? "/icore";
        if(strpos(getDefined('docroot'), $url) === false){
            $url = getDefined('docroot').'/'.$url;
        }

        $url = striplastslash($url);
        if(pathinfo($url, PATHINFO_EXTENSION) == ""){
            $url .= '/dbconfig.php';
        }
        
        if(!$arg = $this->testdb_var($args)) return false;

        if(!($dbvalues = $this->render_arguments($arg)) ) return false;

        //make installation
        $this->setup_db('online',$dbvalues, $url);

    }

    /**
     * Configure the offline parameters for database
     * 
     * @param array func_get_args() : arguments of offline setup
     * @return void
     */
    public function dboffline(){

        $args = func_get_args();

        $url = $args[1]?? "/icore";
        if(strpos(getDefined('docroot'), $url) === false){
            $url = getDefined('docroot').'/'.$url;
        }

        $url = striplastslash($url);
        if(pathinfo($url, PATHINFO_EXTENSION) == ""){
            $url .= '/dbconfig.php';
        }

        if(!$arg = $this->testdb_var($args)) return false;

        if(!($dbvalues = $this->render_arguments($arg)) ) return false;

        //make installation
        $this->setup_db('offline',$dbvalues, $url);

    }    

    /**
     * Handle config response if no parameters are supplied
     *
     * @param array $arg
     * @return string
     */
    private function testdb_var(array $arg): string{
        
        $arg = $arg[0]?? '';
        $arg = trim($arg , "'");
        
        if(empty($arg)){
            Console::error('invalid syntax. Type "spoova config" to see a list of valid options', "(args)" ); 
            return '';
        }
        
        return $arg;

    }


    /**
     * Sort argument supplied from console for database parameters
     *
     * @param string $arg : database parameters
     * @return bool|array
     */
    private function render_arguments(string $arg){

        $match = preg_match('~[A-Za-z-\s]+~', $arg);

        if(!$match){
             $this->addError("invalid syntax");
             return false;
        }

        //sort paramters supplied for db configs
        $dbvalues = explode(" ", $arg);
        $dbvalues = array_map(function($value){
            return ($value !== '-')? $value : '';
        },$dbvalues);
        
        //prevent lesser parameters
        $counts = count($dbvalues);
        if($counts !== 6){
            $this->addError("invalid count(".$counts.") of parameters supplied. ");
            return false;
        }

        $dbvalues = array_combine(self::DBCONSTANTS, $dbvalues); 
        return $dbvalues;

    }


    /**
     * Configure the init file
     *
     * @param string $environment offline or online
     * @param array $dbvalues new configuration settings
     * @param string $url custom init path
     * @return void
     */
    private function setup_db(string $environment, array $dbvalues, string $url) {

        //check the environment
        if($environment !== "online" and $environment !== "offline"){
            Console::error('environment not set');
            return false;
        }

        //$dbconfig as loaded init file configurations
       DBConfig::load($url, $dbconfig);
        
        //database keys
        $dbkeys = self::DBCONSTANTS;
        
        $allconfig = $dbconfig;

        //load for offline configurations
        if($environment === 'offline'){
            
            //set the offline and online information            
            $offline  = $dbvalues; //new online values

            $online = $allconfig['online']?? []; //offline values   
            
            //modify the online information if neccessary 
            if(count($online) < 6 and count($online) > 1){
                Console::error("dbconfig file format is not accepted");
                return false;
            }elseif(empty($online)){
                $online =  array_flip(self::DBCONSTANTS);
                $online = array_fill_keys(array_keys($online), '');
            }
            

        }else if($environment === 'online'){

            //set the offline and online information            
            $online  = $dbvalues; //new online values
            $offline = $allconfig['offline']?? []; //offline values   

            //modify the offline information if neccessary 
            if(count($offline) < 6 and count($offline) > 1){
                Console::error("dbconfig file format is not accepted");
                return false;
            }elseif(empty($offline)){
               $offline =  array_flip(self::DBCONSTANTS);
               $offline = array_fill_keys(array_keys($offline), '');
            }

        }

        //trim spaces in environment arrays containing database parameters
        array_trim($online);
        array_trim($offline);

        $newconfig = 
        '<?php
        
        // custom db configuration files for online and offline
        
        $_DBCONFIG[\'SOCKET\']  = (online)? \''.$online['SOCKET'].'\' : \''.$offline['SOCKET'].'\';
        $_DBCONFIG[\'PORT\']    = (online)? \''.$online['PORT'].'\' : \''.$offline['PORT'].'\';
        $_DBCONFIG[\'SERVER\']  = (online)? \''.$online['SERVER'].'\' : \''.$offline['SERVER'].'\';	
        $_DBCONFIG[\'USER\']    = (online)? \''.$online['USER'].'\' : \''.$offline['USER'].'\';	
        $_DBCONFIG[\'PASS\']    = (online)? \''.$online['PASS'].'\' : \''.$offline['PASS'].'\';	
        $_DBCONFIG[\'NAME\']    = (online)? \''.$online['NAME'].'\' : \''.$offline['NAME'].'\';
        
        // NOTE:
        // 1: This file should not be edited or used for connection, create a new copy instead, then include that copy in your project which will automatically update this
        // 2: Example of a copy dbconfig.php file is the dbconfig file located created in the root “icore” folder
        ';

        //configure used
        $fp2 = fopen($url, 'w');
        fwrite($fp2, preg_replace('/[[:blank:]]+/',' ',$newconfig));
        fclose($fp2);  

        Console::say($environment." setup configuration successful");
    }

    private function meta(){
        $args = func_get_args();

        self::commandTitle('config:meta');

        if((count($args) < 1) || (count($args) > 1)){
            //$syntax = self::$syntaxes['config']['meta']?? '';
            //print $syntax;
            //$this->log_syntax($syntax);
            Cli::break(1);
            
            Cli::textView(Cli::error('Expecting exactly one(1) argument'), 1);

            Cli::break(2);

            Cli::textView(self::mi('config:meta').Cli::warn('[on|off]', 1), 2).Cli::break(2);
            Cli::textView(self::mi('config meta').Cli::warn('[on|off]', 1), 2);

            Cli::break(2);

            return;
        }

        if($args[0] !== 'on' and $args[0] !== 'off'){
            Cli::break(1);     

            Cli::textView(Cli::error('command "'.$args[0].'" not recognized'), 1);

            Cli::textView('Syntax:'.self::mi('config:meta', '', '', '').Cli::warn('[on|off]', 1), 2).Cli::break(2);
            Cli::textView('Syntax:'.self::mi('config meta', '', '', '').Cli::warn('[on|off]', 1), 2);

            Cli::break(2);
            return;
        }

        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['RESOURCE_META' => $args[0] ]);
            
            if($FileManager->readFile('RESOURCE_META')){
                Cli::break();
                Cli::textView(Cli::Success('meta switched '.$args[0].' successfully', 2));   
                Cli::break(2);
                $this->complete_setup();          
            } else {
                Cli::break();
                Cli::textView(Cli::Error('meta switch '.$args[0].' failed!', 2));   
                Cli::break(2);             
            }            
        }

    }

    private function dbusers_table() {
        $args = func_get_args();

        if(count($args) < 1){
            $syntax = self::$syntaxes['config']['users_table'];
            $this->log_syntax($syntax);
            return;
        }

        if(count($args) > 1){
            Console::error("install user_table expects exactly one parameter");  
            return;
        }
        
        $table_name = $args[0];

        //read the default init file
        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['USER_TABLE' => $table_name]);
            
            if($FileManager->readFile('USER_TABLE')){
                Console::log('user table configured successfully');    
                $this->complete_setup();         
            } else {
                Console::log('user table configuration failed');                
            }
        }

    }

    private function dbusers_id_fieldname() {
        $args = func_get_args();

        if(count($args) < 1){
            $syntax = self::$syntaxes['config']['dbusers_id_fieldname'];
            $this->log_syntax($syntax);
            return;
        }

        if(count($args) > 1){
            Console::error("install user_table expects exactly one parameter");  
            return;
        }
        
        $field_name = $args[0];

        //read the default init file
        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['USER_ID_FIELDNAME' => $field_name]);
            
            if($FileManager->readFile('USER_ID_FIELDNAME')){
                Console::log('user id field configured successfully');    
                $this->complete_setup();         
            } else {
                Console::log('user id field configuration failed');                
            }
        }

    }

    private function dbcookie_fieldname() {
        $args = func_get_args();
        if(count($args) < 1){
          Console::log(">> config cookie_fieldname [ user_database_cookie_field_name ]");  
          return;
        }    

        if(count($args) > 1){
            Console::error("install cookie_fieldname expects exactly one parameter");  
            return;
        }
        
        $cookie_fieldname = $args[0];

        //read the default init file
        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['COOKIE_FIELDNAME' => $cookie_fieldname]);
            
            if($FileManager->readFile('RESOURCE_META')){
                Console::log('cookie field configured successfully');   
                //try to complete setup
                $this->complete_setup();         
            } else {
                Console::log('cookie field configuration failed');                
            }
        }

    }   
    
    private function init(){
        $args = func_get_args();

        if(empty($args)){
            $syntax = self::$syntaxes['config']['init'];
            $this->log_syntax($syntax);
            return;
        }

        var_dump($args);

        // $arg = array_shift($args)[0]; 
        // $args = array_values($args);
        // $this->$arg(...$args);
        // return;
    }

    /**
     * Transfer all installations to the Installation  Handler Class
     *
     * @params $params : list of arguments supplied
     * @return void
     */
    private function install($params = '') {

        self::error(" config install is not recognized... ");
        self::log(' use instead :: >> init install ');

        return ;
        //Installations will be handled by the installation class
        $Installer = new Install(...func_get_args());
        
    }


    //complete the setup installation file
    private function complete_setup(){
        //run this after all configuration has been made
    }

    /**
     * Separates a syntax from a string of text where syntaxes are identified by double forward arrows (>>)
     *
     * @param string $syntax
     * @return string
     */
    private function log_syntax($syntax){

        $expSyntax = explode(">>", $syntax, 2)[1]?? '';
            
        if($expSyntax){
            Console::log(">> ".$expSyntax);
            return;
        }

        Console::log("no syntaxes found for this command");

    }

    private function watch($arg = ''){

        $this->display(Cli::danger(Cli::emo('point-list').' config:watch'));
        $this->display(Cli::notice('Please Type:'.self::mi('watch', '','', '').' instead'), 2);

    }



    
//  USER_TABLE: users;
//  COOKIE_FIELDNAME: cookie;
//  USER_ID_FIELDNAME: email;
//  TABLE_CONFIGURATION: 3;
//  RESOURCE_WATCH: 1
//  RESOURCE_META: on
//  SETUP_COMPLETE: 1
    

}