<?php

namespace spoova\core\classes;

class DBConstruct {

    private function __construct(){}

    /**
     * Construct database table operation fields from array or string
     *
     * @param array|string $field
     * @return string
     */
    public static function Fields(array|string $field, bool $trailingComma = false) : string {

        if(is_string($field)) $field = trim($field, ' ');

        if(!empty($field)) {
            $field = (array) $field;
    
            $field = "".implode(", ", $field)."";
        }else{
            return '*';
        }
        //$field = str_replace("'*',", "*")
        if($field && $trailingComma){
            return $field.',';
        }

        return $field;

    }


}