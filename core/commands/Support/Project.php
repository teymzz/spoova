<?php

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 *  This may cause app to break or lead to other undesired errors.
 */
namespace spoova\mi\core\commands\Support;

use spoova\mi\core\classes\Bundle\Filemanager\FileCompressor;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPrompt;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\commands\Root\Welcome;
use spoova\mi\core\commands\Support\Handlers\Sanitize;
use spoova\mi\core\commands\Support\Map;
use ZipArchive;

class Project extends Entry{

    private bool $recompile = false;

    /**
     * array of arguments
     *
     * @param array $args
     */
    function __construct($args = []) {

        /* sanitize reports rather than builds, so it is handled before the project
           builder claims the first argument as a new project name */
        if(strtolower((string) ($args[0] ?? '')) === 'sanitize'){
            array_shift($args);
            new Sanitize(array_values($args));
            return;
        }

        Cli::animeType('roller');
        Cli::runAnime([[$this, 'build'], $args]);

    }

    public function build(array $args) {
  
        Cli::loadTime(10000);

        if(!$this->validate_arguments($args)) {     
            yield false;
            return false;
        }
        
        // Handle environmental directive
        if(!is_file(_core.'custom/app')){        
            Cli::textView(
                Cli::danger(Cli::emos('hot', 1).'Spoova:')
                .Cli::warn(''), '1', [1, 2]
            );
            Cli::textView(Cli::error('invalid command "'.Cli::warn('project').'"', '1'));
            Cli::break(2);
            yield false;
        }
        
        // Create a new spack file if missing
        if (!is_file(SP_SPACK) || $this->recompile) {
            Cli::textView(
                Cli::danger(Cli::emos('hot', 1).'Spoova Project:')
                .Cli::warn(''), 1, [1, 2]
            );
            Cli::textView(Cli::error('missing project compiler!'), '1', "|2");
            Cli::textView(Cli::alert('Fix 1:', '1').(' ensure project pack name is : ').'"'.Cli::warn('spoova').'"', 0, "|2");
            Cli::textView(Cli::alert('Fix 2:', '1').(' try running - ').'"'.Cli::warn('php mi repack').'" command.', 0, "|2");
            yield false;
        } 

        //default options
        $entryFile = "Index";
        $settings['projectLogic'] = 'standard';
        $settings['webInstaller'] = true;

        //Project Logic
        Cli::textView(Cli::alert("What project logic do you prefer to use?"), 0, '|2');
        $logics = ['basic', 'index', 'standard'];
        Cli::list($logics, 0, '|1');

        $response1 = Cli::prompt(['1','2','3', 'basic', 'index', 'standard'], function(CliPrompt $prompt){
            
            $prompt->query(br().Cli::warn('Logic: '));
            
            if($prompt->inactive() && !$prompt->imatches($prompt->options())){
                Cli::response(false, 'Program exited due to bad response');
                Cli::errorView('invalid option supplied!', break:'1')->exit();
            }

        })->value();

        if(is_numeric($response1)) $response1 -= 1;
        
        $logic = $logics[$response1]?? $response1; //get logic name

        if($logic === 'basic'){

            Cli::break();

            $input = Cli::q([], function(){

                return [

                    'init' => function(){
                        Cli::textView(Cli::alert('Please input a base window file name: '));
                    },

                    'test' => function($input) {
                       return preg_match("~^[a-zA-Z][a-zA-Z_0-9]+$~", $input->value(), $matches)? true : false;
                    },

                    'failed' => function($input, $options, $counter){
                        Cli::clearUp().Cli::clearLine();
                        Cli::textView(Cli::error("invalid file name supplied!"), 0, "|2");
                        return true;
                    },

                    'maximum' => fn() =>  Cli::textView(Cli::error("maximum number of trials reached"))

                ];

            }, 4);

            if(Cli::qFailed()){
                return false;
            }

            $choice = Cli::q('', function() use($input) {

                return [

                    'init' => function() use($input) {
                        Cli::textView(Cli::alert('Window basic file name is "'.Cli::warn(ucfirst($input)).'" [Y/N] '), 0, "1");
                    },

                    'test' => function($input){
                        $input =  strtolower($input);
                        $valids = ['y', 'n'];
                        return in_array($input, $valids);
                    },

                    'failed' => function($input, $options, $counter) {

                        Cli::textView(Cli::error("invalid option supplied!"), 0, "|1");
                        return true;

                    },

                    'maximum' => fn() => Cli::textView(Cli::error("maximum number of trials reached"))

                ];

            }, 4);

            if(Cli::qFailed() || (strtolower($choice) === 'n')){
                                
                Cli::textView(br().Cli::alert("Use basic file name as \"".Cli::warn('Basic')."\"?"));

                $response5 = Cli::q(['y'], fn() => 

                    [
                        'init' => fn() => Cli::textView("Press ".Cli::warn("\"Y\"")." to continue or any key to abort: ", 0, 1),
                        'test' => function($input){
                            return in_array(strtolower($input), $input->options());
                        },

                        'maximum' => fn() => Cli::textView(Cli::error("maximum number of trials reached"), 0, "|1"),

                        'failed' => function() {
                            Cli::textView(Cli::error("process terminated"), 0, "1|2");
                            exit;
                        }

                    ]
            
                );

                $entryFile = "Basic";

            }else{
                $entryFile = $input;
            }
        }elseif( ($logic === 'index') || ($logic === 'standard') ) {
            $entryFile = "Index";
        }

        $baseLogic = $logic;

        if($logic === 'standard') {
            $logic = '';
        }else{
            $logic = "'$entryFile'";
        }
        
        Cli::break();

        //Add web installer
        $response2 = Cli::q(['y','n'], fn() => 

            [
                'init' => fn() => Cli::textView(Cli::alert("Add a web installer page? [Y/N] ")),
                'test' => function($input, $options){
                    return in_array(strtolower($input), $input->options());
                },

                'maximum' => fn() => Cli::textView(Cli::error("maximum number of trials reached"), 0, "|1"),

                'failed' => function() {
                    Cli::textView(Cli::error("invalid option supplied!"), 0, "|1");
                    return true;
                }

            ], 4
    
        );

        $addInstaller = false;

        if(Cli::qFailed()){
            if(Cli::qmax()){
                
                Cli::textView(br().Cli::alert("No web installer page will be added"));

                $response5 = Cli::q('y', fn() => 

                    [
                        'init' => fn() => Cli::textView("Press ".Cli::warn("\"Y\"")." to continue or any key to abort: ", 0, 1),
                        'test' => function($input){
                            return strtolower($input) === $input->options();
                        },

                        'maximum' => fn() => Cli::textView(Cli::error("maximum number of trials reached"), 0, "|1"),

                        'failed' => function() {
                            Cli::textView(Cli::error("process terminated"), 0, "1|2");
                            exit;
                        }

                    ]
            
                );

                $addInstaller = false;

            }
        }else{
            $addInstaller = (strtolower($response2) === 'y');
        }

        //set the project name
        $project_name = $args[0];

        //write text, delay 2 seconds, break 2 lines
        Cli::textView(
            Cli::alert(Cli::emo('bullet').' Build APP')
            .Cli::emo('colon', '1|1')
            .Cli::warn($project_name), break: '1|2'
        );

        //write text, run animation 10 times
        yield from Cli::play(20, Cli::textBuild(':checking environment ', '2'), function(){
            Cli::stop()->clearView(':checked environment '.Cli::emo('checkmark'), '2')->pause(1);
        });

        Cli::loadTime(100000);

        # Load configurations ---------------------------------
        Cli::clearLine();
        
        yield from Cli::play(6, Cli::textBuild(':loading configurations ', '2'), callback: fn() => Cli::stop()); //run animation 6 times  
 
        //load app configurations
        $app = Filemanager::load(_core.'custom/app');

        $app_name = $app['spack']?? '';
        $app_path = $app['path']?? '';
        $app_root = $app['root']?? '';

        $app_crest = ($app_root)? $app_root : $app_path;
        $app_file  = rtrim($app_crest,'/ ').DS.$app_name;
        $zip_path = dirname(docroot). DS. $args[0].".zip";

        $Filemanager = new Filemanager;
        $Filemanager->setUrl($app_file);
        $Filemanager->copyTo(dirname(docroot), $args[0].".zip");

        # Decompressing -----------------------------------------
        Cli::clearLine();
        yield from Cli::play(10, Cli::textBuild(':decompressing', '2|1'), callback: fn() => Cli::stop()->clearView(':decompressing... ', '2'));
        
        $Filemanager->zipProgress(function(FileCompressor $info) use(&$i){
                
            if($info->status === 0) Cli::clearLine();
            Cli::moveStart()->textView(Cli::color(Cli::emos('hot', 1),'blue').':decompressing...['.$info->status.'%]', 2);
            if($info->status > 99){
                Cli::pause(1)->clearLine();
                Cli::moveStart()->textView(Cli::color(Cli::emos('hot', 1),'blue').'decompressing...[100%] ')->pause(1);
            }
                
        });
        
        $Filemanager->setUrl(dirname(docroot).'/'.$args[0].".zip");
        $Filemanager->decompress();

        if($Filemanager->fails()){
            Cli::clearLine()->errorView($Filemanager->err())->break();
            Cli::clearLine()->errorView($Filemanager->err())->break();
            yield false;
        } 
        Cli::clearView(':decompressed '.Cli::emo('checkmark'), '2');
        
        # Create project -----------------------------------------
 
        //Remove unnecessary files from new folder
        $project_path = dirname(docroot).DS.$project_name;
        $removables = ['core/custom/app','core/custom/'.$app_name];

        $this->flushapp($project_path, $removables);
        
        Cli::pause(1);           
        
        Cli::clearView('project "'.Cli::alert($project_name).'" created successfully"', '3');

        Cli::break(2);
        Cli::animeType('arrows'); 
        Cli::textView(Cli::emos('pipe').'mapping project: ('.Cli::warn($project_name).')', '3'); 

        Cli::textView(br());

        $map = new Map([$project_name], false);
        
        if(!$map->mapped()) return; 
        
        Cli::clearView('project mapping successful', '3');
        Cli::pause(1)->clearLine();
        
        Cli::pulseView(Cli::textBuild('setting logic ...', '3'))->pulseToggle(3, 5);
        
        //use predefined logic 
        $LOGIC = static::logic($logic);
        $LOGIC_FILE = $project_path.DS.'index.php';

        file_put_contents($LOGIC_FILE, $LOGIC);

        if($logic === ''){
            /* add map file */
            (new Filemanager)->createFile($project_path.'/'.'windows/Routes/.map');
        }

        //finalize 
        $final = new Welcome(dirname(docroot).DS.$project_name);

        $final->build(['installer' => $addInstaller, 'entry_file' => $entryFile, 'logic' => $baseLogic ]);
        Cli::clearLine();

        // Remove zip file
        (new Filemanager)->removeFile($zip_path);

        // Check project port...
        if($path = self::newProject_running($project_name)){
            Cli::textView($project_name.Cli::emo('colon','1').$path, '3', '1', [2, 1]);
        } else {
            Cli::textView($project_name.' serve project manually.', '3', '1', [2, 1]);
        }

    }

    private static function newProject_running(string $path) :string|false {
        $candidates = [
            "http://localhost/".$path,
            "http://localhost:80/".$path,
            "http://localhost:8080/".$path
        ];

        foreach ($candidates as $url) {
            if(self::isServerReachable($url)){
                return $url;
            }
        }

        return false;
    }

    private static function isServerReachable(string $url) : bool {
        $ch  = \curl_init($url);
        \curl_setopt_array($ch, [
            \CURLOPT_NOBODY => true, // HEAD request, don't fetch body
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_TIMEOUT => 1,  // FAIL FAST 
            \CURLOPT_CONNECTTIMEOUT => 1
        ]);
        curl_exec($ch);
        $ok = \curl_errno($ch) === 0; // connected successfully (any HTTP status is fine)
        return $ok;
    }

    private function validate_arguments(array $args){

        Cli::headerView('project', break: 2);

        if(empty($args)){

            Cli::textView('creates a new project application', 0, 2);
            Cli::textView('Syntax:'.self::mi('project','','','').Cli::warn('<appName>'), 0, 1);
            return;

        }

        if(count($args) > 2) {
            Cli::errorView('Expecting maximum of 2 arguments!', break: 1);
            // $this->addError('Expecting maximum of 2 arguments!');
            return;
        }

        if(isset($args[1]) && ($args[1] != '-fresh')){
            Cli::errorView('unrecognized directive: "'.$args[1].'"', break: 1);
            return;            
        }

        $app_name = $args[0];

        preg_match_all('@\W+@',$app_name, $matches);
        $matches = $matches[0];

        if(!empty($matches)){
            Cli::errorView('invalid characters supplied as project name', break: 1);
            return false;            
        }

        if(is_dir((dirname(docroot).DS.$app_name))) {
            Cli::headerView('mi project', break: 2);
            Cli::textView(Cli::error('project "'.Cli::warn($app_name).'" already exists!'), 0, '|2');
            return false;
        }

        if(count($args) == 2){
            if($args[1] == '-fresh') {
                $this->recompile = true;
            }else{
                Cli::errorView('invalid directive "'.$args[1].'" ', break: 1);
                return false;                
            }
        }

        return true;
    }

    private function flushapp(string $project_path, array $files){
        foreach($files as $file) {
            $fpath = to_backslash($project_path.'/'.$file);
            if(is_file($fpath)){
                unlink($fpath);
            }
        }
    }
    
    private function logic(string $logic){
      return  <<<LOGIC
        <?php

        include 'icore/filebase.php';

        return server($logic);

        LOGIC;
    }

}