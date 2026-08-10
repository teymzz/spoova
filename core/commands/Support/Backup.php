<?php

namespace spoova\mi\core\commands\Support;

use Exception;
use spoova\mi\core\classes\Bundle\Filemanager\FileCompressor;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliHistory;
use spoova\mi\core\commands\Root\Entry;

class Backup extends Entry{

    public const bool latent_mode = true;

    public bool $spack = false;

    public function __construct(array $args = [])
    {

        $option = $args[0] ?? '';

        Cli::headerView('Backup '.$option, break: 1);


        if((!$args) || (count($args) > 1)){
            Cli::break();
            Cli::textView(Cli::error('expecting exactly one(1) argument!'));
            Cli::break(2);
            Cli::textView(Cli::emo('ribbon-arrow', '|1').'Syntax:'. self::mi('backup', '','','').Cli::warn('[project|:clear]', '1'), '2');
            Cli::break(1);
            return Cli::response(false);
        }
        
        if($option != 'project' && $option != ':clear'){

            self::commandTitle('backup');
            Cli::break();
            Cli::textView(Cli::error('invalid option supplied'), 2);
            Cli::break(2);
            Cli::textView(Cli::emo('ribbon-arrow', '|1').'Syntax:'. self::mi('backup', '','','').Cli::warn('[project|:clear]', '1'), '2');
            Cli::break(1);
            return Cli::response(false);

        } 

        //save to directory...        
        if ($option === 'project') {
           
            Cli::break(1);
    
            Filemanager::noZip(function(){
                Cli::exit(Cli::errorView('This operation requires '.Cli::warn('ZipArchive').' installation.', break: '|1'));
            });

            Cli::textView(Cli::alert('Backup name: '), 0);
            $folder = 'backup';
            $filename = Cli::prompt()->value();
            Cli::wait(9000);

            // $history = new CliHistory();
            if(!$filename || (trim($filename) && (!preg_match('~^[a-zA-Z0-9_]+$~', $filename)))){
                if(!$filename){
                    Cli::clearUp();
                    $message = 'process aborted because no name was specified!';
                    Cli::textView(Cli::alert('Backup name: '.Cli::danger('required*')), 0);
                    Cli::break(2);
                }else{
                    $message = 'process aborted because invalid name was specified!';
                }

                return Cli::response(false, $message);
            }

            // check if backup name exists here... 
            if(is_file(docroot.'/'.$folder."/".$filename.".zip")){
                return Cli::response(false, Cli::warn($folder.'/'.$filename.'.zip').'" exists!', title: 'Error');                
            }

            Cli::textView(Cli::alert('Backup reason: '));
            $reason = Cli::prompt()->value();
            Cli::pause(1); Cli::break(1);

            return Cli::runAnime([[$this, 'newBackup'], [$folder, $filename, $reason]]);
        
        } elseif ($option === ':clear') {

            return Cli::runAnime([$this, 'delBackup']);   

        }

    }

    function newBackup(array $args) {

        [$folder, $file, $reason] = $args;
        
        Cli::clearUp(1);

        yield from Cli::play(5, Cli::textIndent('Backup : initializing process ...'), function(){
            Cli::stop(true)->wait(2);
        });

        $newName = $file;
        
        $Filemanager = new Filemanager;
        $Filemanager->setUrl(docroot);

        yield from Cli::play(5, Cli::textIndent('Backup : preparing files ...'), function(){
            Cli::stop(true)->wait(2);
        });
        Cli::clearLine();
        
        if($Filemanager->addDir($folder)){

            $NewFilemanager = new Filemanager;

            if($NewFilemanager->openFile(url: 'BackupLog')){
                $NewFilemanager->setUrl('BackupLog');
                $NewFilemanager->textWrite([
                    'Backup File Generated on' => date('Y-m-d H:i:s'),
                    'Backup reason' => $reason
                ]);
            }
            
            $Filemanager->zipProgress(function(FileCompressor $info){
                $status = $info->status.'%';
                if($info->status === 0) Cli::clearLine();
                Cli::moveStart()->textPlain('Backup : staging files ['.$status.']', 0);
                if($info->status === 100){
                    Cli::pause(1)->clearLine();
                    Cli::moveStart()->textPlain('Backup : process starting [may take a while] ...', 0);
                } 
            });

            $Filemanager->zipUrl($folder."/".$newName, [$folder,'.git','core/storage']);
            Cli::clearLine();
            
            yield from Cli::play(5, Cli::emo('ribbon-arrow', '1|2').'finalizing backup ...', function(){
                Cli::stop(true)->pause(1);
            });
    
            if($Filemanager->zipped()){
                $NewFilemanager->deleteFile('BackupLog');
                Cli::cls();
                Cli::headerView('Backup project', break: 2);
                Cli::textView('Backup: '.Cli::valid('process completed'), break: 1);
                Cli::endAnime(message: Cli::emo('ribbon-arrow', '1|2')."file added to: ".Cli::warn("$folder/$newName.zip")); 
                yield true;  
            }
        }

        yield Cli::endAnime(0, 0, Cli::error('backup failed!'), 1);

    }

    function delBackup(){

        Cli::break();
        Cli::textView(Cli::alert("Enter backup folder: "));
        $backupFol = trim(Cli::prompt()->i(), " ");
        
        $backupDir = docroot.'/'.$backupFol;

        Cli::clearUp();

        if(!$backupFol){
            Cli::clearUp();
            Cli::textView(Cli::alert("Enter backup folder: ".Cli::danger("*required")));
            Cli::break();
            yield Cli::response(false, 'invalid folder name supplied!');
        }elseif(($badFol = ($backupFol !== 'backup'))){
            yield Cli::response(false, 'invalid folder name supplied!');
        } else {

            Cli::textView(Cli::warn('Notice: ').('this will delete the entire backup folder and its contents. [Y/N] '), '2');
            
            $delete = strtolower(Cli::prompt(['y','n'], terminate: true)->value());
            Cli::clearUp();
    
            if($delete === 'n'){
                yield Cli::response(false, 'process terminated by choice.');       
            }elseif($delete !== 'y'){
                Cli::clearUp(2);
                yield Cli::endAnime(0, 0, Cli::warn("Notice: ").('process exited!').br('',2), 0);                     
            }
    
            Cli::clearLine();
            
            if(file_exists($backupDir)){
                
                yield from Cli::play(10, Cli::textIndent('initializing backups removal...', '2'), function(){
                    Cli::stop()->wait(2);
                });
                
                $Filemanager = new Filemanager;
                $Filemanager->setUrl($backupDir);
        
                Cli::animeType('circle');
    
                yield from Cli::play(10, Cli::textIndent('deleting backups (may take a while) ', '2'), function(){
                    Cli::stop();
                });  
                
                Cli::animeType('normal');
    
                if($Filemanager->deleteFile()){
            
                    yield from Cli::play(10, callback: function(){
                        Cli::stop()->wait(50000);
                    });  
                    
                    Cli::clearUp(3);
                    yield Cli::endAnime(1, 0, Cli::success('backups removed successfully.'));   
                
                }
            }
                
            Cli::textView(Cli::error('backups removal failed.'), '2');
            yield Cli::endAnime(0, 1, Cli::danger('Ensure that the root backup directory still exists and is accessible.'));   

        }


    }

}