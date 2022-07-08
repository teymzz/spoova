<?php

namespace spoova\core\commands\Make;

use spoova\core\classes\FileManager;

class MkFrame extends MkBase{

    public function build() : bool{
        $path = domroot('windows/Frame');
        $class = static::$args[0];
        $class = ucfirst($class);

        $Filemanager = new FileManager;

        if($Filemanager->openFile(true, $path)) {

            /* create a new file */

            $content = <<<Frame
            <?php

            namespace spoova\windows\Frame;
            
            use Window;
            
            class $class extends Window {

                public function __construct(){

                    //your code here...

                }

            }
            Frame;

            if($Filemanager->openFile(true, $path.'/'.$class.'.php')) {
                
                $file = fopen($path.'/'.$class.'.php', 'w');
                fputs($file, $content);

                sleep(1);

                if(class_exists('\spoova\windows\Frame\\'.$class)) {
                    $this->display("$class created successfully >> windows\Frame\\$class.php".PHP_EOL);
                    return true;
                } else {
                    $this->display("$class creation failed!".PHP_EOL);
                }

            }

        } else {
            $this->display('cannot access directory'.PHP_EOL);
        }

        return false;

    }

    

}