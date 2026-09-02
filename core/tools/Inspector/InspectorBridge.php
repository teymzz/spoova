<?php 

namespace spoova\mi\core\tools\Inspector;

class InspectorBridge {

    protected static $keyLen;

    static function keyLen(?int $len = null){
        if(func_num_args() > 0) self::$keyLen = $len;
        return static::$keyLen;
    }

}