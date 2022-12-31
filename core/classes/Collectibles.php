<?php

namespace spoova\core\classes;

use DBStatus;
use Traversable;
use User;

class Collectibles {

    public static $data;
    private static $privateData;
    private static $model;
    private static $modelName;
    public static $staticError;
    public static $collectionItems = false;
    public static $privatize = false;

    public function __construct($data, ?Model $model = null, $modelName = null, bool $privatize = false)
    {

        static::$data = $data;
        self::$model = $model;
        $modelName = $modelName?: 'Collection';
        self::$privatize = $privatize;

        self::$modelName = $modelName;
        if(!$privatize){
            $this->{$modelName} = new Collection(static::$data, $model, false);

            if(Static::$staticError) {            
                $this->Error = Static::$staticError;
                $this->{$modelName}->Error = $this->Error;
                $this->Error = Static::$staticError;
            }            
        }else{            
            self::$privateData = new Collection(static::$data, $model, false);
            if(Static::$staticError) {
                $this->Error = Static::$staticError;
                self::$privateData->Error = Static::$staticError;
            }
        }

        return $this;

    }

    /**
     * Hides the data of keys supplied
     *
     * @param array|string $datakeys
     * @return Collectibles|void
     * 
     * @notice Avoid chaining other class methods to this method
     */
    public function protect(array|string $datakeys){

        $datakeys = (array) $datakeys;

        foreach(static::$data as $key => $data) {
            foreach($datakeys as $datakey){
                if(isset(static::$data[$key][$datakey])){
                    if(is_array(static::$data[$key]) && array_key_exists($datakey, static::$data[$key])){
                        static::$data[$key][$datakey] = '***protected***'; 
                    }
                }
            }
        }  

        foreach($datakeys as $datakey){
            if(array_key_exists($datakey, static::$data)){
                static::$data[$datakey] = '***protected***';
            }
        }

        if(!static::$collectionItems) {
            $new = (new Static(static::$data, self::$model, self::$modelName, self::$privatize));
            return $new;
        }

    }
        
    /**
     * Removes a data out of an object
     *
     * @param int|string $key index key of data to be removed
     * @return Collectibles
     */
    public function pluck(int|string $key){

        if(isset(static::$data[$key])){
            //return static::$data[$key];
            return  (new Collectibles(static::$data[$key], self::$model, self::$modelName));
        }else{
            self::setError("invalid index key {{$key}} called on pluck");
        }

        return new Static([false], self::$model, self::$modelName);
    }

    /**
     * Shuffles data returned
     *
     * @return Collectibles
     */
    public function shuffle(){
        
        shuffle(static::$data);

        return (new Static(static::$data, self::$model, self::$modelName));

    }

    /**
     * Sets a collectible error that can be viewed in the collectible Object data itself.
     *
     * @param string $error
     * @return void
     */
    public static function setError(string $error = null){
        if($error) self::$staticError = $error;
    }

    /**
     * Returns the last error set by Collectibles
     *
     * @return string
     */
    public function error() : string|null {
        return Static::$staticError;
    }

    /**
     * Accesses the last read collection and returns the data
     *
     * @return traversable|array
     */
    public function Collection() : Traversable | array {

        if(isset($this->Error)) $this->{self::$modelName}->Error = $this->Error;
        return $this->{self::$modelName}?? [];
    }

    public function __get($name){
        if($name == self::$modelName){
            unset($this->Error);
            return self::$privateData;
        }else{
            $model = self::$model::tableName();
            return EInfo::view("Undefined property \"{$name}\" called on ".get_class(self::$model).'()');
        }
    }

}