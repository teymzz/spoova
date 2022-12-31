<?php

use spoova\core\classes\DB;

Use spoova\core\classes\Filemanager;

class Installer{

    private $DBKEYS = [];
    private $DBDEFAULT = [];
    private $DBDATA = [];
    private $DBSETS = [];
    private $DBALL  = [];
    private $intro;
    private $refreshBtn;
    private $content;

    private $userColumns = [
        'firstname'=> ['len'=> 30, 'type'=> 'varchar'],
        'lastname'=>['len'=> 30, 'type'=> 'varchar'],
        'address'=>['len'=> 150, 'type'=> 'varchar'],
        'ipaddress'=>['len'=> 20, 'type'=> 'varchar'],
        'image'=>['len'=> 191, 'type'=> 'varchar'],
        'biodata'=>['len'=> 1500, 'type'=> 'varchar'],
        'username'=>['len'=> 30, 'type'=> 'varchar', 'index'=>'unique'],
        'email'=>['len'=> 191, 'type'=> 'varchar', 'index'=>'unique'],
        'phone'=>['len'=>20, 'type'=> 'varchar', 'index'=>'unique'],
        'password'=>['len'=> 191, 'type'=> 'varchar', 'index'=>'unique'],
        'usertoken'=>['len'=> 191, 'type'=> 'varchar', 'index'=>'unique'],
        'activated'=>['len'=>'', 'type'=> 'bit'],
        'added_on'=> ['len'=>'', 'type'=>'timestamp']
    ];

    private $install_status = 0; // 0, 1, 2, 3
    private $Filemanager;

    function __construct(){

        $this->refreshBtn = '
          <form method="get" class="px-full fb-7 pxs-10 pvt-8">
            <button type="submit" class="box flex-btn pxs-20 rad-4 bd-2 shadow c-red-d ch-red-dd ch-white pull-right" name="refresh"><span class="bi-bootstrap-reboot"></span></button> 
          </form>
        ';
        
        if(isset($_GET['refresh'])){
          $this->dbconfig('refresh');
          sleep(2);
          return ;
        }

        htCaliber(true); //update htaccess

        $this->DBKEYS =  ['DBNAME','DBUSER','DBPASS','DBSERVER','DBPORT','DBSOCKET'];

        //update default connection (if necessary, else fall back to root configuration)
        if(defined('DBNAME')){
            $ENV = ['NAME'=>DBNAME, 'USER'=>DBUSER, 'PASS'=>DBPASS, 'SERVER'=>DBSERVER, 'SOCKET'=>DBSOCKET, 'PORT'=>DBPORT];
 
            if(!arrVoid($ENV)){
                $_ENV['DBDEFAULT'] = $ENV;
            }
        }

        //get database informations (default)
        $this->DBDEFAULT = $_ENV['DBDEFAULT'];

        foreach($this->DBDEFAULT as $DBKEY => $DBVALUE){
            $this->DBDATA['_DB'.$DBKEY] = $DBVALUE;
            $this->DBALL['DB'.$DBKEY] = $DBVALUE;
        }

        foreach($this->DBKEYS as $DBKEY){
            if($DBKEY == 'DBPORT' || $DBKEY == 'DBSOCKET'){
                if(empty($this->DBALL[$DBKEY])) continue ;
            }
        
            $this->DBSETS[$DBKEY] = $this->DBALL[$DBKEY];
        }

        $this->Filemanager = new Filemanager;

        $this->startConnection(); //set status connection

        //this is when variables needs to be used to build files
        foreach($this->DBDATA as $DBCONFS => $DBCONF){
            $$DBCONFS = $DBCONF;
        } 
    }

    public function headerText($message = ''){

        if(func_num_args() === 0){
            $message = '
            Start installation by setting up your default offline and online environment settings. 
            Ensure you read through each configuration settings. 
            <span class="hide">You can watch <a href="#" ><span class="c-sky-blue">tutorials</span></a> online to get started.</span>
            ';
        }
        
        $message = '
        <section class="intro pvs-10 mobi-100 font-em-1d2 c-blue" style="width:55%">
         '.$message.'
        </section>
        ';

        
        $this->intro = $message;
    }

    public function install(){


        define('spoova', @DomUrl()); 
        
        if($this->done()) redirect(spoova);
        $this->headerText();
        
        //stage 1: if not connected show dbconfig forms and allow $_POST['db_config']
        if($this->install_status === 0){
            $this->start_install(); //show config form and allow data config
            return ;            
        }

        $this->content .= $this->refreshBtn; 
        
        //stage 2: test, show user config forms and allow $_POST['user_config']
        if($this->install_status === 1){

            $this->headerText('
                Setup your user\'s database table name along with "user id" and "cookie" columns<br>
                <span class="font-em-d75 c-orange-dd">
                    A column of "id" will be automatically generated in your user table if it does not already exist. 
                    Alternatively, if your users\' table was set manually in database, then the <span class="c-silver-dd">(icore/init)</span> 
                    file along with <code>dbconfig.php</code> file should be updated properly. 
                     
                </span>'
            );
            //returns true if config is at state 2
            if(!$this->userInstalled()){
                //* print forms and sets config as 2 if user fields table is set
                $this->userInstall();
                return ;
            }
        }
       
        //stage 3: show starter fields 
        if($this->install_status === 2){

            //set config as 3 if starter fields are set or return false
            if(!$this->addedFields()){
                //show helper fields 
                $this->addFields();
                $this->showFields();
                return;
            }        
        }
       
        //stage 3: show resource options         
        if($this->install_status === 3){
            if(!$this->done(true)){
              $this->headerText("Resource tool is a great feature for file control, code debugging and handling meta tags.");
              $this->resourceForm();
            }
        }
        
        //stage 4: final
        if($this->install_status === 4){
          $this->final();            
        }


    }

    /**
     * start installation function
     *
     * @return void
     */
    private function start_install(){
        $this->content .= $this->intro;
        $this->dbConfig(); //set configuration files

        $this->content .= $this->dbForms();
    }
    
    /**
     * intall database environment setup
     * 
     * @return config texts
     * @param  string $type[default | custom]
     */
    private function dbConfig(){
        
        $arg = func_get_args()[0]?? false;
   
        if(!isset($_POST['dbconfig']) && ($arg !== 'refresh')) return false;
        
        sleep(1);

        //all variables initialized
        $dbname_off = $_POST['dbname_off']?? '';
        $dbname_on  = $_POST['dbname_on']?? '';

        $dbuser_off = $_POST['dbuser_off']?? '';
        $dbuser_on  = $_POST['dbuser_on']?? '';

        $dbpass_off = $_POST['dbpass_off']?? '';
        $dbpass_on  = $_POST['dbpass_on']?? '';

        $dbserver_off = $_POST['dbserver_off']?? '';
        $dbserver_on  = $_POST['dbserver_on']?? '';

        $dbport_off = $_POST['dbport_off']?? '';
        $dbport_on  = $_POST['dbport_on']?? '';

        $dbsock_off = $_POST['dbsock']?? '';
        $dbsock_on  = $_POST['dbsock']?? ''; 

        //similar db config for both environments
        if(isset($_POST['dbcon_same'])){
            $dbname_on = $dbname_off;
            $dbuser_on = $dbuser_off;
            $dbpass_on = $dbpass_off;
            $dbserver_on = $dbserver_off;
            $dbport_on = $dbport_off;
            $dbsock_on = $dbsock_off;
        }

        //curent environment connection parameters 
        if(online){
            $dbname = $dbname_on;
            $dbpass = $dbpass_on;
            $dbuser = $dbuser_on;
            $dbserver = $dbserver_on;
            $dbport = $dbport_on;
        }else{
            $dbname = $dbname_off;
            $dbpass = $dbpass_off;
            $dbuser = $dbuser_off;
            $dbserver = $dbserver_off;
            $dbport = $dbport_off;            
        }
        $dbsocket = $dbsock_on; //both environments
      
        if($arg !== 'refresh'){
          //test database connection
          if(!arrVoid($dbname, $dbuser,$dbpass,$dbserver,$dbport,$dbsocket) || isset($_POST['newdb'])){
              $dbcon = new spoova\core\classes\DB;
              $db = $dbcon->openDB('',$dbuser,$dbpass,$dbserver,$dbport,$dbsocket);
  
              if(!$db){
                  $this->message = " connection parameters failed!!! ";
                  return false;
              }
  
              //create a new database
              if(isset($_POST['newdb'])){
                  $db->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4");
                  if(!$db->process()){
                      $this->message = 'database cannot be created: '.$db->error();
                      return false;
                  }
              }else{
  
                  //test database if supplied and new database is not selected for creation
                  $db = $dbcon->openDB($dbname,$dbuser,$dbpass,$dbserver,$dbport,$dbsocket);
  
                  if(!$db){
                      $this->message = '"'.$dbname.'" is not a valid mysqli database name';
                      return false;                    
                  }
              }
  
              $connection_success = true;
          }
        
        
          //if no data is supplied, try to run the default connection
          if(!isset($connection_success)){
              $dbcon = new spoova\core\classes\DB();
              $db = $dbcon->openDB();
  
              if(!$db){
                    $this->message = 'database connection failed: ';
                    return false;
              }
  
              if(!$dbcon->active()){
                  $this->message = 'no database selected. Please re-fill the form and submit';
                  return false;
              }
          }
          
        } 

        
        $dbText =  (
        '<?php
            
            require_once \'secure.php\'; //secure file
            
            //online means live server, not online means on local server (e.g wamp, xamp ...)
            $_DBSOCKET = (online)? \''.$dbsock_on.'\' : \''.$dbsock_on.'\';
            $_DBPORT   = (online)? \''.$dbport_on.'\' : \''.$dbport_off.'\';
            $_DBSERVER = (online)? \''.$dbserver_on.'\' : \''.$dbserver_off.'\';	
            $_DBUSER   = (online)? \''.$dbuser_on.'\' : \''.$dbuser_off.'\';	
            $_DBPASS   = (online)? \''.$dbpass_on.'\' : \''.$dbpass_off.'\';	
            $_DBNAME   = (online)? \''.$dbname_on.'\' : \''.$dbname_off.'\';
            
            // NOTE:
            // 1: This file should not be edited or used for connection, create a new copy instead, then include that copy in your project which will automatically update this
            // 2: Example of a copy dbconfig.php file is the dbconfig file located created in the root “icore” folder
            '
        );

        //configure default
        // $fp = fopen(getDefined('_core').'dbconfig.php', 'w');
        // fwrite($fp, preg_replace('/[[:blank:]]+/',' ',$dbText));
        // fclose($fp);
        // sleep(1);

        
        if(isset($_POST['use_dbconfig']) || $arg === 'refresh'){
            sleep(1); 
            $dbText2 = 
            '<?php

            // custom db connection file for online and offline environments

            $_DBCONFIG[\'SOCKET\']   = (online)? \''.$dbsock_on.'\' : \''.$dbsock_off.'\';
            $_DBCONFIG[\'PORT\']     = (online)? \''.$dbport_on.'\' : \''.$dbport_off.'\';
            $_DBCONFIG[\'SERVER\']   = (online)? \''.$dbserver_on.'\' : \''.$dbserver_off.'\';
            $_DBCONFIG[\'USER\']     = (online)? \''.$dbuser_on.'\' : \''.$dbuser_off.'\';
            $_DBCONFIG[\'PASS\']     = (online)? \''.$dbpass_on.'\' : \''.$dbpass_off.'\';	
            $_DBCONFIG[\'NAME\']     = (online)?  \''.$dbname_on.'\' : \''.$dbname_off.'\'; ';
            
            //configure used
            $fp2 = fopen(getDefined('_icore').'dbconfig.php', 'w');
            fwrite($fp2, preg_replace('/[[:blank:]]+/',' ',$dbText2));
            fclose($fp2);
        }
        
        if($arg === 'refresh'){
           if(is_file(getDefined('_icore').'init')) unlink(_icore.'init');
           $Filemanager = new Filemanager;
           $Filemanager->openFile(true, _icore.'init');
        } 
        
        sleep(1);
        //redirectTo(":referer"); 
        redirect('install', 'java');      
        // sleep(5); //wait for redirection
    }    

    /**
     * dbconfig starter forms
     *
     * @return string starter forms
     */
    private function dbForms(){
        $conParams = $this->DBSETS;
        
        $DBNAME = setVar($conParams['DBNAME']);
        $DBUSER = setVar($conParams['DBUSER']);
        $DBPASS = setVar($conParams['DBPASS']);
        $DBSERVER = setVar($conParams['DBSERVER']);
        $DBPORT = setVar($conParams['DBPORT']);
        $DBSOCKET = setVar($conParams['DBSOCKET']);

        function enVars($value, &$offlineVar, &$onlineVar){
            if(!online) $offlineVar = $value;
            if(online) $onlineVar = $value;
        }
        
        if(isset($_POST['dbconfig'])){
            //all variables initialized
            $dbname_off = $_POST['dbname_off'];
            $dbname_on  = $_POST['dbname_on'];

            $dbuser_off = $_POST['dbuser_off'];
            $dbuser_on  = $_POST['dbuser_on'];

            $dbpass_off = $_POST['dbpass_off'];
            $dbpass_on  = $_POST['dbpass_on'];

            $dbserver_off = $_POST['dbserver_off'];
            $dbserver_on  = $_POST['dbserver_on'];

            $dbport_off = $_POST['dbport_off'];
            $dbport_on  = $_POST['dbport_on'];

            $dbsock_off = $_POST['dbsock'];
            $dbsock_on  = $_POST['dbsock']; 

            //similar db config for both environments
            if(isset($_POST['dbcon_same'])){

                //allow one value to set the (empty) other
                function setVals(&$val1, &$val2){
                    if(!empty($val1) && !empty($val2)) return;
                    if(!empty($val1) && empty($val2)) $val2 = $val1;
                    if(!empty($val2) && empty($val1)) $val1 = $val2;
                }

                setVals($dbname_off, $dbname_on);
                setVals($dbuser_off, $dbuser_on);
                setVals($dbpass_off, $dbpass_on);
                setVals($dbserver_off, $dbserver_on);
                setVals($dbport_off, $dbport_on);
                setVals($dbsock_off, $dbsock_on);

            } 
        
        }else{
                //only allow current environment value to be set
                enVars($DBNAME, $dbname_off, $dbname_on);
                enVars($DBUSER, $dbuser_off, $dbuser_on);
                enVars($DBPASS, $dbpass_off, $dbpass_on);
                enVars($DBSERVER, $dbserver_off, $dbserver_on);
                enVars($DBPORT, $dbport_off, $dbport_on);
                enVars($DBSOCKET, $dbsock_off, $dbsock_on);            
        }

        //If connection parameters are supplied but db install page still visible
        $errmess = (!empty(array_unset($conParams,'')))? "connection parameters failed!" : '';
        
        $newDBOption = '
            <span>
                <span class="pxv-4 box"><span><input type="checkbox" name="newdb"></span> Create new database
            </span>
        ';



        if($errmess == ''){

            /* 
             throw new ErrorException($this->buildStatus());
            */
            if(isset($this->message)){ $errmess = $this->message; }
        }

        $content = 
            '
            <div class="box dbset mobi-100" style="width: 50%;">
                <div class="header pvs-10">
                    Database Environment Setup <br>
                    <div class=" c-orange-dd font-em-d85"> 
                    <span class="c-red-dd"> dbconfig path: [ icore\dbconfig.php ] </span> <br>
                    Supply your database information for an existing or new database. Should you like to create a new database if it does not exist, select "create new database".
                    </div>
                </div> 
                <div class="c-red">'.$errmess.'</div>
                <form method="post" class="form-field in-flex-full f-col" action="">
                    
                    <div role="group" class="in-flex-full bc-deep-blue bd rad-4 pxv-10">
                        <span>
                            <span class="pxv-4 box"><span><input type="checkbox" name="dbcon_same"></span> Use '.(!online? "offline" : '').' settings for all
                        </span>
                        '.$newDBOption.'
                        <span hidden>
                            <span class="pxv-4 box"><span><input type="checkbox" name="use_dbconfig" checked="checked"></span> install & use setup
                        </span>
                    </div> 
                    
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-server mxr-4"></span> dbname</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbname_off" placeholder="offline" value="'.$dbname_off.'" >
                        <input type="text" class="flex-full pxv-10" name="dbname_on" placeholder="online" value="'.$dbname_on.'">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-person-check mxr-4"></span> dbuser</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbuser_off" placeholder="offline" value="'.$dbuser_off.'" >
                        <input type="text" class="flex-full pxv-10" name="dbuser_on" placeholder="online" value="'.$dbuser_on.'">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-eye mxr-4"></span> dbpass</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbpass_off" placeholder="offline" value="'.$dbpass_off.'" >
                        <input type="text" class="flex-full pxv-10" name="dbpass_on" placeholder="online" value="'.$dbpass_on.'">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-eye mxr-4"></span> dbserver</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbserver_off" placeholder="offline" value="'.$dbserver_off.'"  >
                        <input type="text" class="flex-full pxv-10" name="dbserver_on" placeholder="online" value="'.$dbserver_on.'">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-eye mxr-4"></span> dbport</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbport_off" placeholder="offline" value="'.$dbport_off.'"  >
                        <input type="text" class="flex-full pxv-10" name="dbport_on" placeholder="online" value="'.$dbport_on.'">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-plug mxr-4"></span> socket</button> 
                        <input type="text" name="dbsock" class="flex-full pxv-10" placeholder="dbsocket" value="'.$dbsock_off.'"  >
                    </div>

                    <div class="in-flex-full flex-r bc-white-dd pxv-10">
                        <fielset class="i-flex bc-blue-l bd-f rad-4 c-white font-em-1d2">
                            <button class="flex-btn-full pxs-20 pvs-6 pxv-6 bc-blue-dd c-white rad-r" name="dbconfig">
                                <span class="bi-install"></span> Install
                            </button>
                        </fielset>
                    </div>   

                </form>                
        </div>
            '
        ;

        return $content;
    }


    /**
     * 1) check if user init file is installed
     * 2) check if init configuration is valid
     * @return boolean
     */
    private function userInstalled() : bool{
        

        if(!is_file(getDefined('_icore').'init')) return false;    
        //check user here...
        $Filemanager = $this->Filemanager;  
        $Filemanager->setUrl(getDefined('_icore').'init');     
        if((int)$Filemanager->readFile('TABLE_CONFIGURATION') > 1){
            
            $userTable = $Filemanager->readFile('USER_TABLE');
            $cookie_field = $Filemanager->readFile('COOKIE_FIELDNAME');
            $user_id_field =  $Filemanager->readFile('USER_ID_FIELDNAME');

            $db = $this->db;
            if($db->table_exists($userTable)){ 
                if($db->column_exists($userTable, $cookie_field) && $db->column_exists($userTable, $user_id_field)){               
                    $this->install_status = 2;
                    return true;
                }                
            }
        }
        return false;
    }


    /**
     * user config installer
     * 
     * process the user configuration
     */
    private function userInstall(){        
        
        $this->content .= $this->intro;

        //process the user configuration
        $this->userConfig();

        $this->content .= $this->userTableForms();

    }
    
    /**
     * Install the user configuration settings
     */
    private function userConfig(){
        
        //* get file manager
        $Filemanager = $this->Filemanager;
        $Filemanager->setUrl(getDefined('_icore').'init');

        //* get database controller
        $db = $this->db;

        //start process on submission only...
        if(!isset($_POST['populate'])){
            
            //only set message if redirection failed
            //validate table configuration settings
            $tableConfig = $Filemanager->readFile('TABLE_CONFIGURATION');
            if(!$tableConfig){
                $this->message = ' 
                <span class="pxs-10">
                  <span class="c-red bold">Error:</span> no config table found in init file! <br>
                  <span class="box">
                    <span class="bold">Fix 1:</span> Immediately you see this error, refresh your page. <br>  
                    <span class="bold">Fix 2:</span> If you are unable to proceed after refresh, then delete the init file in root <span class="box">[ icore ]</span> folder. Your page should detect the changes and fix the errors. <br>  
                  </span>
                </span>
                ';
                $this->fatal_error = 0;
            }elseif((int)$tableConfig !== 1){
                $this->message = "please configure your user table with valid details!";
            }
            return false;       
        }

  
        if(!isset($_POST['users_table'])) return false;

        //get all needed fields
        $config['USER_TABLE'] = setVar($_POST['users_table']);
        $config['COOKIE_FIELDNAME'] = setVar($_POST['cookie_field']);
        $config['USER_ID_FIELDNAME'] = setVar($_POST['userid_field']);

        //initialize table configuration (must fill form)

        if(arrGetsVoid($config)){
            alert('no empty fields allowed!');
            return false;
        }

        if(
            strtolower(trim($config['COOKIE_FIELDNAME'])) ===
            strtolower(trim($config['USER_ID_FIELDNAME'])) 
        ){
            $this->message = "cookie field cannot be the same with user field!";
            alert('cookie field cannot be the same with user field!');
            return false;
        }
        if(strtolower($config['USER_ID_FIELDNAME']) === 'id'){ 
            $this->message = "id is a reserved field name. Consider using a different name"; 
            alert('id is a reserved field name. Consider using a different name');
            return false;
        }

        $userTable = $config['USER_TABLE'];
        $cookieField = $config['COOKIE_FIELDNAME'];
        //$cookieHashField = $config['COOKIE_HASH_FIELDNAME'];
        $useridField = $config['USER_ID_FIELDNAME'];

        
        //* create database table if online (!!!check)
        if($db->table_exists($userTable)){

            //check for cookie field and user id fields
            $cookieExists = $db->column_exists($userTable, $cookieField);
            $useridExists = $db->column_exists($userTable, $useridField);
            
            if(!$cookieExists){ 
               $queryString[] =' add '.$cookieField.' varchar(255) not null default \'\' '; 
            }
            
            if(!$useridExists){
               $queryString[] =' add '.$useridField.' varchar(191) not null default \'\', ADD UNIQUE KEY `'.$useridField.'` (`'.$useridField.'`) ';    
            }
            
            if(!empty($queryString)){
              //create a new command for adding fields
              $command = 'alter table `'.$userTable.'` ';
              $command .= implode(', ',$queryString);
            }
            

        }else{
            //create a new table
            $command = ('
                create table if not exists 
                `'.$userTable.'` (
                    `id` int(11) unsigned not null auto_increment,
                    `'.$cookieField.'` varchar(255) not null default \'\',
                    `'.$useridField.'` varchar(191) not null default \'\',
                    UNIQUE (`'.$useridField.'`),
                    PRIMARY KEY (`id`)
                )
            ');   

        }

        if(setVar($command)) {
            //* if command variable exists => execute command
            if(!$db->query($command)->process()){
                $this->message = $db->error();
                return ;    
            }
        }


        //update table configuration if all goes well and force redirection
        $Filemanager->textUpdate(['USER_TABLE'=>$userTable, 'COOKIE_FIELDNAME' => $cookieField, 'USER_ID_FIELDNAME'=> $useridField]);


        sleep(2);

        //* read file again "get config values"
        $userTable = $Filemanager->readFile('USER_TABLE');
        $cookieField = $Filemanager->readFile('COOKIE_FIELDNAME');
        $userIdField = $Filemanager->readFile('USER_ID_FIELDNAME');

        if( 
            ($userTable == $config['USER_TABLE']) &&
            ($cookieField == $config['COOKIE_FIELDNAME']) &&
            ($userIdField == $config['USER_ID_FIELDNAME'])
        ){
            //* search values from database
            if($db->table_exists($userTable) && 
            $db->column_exists($userTable, $cookieField) &&
            $db->column_exists($userTable, $userIdField)
            ){         
                //update table configuration if all goes well and force redirection
                $Filemanager->textUpdate(['TABLE_CONFIGURATION'=>'2']);
                sleep(2);
                redirect('install', false);            
            }            
        }else{
            $this->message = '<span class="c-red pvs-6">installation failed!</span>';
        }



    }    

    /**
     * user config forms
     * 
     * @return string user table forms
     */
    private function userTableForms(){
        
        $db = $this->db;
        $Filemanager = $this->Filemanager;
        $Filemanager->setUrl(getDefined('_icore').'init');

        if($currentDB = $db->currentDB()){
            $dbField = "(dbname: ".$currentDB.")";
        }

        //read the configuration file if it exists
        if(is_file(getDefined('_icore').'init')){
            //get the data in the file
            if($userTable = $Filemanager->readFile('USER_TABLE')){

                $cookie = $Filemanager->readFile('COOKIE_FIELDNAME');
                $userIdHash = $Filemanager->readFile('USER_ID_FIELDNAME');
                
                //check database table
                if(!$db->table_exists($userTable)){
                    if((int) $Filemanager->readFile('TABLE_CONFIGURATION') !== 1)
                        $tbError = 'current table "'.$userTable.'" not found';               
                }
            }
        }

        if(isset($this->message)){
            $tbError = $this->message;
        }

        if(isset($_POST['users_table'])){
            $uFieldName = setVar($_POST['users_table']);
        }else{
            $uFieldName = setVar($userTable);
        }

        $fields = $Filemanager->readFile(['COOKIE_FIELDNAME','USER_ID_FIELDNAME']);

        if(isset($_POST['cookie_field'])){
            $uCookie = setVar($_POST['cookie_field']);
        }else{
            $uCookie = $fields['COOKIE_FIELDNAME'];
        }     
        
        if(isset($_POST['userid_field'])){
            $useridField = setVar($_POST['userid_field']);
        }else{
            $useridField = $fields['USER_ID_FIELDNAME'];
        }             

        if(isset($this->fatal_error)) return setVar($tbError);

        return ('
            <div class="users-table mobi-100 mobi-100" style="width: 55%;">
                <div class="header pvs-10">Configure user database table name '.setVar($dbField).'</div>
                <form method="post" class="form-field in-flex-full f-col">
                    <div class="font-em-d85 c-red-d mvb-6" '.onShow(setVar($tbError)).'>'.$tbError.'</div>
                    <div class="i-flex f-col">
                        <label for="users_table"  class="flex-ico flex-l wid-full" ><span class="bi-people mxr-4"></span> users table name</label> 
                        <input type="text" class="flex-full pxv-10" id="users_table" name="users_table" placeholder="users table name (e.g users)" value="'.$uFieldName.'">
                    </div>  

                    <div class="i-flex f-col">
                        <label for="user_id"  class="flex-ico flex-l wid-full"><span class="bi-person-check pvs-2 mxr-4 flex mid"></span> user id field name</label> 
                        <input type="text" class="flex-full pxv-10" id="user_id" name="userid_field" placeholder="user id field name (e.g email)"  value="'.setVar($useridField).'">
                    </div>

                    <div class="i-flex f-col">
                        <label for="cookie_field"  class="flex-ico flex-l wid-full"><span class="bi-clock-history mxr-4"></span> cookie field name</label> 
                        <input type="text" class="flex-full pxv-10" id="cookie_field" name="cookie_field" placeholder="cookie field name (e.g cookie)" value="'.$uCookie.'">
                    </div>

                    <div class="in-flex-in bd-f rad-4 anc-btn-link mid">
                        <button class="flex-btn-full bh-deep-blue-d mid pxv-14 c-white" name="populate">
                            <span class="bi-ui-checks-grid mxr-4"></span> <span>Populate</span>
                        </button> 
                    </div>
                </form>        
            </div>
        ');
    }

    private function showFields(){
        
        if(isset($this->message)){ $errMess = $this->message; }

        $userColumns = $this->userColumns;
        
        $fields = '';

        $userTable = $this->Filemanager->readFile('USER_TABLE');
        $eFields = ($this->db->tables($this->db->currentDB(), $userTable));
            
        foreach($eFields as $eField){
            unset($userColumns[$eField]);
        }

        if(empty($userColumns)){ 
            $this->addFields(true);
            return true;
        }
        $categories = []; $i = 0;
        foreach($userColumns as $columnName => $columnProps){
            $fieldType = $columnProps['type'];
            $unique    = setVar($columnProps['index'])? ' <span class="c-orange-d">*</span>' : '';
            $length    = setVar($columnProps['len'])? " ".$columnProps['len'] : '';
            $length    = ' ('.$fieldType.$length.')';
            if(!in_array($fieldType, $categories)){
                if($i > 1) $fields .= "<br><br>";
                $fields .= '
                <div role="group" class="flex-btn-full midl mb-1 mt-2 bc-deep-blue c-white">
                    <button class="flex-btn mxs-10">'.$fieldType.' fields</button>
                </div> 
                ';
                $categories[] = $fieldType;
            }
            $fields .= '
                <div role="group" class="i-flex-full midl bc-deeper-blue">
                    <input type="checkbox" class="flex-child mxs-10" id="'.$columnName.'" name="fields[]" value="'.$columnName.'"> 
                    <label class="bc-none wid-full no-select pxs-10 bc-deep-blue" for="'.$columnName.'"> '.$columnName.' '.$length.$unique.'</label>
                </div>
            ';            
            $i++;

        }

        $fields .= "<br><br>";

        if(!empty($fields)){
            $fields .= '
                <div role="group" class="i-flex-full bc-deep-blue midr">
                    <span class="flex-full"></span>
                    <span class="flex c-silver-dd mid">
                        <input type="checkbox" class="flex-child mxs-10" id="add_all" name="add_all"> 

                        <span class="no-wrap p6 pxl-1 pxr-10 ">ADD ALL</span>                  
                        <button class="no-wrap bc-orange c-white p6 flex-btn" name="complete">COMPLETE</button>                    
                    </span>

                </div> 
            ';
        }
        $this->content .= (
            '
            <div class="pxv-10 mobi-100" style="width: 50%">
                <div class="pvt-10">Add other field to your user\'s table   
                    <span class="pxs-4 font-em-d85">(asterisks (*) refer to unique fields)</span>
                </div>
                '.setVar($errMess).'
                <form method="post">
                    '.$fields.'
                </form>
            </div>'."
            <script>
                const x=d;(function(e,f){const t=d,u=d,g=e();while(!![]){try{const h=parseInt(t(0x1f9))/(-0xbc3+-0x1db1+0x2975)*(parseInt(t(0x1ef))/(-0xec2+-0xa0*-0x29+-0xadc))+parseInt(u(0x1e4))/(0x1*0x1903+0x49*0x15+-0x1*0x1efd)*(-parseInt(t(0x1e0))/(0x1d*-0xfd+-0x12dc+0x2f89))+parseInt(u(0x1e3))/(0x507+-0xd*0x24d+-0x5*-0x4fb)*(parseInt(u(0x1f2))/(-0x4*0x77c+0x891*0x4+-0x26*0x1d))+-parseInt(t(0x1e9))/(-0x1bb*-0xe+0xb75*0x1+-0x23a8)*(-parseInt(u(0x1e5))/(0x9b8+0x5*0x4a9+-0x20fd))+parseInt(t(0x1f8))/(0x73*-0x25+-0x97*-0x8+-0xbf*-0x10)+parseInt(t(0x1f7))/(0xa2*0x4+-0x1e3d+0x1bbf)+-parseInt(t(0x1ec))/(-0x51*0x42+-0x888+0x1d75);if(h===f)break;else g['push'](g['shift']());}catch(j){g['push'](g['shift']());}}}(c,-0xa11c4+-0x1*0xae492+0x1ad48a));const k=b,l=b;(function(m,n){const v=d,w=d,o=b,p=b,q=m();while(!![]){try{const r=parseInt(o(-0x37*-0x28+0xa35+-0x4*0x45d))/(-(0x35de+-0xb6f*-0x2+-0x2bfb)+-(0x6*0x21e+-0x5*-0x23+-0xb20)*(-0x706+0x1e*0x4c+-0x1db)+(0x34*0x9b+-0x2046+0xcb*0x1)*(0x4a01+-0x1*-0x12fa+-0x1*0x2c64))*(parseInt(p(0x1*-0x2372+0x1*-0x1a9d+0x3f60))/(-(-0x2*0x113c+0x9dc+0x1b2a)*(0x708+0x1a5*-0x8+-0x1*-0x622)+(-0x44b*-0x1+0xfe*-0x20+0x27cb)+-(-0x1169+0x45b+0x1446)))+parseInt(o(-0x15f2+-0x12e2+-0x1*-0x2a2c))/((0x1dc6+0x49+-0x1e0e*0x1)*(0xef0+0x1726+-0x2533)+-(0x1*-0x21f1+-0x2*0xfec+0x16fc*0x3)+(-0x5*-0x5cb+-0x53e+-0x156e))*(parseInt(p(0x2*0x62b+-0xe6*-0x1f+0x1*-0x26dd))/(-0xab*0xb+-0x17a8+0x348b+(0x4*-0x443+0xbb2*-0x3+0x3a15)*-(0x18c+0x12*-0xc1+-0x16*-0x8c)+-(0x2015*0x1+-0x15ea+-0x8b)))+-parseInt(p(0x176*0x7+-0x1594+0xca8))/((-0x800+0x1e41+-0x163c)*-(-0xbb9+0x32b*-0x7+-0x35f*-0xb)+(-0xcc3+-0x25f1+-0x1cc9*-0x2)+-(-0x1*-0x59d+-0x816*0x3+-0x3*-0x63d)*-(-0x1e77+0x253+0x1ca5))+-parseInt(p(-0x15ab*0x1+-0x2*0x8bd+0x2879))/(0x2145+0xf79+-0xc0d+-(0x9bf+-0x1294+0x11e1)*(-0x2*0xdc1+-0xc95*0x1+-0x281b*-0x1)+(-0x1*0xf10+0x33*0xa8+-0x1265)*-(-0x5d4+0x2e0+-0x1*-0x31d))*(parseInt(o(-0x17*0x13c+0x35*0x47+-0xa7*-0x17))/(-(0x1f8d+0x3*0x3af+-0x2a99)*-(-0xef9*-0x1+-0x4661+0x5b83)+(0xc67*-0x2+-0x9f*0x3d+0x528a)*(0x3*-0x6b6+-0x20b*-0xa+0x4b*-0x1)+-(0x2b0b+0x5*0x416+-0x3c6*0x2)))+parseInt(p(0x4d*0x7+0x1*0x9fc+0xa3*-0x11))/(0x2ccd+0x2e5c+-0x1b*0x225+-(0x1a15+-0x5*0xa2+-0x16e9)*-(0x117*0x1b+0x7f4+-0x13e4)+-(-0x1*-0x229d+0x3e15+-0xe*0x209))*(parseInt(p(-0x12*0xe+-0x255d+0x27af))/(-(0x34d+-0x2326+0x1fdb)*-(0x1b*-0x21+0x1fc5*0x1+-0x121*0x13)+-(-0x17a4+0x1cd6+-0x1*-0x2e3)+(-0xf17+-0x2db*-0x5+0xd2*0x1)*-(0x1000+0x184*-0xe+-0x10*-0x80)))+parseInt(p(0x101*0x19+0x14e+-0x191f))/(-(-0x10dc+0x17e8+-0x923*-0x2)+(0xb24+-0x42a4*-0x1+0x9*-0x4c2)+(0x1*-0x67+0x2178+-0x2110)*-(-0x139a+-0x8a8+-0x977*-0x4))+-parseInt(p(0x5c3+-0xf*0x1f7+0x18fd*0x1))/(-(0x234+0x94*0x1f+-0x1412)*(0x1*-0x2023+-0x4*-0x685+-0x151*-0x5)+(0x1dae+-0x235*0x7+-0xd42)*(0xa4a+0xc06+-0x1645)+-(0x2fa+-0x4fc+0x2*0x2ab))*(parseInt(o(0x11f*0x1c+0x258f+-0x439e))/(-0x3a*-0x37+0x4d*0x65+0x2*-0x35f+-(0x4*-0x44b+0x1f8+0x1b1d)+(0xb6*-0x13+-0x1050+0x1e39)*-(-0x1519+0xa66+0xaef)));if(r===n)break;else q[v(0x1f3)](q['shift']());}catch(s){q[w(0x1f3)](q[w(0x1f4)]());}}}(a,(0x4f*0x6d+0x1ce1+-0x3e15)*(0x51*-0x97+0xce7+-0x2*-0x1db6)+-(-0x112*-0x4d6+-0x119c7b+0x164e3f)+(0x510*-0x1d4+0x37a17+0xca9a4)));let addAll=document['getElementById'](k(-0xbf8+-0x505*-0x7+-0x15e0));function d(a,b){const e=c();return d=function(f,g){f=f-(-0x29*-0x2c+-0x185f+-0x1*-0x1330);let h=e[f];return h;},d(a,b);}addAll[k(0x11*0x223+-0xb*-0x152+-0x3187*0x1)](x(0x1e2),function(){const f=k,g=k;let h=document[f(0x420+-0x310+0x35)](f(-0xc3*-0x25+-0x5a5+-0x1540));for(let j=0x1a54+0x2*-0x74a+0x1243+(0xf4a+0x2072+-0x126a)+-(0x9fc*-0x2+0x1b2e+0x341f),o=h[g(0x1b*-0xe2+-0xb0d+0x1*0x243a)];j<o;j++){h[j][g(-0x3d5+-0x20b+0x73a)]===f(0xa*-0x1e9+-0xa*0x25f+0x2c1d*0x1)&&(this[g(-0x23d1+-0x1*-0x159b+0xf85)]?h[j][f(0x32a+0xe63*-0x1+0xc88)]=!![]:h[j][g(-0x412*0x1+0xb7a+-0x1*0x619)]=![]);}});function b(f,g){const h=a();return b=function(j,m){j=j-(-(-0x1ee*-0x11+-0x8e5+-0x135e)*-(0x3*0xbf1+-0x7*0x137+-0x1b4a)+-(-0x8fd+0x439*-0x7+0x268f)*-(0x3fc+0x35*-0x76+0x1*0x1ef3)+-(0x54c0+0x2f2d+-0x4156));let n=h[j];return n;},b(f,g);}let inputs=document['getElementsByTagName'](k(0x56d*-0x3+0x1f*0xc1+-0x5ce));function a(){const y=x,z=x,e=['input:checked',y(0x1fc),y(0x1e8),y(0x1dd),y(0x1ea),z(0x1de),y(0x1e2),z(0x1fd),z(0x1f0),'checked',z(0x1e1),z(0x1fb),'addEventListener','1771768AnRaTc',y(0x1f6),y(0x1df),y(0x1ee),z(0x1e7),y(0x1f1),z(0x1e6),z(0x1f5),z(0x1eb),z(0x1ed)];return a=function(){return e;},a();}function c(){const C=['click','3394205FXRAFB','125067nVRKZc','16SDOdzR','291215kwgTZF','length','8104000pfavIq','1902068vucTRJ','input','5728bLtHmj','14947108BHQulu','getElementsByTagName','7551ZFEpuv','16122mkiHyX','479425hFtMgz','3BHZSQi','6kdzLdu','push','shift','type','207804PCmwCL','373820GiyHtj','4220847CQiMbn','7KDGWXE','checked','6mdqnKv','187xbzTwe','checkbox','querySelectorAll','add_all','1136796luPyIC','4gJuwcl','105IyHpLX'];c=function(){return C;};return c();}for(let i=-0x1253+0x8cd+0x15*0x165+(0x146d+0x1d0d*0x1+-0xc40)*-(-0x1f34+0xe2*0x1c+0x67d)+-(0x3*0x6b+-0xd9d+-0x95*-0x17)*-(0x10*-0xcd+0x16b+0xb76),max=inputs[l(0xb*-0xeb+-0x1*0xe2d+-0x4f*-0x53)];i<max;i++){inputs[i][l(0x12a0+0x1*0x1d5c+0x5e*-0x7f)]===k(0x227e+-0x195e+-0x7d3*0x1)&&inputs[i]['id']!==l(0x239f+-0xc7*0x2+-0x20c6)&&inputs[i][l(0x1*-0xfa9+0xd*0x2fc+-0x45d*0x5)](k(0x15e1+-0x17*0x167+0xbac),function(){const A=x,B=x,e=l,f=l;if(!inputs[i][e(-0x1*0x8f8+-0x2367+-0xf3a*-0x3)])addAll[A(0x1fa)]=![];else{let g=document[f(0x821*-0x2+-0x9e9*-0x2+0x247*-0x1)](f(0x1be4+-0x13*0xef+-0x8e1));g[f(0x102b+0xbd8*0x2+-0x2684)]==inputs[A(0x1e7)]-((-0x2*0x92+-0x3*0x341+0xb75)*(0x1851+0x12ec+-0x2b24)+-(-0x3b*0x3+-0x2091+0x2143)*-(-0xca*0x7+0x7*-0x1a3+-0x1*-0x14b6)+(-0xea4*-0x1+-0x1718+-0x3*-0x2d4)*-(0x380+0x9*-0x31d+0x78*0x39))&&(addAll[f(0x1d99+0x2f5+-0x1a5*0x13)]=!![]);}});}
            </script>
            "
        );
    }

    private function addFields($inject = false){
        
        if(isset($_POST['complete']) || $inject === true){
           
            $userColumns = $this->userColumns;
            $fields = ($_POST['fields'])?? []; //submitted fields
            $remFields  = []; //remaining fields' anchor (grouped)
            
            foreach($fields as $uField){
                $type = $userColumns[$uField]['type'];  
                    
                $remFields[$type][$uField] = $userColumns[$uField];
         
            }
            
            $Filemanager = $this->Filemanager;
            $Filemanager->setUrl(getDefined('_icore').'init');
            $userTable = $Filemanager->readFile('USER_TABLE');
            $command = "ALTER TABLE  `$userTable` ";
            $uniqs = ""; $query = "";
            $uniques = [];

            foreach($remFields as $coltype => $columns){
                
                foreach($columns as $column => $values){
                    $query .= "ADD COLUMN `".$column."` ";
                    if($coltype === 'bit'){
                        $query .= "BIT DEFAULT 0 NOT NULL, ";
                    }else if($coltype === 'timestamp'){
                        $query .="TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ";
                    }else{
                        $query .="VARCHAR(".$values['len'].") DEFAULT '' NOT NULL, ";
                    }

                    if(setVar($values['index']) === 'unique') $uniques[] = $column;
                }
            }

            //get existing fields;
            $eFields = ($this->db->tables($this->db->currentDB(),$userTable)); 

            foreach($uniques as $unique){
                $uniqs .= ', ADD UNIQUE KEY `'.$unique.'` (`'.$unique.'`)';
            }

            if(!empty($query)){
                $command = rtrim($command.$query,", ").$uniqs;

                $db = $this->db;

                if(!($process = $db->query($command)->process())){
                    $this->message = $db->error();
                    return false;
                }
            }
            
            sleep(1);
            
            if($Filemanager->readFile('TABLE_CONFIGURATION')){
                $Filemanager->textReplace(['TABLE_CONFIGURATION'=>'3']);
            }else{
                $Filemanager->textWrite(['TABLE_CONFIGURATION' => 3]); //textWrite('TABLE_CONFIGURATION: 3;',['separator'=>''])
            }
            redirect('install', false);
            return true;
        }
    }


    private function addedFields(){
        //read init
        if(file_exists(getDefined('_icore').'init')){
            $Filemanager = $this->Filemanager;
            $Filemanager->setUrl(getDefined('_icore').'init');
            if($Filemanager->readFile('TABLE_CONFIGURATION') === '3'){
                $this->install_status = 3;
                return true;
            }
        }
        return false;
    }

    /**
     * Verifies a true connection and updates the status
     *
     * @return void
     */
    private function startConnection(){

        if(empty($this->DBDATA)){
            $install_status = 0;
            $created_file = 0;
        }else{
            if(DBNAME == ''){
                $install_status = 0;
                $created_file = 1;
            }else{
                $install_status = 1;
                $created_file = 1;
            }
        }

        $this->install_status = $install_status;
        $this->create_file    = $created_file;

        if($install_status == 0){ return false; }

        $conParams = $this->DBSETS; 
        
        $conParams = array_values($conParams);    
        
        if( $this->db = (new DB)->openDB($conParams) ){ 
            $this->install_status = 1;
            $this->init();
        }else{
            $this->install_status = 0;
        }
        
    }
    
    
    /**
     * initialize configuration file
     *
     * @return void
     */
    private function init(){
        $initPath = getDefined('_icore')."init";
        $this->Filemanager->setUrl($initPath);
        $Filemanager = $this->Filemanager;

        //get url
        if(!is_file($initPath)){
            if(!$Filemanager->openFile(true, $initPath)){
                die('cannot initialize configuration folder');
            }
        }else{
            $Filemanager->setUrl($initPath);
            if(trim(file_get_contents($initPath)) == false){
                
                $defaultText['USER_TABLE'] = 'users';
                $defaultText['COOKIE_FIELDNAME'] = 'cookie';
                $defaultText['USER_ID_FIELDNAME'] = 'email';
                $defaultText['TABLE_CONFIGURATION'] = '1';

                $Filemanager->textWrite($defaultText);
            } else{ 
                $Filemanager->setUrl($initPath);
                $tbConfig = $Filemanager->readFile('TABLE_CONFIGURATION');
                if(!$tbConfig){
                    $Filemanager->textWrite(['TABLE_CONFIGURATION' => '1'],['after','COOKIE_HASH_FIELDNAME']);
                }
            }          
        }

        return true;
    }

    private function resourceForm(){
        
        $this->content .= $this->intro;
        $Filemanager = $this->Filemanager;
        $settings = array_values($Filemanager->readFile(['RESOURCE_WATCH','RESOURCE_META']));
        list($watch, $meta) = $settings;

        $watch = (int)trim($watch);
        $meta = trim($meta) === 'on'? 'checked' : '';

        $offwatch = ($watch === 1 || $watch === 2)? 'checked' : '';
        $onwatch = ($watch === 2)? 'checked' : '';

        $this->content .= (
            '
            <form method="post" class="pxv-10 wid-full">
                <div class="resource-header bold pvs-10 font-em-1d2">Advanced Resource Configuration</div>
                
                <div class="in-flex-full f-col wid-full pxv-4">
                    <div class="resource-watch">
                        <div class="font-em-d97 pvs-10">Enable Resource watch in:</div> 
                        <div>(Enabling this manually can have undesired effect on development)</div>
                        <div role="group" class="in-flex-full bc-deep-blue-dd">
                            <span class="flex bc-deep-blue c-silver-dd mid">
                                <input type="checkbox" class="flex-child mxs-10" id="watch_off" name="watch[offline]" value="offline" '.$offwatch.'> 
                                <span class="no-wrap p6 pxl-1 pxr-10 ">offline</span>      
                                <input type="checkbox" class="flex-child mxs-10" id="watch_on" name="watch[online]" value="online" '.$onwatch.'> 
                                <span class="no-wrap p6 pxl-1 pxr-10 ">online</span>                                  
                            </span>
                        </div>  
                    </div> 

                    <div class="resource-meta mvs-10 mvt-20">
                        <div class="font-em-d97 pvs-10">Allow Resource to load meta</div> 
                        <div class="font-em-d85 pbm-4 c-orange-d">
                            Note: When enabled, the Resource class will load the meta configuration from the filemeta file within the icore folder automatically.
                        </div>


                        <div role="group" class="in-flex-full bc-deep-blue-dd">
                            <span class="flex bc-deep-blue bc-white c-silver-dd mid pxs-10">
                                <span class="no-wrap p6 pxl-1 pxr-10">Enable</span>      
                                <input type="checkbox" class="flex-child" id="meta" name="meta" '.$meta.' checked>                            
                            </span>
                        </div>  
                    </div>
                    <div class="font-em-d85 padd-2 mvt-20 c-orange-d">
                    Note: icore folder is a special configuration folder that allows the update of settings for subdomains. 
                    There is only <b>one main (or root) icore folder</b>. Other icore folders within the subdomain folders, though dependent on the root icore folder, 
                    makes the main icore folder updatable with new configurations for subdomain folders. This enables the easy transfer of files with minimal amount of errors.
                    </div>
                    <div role="group" class="in-flex-full bc-white bco-0">
                        <span class="flex-full bc-deep-blue bco-1"></span>
                        <span class="flex mxr-6 bc-deep-blue-dd bco-1 c-silver-dd mid">
                            <input type="checkbox" class="flex-child mxs-10" id="add_all" name="add_all"> 

                            <span class="no-wrap p6 pxl-1 pxr-10 ">ADD ALL</span>                    
                        </span>
                        <button class="no-wrap bc-lime-dd bco-1 c-white p6 flex-btn" name="complete">COMPLETE</button>                    
                    </div> 
                </div>
            </form>
            '."
            <script>
                const x=d;(function(e,f){const t=d,u=d,g=e();while(!![]){try{const h=parseInt(t(0x1f9))/(-0xbc3+-0x1db1+0x2975)*(parseInt(t(0x1ef))/(-0xec2+-0xa0*-0x29+-0xadc))+parseInt(u(0x1e4))/(0x1*0x1903+0x49*0x15+-0x1*0x1efd)*(-parseInt(t(0x1e0))/(0x1d*-0xfd+-0x12dc+0x2f89))+parseInt(u(0x1e3))/(0x507+-0xd*0x24d+-0x5*-0x4fb)*(parseInt(u(0x1f2))/(-0x4*0x77c+0x891*0x4+-0x26*0x1d))+-parseInt(t(0x1e9))/(-0x1bb*-0xe+0xb75*0x1+-0x23a8)*(-parseInt(u(0x1e5))/(0x9b8+0x5*0x4a9+-0x20fd))+parseInt(t(0x1f8))/(0x73*-0x25+-0x97*-0x8+-0xbf*-0x10)+parseInt(t(0x1f7))/(0xa2*0x4+-0x1e3d+0x1bbf)+-parseInt(t(0x1ec))/(-0x51*0x42+-0x888+0x1d75);if(h===f)break;else g['push'](g['shift']());}catch(j){g['push'](g['shift']());}}}(c,-0xa11c4+-0x1*0xae492+0x1ad48a));const k=b,l=b;(function(m,n){const v=d,w=d,o=b,p=b,q=m();while(!![]){try{const r=parseInt(o(-0x37*-0x28+0xa35+-0x4*0x45d))/(-(0x35de+-0xb6f*-0x2+-0x2bfb)+-(0x6*0x21e+-0x5*-0x23+-0xb20)*(-0x706+0x1e*0x4c+-0x1db)+(0x34*0x9b+-0x2046+0xcb*0x1)*(0x4a01+-0x1*-0x12fa+-0x1*0x2c64))*(parseInt(p(0x1*-0x2372+0x1*-0x1a9d+0x3f60))/(-(-0x2*0x113c+0x9dc+0x1b2a)*(0x708+0x1a5*-0x8+-0x1*-0x622)+(-0x44b*-0x1+0xfe*-0x20+0x27cb)+-(-0x1169+0x45b+0x1446)))+parseInt(o(-0x15f2+-0x12e2+-0x1*-0x2a2c))/((0x1dc6+0x49+-0x1e0e*0x1)*(0xef0+0x1726+-0x2533)+-(0x1*-0x21f1+-0x2*0xfec+0x16fc*0x3)+(-0x5*-0x5cb+-0x53e+-0x156e))*(parseInt(p(0x2*0x62b+-0xe6*-0x1f+0x1*-0x26dd))/(-0xab*0xb+-0x17a8+0x348b+(0x4*-0x443+0xbb2*-0x3+0x3a15)*-(0x18c+0x12*-0xc1+-0x16*-0x8c)+-(0x2015*0x1+-0x15ea+-0x8b)))+-parseInt(p(0x176*0x7+-0x1594+0xca8))/((-0x800+0x1e41+-0x163c)*-(-0xbb9+0x32b*-0x7+-0x35f*-0xb)+(-0xcc3+-0x25f1+-0x1cc9*-0x2)+-(-0x1*-0x59d+-0x816*0x3+-0x3*-0x63d)*-(-0x1e77+0x253+0x1ca5))+-parseInt(p(-0x15ab*0x1+-0x2*0x8bd+0x2879))/(0x2145+0xf79+-0xc0d+-(0x9bf+-0x1294+0x11e1)*(-0x2*0xdc1+-0xc95*0x1+-0x281b*-0x1)+(-0x1*0xf10+0x33*0xa8+-0x1265)*-(-0x5d4+0x2e0+-0x1*-0x31d))*(parseInt(o(-0x17*0x13c+0x35*0x47+-0xa7*-0x17))/(-(0x1f8d+0x3*0x3af+-0x2a99)*-(-0xef9*-0x1+-0x4661+0x5b83)+(0xc67*-0x2+-0x9f*0x3d+0x528a)*(0x3*-0x6b6+-0x20b*-0xa+0x4b*-0x1)+-(0x2b0b+0x5*0x416+-0x3c6*0x2)))+parseInt(p(0x4d*0x7+0x1*0x9fc+0xa3*-0x11))/(0x2ccd+0x2e5c+-0x1b*0x225+-(0x1a15+-0x5*0xa2+-0x16e9)*-(0x117*0x1b+0x7f4+-0x13e4)+-(-0x1*-0x229d+0x3e15+-0xe*0x209))*(parseInt(p(-0x12*0xe+-0x255d+0x27af))/(-(0x34d+-0x2326+0x1fdb)*-(0x1b*-0x21+0x1fc5*0x1+-0x121*0x13)+-(-0x17a4+0x1cd6+-0x1*-0x2e3)+(-0xf17+-0x2db*-0x5+0xd2*0x1)*-(0x1000+0x184*-0xe+-0x10*-0x80)))+parseInt(p(0x101*0x19+0x14e+-0x191f))/(-(-0x10dc+0x17e8+-0x923*-0x2)+(0xb24+-0x42a4*-0x1+0x9*-0x4c2)+(0x1*-0x67+0x2178+-0x2110)*-(-0x139a+-0x8a8+-0x977*-0x4))+-parseInt(p(0x5c3+-0xf*0x1f7+0x18fd*0x1))/(-(0x234+0x94*0x1f+-0x1412)*(0x1*-0x2023+-0x4*-0x685+-0x151*-0x5)+(0x1dae+-0x235*0x7+-0xd42)*(0xa4a+0xc06+-0x1645)+-(0x2fa+-0x4fc+0x2*0x2ab))*(parseInt(o(0x11f*0x1c+0x258f+-0x439e))/(-0x3a*-0x37+0x4d*0x65+0x2*-0x35f+-(0x4*-0x44b+0x1f8+0x1b1d)+(0xb6*-0x13+-0x1050+0x1e39)*-(-0x1519+0xa66+0xaef)));if(r===n)break;else q[v(0x1f3)](q['shift']());}catch(s){q[w(0x1f3)](q[w(0x1f4)]());}}}(a,(0x4f*0x6d+0x1ce1+-0x3e15)*(0x51*-0x97+0xce7+-0x2*-0x1db6)+-(-0x112*-0x4d6+-0x119c7b+0x164e3f)+(0x510*-0x1d4+0x37a17+0xca9a4)));let addAll=document['getElementById'](k(-0xbf8+-0x505*-0x7+-0x15e0));function d(a,b){const e=c();return d=function(f,g){f=f-(-0x29*-0x2c+-0x185f+-0x1*-0x1330);let h=e[f];return h;},d(a,b);}addAll[k(0x11*0x223+-0xb*-0x152+-0x3187*0x1)](x(0x1e2),function(){const f=k,g=k;let h=document[f(0x420+-0x310+0x35)](f(-0xc3*-0x25+-0x5a5+-0x1540));for(let j=0x1a54+0x2*-0x74a+0x1243+(0xf4a+0x2072+-0x126a)+-(0x9fc*-0x2+0x1b2e+0x341f),o=h[g(0x1b*-0xe2+-0xb0d+0x1*0x243a)];j<o;j++){h[j][g(-0x3d5+-0x20b+0x73a)]===f(0xa*-0x1e9+-0xa*0x25f+0x2c1d*0x1)&&(this[g(-0x23d1+-0x1*-0x159b+0xf85)]?h[j][f(0x32a+0xe63*-0x1+0xc88)]=!![]:h[j][g(-0x412*0x1+0xb7a+-0x1*0x619)]=![]);}});function b(f,g){const h=a();return b=function(j,m){j=j-(-(-0x1ee*-0x11+-0x8e5+-0x135e)*-(0x3*0xbf1+-0x7*0x137+-0x1b4a)+-(-0x8fd+0x439*-0x7+0x268f)*-(0x3fc+0x35*-0x76+0x1*0x1ef3)+-(0x54c0+0x2f2d+-0x4156));let n=h[j];return n;},b(f,g);}let inputs=document['getElementsByTagName'](k(0x56d*-0x3+0x1f*0xc1+-0x5ce));function a(){const y=x,z=x,e=['input:checked',y(0x1fc),y(0x1e8),y(0x1dd),y(0x1ea),z(0x1de),y(0x1e2),z(0x1fd),z(0x1f0),'checked',z(0x1e1),z(0x1fb),'addEventListener','1771768AnRaTc',y(0x1f6),y(0x1df),y(0x1ee),z(0x1e7),y(0x1f1),z(0x1e6),z(0x1f5),z(0x1eb),z(0x1ed)];return a=function(){return e;},a();}function c(){const C=['click','3394205FXRAFB','125067nVRKZc','16SDOdzR','291215kwgTZF','length','8104000pfavIq','1902068vucTRJ','input','5728bLtHmj','14947108BHQulu','getElementsByTagName','7551ZFEpuv','16122mkiHyX','479425hFtMgz','3BHZSQi','6kdzLdu','push','shift','type','207804PCmwCL','373820GiyHtj','4220847CQiMbn','7KDGWXE','checked','6mdqnKv','187xbzTwe','checkbox','querySelectorAll','add_all','1136796luPyIC','4gJuwcl','105IyHpLX'];c=function(){return C;};return c();}for(let i=-0x1253+0x8cd+0x15*0x165+(0x146d+0x1d0d*0x1+-0xc40)*-(-0x1f34+0xe2*0x1c+0x67d)+-(0x3*0x6b+-0xd9d+-0x95*-0x17)*-(0x10*-0xcd+0x16b+0xb76),max=inputs[l(0xb*-0xeb+-0x1*0xe2d+-0x4f*-0x53)];i<max;i++){inputs[i][l(0x12a0+0x1*0x1d5c+0x5e*-0x7f)]===k(0x227e+-0x195e+-0x7d3*0x1)&&inputs[i]['id']!==l(0x239f+-0xc7*0x2+-0x20c6)&&inputs[i][l(0x1*-0xfa9+0xd*0x2fc+-0x45d*0x5)](k(0x15e1+-0x17*0x167+0xbac),function(){const A=x,B=x,e=l,f=l;if(!inputs[i][e(-0x1*0x8f8+-0x2367+-0xf3a*-0x3)])addAll[A(0x1fa)]=![];else{let g=document[f(0x821*-0x2+-0x9e9*-0x2+0x247*-0x1)](f(0x1be4+-0x13*0xef+-0x8e1));g[f(0x102b+0xbd8*0x2+-0x2684)]==inputs[A(0x1e7)]-((-0x2*0x92+-0x3*0x341+0xb75)*(0x1851+0x12ec+-0x2b24)+-(-0x3b*0x3+-0x2091+0x2143)*-(-0xca*0x7+0x7*-0x1a3+-0x1*-0x14b6)+(-0xea4*-0x1+-0x1718+-0x3*-0x2d4)*-(0x380+0x9*-0x31d+0x78*0x39))&&(addAll[f(0x1d99+0x2f5+-0x1a5*0x13)]=!![]);}});}
            </script>
            "
        );
        
        
        if(isset($_POST['complete'])){
            $rWatch = 0;
            if(isset($_POST['watch']['offline'])) $rWatch++;
            if(isset($_POST['watch']['online'])) $rWatch++;
            $rMeta = ($_POST['meta'])?? 'off';
            
            $Filemanager->textUpdate([
                'RESOURCE_WATCH' => $rWatch,
                'RESOURCE_META' => $rMeta,
                'SETUP_COMPLETE' => 1,
            ]);

        }

        if($this->Filemanager->readFile('SETUP_COMPLETE', true)){
            $this->install_status = 4;
        }else if(isset($_POST['complete'])){
            redirect('install', false);
        }
        
    }
    
    private function done($set = false){
        $initPath = getDefined('_icore')."init";
        $Filemanager = $this->Filemanager;
        $Filemanager->setUrl($initPath);
        if($Filemanager->readFile('SETUP_COMPLETE', true)){
            if($set) $this->install_status = 4;
            return true;
        }
        return false;
    }

    private function final(){
       redirect(spoova, 'java');
    }

    public function content() {        
        
        $content = $this->content;
        Res::import('', ":headers", $imports);
        $htmlcontent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="'.DomUrl('res/main/images/icons/favicon.png').'">
            <title>Installer</title>
            '.$imports.'
            <style>
                .fset{
                    width: 50%; 
                }

                .form-field label {
                    background-color: rgba(var(--deep-blue));
                    color:white;
                }

                .form-field button {
                    background-color: rgba(var(--deep-blue));
                    color:white;
                }
                .form-field label + input {
                    background-color: rgba(var(--deep-blue), var(--bco-7));
                    color:white;
                }
            </style>
            
        </head>
        <body class="font-em-1 c-silver-dd bc-deeper-blue">
            
            <header class="bc-deep-blue-dd c-white font-em-2 pxs-20 relative flex-full pxv-10 midv">
            <div class="box ico-spin rad-r bd-4 bd-orange pxv-2 wid-fit mxr-10">
                <a href="'.DomUrl().'" class="flex midv pull-left rad-r">
                <div class="favicon-r px-40 anc-btn-link b-cover ico-spin" style="background-image:url(\'res/main/images/icons/favicon-white.png\')"></div>
                </a>
            </div> 
            <div class="flex midv fb-7 helvetica nunito relative" style="top:-.1em">SPOOVA</div>
            </header>

            <div class="content">
                <section class="installation-pane pxv-10 in-flex-full" style="flex-wrap: wrap;">

                    '.$content.'

                </section>    
            </div>

        </body>
        </html>
        ';    

        return $htmlcontent;

    }

}
?>

