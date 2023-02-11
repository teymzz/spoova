<?php

namespace spoova\core\commands;
use spoova\core\classes\DB\DBConfig;

class Config extends Entry{

    /* Database constants */
    private const DBCONSTANTS = [ 'NAME', 'USER', 'PASS', 'SERVER', 'PORT', 'SOCKET' ];

    /* methods that are allowed to be called directly on config */
    private $direct = [
        'meta', 'watch', 'init', 'install', 'usersTable', 'cookieField', 'idField'
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

    /**
     * Configure the online parameters for database
     * 
     * @param array func_get_args() : arguments of online setup
     * @return void
     */
    public function dbonline(){

        self::commandTitle('config:dbonline'.Cli::br());

        $args = func_get_args();

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

    /**
     * Configure the offline parameters for database
     * 
     * @param array func_get_args() : arguments of offline setup
     * @return void
     */
    public function dboffline(){

        self::commandTitle('config:dboffline'.Cli::br());

        $args = func_get_args();

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

        Cli::textView(Cli::success($environment." setup configuration successful"), 0, '|2');
    }

    private function meta(){
        $args = func_get_args();

        self::commandTitle('config:meta');

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

        self::commandTitle('config:usersTable');

        if(count($args) < 1){
            //$syntax = self::$syntaxes['config']['users_table'];
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
                Cli::textView(br().Cli::error('user table configuration failed').br('', 2));                
            }
        }

    }

    private function idField() {
        $args = func_get_args();

        self::commandTitle('config:idField');

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
                Cli::textView(br().Cli::error('user id field configuration failed').br('', 2));             
            }
        }

    }

    private function cookieField() {

        self::commandTitle('config:idField');

        $args = func_get_args();
        
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
                Cli::textView(br().Cli::error('cookie field configuration failed').br('', 2));            
            }
        }

    }   
    
    /**
     * Transfer all installations to the Installation  Handler Class
     *
     * @params $params : list of arguments supplied
     * @return void
     */
    // private function install($params = '') {

    //     self::error(" config install is not recognized... ");
    //     self::log(' use instead :: >> init install ');
        
    // }


    //complete the setup installation file
    private function complete_setup(){
        //run this after all configuration has been made
    }

    private function watch($arg = ''){

        $this->display(Cli::danger(Cli::emo('point-list').' config:watch'));
        $this->display(Cli::notice('Please Type:'.self::mi('watch', '','', '').' instead'), 2);

    }
    

}