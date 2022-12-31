<?php

namespace spoova\core\commands\Make;

class MkMigrate {

    /**
     * This class is under development and is not suitable for use at the moment
     * @param string $filepath
     * @param bool $create
     */
    public static function Migrator($filename, $create = false){


        print "command not available for use...";

        return false;
        
        $filename = rtrim($filename,'.php').".php";      
        if(substr($filename, 0, 1) === '/'){
          $pathused = str_replace("/","\\", rtrim(ltrim(dirname($filename),'/'),'/'));
          $filepath = getDefined('docroot')."{$filename}";
        }else{
          $pathused = str_replace("/", "\\", rtrim(ltrim('core/migrations/'.dirname($filename),'/'),'/'));      
  
          $filepath = getDefined('docroot')."/core/migrations/{$filename}";        
        }

        $prefix = 'm'.time().'_';

        $filename = $prefix.basename($filename);
        $classname = rtrim($filename, '.php');
        $filepath = dirname($filepath).'/'.$prefix.basename($filepath);
  
        javaconsole("migrator: create( ".$filename." )");
  
        if(empty($filename)){
          javaconsole(">> command status:", [
            'command' => 'create migrator',
            'path' => dirname($filepath),
            'filename' => $filename,
            'mode' => 'debug',
            'status' => 'not resolved',
          ]);
          return false;
        }
  
        if(dirname($filepath)){
  
          if(is_file($filepath)){       
            javaconsole("migrator: status( file already created ) \n------------\n ");
            return false;
          }else{
            javaconsole("migrator: status( pending ) \n------------\n ");
          }
          
          //create a new file here;
          if($create === true){
            $content = <<<Migrate
            <?php

            use core\classes\DBBot;
            
            class '.$classname.' {

              public function up(){

                //your code here...

              }

              public function down(){

                //your code here...

              }  
            }
            
            ?>
            Migrate;

            $file = fopen($filepath, 'w');
            fputs($file, $content);
            fclose($file);
  
          } else {
            
            javaconsole('>> command status:', [
              'command' => 'create migrator',
              'path' => dirname($filepath),
              'filename' => $filename,
              'mode' => 'info',
              'status' => 'resolved'
            ]);
  
          }
  
        }else{
  
          trigger_error('directory does not exist');
          javaconsole('>> command status:', [
            'command' => 'create migrator',
            'path' => dirname($filepath),
            'filename' => $filename,
            'mode' => 'debug',
            'status' => 'not resolved'
          ]);
  
        }
  
    }    

}