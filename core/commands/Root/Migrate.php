<?php 

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\DB\DBMigrate;

class Migrate extends Entry{

    public function __construct($args = [])
    {
        $arg1 = $args[0]?? '';

        Cli::textView(Cli::danger(Cli::emo('point-list').' migrate '.$arg1));
        Cli::break(2);

        if(!in_array($arg1, $this->valid_arguments())){
         Cli::textView(Cli::error("Invalid \"".Cli::warn($arg1)."\" argument supplied on ".Cli::alert('migrate')));
         Cli::break(2);           
        }
        
        $migration_method = "migration_".$arg1;

        if(method_exists($this, $migration_method)){
            unset($args[0]);
            $args = array_values($args);

            //start migration class
            $this->{$migration_method}($args, new DBMigrate);

        }else{
            Cli::textView(Cli::error("migration method is missing!"));
            Cli::break(2);                 
        }

    }

    /**
     * Add new migration file
     *
     * @param array $args
     * @param DBMigrate $DBMigrate
     * @return void
     */
    public function migration_add(array $args, DBMigrate $DBMigrate){
        
        if(!$args){

            Cli::textView(Cli::error(Cli::warn("migrate all:")." no arguments supplied!"));
            Cli::break(2);                 
            
        }else{
            $DBMigrate->add($args);             
        }


    }

    /**
     * Run migration files
     *
     * @param array $args
     * @param DBMigrate $DBMigrate
     * @return void
     */
    public function migration_up(array $args, DBMigrate $DBMigrate){
        //run migrate files here
        
        if(!$args){

            $DBMigrate->migrate();             

        }else{
            $arg = $args[0];
            Cli::textView(Cli::error(Cli::warn("migrate {$arg}:")." expecting no arguments!"));
            Cli::break(2);                 
        }


    }

    public function migration_down(array $args, DBMigrate $DBMigrate){
        if($args){

            if(count($args) > 1){
                Cli::textView(Cli::error("invalid arguments count supplied!"));
                Cli::break(2);   
                exit;                
            }

            $arg1 = $args[0];
            if(is_numeric($arg1)) $arg1 +=0;

            if(!is_numeric($arg1) || !is_int($arg1)){
                Cli::textView(Cli::error("argument {{$arg1}} must be a valid integer!"));
                Cli::break(2);   
                exit;   
            }

            
            $DBMigrate->unmigrate($arg1);   

        }else{

            $DBMigrate->unmigrate();         

        }

    }

    public function migration_status(array $args, DBMigrate $DBMigrate){

        $DBMigrate->status($args); 

    }

    public function migration_remove(){

    }

    /**
     * Get migrations for tables
     *
     * @return void
     */
    public function migration_select(){

    }

    /**
     * Push migrations back for tables
     *
     * @return void
     */
    public function migration_rewind(){

    }

    /**
     * Push migrations forward for rolled back migrations
     *
     * @return void
     */
    public function migration_forward(){

    }

    /**
     * Return valid commands
     *
     * @return array
     */
    private function valid_arguments($posit = 0) : array {
        return [
            'up',
            'down',
            'add',
            // 'remove',
            // 'rewind',
            // 'forward',
            // 'select',
            'status'
        ];
    }

}