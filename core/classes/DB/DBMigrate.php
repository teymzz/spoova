<?php 

namespace spoova\core\classes\DB;

use spoova\core\commands\Make\MkMigrator;

class DBMigrate {


    public function migrate(){

        $DBMigrator = new DBMigrator;

        $DBMigrator->migrate_up();

    }

    public function unmigrate(int $times = null){

        $DBMigrator = new DBMigrator;

        $DBMigrator->migrate_down(...func_get_args());

    }
    public function add($args) : bool {

        $MkMigrator = new MkMigrator($args);

        return $MkMigrator->build();

    }


}