<?php

namespace spoova\mi\core\classes;

use Iterator;
use Reflection;
use ReflectionClass;
use ReflectionMethod;
use stdClass;


class Collection implements Iterator{ 

    private $data = [];

    /**
     * data keys
     *
     * @var array
     */
    private $datakeys = [];
    private $iterator = 0;
    private $callables = [];
    private static $protected = [];
    public $error;

    private static Collection $container;

    /**
     * Undocumented function
     *
     * @param mixed $data
     * @param object|null $class
     * @param boolean $callable add callables
     */
    public function __construct($data, object $class = null, $callable = true)
    { 
        $objectData = []; $data = (array) $data;
        foreach($data as $datakey => $datavalue){
            $objectData[$datakey] = is_array($datavalue) ? (object) $datavalue : $datavalue;
        }

        //convert array data to object format
        $data = $objectData;    

        $this->data = $data;
        $this->datakeys = is_array($data) ? array_keys($data) : [];

        $callables = [];

        if(gettype($data) != 'string'){
            if(!empty($data)) {
                if($class){
                    $classInstance = $class;
                    $class = new ReflectionClass($class);
                    if($callable){
                        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
                        $static  = $class->getMethods(ReflectionMethod::IS_STATIC);
                        foreach($methods as $method){
                            if(!in_array($method, $static)){
                                $callables[] = '->'.$method->name.'()';     
                            }else{       
                                $callables[] = '::'.$method->name.'()';    
                            }
                        }
                    }
                    $this->callables = $callables;
                } else {
                    $this->callables = []; 
                }
            } else {
                $this->callables = []; 
            }
        }else{
            $this->callables = [];
        }
        $this->iterator = 0;

        self::$container = $this;

        return $class;

    }

    public function data(){
        return $this->data;
    }

    public function rewind(): void {
        $this->iterator = 0;
    }

    # [ReturnTypeWillChange]
    public function current() {
        return $this->data[$this->datakeys[$this->iterator]];
    }

    # [ReturnTypeWillChange]
    public function key() {
        return $this->iterator;
    }

    public function next(): void {
        ++$this->iterator;
    }

    public function valid(): bool {
        if(isset($this->datakeys[$this->iterator])){
            return isset($this->data[$this->datakeys[$this->iterator]]);
        }
        return false;
    }

    
    /**
     * Protect all collected data having specified keys
     * 
     * @param $keys array of keys whose values must be protected
     */
    public static function protect(array $keys = []){
        $protected = self::$protected;
        self::$protected = array_merge($protected, $keys);
    }

    /**
     * Return protect Collection keys
     */
    public static function protected(){
            return self::$protected;
    }

    /**
     * @todo Unprotect protected collectibles data.
     * 
     * @notice This must be called before data is retrieved from database. Once a data 
     * is retrieved, it cannot be unprotected.
     */
    public static function unprotected(array $keys){

        foreach($keys as $key){  
            if(in_array($key, static::$protected)){
                static::$protected = array_delete(static::$protected, $key);
            }
        }

    }

    /**
     * Create a new collection list
     *
     * @param array $data
     * @return Collectibles
     */
    public static function list(array $data = []){
        return (new Collectibles($data))->protect(Collection::protected());
    }

    /**
     * Fetchs an index from data list
     *
     * @param integer|string $index
     * @param integer|string|array $value
     * 
     * @return bool|stdClass
     *      - A bool of false is returned if $index does not exist in the data list.
     *      - A stdClass object is returned if $index exists in data list and $value is not supplied.
     *      - If $value (string) is supplied and $value exist in $index data list, the relative value is returned, else, false is returned.
     *      - If $value (array) is supplied each array values is tested as sub index of $index datalist. If subindex does not exist in $index, a false value is assigned to the index in array data returned
     */
    public function get(int|string $index, string|array $value = null): stdClass|array|bool|string
    {
        if($value){
            if(is_array($value)){
                $valueFlip = array_flip($value);
 
                return array_map(function($val) use($index, $value) {
                    $key = $value[$val];
                    if(isset($this->data[$index])){
                       return  $this->data[$index]->{$key} ?? false;
                    }else{
                        return false;
                    }
                }, $valueFlip);
            }elseif($value && isset($this->data[$index])){
                    return $this->data[$index]->{$value} ?? false;
            }
        }elseif(is_array($value)){
            if(isset($this->data[$index])){
                $data = [];
                foreach($this->data[$index] as $key => $value){
                    $data[$key] = $value;
                }
                return $data;
            }

        }
        return ($this->data[$index] ?? false);
    }

    /**
     * Return any database error encountered
     *
     * @return bool|string
     */
    public function error() : bool|string|null {
       return property_exists($this, 'error')? $this->error : false;
    }

}