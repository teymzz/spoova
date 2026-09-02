<?php 

namespace spoova\mi\core\commands\Support;

use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\DB\DBSeeder;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

/**
 * Command line class for resolving seeder processes.
 */
class Seeder extends Entry{

    public function __construct($args = [])
    {
        $arg1 = $args[0]?? '';
        $arg2 = $args[1]?? '';

        Cli::textView(Cli::danger(Cli::emo('point-list').' seeder '.$arg1));
        Cli::break(2);

        if(!in_array($arg1, $this->valid_arguments())){
            $arg = ($arg1)?  '"'.Cli::warn($arg1).'"' : 'empty';
            Cli::textView(Cli::error("invalid $arg argument supplied for ".Cli::alert('seeder')));
            Cli::break(2);   
            exit;        
        }else if(count($args) > 2){
            Cli::textView(Cli::error("invalid arguments supplied for ".Cli::alert('seeder')));
            Cli::break(1)->bashBreak(1); 
            exit;
        }

        //get specified seeder ...
        [$directory, $namespace] = array_values(DBSeeder::pathInfo());

        /* seeder syntax: <table>[:index]? -- an index targets "seed_<table>_<index>" */
        $seederTable = $arg2;
        $seederIndex = null;

        if(strpos($seederTable, ':') !== false){
            [$seederTable, $seederIndex] = explode(':', $seederTable, 2);
        }

        if($seederTable === ''){
            Cli::textView(Cli::error('no seeder table name supplied for '.Cli::alert('seeder')));
            Cli::break(1)->bashBreak(1);
            exit;
        }

        if($seederIndex !== null && (!ctype_digit($seederIndex) || ((int) $seederIndex < 1))){
            Cli::textView(Cli::error('seeder index must be 1 or greater'));
            Cli::break(1)->bashBreak(1);
            exit;
        }

        /* seeder files are generated in lower case by "add:seeder" */
        $seederFile = strtolower('seed_'.$seederTable);
        if($seederIndex !== null) $seederFile .= '_'.((int) $seederIndex);

        $seederPath = $directory.'/'.$seederFile.'.php';

        if(!file_exists($seederPath)){
            Cli::textView(Cli::error('unknown seeder "'.Cli::warn($seederFile).'"'));
            Cli::break(1)->bashBreak(1);
            exit;
        }

        $seederSpace = $namespace.'\\'.$seederFile;
        $dbTable = ($seederSpace::table());

        if(trim($dbTable) === ''){
            Cli::textView(Cli::error('seeder "'.Cli::warn($seederFile).'" declares no database table'));
            Cli::break(1)->bashBreak(1);
            exit;
        }

        if($db = (new DB())->openDB()){

            self::$arg1($db, compact('seederSpace','dbTable'));

        } else {
            Cli::textView(Cli::error('database connection failed'));
            Cli::break(1)->bashBreak(1); 
        }

    }

    private static function seed(DBHandler $db, array $seedInfo){

        $seederSpace = $seedInfo['seederSpace'];
        $dbTable = $seedInfo['dbTable'];

        $seeds = $seederSpace::seeds();

        if(!$seeds){
            Cli::textView(Cli::error('no seeder data discovered!'));
            Cli::break(1)->bashBreak(1);
            return;
        }

        $columns = array_keys(reset($seeds));

        $data = [];

        foreach($seeds as $seed){

            foreach($columns as $col){
                $data[$col][] = $seed[$col] ?? null;
            }

        }

        $db->insert_into($dbTable, $data);

        if($db->insert()){
            Cli::textView(Cli::success('database table seeded successfully ('.count($seeds).')'));
            Cli::break(1)->bashBreak(1);
        }else{
            Cli::textView(Cli::error($db->error(true)));
            Cli::break(1)->bashBreak(1);
        }
    }

    private static function unseed(DBHandler $db, array $seedInfo){

        $seederSpace = $seedInfo['seederSpace'];
        $dbTable = $seedInfo['dbTable'];

        /** @var \spoova\mi\core\classes\DB\DBSeed $seederSpace */
        $seeds = $seederSpace::seeds(); // list of data to be unseeded.

        if(!$seeds){
            Cli::textView(Cli::error('no seeder data discovered!'));
            Cli::break(1)->bashBreak(1);
            return;
        }

        $unseeds = []; // rows removed
        $absent  = []; // rows that matched nothing (already removed, or never seeded)
        $failed  = []; // rows whose delete query could not run

        foreach ($seeds as $skey => $seed) {

            if(!is_array($seed) || !$seed){
                $failed[$skey] = $seed;
                continue;
            }

            // The seed columns are bound into a "where col=? and col=?..."
            // clause that targets this exact row, while "limit 1" keeps
            // repeated (identical) seeds in step with the number seeded.
            if(!$db->query("DELETE FROM $dbTable", $seed, true)->delete(1)){
                $failed[$skey] = $seed;
                continue;
            }

            if($db->num_rows() > 0){
                $unseeds[$skey] = $seed;
            }else{
                $absent[$skey] = $seed;
            }

        }

        $total   = count($seeds);
        $removed = count($unseeds);

        if($failed){
            Cli::errorView('Process failed: '.($db->error(true) ?: 'unable to unseed '.count($failed).' of '.$total.' rows'));
            Cli::break(1)->bashBreak(1);
            return;
        }

        if($removed === $total){
            Cli::successView('Table data unseeded successfully ('.$removed.'/'.$total.')');
            Cli::break(1)->bashBreak(1);
            return;
        }

        if($removed){
            Cli::successView('Table data unseeded with remnants ('.$removed.'/'.$total.' removed, '.count($absent).' not found)');
            Cli::break(1)->bashBreak(1);
            return;
        }

        Cli::errorView('No seeded data found in "'.$dbTable.'" to unseed.');
        Cli::break(1)->bashBreak(1);

    }

    /**
     * Return valid commands
     *
     * @return array
     */
    private function valid_arguments() : array {
        return ['seed','unseed'];
    }

}