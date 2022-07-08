<?php

namespace spoova\core\commands\Make;

use spoova\core\classes\FileManager;

class MkController extends MkBase{

    public function build() : bool{
        
        $path = domroot('controllers');
        $class = static::$args[0] ?? '';

        if(!$class) {
             $this->display('Error: no class supplied!');
             return false;
        }

        $class = ucfirst($class); //class name
        $filepath = domroot('controllers\\'.$class.'.php');

        $Filemanager = new FileManager;

        //create the directory if not exist for controller
        if($Filemanager->openFile(true, $filepath)) {

            $content = <<<Controller
            <?php
    
            namespace spoova\controllers;

            use spoova\core\classes\Controller;
                
            class $class extends Controller {
            
                public function __construct(){
            
                    //your code here...
            
                }
            
            }
            Controller;

            $file = fopen($filepath, 'w');
            fputs($file, $content);
            fclose($file);

            sleep(1);

            if(class_exists('\spoova\controllers\\'.$class)) {
                $this->display("$class created successfully >> controllers\\$class.php".PHP_EOL);
                return true;
            } else {
                $this->display("$class creation failed!".PHP_EOL);
            }            

        } else {
            $this->display('cannot access directory'.PHP_EOL);   
        }
        return false;
    }

}