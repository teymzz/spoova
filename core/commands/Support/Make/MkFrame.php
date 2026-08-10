<?php

namespace spoova\mi\core\commands\Support\Make;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli\CliPrompt;

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

            Cli::smartBreak(2);
            return false;
        }

        if($arg2 && ($arg2 != '-O')){

            Cli::textView(Cli::danger("Error: ").Cli::warn("invalid argument(#2) \"{$arg2}\" directive supplied on add:frame!"));

            Cli::smartBreak(2);
            return false;           

        }

        $classArg = to_backslash($arg, true);


        if(!$classArg) {
            Cli::textView('Syntax: '.Cli::btn('mi','|1').Cli::textBuild(Cli::color('add:frame', 'red'), "|1").Cli::warn('<args>'), 0, "|2");
            Cli::textView('Type: '.Cli::emo('ribbon-arrow', '|1').Cli::btn('mi','|1').Cli::textBuild(Cli::color('info', 'blue'), "|1").Cli::warn('add:frame')." to see full syntax.", 0, "|2");
            return false;
        }
        
        $classDir = dirname($classArg);
        $classDir = ($classDir === '.')? '' : $classDir;

        $className = ucfirst(basename($classArg));
        $classSpace = striplastSlash('windows\Frames\\'.$classDir);

        $classDir = $path.'/'.($classDir? $classDir.'/' : $classDir);
        $classPath = $classDir.$className;
        $classPath = to_backslash($classPath);

        $Filemanager = new Filemanager;

        if($Filemanager->addDir($classDir)) {

            /* create a new file */

            if(is_file($classPath.'.php') && ($arg2 !== '-O')){

                 Cli::textView("Frame ".Cli::warn("\"$className\"")." already exists! ", 0, '|2');

                 Cli::prompt(['y','n','::nocase'=>true], function(CliPrompt $prompt){

                    if($prompt->active()) Cli::textView('Overwite existing file? [Y, N] ');

                    if($prompt->inactive()){
                        if($prompt->invalid() || $prompt->matches('n')) {
                            Cli::textView(br().Cli::alert('Notice:').' File creation aborted!', 0)->smartBreak(2)->exit();
                        }
                    }

                 }, 1);
            }

            $content = <<<Frame
            <?php

            namespace spoova\mi\\$classSpace;
            
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

                if(class_exists(scheme("$classSpace\\".$className))) {
                    Cli::textView("Frame ".Cli::alert("\"$className\"")." added successfully ", 0, '');
                    Cli::textView("in $classSpace\\$className.php");
                    Cli::smartBreak(2);
                    return true;
                } else {
            
                    Cli::textView(Cli::danger("Error: ")."Frame class ".Cli::warn("\"$className\"")." failed to create!");
                    Cli::smartBreak(2);
                }

            }

        } else {
            $this->display('cannot access directory'.PHP_EOL);
        }

        return false;

    }

}