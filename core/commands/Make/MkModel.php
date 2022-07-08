<?php

namespace spoova\core\commands\Make;

use spoova\core\classes\FileManager;

class MkModel extends MkBase{

    public function build() : bool{

        $args = static::$args;
        $arg = $args[0];

        if(count(static::$args) > 2){
            $this->display('Invalid argument count!');
            return false;
        }

        $class = $args[0];
        $modelpath = $args[1] ?? '';

        if($modelpath) {
            
            if(strpos($args[1], '.') != false){

                $modelpath = str_replace('.', '/', $modelpath);
                $args[1] = $modelpath;

            }

        }

        $class = ucfirst($class);

        $xpath = $args[1] ?? '';
        if($xpath) $xpath = rtrim($xpath, '/');

        if(!$xpath) $xpath = 'Models';
        
        $namespace = str_replace('/','\\', $xpath);

        $path = domroot($namespace);

        $namespace = "$namespace";

        $Filemanager = new FileManager;

        if($Filemanager->openFile(true, $path.'/'.$class.'.php')) {

            /* create a new frame file */

            $content = <<<Frame
            <?php

            namespace spoova\\$namespace;
            
            use spoova\core\classes\Model;
            
            class $class extends Model {

                public function __construct(){

                    //your code here...

                }

                /**
                 * Validation rules
                 *
                 * @return array
                 */
                public function rules(): array {

                    return [];

                }

                /**
                 * set table name where data is inserted
                 *
                 * @return string
                 */
                public function tablename(): string {

                    //default table name
                    return \User::config('USER_TABLE');
            
                }


            }
            Frame;

            $file = fopen($path.'/'.$class.'.php', 'w');
            fputs($file, $content);
            fclose($file);

            sleep(1);

            if(class_exists("\spoova\\$namespace\\".$class)) {
                $this->display("$class created successfully >> $namespace\\$class.php".PHP_EOL);
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