<?php

namespace spoova\core\classes;

use DBStatus;
use User;

abstract class ModelOperators {

    
    protected static $dbh;
    protected static $tthis = null;
    protected static Model $model;
    protected static $primaryTable;
    protected static $secondaryTable;
    protected $sql = "SELECT %s FROM"; 
    protected static $sqlWhere = '';
    protected static $sqlParams = [];
    protected static $called = [];

    final public function __construct(?Model $Model = null)
    {

        $this->initialized = 1;

        // new DataModel(new Model)
        // $Posts = db(new Posts);
        // $Posts::ofUser;
        // Posts::ofUser()->read();
        // $Posts = db(new Posts)->onUser()->read()
        // collect(new Posts)->ofUser()->where("date > '20:10:22'")















        //static::$tthis = 'hy';
        // static::$model = $Model?? (new static());
        // Posts::ofUser()->where();

        // $dbh = User::auth()->dbh();

        // if($dbh) {
        //     static::$dbh = $dbh;
        //     $tables = $dbh->tables();
        //     $primaryTable = strtolower($Model::tableName());
        //     if(!in_array($primaryTable, $tables)){
        //         return EInfo::view("Table \"{$primaryTable}\" does not exist in database");
        //     }
        //     static::$primaryTable = $primaryTable;
        //     $this->sql .= " {$primaryTable} ";
        // }else {
        //     return EInfo::view(DBStatus::err());
        // }

        // if(!static::$tthis){
        //     static::$tthis = new self();
        // }

    }

    protected static function loadOperators() {
        static::$primaryTable;
        static::$secondaryTable;
        static::$sql ="SELECT %s FROM"; 
        static::$sqlWhere = '';
        static::$sqlParams = [];
        static::$called = []; 

    }

    public static function ofUser($ForeignKey = '') : ModelOperators {

        
        // if(!static::$tthis) {
        //     $tthis = new static(new (get_called_class()));
        // } else {
        //     $tthis = static::$tthis = (static::$tthis);
        // }
        $tthis = self::$tthis;

        vdump($tthis);

        $primaryTable = $tthis::$primaryTable;
        $userID       = User::id()->primary();
        $userTable    = User::tableName();
        $FKey         = $ForeignKey ?: 'userid';

        if($userID == ''){
            return EInfo::view('No primary id found for user');
        }

        if($primaryTable ==  $userTable){
            return EInfo::view('primary model\'s tableName cannot be the same as secondary Model\'s tableName');
        }

        $tthis::$sqlWhere .= "JOIN {$userTable} ON {$primaryTable}.{$FKey} = {$userTable}.id WHERE {$userTable}.id = $userID";
        $tthis::$called[] = 'WHERE';
        return $tthis;

    }

    public function of() {

    }

    public static function where(string $string, array $params = []) {

        $called = static::$called;
        $where = (!in_array('WHERE', $called))? ' WHERE ' : ' AND ';
        static::$sqlWhere .=  $where.$string;
        static::$sqlParams = array_merge(static::$sqlParams, $params);
        return (static::$tthis);

    }

    public static function read(array|string $fields = '', $limit = []) : DataObject {

        $fields = DBConstruct::Fields($fields);

        $sql = sprintf($this->sql, $fields);

        $sql .= static::$sqlWhere;
        
        $dbh = static::$dbh;

        vdump($dbh);

        if($dbh) {
            $dbh->query($sql, static::$sqlParams)->read(...$limit);
            return new DataObject($dbh->results(), static::$tthis);
        }
        return new DataObject([]);
    }

    /**
     * Undocumented function
     *
     * @param string $tableName
     * @param string|Model $join optional [LEFT|RIGHT|OUTER|INNER]
     * @return DataModel
     */
    public static function on(string|Model $tableName, string $join = "JOIN"){

        $joins = ['LEFT','RIGHT', 'OUTER', 'INNER', 'JOIN'];

    }

}