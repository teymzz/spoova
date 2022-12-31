<?php

namespace spoova\core\classes;

use User;

/**
 * This class is only used for handling UserDBRelatives::Where()
 * queries
 */
class UserDBWhere {

    private $dbh;
    private static string $databaseTable;
    private static string $sqlJOIN;
    private string $sqlWhere = '';
    private string $order = '';
    private static array $params = [];
    private $table; 

    /**
     * This class can only by instantiated with a token
     *
     * @param [type] $token
     * @param string $sqlWhere
     * @param array $params
     */
    function __construct(UserDBRelatives $class, $token, string $sqlWhere = '', array $params = [])
    {

        Posts::read(1);

        Posts::where('user = ?')->read(1);

        if($class->classID() !== $token){
            return EInfo::view('class UserDBWhere can only be called from a similar instance of UserDBRelatives');
        }
        
        $this->table = basename(to_frontslash(get_class($class)));
        $this->{$this->table} = new DataObjectContainer([]);
        $this->dbh = User::auth()->dbh();
        
    }

    public function order(string $field, $order = "ASC"){
        $this->order = "ORDER BY {$field} {$order}";
    }

    public function update(int $limit = null) : bool {


        if($db = $this->dbh) {

            $sql = "DELETE FROM {self::table()} {$this->sqlWhere}";
            $db->query($sql, self::$params)->delete();
            return $db->results();

            $db->query($this->sqlWhere, self::$params)->update($limit);
            SETTER::CLOSE();
            return $db->results();

        }
    }

    public function delete() : bool {

        if($db = $this->dbh) {

            $sql = "DELETE FROM {self::table()} {$this->sqlWhere} {$this->order}";
            SETTER::CLOSE();
            return $db->query($sql, self::$params)->delete();
            
        }

        return false;
    }

    /**
     * Read data from database
     *
     * @param array $fields
     * @param array $limit
     * @return array
     */
    public function read($fields = [], array|int $limit = []) : array {

        $className = $this->table;

        unset($this->className);

        // $db = User::auth()->dbh();

        // if($db) {

        //     $fields = DBConstruct::Fields($fields);

        //     //** VALUES THAT MUST BE DECLARED */
        //     $DBTABLE = SETTER::GET('DBTABLE');

        //     //** VALUES THAT MAY BE DECLARED */
        //     $DBJOIN  = GET('DBJOIN');

        //     if(is_int($limit)) $limit = (array) $limit;
        //     $sql = "SELECT {$fields} FROM {$DBTABLE} {$DBJOIN} {$this->sqlWhere} {$this->order}";

        //     print $sql;
        //     //$auth->query($sql, self::$params)->read(...$limit);
        //     SETTER::CLOSE();
        //     return $db->results();
        // }

        return [$className => ($this->$className = new DataObjectContainer(['1234']))];

    }

    // public static function TABLE(string $tableName = ''){
    //     if(func_num_args() == 0) return self::$databaseTable;
    //     self::$databaseTable = $tableName;
    // }

    // public static function JOIN(string $sqlJOIN, array $params = []){


    //     $oldParams = array_values(self::$params);
    //     $newParams = array_values($params);

    //     self::$params = array_merge($newParams, $oldParams);
    //     self::$sqlJOIN= "JOIN {$sqlJOIN}";

    // }

    // private function getJoin() {
    //     $join = GET('JOIN');
    //     return self::$sqlJOIN;
    // }


}