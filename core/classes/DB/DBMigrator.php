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

        Cli::textView(Cli::error('database connection failed!'), 0, "|2");
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
            Cli::textView(Cli::error(DBStatus::err()), 2, '|2');

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
                            
                            if(DRAFT::hasError()){
                                Cli::textView(DRAFT::err(), 0, '|2');
                            }
                            if(DBSCHEMA::DRAFT_SQL()) Cli::textView(DBSCHEMA::DRAFT_SQL(), 2, '|2');
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
                Cli::textView(Cli::color("migrations:",'green', '|1')."no reversible migrations found", 2, '|2');
            }

        } else {

            Cli::textView(Cli::error("migration table does not exist in database ".Cli::warn(User::config('DBNAME')).""), 2, '|2');

        }
       
    }

    public function createMigrationsTable() : bool{


        $dbh = $this->dbh;

        return $dbh->query("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(191),
            removed VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            removed_at TIMESTAMP,
            UNIQUE(migration)
        ) ENGINE=INNODB")->process();

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

    public function migrate_status($args){
        if($args){
            Cli::textView(Cli::error("no arguments expected on syntax"), 0, "|2");
            return false;
        }

        $dbh = $this->dbh;

        $appliedMigrations = $this->getAppliedMigrations();


        if(!$dbh->table_exists('migrations')){
            Cli::textView(Cli::error('migration table does not exist'), 0, "|2");
            Cli::textView('Trying to generate one', 0, "|2");
            Cli::wait(1);

            $this->createMigrationsTable();

            Cli::wait(1);

            if(!$dbh->table_exists('migrations')){
                
                Cli::textView(Cli::error('migration table failed to create!'), 0, "|2");

                return false;
            } else{
                Cli::textView(Cli::success('migration table added successfully', 1), 0, "|2");
            }

            //yield from Cli::play(10, 0, 'Checking migration status', 1);
        }

        $migrationsFolder = docroot.'/core/migrations';
        $migrationSpace   = "spoova\core\migrations\\";

        $Filemanager = new FileManager;
        $Filemanager->setUrl($migrationsFolder);
        $files = $Filemanager->getFiles(false, false);
        
        $newMigrations = array_diff($files, $appliedMigrations);

        $default = ['LAST MIGRATED FILE' => '', 'APPLIED ON' => ''];

        $dbh->query("select migration as 'LAST MIGRATED FILE', created_at as 'APPLIED ON' from migrations order by created_at desc")->read();
        $allmigrations = count($dbh->results());
        $rows = array_unset($dbh->results($allmigrations - 1), '');
        $fields = $dbh->tables(User::config('DBNAME'),'migrations');
        // $fields = array_unset($fields, 'removed');
        // $fields = array_unset($fields, 'removed_at');
        // $fields = array_unset($fields, 'id');
        $rows = array_replace($default, $rows);

        //$resultCount = count($result)?: 1; - 15
        $lines = (count($fields) * (10)) + 14; 
        $table = "";

        $lim1 = 25;
        $lim2 = 34;
        $lim3 = $lim2 - 3;



        $table .= "".str_repeat("-", $lines)."".br();

        foreach($rows as $row => $value){
            $table .= "| ".strtoupper(limitChars($row, $lim1)).Cli::dots($lim1, $row, " ");
            
            if(!$value){
                $value = Cli::emo('crossmark', '|1').'Not available ';
                $table .= "| ".limitChars($value, $lim2).Cli::dots($lim2 + 2, $value, " ")."|".br(); 
            }else{
                
                $table .= "| ".limitChars($value, $lim2).Cli::dots($lim2, $value, " ")."|".br(); 
            }

            $table .= "".str_repeat("-", $lines)."".br();

        }

        //print $table;

        $mod = ['migration'=> 'last migrated file', 'created_at'=> 'applied on'];
        
        // $count = 0;
        // foreach($fields as $field => $value){
        //     $value = $mod[$value] ?? $value;
        //     $table .= "| ".strtoupper(limitChars($value, $lim)).Cli::dots($num, limitChars($value, $lim2), " ");
        //     $count++;
        // }
        
        // if($rows){
        //     $table .= "|".Cli::br();
        //     $table .= "".str_repeat("-", $lines)."".br();
    
        //     $count = 0;
        //     foreach($rows as $row => $value){
        //         $table .= "| ".limitChars($value, $lim).Cli::dots($num, limitChars($value, $lim2), " ");
        //         $count++;
        //     }
        // }else{

        //     $table .= "|".Cli::br();
        //     $table .= "".str_repeat("-", $lines)."".br();
        //     $count = 0;
        //     foreach($fields as $field => $value){
        //         $table .= "| ".limitChars(Cli::emo('crossmark', '|1').'Not available', $lim).Cli::dots($num + 2, limitChars(Cli::emo('crossmark', '|1').'Not available', $lim2), " ");
        //         //$table .= "| ".limitChars($value, $lim).Cli::dots($num, limitChars($value, $lim2), " ");
        //         $count++;
        //     }
        //     // $table .= "|".Cli::br();
        //     // $table .= "".str_repeat("-", $lines)."".br();
            
        // }

        // $table .= "|".Cli::br();
        //        $table .= "".str_repeat("-", $lines)."".Cli::br();
        $totalNew = count($newMigrations);
        $text = strtoupper("pending migrations");
        $table .= "| ".limitChars($text, $lim1).Cli::dots($lim1, $text, " ");
        
        $table .= "|"." $totalNew".Cli::dots($lim2, $totalNew, " ")."|".br()."".str_repeat("-", $lines)."".Cli::br();
        
        $totalNew = count($newMigrations);
        $text = strtoupper("applied migrations");
        $table .= "| ".limitChars($text, $lim1).Cli::dots($lim1, $text, " ");
        
        $table .= "|"." $allmigrations".Cli::dots($lim2, $allmigrations, " ")."|".br()."".str_repeat("-", $lines)."".Cli::br();

        Cli::textView(Cli::alert($table), '', '|1');

    }

    protected function log(string $message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
    
}
