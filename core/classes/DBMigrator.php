<?php

namespace spoova\core\classes;

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

    public function __construct(){

        $auth = \User::auth();
        $this->dbc = $auth->dbc();
        $this->dbh = $auth->dbh();

        return $this->dbh;

    }

    public function dbc(){
        return $this->dbc;
    }

    public function applyMigrations(){

        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(getDefined('docroot').'/migrations');

        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration){
            if($migration === '.' || $migration === '..') continue;
            require_once getDefined('docroot').'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("applying migration ".$migration);
            $instance->up();
            $this->log("applied migration ".$migration);
            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            $this->log("All migrations are applied");
        }
       
    }

    public function createMigrationsTable(){
        $dbh = $this->dbh;
        $dbh->query("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
        $dbh->process();

    }


    public function getAppliedMigrations(){
        $dbh = $this->dbh;
        $dbh->query("SELECT migration from migrations");
        $migrations =  $dbh->read()? array_column($dbh->results(), 'migration') : [];
        return $migrations;
    }    

    public function saveMigrations(array $migrations){

        $dbh = $this->dbh;
        foreach($migrations as $migration){
            $dbh->insert_into('migrations',['migration'=>$migration]);
            $dbh->insert();
        }
        
    }

    protected function log(string $message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
    
}
