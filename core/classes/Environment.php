<?php 

namespace spoova\mi\core\classes;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class Environment {

    static function path(string $path){
        Filemanager::loadenv($path, env: true);
    }

    /**
     * Return environment key's value or all environment values.
     *
     * @param string|array|null|null $key
     *   - string: key whose value is to be fetched
     *   - array: array of keys whose values are to be fetched 
     *   - null: all keys and value pairs are fetched
     * @return string|array|false
     *   - string: returned as corresponding value of defined key
     *   - array: returned as corresponding key and value pairs of defined keys fetched
     *   - false: returned as error
     */
    static function keys(string|array|null $key = null) : string|array|false  {
        if(isset($key)) {
            if(is_array($key)){
                $keys = [];
                foreach($key as $k){
                    $keys[$key] = getenv($k);
                }
                return $keys;
            }elseif(is_string($key)){
                return getenv($key);
            }
        }
        return getenv();
    }


}