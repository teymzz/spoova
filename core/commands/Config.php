<?php

namespace spoova\core\commands;

use PDO;
use spoova\core\classes\DB;
use spoova\core\classes\DB\DBConfig;

class Config extends Entry{

    /* Database constants */
    private const DBCONSTANTS = [ 'NAME', 'USER', 'PASS', 'SERVER', 'PORT', 'SOCKET' ];

    /* methods that are allowed to be called directly on config */
    private $direct = [
        'meta', 'watch', 'init', 'install', 'usersTable', 'cookieField', 'idField',
        'all'
    ];   

    private static array $offline = []; 
    private static array $online = [];
    private static $all = false;

    /**
     * @param array func_get_args() : installer arguments
     */
    function __construct($args = []){

        $arg = $args[0]?? false;

        if(empty($arg)){   

            $config = [];

            Cli::textView(Cli::danger(Cli::emo('point-list', '|1').'mi config'));
            Cli::textView(Cli::emos('hot', 1).'sets configuration', 0, '2|1');
            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('config:','','','').Cli::warn('[option] <args>'), 0, '1|2');

            Cli::textView(Cli::warn('[option] => '). "[dbonline|dboffline|meta|usersTable|cookieField|idField]", 3, "|2");
            Cli::textView('Type '.self::mi('info').Cli::danger('config:', 1).Cli::warn('[option]').' to see specified option syntax', 3, "|2");
            
            return;   
        }  

        array_shift($args);
        $args = array_values($args);

        if(method_exists($this, $arg)){
            $this->$arg(...$args);
            return;
        }


        self::commandTitle('config:'.$arg.Cli::br());

        Cli::textview(Cli::error('"'.$arg.'" not recognized'), 0, "|2");

    }

    public function all(){

        self::$all = true;

        self::commandTitle('config:all'.Cli::br());

        Cli::textView(Cli::alert("Please setup the following configuration parameters"), "0|0", "|2");

        Cli::textView(Cli::warn("Database parameters (offline): "), 0, "");
        $response = Cli::prompt([], null, true);

        if(trim($response)) {
            $response = ltrim(rtrim($response,'"'), '"');
            $this->dboffline($response);
        }else{
            Cli::clearUp(2);
            Cli::clearLine();
            Cli::textView(Cli::warn('skipping offline database parameters...'), 0, "|2");
        }

        Cli::textView(Cli::warn("Database parameters (online) : "), "0|0");
        $response = Cli::prompt([], null, true);    

        if(trim($response)) {
            $this->dbonline($response);
        }else{
            Cli::clearUp(2);
            Cli::clearLine();
            Cli::textView(Cli::warn('skipping online database parameters...'), 0, "|2");
        } 

        if(!online){

            Cli::textView(Cli::alert("Proceed to test offline connection? [Y/N] "));
            $response = strtolower(Cli::prompt([], null, true)); 

            if($response === 'y') {

                //get connection parameters;
                $config = docroot."/icore/dbconfig.php";
                DBConfig::load($config, $configs);
                $oconfigs = $configs['offline']??[];
                array_trim($oconfigs);
                $dbname = ($oconfigs['NAME'] ?? '');

                unset($oconfigs['NAME']);
                $configs = array_keys($oconfigs);

                $dbc= new DB();

                if($db = $dbc->openTool()){
                    
                    if($dbname) {

                        $configs[0] = $dbname;

                        $oconfigs['NAME'] = $dbname;

                        if($dbc->openDB($oconfigs)){
                            Cli::clearUp();
                            Cli::textView(Cli::success("connection successfull!"), 0, '|2');

                        }else{

                            Cli::clearUp();
                            Cli::textView(Cli::warn('Notice: ').("database name \"".Cli::warn($dbname)."\" does not exist."), 0, "|2");
                            Cli::textView("Will you like to create one? [Y/N] ");

                            $response = strtolower(Cli::prompt());

                            if(strtolower($response) === 'y'){
                                if($db->createDB($dbname)){
                                    Cli::textView(Cli::success('database name created successfully'), 0, "|2");                                    
                                }else{
                                    Cli::textView(Cli::error('database name creation failed'), 0, "|2");  
                                    Cli::textView(Cli::error($db->error(true)));  
                                }
                            }else{
                                // Cli::break();
                                Cli::textView(Cli::error("process aborted because selected database name does not exist!"), 0, '|2');
                                exit;                            
                            }

                        }

                    }else{
 
                        Cli::clearUp(2);
                        Cli::textView(Cli::warn('Notice: ').("no database name added yet."), 0, "|1");
                        Cli::textView(Cli::alert("Proceed to add database name? [Y/N] "), 0, 1);

                        $response = strtolower(Cli::prompt());

                        if(strtolower($response) === 'y'){

                            Cli::textView(Cli::alert("Please enter your database name: ", 0 , 1));
                            $dbname = strtolower(Cli::prompt());

                            if(!trim($dbname)){

                                Cli::textView(Cli::error("process aborted because no name was supplied"), 0, '|2');
                                exit;                                     
                            }
                            
                            if($db->createDB($dbname)){
                                Cli::textView(Cli::success('database name created successfully'), 0, "|2");                                    
                            }else{
                                Cli::textView(Cli::error("some error occured!"), 0, '|2');
                                Cli::textView(Cli::error($db->error(true)), 0, '|2');
                                Cli::textView(Cli::error("process aborted!"), 0, '|2');
                                exit;                            
                            }

                        }else{
                            Cli::textView(Cli::warn("skipping database name configuration..."), 0, '|2');
                            Cli::break(1);
                        }

                    }

                } else {

                    Cli::textView(Cli::error("connection failed!"), 0, '|2');
                    Cli::textView(Cli::error("process aborted!"), 0, '|2');
                    exit;
                    
                }

            } else{

                Cli::clearUp();
                Cli::textView(Cli::warn('Notice: ').('process aborted because connection must be tested.'), 0, "|2");

                exit;

            }

        }else{
            Cli::break(1);
        }

        Cli::textView(Cli::alert("set users data table name (USERS_TABLE) : "));       
        $useridTable = Cli::prompt([], null, true); 
        
        Cli::clearUp();        
        Cli::textView(Cli::alert("set userid column name (USER_ID_FIELDNAME) : "));         
        $useridField = Cli::prompt([], null, true);        
        
        Cli::clearUp();         
        Cli::textView(Cli::alert("set cookie column name (USER_COOKIE_FIELDNAME) : "));        
        $cookie = Cli::prompt([], null, true);     
        Cli::clearUp(2);
        
        $this->usersTable($useridTable);
        Cli::clearUp(1);
        $this->idField($useridField);
        Cli::clearUp(1);
        $this->cookieField($cookie); 

        //meta option     
        Cli::textView(Cli::alert("Allow resource class to build meta tags from setup file? [Y/N] "));        
        $response = Cli::prompt([], null, true);           
        $option = (strtolower($response) === 'y')?  'on' : "off";
        Cli::clearUp(2);
        $meta = $this->meta($option);

        if($useridField && $useridTable && $cookie){
            //do a text update
            $FileManager = $this->get_init();
            $FileManager->textUpdate(['SETUP_COMPLETE' => 1 ]);
        }
        
        Cli::textView("All configurations added successfully");
        Cli::break(2);

    }

    /**
     * Configure the online parameters for database
     * 
     * @param array func_get_args() : arguments of online setup
     * @return void
     */
    public function dbonline(){

        $args = func_get_args();
        
        if(!self::$all) self::commandTitle('config:dbonline'.Cli::br());

        $url = $args[1]?? "/icore";
        if(strpos(getDefined('docroot'), $url) === false){
            $url = getDefined('docroot').'/'.$url;
        }

        $url = striplastslash($url);
        if(pathinfo($url, PATHINFO_EXTENSION) == ""){
            $url .= '/dbconfig.php';
        }
        
        if(!$arg = $this->testdb_var($args, __FUNCTION__)) return false;

        if(!($dbvalues = $this->render_arguments($arg)) ) return false;

        //make installation
        $this->setup_db('online',$dbvalues, $url);

        if(!self::$all){
            Cli::textView("Will you like to use the same configuration for offline environment? [Y, N] ");
    
            $response = Cli::prompt(['Y','N', 'y', 'n'], function($input, $options, $times){
    
                if(!in_array($input, $options)){
                    Cli::textView("Oops! Invalid option supplied", 0, "|2");
                }
    
                if($times > 3){
                    Cli::textView("trials exceeded, aborting command...", 0 , "|2");
                }
    
            }, 3);
    
            if(strtolower($response) === 'y'){
                Cli::break();
                $this->setup_db('offline',$dbvalues, $url);
            } else {
                Cli::textView(Cli::alert("Notice: ").'Default offline connection unchanged', 0, '1|1');
                Cli::break();
            }
        }

    }

    /**
     * Configure the offline parameters for database
     * 
     * @param array func_get_args() : arguments of offline setup
     * @return void
     */
    public function dboffline(){

        $args = func_get_args();

        if(!self::$all) self::commandTitle('config:dboffline'.Cli::br());

        $url = $args[1]?? "/icore";
        if(strpos(getDefined('docroot'), $url) === false){
            $url = getDefined('docroot').'/'.$url;
        }

        $url = striplastslash($url);
        if(pathinfo($url, PATHINFO_EXTENSION) == ""){
            $url .= '/dbconfig.php';
        }

        if(!$arg = $this->testdb_var($args, __FUNCTION__)) return false;

        if(!($dbvalues = $this->render_arguments($arg)) ) return false;

        //make installation
        $this->setup_db('offline',$dbvalues, $url);

        if(!self::$all){
            
            Cli::textView("Use the same configuration for online environment? [Y, N] ");
    
            $response = Cli::prompt(['Y','N', 'y', 'n'], function($input, $options, $times){
    
                if(!in_array($input, $options)){
                    if($times == 3){
                        Cli::break();
                        Cli::textView(Cli::error("maximum trials exceeded, aborting command..."));
                    }else{
                        Cli::textView(Cli::warn("oops: ")."invalid option supplied", 0, "|2");
                        Cli::textView("Use the same configuration for online environment? [Y, N] ");
                    }
                }
    
    
            }, 3);
            
            if(strtolower($response) === 'y'){
                Cli::break(1);
                $this->setup_db('online',$dbvalues, $url);
            } else {
                Cli::textView(Cli::alert('Notice: ').'Default online connection unchanged', 0, '1|1');
                Cli::break();
            }

        }

    }    

    /**
     * Handle config response if no parameters are supplied
     *
     * @param array $arg
     * @return string
     */
    private function testdb_var(array $arg, $option = ''): string{
        
        $arg = $arg[0]?? '';
        $arg = trim($arg , "'");
        
        if(empty($arg)){
            
            Cli::textView(Cli::danger(Cli::emo('point-list', '|1').'mi config:'.$option));
            Cli::textView('sets database '.ltrim($option, 'db').' configuration', 0, '2|1');
            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('config:'.$option,'','','').Cli::warn('"dbname dbuser dbpass dbserver dbport dbsocket"', 1), 0, '1|2');
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
             Cli::textView(Cli::error("invalid syntax"));
             return false;
        }

        //sort paramters supplied for db configs
        $dbvalues = explode(" ", $arg);
        $dbvalues = array_map(function($value){
            return ($value !== '-')? $value : '';
        },$dbvalues);
        
        //prevent lesser parameters
        $counts = count($dbvalues);

        if($counts < 5){
            Cli::textView(Cli::error("invalid count(".$counts.") of parameters supplied. "));
            return false;
        }

        if(count($dbvalues) < 6) $dbvalues[] = '';

        $dbvalues = array_combine(self::DBCONSTANTS, $dbvalues); 

        return $dbvalues;

    }


    /**
     * Configure the init file
     *
     * @param string $environment offline or online
     * @param array $dbvalues new configuration settings
     * @param string $url custom init path
     * @return void|false
     */
    private function setup_db(string $environment, array $dbvalues, string $url) {

        //check the environment
        $environments = ['online','offline'];

        if(!in_array($environment, $environments)){
            Console::error('environment not set');
            return false;
        }

        //$dbconfig will contain loaded init file configurations
        DBConfig::load($url, $dbconfig);
        
        $allconfig = $dbconfig;

        //load for offline configurations
        if($environment === 'offline'){
            
            //set the offline and online information            
            $offline  = $dbvalues; //new online values

            $online = $allconfig['online']?? []; //offline values   
            
            //modify the online information if neccessary 
            if(count($online) < 6 and count($online) > 1){
                Cli::textView(Cli::error("dbconfig file format is not accepted"), 0, '|2');
                return false;
            }elseif(empty($online)){
                $online =  array_flip(self::DBCONSTANTS); //database keys
                $online = array_fill_keys(array_keys($online), '');
            }
            

        }else if($environment === 'online'){

            //set the offline and online information            
            $online  = $dbvalues; //new online values
            $offline = $allconfig['offline']?? []; //offline values   

            //modify the offline information if neccessary 
            if(count($offline) < 6 and count($offline) > 1){
                Cli::textView(Cli::error("dbconfig file format is not accepted"), 0, '|2');
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
        if(self::$all) Cli::clearUp(1); 
        Cli::textView(Cli::success($environment." setup configuration successful"), 0, '|2');
    }

    private function meta(){
        
        $args = func_get_args();

        if(!self::$all) self::commandTitle('config:meta');

        if((count($args) < 1) || (count($args) > 1)){

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

    private function usersTable() {
        
        $args = func_get_args();

        if(!self::$all) self::commandTitle('config:usersTable');

        if(count($args) < 1){
            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('config:','','','').Cli::warn('userTable <tablename>'), 0, '1|2');
            return;
        }

        if(count($args) > 1){
            Cli::textView(br().Cli::error("usersTable expects exactly one parameter").br('',2));  
            return;
        }
        
        $table_name = $args[0];

        //read the default init file
        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['USER_TABLE' => $table_name]);
            
            if($FileManager->readFile('USER_TABLE')){
                Cli::textView(br().Cli::success('user table configured successfully').br('', 2));    
                $this->complete_setup();         
            } else {
                if(!$table_name){
                    Cli::textView(br().Cli::warn('Notice: ').('user data table name not defined').br('', 2));                
                }else{
                    Cli::textView(br().Cli::error('user table configuration failed').br('', 2));                
                }
            }
        }

    }

    private function idField() {
        
        $args = func_get_args(); 

        if(!self::$all) self::commandTitle('config:idField');

        if(count($args) < 1){
            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('config:','','','').Cli::warn('idField <columnName>'), 0, '1|2');
            return;
        }

        if(count($args) > 1){
            Cli::textView(br().Cli::error("idField expects exactly one parameter").br('', 2));  
            return;
        }
        
        $field_name = $args[0];

        //read the default init file
        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['USER_ID_FIELDNAME' => $field_name]);
            
            if($FileManager->readFile('USER_ID_FIELDNAME')){
                Cli::textView(br().Cli::success('user id field configured successfully').br('', 2));    
                $this->complete_setup();         
            } else {
                if(!$field_name){
                    Cli::textView(br().Cli::warn('Notice: ').('user id field name not defined').br('', 2));             
                }else{
                    Cli::textView(br().Cli::error('user id field configuration failed').br('', 2));             
                }
            }
        }

    }

    private function cookieField() {

        $args = func_get_args();

        if(!self::$all) self::commandTitle('config:cookieField');     

        if(count($args) < 1){ 

            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('config:','','','').Cli::warn('cookieField <columnName>'), 0, '1|2');

            return;
        }    

        if(count($args) > 1){

            Cli::textView(br().Cli::error("cookieField expects exactly one parameter").br('', 2));  

            return;
        }
        
        $cookie_fieldname = $args[0];

        //read the default init file
        if($FileManager = $this->get_init()){
            $FileManager->textUpdate(['COOKIE_FIELDNAME' => $cookie_fieldname]);
            
            if($FileManager->readFile('COOKIE_FIELDNAME')){
                Cli::textView(br().Cli::success('cookie field configured successfully').br('', 2)); 

                $this->complete_setup();         
            } else {

                if(!$cookie_fieldname){

                    Cli::textView(br().Cli::warn('Notice: ').('cookie field name not defined').br('', 2));            
                }else{
                    Cli::textView(br().Cli::error('cookie field configuration failed').br('', 2));            

                }
            }
        }

    }   


    //complete the setup installation file
    private function complete_setup(){
        //run this after all configuration has been made
    }

    private function watch($arg = ''){

        $this->display(Cli::danger(Cli::emo('point-list').' config:watch'));
        $this->display(Cli::notice('Please Type:'.self::mi('watch', '','', '').' instead'), 2);

    }
    

}