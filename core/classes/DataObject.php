<?php

namespace spoova\core\classes;


class DataObject extends DataObjectMapper { 


    final public function get($key) : DataObject {

        if(isset($this->data[$key])){

            $data = ( is_string($this->data[$key]) )
                    ? [ $key => $this->data[$key]] 
                    : $this->data[$key];

            return new static($data);
        }
        return new static([]);
    }

    final public function pull(string|int $key) : DataObject|DataObjectContainer {

        if(is_array($this->data1) && array_key_exists($key, $this->data1)){

            $data = ( is_string($this->data1[$key]) )
                    ? new DataObjectContainer([ $key => $this->data1[$key]]) 
                    : new DataObject($this->data1[$key]);

            return $data;

        }

        return new DataObjectContainer($this->data1[$key] ?? []);

    }

    /**
     * Get the string value of a key if it exists 
     *
     * @param string|integer $key
     * @return mixed
     */
    final public function pluck(string|int $key) : string {
        return $this->data[$key] ?? false;
    }


    final public function loop(){
        return  new DataObjectContainer($this->data);
    }

    final public function exists() : bool {
        return $this->Checkers ? true : false;
    }

    final public function protect($datakeys) {
        $datakeys = (array) $datakeys;

        $objectName = $this->objectName();
        
        $objectClass = get_class($this->object);
        $objectName = basename(to_frontslash($objectClass)); 

        foreach($this->{$objectName} as $key => $data) {
            foreach($datakeys as $datakey){
                if(isset($this->data[$key][$datakey])){
                    if(is_array($this->data[$key]) && array_key_exists($datakey, $this->data[$key])){
                        $this->data[$key][$datakey] = '*****'; 
                    }
                }
            }
        }  

        foreach($datakeys as $datakey){
            if(array_key_exists($datakey, $this->data)){
                $this->data[$datakey] = '*****';
            }
        }
        
        $protectedData = new $objectClass($this->data, $this->object);
        return $protectedData;
    }
    
}