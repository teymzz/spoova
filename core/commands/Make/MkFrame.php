<?php

namespace spoova\core\commands\Make;

use spoova\core\commands\Cli;
use spoova\core\classes\FileManager;

class MkFrame extends MkBase{

    public function build() : bool{

        //set base path
        $path = domroot('windows/Frames');

        //get class path
        $arg = static::$args[0] ?? '';
        $arg2 = static::$args[1] ?? '';
        $args = implode(' ', static::$args);

        Cli::textView(Cli::danger(Cli::emo('point-list').' add:frame '.Cli::warn($args)), 0, '|2');

        if(count(static::$args) > 2){

            Cli::textView(Cli::danger("Error: ")."invalid number of arguments count!");

            Cli::break(2);
            return false;
        }

        if($arg2 && ($arg2 != '-O')){

            Cli::textView(Cli::danger("Error: ").Cli::warn("invalid argument(#2) \"{$arg2}\" directive supplied on add:frame!"));

            Cli::break(2);
            return false;           

        }

        $classArg = to_backslash($arg, true);


        if(!$classArg) {
            $this->display(Cli::color('Error:', 'red').' no class name supplied!');
            $this->display('Syntax:'.Cli::btn('mi','add:frame', '','', '').Cli::color('<className>', 'yellow', 0), 2);
            return false;
        }
        
        $classDir = dirname($classArg);
        $classDir = ($classDir === '.')? '' : $classDir;

        $className = ucfirst(basename($classArg));
        $classSpace = striplastSlash('windows\Frames\\'.$classDir);

        $classDir = $path.'/'.($classDir? $classDir.'/' : $classDir);
        $classPath = $classDir.$className;
        $classPath = to_backslash($classPath);

        $Filemanager = new FileManager;

        if($Filemanager->addDir($classDir)) {

            /* create a new file */

            if(is_file($classPath.'.php') && ($arg2 !== '-O')){

                 Cli::textView("Frame ".Cli::warn("\"$className\"")." already exists! ", 0, '|2');
                 Cli::textView(Cli::alert("Notice:")." use directive \"-O\" to overwrite ", 0, '|2');
                return false;

            }

            $content = <<<Frame
            <?php

            namespace spoova\\$classSpace;
            
            use Window;
            
            class $className extends Window {

                public static function super() {

                    //add a super activity

                }

            }
            Frame;


            if($Filemanager->openFile(true, $classPath.'.php')) {
                
                $file = fopen($classPath.'.php', 'w');
                fputs($file, $content);

                sleep(1);

                if(class_exists("\spoova\\$classSpace\\".$className)) {
                    Cli::textView("Frame ".Cli::alert("\"$className\"")." added successfully ", 0, '');
                    Cli::textView("in $classSpace\\$className.php");
                    Cli::break(2);
                    return true;
                } else {
            
                    Cli::textView(Cli::danger("Error: ")."Frame class ".Cli::warn("\"$className\"")." failed to create!");
                    Cli::break(2);
                }

            }

        } else {
            $this->display('cannot access directory'.PHP_EOL);
        }

        return false;

    }

    

}