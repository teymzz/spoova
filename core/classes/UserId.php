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
     * This function can only be used if user primary key field name is set as "id"
     *
     * @return string|false 
     *  - FALSE only if database error occurs
     *  - String (empty or non-empty) if no error occurs.
     */
    public function primary(): string|false {
        
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

        if(Session::has(SELF::$sessionName, 'userid')){

            $userid = Session::value(SELF::$sessionName, 'userid');

            /* Session::secure() adds a database re-check of the stored id, it does not
               decide whether the id is readable. Returning inside this test meant that
               every project that had not called secure() got an empty user id. */
            if(Session::secure()){
                if(!User::hasUserData()){
                   self::authenticate_session($userid);
                }
            }

            return (string) $userid;

        }

        return '';

    }

}
