<?php

namespace teymzz\spoova\core\classes;

use User;

class UserDB {

    private $databaseTable;
    private string $where = '';
    private array $bindparams = [];

    /**
     * set the database table name
     *
     * @param string $name database table name
     */
    public function __construct(string $name){
        $this->databaseTable = $name;
        $this->where = '';
        $this->bindparams = [];
        return $this;
    }

    public function where($where, array $bindparams) {
        $this->where = " and ".$where;
        $this->bindparams = $bindparams;
        return $this;
    }   

    /**
     * Returns the data of the currently logged in user
     *
     * @param array|string $arg1 
     *      -When argument supplied is one and $arg1 is integer, sets data limit
     *      -When argument supplied is string or array sets field to be returned
     * @param array|integer $limit limits of data to be returned
     * @return array|bool
     */
    public function read($fields = [], $limits = []){
        if(empty($fields)){

            if(!is_array($fields) && !is_bool($fields)){
                $fields = (array) $fields;
            }

            array_unshift($fields, '*');

        }elseif(is_string($fields)){
            $fields = (array) $fields;
        }
        $fields = implode(",", $fields);

        $databaseTable = $this->databaseTable;

        $userquery = $this->userquery()." ".$this->where;

        $query = "SELECT {$fields} FROM {$databaseTable} WHERE {$userquery}";

        array_unshift($this->bindparams, User::autoID());
        
        $dbh = User::auth()->dbh();

        return $dbh?->query($query, $this->bindparams)->read(...$limits);
    }

    public function delete(){

    }

    public function insert(){

    }

    public function sort() {

    }

    private function userquery(){
        if(($this->databaseTable === User::tableName()) || ($this->databaseTable === '')){
            return "id = ?";
        }
        return "userid = ?";
    }

}