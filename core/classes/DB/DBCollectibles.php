<?php

namespace teymzz\spoova\core\classes\DB;

use teymzz\spoova\core\classes\Collectibles;
use teymzz\spoova\core\classes\Collection;
use teymzz\spoova\core\classes\DBConstruct;
use teymzz\spoova\core\classes\Model;
use User;

class DBCollectibles implements DBOperators {

    /**
     * Instance of DBCollectibles
     *
     * @var DBCollectibles
     */
    public static ? DBCollectibles $tthis = null;

    public $DBError;

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
    private static string $tableName = '';

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

        if($className) {
            self::$tableName = $className; 
            $parentTable     = $className;
        }else{
            $parentTable = $model::tableName(); 
        }

        $this->sql = [
            'OPERATION'   => "",
            'USE' => '',
            'WHERE' => '',
            'JOIN' => '',
            'ON' => '',
            'QUERY' => '',
            'FIELDS' => [],
            'PARAMS' => [],
            'DEFAULTS' => [],
            'FOREIGN_KEY' => '',
            'OWNER_KEY' => '',
            'BASE_TABLE' => strtolower($parentTable),
            'BY_RECENT' => [],
            'ORDER' => [],
        ];

 
    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param string $className
     * @param array $relationship contains the type of relationship (e.g matchMany) and the relative class (used as access property only)
     * @param string|array $query
     * @param string|array $foreignKey 
     *   - If array is supplied, will contain a child table foreign and local keys
     * @param string|array $ownerKey
     *   - If array is supplied, will contain a parent table foreign and local keys
     * @return DBCollectibles
     */
    static function collect(Model $model, string $className, array $relationship, string|array $query, string|array $foreignKey, string|array $ownerKey){
        
        $dbcollectibles = new self($model, $className); //dbcollectibles

        if(is_array($query)){
            $dbcollectibles->sql['BASE_TABLE'] = ($query[0] ?? '');
            $dbcollectibles->sql['QUERY'] = ($query[1] ?? '');
        } else {
            $dbcollectibles->sql['QUERY'] = ($query);
        }

        
        $dbcollectibles->sql['FOREIGN_KEY'] = $foreignKey;
        $dbcollectibles->sql['OWNER_KEY'] = $ownerKey;
        if(strtolower(($relationship[0]??'') == 'matchMany')){
            $selection = $className;
        }else{
            $selection = $model::table();
        }
        $dbcollectibles->sql['SELECTION'] = $selection;
        $dbcollectibles->sql['RELATION']    = $relationship[1] ?? '';
        $dbcollectibles->sql['RELATIONSHIP'] = $relationship[0]?? '';
        
        return $dbcollectibles; 
    }

    /**
     * Select where
     *
     * @return DBCollectibles
     */
    static function where(string $where, array $params = []) : DBCollectibles {

        $tthis = self::$tthis;

        $useWHERE = (!$tthis->sql['WHERE'])? " WHERE " : " AND ";

        $where = $tthis->sql['WHERE'] .= $useWHERE.$where;
        if($params) $tthis->sql['PARAMS'] = array_merge($tthis->sql['PARAMS'], $params);

        return self::$tthis;

    }

    /**
     * Select and where
     *
     * @return DBCollectibles
     */
    static function andWhere(string $where, array $params = []) : DBCollectibles {

        $tthis = self::$tthis;

        $where = $tthis->sql['WHERE'] .= " AND {$where}";
        if($params) $tthis->sql['PARAMS'] = array_merge($tthis->sql['PARAMS'], $params);

        $query = $where;
        
        self::$tthis->sql['QUERY'] .= $query; 

        return self::$tthis;

    }

    /**
     * Select and where
     *
     * @return DBCollectibles
     */
    static function orWhere(string $where, array $params = []) : DBCollectibles {

        $tthis = self::$tthis;

        $where = $tthis->sql['WHERE'] .= " OR {$where}";
        if($params) $tthis->sql['PARAMS'] = array_merge($tthis->sql['PARAMS'], $params);

        $query = $where;
        
        self::$tthis->sql['QUERY'] .= $query; 

        return self::$tthis;

    }



    /**
     * Read from database
     *
     * @return DBCollectibles|Collectibles
     * 
     * @param array $fields fields to be returned
     * @param array $limit limit of data to be returned
     */
    static function read(array $fields = [], array $limit = []) :  DBCollection|DBCollectibles|Collectibles {

        $tthis  = self::$tthis;

        if($fields) {
            $tthis->sql['FIELDS'] = array_delete($tthis->sql['FIELDS'], '*');
            $fields = array_merge($tthis->sql['FIELDS'], $fields);
        }else{
            $fields = $tthis->sql['FIELDS'];
        }

        $fields = DBConstruct::Fields($fields);

        $use  = $tthis->sql['USE'];
 
        if(!$tthis->sql['OPERATION']){
            $tthis->sql['OPERATION'] = " SELECT %s{$use} FROM ";
        }

        $select = $tthis->sql['OPERATION']." ".$tthis->sql['BASE_TABLE'];
        
        $select = sprintf($select, $fields);
        
        $query  = $select." ".$tthis->sql['JOIN'].$tthis->sql['QUERY'].$tthis->sql['WHERE'];

        $params = $tthis->sql['PARAMS'];

        $byOrder = $tthis->sql['ORDER']?:'';
        $byRecent = $tthis->sql['BY_RECENT']?:'';

        if($byOrder){
            
            $order = $byOrder[1]; //ASC|DESC
            $byOrder = $byOrder[0];

            $sortField = implode('.', $byOrder);

            $byOrder = " ORDER BY ".$sortField." ".$order;

        }elseif($byRecent){

            $byOrder = " ORDER BY ".$tthis->sql['SELECTION'].'.'.$byRecent." DESC";

        }

        $query .= $byOrder;

        $db    = self::$dbh;

        $relationship = ($tthis->sql['RELATIONSHIP']?? '');


        $oneRelations = ['matchOne','matchOneFor'];
        
        if(in_array($relationship, $oneRelations)){
            if($limit){
                //add error into collectibles
                $tthis->DBError = 'setting limit is not allowed on relationship: ONE TO ONE)'; 
                Collectibles::setError($tthis->DBError);
                return (new Collectibles([], self::$model, (basename(to_frontslash(get_class(self::$model)))), true))->protect(Collection::protected());
            }else{

                $query .= " LIMIT 1";
                
            }
        }
        print($query);
        $db->query($query, $params)->read(...$limit);

        $rebuild = [];

        $results = $db->results();
        $defaults = $tthis->sql['DEFAULTS'] ?: [];

        //get Model Table Name
        $modelTable = self::$tableName ?: self::$model::table();

        $modelName = $tthis->sql['RELATION'] ?? (basename(to_frontslash(get_class(self::$model))));

        if($relationship){
            $relation = $tthis->sql['RELATION'];
        }else{
            $relation = $modelName;
        }
        
        if($db->error()){

            //add error into collectibles
            $tthis->DBError = $db->error(); 
            Collectibles::setError($tthis->DBError);        
            $collectibles = (new Collectibles($rebuild, self::$model, $modelName, true))->protect(Collection::protected());

            $collectibles->{$relation} = $collectibles->collection();
            return $collectibles;

        }else{
            $tthis->DBError = false;
            Collectibles::setError(null);

            $rebuild = $results;
            if($results){
                foreach($results as $index => $result){

                    foreach($defaults as $key => $value){
                    
                        if(!isset($rebuild[$index][$key])){ ;
                            $rebuild[$index][$key] = $value;
                        }
                    }

                }               
            }else{
                $rebuild[0] = $defaults;
            }
            

            $data = (new Collectibles($rebuild, self::$model, $modelName))->protect(Collection::protected());  

            $data->{$relation} = $data->collection();

            if(self::$tableName){
                return $data;
            }

        }


        return (new Collectibles($rebuild, self::$model, $modelName, true))->protect(Collection::protected());

    }

    /**
     * delete from database
     *
     * @return bool
     */
    static function delete(bool|int $limit = null) : bool {

        $tthis  = self::$tthis;
        $tthis->sql['OPERATION'] = " DELETE FROM ".$tthis->sql['BASE_TABLE'];

        $params = [];

        if($tthis->sql['WHERE']){
            $sql = $tthis->sql['OPERATION'] .= " ".$tthis->sql['WHERE'];
            $params = $tthis->sql['PARAMS'];
        }

        
        $byOrder = $tthis->sql['ORDER']?:'';
        $byRecent = $tthis->sql['BY_RECENT']?:'';

        if($byOrder){
            
            $order = $byOrder[1]; //ASC|DESC
            $byOrder = $byOrder[0];

            $sortField = implode('.', $byOrder);

            $byOrder = " ORDER BY ".$sortField." ".$order;

        }elseif($byRecent){

            $byOrder = " ORDER BY ".$tthis->sql['SELECTION'].'.'.$byRecent." DESC";

        }

        $tthis->sql['OPERATION'] .= $byOrder;
        
        if($limit === true || is_int($limit)){
            if(is_int($limit)){
                $sql = $tthis->sql['OPERATION'] .= " LIMIT ".$limit;
            }else{
                $sql = $tthis->sql['OPERATION'];
            }
        }

        if(($sql??'')){
            $sql = trim($sql, " ");
            $db  = self::$dbh;
            $db->query($sql, $params);

            $limit = !is_int($limit)? null : $limit;

            return $db->delete($limit);
        }
        
        return false;

    }

    /**
     * Update database table
     *
     * @return bool
     */
    static function update(array $fields) : bool {

        $tthis  = self::$tthis;
        $tthis->sql['OPERATION'] = " UPDATE ".$tthis->sql['BASE_TABLE']." SET ";

        $PARAMS = $tthis->sql['WHERE'] ? $tthis->sql['PARAMS'] : [];

        DBConstruct::bindedParams($fields, $params, $placeholders);
        $params = array_merge($params, $PARAMS);
        
        $sql  = $tthis->sql['OPERATION'] .= " ".$placeholders; 
        $sql .= $tthis->sql['WHERE'];


        if(($sql??'')){
            $sql = trim($sql, " ");
            $db  = self::$dbh;
            return $db->query($sql, $params)->update();
        }
        
        return false;

    }

    /**
     * Uses the one to many relationship to pull data of current user (User::tablename()) in 
     * another table. The user table in this case must have a primary id field
     *
     * @return DBCollectibles
     */
    static function ofUser(int $userid = null, string $ForeignKey = null) : DBCollectibles {

        $userTB = strtolower(User::tableName());
        $userID = ($userid === null) ? User::id()->primary() : $userid;
        $modelTBS = $modelTB = self::$model::table();

        //$modelTBS = self::toSingular($modelTB);
        self::$tthis->sql['BASE_TABLE'] = "{$userTB}";
        self::$tthis->sql['FIELDS'][] = "*";
        /* always return model_id */
        //self::$tthis->sql['FIELDS'][] = $modelTB.".id AS {$modelTBS}_id";
        self::$tthis->sql['JOIN'] .= " JOIN {$modelTB} ON {$userTB}.id = {$modelTB}.{$userTB}_id ";
        self::$tthis->sql['WHERE'] .= " WHERE {$modelTB}.{$userTB}_id = {$userID}";
        
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

        $modelTB = self::$model::table(); 

        self::$tthis->sql['BASE_TABLE'] = "{$ownerTB}";

        //$ForeignKey = $ForeignKey?? self::toSingular($ownerTB).'_id'; 
        $UseForeignKey = $ForeignKey?? toSingular($ownerTB).'_id'; 
        
        $parent_to_child = " JOIN {$modelTB} ON {$ownerTB}.id = {$modelTB}.{$UseForeignKey} ";

        $Where = ($ForeignId)? " WHERE {$modelTB}.{$UseForeignKey} = ".$ForeignId : "";

        self::$tthis->sql['JOIN']  .= $parent_to_child;
        self::$tthis->sql['WHERE'] .= $Where;
        // self::$tthis->sql['WHERE_SUFFIX'] = $Where;

        self::$tthis->sql['TABLE']['OWNER'] = $ownerTB;
        self::$tthis->sql['TABLE']['MODEL'] = $modelTB;
        self::$tthis->sql['TABLE']['FOREIGN_ID'] = $ForeignId;
        self::$tthis->sql['TABLE']['FOREIGN_KEY'] = $ForeignKey;

        return self::$tthis;

    } 

    /**
     * Select fields through class for ambiguous fields
     *
     * @param array $use
     *  - format: [class => ['field' => 'customFieldName']]
     * @return DBCollectibles
     */
    public function use(array $use){
        $sql = [];
        
        foreach($use as $tableName => $field){
            if(strpos($tableName, '\\')!==false){
                $tableName = $tableName::table();
            }else{
                $tableName = strtolower($tableName);
            }
            array_map(function($value, $key) use(&$sql, $tableName){
                   $sql[] = "{$tableName}.{$key} AS {$value}";
            },$field, array_keys($field));
        }

        $use = (implode(", ", $sql));
        if($use) $use = ", ".$use;
        $tthis = self::$tthis;

        $tthis->sql['USE'] = $use;

        return self::$tthis;
    }

    public function bind(string $tableName){

        self::$tthis->sql['BIND'] = $tableName;
        $bindTable = self::$tthis->sql['BIND'];
        
        $ownerTB = self::$tthis->sql['TABLE']['OWNER'];
    
        $ForeignKey  = toSingular($tableName).'_id';
       
        self::$tthis->sql['JOIN'] .= " JOIN {$bindTable} ON {$bindTable}.id = {$ownerTB}.{$ForeignKey}";

        return self::$tthis;
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
     * @param array|string $field
     *   - if $field is string set as owner model's field name (i.e depeding on relationship defined).
     *   - if $field is array set as array list of desired "Model" and fieldname respectively within the relationship range.
     * @return DBCollectibles
     */
    static function byRecent(array|string $field = 'id') {

        if(is_array($field)){
            if(count($field) > 1){
                $model = $field[0];
                $fieldName = $field[1];
                if(strpos($model, '\\')!==false){
                    $model = $model::tableName();
                }
            }else{
                $model = get_class(self::$tthis::$model);
                $model = $model::tableName();
                $fieldName = $field[0] ?? self::$tthis->sql['OWNER_KEY'];
            }
        }else{
            $model = get_class(self::$tthis::$model);
            $model = $model::tableName();
            $fieldName = $field ?: self::$tthis->sql['OWNER_KEY'];
        }
        if(strpos($fieldName, '\\')!==false){
            $fieldName = $fieldName::tableName();
        }
        self::$tthis->sql['SELECTION'] = $model;
        self::$tthis->sql['BY_RECENT'] = $fieldName;
        return self::$tthis;
    }
    
    /**
     * set the order in which a data is obtained using a specified field name.
     *
     * @param array|string $field relative database table's field name
     *     - if $field is string, then property table is set as sort table while $field is the sort field
     *     - if $field is array, then the first value is assumed as the sort table
     *       while the second value is the sort field
     * @param string $order optional [ASC|DESC] default is ASC
     * @return DBCollectibles
     */
    static function order(array|string $field, string $order = "ASC") {
        $field = (array) $field;
        if(count($field) > 1){ 
            $model = $field[0];
            if(strpos($model, '\\')!==false){
                $model = $model::tableName();
            }
            $field[0] = $model;
        }elseif(strpos(($field[0]??''), '\\')!==false){
            $field[0] = $field[0]::tableName();
        }
        self::$tthis->sql['ORDER'] = [$field, $order];
        return self::$tthis;
    }

}