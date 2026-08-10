<?php

namespace spoova\mi\core\classes;

use Iterator;
use stdClass;
use ReflectionClass;
use ReflectionMethod;
use spoova\mi\core\classes\Record;

/**
 * This is a storage class is intended for iterating over an array record list
 */
class Collection implements Iterator{ 

    private $data = [];
    private $dataset = [];

    /**
     * data keys
     *
     * @var array
     */
    private $datakeys = [];
    private $iterator = 0;
    private $callables = [];
    private $protected = [];
    private $error = false;

    private static Collection $container;

    /**
     * Instance of the Collection class
     *
     * @param mixed $data
     * @param object|null $class
     * @param boolean $callable add callables
     */
    public function __construct($data, ?object $class = null, $callable = true)
    { 
        $dataset = []; $data = (array) $data;

        foreach($data as $key => $value){
            $dataset[$key] = is_array($value) ? new Record($value) : new Record([$value]);
        }

        //convert array data to object format
        $data = $dataset; 

        $this->data = $data;
        $this->dataset = $data;
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

    /**
     * This belongs to the collection class. Returns an array or a record
     *
     * @param integer|string|float|null $key
     *  - If defined returns a record if it exists or returns FALSE
     * @return mixed|Record
     *  - Array is returned if no key is supplied
     *  - FALSE is returned if $key value defined does not exist
     *  - Other data types returned are dependent upon the value of the data key in a specified array
     *  - Record is returned if used in a Model context and $key value defined exists as a key in retrieved data record object
     */
    public function data(int|string|float|null $key = null): mixed {
        return is_numeric($key)? $this->data[$key] : $this->data;
    }

    public function rewind(): void {
        $this->iterator = 0;
    }

    #[\ReturnTypeWillChange]
    public function current() : mixed {
        return $this->data[$this->datakeys[$this->iterator]];
    }

    #[\ReturnTypeWillChange]
    public function key() : mixed {
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
     * Belongs to the collection class. Protect all collected data having specified keys
     * 
     * @param array $keys array of keys whose values must be protected
     */
    public function protect(array $keys = []) : Collection {
        $this->protected = array_merge($this->protected, $keys);
        return $this;
    }

    /**
     * Return protect Collection keys
     */
    public function protected(){
        return $this->protected;
    }

    /**
     * @todo Unprotect protected DBViewer data.
     * 
     * @notice This must be called before data is retrieved from database. Once a data 
     * is retrieved, it cannot be unprotected.
     */
    public function unprotected(array $keys){

        foreach($keys as $key){  
            if(in_array($key, $this->protected)){
                $this->protected = array_delete($this->protected, $key);
            }
        }

    }

    /**
     * Create a new collection list
     *
     * @param array $data
     * @return Collection
     */
    public static function list(array $data) : Collection {
        return new Collection($data);
    }

    /**
     * Fetchs an index from data list
     *
     * @param integer|string $index
     * @param integer|string|array $value
     * 
     * @return bool|Record|stdClass|array|string
     *      - FALSE is returned if $index does not exist in the data list.
     *      - The Record held at $index is returned if $index exists in data list and $value is not supplied.
     *      - If $value (string) is supplied and $value exist in $index data list, the relative value is returned, else, false is returned.
     *      - If $value (array) is supplied each array values is tested as sub index of $index datalist. If subindex does not exist in $index, a false value is assigned to the index in array data returned
     */
    public function get(int|string $index, string|array|null $value = null): Record|stdClass|array|false|string
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
     * Sets or retrieves a custom collection error message.
     *   - A predefined custom message will be retrived unless it has been manually modified.
     * 
     * @param mixed $message custom error message if defined.
     * 
     * @return bool|string
     */
    public function error(mixed $message = null) {
        if(func_num_args() > 0){
            $this->error = $message;
        }else{
            return $this->error;
        }
    }

}