<?php

namespace spoova\windows\Models\Access;

use Form;
use spoova\core\classes\Model;
use spoova\core\classes\Request;
use User;

class AccessModel extends Model {


    static function onSubmit($arg = ''){

        $Request = new Request; 

        if($Request->isPost()) { 

            if($arg == 'logout'){
                if($Request->has('logout') && User::id()){

                    User::logout();

                }                
            } else if(($Request->has('login') || $Request->has('signup'))) { 

                if($Request->has('login')) {
                    $Model = Login::class; 
                    $userid = 'username';
                }elseif($Request->has('signup')){
                    $Model = Signup::class;
                    $userid = 'email';
                } 
    
                if($Model??''){
    
                    Form::model(new $Model);
                    Form::loadData($Request->data());

                    if(Form::isAuthenticated()) {
                        User::login(['userid' => Form::datakey($userid)], 'home');   
                    }
    
                }

            }

        }         

    }
    
    /**
     * input fields with relative database column name key pairs 
     *
     * @return string
     */
    public static function mapform(): array {

        return [
            'pass' => 'password',
            'user' => 'username'
        ];

    }

    //AtV3Tjmi4YmpJFX9aSsFAv6GWMsz2yyPua4aJPhTE3pR
    public function rules(): array { return []; }

    public static function tableName(): string {

        return 'users';
        
    }

}