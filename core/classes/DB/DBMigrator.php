<?php

namespace spoova\core\classes\DB;

use DBStatus;
use spoova\core\classes\DB;
use spoova\core\classes\DB\DBSchema\DBSCHEMA;
use spoova\core\classes\DB\DBSchema\DRAFT;
use spoova\core\classes\FileManager;
use spoova\core\commands\Cli;
use User;

/**
 * DBMigrator for performing migrations
 * This class is still in its development phase. 
 * Migrations are part of feature that will be included soon.
 * 
 * @package spoova\core\classes
 */

class DBMigrator
{
    private ?DB $dbc = null;
    private ?DBHandler $dbh = null;

    public function __construct(){

        $auth = \User::auth();
        $dbc = $auth->dbc();
        $dbh = $auth->dbh();

        if($dbh){
            $this->dbh = $dbh;
            $this->dbc = $dbc;
            return;
        }

        Cli::textView(Cli::error('database connection failed!'));
        exit();

    }

    public function migrate_up(){

        if($this->createMigrationsTable()){
            $appliedMigrations = $this->getAppliedMigrations();

            $migrationsFolder = docroot.'/core/migrations';
            $migrationSpace   = "spoova\core\migrations\\";
            $Filemanager = new FileManager;
            $Filemanager->setUrl($migrationsFolder);
            $files = $Filemanager->getFiles(false, false);

            // $files = scandir($migrationsFolder);
            
            $newMigrations = array_diff($files, $appliedMigrations);

            $aborted = !($newMigrations); //aborted as true if no new migrations files found

            $addedMigrations = []; 
            $totalFiles = count($newMigrations);
            $totalApplied = 0; 
            
            foreach ($newMigrations as $migration){

                $migration = pathinfo($migration, PATHINFO_FILENAME);
                $migrationClass = $migrationSpace.$migration;

                // instantiate migration file
                $migrator = new $migrationClass;
                
                Cli::textView("Applying migration ........ ".Cli::warn($migration), 0, '|2');

                $migrator->up();

                if(!DBStatus::err() && !DRAFT::hasError()){
                    //save migration file...

                    if($this->saveMigrations([$migration])){
                        print (br("[".date('Y-m-d H:i:s')."] ..... ".Cli::alert($migration. Cli::emo('checkmark', 1)), 2));
                    }else{

                        $migrator->down(); 
                        Cli::textView(Cli::alert("{$totalApplied} migrations implemented out of {$totalFiles}"), 0, '|2');
                        Cli::textView(Cli::error("migration was aborted because error was found in \"".Cli::warn("{$migrationClass}")."\""), 0, '|2');

                        $aborted = true;
                        break;

                    }

                    $aborted = false;

                } else {
                    $aborted = true;
                    Cli::textView(Cli::danger('Notice::', "|1").("migration was aborted because error was found in \"".Cli::warn("{$migrationClass}")."\""), 0, '|2');
                    break;
                }

                $totalApplied++;
                

                $addedMigrations[] = $migration;

            }

            if($newMigrations){

                if($aborted){

                    if(DBStatus::err()){
                        Cli::textView(Cli::error(DBStatus::err()), 0, '|2');
                    }
                    
                    if(DBSCHEMA::DRAFT_SQL()) Cli::textView(DBSCHEMA::DRAFT_SQL(), 0, '|2');

                    if(DRAFT::hasError()){
                        Cli::textView(DRAFT::err(), 0, '|2');
                    }
                    
                }

                Cli::textView(Cli::alert("{$totalApplied} new ".inflect('migration', $totalApplied)." implemented out of {$totalFiles}"), 0, '|2');

            }else{
                Cli::textView(Cli::color("migrations:",'green', '|1')."no new migration files found", 2, '|2');
            }

        } else {

            Cli::textView(Cli::error("migration table does not exist in database ".Cli::warn(User::config('DBNAME')).""), 2, '|2');

        }
       
    }

    public function migrate_down(int $times = null){

        if(func_get_args() > 0);

        $dbh = $this->dbh;

        //get migrations table 
        $tables = $dbh->tables();

        if(in_array('migrations', $tables)){

            $dbh->query('select * from migrations')->read();

            $migrations = array_column($dbh->results(), 'migration');
            
            $migrationSpace   = "spoova\core\migrations\\";

            if($error = $dbh->error()){
                Cli::textView(Cli::error("{$error}"), 0, '|2');
                exit();
            }

            $migrations = array_reverse($migrations);

            $aborted = !($migrations); 

            $totalFiles = count($migrations); 
            $totalApplied = 0;
            
            if($migrations){

                $timesDown = $times = (func_num_args() > 0)? $times : $totalFiles;

                foreach($migrations as $migration){

                    if(is_int($timesDown)){
                        if($timesDown < 1){
                            break;
                        }
                        $timesDown--;
                    }

                    //get migration file 
                    $path = _core."migrations/".$migration.'.php';

                    if(is_file($path) && class_exists($migrationSpace.$migration)){

                        $migrationClass = $migrationSpace.$migration;

                        $migrator = new $migrationClass;

                        $migrator->down();
                        
                        if(DBStatus::err() || DRAFT::hasError()){
                            $aborted = true;
                            Cli::textView(Cli::error("migration was aborted because error was found in \"".Cli::warn("{$migrationClass}")."\""), 0, '|2');
                            if(DBStatus::err()) Cli::textView(Cli::danger("Sql error:",'|1').DBStatus::err(), 2, '|2');
                            break;
                        }else{
                            //remove migration from database
                            $dbh->query('DELETE FROM migrations WHERE migration = ?', [$migration]);

                            if(!$dbh->delete()){
                                $aborted = true;
                                Cli::textView(Cli::error("migration reversal discontinued because error was found in [".Cli::warn($migration)."")."] ", 2, '|2');
                                Cli::textView(Cli::danger("Sql error:",'|1').$dbh->error(), 2, '|2');
                                break;                             
                            }

                            $totalApplied++;
                            
                            // else{
                            //     Cli::textView(Cli::success("all migrations reversed successfully"), 2, '|2');
                            // }
                        }

                    }else {

                        Cli::textView(Cli::error("migration file [".Cli::warn($migration)."")."] missing", 2, '|2');
                        exit();

                    }

                }

                if( ($times === $totalApplied) && ($times === 0)){
                    Cli::textView(Cli::alert("no migrations reversed out of {$totalFiles}", '|1'), 2, '|2');
                }elseif( ($times === $totalApplied) ){
                    Cli::textView(Cli::alert("{$totalApplied} recent migrated ".inflect('file', $totalApplied)." successfully reversed out of {$totalFiles} ".inflect('migration', $totalFiles), '|1'), 2, '|2');
                }else if(($times != $totalApplied)){
                    if($times > $totalFiles) $times = $totalFiles;
                    Cli::textView(Cli::alert("{$totalApplied} recent migrated ".inflect('file', $totalApplied)." reversed out of {$times} ".inflect('migration', $totalFiles), '|1'), 2, '|2');
                }


            }else{
                Cli::textView(Cli::color("migrations:",'green', '|1')."no new migrations found", 2, '|2');
            }

        } else {

            Cli::textView(Cli::error("migration table does not exist in database ".Cli::warn(User::config('DBNAME')).""), 2, '|2');

        }
       
    }

    public function createMigrationsTable() : bool{


        $dbh = $this->dbh;

        /* 
           
            DBSCHEMA::CREATE('migrations', function(DRAFT $DRAFT){

                $DRAFT::ID();
                $DRAFT::VARCHAR('migration', 255)->UNIQUE()->NULL('hey');
                $DRAFT::VARCHAR('removed', 255);
                $DRAFT::TIMESTAMP('created_at')->CURRENT_TIME();
                $DRAFT::TIMESTAMP('removed_at')->CURRENT_TIME();

                return $DRAFT;

            })

        */

        return $dbh->query("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            removed VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            removed_at TIMESTAMP,
            UNIQUE(migration)
        ) ENGINE=INNODB;")->process();


        // DBSCHEMA::TABLE(
        //     'migrations', 
        //     function(){

        //         // $this->ID('size', 'custom_name').
                
        //         // $this->JSON('name', 'size', 'default').

        //         // $this->VARCHAR('name', 'size', 'default').
                
        //         // $this->CHAR('name', 'size', 'default').
        //         // $this->TEXT('name', 'size', 'default').
        //         // $this->TINYTEXT('name', 'size', 'default').
        //         // $this->MEDIUMTEXT('name', 'size', 'default').
        //         // $this->LONGTEXT('name', 'size', 'default').
                
        //         // $this->ENUM('name', 'size', 'default').
        //         // $this->SET('name', 'size', 'default').

        //         // //bool fields
        //         // $this->BOOL('name', 'size', 'default').
        //         // $this->BIT('name', 'size', 'default').
                
        //         // $this->BINARY('name', 'size', 'default').

        //         // //integers
        //         // $this->INT('name', 'size', 'default'). //signed or unsigned
        //         // $this->BIGINT('name', 'size', 'default').
        //         // $this->SMALLINT('name', 'size', 'default').
        //         // $this->TINYINT('name', 'size', 'default').

        //         // //integer serial
        //         // $this->SERIAL('name', 'size', 'default'). //BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE
                

        //         // // decimal
        //         // $this->FLOAT('name', ['size', 'd'], 'default').
        //         // $this->DOUBLE('name', ['size', 'd'], 'default').
        //         // $this->DECIMAL('name', ['size', 'd'], 'default').
        //         // $this->REAL('name', ['size', 'd'], 'default').

        //         // //date fields
        //         // $this->DATE('name', 'size', 'default').
        //         // $this->DATETIME('name', 'size', 'default').
        //         // $this->TIMESTAMP('name', 'size', 'default').
        //         // $this->TIME('name', 'size', 'default').
        //         // $this->YEAR('name', 'size', 'default').

        //         // //text fields

        //         // $this->BLOB('name', 'size', 'default').
        //         // $this->TINYBLOB('name', 'size', 'default').
        //         // $this->MEDIUMBLOB('name', 'size', 'default').
        //         // $this->LONGBLOB('name', 'size', 'default')

        //         //FORMAT .........................................
        //         $this->ID('size', 'custom_name').  //id int auto_increment not null [signed|unsigned]              

        //         $this->JSON('name', 'size', 'DEFAULT|NULL|NOT NULL').

        //         $this->VARCHAR('name', 'size', 'DEFAULT|NULL|NOT NULL').
        //         $this->CHAR('name', 'size', 'DEFAULT|NULL|NOT NULL').
        //         $this->TEXT('name', 'size', 'DEFAULT|NULL|NOT NULL').
        //         $this->TEXTFIELD('TEXT|TINY|MEDIUM|LONG', 'name', 'size', 'DEFAULT|NULL|NOT NULL').
                
        //         $this->ENUM('name', ['OPTIONS'], 'DEFAULT|NULL|NOT NULL').
        //         $this->SET('name', ['OPTIONS'], 'DEFAULT|NULL|NOT NULL').
                
        //         $this->BOOL('name', 'DEFAULT|NULL|NOT NULL').                
        //         $this->BIT('name', 'DEFAULT|NULL|NOT NULL').
        //         $this->BINARY('name', 'DEFAULT|NULL|NOT NULL').
                
        //         $this->INT('name', 'size', 'DEFAULT|NULL|NOT NULL').
        //         $this->INTFIELD('INT|TINY|SMALL|BIG', 'name', 'size', 'DEFAULT|NULL|NOT NULL').
                
        //         $this->SERIAL('name', 'size').
                
        //         $this->FLOAT('name', ['size', 'd'], 'default').
        //         $this->DOUBLE('name', ['size', 'd'], 'default').
        //         $this->DECIMAL('name', ['size', 'd'], 'default').
        //         $this->REAL('name', ['size', 'd'], 'default').
                
        //         $this->DATE('name', 'size', 'default').
        //         $this->DATETIME('name', 'size', 'default').
        //         $this->TIMESTAMP('name', 'size', 'default').
        //         $this->TIME('name', 'size', 'default').
        //         $this->YEAR('name', 'size', 'default').

        //         $this->BLOB('name', 'size', 'default').
        //         $this->FIELD('BLOB|TINY|MEDIUM|LONG','name', 'size', 'default').

        //         ->DEFAULT();
        //         ->SIGNED();
        //         ->UNSIGNED();
                
        //     }
        // );

    }


    public function getAppliedMigrations(){
        $dbh = $this->dbh;
        $dbh->query("SELECT migration from migrations")->read();
        $migrations = array_column($dbh->results(), 'migration');
        return $migrations;
    }    

    public function saveMigrations(array $migrations) : bool{

        $dbh = $this->dbh;

        $dbh->insert_into('migrations',[ 'migration' => $migrations]);
        
        return $dbh->insert();
        
    }

    protected function log(string $message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
    
}
