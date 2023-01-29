<?php

use spoova\core\classes\FileManager;
use spoova\core\commands\Install;
use spoova\core\commands\Project;

/**
 * Development contoller
 */
class Dev{

    private static $error;
    
    /**
     * Create a new project file
     *
     * @param string $project_name
     * @return void
     */
    public static function project(string $project_name){

        //check if project name exists
        if(file_exists(approot.DS.$project_name)){
            $modified_time = filectime(approot.DS.$project_name);
            $current_time  = time();
            $since = ($current_time - $modified_time);
            
            // //Test modification time
            if($since < 60){
                trigger_error('Project app "'.$project_name.'" created successfully');
                return false;
            }

            trigger_error('Project directory "<a href="/'.$project_name.'" class="inherit bold">'.$project_name.'</a>" already exists');
            return false;
        }

        (new Project([$project_name]));
    }

    /**
     * Update root dev files
     *
     * @param string $editUrl
     * @param string $spUrl
     * @param integer $update_interval
     * @return void|bool
     */
    public static function backup(string $editUrl, string $spUrl = '', $update_interval = 60){

        //get the new file
        $editUrl = realpath($editUrl);
        $edit_path = '';

        if(!$editUrl){
            trigger_error('invalid source edit path');
            return;
        }

        if(trim($spUrl)) {
            $spUrl = realpath($spUrl);

            if(!is_file($spUrl)){
                trigger_error('invalid destination path supplied');
                return false;
            }
        }

        // Remove project root from $editUrl
        $current_app_path = str_replace(approot, '', $editUrl);

        // Replace all directory separators
        $current_app_path = str_replace('/','\\',$current_app_path);
        $current_app_path = str_replace('\\',DS,$current_app_path);

        //remove trailing directory separator
        $current_app_path = ltrim($current_app_path, DS." ");

        // Current edit Url
        $edit_path = explode(DS, $current_app_path, 2);

        $edit_path = $edit_path[1]?? '';        

        //get installer path to same project file
        if(!$spUrl){
            // Attach app installer path
            $spUrl = approot.DS.'spoova'.DS.$edit_path;
        }
    
        if(!is_file($spUrl)){
            self::$error = ('Cannot find spoova installation bundle');
            return false;
        }

        //check if edited file is movable
        if(!is_writeable($editUrl)) {
            self::$error = ('edited file is not transferable');
            return false;
        }

        //check modified time 
        $last_modified_time = filemtime($spUrl);
        $current_time  = time();
        $since = ($current_time - $last_modified_time);

        $content1 = file_get_contents($editUrl);
        $content2 = file_get_contents($spUrl);
        $filesmatch = $content1 === $content2;

        //* If last update is less than 30 minutes and both files matches
        if($since < 30 && $filesmatch) {

            trigger_error('( '.$edit_path.' ) file is currently updated');
            return;

        }

        //* if last update is less than update interval and files do match
        if($since < $update_interval && $filesmatch) {

            trigger_error('( '.$edit_path.' ) file was currently updated');
            return;

        }  

        //* If last update is equal or greater than 30 minutes and both files matches       
        if($since >= $update_interval && $filesmatch) {

            trigger_error('( '.$edit_path.' ) file is already up to date');
            return;

        } 

        //* if last update is less than update interval and files do not match
        if($since < $update_interval && !$filesmatch) {

            trigger_error('( '.$edit_path.' ) file will be updated in '.($update_interval - $since));
            return;

        }  

        if($since > $update_interval && !$filesmatch) {

            //update file here....
            return (copy($editUrl, $spUrl));

            //recompile spack file
            if(is_file(SP_SPACK)) @unlink(SP_SPACK);

            //generate new spack file
            self::compile();

        }   

    }

    public static function Compile()
    {
        $Filemanager = new FileManager;
        $Filemanager->setUrl(SP_SPOOVA);
        $Filemanager->zipUrl(SP_SPOOVA.'core/custom/spoove');
        $Filemanager->moveTo(SP_SPOOVA.'core/custom/', 'spack_'.SP_VERSION);

        if($Filemanager->fails()) {
            trigger_error('spoova compilation failed - '.$Filemanager->err());
            return;
        }
        return true;
    }

    static function error(){
        return self::$error;
    }

}