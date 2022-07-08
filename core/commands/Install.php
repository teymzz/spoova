<?php

namespace spoova\core\commands;
use spoova\core\classes\DB;
use spoova\core\classes\DBConfig;
use spoova\core\classes\FileManager;

/**
 * @package core/commands
 * @author Akinola Saheed <teymss@gmail.com> .
 * 
 * Handles the Installation of the init file
 */
class Install extends Entry{


    function __construct($args = []){


        $method = trim( ($args[0]?? ' ') );
        $dbname = trim( ($args[1]?? ' ') );
        $dburl  = trim( ($args[2]?? ' ') );

        if($method === 'app' || $args === 'app') {
            $this->app();
            return;            
        }             

        if($method === 'db'|| $method === '') {
            $this->install_db($dbname);
            return;
        }

        if($method === 'dbname') {
            $newargs = [$dbname];
            if($dburl) array_push($newargs, $dburl);
            $this->install_dbname(...$newargs);
            return;            
        }



        if(method_exists($this, $method)  && $method != 'complete_setup') {
            array_shift($args);
            $args = array_values($args);
            $this->$method(...$args);
            return;
        }

        $this->addError('command "'.implode(' ',$args).'" not recognized');
        return;

    }

    /**
     * Install spoova app
     *
     * @return void
     */
    private function app()
    {   

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            $this->addError('invalid command "app"');
            return false;
        }

        // Import FileManager
        $Filemanager = new FileManager;

        // Set crest file variables
        $crest_name = self::crest;
        $crest_path = _core.'custom/';
        $crest_file = _core.'custom/'.self::crest.'.re';
        $crest_root = '';
        
        $sys_cresp  = sys.'/'.self::crest;
        $sys_cresf  = sys.'/'.self::crest;

        // Generate a spack file 
        if(!is_file($crest_file)) {

            $Filemanager->setUrl(docroot);
            $Filemanager->zipUrl(_core.'custom/spoove');
            $Filemanager->moveTo(_core.'custom/',self::crest);

            if($Filemanager->fails()) {
                $this->addError($Filemanager->err()); 
                return;
            }

            //update app installer
            $Filemanager->setUrl(_core.'custom/app');
            $Filemanager->textUpdate(
                [   
                    'app'     => 'spoova',
                    'version' => SP_VERSION,
                    'spack'   => $crest_name,
                    'path'    => $crest_path,
                    'install' => '1',
                    'complete'=> 'false',
                ]);

        }

        //Read from app installer
        $Filemanager->setUrl(_core.'custom/app'); 
        $app = $Filemanager::load(_core.'custom/app');
    
        // Check Root App Installer
        if(is_file($sys_cresf)){

            if(is_readable($sys_cresf)){

                $crest_root = $sys_cresp;

                if(!isset($app['root']) || ($app['complete'] == 'false')){
                    $this->complete_setup($crest_root);
                } else {
                    $this->addLog('app already installed');
                }

            } else {
                 $this->addLog('app already installed');
            }
            return;

        }

        //* Handle no system root installer
        if($app['complete'] == 'true'){
            $this->addLog('app already installed');
            return;
        }

        //* Handle incomplete setup
        if(isset($app['root'])) $Filemanager->textDelete(['root']);
            
        // Try to generate a root app installer
        $Filemanager->setUrl($crest_file);
        $Filemanager->copyTo($sys_cresp, $crest_name);

        if($Filemanager->succeeds()){
            $this->addLog('Installation successful ...');
            if(is_writable($sys_cresp) && is_readable($sys_cresf)){
                $crest_root = $sys_cresp;
            }
        } else {
            $this->addLog('Skipping root installation ...');
        }

        sleep(2);
        $this->addLog('Completing setup ... ');

        $this->complete_setup($crest_root);
            
    }

    private function complete_setup(string $crest_root){

        $Filemanager = new FileManager;
        $Filemanager->setUrl(_core.'custom/app'); 

        if($crest_root){

            if(!$Filemanager->readFile('root', true)){
                $Filemanager->textWrite(
                    ['root' => $crest_root], ['after'=> 'spack']);
            } else {
                $Filemanager->textUpdate(['root' => $crest_root]);
            }


        }

        $Filemanager->textUpdate([
            'install' => '1',
            'complete'=> 'true',
        ]);

        $this->addLog('Installation completed successfully.');

    }

    /**
     * Try to install the database using default parameters
     *
     * @param string $url : optional url
     * @return void
     */
    private function install_db($url = ''){

        //*  Load offline connection parameters /
        if( !$offlineConfig = $this->loadDB((func_num_args() > 1? $url : false)) ) return;
        
        $offline = $offlineConfig ; //offline configurations

        $dbcon = new DB;  //new instance of default cconnection

        $isNamed = $offline['NAME']?? false;

        
        if($isNamed) {

            if($dbcon->openDB($offline)){
                if($dbcon->active()){
                    $this->addLog('Database "'.$isNamed.'" connected successfully ');
                    return;
                }
            } else {
                //Try to connect without database name
                if($dbcon->openTool($offline)){
                    $this->addError('Database connected but "'.$isNamed.'" failed to connect');
                }
            }

        } else {

            if($dbcon->openTool($offline)) {
                $this->addLog('Database connected. (No database name selected)');
            } else {
                $this->addError('Database connection failed.');
            }
            
        }

    }

    /**
     * Try to create a new database name using default parameters
     *
     * @param string $dname new database name
     * @param string $dbconfig_url : optional dbconfig file directory
     * @return void
     */
    private function install_dbname($dbname, $dbconfig_url = '') {
 
        if($dbname == '') {
            $this->addLog(">> install dbname <database_name> <optional_dbconfig_directory>");
            $this->addLog(str_repeat(" ", 14)."Note: optional directory as relative or absolute should not be started with a slash");
            return;
        }

        $configPath =  $dbconfig_url."/dbconfig.php";

        if( func_num_args() > 1 and !is_file($configPath) ){

            $this->addError(' cannot find "'.$configPath.'" '); 
            return;

        } else {

            $this->loadDB($configPath);
            return;

        }

        //*  Load offline connection parameters /        
        $url = (func_num_args() > 1)? [$dbconfig_url] : [];

        if(!$offlineConfig = $this->loadDB(...$url)) return ;

        if($db = ($dbcon = new DB)->openDB($offlineConfig)) {
      
            if($db->db_exists($dbname)) {
                $this->addLog('  Spoova says -> database "'.$dbname.'" already exists');
            } else {
                if($db->createDB($dbname)) {
                    $this->addLog('  Spoova says -> database "'.$dbname.'" created successfully  ');
                    return;
                }
                
                if($db->error()) { 
                    $this->addError('database "'.$dbname.'" failed to create');
                    $this->addLog('  Spoova says -> '.$db->error() );
                    return ;
                } 
            }        
            
        } else  {

            if($dbcon->error()) {
                $this->addError('database "'.$dbname.'" failed to create');
                $this->addError('Spoova says -> "'.$dbname.'" '.$dbcon->error());
            }

        }

    }

    /**
     * Load offline parameters from supplied dbconfig url
     *
     * @param string $dbconfig_url
     * @return void
     */
    private function loadDB($dbconfig_url = ''){

        //load the default database config file (To add dynamic url)
        $dbconfig_url = (func_num_args() > 0)? func_get_args()[0] : self::dbconfig_url();

        if(DBConfig::load($dbconfig_url, $dbconfig)){
            if(empty($dbconfig)){
                $this->addError('config file "'.$dbconfig_url.'" failed to load');
                $this->addLog('  No resolvable data found in file');           
                return ;    
            }
            $configs = array_trim($dbconfig['offline']); //get offline data
            unset($configs['SOCKET']); //unset any socket -- not using socket in offline mode
            return $configs;
        } else {
            $this->addError('config file "'.$dbconfig_url.'" failed to load');
            $this->addLog(DBConfig::response());
        }

        return false;
    }

}