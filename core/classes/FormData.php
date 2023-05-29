<?php

/**
 * This class manages form request data for window routes
 */
class FormData extends Window{

    public const action = 'form-data';

    function __construct() {

        if(!isset($_SERVER['HTTP_REFERER'])){
            self::close();
        } 
        
        self::pushFormData();
    }

}