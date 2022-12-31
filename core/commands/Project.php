<?php

/**
 * @package core/commands
 * @author Akinola Saheed <teymss@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 *  This may cause app to break or lead to other undesired errors.
 */
namespace spoova\core\commands;

use spoova\core\classes\FileManager;

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
            Cli::textView(Cli::error('invalid command "'.Cli::warn('project').'"', 2));
            Cli::break(2);
            yield false;
            return false;
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

        // Create a new spack file if missing
        if (!is_file(_core.'custom/'.self::crest) || $this->recompile) {
 
            if($this->recompile && is_file(SP_SPACK)) {
                unlink(SP_SPACK);
                Cli::break(1);
                new Root('repack');
                Cli::clearUp(2);
            }
            if (!(new Install('app'))) {
                return false;
            }
            Cli::break(2);
        } else {
            Cli::break(2);
        }

        # Load configurations ---------------------------------
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
        //Cli::textView('finalizing project', 1);
        
        //yield from Cli::animate(4, 2);
        
        //Remove unecessary files from new folder
        $project_path = dirname(docroot).$project_name;
        $this->flushapp($project_path, ['core/custom/app','core/custom/'.$app_name]);
        
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

        //finalize 
        $final = new Welcome(dirname(docroot).DS.$project_name);
        $final->build();

        // Cli::textView(br(), 1);
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
            $this->display('project "'.$app_name.'" already exists!');
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
            if(is_file($project_path.'/'.$file)){
                unlink($project_path.'/'.$file);
            }
        }
    }

}