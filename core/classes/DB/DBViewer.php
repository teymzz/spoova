<?php

namespace spoova\mi\core\classes\DB;

use Error;
use Closure;
use stdClass;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Model;
use spoova\mi\core\classes\Collection;
use spoova\mi\core\classes\DB\DBExecutors;
use spoova\mi\core\classes\DB\DBMediators;

/**
 * This class contains custom modifier operators for 
 * modifying records already retrieved from database, thereby determining how records 
 * are finally viewed.
 * - Note that this class uses the Collection storage class
 * 
 * @property array|collection $collection return collection data
 *  - This property is reserved and should not be used as a database table's field name. The value is immutable and cannot be modified.
 * @property mixed $* Any dynamically handled property
 */
class DBViewer extends stdClass implements DBExecutors {

    private $Data;
    private Collection $PrivateData;
    private ?Model $Model = null;
    private ?string $ModelName = null;
    protected static string $StaticError = '';
    protected $CollectionItems = false;
    protected $Privatize = false;
    private $Property = false;
    private $DBError = false;
    private $Collated = false;
    private $Sql = '';

    // /**
    //  * This belongs to the collection class
    //  *
    //  * @var array|Collection
    //  */
    // public array|Collection $collection = [];

    /**
     * This belongs to the dbcollector class
     *
     * @var array|DBMediators
     */
    protected DBMediators $Collector;

    /**
     *
     * @param mixed $data
     * @param Model|null $model
     * @param string $modelName name for accessing data
     * @param boolean $privatize
     * 
     * @return DBViewer
     */
    public function __construct($data, DBMediators $collector, ?Model $model = null, ?string $modelName = null, bool $privatize = false)
    {

        $this->Data = $data;
        $this->Model = $model;
        $modelName = $modelName?: 'collection';
        $this->Privatize = $privatize;
        $this->Collector = $collector;
        
        $this->DBError = $collector->error();

        if(!$this->DBError) $this->Collated = true; 

        if($model) $this->Sql = $model->sql();
        
        $this->ModelName = $modelName;
        if(!$privatize){

            $this->property(fn() => $this->collection = new Collection($data, $model, false));
            
            // if(self::$StaticError) {            
            //     $this->DBError = self::$StaticError;
            //     $this->{$modelName}->error = $this->DBError;
            //     $this->DBError = self::$StaticError;
            // }   
        
        }else{
            $this->PrivateData = new Collection($this->Data, $model, false);
            $this->PrivateData->error($this->DBError);
            // if(self::$StaticError) {
            //     $this->DBError = self::$StaticError;
            //     $this->PrivateData->error = self::$StaticError;
            // }
        }

        return $this;

    }

    /**
     * Returns the last sql query detected if any.
     *
     * @return string
     */
    public function sql() {

        return $this->Collector->sql();

    }

    /**
     * Returns TRUE if sql error was detected.
     *
     * @return bool
     */
    public function failed() : bool {

        return !$this->Collated;

    }

    /**
     * Returns TRUE if no sql error was detected.
     *
     * @return bool
     */
    public function succeeds() : bool {

        return !$this->failed();

    }

    /**
     * Alias for {@see DBViewer::succeeds()}. Returns TRUE if no sql 
     * error was detected.
     *
     * @return bool
     */
    public function collated() : bool {

        return $this->succeeds();

    }

    /**
     * Return an array list of sql data related information
     *
     * @return array
     */
    public function info() {

        return $this->Collector->info();

    }

    /**
     * Belongs to the DBViewer class. Hides the data of keys supplied
     *  - Warning: Avoid chaining other class methods to this method
     *
     * @param array|string $datakeys 
     * @return DBViewer|null
     */
    public function protect(array|string $datakeys) : DBViewer|null {
        
        $datakeys = (array) $datakeys;

        //modify model data only needed to be protected
        foreach($this->Data as $key => $data) {
            foreach($datakeys as $datakey){
                if(isset($this->Data[$key][$datakey])){
                    if(is_array($this->Data[$key]) && array_key_exists($datakey, $this->Data[$key])){
                        $this->Data[$key][$datakey] = '**protected**'; 
                    }
                }
            }
        }  

        foreach($datakeys as $datakey){
            if(array_key_exists($datakey, $this->Data)){
                $this->Data[$datakey] = '**protected**';
            }
        }
        
        if(!$this->CollectionItems) {
            $new = (new Static($this->Data, $this->Collector, $this->Model, $this->ModelName, $this->Privatize));
            return $new;
        }

        return null;

    }
        
    /**
     * Removes a data out of an object
     *
     * @param int|string $key index key of data to be removed
     * @return DBViewer
     */
    public function pull(int|string $key) : DBViewer {

        if(isset($this->Data[$key])){
            //return $this->Data[$key];
            return  (new DBViewer($this->Data[$key], $this->Collector, $this->Model, $this->ModelName));
        }else{
            self::setError("invalid index key {{$key}} called on pull");
        }

        return new Static([false], $this->Collector, $this->Model, $this->ModelName);
    }

    /**
     * Shuffles data returned
     *
     * @return DBViewer
     */
    public function shuffle() : DBViewer {
        
        shuffle($this->Data);

        return (new Static($this->Data, $this->Collector, $this->Model, $this->ModelName));

    }

    /**
     * Sets a collectible error that can be viewed in the collectible Object data itself.
     *
     * @param string $error
     * @return void
     */
    private static function setError(?string $error = null) : void {
        if($error) self::$StaticError = $error;
    }

    /**
     * Returns the last error set by DBViewer
     *
     * @return string
     */
    public function error() : string|false {
        return $this->DBError;
    }

    /** 
     * Accesses the last read collection and returns the data
     *
     * @return array|Collection
     */
    public function collection() : array|Collection {
        if(property_exists($this, 'DBerror') && ($this->collection instanceof Collection)) {
            $this->collection->error($this->DBError);
        }
        return $this->collection ?: [];
    }

    /**
     * @param string $name
     * @param mixed $arguments
     * @return void
     */
    public function __set(string $name, $arguments) {
        if(!$this->Property === true) throw new Error('This method is not available for use');
        if((strtolower($name) === 'collection')){
            $this->$name = $arguments;
        }
    }

    /**
     * @param string $name
     * @return array|collection|false
     */
    public function __get($name) : array|false|collection {
        if((strtolower($name) === strtolower($this->ModelName)) || ($name === 'collection')){
            return property_exists($this, 'collection') ? $this->collection : [];
        }else{
            return EInfo::view("Undefined property \"{$name}\" called on ".($this->Model ? get_class($this->Model) : "DBViewer").'()');
        }
    }

    private function property(Closure $callback){
        $this->Property = true;
        $callback();
        $this->Property = false;
    }

}