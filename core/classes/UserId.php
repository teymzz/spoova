<?php

namespace spoova\mi\core\classes;

use DBStatus;
use Session;
use User;

final class UserId extends User{

    /** prevent parent call */
    public function __construct(){}

    /**
     * Return user id from current session id
     *
     * @return string
     */
    public function __toString(){
        return $this->main();
    }

    /**
     * Return primary id of a user field in database 
     * This function can only be used if user primary key field name is set as id
     *
     * @return string|bool(false)
     */
    public function primary() {
        
        $data = self::data();

        $dbh = User::auth()->dbh();

        if($dbh){

            $tables = $dbh->tables($dbh->currentDB(), User::tableName());

            if(!in_array('id', $tables)){            
                
                if(!DBStatus::err()){
                    return EInfo::view('no primary key "id" column found in database table {'.User::tableName().'} ');
                }

            }

        }


        return $data['id'] ?? '';

    }

    public function main() {
        if(isset($_SESSION[self::$sessionName])){
            if(empty($_SESSION[self::$sessionName]['userid'])) {
               self::logout(false);
               return '';
            }else{

                if(Session::secure()){
                    if(!User::hasUserData()){ 
                        self::authenticate_session($_SESSION[self::$sessionName]['userid']); 
                    }
                    if(array_key_exists(self::$sessionName, $_SESSION)){
                        return ($_SESSION[self::$sessionName]['userid'])?: '';  
                    }
                }
            }
        }
        return '';        
    }

}
