<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\DB\DBCollectors;

class ModelOptimizer{

    private static $strict = false;

    function __construct($strict = true)
    {
        self::$strict  = $strict;
    }

    /**
     * Optimize collected data for get() method
     *
     * @param DBCollectors|Collection $data
     * @param boolean $strict uses strict optimization.
     * @return ModelOptimizer|Collection
     */
    static function optimize(DBCollectors|Collection $data, bool $strict = true): ModelOptimizer|Collection
    {
        if(!$data->error()){
            return $data;
        }else{
            return new ModelOptimizer($strict);
        }
    }

    /**
     * Undocumented function
     *
     * @param integer|string $index
     * @param integer|string|array|null|null $value
     * @return boolean|array
     */
    // function get(int|string $index, int|string|array|null $value = null) : bool|array {
    //     if($value){

    //         if(self::$strict) return false;

    //         if(is_array($value)){
    //             $valueFlip = array_flip($value);
 
    //             return array_map(function($val){
    //                 return false;
    //             }, $valueFlip);
    //         }else{
    //             return false;
    //         }
    //     }elseif(is_array($value)){
    //         if(self::$strict) return false;
    //         return [];
    //     }
    //     return false;
    // }

}