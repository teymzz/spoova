<?php

namespace spoova\core\classes;

/* 
This file contains spoova special directives
for handling template engines 
*/
class Bolt {

    /**
     * handle all template requests
     *
     * @return void
     */
    static function request($request_name, $reqest_key) {

        if(isset(${'_'.$request_name})){
            return (${'_'.$request_name}[$reqest_key])?? false;
        }
        return false;

    }

}