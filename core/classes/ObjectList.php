<?php 

namespace spoova\mi\core\classes;

use stdClass;
use spoova\mi\core\classes\Bundle\Arr\Arr;

/**
 * Converts array to object format
 * @uses Arr::objectList()
 */
class ObjectList extends stdClass {

    /**
     * Returns a key in the object list instance only 
     * if the key exists as a dynamic property of the ObjectList item. 
     *
     * @param string|int|float|bool $key
     * @return void
     */
    function get(string|int|float|bool $key){
        return $this->$key;
    }

    /**
     * Converts array to objectList 
     *
     * @param array $data
     * @return ObjectList
     */
    static function data(array $data) : ObjectList{

        return Arr::objectList($data);

    }

}