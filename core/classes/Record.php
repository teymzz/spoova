<?php 

namespace spoova\mi\core\classes;

class Record {

    private $data = [];
    private $dataset = [];
    private $protected = [];


    public function __construct(array $data)
    {
      foreach($data as $key => $value){
        $this->data[$key] = $value;
        $this->dataset[$key] = $value;
      }   
    }

    /**
     * Read a column off the record.
     *
     * @param string $name column name
     * @return mixed the column value, or FALSE if the record has no such column.
     *   A protected column reads as its mask, the same as through {@see data()}.
     */
    public function __get(string $name){

        /* both branches used to return the same thing, which left the guard doing
           nothing and an unknown column raising an undefined-key warning on its way
           to NULL. A column that is not there is reported as FALSE, matching data() */
        if(array_key_exists($name, $this->dataset)){
            return $this->dataset[$name];
        }

        return false;

    }

    /**
     * Report whether the record carries a column, so that isset() and ?? on a
     * column answer for the record rather than for the undeclared property.
     *
     * @param string $name column name
     * @return bool
     */
    public function __isset(string $name) : bool {
        return isset($this->dataset[$name]);
    }

    /**
     * Protect Record access key names
     *
     * @param array|string $data
     * @return Record
     */
    public function protect(array|string $data) : Record {
        $data = (array) $data;
        /* the list used to be pushed as a nested array, so in_array() could never
           match a column name against it and every read of it came back empty */
        $this->protected = array_merge($this->protected, $data);
        foreach($data as $key){
            $this->dataset[$key] = '**protected**';
        }
        return $this;
    }

    /**
     * Column names masked by {@see protect()}.
     *
     * @return array
     */
    public function protected() : array {
        return $this->protected;
    }

    /**
     * This belongs to a record class. Returns the value obtained from a record.
     *
     * @param integer|null $key A database column name assigned to an individual record.
     * @return mixed Value returned depends on value obtained from the database 
     *  - An array is returned if no argument is supplied
     *  - FALSE is returned if $key does not exist in data retrieved
     */
    public function data(?string $key = null): mixed {
        /* protect() masks the column in $dataset itself, so there is nothing a
           protected column needs here that an ordinary read does not already do */
        if((func_num_args()>0)){
            if(isset($this->dataset[$key])){
                return $this->dataset[$key];
            }
            return false;
        }
        return $this->dataset;
    }


}