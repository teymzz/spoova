<?php

namespace spoova\core\commands;

use spoova\core\commands\InteractiveConsole;
use spoova\core\commands\Cli;
use spoova\core\classes\FileManager;

/**
 * This class contains all spoova direct commands except the Info class
 */
class Root extends Entry{


    function __construct(string $arg)
    {
        
        if($arg === ':interactive'){

            new InteractiveConsole;

        } else {
            if(is_iterable($this->$arg())){
                Cli::runAnime([$this, $arg]);
            }
        }
    }

    /**
     * Display spoova version
     *
     * @return void
     */
    function version() {

       Cli::textView(Cli::alert(Cli::emos('hot', 1).'SPOOVA VERSION').Cli::warn(SP_VERSION, 1). ' (Beta)', 0, '1|2');

    }

    /**
     * show the supports of spoova
     *
     * @return void
     */
    function support() {
        
        $support = Cli::warn(Cli::emos('diamond', 1).'Supports: '); 
        
        Cli::textView($support, 0).Cli::break();
        Cli::textView(Cli::alert('PHP VERSION .......... 8.0 +'), 2, 1, 1);
        Cli::textView(Cli::alert('MYSQL VERSION ........ 5.4 +'), 2, 1, 1);
        Cli::textView(Cli::alert('SERVER SUPPORT ....... APACHE'), 2, 1, 1);
        Cli::textView(Cli::alert('ANDROID SERVER ....... KSWEB SERVER'), 2, [1, 2], 1);

    }    

    /**
     * Display list of cli commands
     *
     * @notice: All cli -lists are handled by the Syntax class 
     * @return void
     */
    public function cli() {

      $clis =  [     
        Cli::emos('point-list', 1).'cli (commands) :' => '',
            
            '> add' => '',                                 
            '> backup'   => '',
            '> clean' => '',
            '> cli'   => '', 
            '> config' => '',
            '> features'  => '',                        
            '> install'     => '',
            '> migrate'     => '',
            '> project' => '',
            '> support'   => '',  
            '> version'   => '',
            '> watch'     => '',
            
        ];

        $i = 0;

        Cli::break(2);

        foreach($clis as $cli => $value) {
            if($i == 0) { $i++;
                Cli::textView(Cli::danger($cli)).Cli::break(2);
                continue;
            }
            Cli::textView(Cli::warn($cli), 3).Cli::break(2);
           
        }

        $help = 'Type'.self::mi('cli','','','').Cli::danger("-lists", 1).' to see description.';
        Cli::textView($help).Cli::break(2);

    }

    /**
     * Display all spoova features
     *
     * @return void
     */
    function features(){

        $features = [
            'RESOURCE CONTROL'    => 'Importing and grouping of static resources',
            'LIVE SERVER CONTROL' => 'Inbuilt live server file integrated with code debugging (beta)',
            'TEMPLATE RENDERING'  => 'Renders template engine',
            'DATA VALIDATION'     => 'Inbuilt input validation',
            'FILE UPLOADER'       => 'Inbuilt file uploader class',
            'FILE MANAGER'        => 'Inbuilt file manager class',
            'SESSION CONTROL'     => 'Built in structure for handling sessions',
            'META TAGS CONTROL'   => 'Designed structure for managing meta tags setup and importation.',
            'DATABASE CONTROL'    => 'Simple Handlers for running mysql queries on mysql database',
            'DATABASE MIGRATION'  => 'Cli commands for generating and running migration files (beta)',
            'INTERACTIVE CLI'     => 'An interactive console assistant',
            'WVM(WMV) PATTERN'    => 'A development structure built on MVC pattern',
        ];
        
        Cli::textView(Cli::color(Cli::emos('diamond', 1).'FEATURES','yellow'), 0, "1|1");

        foreach($features as $feature => $desc) {

            $this->display( Cli::emo('ribbon-arrow',1, 0).Cli::warn($feature, 1) ." ".Cli::dots(25, $feature)." ".$desc);
        }        
        
    }

    /**
     * For development purposes
     *
     * @return iterable
     */
    public function repack(){

        Cli::textView(Cli::color(Cli::emos('hot', 1),'blue').'spoova build ... ');

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

                Cli::textView(Cli::emos('checkmark'), 2, 2);

                Cli::textView('initializing compiler ... ', 0, 0);

                unlink(domroot('core/custom/'.self::crest));
            }

            yield 5; //stage 5
            
            $Filemanager->setUrl(docroot);
            $Filemanager->zipUrl(_core.'custom/spoove', ['.git']);      
              
            yield 6; //stage 6

            $Filemanager->moveTo(_core.'custom/', self::crest);

            if($Filemanager->fails()) {
                $this->addError($Filemanager->err()); 
                yield false;
                return false;
            }

            Cli::textView(Cli::emos('checkmark'), 2, 2);

            Cli::textView('updating installer ... ');

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

            Cli::textView(Cli::emos('checkmark'), 2, 2);

        }

        Cli::animeType('arrows');
        Cli::textView('finalizing up process ');

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

        Cli::wait(2);

        $this->complete_setup($crest_root);
        
        Cli::textView(
            Cli::alert(Cli::emos('hot',1).'spoova repacked successfully'), 2, [2, 1], 1 
        );
        
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
                    ['root' => $crest_root], ['after' => 'spack']);
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