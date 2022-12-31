<?php

namespace spoova\core\classes;

use DBStatus;
use User;

class DBCollectibles implements DBOperators {

    /**
     * Instance of DBCollectibles
     *
     * @var DBCollectibles
     */
    public static ? DBCollectibles $tthis = null;

    /**
     * Database Handler
     *
     * @var DBHandler
     */
    public static DBHandler $dbh;

    /**
     * Parent model instance
     *
     * @var Model
     */
    public static Model $model;

    /**
     * Parent table name
     *
     * @var string
     */
    private static string $tableName;

    /**
     * Store sql query structures
     *
     * @var array
     */
    public $sql = [];

    final function __construct(Model $model, string $className = ''){
        
        self::$tthis = $this;
        self::$model = $model;
        self::$dbh   = User::auth()->dbh();

        if($className) self::$tableName = $className; 

        $this->sql = [
            'SELECT'   => 'SELECT %s FROM',
            'WHERE' => '',
            'ON' => '',
            'QUERY' => '',
            'FIELDS' => [],
            'PARAMS' => [],
            'DEFAULTS' => [],
            'FOREIGN_KEY' => '',
            'OWNER_KEY' => '',
            'BY_RECENT' => '',
        ];

 
    }

    static function collect(Model $model, string $className, string $relationship, string $query, string $foreignKey, string $ownerKey){
        
        $collectibles = new self($model, $className); //dbcollectibles

        $collectibles->sql['QUERY'] = ($query);
        $collectibles->sql['FOREIGN_KEY'] = strtolower($foreignKey);
        $collectibles->sql['OWNER_KEY'] = strtolower($ownerKey);
        $collectibles->sql['SELECTION'] = ($relationship == 'ownsMany')? $className : $model::tableName();

        //$collection = $collectibles->read([])->protect(Collection::protected());
        return $collectibles; 
        //$this->$className = [];
    }

    // static function instance(Model $Model) : DBCollectibles {
        
    //     return new self($Model);

    // }

    /**
     * Select where
     *
     * @return DBCollectibles
     */
    static function where(string $where, array $params = []) : DBCollectibles {

        $tthis = self::$tthis;
        $where = $tthis->sql['WHERE'] .= $where;
        $tthis->sql['PARAMS'] = array_merge($tthis->sql['PARAMS'], $params);

        $query = $where;
        
        self::$tthis->sql['QUERY'] .= $query; 

        return self::$tthis;

    }

    /**
     * Read from database
     *
     * @return DBCollectibles|Collectibles
     */
    static function read(array $fields = [], array $limit = []) : DBCollectibles|Collectibles {

        $tthis  = self::$tthis;

        if($fields) {
            $fields = array_merge($tthis->sql['FIELDS'], $fields);
        }else{
            $fields = $tthis->sql['FIELDS'];
        }

        $fields = DBConstruct::Fields($fields);

        $select = $tthis->sql['SELECT'];
        
        $select = sprintf($select, $fields);
        
        $query  = $select." ".$tthis->sql['QUERY'].$tthis->sql['WHERE'];

        $params = $tthis->sql['PARAMS'];

        $byRecent = $tthis->sql['BY_RECENT']? 'ORDER BY '.$tthis->sql['SELECTION'].'.'.$tthis->sql['BY_RECENT'].' DESC' : '';

        $query .= " ".$byRecent;

        $db    = self::$dbh;

        $db->query($query, $params)->read(...$limit);

        $rebuild = [];

        $results = $db->results();
        $defaults = $tthis->sql['DEFAULTS'] ?: [];

        //get Model Table Name
        $modelTable = self::$tableName ?: self::$model::tableName();
        
        if($db->error()){

            //add error into collectibles
            $tthis->DBError = $db->error(); 
            Collectibles::setError($tthis->DBError);

        }else{
            $tthis->DBError = false;
            Collectibles::setError(null);

            $rebuild = $results;

            foreach($results as $index => $result){

                foreach($defaults as $key => $value){
                 
                    if(!isset($rebuild[$index][$key])){ ;
                        $rebuild[$index][$key] = $value;
                    }
                }

            }

            $data = (new Collectibles($rebuild, self::$model, $modelTable))->protect(Collection::protected());
            
            $data->{$modelTable} = $data->Collection();
            if(self::$tableName){
                return $data;
            }


        }

        //return new Collectibles($db->results(), $modelTable);
        return (new Collectibles($rebuild, self::$model, $modelTable, true))->protect(Collection::protected());

    }

    /**
     * delete from database
     *
     * @return DBCollectibles
     */
    static function delete(int $limit = null) : DBCollectibles {

        return self::$tthis;

    }

    /**
     * Update database table
     *
     * @return DBCollectibles
     */
    static function update() : DBCollectibles {

        return self::$tthis;

    }

    /**
     * Join database
     *
     * @return DBCollectibles
     */
    static function on() : DBCollectibles {

        return self::$tthis;

    } 

    /**
     * Uses the one to many relationship to pull data of current user (User::tablename()) in 
     * another table.
     *
     * @return DBCollectibles
     */
    static function ofUser(int $userid = null, string $ForeignKey = null) : DBCollectibles {

        $userTB = User::tableName();
        $userID = ($userid === null) ? User::id()->primary() : $userid;
        $modelTB = self::$model::tableName();
        $modelTBS = self::toSingular($modelTB);
        self::$tthis->sql['FIELDS'][] = '*';
        self::$tthis->sql['FIELDS'][] = $modelTB.".id AS {$modelTBS}_id";
        self::$tthis->sql['SELECT'] = "SELECT %s FROM";
        self::$tthis->sql['WHERE'] .= " {$modelTB} JOIN {$userTB} ON {$userTB}.id = {$modelTB}.user_id WHERE {$modelTB}.user_id = {$userID}";
        return self::$tthis;

    } 

    /**
     * This relationship selects data owned by an another table where $ownerTB is the owner 
     * and the model class is owned.
     *
     * @param string $ownerTB name of database table
     * @param string|int|null $ForeignId a model foreignId if not default 
     * @param string|int|null $ForeignKey a new model Foreignkey if not default 
     * @return DBCollectibles
     */
    static function of(string $ownerTB, string $ForeignId = null, string $ForeignKey = null) : DBCollectibles {

        $modelTB = ucfirst(self::$model::tableName());
        $ForeignKey = $ForeignKey?? self::toSingular($ownerTB).'_id'; 

        $Where = ($ForeignId)? "WHERE {$modelTB}.{$ForeignKey} = ".$ForeignId : "";
   
        self::$tthis->sql['WHERE'] .= " {$modelTB} JOIN {$ownerTB} ON {$ownerTB}.id = {$modelTB}.{$ForeignKey} ".$Where;

        return self::$tthis;

    } 


    public static function from(string $modelClass) {
        
        if(appExists($modelClass)){
            if(method_exists($modelClass, 'belongsTo')){

                //Primary model configs
                $modelTable_s = self::$model::tableName(); //$modelTable
                $modelTable = self::toSingular($modelTable_s);
                $modelBelongsTo = '';

                if($modelBelongsTo){

                    //if model belongs to a class (parentTables), get name of that class
                    $modelParentTable = self::toSingular($modelBelongsTo::tableName());

                    //set foreign key as the parentTable_id
                    $modelForeignKey = $modelParentTable.'_id';

                }else{
                    
                    //if model belongs to no class, get the model table name
                    $modelParentTable = self::toSingular($modelClass::tableName());

                    //set foreign key, as owners real primary field name. i.e use id of owner table
                    $modelForeignKey = 'id';
                }

                //Secondary model configs
                $childTable = $modelClass::tableName();
                $childBelongsTo = $modelClass::belongsTo()?: ''  ;

                if($childBelongsTo){

                    //if child belongs to a class (parentTables), get the name of that class
                    $childParentTable = self::toSingular($childBelongsTo::tableName());

                    //use owner's foreign key (field name). That is : parentTable_id
                    $childForeignKey = $childParentTable.'_id';

                }else{
                    
                    //if child belongs to no class, get the child's table name
                    $childParentTable = self::toSingular($modelClass::tableName());
                    
                    //use owner's real primary key field name.
                    $childForeignKey = 'id';

                }

                $query = "SELECT * FROM {$modelTable_s} 
                    JOIN {$childTable} ON $modelTable_s.{$modelForeignKey} = {$childTable}.{$modelTable}_id";
            }else{
                EInfo::view('Only a valid model class path can be supplied as parameter on "from()"');
            }
        }

    }

    /**
     * Sets the default for data obtained
     *
     * @param array $defaults
     * @return DBCollectibles
     */
    static function withDefault(array $defaults = []) {
        self::$tthis->sql['DEFAULTS'] = $defaults;
        return self::$tthis;
    }
    
    /**
     * set the order of a field to recent items using 
     * specified field name.
     *
     * @param string $fieldname database table's field name
     * @notice default is set by owner key
     * @return DBCollectibles
     */
    static function byRecent(string $fieldname = '') {
        $fieldname = $fieldname ?: self::$tthis->sql['OWNER_KEY'];
        self::$tthis->sql['BY_RECENT'] = $fieldname;
        return self::$tthis;
    }

    private static function toSingular($name){
        return ((substr($name, -1) === 's')? substr($name, 0, strlen($name) - 1) : $name);
    }

}