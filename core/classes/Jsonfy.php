<?php

namespace spoova\core\classes;

/**
 * JsonFy is a tool for creating or manupulating simple arrays
 * or json structure easily on a two dimentional level. It is important
 * to note that this class was not built to handle data more than two
 * dimentional level which is its only know limitation.
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
 */
class Jsonfy{

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
    public function newData($data){
    	//supplies an array or json data to decompress to an array format.
        $data = !is_array($data)? json_decode($data, true) : $data;

        $this->data = is_array($data)? $data : [];
        $this->sourceData = $this->data;
	}
	
	/**
	 * return the key for value one level array 
	 *
	 * @param string $name
	 * @return void
	 */
	public function datakey(string $value){
		if(!in_array($value,$this->data)) return ;
		return array_search($value,$this->data);
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
    public function add($name, $key = null , $value = null){
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
	 * 		- @args count = 2, set value of @var $data[@param $key] = @param $value
	 *  	- @args count = 3, set value of @var $data[@param $key][@param $value] = @param $subval
	 * @return void
	 */
    public function update($key, $value = null, $subval = null){
       	
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
	 * @param string $value
	 * 
	 * if @args = 1, deletes @param $keyname from @var $data
	 * if @args = 2, deletes @param $value from @var $data[@param $keyname]
	 *
	 * @return void
	 */
    public function delete(string $keyname,$value = null){
    	$data = $this->data;
		$args = func_num_args();
		
		if($args === 1){
			unset($data[$keyname]);
		}elseif($args == 2){
			unset($data[$keyname][$value]);
		}

    	$this->data = $data;    	
    }

	/**
	 * read @param string $keyname from @var array $data
	 * 
	 * @return string if found
	 * @return boolean false if not found
	 */
    public function read($keyname){

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
	 *   @param $type ==  null	   : @return @var array $data
	 * 	 @param $type == 'source'  : @return @var $sourcedata
	 * 	 @param $type == 'json'    : @return string json of @var $data
	 * 	 @param $type == 'count'   : @return int count of @var $data
	 * 
	 */
    public function data($type = null){

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

/**
 * DOCUMENTATION
 * 
 * newData($data) //optional method for setting already existing $data. Can be skipped if $data is generated internally
 * 
 * add($name,$key,$value) // add data into $data
 * add($name,$key,$value) // updates data in $data
 * delete($key,$value) // deletes key in $data
 * read($key) //read $key from $data
 * data($type) //return $data in format of defined $type
 * datakey($value) // returns keyname for value $value in @var array $data 
 */
/* 
	INITIALIZE CLASS

		new \core\classes\Jsonfy;
	
	SUPPLY AN EXISTING DATA FOR MODIFICATION

		$Jsonfy->newData($mydata); //this is optional except for existing data modification 

	SAMPLES FOR ADDING DATA

	// Please note: when a method is called, it modifies the old one if neccessary. However, every line below is assumed to be the first declaration of the method, coming immediately after the class was initialized or after new data was set

	// $Jsonfy->add(''); //['0'=>'']
	// $Jsonfy->add('ade'); //['ade'=>'']
	// $Jsonfy->add('',''); //['0'=>'']
	// $Jsonfy->add('','me'); //['0'=>'me']
	// $Jsonfy->add('ade','me'); //['ade'=>'me']
	// $Jsonfy->add('','',''); //['0'=>['0'=>'']]
	// $Jsonfy->add('ade','me','you');  //['ade'=>['me'=>'you']]
	// $Jsonfy->add('','me','you');  //['0'=>['me'=>'you']]
	// $Jsonfy->add('','you','');  //['0'=>['you'=>'']]
	// $Jsonfy->add('','','you');  //['0'=>['0'=>'you']]

	//To view this all, use $Jsonfy->data() after each declaration;

	
	SAMPLES FOR UPDATING DATA

	// Please note: when a method is called, it modifies the old one if neccessary. However, every line below is assumed to be the first declaration of the method, coming immediately after the class was initialized or after new data was set

	// $Jsonfy->add('','felix'); //['0'=>'felix']
	// $Jsonfy->update($Jsonfy2->datakey('felix'),'tina'); //['0'=>'tina']

	// $Jsonfy->add('users','felix'); //['users'=>'felix']
	// $Jsonfy->update('users','tina'); //['users'=>'tina']

	// $Jsonfy->add('users','felix','stand'); //['users'=>['felix'=>'stand']]
	// $Jsonfy->update('users','tina','sit'); //[users'=>['felix'=>'stand','tina'=>'sit']]
	// $Jsonfy->update('users','felix','run'); //[users'=>['felix'=>'run','tina'=>'sit']]

	//To view this all, use $Jsonfy->data() after each declaration;

	
	SAMPLES FOR DELETING DATA

	// Please note: when a method is called, it modifies the old one if neccessary. However, every line below is assumed to be the first declaration of the method, coming immediately after the class was initialized or after new data was set

	$Jsonfy2->add('users','see','me'); //['users'=>['see'=>'me']];
	
	// // deleting subkey only
	// $Jsonfy2->delete('users','see');
	// $Jsonfy->data(); // ['users'=>''];
	
	// //deleting main key
	// $Jsonfy2->delete('users');
	// $Jsonfy->data(); // [];


	SAMPLES FOR READING DATA
	$Jsonfy2->read('users'); // returns the value of 'users'

*/