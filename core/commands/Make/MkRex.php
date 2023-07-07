<?php

namespace spoova\mi\core\commands\Make;

use spoova\mi\core\classes\FileManager;
use spoova\mi\core\commands\Cli;

class MkRex extends MkBase{

    public function build() : bool{

        $rexfolder = 'windows\Rex';
        $args = static::$args;

        if((!$args) || (count($args) > 1 )) {
             return $this->display('Invalid arguments count!');
        }

        $path = $args[0];

        Cli::textView(Cli::danger(Cli::emo('point-list').' add:rex '.Cli::warn($path)), 0, '|1');
        
        $exts = ['css','js', 'php'];

        $ext = 'php';

        if(strpos($path, ':') !== false){

            $pathexp = explode(':', $path, 2);

            $path = $pathexp[0];
            $ext  = $pathexp[1];

        }

        if(!in_array($ext, $exts)){
            Cli::break(1);
            Cli::textView(Cli::error('invalid template extension "'.Cli::warn($ext).'" supplied'));
            Cli::break(2);
            return false;
        }

        $path = str_replace(['.','/'], '\\', $path);

        
        $filename = basename($path).'.rex.'.$ext;
        $path     = dirname($path);

        $path     = $path == '.' ? '' : $path.'\\';

        $filepath = str_replace('/', '\\', 'windows\Rex\\'.$path.$filename);

        $fullpath = $rexfolder.'\\'.$path.$filename;

        $Filemanager = new FileManager;

        if(!file_exists(domroot($filepath))) {
            
            if( $Filemanager->openFile(true, domroot($fullpath)) ){
    
                Cli::break(1);
                Cli::textView(Cli::success('template created successfully'), '|2', '|2');
                Cli::textView(Cli::emo('ribbon-arrow', '1|1').Cli::warn($filepath));
                Cli::break(2);
                return true;
    
            } else {
                Cli::break(1);
                Cli::textView(Cli::error($filename.' file creation failed'));
                Cli::break(2);
    
            }
        } else {
            Cli::break(1);
            Cli::textView(Cli::danger('File exists: ').$fullpath);
            Cli::break(2); 
        }

        return false;

    }

}