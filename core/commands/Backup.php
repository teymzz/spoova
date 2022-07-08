<?php

namespace spoova\core\commands;

use spoova\core\classes\FileManager;
use ZipArchive;

class Backup {

    public $spack = false;

    public function __construct()
    {
        if(!is_file(sys.'spack.re')){

            //create a new base app
            $FileManager = new FileManager;
            $FileManager->setUrl('../');
            $FileManager->zipUrl('core/spoove');
            $FileManager->moveTo(sys,"spack.re");

            if(!is_file(sys.'spack.re')) return;

        }

        $this->spack = true;
    }

    public function file($filepath){
        if($this->decompress()){
            rename($filepath, sys."spack/".$filepath);
        }
    }

    public function folder($folderpath){

    }

    private function decompress(){
        if(!$this->spack) return;
        if(rename(sys.'spack.re', sys.'spack.zip')){
            //decompress to folder
            $zip = new ZipArchive;
            if($opened = $zip->open(sys.'spack.zip')){
                $zip->extractTo(sys);
                $zip->close();
            }
        }
    }

    private function compress(){
        if(!$this->spack) return;

        //re-pack spack file
        $FileManager = new FileManager;
        $FileManager
            ->setUrl(sys.'spack')
            ->zipUrl(sys.'spack')
            ->moveTo(sys,"spack.re");

        return (!is_file(sys.'spack.re'));       
    }

}