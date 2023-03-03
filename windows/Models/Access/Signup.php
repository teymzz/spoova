<?php

namespace teymzz\spoova\windows\Models\Access;

use Form;
use teymzz\spoova\windows\Models\Access\AccessModel;

class Signup extends AccessModel {

    protected $firstname;
    protected $lastname;
    protected $user;
    protected $pass;
    protected $email;

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules(): array {

        return [
            'firstname' => [SELF::RULE_REQUIRED],
            'lastname'  => [SELF::RULE_REQUIRED],
            'email'     => [SELF::RULE_REQUIRED, SELF::RULE_UNIQUE],
            'user'      => [SELF::RULE_REQUIRED, SELF::RULE_UNIQUE],
            'pass'      => [SELF::RULE_REQUIRED],
        ];

    }

    public function isAuthenticated(): bool
    {
        
       return Form::isSaved(['password' => password_hash(Form::datakey('pass'), PASSWORD_DEFAULT)]);

    }


}