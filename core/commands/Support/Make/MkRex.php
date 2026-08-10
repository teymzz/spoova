<?php

namespace spoova\mi\core\commands\Support\Make;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class MkRex extends MkBase{

    public function build() : bool{

        $rexfolder = 'windows\Rex';
        $args = static::$args;

        if((!$args) || (count($args) > 1 )) {
            $path = $args[0] ?? '';
             Cli::textView(Cli::danger(Cli::emo('point-list').' add:rex '.Cli::warn($path)), 0, '|2');
             Cli::textView(Cli::danger('Error:').' invalid arguments count!').Cli::smartBreak(2);
             return false;
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
            Cli::smartBreak(2);
            return false;
        }

        $path = str_replace(['.','/'], '\\', $path);

        
        $filename = basename($path).'.rex.'.$ext;
        $path     = dirname($path);

        $path     = $path == '.' ? '' : $path.'\\';

        $filepath = str_replace('/', '\\', 'windows\Rex\\'.$path.$filename);

        $fullpath = $rexfolder.'\\'.$path.$filename;

        $Filemanager = new Filemanager;

        if(!file_exists(domroot($filepath))) {
            
            if( $Filemanager->openFile(true, domroot($fullpath)) ){
    
                Cli::break(1);
                Cli::textView(Cli::success('template created successfully'), '|2', '|2');
                Cli::textView(Cli::emo('ribbon-arrow', '1|1').Cli::warn($filepath));
                Cli::smartBreak(2);
                return true;
    
            } else {
                Cli::break(1);
                Cli::textView(Cli::error($filename.' file creation failed'));
                Cli::smartBreak(2);
    
            }
        } else {
            Cli::break(1);
            Cli::textView(Cli::danger('File exists: ').$fullpath);
            Cli::smartBreak(2); 
        }

        return false;

    }

}