<?php

namespace spoova\mi\windows\Models\Access;

use Form;
use spoova\mi\windows\Models\Access\AccessModel;
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
            'user' => [SELF::RULE_REQUIRED, SELF::RULE_EMAIL],
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
        return User::config('USER_TABLE');

    }

    /**
     * input fields with relative database column name key pairs 
     *
     * @return string
     */
    public static function mapform(): array {

        return [
            'user' => 'email',
            'pass' => 'password'
        ];

    }

    public function isAuthenticated(): bool
    {

        if($db = (User::auth())->dbh()) {

            $data = Form::data();
    
            $params =  [$data['email']];
    
            $db->query('select * from '.User::tableName().' where email = ?', $params)->read();
    
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
