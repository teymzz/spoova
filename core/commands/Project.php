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

        Anime::animeType('roller');
        Anime::runAnime([[$this, 'build'], $args]);

    }

    public function build($args) {

        Anime::loadTime(100000);

        if(!$this->validate_arguments($args)) {     
            yield false;
            return false;
        }        

        //set the project name
        $project_name = $args[0];

        //write text, delay 2 seconds, break 2 lines
        Anime::textView(Anime::emos('hot', 1).'Build APP >> '.$project_name, 2);

        Anime::textView(':', 1, 2);        

        //write text, run animation 4 times
        yield from Anime::textYield('checking environment', 10, 2);

        //write text, delay 2 seconds, break 2 lines
        Anime::textView(Anime::emos('checkmark'), 1, 2);      

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            Anime::endView('invalid command "project"');
            yield false;
            return false;
        }

        // Create a new spack file if missing
        if (!is_file(_core.'custom/'.self::crest) || $this->recompile) {
 
            if($this->recompile && is_file(SP_SPACK)) {
                unlink(SP_SPACK);
            }
            if (!(new Install('app'))) {
                return false;
            }
        }

        # Load configurations ---------------------------------
        Anime::textView('loading configurations', 2);
        
        yield from Anime::animate(6); //run animation 6 times  
 
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
        
        Anime::textView(Anime::emos('checkmark'), 1, 2);  

        # Decompressing -----------------------------------------
        Anime::textView('decompressing', 2);

        yield from Anime::animate(4, 1);

        $Filemanager->decompress(true);

        if($Filemanager->fails()){
            Anime::endView($Filemanager->err());
            yield false;
            return false;
        } 

 
        
        # Create project -----------------------------------------
        //Anime::textView('finalizing project', 1);
        
        //yield from Anime::animate(4, 2);
        
        //Remove unecessary files from new folder
        $project_path = dirname(docroot).$project_name;
        $this->flushapp($project_path, ['core/custom/app','core/custom/'.$app_name]);
        
        Anime::textView(Anime::emos('checkmark'), 1, 2);           

        //Anime::textView(br(), 2, 1);
        Anime::textView('project "'.$project_name.'" created successfully"', 2, 3);

        Anime::animeType('arrows'); 
        Anime::textView(Anime::emos('linkb', 2).'mapping project: ('.$project_name.')', 2); 

        yield from Anime::animate(4, 2); 

        Anime::loadTime(100000);

        Anime::textView('>>');

        Anime::textView(br());

        $map = new Map([$project_name], false);

        // Anime::textView(br(), 1);
        Anime::endView($project_name.' >> http://localhost/'.$project_name);
    }

    private function validate_arguments($args){

        if(empty($args)){

            Anime::textView(Anime::emos('hot', 1).'create project', 0, 2);
            Anime::textView('syntax >> mi project <app_name>', 0, 2, 2);
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