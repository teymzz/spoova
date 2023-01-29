<?php 

namespace spoova\core\classes\DB\DBSchema;

use Closure;
use spoova\core\classes\DB\DBPlugins;
use spoova\core\commands\Cli;

trait TBPARTITION {

    use TBGROUP;

    /**
     * Set partition option
     *
     * @param string $type  optional [RANGE|LIST]
     * @return DRAFT
     */
    public static function PARTITION_BY($type, Closure $callback) : DRAFT {

        $plugin = DBPlugins::get('partition', 'PLUGIN_STATUS');

        if(strtolower($plugin) !== 'active'){
            self::callError(Cli::error(" Database does not support table partitioning "));
            return self::$instance;
        }
        
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        self::$TYPE['OLD'] = $TYPE;
        
        if(in_array($type, self::options(__FUNCTION__))){

            self::$$TYPE['PARTITION_BY'] = "PARTITION BY {$type}"; //set query
            self::$$TYPE['PARTITIONS']   = '';
            self::$TYPE[1] = 'PARTITION'; //set scope

            $DRAFT = $callback(self::$instance); //return a draft string

            if($DRAFT instanceof DRAFT){
                self::$TYPE[0] = '';
                $DRAFT::BUILD_PARTITION();
                self::$TYPE[0] = self::$TYPE['OLD'];
                unset(self::$TYPE['OLD']);
                self::$TYPE[1] = '';
            }else{
                self::callError(Cli::error(" closure argument(#2) of PARTITION_BY must return a DRAFT object. ")); 
            }

        }else{
            self::callError(Cli::error(" invalid partition option supplied. Option can only be \"RANGE\" or \"LIST\". "));       
        }
        
        return self::$instance;

        //PARTITION BY RANGE VALUES LESS THAN
        // VALUES

        /* 

            $DRAFT::PARTITION_BY('RANGE')->COLUMNS()->
            ->PARTITION('VALUES LESS THAN (UNIX_TIMESTAMP('2013-04-01'));')
            ->PARTITION('VALUES LESS THAN (UNIX_TIMESTAMP('2013-05-01'));')
            
            $DRAFT::PARTITION_BY('RANGE', function(DRAFT $DRAFT){

                $DRAFT::COLUMNS([])
                            
                        -> PARTITION('p0',"LESS THAN")->VALUE('')
                        -> PARTITION('p0',"LESS THAN")->VALUE('')
                        -> PARTITION('p0',"LESS THAN")->VALUE('')
                        -> PARTITION('p0',"LESS THAN")->VALUE('')
                    

            })   
            
            
            
            
            
            
            $DRAFT ->COLUMNS([]);
                       ->WITH('p0')->LESS_THAN();
                       ->WITH('p1')->LESS_THAN();
                       ->WITH('p2')->IN();

                       WITH('p0', "LESS THAN")->VALUE('UNIX_TIMESTAMP()')
                       WITH('p0', "IN")->VALUE('UNIX_TIMESTAMP()')
        */

        // PARTITION BY RANGE
        // PARTITION BY LIST
        // PARTITION BY COLUMNS
        // PARTITION BY HASH
        // PARTITION BY KEY

    }

    /**
     * Set columns on partition
     *
     * @return DRAFT
     */
    public function COLUMNS(array|string $columns) : DRAFT {

        $TYPE = self::$TYPE['OLD'] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //PARTITION

        if($MODE === 'PARTITION'){
            
            if(is_array($columns) && !arrInside($columns)){
                self::$$TYPE['PARTITION_BY'] .= " COLUMNS (". implode(',', $columns)." )";
            }elseif(is_string($columns)){
                self::$$TYPE['PARTITION_BY'] .= "($columns)";
            }else{
                self::callError(Cli::error(" invalid array format supplied on ".Cli::warn('DRAFT::COLUMNS()')." method"));       
            }
            
        }else{
            self::callError(Cli::error(" DRAFT::".__FUNCTION__."() must be called on \"PARTITION_BY()\"  "));       
        }

        return self::$instance;
    }

    /**
     * Set partition name and checker
     *
     * @param string $name partition identifier name
     * @param string $checker  options ['LESS THAN'|'IN']
     * @return DRAFT
     */
    public function PARTITION(string $name, string $checker) : DRAFT{

        $TYPE = self::$TYPE['OLD'] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //PARTITION
        self::$TYPE[2] =  __FUNCTION__; //FUNCTION

        $checkers = [
            'LESS THAN' => 'VALUES LESS THAN', 'VALUES LESS THAN' => 'VALUES LESS THAN',
            'IN'=>'VALUES IN', 'VALUES IN' => 'VALUES IN'];

        if($MODE === 'PARTITION'){

            if(array_key_exists($checker, $checkers)){
                $checker = $checkers[$checker];
                self::$$TYPE['PARTITIONS'] .= " PARTITION {$name} $checker ";
            }else{
                self::callError(Cli::error(" invalid argument(#2) supplied on ").Cli::warn('DRAFT::PARTITION()'));       
            }
            
        }else{
            self::callError(Cli::error(" DRAFT::".__FUNCTION__."() must be called on \"PARTITION_BY()\"  "));       
        }

        return self::$instance;

    }

    /**
     * Set partition values
     *
     * @param string $name
     * @param string $value  
     *  - options [ ('VALUES LESS THAN' or 'LESS THAN') | ('VALUES IN' or 'IN') ]
     * @return DRAFT
     */
    public function VALUE(string|array $value) : DRAFT {

        $TYPE = self::$TYPE['OLD'] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //PARTITION
        $FUNC = self::$TYPE[2] ?? ''; //PARTITION

        $value = (array) $value;

        if($MODE === 'PARTITION'){

            if($FUNC === 'PARTITION'){

                if(!arrInside($value)){

                    self::$$TYPE['PARTITIONS'] .= " (". implode(',', $value).") ";
                    self::$TYPE[2] = '';

                }else{
                    self::callError(Cli::error(" invalid array format supplied on ".Cli::warn('DRAFT::COLUMNS()')." method"));       
                }
                
            }else{
                self::callError(Cli::error(" DRAFT::".__FUNCTION__."() must be called on \"PARTITION()\"  "));  
            } 
            
        }else{
            self::callError(Cli::error(" DRAFT::".__FUNCTION__."() must be called within the scope of \"PARTITION_BY()\"  "));       
        }

        return self::$instance;

    }

    /**
     * Add partition to draft sql
     *
     * @return void
     */
    public static function BUILD_PARTITION(){
        
        $TYPE = self::$TYPE['OLD'] ?? ''; //PARTITION
        $MODE = self::$TYPE[1] ?? ''; //PARTITION

       // $TTYPE= self::$TYPE['OLD'];
        $PARTITION_BY = self::$$TYPE['PARTITION_BY'] ?? '';
        $PARTITIONS = self::$$TYPE['PARTITIONS'] ?? '';

        if($MODE === 'PARTITION'){

            $PARTITION = " {$PARTITION_BY} ({$PARTITIONS}) ";
            unset(self::$$TYPE['PARTITIONS']);
            self::$$TYPE['PARTITION_BY'] = $PARTITION;

        }else{
            self::callError(Cli::error(" the method DRAFT::BUILD_PARTITION() was called within an unrelated scope! "));
        }
    }

}