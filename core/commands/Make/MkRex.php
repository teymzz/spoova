<?php

namespace spoova\core\commands\Make;

use spoova\core\classes\FileManager;
use spoova\core\commands\Cli;

class MkRex extends MkBase{

    public function build() : bool{

        $rexfolder = 'windows\Rex';
        $args = static::$args;
        
        if((!$args) || (count($args) > 1 )) {
             return $this->display('Invalid arguments count!');
        }

        $path = $args[0];

        $exts = ['css','js', 'php'];

        $ext = 'php';

        if(strpos($path, ':') !== false){

            $pathexp = explode(':', $path, 2);

            $path = $pathexp[0];
            $ext  = $pathexp[1];

        }

        if(!in_array($ext, $exts)){
            Cli::break(1);
            $this->display('Invalid extension "'.Cli::warn($ext).'" supplied for rex file');
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
    
                $this->display('Rex file created successfully');
                $this->display('>> '.$filepath, 2);
                return true;
    
            } else {
    
                $this->display($filename.' file creation failed');
    
            }
        } else {
            $this->display('File already exists: '.$fullpath); 
        }

        return false;

    }

}