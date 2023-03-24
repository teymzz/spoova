<?php

namespace spoova\mi\core\classes\DB;

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

        if($field && $trailingComma){
            return $field.',';
        }

        return $field;

    }

    /**
     * Build a binded parameter structure from an array format
     *
     * @param array $fields array of field name and new value pairs
     * @param array $params referenced binded parameters
     * @param string $placeholder referenced placeholder structure
     * @return void
     */
    static function bindedParams(array $fields, &$params = [], &$placeholder = ''){

        if($fields){
            $placeholder = implode("= ?, ", array_keys($fields))." = ?";
            
            $params = array_values($fields);
        }

    }


}