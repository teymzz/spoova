<?php

namespace spoova\core\commands\Make;

use spoova\core\classes\FileManager;

class MkWindow extends MkBase{

    public function build() : bool{

        $path = domroot('windows');
        $class = static::$args[0];
        $class = ucfirst($class);

        $extend = static::$args[1]?? '';
        $use = "use Windows";

        if($extend) $use = "use spoova\Windows\Frame\\$extend";

        $extends = $extend?? 'Window';

        $Filemanager = new FileManager;

        if($Filemanager->openFile(true, $path)) {

            /* create a new frame file */

            $content = <<<Frame
            <?php

            namespace spoova\windows;
            
            $use;
            
            class $class extends $extends {

                public function __construct(){

                    //your code here...

                }

            }
            Frame;

            if($Filemanager->openFile(true, $path.'/'.$class.'.php')) {
                
                $file = fopen($path.'/'.$class.'.php', 'w');
                fputs($file, $content);
                fclose($file);

                $this->display("$class created successfully >> windows\\$class.php".PHP_EOL);
                
                return true;

                // if(@class_exists('\spoova\windows\\'.$class)) {
                //     $this->display("$class created successfully >> windows\\$class.php".PHP_EOL);
                //     return true;
                // } else {
                //     $this->display("$class creation failed!".PHP_EOL);
                // }

            }

        } else {
            $this->display('cannot access directory'.PHP_EOL);
        }

        return false;

    }

}