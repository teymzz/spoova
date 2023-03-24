<?php

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Collection;

class ModelOptimizer{

    private static $strict = false;

    function __construct($strict = true)
    {
        self::$strict  = $strict;
    }

    /**
     * Optimize collected data for get() method
     *
     * @param Collectibles|Collection $data
     * @return ModelOptimizer|Collection
     */
    static function optimize(Collectibles|Collection $data, bool $strict = true): ModelOptimizer|Collection
    {
        if(!$data->error()){
            return $data;
        }else{
            return new ModelOptimizer($strict);
        }
    }

    function get(int|string $index, int|string|array $value = null) : bool|array {
        if($value){

            if(self::$strict) return false;

            if(is_array($value)){
                $valueFlip = array_flip($value);
 
                return array_map(function($val){
                    return false;
                }, $valueFlip);
            }else{
                return false;
            }
        }elseif(is_array($value)){
            if(self::$strict) return false;
            return [];
        }
        return false;
    }

}