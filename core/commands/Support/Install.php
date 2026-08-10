<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\DB\DBConfig;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli\CliPlay;
use User;

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com> .
 * 
 * Handles the Installation of the init file
 */
class Install extends Entry{


    function __construct(string|array $args = []){

        $method = trim( ($args[0]?? ' ') );
        $folname = trim( ($args[1]?? ' ') );

        if(is_string($args) || (is_array($args) && count($args) > 2)){
            $supplied = is_array($args)? implode(' ', $args) : $args;
            $this->display(Cli::danger(Cli::emo('point-list', '|1'). 'install'));
            Cli::textView(Cli::error("invalid number of arguments count supplied. ".$supplied), 0, "|2");
            return false;
        }
        if(!$method || ($max = (count($args) > 2))){
            if(empty($max)) Cli::textView(Cli::danger(Cli::emo('point-list', '|1'). 'install'), break:1);
            $this->display('Syntax :'.self::mi('install', '','','').Cli::warn('<args>', 1), 1);
            Cli::break();
            $this->display(self::mi('install ', '','','').Cli::warn('[db|dbname]').Cli::danger(" [folder?]"));
            $this->display(self::mi('install ', '','','').Cli::warn('db').Cli::emo("infinite-arrow","1|1").'tests default database connection parameters');
            $this->display(self::mi('install ', '','','').Cli::warn('dbname').Cli::emo("infinite-arrow","1|1").'adds default configured database name to database if not exist');
            $this->display(self::mi('install ', '','','').Cli::warn('[db|dbname]').Cli::danger('folder', '1').Cli::emo("infinite-arrow","1|1").'uses custom folder "icore/dbconfig.php" parameters');
            Cli::break();
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

        Cli::headerView('install app', break: 2);

        // Text 1: start test animation
        yield from Cli::play(5, Cli::warn('process: ').'installing application ...', 
            fn(CliPlay $anime) => $anime->stop(true, pause: 1)->switchTo('roller') 
        );

        yield from Cli::play(5, callback: true, pause: 2);

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            yield Cli::endAnime(0, 1, Cli::error('the command "app" is not enabled for this environment.'));
        }

        // Import Filemanager
        $Filemanager = new Filemanager;

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

            // Initialize spack message
            yield from Cli::play(5, Cli::warn('process: ').'generating spack file ...', pause: 1);

            // Every spack already on disk sits inside docroot, so without this the
            // archive swallows the previous one(s) and grows on every run. The output
            // archive is skipped for the same reason.
            $spackIgnores = ['backup', '.git'];

            $docRoot = rtrim(to_frontslash(docroot), '/').'/';
            $relPath = function(string $path) use($docRoot) : string {
                $path = to_frontslash($path);
                return (stripos($path, $docRoot) === 0)? substr($path, strlen($docRoot)) : $path;
            };

            foreach((glob(to_frontslash($crest_path).self::spack.'*') ?: []) as $oldSpack){
                $spackIgnores[] = $relPath($oldSpack);
            }

            $spackIgnores[] = $relPath(_core.'custom/spv.zip');

            // zip project file into core/custom/spv directory
            $Filemanager->setUrl(docroot);
            $Filemanager->zipUrl(_core.'custom/spv', $spackIgnores);
            
            Cli::loadTime(2000);

            // Spack: continues
            yield from Cli::play(20, pause: 1);

            if($Filemanager->zipped()){

                // Spack: continues
                yield from Cli::play(20, pause: 1);

                //continue with zipped file and move zip to defined directory with defined name
                $Filemanager->source(\to_dirslash(_core.'custom/spv.zip'));

                //unlink the previous spack of this same version only now, with the new
                //archive already built: a compression that broke above can no longer
                //discard the copy that still works. moveTo() refuses an existing
                //destination, so this has to clear the way immediately before it.
                $Filemanager->removeFile($crest_spac);

                $Filemanager->moveTo(_core.'custom/', self::crest);

            }
            // Spack: finalizes here .........................
            yield from Cli::play(20, callback: true, pause: 2); 

            if($Filemanager->fails()) {
                Cli::endAnime(0, 1, Cli::error($Filemanager->err()), 2); 
                return;
            }
            
            Cli::loadTime(5000);
            
            // Initialize app installer message ... 
            yield from Cli::play(5, Cli::warn('process: ').'updating installer ...', pause: 3);        

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
                
            // App Installer : continues loading ...            
            yield from Cli::play(20, callback: true);  

        }

        //Read from app installer
        $Filemanager->setUrl(_core.'custom/app'); 
        $app = $Filemanager::load(_core.'custom/app');

        // App Installer : continue loading ...
        yield from Cli::play(20, callback: fn() => Cli::stop());  

        //* Handle no system root installer
        if($app['complete'] == 'true'){
            yield Cli::endAnime(0, 2, Cli::notice('app already installed'), 2);
        }

        //* Handle incomplete setup
        if(isset($app['root'])) $Filemanager->textDelete(['root']);

        // Text 2: continue loading ...   
        Cli::pause(1);
        yield from Cli::play(20, callback: true); 
        yield from $this->complete_setup($crest_root);
            
    }

    private function complete_setup(string $crest_root){

        // Initialize complete setup message
        yield from Cli::play(5, Cli::warn('process: ').'completing installation ...', 
            fn(CliPlay $anime) => $anime->stop(true)->backspace(3)->switchTo('circle')
        );
        
        $Filemanager = new Filemanager;
        $Filemanager->setUrl(_core.'custom/app'); 

        if($crest_root){

            if(!$Filemanager->readFile('root', true)){
                $Filemanager->textWrite(
                    ['root' => $crest_root], ['after' => 'spack']);
            } else {
                $Filemanager->textUpdate(['root' => $crest_root]);
            }

        }
        
        yield from Cli::play(20, callback: true); //animation continues

        $Filemanager->textUpdate([
            'install' => '1',
            'complete'=> 'true',
        ]);
 
        yield from Cli::play(20, callback: false); //animation continues
        
        // Text 4: end animation ...
        Cli::textView(Cli::success('installation successful.'), break: 2);
        yield true;

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
                    'test' => fn($input) => in_array(strtolower($input->value()), $input->options()),
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
                Cli::textView("Syntax: ".self::mi('install ').Cli::warn('dbname ').Cli::danger("[folder?]"), '4', "1|2");
                if($response == '3') {
                    Cli::textView('Creates configured database name from the dbconfig file if it does not exist', '4', "0|2");
                    Cli::textView(Cli::warn('dbname').': creates default database name if not exist using default "icore/dbconfig.php" parameters.', '4', "|2");
                    Cli::textView(Cli::danger('folder').' (optional): custom sub-folder name which contains "icore/dbconfig.php" file.', '4', "|2");
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
                Cli::textView(Cli::notice('database "'.Cli::warn($dbname).'" already exists'), '2', "1|2");
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