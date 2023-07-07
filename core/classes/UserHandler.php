<?php

namespace spoova\mi\core\classes;

use User;

class UserHandler {

    public $databaseTable;


    public function __construct($name){
        $this->databaseTable = $name;
        return $this;
    }

    public function where() {

    }

    /**
     * Selects some specific fields from database.
     *
     * @param array|string $arg1 
     *      -When argument supplied is one and $arg1 is integer, sets data limit
     *      -When argument supplied is string or array sets field to be returned
     * @param array|integer $limit limits of data to be returned
     * @return void
     */
    public function data($fields, $limits = []){
        if(empty($fields)){

            if(!is_array($fields) && !is_bool($fields)){
                $fields = (array) $fields;
            }

            array_unshift($fields, '*');

        }elseif(is_string($fields)){
            $fields = (array) $fields;
        }
        $fields = implode(',', $fields);

        $query = "select ".$fields." from ".$this->databaseTable;
        
        $dbh = User::auth()->dbh();
        $dbh->query($query)->read(...$limits);

        return $dbh->results();

    }

    public function delete(){

    }

    public function insert(){

    }

    public function sort() {

    }

}