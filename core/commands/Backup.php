<?php

namespace spoova\core\commands;

use spoova\core\classes\FileManager;
use ZipArchive;

class Backup extends Entry{

    public $spack = false;

    public function __construct($args = [])
    {

        // print docroot;

        if((!$args) || (count($args) > 1)){

            self::commandTitle('backup');
            Cli::break().
            Cli::textView(Cli::error('Expecting exactly one(1) argument!'), 2);
            Cli::break(2).
            Cli::textView(Cli::emo('ribbon-arrow', '|1').'Syntax:'. self::mi('backup', '','','').Cli::warn('[project|:clear]', 1), 2);
            Cli::break(2);
            return false;
        }

        $option = $args[0];

        if($option != 'project' && $option != ':clear'){

            self::commandTitle('backup');
            Cli::break().
            Cli::textView(Cli::error('Invalid argument supplied'), 2);
            Cli::break(2).
            Cli::textView(Cli::emo('ribbon-arrow', '|1').'Syntax:'. self::mi('backup', '','','').Cli::warn('[project|:clear]', 1), 2);
            Cli::break(2);
            return false;

        }

        self::commandTitle('backup', 2);

        if ($option == 'project') Cli::runAnime([$this, 'newBackup']);
        if ($option == ':clear')  Cli::runAnime([$this, 'delBackup']);

    }

    function newBackup() {

        Cli::break();

        yield from Cli::play(5, 2, 'initializing backup ...', 0, 2);

        Cli::clearUp(2);

        $newName = docBase.'-bk'.time();
        
        $FileManager = new FileManager;
        $FileManager->setUrl(docroot);

        Cli::break(2);
        yield from Cli::play(5, 2, 'zipping project file (may take a while) ...');   
        
        if($FileManager->addDir('backup')){

            $FileManager->zipUrl('backup/'.$newName, ['backup','.git']);
    
            Cli::clearLine();
    
            yield from Cli::play(5, 2, Cli::emo('ribbon-arrow', '|1').'finalizing backup ...', 0, 2);  
    
            Cli::clearUp();
    
            if($FileManager->zipped()){
                yield Cli::endAnime(1, 0, Cli::success('backup successful: backup\\'.$newName), 2);   
            }
        }

        yield Cli::endAnime(0, 0, Cli::error('backup failed!'));

    }

    function delBackup(){

        
        Cli::break();
        
        $backupDir = docroot.'/backup';
        
        if(file_exists($backupDir)){
    
            yield from Cli::play(10, 2, 'initializing backups removal...', 0, 2);

            Cli::clearUp(2);
            
            $FileManager = new FileManager;
            $FileManager->setUrl($backupDir);
    
            Cli::break(2);
    
            Cli::animeType('circle');

            yield from Cli::play(10, 2, 'deleting backups (may take a while) ...');   
            
            Cli::animeType('normal');

            if($FileManager->deleteFile()){
        
                yield from Cli::play(10);  
        
                Cli::clearUp();
                yield Cli::endAnime(1, 0, Cli::success('backups removed successfully.'), 2);   
            
                //Cli::break(2);
            }
        }
            
        Cli::textView(Cli::error('backups removal failed.'), 2);
        yield Cli::endAnime(0, 1, Cli::danger('Ensure that the root backup directory still exists and is accessible.'), 2);   

    }

}