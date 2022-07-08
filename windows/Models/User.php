<?php

namespace spoova\windows\Models;

use spoova\core\classes\Model;

class User extends Model {

    public function __construct(){

        //your code here...

    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules(): array {

        return [];

    }

    /**
     * set table name where data is inserted
     *
     * @return string
     */
    public function tablename(): string {

        //default table name
        return \User::config('USER_TABLE');

    }


}