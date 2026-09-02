<?php 

namespace spoova\mi\core\classes\Bundle\Arr;

use stdClass;
use ErrorException;
use spoova\mi\core\classes\ObjectList;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Bundle\Arr\ArrBin;

/**
 * (Spoova 3.0) <br/>
 * This class is an helper class for modifying arrays through some static helper
 * methods
 * @todo Convert array bin's ghost method to class methods. 
 */
class Arr {

    /** This class cannot be instantiated. Use static helper methods instead */
    private function __construct(){}

    /**
     * Converts an array to ObjectList
     *
     * @param array $value
     * @return ObjectList
     * @uses stdClass 
     */
    static function objectList(array $value) : ObjectList {

       return self::make_objectList($value);

    }

    /**
     * Alias of {@see Arr::objectList()}
     *
     * @param array $value
     * @return ObjectList
     */
    static function to_objectList(array $value) : ObjectList {

       return self::objectList($value);

    }

    /**
     * Converts an array to stdClass object
     *
     * @param array $value
     * @return stdClass
     */
    static function to_stdClass(array $value) : stdClass {

       return self::make_stdclass($value);

    }
    
    /**
     * Checks if an array exists inside another array.
     *
     * @param array $value array value to be checked
     * 
     * @return boolean returns ```TRUE``` or ```FALSE``` dependending on if array exist or not respectively.
     */
    static function inside(array $value) : bool {
        foreach ($value as $val) {
            if(is_array($val)) return true;
        }
        return false;
    }

    /**
     * Provides a list of GhostFunctions for testing an array
     *
     * @param array $array test array
     * @return GhostFunction|ArrBin
     *  - ```hasKeys(array|string $keys)```: Checks if all specified keys exists as keys of test array
     *  - ```hasValues(array|string $keys, bool $strict = false)```: Checks if specified values exists as a key of test array
     *  - ```hasArray(bool|int $unit = FALSE)```: Checks if test array contains at least one data type of array
     *  - ```hasObject(bool|int $unit = FALSE)```: Checks if test array contains at least one data type of object
     *  - ```hasFloat(bool|int $unit = FALSE)```: Checks if test array contains at least one data type of float
     *  - ```hasInteger(bool|int $unit = FALSE)```: Checks if test array contains at least one data type of integer
     *  - ```hasNumeric(bool|int $unit = FALSE)```: Checks if test array contains a numerical string or number
     *  - ```hasBool(bool|int $unit = FALSE)```: Checks if test array contains at least one data type of bool
     *  ##### where: $unit :
     *  - ```TRUE``` checks if ONLY the specified data type exists in the test array values
     *  - ```FALSE``` checks if the specified data type exists in the test array values
     *  - ```int``` checks if the specified data type exists in the test array values in the total number of times specified
     *  ##### where: $strict :
     *  - ```TRUE``` sets strict data type checking where required
     *  - ```FALSE``` sets loose data type checking where required
     */
    static function bin(array $array) : GhostFunction|ArrBin {
        $data = []; 
        $data['keys'] = array_keys($array);
        $data['values'] = array_values($array);

        $data['typecount'] = [];
        $data['types'] = [];

        foreach ($array as $key => $val) {
            $type = gettype($val);
            $data['types'][] = $type;
            if(!array_key_exists($type,$data['typecount'])){
                $data['typecount'][$type] = 0;
            }
            if(is_numeric($val)){
                if(!in_array('numeric', $data['types'])) $data['types'][] = 'numeric';
                $data['typecount']['numeric'] = array_key_exists('numeric',$data['typecount'])? $data['typecount']['numeric'] + 1 : 1;
            }
            $data['typecount'][$type]++;
            if($type === 'object') $data['types'][] = $val::class; 
        }

        if(isset($data['types'])){
            $data['types'] = array_unique($data['types']);
        }

        $dataTypes = [
            'hasKeys','hasValues','hasArray',
            'hasObject','hasFloat','hasInteger',
            'hasBool','hasNumeric','hasString'
        ];
        $GhostFunction = new GhostFunction($dataTypes, "Arr::bin");
        
        $GhostFunction->hasKeys(function(array|string $keys) use($data) : bool {
            $haskeys = false; $keys = (array) $keys;
            foreach($keys as $key){
                $is_string = is_string($key) || is_numeric($key);
                if($is_string){
                    $haskeys = in_array($key, $data['keys']);
                    if(!$haskeys) break;
                }else{
                    throw new ErrorException('array values of "hasKeys" must be of data type string or numerical');
                }
            }
            return $haskeys;
        });

        $GhostFunction->hasValues(function(array|string $values, int $strict = 1) use($data) : bool {
            $hasvalues = false;
            $array = $data['values'];
            $values = (array) $values; 
            $is_strict = (in_array('object',$data['types']) && (count($data['types'])>1));
            
            if($is_strict && !$strict){
                // throw new ErrorException('mixing objects with other data types on "bin()" requires setting the second argument of "hasValues()" as TRUE');
            }

            $tempArray = $array;
            // $tempArray = self::unset($tempArray, true);

            foreach($values as $value){

                if($strict === 0 || $strict === 1 || $strict === 2){
                    $tempArr = array_filter($tempArray, function($tval)use($value, $strict){

                        if($strict === 0){
                            
                            if( (is_object($value) && !is_object($tval) && !is_bool($tval)) || (is_object($tval) && !is_object($value) && !is_bool($value)) ){
                                return $value === $tval;
                            }else{
                                //use weak comparison for other data types.
                                return $value == $tval;
                            }

                        }else if($strict === 1){
                            if((is_bool($value) || is_bool($tval))){
                                return $value === $tval; //strong comparison between booleans and other data types
                            }elseif( (is_object($value) || is_object($tval)) && !(is_object($value) && is_object($tval)) ){
                                return $value === $tval; //strong comparison between objects & other data types (error fix)
                            }else{
                                return $value == $tval; //weak comparison between other data types
                            }
                        } else if($strict === 2){
                            if(is_object($value) || is_object($tval) || is_bool($value) || is_bool($tval)){
                                return $value === $tval; // use strict comparison for booleans and objects only
                            }else{
                                return $value = $tval;
                            }
                        }

                    });
                    $hasvalues = $tempArr? true : false;
                    if(!$tempArr) break;
                }else{
                    //strict data comparison for all data types
                    $hasvalues = in_array($value, $array, true);
                    if(!$hasvalues) break;
                }
            }
            return $hasvalues;
        });

        $GhostFunction->hasArray(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test = (in_array('array', $data['types']) && (($data['typecount']['array']??'') === $counter));
                    return ($count === true)? ($data['typecount']['array']??0) : $test;
                }
            }
            return in_array('array', $data['types']);
        });

        $GhostFunction->hasFloat(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test = (in_array('double', $data['types']) && (($data['typecount']['double']??'') === $counter));
                    return ($count === true)? ($data['typecount']['double']??0) : $test;
                }
            }
            return in_array('double', $data['types']);
        });

        $GhostFunction->hasInteger(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test = (in_array('integer', $data['types']) && (($data['typecount']['integer']??'') === $counter));
                    return ($count === true)? ($data['typecount']['integer']??0) : $test;
                }
            }
            return in_array('integer', $data['types']);
        });

        $GhostFunction->hasNumeric(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test = (in_array('numeric', $data['types']) && (($data['typecount']['numeric']??'') === $counter));
                    return ($count === true)? ($data['typecount']['numeric']??0) : $test;
                }
            }
            return in_array('numeric', $data['types']);
        });

        $GhostFunction->hasString(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test =  (in_array('string', $data['types']) && (($data['typecount']['string']??'') === $counter));
                    return ($count === true)? ($data['typecount']['string']??0) : $test;
                }
            }
            return in_array('string', $data['types']);
        });

        $GhostFunction->hasBool(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test = (in_array('boolean', $data['types']) && (($data['typecount']['boolean']??'') === $counter));
                    return ($count === true)? ($data['typecount']['boolean']??0) : $test;
                }
            }
            return in_array('boolean', $data['types']);
        });

        $GhostFunction->hasObject(function(int|bool $count = false) use($data) : int|bool {
            if(func_num_args() > 0) {
                $counter = $count === true ? 1 : $count; 
                if(is_int($counter)){
                    $test = (in_array('object', $data['types']) && (($data['typecount']['object']??'') === $counter));
                    return ($count === true)? ($data['typecount']['object']??0) : $test;
                }
            }
            return in_array('object', $data['types']);
        });

        return $GhostFunction;
    }
    
    /**
     * Deletes the first index of a value from an array
     * 
     * @param array $array
     * @param mixed $value
     * @param int $strict optional [0|1|2]
     *  - ```0```: data type strictness is set as false
     *  - ```1```: applies smart data type filtering for cases where booleans are suppled as value. 
     *  - ```2```: data type strictness is set as true
     *  Visit documentation of [Arr::delete](https://spoova.com/docs/helpers/classes/arr/delete) to learn more.
     * @return array
     */
    static function delete(array $array, mixed $value, int $strict = 1){  
        if($strict === 2 || (is_bool($strict) && ($strict===1))){
            // strict data types
            $val = array_search($value, $array, true);
            unset($array[$val]);
        }elseif(($strict === 0) || ($strict === 1)){
            // loose data types
            if($strict === 1){
                //remove all indices of true or false before comparison
                $tempArray = self::unset($array, [true, false], 2);
                $val = array_search($value, $tempArray);
                if($val !== false) unset($array[$val]);
            } else {
                $val = array_search($value, $array);
                if($val !== false) unset($array[$val]);
            }

        }
        return $array;
    }

    
    /**
     * Removes all keys having a declared value from an array
     *  - Uses strict data type
     * @param array  $array
     * @param string $value
     * @param bool $series
     *  - If set as true and $value is array, $value will be assumed
     *    to be a container of values expected to be removed. This is useful when 
     *    removing multiple values from $array
     * @param int $strict optional [0|1|2]
     *  - ```0```: data type strictness is set as false
     *  - ```1```: applies smart data type filtering for cases where booleans are suppled as value. 
     *  - ```2```: data type strictness is set as true
     *  Visit documentation of [Arr::unset](https://spoova.com/docs/helpers/classes/arr/unset) to learn more.
     * @return array
     */
    static function unset(array $array, $value, bool $series = false, int $strict = 1) : array {
       
        if(is_array($value) && $series){
            foreach ($array as $key => $val) {
                if($strict === 0){
                    if(in_array($val, $value)){ 
                        unset($array[$key]);
                    }
                }elseif($strict === 1){
                    if(is_bool($val)){
                        if(in_array($val, $value, true)){
                            unset($array[$key]);
                        }
                    }else{
                        //remove all indices of true or false before comparison
                        $tempValue = self::unset($value, [true, false], 2);

                        //apply loose comparison for other non-booleans
                        if(in_array($val, $tempValue)){
                            unset($array[$key]);
                        }
                    }
                }elseif($strict === 2){
                    if(in_array($val, $value, true)){
                        unset($array[$key]);
                    }
                }
            }
        }else{
            foreach ($array as $key => $val) {
                if($strict === 0){
                    if($val == $value){
                        unset($array[$key]);
                    }
                }elseif($strict === 1){
                    if(is_bool($value)){
                        if($val === $value){
                            unset($array[$key]);
                        }
                    }else{
                        if($val == $value){
                            unset($array[$key]);
                        }
                    }
                }elseif($strict === 2){
                    if($val === $value){
                        unset($array[$key]);
                    }
                }
            }    
        }
        return $array;  
    }

    /**
     * Trims an entire array by reference
     *
     * @param String[] $array referenced array
     * @param boolean $extras TRUE removes any extra spaces in between texts
     * @return array
     */
    static function trim(array &$array, bool $extras = false): array {
        $nArray = array();
        foreach($array as $data => &$value){
            if(is_array($value)){
                $ndata = $value;
                self::trim($ndata, $extras);
            }else{
                if($extras){
                    $ndata = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $value);
                }else{
                    $ndata = trim($value);
                }
            }
            $nArray[$data] = $ndata;
        }
        $array = $nArray;
        return $array;    
    }

    
    /**
     * Shorthand method for {@see json_encode()}. <p> 
     * Aside from the first argument data type as array, all other parameters 
     * are relative to the argument required by the {@see json_encode()} inbuilt PHP function.</p>
     *
     * @return string|false
     */
    function toJson(array $array, int $flags = 0, int $depth = 512) : string|false {
        return json_encode(...func_get_args());
    }

    
    /**
     * Shorthand method for converting json to array.
     *  - All std are converted to array by default
     * 
     * @uses \json_decode()
     * @return object|array
     */
    function fromJson(string $json, bool $associative = true, int $depth = 512, int $flags = 0){
        if(func_num_args() > 2){
            $args = func_get_args();
        }else{
            $args = [$json, $associative];
        }
        return json_decode(...$args);
    }

    /**
     * Converts an array data type to an ObjectList or returns the value defined if it is not an array
     *
     * @param mixed $array
     * @uses ObjectList
     * @return mixed
     */
    private static function make_objectList(mixed $array) : mixed {

        if(is_array($array)){
            $newarray = new ObjectList();
            foreach($array as $array_keys => $array_vals){
              $newarray->$array_keys = array_object($array_vals);
            }    
        }else{
            $newarray = $array;
        }
        
        return $newarray;

    }

    /**
     * Converts an array data type to a stdClass object or returns the value defined if it is not an array
     *
     * @param mixed $array
     * @uses \stdClass
     * @return mixed
     */
    private static function make_stdclass($array) : mixed {

        if(is_array($array)){
            $newarray = new stdClass();
            foreach($array as $array_keys => $array_vals){
              $newarray->$array_keys = array_object($array_vals);
            }    
          }else{
            $newarray = $array;
          }
        
          return $newarray;

    }

}