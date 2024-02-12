<?php


namespace spoova\mi\core\commands\Root\Make;

use spoova\mi\core\classes\DB\DBSchema\DBSCHEMA;
use spoova\mi\core\classes\DB\DBSchema\DRAFT;
use spoova\mi\core\classes\FileManager;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Make\MkBase;

class MkMigrator extends MkBase{


    public function build() : bool{

        $args = static::$args;

        $arg1 = $args[0] ?? '';
        $arg2 = $args[1] ?? '';

        $filename = $arg1;      

        $class = $arg1;
        $class = ltrim(to_frontslash($class, true), '/');
        $class = to_frontslash($class, true);
        $classDir  = dirname($class);
        $classDir  = ($classDir == '.')? '' : $classDir;
        $className = basename($class);
        
        if($className == ''){

          Cli::textView(Cli::danger(Cli::emo('point-list').' add:migrator '), 0, '|2');
          Cli::textView(Cli::danger('Error:')." ".Cli::warn('no valid migration file name is supplied!'), '2', '|2');
          return false;
        }

        Cli::textView(Cli::danger(Cli::emo('point-list').' add:migrator ').Cli::warn($filename));
        Cli::break(2);

        if(strpos($filename, '.') !== false){
            Cli::textView(Cli::error('invalid character supplied on file name'), 2, "|2");
            return false; 
        }

        if(count($args) > 1){
            Cli::textView(Cli::error('invalid number of arguments count!'), 2, "|2");
            return false;             
        }

        $filename = rtrim($filename,'.php').".php";      

        $filepath = docroot."/migrations/{$filename}";        

        $prefix = 'M'.time().'_';

        $filename = $prefix.basename($filename);
        $filepath = dirname($filepath).'/'.$prefix.basename($filepath);

        /* Note:: all space variables have no trail slash */

        /* class subnamespace in window\Models if subnamespace exists */
        $classSpace = to_namespace($classDir); 
        
        /* class namespace starting from windows folder  */
        $migrateSpace  = to_namespace('migrations\\'.$classSpace);
        
        /* class full folder namespace */
        $nameSpace = scheme($migrateSpace, false);    

        /* class full namespace */
        $fileNameSpace = $nameSpace.'\\'.$className;

        /* class relative migrations directory */
        $fileDir  = to_frontslash($migrateSpace);
        
        /* class absolute file path */
        $fileLoc  = $fileDir.'\\'.$className.'.php'; /* relative file path */


        $Filemanager = new FileManager;
       
        if($Filemanager->openFile(true, $filepath)) {

            $tableName = $className;

            if(strtolower(substr($className, 0, 7)) === 'create_'){

                $tableName = substr($className, 7, strlen($className));
                
            }elseif(strtolower(substr($className, 0, 6)) === 'alter_'){

                $tableName = substr($className, 6, strlen($className));
                
            }



            $content = <<<SCRIPT

              public function up() {

                DBSCHEMA::CREATE(\$this, function(DRAFT \$DRAFT){

                    //\$DRAFT::VARCHAR();

                    return \$DRAFT;

                });

              }

              public function down() {

                 DBSCHEMA::DROP_TABLE(\$this);

              }  

              public function table() : string {

                return '$tableName';

              }

            SCRIPT; 

            $content2 = <<<SCRIPT

            
              public function up() {

                DBSCHEMA::ALTER(\$this, function(DRAFT \$DRAFT){

                    //code here...

                });

              }

              public function down() {


                DBSCHEMA::ALTER(\$this, function(DRAFT \$DRAFT){

                    //code here...

                });
            

              }  

              public function table() : string {

                return '$tableName';

              }

            SCRIPT;

            if(strpos(strtolower($className), 'alter') !== false){
                $content = $content2;
            }
            
            $format = self::classFormat([
                'namespace' => $nameSpace, 
                'class'     => $prefix.$className, 
                'methods'   => $content,
                'use'       => [DBSCHEMA::class, DRAFT::class]
            ]);
            file_put_contents($filepath, $format);
            
            if(is_file($filepath) && class_exists($nameSpace.'\\'.$prefix.$className)){

                Cli::textView("migration file ".Cli::alert($prefix.$className)." created successfully in ".Cli::warn($fileDir));
                Cli::break(2);
                return true;

            }  else {

                
                Cli::textView("migration file ".Cli::alert($className)." failed to create in ".Cli::danger($fileDir)." directory.");
                Cli::break(2);

            }           

        }

        return false;  
    }


}