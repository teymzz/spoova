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

        if(!$method){
            $this->display(Cli::danger(Cli::emo('point-list', '|1'). 'install'));
            $this->display('Syntax :'.self::mi('install', '','','').Cli::warn('<args>', 1), 1);
            $this->display(Cli::emo('ribbon-arrow', '2|1').self::mi('install:', '','','').Cli::warn('[app|db|dbname]', 0));
            $this->display(Cli::notice('NOTE:').Cli::warn('install app', 0).' is the same as '.Cli::warn('install:app', 0), 1);
            return false;
        }

        if($method === 'app' || $args === 'app') {

            Cli::loadTime(50000);
            Cli::runAnime([[$this, 'app'], '']);
            //$this->app();
            return;            
        }         

        if($method === 'db') {
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
    public function app()
    {   
        Cli::animeType('roller');
        $this->display(Cli::color(Cli::emo('point-list','|1'). "Install App", 'green'));
        
        // Text 1: start test animation
        yield from Cli::play(5, 2, 'Installing application');
        //Cli::animeType('roller');
        yield from Cli::play(5);
        Cli::pause(3);
        yield from Cli::play(5);
        Cli::pause(3);
        yield false;

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            yield Cli::endAnime(0, 1, Cli::error('invalid command "app"'));
        }

        // Import FileManager
        $Filemanager = new FileManager;

        // Set crest file variables
        $crest_name = self::crest;
        $crest_path = _core.'custom/';
        $crest_spac = _core.'custom/'.self::crest;
        $crest_file = _core.'custom/'.self::crest.'.re';
        $crest_root = '';
        
        $sys_cresp  = sys.'/'.self::crest;
        $sys_cresf  = sys.'/'.self::crest;

        //NOTE: Root installation was suspended

        // Generate a spack file 
        if(!is_file($crest_file)) {

            $Filemanager->setUrl(docroot);
            $Filemanager->zipUrl(_core.'custom/spv');
            
            Cli::loadTime(2000);

            // Text 1: continue loading ...
            yield from Cli::play(20);

            if($Filemanager->zipped()){

                //unlink previous spack file...
                if(is_file($crest_spac)) unlink($crest_spac);

                // Text 1: continue loading ...               
                yield from Cli::play(20); 

                $Filemanager->moveTo(_core.'custom/', self::crest);
            }

            // Text 1: continue loading ...                  
            yield Cli::play(20); 

            if($Filemanager->fails()) {
                Cli::endAnime(0, 1, Cli::error($Filemanager->err()), 2); 
                return;
            }
            
            Cli::loadTime(5000);
            
            // Text 2: uploading app installer ... 
            Cli::break(1);
            yield from Cli::play(5, 2, 'Updating application installer ...');           
            yield Cli::play(20);             

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
                
            // Text 2: continue loading ...            
            yield Cli::play(20);  

        }

        //Read from app installer
        $Filemanager->setUrl(_core.'custom/app'); 
        $app = $Filemanager::load(_core.'custom/app');

        // Text 2: continue loading ...
        yield Cli::play(20);  

        //* Handle no system root installer
        if($app['complete'] == 'true'){
            yield Cli::endAnime(0, 2, Cli::notice('app already installed'), 2);
        }

        //* Handle incomplete setup
        if(isset($app['root'])) $Filemanager->textDelete(['root']);

        // Text 2: continue loading ...   
        Cli::pause(1);
        yield from Cli::play(10, 0, ''); 
        Cli::break(1);

        yield from $this->complete_setup($crest_root);
            
    }

    private function complete_setup(string $crest_root){

        $Filemanager = new FileManager;
        $Filemanager->setUrl(_core.'custom/app'); 

        // Text 3 : Complete installation from app()
        yield from Cli::play(5, 2, 'completing installation ...');

        if($crest_root){

            if(!$Filemanager->readFile('root', true)){
                $Filemanager->textWrite(
                    ['root' => $crest_root], ['after' => 'spack']);
            } else {
                $Filemanager->textUpdate(['root' => $crest_root]);
            }

        }

        //Text 3: Change animation type. 
        Cli::animeType('circle');

        // Text 3: Continue animation ... 
        yield from Cli::play(20, 0, ''); //animation continues

        $Filemanager->textUpdate([
            'install' => '1',
            'complete'=> 'true',
        ]);

        // Text 3: continue animation ... 
        yield from Cli::play(20, 0, '');
        
        // Text 4: end animation ... 
        yield Cli::endAnime(2, 1, Cli::success('Installation successful.'), 2);

    }

    /**
     * Try to install the database using default parameters
     *
     * @param string $url : optional url
     * @return void
     */
    private function install_db($url = ''){

        //*  Load offline connection parameters /
        if( !$offlineConfig = $this->loadDB( (func_num_args() > 1? $url : false)) ) return;
        
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

        if(!$dbconfig_url) $dbconfig_url = domroot();

        $configPath =  rtrim($dbconfig_url, '/ ')."/dbconfig.php";

        if( func_num_args() > 1 and !is_file($configPath) ){

            Cli::error('cannot find "'.$configPath.'"'); 
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
            $this->display(Cli::error('config file "'.$dbconfig_url.'" failed to load'));
            $this->display(Cli::error('database config '.DBConfig::response()));

            if(!is_file($dbconfig_url)) $this->display(Cli::warn('Debug:').'database config path is invalid or missing!');
        }

        return false;
    }

}