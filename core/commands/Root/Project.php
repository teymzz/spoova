<?php

/**
 * @author Akinola Saheed <teymss@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 *  This may cause app to break or lead to other undesired errors.
 */
namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\FileManager;
use spoova\mi\core\commands\Root\Welcome;
use spoova\mi\core\commands\Root\Map;
use spoova\mi\core\commands\Root\Entry;


class Project extends Entry{

    private $recompile;

    /**
     * array of arguments
     *
     * @param array $args
     */
    function __construct($args = []) {

        Cli::animeType('roller');
        Cli::runAnime([[$this, 'build'], $args]);

    }

    public function build($args) {

        Cli::loadTime(10000);

        if(!$this->validate_arguments($args)) {     
            yield false;
            return false;
        }
        
        // Handle environmental directive
        if(!is_file(_core.'custom/app')){        
            //write text, delay 2 seconds, break 2 lines
            Cli::textView(
                Cli::danger(Cli::emos('hot', 1).'Spoova:')
                .Cli::warn(''), 1, [1, 2]
            );
            Cli::textView(Cli::error('invalid command "'.Cli::warn('project').'"', 1));
            Cli::break(2);
            yield false;
        }
        
        // Create a new spack file if missing
        if (!is_file(SP_SPACK) || $this->recompile) {
            Cli::textView(
                Cli::danger(Cli::emos('hot', 1).'Spoova Project:')
                .Cli::warn(''), 1, [1, 2]
            );
            Cli::textView(Cli::error('missing project compiler!'), 1, "|2");
            Cli::textView(Cli::alert('Fix:', 1).(' try running - ').'"'.Cli::warn('php mi repack').'" first.', 0, "|2");
            yield false;
        } else {
            Cli::break(2);
        }

        //default options
        $entryFile = "Index";
        $settings['projectLogic'] = 'standard';
        $settings['webInstaller'] = true;

        //Project Logic
        Cli::textView(Cli::alert("What project logic do you prefer to use?"), 0, '|2');
        $logics = ['basic', 'index', 'standard'];
        Cli::list($logics, 0, '|1');
        Cli::textView(br().Cli::warn('Logic: '), 2);

        $response1 = Cli::prompt(['1','2','3', 'basic', 'index', 'standard'], function($input, $options){

            if(Cli::promptInvalid($input, $options)) {
                Cli::clearLine();
                Cli::textView(Cli::error("Please choose a valid logic in [1, 2, 3]"), 0, "|1");
                Cli::textView(br().Cli::warn('Logic: '), 2);
            }

        });

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
                       return preg_match("~^[a-zA-Z][a-zA-Z_0-9]+$~", $input, $matches)? true : false;
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
                        'test' => function($input, $options){
                            return in_array(strtolower($input), $options);
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

        //Add web installer
        $response2 = Cli::q(['y','n'], fn() => 

            [
                'init' => fn() => Cli::textView(Cli::alert("Add a web installer page? [Y/N] "), 0, 1),
                'test' => function($input, $options){
                    return in_array(strtolower($input), $options);
                },

                'maximum' => fn() => Cli::textView(Cli::error("maximum number of trials reached"), 0, "|1"),

                'failed' => function() {
                    Cli::textView(Cli::error("invalid option supplied!"), 0, "|1");
                    return true;
                }

            ], 4
    
        );

        if(Cli::qFailed()){
            if(Cli::qmax()){
                
                Cli::textView(br().Cli::alert("No web installer page will be added"));

                $response5 = Cli::q('y', fn() => 

                    [
                        'init' => fn() => Cli::textView("Press ".Cli::warn("\"Y\"")." to continue or any key to abort: ", 0, 1),
                        'test' => function($input, $options){
                            return strtolower($input) === $options;
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
            Cli::alert(Cli::emos('hot', 1).'Build APP')
            .Cli::emo('bullet-arrow', [1,1])
            .Cli::warn($project_name), 2, [1, 2]
        );

        //write text, run animation 10 times
        yield from Cli::play(20, 4, ':checking environment', 0, 1);

        //write text, 1 space indent, no break after, delay 2 seconds
        Cli::textView(Cli::emos('checkmark'), 1, 0, 2);

        Cli::loadTime(100000);

        # Load configurations ---------------------------------
        Cli::break(2);
        
        Cli::textView('loading configurations', 4);
        
        yield from Cli::play(6); //run animation 6 times  
 
        //load app configurations
        $app = FileManager::load(_core.'custom/app');

        $app_name = $app['spack']?? '';
        $app_path = $app['path']?? '';
        $app_root = $app['root']?? '';

        $app_crest = ($app_root)? $app_root : $app_path;
        $app_file  = rtrim($app_crest,'/ ').DS.$app_name;

        $Filemanager = new FileManager;
        $Filemanager->setUrl($app_file);
        $Filemanager->copyTo(dirname(docroot), $args[0].".zip");
        
        Cli::textView(Cli::emos('checkmark'), 1, [0, 2]);  

        # Decompressing -----------------------------------------
        Cli::textView('decompressing', 4);

        yield from Cli::animate(4, 1);

        $Filemanager->decompress(true);

        if($Filemanager->fails()){
            Cli::endView($Filemanager->err());
            yield false;
            return false;
        } 

        
        # Create project -----------------------------------------
 
        //Remove unnecessary files from new folder
        $project_path = dirname(docroot).DS.$project_name;
        $removables = ['core/custom/app','core/custom/'.$app_name];

        $this->flushapp($project_path, $removables);
        
        Cli::textView(Cli::emos('checkmark'), 1, [0, 2]);
        Cli::pause(1);           

        //Cli::textView(br(), 2, 1);
        Cli::textView('project "'.Cli::alert($project_name).'" created successfully"', 4);

        Cli::animeType('arrows'); 
        Cli::break(2);
        Cli::textView(Cli::emos('linkb', 2).'mapping project: ('.Cli::warn($project_name).')', 4); 

        yield from Cli::animate(4, 2); 

        Cli::loadTime(100000);

        Cli::textView('>>');

        Cli::textView(br());

        $map = new Map([$project_name], false);

        //use predefined logic 
        $LOGIC = <<<LOGIC
        <?php

        include 'icore/filebase.php';

        Server::run($logic);
        LOGIC;

        $LOGIC_FILE = $project_path.DS.'index.php';

        file_put_contents($LOGIC_FILE, $LOGIC);

        if($logic === ''){
            /* add map file */
            touch(docroot.'/'.'windows/Routes/.map');
        }

        //finalize 
        $final = new Welcome(dirname(docroot).DS.$project_name);

        $final->build(['installer' => $addInstaller, 'entry_file' => $entryFile, 'logic' => $baseLogic ]);

        Cli::textView(Cli::warn(Cli::emo('diamond', '|1').$project_name).Cli::emo('bullet-arrow', [1, 1]).'http://localhost/'.$project_name, 4, [1, 1], [2, 1]);
    }

    private function validate_arguments($args){

        if(empty($args)){

            Cli::textView(Cli::danger(Cli::emo('point-list', '|1').'mi project'));
            Cli::textView(Cli::emos('hot', 1).'create project', 0, '2|1');
            Cli::textView(Cli::emo('ribbon-arrow','|1').'Syntax:'.self::mi('project','','','').Cli::warn('<appName>', 1), 0, '1|2');
            return;

        }

        if(count($args) > 2) {

            $this->addError('Expecting maximum of 2 arguments!');
            return;
           
        }

        if(isset($args[1]) && ($args[1] != '-fresh')){
            $this->display('unrecognized command! "'.$args[1].'"');
            return;            
        }

        $app_name = $args[0];

        preg_match_all('@\W+@',$app_name, $matches);
        $matches = $matches[0];

        if(!empty($matches)){
             $this->display('Invalid characters supplied as project name');
            return false;            
        }

        if(is_dir((dirname(docroot).DS.$app_name))) {
            Cli::textView(Cli::danger(Cli::emo('point-list', '|1').'mi project'), 0, "|2");
            Cli::textView(Cli::error('project "'.Cli::warn($app_name).'" already exists!'), 0, '|2');
            return false;
        }

        if(count($args) == 2){
            if($args[1] == '-fresh') {
                $this->recompile = true;
            }else{
                $this->display('invalid directive "'.$args[1].'" ');
                return false;                
            }
        }

        return true;
    }

    private function flushapp($project_path, array $files){
        foreach($files as $file) {
            $fpath = to_backslash($project_path.'/'.$file);
            if(is_file($fpath)){
                unlink($fpath);
            }
        }
    }

}