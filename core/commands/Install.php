<?php

namespace teymzz\spoova\core\commands;
use teymzz\spoova\core\classes\DB;
use teymzz\spoova\core\classes\DB\DBConfig;
use teymzz\spoova\core\classes\FileManager;
use User;

/**
 * @author Akinola Saheed <teymss@gmail.com> .
 * 
 * Handles the Installation of the init file
 */
class Install extends Entry{


    function __construct($args = []){


        $method = trim( ($args[0]?? ' ') );
        $folname = trim( ($args[1]?? ' ') );
        //$dburl  = trim( ($args[2]?? ' ') );

        if(count($args) > 2){
            $this->display(Cli::danger(Cli::emo('point-list', '|1'). 'install'));
            Cli::textView(Cli::error("invalid number of arguments count supplied."), 0, "|2");
        }

        if(!$method || ($max = (count($args) > 2))){
            if(empty($max)) $this->display(Cli::danger(Cli::emo('point-list', '|1'). 'install'));
            $this->display('Syntax :'.self::mi('install', '','','').Cli::warn('<args>', 1), 1);
            $this->display(Cli::emo('ribbon-arrow', '2|1').self::mi('install ', '','','').Cli::warn('[db|dbname]', 0).Cli::danger(" [folder?]"));
            $this->display(Cli::emo('ribbon-arrow', '2|1').self::mi('install ', '','','').Cli::warn('db', 0).Cli::emo("infinite-arrow","1|1").'tests default database connection parameters');
            $this->display(Cli::emo('ribbon-arrow', '2|1').self::mi('install ', '','','').Cli::warn('dbname', 0).Cli::emo("infinite-arrow","1|1").'adds default configured database name to database if not exist');
            $this->display(Cli::emo('ribbon-arrow', '2|1').self::mi('install ', '','','').Cli::warn('[db|dbname]', 0).Cli::danger('folder', 1).Cli::emo("infinite-arrow","1|1").'uses custom folder "icore/dbconfig.php" parameters');
            return false;
        }


        if($method === 'app' || $args === 'app') {
            Cli::loadTime(50000);
            Cli::runAnime([[$this, 'app'], '']);
            return;            
        }         

        if($method === 'db') {
            //test default or custom folder dbconfig connection
            $this->install_db($folname);
            return;
        }

        if($method === 'dbname') {
            //$newargs = [$dbname];
            //if($dburl) array_push($newargs, $dburl);
            //create a database name for default or custom folder dbconfig connection
            $this->install_dbname($folname);
            return;            
        }

        if(method_exists($this, $method)  && $method != 'complete_setup') {
            array_shift($args);
            $args = array_values($args);
            $this->$method(...$args);
            return;
        }

        Cli::textView(Cli::error('command "'.implode(' ',$args).'" not recognized'), 0, "|2");
        return;

    }

    /**
     * Install spoova app
     *  - Generate an unexisting spack file and update custom app file 
     *
     * @return void
     */
    public function app()
    {   
        //Cli::animeType('roller');
        //$this->display(Cli::color(Cli::emo('point-list','|1'). "Install App", 'green'));
        
        // Text 1: start test animation
        yield from Cli::play(5, 2, 'Installing application');
        Cli::animeType('roller');
        yield from Cli::play(5);
        Cli::pause(3);
        yield from Cli::play(5);
        Cli::pause(3);
        yield false;

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            yield Cli::endAnime(0, 1, Cli::error('the command "app" is not enabled for this environment.'));
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

        // Generate a spack file 
        if(!is_file($crest_file)) {

            // zip project file into core/custom/spv directory
            $Filemanager->setUrl(docroot);
            $Filemanager->zipUrl(_core.'custom/spv');
            
            Cli::loadTime(2000);

            // Text 1: continue loading ...
            yield from Cli::play(20);

            if($Filemanager->zipped()){

                //unlink previous spack file...
                $Filemanager->removeFile($crest_spac);

                // Text 1: continue loading ...               
                yield from Cli::play(20); 

                //continue with zipped file and move zip to defined deirectory with defined name
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
     * Tries to connect to the database using default parameters defined
     *
     * @param string $folder : optional folder name
     * @return void
     */
    private function install_db($folder = ''){

        Cli::textView(Cli::danger(Cli::emos('point-list', 1).'install db '.$folder), 0, '0|1');

        $configUrl = ltrim($folder."/icore", " /");

        if((strpos($folder, "/") !== false) || (strpos($folder, "\\") !== false)){
            Cli::textView(Cli::error('subdirectory folder name must only be a name with no paths.'), 0, "1|2");
            return false;
        }elseif(!is_dir($configUrl)){
            Cli::textView(Cli::error('directory "'.Cli::warn($configUrl).'" does not exist'), 0, "1|2");
            return false;
        }elseif(!is_file($configUrl.'/dbconfig.php')){

            Cli::textView(Cli::error('Directory "'.Cli::warn($configUrl).'" does not contain a "dbconfig.php" file.'), 0, "1|2");

            return false;

        }else{
            $folder = $folder."/icore/dbconfig.php";
            $folder = ltrim($folder, "/");
        }

        //*  Load offline connection parameters /
        if( !$offlineConfig = $this->loadDB($folder)) {
            Cli::textView(Cli::error('invalid configuration parameters defined for "'.Cli::warn($folder).'"'));
            return;
        }
        
        $offline = $offlineConfig ; //offline configurations

        $dbcon = new DB;  //new instance of default cconnection

        $isNamed = $offline['NAME']?? false;

        if(strtolower($folder) !== 'icore/dbconfig.php') {
            $for = 'for "'.Cli::warn($folder).'" ' ;
        }else{
            $for = '';
        }

        if($isNamed) {

            if($dbcon->openDB($offline)){
                if($dbcon->active()){
                    Cli::textView(Cli::success('Database "'.$isNamed.'" connected successfully '.$for), 0, '1|2');
                    return;
                }
            } else {
                //Try to connect without database name
                if($dbcon->openTool($offline)){
                    Cli::textView(Cli::notice('Database connected but "'.$isNamed.'" failed to connect '.$for), 0, "1|2");
                }else{
                    Cli::textView(Cli::error('Database connection failed '.$for), 0, "1|2");
                }
            }

        } else {

            if($dbcon->openTool($offline)) {
                Cli::textView('Database connected '.$for.'(No database name selected)');
            } else {
                Cli::textView('Database connection failed '.$for);
            }
            
        }

    }

    /**
     * Try to create a new database name using default parameters
     *
     * @param string $folder : optional icore/dbconfig.php folder name
     * @return void
     */
    private function install_dbname($folder = '') {
 
        Cli::textView(Cli::danger(Cli::emos('point-list', 1).'install dbname '.$folder), 0, '0|2');

        if(trim($folder) == '') {


            Cli::textView('What will you like to do with this command', 0 , "|2");
            Cli::List(['Run command', 'View syntax', 'View syntax and description'], 0, "|1");;
            
            Cli::save(1, fn() => Cli::textView(Cli::emo('ribbon-arrow', "4|1"), 0, 1), true);

            $response = Cli::q([1, 2, 3], fn() => 
                [
                    'init' => fn() => '',
                    'test' => fn($input, $options) => in_array(strtolower($input), $options),
                    'maximum' => function() {
                         Cli::textView(Cli::error('maximum number of trials reached'), 0, '|2');
                         exit;
                    },
                    'failed' => function() {
                        Cli::clearUp();
                        Cli::fn(1);
                        return true;
                    }
                ], 4
            );

            if(CLi::qFailed()) {
                 echo Cli::textView(Cli::error('process terminated'), 0, "1|2");
                 return;
            }

            if(($response == 2) || ($response == 3)){
                Cli::textView("Syntax: ".self::mi('install ').Cli::warn('dbname ').Cli::danger("[folder?]"), 4, "1|2");
                if($response == '3') {
                    Cli::textView('Creates configured database name from the dbconfig file if it does not exist', 4, "0|2");
                    Cli::textView(Cli::warn('dbname').': creates default database name if not exist using default "icore/dbconfig.php" parameters.', 4, "|2");
                    Cli::textView(Cli::danger('folder').' (optional): custom sub-folder name which contains "icore/dbconfig.php" file.', 4, "|2");
                } 
                return;
            }

            if($response == 1){
                $dbname = User::config('DBNAME');

                if(!$dbname) {
                    Cli::textView(Cli::error('no default database name set in "icore.dbconfig.php" file'), 0, "|2");
                    return;
                }
            }
            
        }

        if(!$folder) $folder = domroot();

        $configPath =  rtrim($folder, '/ ')."/icore/dbconfig.php";

        if( func_num_args() > 0 and !is_file($configPath) ){

            Cli::error('cannot find "'.Cli::warn($configPath).'"', 0, "|2"); 
            return;

        } else {

            $folder = $configPath;

        }

        //*  Load offline connection parameters /        

        if(!$offlineConfig = $this->loadDB($folder)) {
            Cli::error('invalid configuration format detected in "'.Cli::warn($configPath).'"', 0, "|2");
            return ;
        }

        $dbname = ($offlineConfig['NAME']??'');

        if($db = ($dbcon = new DB)->openDB($offlineConfig)) {
    
            if($db->db_exists($dbname)) {
                Cli::textView(Cli::notice('database "'.Cli::warn($dbname).'" already exists'), 2, "1|2");
                return;
            } else {  

                if($db->createDB($dbname)) {
                    Cli::textView(Cli::success('database "'.Cli::warn($dbname).'" added successfully'), 0, "|2");
                    return;
                }
                
                if($db->error(true)) {

                    Cli::textView(Cli::error('database "'.Cli::warn($dbname).'" failed to create'), 0, '|2');
                    Cli::textView(Cli::error($db->error(true)), 0, "|2");
                    return;
                } 
            }        
            
        } else  {

            if($dbcon->error()) {
                //Cli::textView(Cli::error('database "'.$dbname.'" failed to create'), 0, "|2");
                Cli::textView(Cli::error('Database connection parameters failed for "'.Cli::warn($configPath).'"'), 0, "|2");
            }else{
                Cli::textView(Cli::error('something is wrong'));
            }

        }

    }

    /**
     * Load offline parameters from supplied dbconfig url
     *
     * @param string $dbconfig_url
     * @return array|void|false
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