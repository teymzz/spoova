<?php

namespace spoova\mi\core\classes\DB;

use User;
use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\DB\DBViewer;
use spoova\mi\core\classes\DB\DBDeleter;
use spoova\mi\core\classes\DB\DBUpdater;
use spoova\mi\core\classes\DB\DBConstruct;
use spoova\mi\core\classes\Paginator;

/**
 * This class contains custom database operators that directly 
 * navigates how records are retrieved from database.
 */
class DBMediators implements DBOperators {

    /**
     * Instance of DBMediators
     *
     * @var DBMediators
     */
    public static ?DBMediators $tthis = null;

    private string|false $DBError = false;

    /**
     * Contains lists of database retrieved records 
     * @var Collection|array
     */
    public Collection|array $collection = [];

    /**
     * Defines a list of protected database keys
     * @var array
     */
    private array $protected = [];

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
    private $sql = [];

    /**
     * Store sql query
     *
     * @var array
     */
    private $query = [];

    final function __construct(Model $model, string $className = ''){
        
        self::$tthis = $this;
        self::$model = $model;
        self::$dbh   = User::auth()->dbh();

        if($className) {
            self::$tableName = $className; 
            $parentTable     = $className;
        }else{
            self::$tableName = $model::tableName(); 
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
     * defines an sql query required to collect data from database
     *
     * @param Model $model
     * @param string $className
     * @param array $relationship contains the type of relationship (e.g matchMany) and the relative class (used as access property only)
     * @param string|array $query
     * @param string|array $foreignKey 
     *   - If array is supplied, will contain a child table foreign and local keys
     * @param string|array $ownerKey
     *   - If array is supplied, will contain a parent table foreign and local keys
     * @return DBMediators
     */
    static function collect(Model $model, string $className, array $relationship, string|array $query, string|array $foreignKey, string|array $ownerKey){
        
        $DBMediators = new DBMediators($model, $className); //new self

        if(is_array($query)){
            $DBMediators->sql['BASE_TABLE'] = ($query[0] ?? '');
            $DBMediators->sql['QUERY'] = ($query[1] ?? '');
        } else {
            $DBMediators->sql['QUERY'] = ($query);
        }

        
        $DBMediators->sql['FOREIGN_KEY'] = $foreignKey;
        $DBMediators->sql['OWNER_KEY'] = $ownerKey;
        if(strtolower(($relationship[0]??'') == 'matchMany')){
            $selection = $className;
        }else{
            $selection = $model::table();
        }
        $DBMediators->sql['SELECTION'] = $selection;
        $DBMediators->sql['RELATION']    = $relationship[1] ?? '';
        $DBMediators->sql['RELATIONSHIP'] = $relationship[0]?? '';

        self::uses($model::translate());
        
        return $DBMediators; 
    }

    /**
     * Select where
     *
     * @return DBMediators
     */
    static function where(string|array $where, array $params = []) : DBMediators {

        $tthis = self::$tthis;

        if(is_array($where)){
            /** @var string $query */
            DBConstruct::bindedParams($where, $params, $query);
            $query = str_replace('?,', '? AND', $query);
            $tthis->sql['WHERE'] = " WHERE ". $query;
        }else{
            $useWHERE = (!$tthis->sql['WHERE'])? " WHERE " : " AND ";
            $where = $tthis->sql['WHERE'] .= $useWHERE.$where;
        }


        if($params) $tthis->sql['PARAMS'] = array_merge($tthis->sql['PARAMS'], $params);

        return self::$tthis;

    }

    /**
     * Select and where
     *
     * @return DBMediators
     */
    static function andWhere(string $where, array $params = []) : DBMediators {

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
     * @return DBMediators
     */
    static function orWhere(string $where, array $params = []) : DBMediators {

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
     * @return DBViewer
     * 
     * @param array $fields fields to be returned
     * @param array $limit limit of data to be returned
     */
    static function read(string|array $fields = [], array $limit = []) :  DBViewer {

        $tthis  = self::$tthis;

        $fields  = (array) $fields;

        if($fields) {
            $tthis->sql['FIELDS'] = array_delete($tthis->sql['FIELDS'], '*');
            $fields = array_merge($tthis->sql['FIELDS'], $fields);
        }else{
            $fields = $tthis->sql['FIELDS'];
        }

        $fields = DBConstruct::Fields($fields);

        $use  = $tthis->sql['USES'] ?? '';
 
        if(!$tthis->sql['OPERATION']){
            $tthis->sql['OPERATION'] = " SELECT %s{$use} FROM ";
        }

        $select = $tthis->sql['OPERATION']." ".$tthis->sql['BASE_TABLE'];
        
        $select = sprintf($select, $fields);

        $tthis->sql['OPERATION'] = $select;
        
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

        /* A "one" relationship describes how many records may exist on the other side of
           each row - not how many rows are returned. Users::admin() is documented to return
           every user that is an admin, and read($fields, $limit) is what decides how many of
           them come back. An earlier draft here appended " LIMIT 1" for matchOne/matchOneFor
           and rejected any $limit given to them, which would have contradicted both. It never
           ran, because those relationships register themselves as "ownsOne" rather than under
           the names it tested for, and it has been removed rather than revived. */

        $tthis->query = $query;
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
        
        if($db->error(true)){
            $tthis->DBError = $db->error(true);      
            $DBViewer = (new DBViewer($rebuild, $tthis, self::$model, $modelName, true))->protect(static::$tthis->protected);
            return $DBViewer;
        }else{
            $tthis->DBError = false;
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

            /* add protection to data if necessary */
            foreach($results as $key => $value){
                foreach($value as $field => $record){
                    if(in_array($field, static::$tthis->protected)){
                        $results[$key][$field] = '**protected**';
                        if(isset($rebuild[$key]) && array_key_exists($field, $rebuild[$key])){
                            $rebuild[$key][$field] = "**protected**";
                        }
                    }
                }
            }
            
            $data = $DBViewer = (new DBViewer($rebuild, $tthis, self::$model, $modelName));

            if(self::$tableName){
                return $data; /* collectible */
            }

        }


        return (new DBViewer($rebuild, $tthis, self::$model, $modelName, true));

    }

    static function paginate(int $perPage = 15, ?int $page = null) : Paginator {

        return new Paginator(self::$tthis, $perPage, $page);

    }

    public function count() : int {

        $query = "SELECT COUNT(*) AS paginator_total FROM {$this->sql['BASE_TABLE']}";
        $query .= $this->sql['JOIN'].$this->sql['QUERY'].$this->sql['WHERE'];

        $db = self::$dbh;
        $db->query($query, $this->sql['PARAMS'])->read();
        $results = $db->results();

        if($db->error(true) || !isset($results[0]['paginator_total'])){
            $this->DBError = $db->error(true) ?: 'unable to count query results';
            return 0;
        }

        $this->DBError = false;
        return (int) $results[0]['paginator_total'];

    }

    /**
     * Delete data from a model database table
     *
     * @return DBDeleter
     */
    static function delete(bool|int|null $limit = null) : DBDeleter {

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
            /** @var string $sql */
            $sql = trim($sql, " ");
            $db  = self::$dbh;
            $db->query($sql, $params);

            $limit = !is_int($limit)? null : $limit;

            $db->delete($limit);
        }
        
        return new DBDeleter($tthis, self::$model);

    }

    /**
     * Update data on a database table
     *
     * @return DBUpdater
     */
    static function update(array $fields) : DBUpdater {

        $tthis  = self::$tthis;
        $tthis->sql['OPERATION'] = " UPDATE ".$tthis->sql['BASE_TABLE']." SET ";

        $PARAMS = $tthis->sql['WHERE'] ? $tthis->sql['PARAMS'] : [];

        /** @var array $params */
        DBConstruct::bindedParams($fields, $params, $placeholders);

        $params = array_merge($params, $PARAMS);
        
        $sql  = $tthis->sql['OPERATION'] .= " ".$placeholders; 
        $sql .= $tthis->sql['WHERE'];


        if(($sql??'')){
            $sql = trim($sql, " ");
            $db  = self::$dbh;
            $db->query($sql, $params)->update();
        }
        
        return new DBUpdater($tthis, self::$model);

    }

    /**
     * Uses the one to many relationship to pull data of current user (User::tablename()) in 
     * another table. The user table in this case must have a primary id field
     *
     * @return DBMediators
     */
    static function ofUser(?int $userid = null, ?string $ForeignKey = null) : DBMediators {

        $userTB = strtolower(User::tableName());
        $userID = ($userid === null) ? User::id()->primary() : $userid;
        $modelTBS = $modelTB = self::$model::table();

        self::$tthis->sql['BASE_TABLE'] = "{$userTB}";
        self::$tthis->sql['FIELDS'][] = "*";
        /* always return model_id */
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
     * @return DBMediators
     */
    static function of(string $ownerTB, ?string $ForeignId = null, ?string $ForeignKey = null) : DBMediators {

        $modelTB = self::$model::table(); 

        self::$tthis->sql['BASE_TABLE'] = "{$ownerTB}";

        $UseForeignKey = $ForeignKey?? toSingular($ownerTB).'_id'; 
        
        $parent_to_child = " JOIN {$modelTB} ON {$ownerTB}.id = {$modelTB}.{$UseForeignKey} ";

        $Where = ($ForeignId)? " WHERE {$modelTB}.{$UseForeignKey} = ".$ForeignId : "";

        self::$tthis->sql['JOIN']  .= $parent_to_child;
        self::$tthis->sql['WHERE'] .= $Where;

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
     * @return DBMediators
     */
    public static function use(array $use){
        self::uses($use);
    }

    /**
     * Select fields through class for ambiguous fields
     *
     * @param array $use
     *  - format: [class => ['field' => 'customFieldName']]
     * @return DBMediators
     */
    private static function uses(array $use){
        
        $sql = [];
        
        foreach($use as $tableName => $field){
            if(strpos($tableName, '\\')!==false){
                $tableName = $tableName::table();
            }else{
                $tableName = strtolower($tableName);
            }
            array_map(function($value, $key) use(&$sql, $tableName){
                   $sql[] = "{$tableName}.{$key} AS '{$value}'";
            },$field, array_keys($field));
        }

        $use = (implode(", ", $sql));
        if($use) $use = ", ".$use;
        $tthis = self::$tthis;

        $tthis->sql['USES'] = $use;

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
     * Protect records before they are retrieved from database
     *
     * @return DBMediators
     */
    public function protect(string|array $data) : DBMediators{
        $this->protected = array_merge($this->protected, (array)$data);
        return $this;
    }

    /**
     * Sets the default for data obtained
     *
     * @param array $defaults
     * @return DBMediators
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
     * @return DBMediators
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
     * @return DBMediators
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

    public function sql(){
        return $this->query;
    }

    /**
     * Return SQL data information table
     *
     * @return array
     */
    public function info() : array {
        return [
            'QUERY' => $this->query,
            'PARAMS' => $this->sql['PARAMS'],
            'BASE_TABLE' => $this->sql['BASE_TABLE'],
            'FOREIGN_KEY' => $this->sql['FOREIGN_KEY'],
            'OWNER_KEY' => $this->sql['OWNER_KEY'],
            'RELATIONSHIP' => $this->sql['RELATIONSHIP'],
            'FIELDS' => $this->sql['FIELDS'],
            'DEFAULTS' => $this->sql['DEFAULTS'],
            'BY_RECENT' => $this->sql['BY_RECENT'],
            'ORDER' => $this->sql['ORDER'],
            'USES' => $this->sql['USES'],
        ];
    }

    /**
     * Return SQL error if any
     *
     * @return string|false
     */
    public function error() : string|false {
        return $this->DBError;
    }

}