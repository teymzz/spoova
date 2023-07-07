<?php

namespace spoova\mi\windows\Models\Access;

use Form;
use spoova\mi\windows\Models\Access\AccessModel;

class Signup extends AccessModel {

    protected $firstname;
    protected $lastname;
    protected $user;
    protected $pass;

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules(): array {

        return [
            'firstname' => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2],
            'lastname'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2],
            'user'      => [SELF::RULE_REQUIRED, SELF::RULE_EMAIL, SELF::RULE_UNIQUE],
            'pass'      => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 6],
        ];

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
        
       return Form::isSaved(['password' => password_hash(Form::datakey('password'), PASSWORD_DEFAULT)]);

    }


}