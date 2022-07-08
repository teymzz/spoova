<?php

namespace spoova\core\commands\Make;

use spoova\core\classes\FileManager;

class MkRex extends MkBase{

    public function build() : bool{

        $rexfolder = 'rex';
        $args = static::$args;
        
        if((!$args) || (count($args) > 1 )) {
             return $this->display('Invalid arguments count!');
        }

        $path = $args[0];

        $path = str_replace(['.','/'], '\\', $path);

        $filename = basename($path).'.rex.php';
        $path     = dirname($path);

        $path     = $path == '.' ? '' : $path.'\\';

        $filepath = str_replace('/', '\\', 'rex\\'.$path.$filename);

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