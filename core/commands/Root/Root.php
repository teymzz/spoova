<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\Bundle\Filemanager\FileCompressor;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Support\Handlers\CastConsole;
use spoova\mi\core\commands\Support\Handlers\InteractiveConsole;
use spoova\mi\core\commands\Support\Handlers\Syntax;

/**
 * This class contains all spoova direct commands that do not take extra arguments. 
 * It processes only {@see Entry::root} commands.
 */
class Root extends Entry{

    public const commands = Entry::root;

    function __construct(string $command)
    {
        
        if($command === ':wizi') return new CastConsole;
        if($command === ':wiz') return new InteractiveConsole;

        if(str_starts_with($command, 'cli')){
          if($command === 'cli ') return self::cli();
          if($command === 'cli -lists') return self::cliLists();
          Cli::headerView($command, break: 2);
          Cli::errorView('Invalid argument on cli command.', break: 1);
          return;
        }

        if(is_iterable($this->$command())){
            // runs only iterable methods
            return Cli::runAnime([$this, $command]);
        }

    }

    /**
     * Display spoova version
     *
     * @return void
     */
    function version() {

       Cli::headerView('version', break: 2);

       Cli::response(false, false);

       if(isTerminal('bash') && !isTerminal(['wsl','termux-bash'])){
            Cli::break();
       }

       Cli::pulseView(Cli::emo('hot').' SPOOVA VERSION '.SP_VERSION.' [Stable]', 20000, function($char, $index){
        if($index <= 17) {
            return Cli::alert($char);
        }elseif($index <= 23){
            return Cli::warn($char);
        }
        elseif($index === 24){
            Cli::wait(500000);
        }
        return $char;
       });

       Cli::break(2);
                
       Cli::textView('| Type '.Cli::bgWarn(' mi ').' '.Cli::warn('cli -lists').' to see a list of commands', pause: '3', break: 2, spacing: '2');

    }

    /**
     * show the supports of spoova
     *
     * @return void
     */
    function support() {

        $support = Cli::warn(Cli::emos('diamond', 1).'Supports: '); 
        
        Cli::hideCursor();
        Cli::textView($support, 0).Cli::break(2);

        Cli::textView(Cli::alert('PHP VERSION .......... '.SP_PHP_VERSION.' +'), '2', 1, '1');
        Cli::textView(Cli::alert('MYSQL VERSION ........ '.SP_MYSQL_VERSION.' +'), '2', 1, '1');
        Cli::textView(Cli::alert('SERVER SUPPORT ....... APACHE '.SP_APACHE_VERSION.' +'), '2', 1, '1');
        Cli::textView(Cli::alert('ANDROID SERVER ....... KSWEB SERVER'), '2', 1, '1|1');    
        Cli::response(false, false);
        Cli::showCursor();

    }    

    /**
     * Display list of cli commands
     *
     * @notice: All cli -lists are handled by the Syntax class 
     * @return void
     */
    public function cli() {

      Cli::cls()->headerView("cli", break: 2);

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

        Cli::break(1);

        foreach($clis as $cli => $value) {
            if($i == 0) { $i++;
                Cli::textView(Cli::danger($cli)).Cli::break(2);
                continue;
            }
            Cli::textView(Cli::warn($cli), '2').Cli::break(2);
           
        }

        $help = 'Type'.self::mi('cli','','','').Cli::danger("-lists").' to see description.';
        Cli::textView($help).Cli::break(1);

    }

    private static function cliLists(){
        Cli::cls();
        new Syntax(['-lists']);
    }

    /**
     * Display all spoova features
     *
     * @return void
     */
    function features(){

        $features = [
            'RESOURCE CONTROL'    => 'Importing and grouping of static resources.',
            'LIVE SERVER CONTROL' => 'Live server file integrated with code debugging (beta).',
            'TEMPLATE RENDERING'  => 'Inbuilt template engine.',
            'DATA VALIDATION'     => 'Inbuilt input validation.',
            'FILE UPLOADER'       => 'Inbuilt file uploader class.',
            'FILE MANAGER'        => 'Inbuilt file manager class.',
            'SESSION CONTROL'     => 'Built in structure for handling sessions.',
            'META TAGS CONTROL'   => 'Controllers for managing meta tags setup and importation.',
            'DATABASE CONTROL'    => 'Simple Handlers for running mysql queries on mysql database.',
            'DATABASE MIGRATION'  => 'Cli commands for generating and running migration files.',
            'INTERACTIVE CLI'     => 'An interactive console assistant.',
            'WVM / WMV PATTERN'   => 'A development pattern built on MVC architecture.',
        ];
        
        Cli::textView(Cli::color(Cli::emos('diamond', 1).'APP FEATURES'), '0', "|2");

        $count = count($features) - 1;
        foreach($features as $feature => $desc) {
            $i = ($i ?? -1) + 1;
            
            $break = $count === $i ? 1 : 2; 
            Cli::textView(Cli::warn(Cli::emo('pipe','2')).Cli::warn($feature, '1') ." ".Cli::dots(25, $feature)." ".$desc, break: $break);
        }  
        
        return Cli::response(false, false);
        
    }

    /**
     * For development purposes
     *
     * @return iterable
     */
    public function repack(){

        Cli::textView(Cli::headerView('Project repack'));
        Cli::break(2);

        // Handle environmental directive
        if(!is_file(_core.'custom/app')){
            Cli::textView(Cli::error('invalid command '.Cli::warn('"repack"')));
            Cli::break(2);
            yield false; //stop here
        }

        yield from Cli::play(3, Cli::color(Cli::emos('hot', 1),'blue').'spoova build ... '); //stage 1 & 2

        $Filemanager = new Filemanager;

        // Set crest file variables
        $crest_name = self::crest;
        $crest_path = _core.'custom/';
        $crest_spac = _core.'custom/'.self::crest;
        $crest_file = _core.'custom/'.self::crest.'.re';
        $crest_root = '';
        
        $sys_cresp  = sys.'/'.self::crest;
        $sys_cresf  = sys.'/'.self::crest;

        yield from Cli::play(3, Cli::color(Cli::emos('hot', 1),'blue').'spoova build ... '); //stage 3

        // Generate a spack file 
        if(!is_file($crest_file)) {
            
            Cli::clearLine();
            yield from Cli::play(4, Cli::color(Cli::emos('hot', 1),'blue').'spoova [checking compiler] ... '); //stage 4
            
            //unlink any spack file
            if(is_file($crest_spac))
            {
                Cli::clearLine();
                yield from Cli::play(4, Cli::color(Cli::emos('hot', 1),'blue').'spoova [initializing process] ... '); //stage 5
                unlink($crest_spac);
            }
                
            // yield 5; //stage 6
            Cli::clearLine();
            yield from Cli::play(5, Cli::color(Cli::emos('hot', 1),'blue').'spoova [preparing to stage files] ... '); //stage 6
            
            $Filemanager->setUrl(docroot);
            $i = false;

            $Filemanager->zipProgress(function(FileCompressor $info) use(&$i){
                
                if($info->status === 0) Cli::clearLine();
                Cli::moveStart()->textView(Cli::color(Cli::emos('hot', 1),'blue').'spoova [staging files for compression]['.$info->status.'%] ... ');
                if($info->status === 100){
                    Cli::pause(1)->clearLine();
                    Cli::textView(Cli::color(Cli::emos('hot', 1),'blue').'spoova [repacking process may take a while] ... '.Cli::warn('please wait'));
                }
                    
            });
            
            $spv = _core.'custom/spv';

            $Filemanager->removeFile($spv);

            $Filemanager->zipUrl(_core.'custom/spv', ['backup','.git','core/storage']);  

            Cli::clearLine();
            Cli::textView(Cli::color(Cli::emos('hot', 1),'blue').'spoova repack: '.Cli::valid('process completed').' ... ');

            Cli::pause(2);
            
            Cli::clearLine();
            yield from Cli::play(5, Cli::color(Cli::emos('hot', 1),'blue').'spoova [remapping compiler] ... '); //stage 6
            $Filemanager->setUrl(_core.'custom/spv.zip'); 
            $Filemanager->moveTo(_core.'custom/', self::crest);

            if($Filemanager->fails()) {
                $this->addError($Filemanager->err()); 
                yield false;
                return false;
            }
            
            Cli::clearLine();
            yield from Cli::play(5, Cli::color(Cli::emos('hot', 1),'blue').'spoova [updating configurations] ... '); //stage 7
            
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

        }

        Cli::animeType('arrows');
        Cli::clearLine();
        yield from Cli::play(4, Cli::color(Cli::emos('hot', 1),'blue').'spoova [cleaning redundant files] ... '); //stage 8

        //Read from app installer
        $Filemanager->setUrl(_core.'custom/app'); 
        $app = $Filemanager::load(_core.'custom/app');
        
        Cli::clearLine();
        yield from Cli::play(1, Cli::color(Cli::emos('hot', 1),'blue').'spoova [finalizing process] '); //stage 9
        Cli::pause(2); Cli::clearLine();

        //* Handle incomplete setup
        if(isset($app['root'])) $Filemanager->textDelete(['root']);

        $this->complete_setup($crest_root);
        
        Cli::textView(Cli::alert(Cli::emos('hot', '1').'spoova repack: ').Cli::valid('successful'));
        
    }

    /**
     * Complete setup for repack
     *
     * @param string $crest_root
     * @return void
     */
    private function complete_setup(string $crest_root){

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

        $Filemanager->textUpdate([
            'install' => '1',
            'complete'=> 'true',
        ]);

    }

    public static function initalize(array $commands){
       
        Cli::cls();

        $command1 = ($commands)? $commands[0] : '';
        $command2 = $commands[1] ?? '';
        
        if($command1 !== 'cli' && (count($commands) > 1)) {
          Cli::headerView($command1, break: 2);
          Cli::errorView('no arguments required on this command!', break:1);
          return; 
        }
        
        $command = $command1 .($command2? ' ' . $command2 : '');

        new Root($command);
    }

}