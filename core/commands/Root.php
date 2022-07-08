<?php

namespace spoova\core\commands;

use spoova\core\commands\Anime;
use spoova\core\classes\FileManager;

class Root extends Entry{


    function __construct($arg)
    {
        if(is_iterable($this->$arg())){
            Anime::runAnime([$this, $arg]);
        }
    }

    function version() {

       Anime::textView(Anime::emos('hot', 1).'SPOOVA VERSION '.SP_VERSION, 0, 2);

    }

    function support() {
        
        //show the supports of spoova
        $support  = PHP_EOL;    
        $support .= PHP_EOL.str_repeat(" ", 2).'PHP - 7.4';
        $support .= PHP_EOL.str_repeat(" ", 2).'MYSQL';
        $support .= PHP_EOL.str_repeat(" ", 2).'APACHE SERVER ONLY';
        $support .= PHP_EOL.str_repeat(" ", 2).'ANDROID KSWEB SERVER';

        $support  = Anime::emos('hot', 1).'Supports: '.$support;

        Anime::textView($support, 0, 2);
    }    

    /**
     * Display list of cli commands
     *
     * @return void
     */
    public function cli() {

      $clis =  [     
        Anime::emos('hot', 1).'CLI COMMANDS >>' => '',
            
            '> add' => '',
            '> add' => '',
                                              
            '> backup_file <filepath>'   => '',                                    
            '> backup_folder <filepath>' => '',  
            
            '> classes'   => '',
            '> class_methods <namespace>' => '',
            '> cli'       => '', 
               
            '> config' => '',
            '> config meta [on|off]' => '',
            '> config [dbonline|dboffline] [dbname dbuser dbpass dbserver dbport dbsocket]' => '',
            '> config dbusers_table <tablename>'  => '',
            '> config dbcookie_field <fieldname>' => '',
            '> config dbpass_field <fieldname>'   => '',

            '> features'  => '',
            '> functions' => '',
                                        
            '> install'     => '',
            '> install app' => '',
            '> install db'  => '',
            '> install dbname <name>' => '',

            '> project <project_name>' => '',

            '> support'   => '',  
            
            '> version'   => '',
            
        ];

        foreach($clis as $cli => $value) {
            $this->display($cli);
        }

        Anime::textView('Type "spoova cli -lists" to see description', 0, 2);

    }

    function features(){

        $features = [
            'RESOURCE CONTROL'    => 'Importing and grouping of static resources',
            'LIVE SERVER CONTROL' => 'Inbuilt live server system integrated with code debugging',
            'TEMPLATE RENDERING'  => 'Renders template engine',
            'DATA VALIDATION'     => 'Inbuilt input validation',
            'DATA UPLOAD'         => 'Inbuilt file uploader tool',
            'SESSION CONTROL'     => 'Built in structure for handling session',
            'META TAGS CONTROL'   => 'Inbuilt tool for controlling meta tags.',
            'DATABASE CONTROL'    => 'Simple Handlers for running mysql queries on mysql database',
            'WVM(WMV) PATTERN'     => 'A development structure built on MVC pattern',
        ];
        
        Anime::textView(Anime::emos('hot', 1).'FEATURES >>', 0, 2);

        foreach($features as $feature => $desc) {
            $this->display( $feature .' >>> '.$desc);
        }        
        
    }

    /**
     * For development purposes
     *
     * @return iterable
     */
    public function repack(){

        Anime::textView(Anime::emos('hot', 1).'spoova build ... ');

        yield 1; //stage 1

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            $this->addError('invalid command "app"');
            yield false; //stop here
            return false;
        }

        yield 2; //stage 2

        // Import FileManager
        $Filemanager = new FileManager;

        // Set crest file variables
        $crest_name = self::crest;
        $crest_path = _core.'custom/';
        $crest_file = _core.'custom/'.self::crest.'.re';
        $crest_root = '';
        
        $sys_cresp  = sys.'/'.self::crest;
        $sys_cresf  = sys.'/'.self::crest;

        yield 3; //stage 3

        // Generate a spack file 
        if(!is_file($crest_file)) {

            yield 4; //stage 4

            //unlink any spack file
            if(is_file(domroot('core/custom/'.self::crest)))
            {
                unlink(domroot('core/custom/'.self::crest));
            }

            yield 5; //stage 5
            
            $Filemanager->setUrl(docroot);
            $Filemanager->zipUrl(_core.'custom/spoove');      
              
            yield 6; //stage 6

            $Filemanager->moveTo(_core.'custom/', self::crest);

            if($Filemanager->fails()) {
                $this->addError($Filemanager->err()); 
                yield false;
                return false;
            }

            Anime::textView(Anime::emos('checkmark'), 1, 2);

            Anime::textView('updating installer ... ');

            yield 7; //stage 7

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

            Anime::textView(Anime::emos('checkmark'), 2, 2);

        }

        Anime::animeType('arrows');
        Anime::textView('finalizing up process ');

        //Read from app installer
        $Filemanager->setUrl(_core.'custom/app'); 
        $app = $Filemanager::load(_core.'custom/app');

        yield true;
        // //* Handle no system root installer
        // if($app['complete'] == 'true'){
        //     $this->addLog('app already installed');
        //     return;
        // }

        //* Handle incomplete setup
        if(isset($app['root'])) $Filemanager->textDelete(['root']);

        Anime::wait(2);

        $this->complete_setup($crest_root);

        Anime::textView(Anime::emos('checkmark'), 2, 2);

        Anime::textView(Anime::emos('hot',1).'spoova repacked successfully', 0, 1);
        
    }

    /**
     * Complete setup for repack
     *
     * @param string $crest_root
     * @return void
     */
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

    }

}