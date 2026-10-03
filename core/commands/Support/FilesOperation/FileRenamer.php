<?php 

namespace spoova\mi\core\commands\Support\FilesOperation;

use spoova\mi\core\classes\Bundle\Enlist\Enlisted;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli;

class FileRenamer {

    public function serialize_file_names( Filemanager $Filemanager){
        Cli::break();
        yield from Cli::play(10, Cli::warn('Process:').' renaming all files serially ...');
        Cli::break(2);

        $Filemanager->reNumber();
        $Filemanager->rename(callback: function(Enlisted $file){
            
            $file->after(function(Enlisted $file){
                $name =  str_pad($file->name(), '50','.');
                $name = str_replace($file->name(), '', $name);

                Cli::textView('['.Cli::warn($file->name()).'] '.$name. ' ['.Cli::warn($file->newName()).']', break:  1);

                if($file->done()){
                    Cli::textView(Cli::valid('Success:').' all files renamed successfully.', break: '1|1');
                }
            });

        });
    }

    public function serialize_with_named_prefix(Filemanager $Filemanager){

        $prefix = Cli::textView(Cli::warn('set prefixing name: '))->prompt()->value();

        Cli::break();

        // validate characters
        if(!preg_match('/^[A-Za-z0-9_][a-zA-Z0-9_-]+$/', $prefix)){
            Cli::errorView('no space or special characters supported [1 trials left]', break: 2);
            $prefix = Cli::textView(Cli::warn('set prefixing name: '))->prompt();
            if(!preg_match('/^[A-Za-z0-9_][a-zA-Z0-9_-]+$/', $prefix)){
                return Cli::response(false, 'renaming operation failed!');
            }
        }
        
        // validate characters length
        if(strlen($prefix) > 40) {
            Cli::errorView('max of [40] characters exceeded', break: 1);
            return Cli::response(false, 'renaming operation failed to execute!');
        }

        
        yield from Cli::play(10, ' renaming all files serially ...', );
        Cli::break(2);

        // Initialize Preview stage ..........................................................................................................
        $Filemanager->view();
        $Filemanager->prefix($prefix);
        $Filemanager->reNumber();
        /** @var array $results */
        $Filemanager->rename(results: $results);
        $results = array_values($results);

        for($i = 0; $i < count($results); $i++){
            if($i == 2) break;
            $sample[] = basename($results[$i]).'?';
        }
        $sample = $sample ?? [];
        $shortSample = array_slice($sample, 0, 2);
        Cli::List($shortSample, break: 1);
        Cli::break(1);
        Cli::textView('Total ...'.Cli::warn('['.count($results).' files count]'), break: 2);
        // Finalize Preview stage ............................................................................................................
         
        $prompt = Cli::textView('Proceed with renaming format? [Y/N] ')->prompt();

        if($prompt->imatches(['Y'])){
            $Filemanager->view(false);
            $Filemanager->rename(callback: function(Enlisted $file) {
                
                // $dots =  str_pad($file->name(), '50','.');
                // $dots = str_replace($file->name(), '', $dots);
                $dots = ' ........ ';
                Cli::clearLine()->moveStart()->textView('['.Cli::warn($file->name()).'] '.$dots. ' ['.Cli::warn($file->newName()).'] ['.$file->status().'%]');
                // Cli::clearLine()->moveStart()->textView('Percentage renamed ['.$file->status().'%]');
                usleep(600000);

                $file->after(function(Enlisted $file){
                    if($file->done()) {
                        Cli::clearLine()->moveStart()->successView($file->renamedCount().' files renamed.', break: 1);
                    }
                });
            });
        }else{
            Cli::errorView('aborted...');
        }

        // $Filemanager->prefix($prefix);
        // $Filemanager->reNumber();

        // $Filemanager->rename(callback: function(Enlisted $file){
            
        //     $file->after(function(Enlisted $file){
        //         $dots =  str_pad($file->name(), '50','.');
        //         $dots = str_replace($file->name(), '', $dots);

        //         Cli::textView('['.Cli::warn($file->name()).'] '.$dots. ' ['.Cli::warn($file->newName()).']', break:  1);

        //         if($file->done()){
        //             Cli::textView(Cli::valid('Success:').' all files renamed successfully.', break: '1|1');
        //         }
        //     });

        // });
    }

    public function serialize_with_new_extension_name(){
        
    }

    public function rename_files_extension_name(){

    }

}