<?php

namespace spoova\mi\core\classes;

/**
 * JsonFy is a tool for creating or manupulating simple arrays
 * or json structure easily on a two dimentional level. It is important
 * to note that this class was not built to handle data more than two
 * dimentional level which is its only known limitation.
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Jsonfy{

	public array $sourceData;

	/**
	 * array of data supplied or generated from json string
	 *
	 * @var array
	 */
	private $data = [];

	/**
	 * sets a json string or an array data
	 *
	 * @param string|array $data
	 * @return void
	 */
    public function newData(string|array $data){
    	//supplies an array or json data to decompress to an array format.
        $data = !is_array($data)? json_decode($data, true) : $data;

        $this->data = is_array($data)? $data : [];
        $this->sourceData = $this->data;
	}
	
	/**
	 * return the key for value one level array 
	 *
	 * @param string $value
	 * @return int|string|false
	 */
	public function datakey(string $value) : int|string|false {
		if(!in_array($value, $this->data)) return false;
		return array_search($value, $this->data);
	}

	/**
	 * adds a new data into @var array $data
	 *
	 * @param string $name - name of new data
	 * 		- used as array key
	 * 		- if null, array key $name uses number 
	 * @param string|array $key 
	 * 		- used as value if one or two args supplied
   	 *    - @ 3 args: use as subkey
   	 *    - @ 3 args and if null: array subkey $key uses numbered      
	 * @param string|array $value - value of new data for 3 level
	 * 		- @ 3args sets the value as $value
     *    - value is never numbered
	 * @return void
	 */
    public function add($name, mixed $key = null , mixed $value = null){
    	$data = $this->data;
        $args = func_num_args();
		
		if($args === 1){
 		   array_push($data, $name); 
		}elseif($args === 2 and $name == ''){
    	   array_push($data, $key); //where $key => $value :> get array and add value
    	}elseif($args < 3){
    	   if(!isset($data[$name])){ $data[$name] = $key; }
    	}else{
		   if($name === ''){
			   if($key === ''){
				   $data[][] = $value;
			   }else{
			   	$data[][$key] = $value;
			   }
		   }else{
    	   	if(!isset($data[$name])){ $data[$name][$key] = $value; }
		   }
    	}

    	$this->data = $data;
    }

	/**
	 * updates array keys or values
	 *
	 * @param string|array $key
	 *  	- sets array key or parent key whose value is to be replaced
	 * 
	 * @param string|array $value
	 *   - @args count = 2, set value of @var $data[@param $key] = @param $value
	 *   -- @args count = 3, set value of @var $data[@param $key][@param $value] = @param $subval
	 * @return void
	 */
    public function update($key, mixed $value = null, mixed $subval = null){
       	
       	$data = $this->data;
		$args = func_num_args();

		if($key === '') return false;

		if($args < 3){
			if($args === 2 and is_array($key)) return false;
			if(isset($data[$key])){
				$data[$key] = $value;
			}
		}else{
			if($args > 2 and (is_array($key) || is_array($value))) return false;
			$data[$key][$value] = $subval;	
		}
		
    	$this->data = $data;
    }

	/**
	 * deletes value from an array
	 * 
	 * @param string $keyname
	 * @param mixed $value
	 * 
	 * if @args = 1, deletes @param $keyname from @var $data
	 * if @args = 2, deletes @param $value from @var $data[@param $keyname]
	 *
	 * @return void
	 */
    public function delete(string $keyname, mixed $value = null){
    	$data = $this->data;
		$args = func_num_args();
		
		if($args === 1){
			unset($data[$keyname]);
		}elseif($args == 2){
			/* a key holding a scalar has no sub-key to remove. unset() used to be
			   reached anyway, raising a fatal "cannot unset offset in a non-array
			   variable" where an unknown key is otherwise a no-op */
			if(isset($data[$keyname]) && is_array($data[$keyname])){
				unset($data[$keyname][$value]);
			}
		}

    	$this->data = $data;    	
    }

	/**
	 * read @param string $keyname from @var array $data
	 * 
	 * @return mixed 
	 *  - false : if key does not exist.
	 * @return boolean false if not found
	 */
    public function read(string $keyname) : mixed {

    	$data = $this->data;

    	if(isset($this->data[$keyname])){
    		return $data[$keyname];
    	}
    	return false;
    }

	/**
	 * return data using defined values
	 * 
	 * @param string $type 
	 * 
	 * @return mixed
	 *   - $type ==  null	  : return value of property $data (array)
	 * 	 - $type == 'source'  : return value of property $sourcedata
	 * 	 - $type == 'json'    : return json string of property $data
	 * 	 - $type == 'count'   : return integer count of property $data
	 * 
	 */
    public function data(?string $type = null){

    	if($type == 'source'){
    		return $this->sourceData;
    	}elseif($type == 'json'){
    		return json_encode($this->data,true);
    	}elseif($type=="count"){
    		return count($this->data);
    	}else{
    		return $this->data;
    	}
    }

}