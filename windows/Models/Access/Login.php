<?php

namespace spoova\windows\Models\Access;

use Form;
use spoova\core\classes\Model;
use spoova\core\classes\Request;
use spoova\windows\Models\Access\AccessModel;
use User;

class Login extends AccessModel     {
    
    protected $user;
    protected $pass;

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules(): array {

        return [
            'user' => [SELF::RULE_REQUIRED],
            'pass' => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2]
        ];

    }

    /**
     * set table name where data is inserted
     *
     * @return string
     */
    public static function tablename(): string {

        //default table name
        return \User::config('USER_TABLE');

    }

    /**
     * input fields with relative database column name key pairs 
     *
     * @return string
     */
    public static function mapform(): array {

        return [
            'user' => 'username',
            'pass' => 'password'
        ];

    }

    public function isAuthenticated(): bool
    {

        if($db = (User::auth())->dbh() ) {

            $data = Form::Data();
    
            $params =  [$data['username'], $data['username']];
    
            $db->query('select * from '.User::tableName().' where username = ? or email = ?', $params)->read();
    
            if($db->results()){
                return true;
            }
    
            if(!$db->error()) Form::setError('username or password mismatch');

        } else {

            Form::setError('database connection failed');

        }

        
        return false;

    }

}
