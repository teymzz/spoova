<?php

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\classes\Bundle\Enlist\Enlisted;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\ErrorHandlers\GhostCliMsg;
use spoova\mi\core\classes\Init;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliList;
use spoova\mi\core\commands\Root\Cli\CliPrompt;
use spoova\mi\core\commands\Root\Cli\CliPulser;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliOffset;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliWords;
use spoova\mi\core\commands\Root\Cli\CliQuery;
use spoova\mi\core\commands\Support\FilesOperation\FileRenamer;

/**
 * This cla
 */
class Files{ 

    public function __construct()
    {

        // $name = input(cliWarn('Please write your name: '),  ['saheed', 'teymi']);
        // pulseView('Please write your name.. just write', 0, function(CliPulser $pulse){
        //     return  $pulse->words('write', fn(CliWords $word) => Cli::danger($word->char()) );
        // });

        // if($name->anyValid()){
        //     textPlain(cliDanger($name));
        // }else{
        //     infoView(' Error ','Invalid user received name: '.cliWarn($name), break: '1|1')->exit();
        // }

        $intro = $this->intro();
        
        if($intro === '1') Cli::runAnime([$this, 'batch_rename_files']);
        // if($intro === '2') return $this->delete_file();
        // if($intro === '3') return $this->compress_file();
        // if($intro === '4') return $this->move_folder();
    }

    public function batch_rename_files() {
        Cli::clearUp(8);
        $agreement = Cli::textView('Proceed to rename all files ignoring subdirectories [Y/N]? ')->prompt();

        if(!$agreement->imatches('y')){
           return Cli::response(false, 'renaming files do not support directories.');
        }

        $path = Cli::clearView('Please set files directory path: ')->prompt()->i();
        //  print "\033[93m";
        // $colorClose = "\033[0m";
        if(!$path) return  Cli::errorView('No path defined!');

        Cli::break(1);

        yield from Cli::play(10, 'Process: checking file path ... '); Cli::clearLine();
        if(!is_dir($path)) return Cli::errorView('Directory path specified cannot be found!', break: '1|1');

        $Filemanager = new Filemanager;

        $Filemanager->source($path);

        $files = $Filemanager->getFiles();

        if(!$files){
           Cli::clearLine()->textView('Response: no files detected in supplied directory ... '); 
           Cli::pause(1)->break(1);
           yield Cli::response(false, 'program ended with no activity');
        }

        if($Filemanager->openFile()){
            Cli::textView('Please select renaming format: ', break: 2);
            $lists= ['serialize file names', 'serialize with named prefix', 'serialize with new extension name','rename file extension names'];
            Cli::List($lists, break: 1, callback: function(CliList $list){
                Cli::pulseView($list->sn().'. '.$list->value(), 50, fn(CliPulser $pulse) =>
                    $pulse->offset(4, function(CliOffset $posix){
                        return Cli::warn($posix->char());
                    })
                );
            });
            Cli::break(1);
            Cli::textView('select option [');
            Cli::List($lists, callback: fn(CliList $list)=> $list->sn().',');
            Cli::back();
            Cli::textView(']? ');

            $prompt = Cli::prompt();
            $fileRenaming = new FileRenamer($Filemanager);

            if($prompt->imatches('1')){
                // rename files just by serializing
                yield from $fileRenaming->serialize_file_names($Filemanager);
                }elseif($prompt->imatches('2')){
                yield from $fileRenaming->serialize_with_named_prefix($Filemanager);
                // Cli::clearUp(6);
                // Cli::textView('Renaming format: ' . Cli::warn($lists[1]), break: 2);
                // $prefix = Cli::textView('Files name prefix : ')->prompt()->i();

                // if(preg_match('/^[A-Za-z0-9_][a-zA-Z0-9_-]+$/', $prefix)){
                //     if(strlen($prefix) > 40) return Cli::response(false, 'prefix name defined is too long!');
        
                //     $sample = [];
                //     $files = $Filemanager->dirFiles();

                //     if($files){

                //         $Filemanager->view();
                //         $Filemanager->prefix($prefix);
                //         $Filemanager->reNumber();
                //         /** @var array $results */
                //         $Filemanager->rename(results: $results);
                //         $results = array_values($results);

                //         for($i = 0; $i < count($results); $i++){
                //             if($i == 2) break;
                //             $sample[] = basename($results[$i]).'?';
                //         }
    
                //         //Cli::textView('Renamed files sample formats:', break: 2);
                        
                //         Cli::break(1);
                //         Cli::List($sample, break: 1);
                //         Cli::break(1);
                //         Cli::textView('...'.Cli::warn('['.count($results).' files count]'), break: 2);

                //         $prompt = Cli::textView('Proceed with renaming format? [Y/N] ')->prompt();
                        
                //         if($prompt->imatches(['Y'])){
                //             $Filemanager->view(false);
                //             $Filemanager->rename(callback: function($rename) {
                //                 Cli::clearLine()->moveStart()->textView('Percentage renamed ['.$rename->status().'%]');
                //                 usleep(600000);
                //                 if($rename->done()) {
                //                     Cli::clearLine()->moveStart()->successView($rename->renamed().' files renamed.', break: 1);
                //                 }
                //             });
                //         }else{
                //             Cli::errorView('aborted...');
                //         }

                //     } else {
                //         Cli::clearLine();
                //         Cli::response(false, 'No files found in specified directory');
                //     }


                // }else{
                //     Cli::response(false, 'invalid prefix name aborted operation');
                // }
            }
            
        }

    }

    public function intro() : string {
        Cli::textView(Cli::danger(Cli::emos('point-list', 1).'filemanager '), break: 2);

        $lists = ['batch rename files', 'delete a file', 'compress file', 'move folder'];
        Cli::textView('What will you like to do? ', break: 2);
        Cli::List($lists, break: 1, callback: function(CliList $list){
              Cli::pulseView($list->sn().'. '.$list->value(), 100, fn(CliPulser $pulse) =>
                $pulse->offset(4, function(CliOffset $posix){
                    return Cli::warn($posix->char());
                })
              );
              Cli::wait(500);
        });
        Cli::break(1);
        Cli::textView('option [');
        Cli::List($lists, callback: fn(CliList $list)=> $list->sn().',');
        Cli::back();
        Cli::textView(']? ');

        return Cli::prompt(['1', '2', '3', '4'], function(CliPrompt $prompt){

           if($prompt->invalid() && $prompt->inactive()) {
                Cli::response(false, 'program terminated due to invalid option!');
                Cli::exit();
           }

        }, 1)->i();
    }

}