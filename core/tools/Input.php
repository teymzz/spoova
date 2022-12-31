<?php
 
namespace spoova\core\tools;

/**
 * This class is a simply used for validating the following lists.
 * strings, bool, integer, email, phone, number, ranges, text 
 * 
 * For proper validation of mail and phone you may need a more complex solution
 *
 * @author by Akinola Saheed <teymss@gmail.com>
 * 
 * @package spoova\core\tools
 */

class Input{

  /**
   * value supplied
   *
   * @var [sring | array]
   */
  private $value;

  /**
   * type of validation 
   *
   * @var array
   */
  private $default = [
    'type'   => null,
    'range'  => null,
    'length' => null,
  ];

  //Note:: integers are considered as numbers > or < 0
  private const types = [
    'string', 'text',
    'integer', 'number',
    'email', 'phone',
    'url', 'pregmatch',
  ];  

  private $type           = null;
  private $range          = null;
  private $length         = null;         
  private $allow_range    = false;
  private $allow_length   = false;
  private $pregmatch      = false;
  
  private $strict         = false;
  private $error_exists   = false;

  private $issue;
  private $message;
  private static $voidKey;

  /**
   * sets a value to be validated along with some custom settings
   *
   * @param string $value
   * @param array $config 
   *                [
   *                 'type'  => @property const types,
   *                 'range' => [value_a, value_b],
   *                 'length' =>[min, max],
   *                 'pregmatch' => 'pattern'
   *                ]
   * @param boolean $check_space
   * @return void
   */
  public function set($value, array $config, $check_space = false){
    
    //check for existing errors first
    if($this->error_exists)
      {

        $this->setIssue();
        if($this->strict) return false;

      }

    //check if no value was supplied
    if(trim($value) == null) return $this->response("no value set"); 

    //check if type was set
    if(!$this->set_type($config['type'])) return $this->response("no type set");

    $this->value = $value;
    
    //check for length if supplied
    if(array_key_exists('length', $config)){

      $length = $this->length = $config['length'];

      if(!$this->validate_length($length)){
        $this->error_exists = true;
        $this->issue   = "length";
        return false;
      }

    } elseif ($this->allow_length) {
      
      if(!$this->validate_length($this->default['length'])){
        $this->error_exists = true;
        $this->issue   = "length";
        return false;
      }

    }

    //set preg_match
    if(array_key_exists('pregmatch', $config)){

      $this->pregmatch = $config['pregmatch'];

      if(!$this->matched($value)) return false;

    } 

    //set space checking
    $check_space = ($check_space === 'no-space')? true : false;

    if($this->findSpace($value,$check_space)) return false;

    //check for range if supplied
    if(array_key_exists('range', $config)){
      
      $range =  $config['range'];
      $this->range = $range;

      $allow_range = ($range == true)? true : false;

    } else {

      $this->range = null;

      $allow_range = ($this->default['range'] != null)? true : false;
         
    }

    if($allow_range == true){

      if($this->validate_range($value)){
        if($this->strict){
          return $this->validate();
        }
        return $value;
      }else{
        $this->error_exists = true;
        $this->issue   = "range";
        return false;
      }

    }else{

      return $this->validate();

    }

  }

  /**
   * configures the class to return values for each data validation
   *
   * @param boolean $value
   * @return void
   */
  public function strict(bool $value = true){
    return $this->strict = $value;
  }

  /**
   * sets the minimum and maximum length of characters allowed
   *
   * @param integer|array $length
   * @return void
   */
  public function default_length($length){
    $this->allow_length = true;
    $this->default['length'] = $length;
  }

  /**
   * sets the default type
   *
   * @param string $default_type ['number' | 'string' ...]
   * @return void
   */
  public function default_type($default_type){    
    $this->default['type'] = $default_type;
  }
  
  /**
   * sets the default range
   *
   * @param array|integer $default_range
   * @return void
   */
  public function default_range($default_range){
    $this->allow_range   = true;
    $this->default['range'] = $default_range;
  }

  public static function arrGetsVoid($data){
    
    //returns true if an array $data contains at least one empty value
    if(func_num_args() > 1){
        $data = func_get_args();
    }
    
    $data = (array) $data;
    
    foreach($data as $key => $value){
      $value = trim($value);
      if($value == null){
        
        self::$voidKey = $key; 
       
        return true;
      }    
    }
    
    return false;
    
  }
  
  public static function voidKey() {
    return self::$voidKey;
  }

  private function set_type($type=null){

    $types = self::types;
    $type  = ($type == null)? strtolower($this->default['type']) : strtolower($type);

    if(in_array($type,$types)){

      $this->type  =  $type;
      return true;

    }else{

      trigger_error('invalid data type "'.$type.'" supplied');
      return false;

    }

  }

  private function findSpace($value,$check = false){
    if($check){
      if(strpos($value," ")) {
        $this->response("value does not allow space",false);
        $this->issue = 'space';
        return true;
      }
    }
    return false;
  }

  private function validate_string(){

    $value = $this->value;

    if (is_string($value)) {

      return $value;

    } else {

      return $this->response('value is not a valid string');

    }

  }

  private function validate_text(){

    $value = $this->value;

    if(!preg_match('/[^a-zA-Z]/', $value)){
      return $value;
    }

    return $this->response('value is not a valid text'); 

  }  

  private function validate_integer(){
      
    $value = $this->value;
     
    if(is_numeric($value)) {

      //check if the value is not decimal
      if(is_float($value)) return $this->response('value is not a valid integer');
  
      $nvalue = $value + 0;

      if(!is_int($nvalue)) return $this->response('value is not a valid integer');

      //check if range is set on the value
      if($this->allow_range == true){

        $ranges = $this->range;
        if(is_array($ranges)) {
          return $this->response('value range is not supplied');
        }

        if(in_array($nvalue, $ranges)){

          //return true    
          $this->response("value in range", true);
          return $value;

        }else{

          return $this->response("value not in range");

        }
      }

      //return true if all data is validated
      $this->response("value is valid");
      return $nvalue;
    
    }else{

      return $this->response('value is not a valid number');

    }

  }

  /**
   * checks if value is within the length(s) supplied
   *
   * @param array|integer $length
   * @return void
   */
  private function validate_length($length){
    
    $value = $this->value;
    if($length != null){

      if(!is_array($length)){
        $len = is_numeric($length)? $length + 0 : $length;
      }else{        

        if(count($length) == 1){ $length[1] = $length[0]; }

        $count = count($length);

        if($count == 2){
          $len1 = $length[0];
          $len2 = $length[1];
        }
      }
     
    }

    if(isset($len)){

      if(!is_numeric($len)){
        return $this->response("string length is invalid");
      }

      if( (strlen($value) > 0) && (strlen($value) <= $length) && (!is_empty($length)) ){
        return true;
      }else{
        return $this->response("string maximum length ($length chars) exceeded !");
      }

    }elseif (isset($len1)) {

      if(!is_numeric($len1) || !is_numeric($len2)){
        return $this->response("length range must be numeric");
      }

      if($len1 > $len2){
        return $this->response("range of lengths misplaced");
      }

      if($len1 == $len2){
        if(strlen($value) != $len1){ return $this->response("value must be $len1 chars in length"); }
        return true;
      }
      
      $range = range($len1, $len2);

      if(in_array(strlen($value), $range)){
        return true;
      }else{
        if(is_array($length)){ $length = $length[0].' - '.$length[1]; }
        return $this->response("value not in range of $length chars!");     
      }

    }
    
    return $this->response("characters length range of undetermined!");

  }

  //
  /**
   * check if value is not within the supplied range of values
   *
   * @param string $value
   * @return boolean
   */
  private function validate_range($value) : bool{

    $range = ($this->range == null)? $this->default['range'] : $this->range;
  
    return in_array($value, $range);

  }
  
  private function validate_number(){

    $value = $this->value;

    if(is_numeric($value)) return $value;
    return $this->response('value supplied is not a valid number');

  }

  private function validate_phone(){
    $value = $this->value;

    $phonevalue = ltrim($value, "+ ");
    
    $phonevalue = str_replace('-', '' , $phonevalue);

    if(is_numeric($phonevalue) && 
      (strlen($value) <= 18) && 
      (strpos($value, "--") === false) && 
      (substr_count($value, '-') < 3) && 
      (substr($phonevalue, 0 , 1) != "-") &&
      (substr($phonevalue, strlen($phonevalue) - 1, 1) != "-")
      ){
      return $value;
    }

    return $this->response('value supplied is not a valid phone');

  }

  private function validate_email(){
      
    $value = trim($this->value);

    if($this->findSpace($value,true)) return false;
    
    $pattern = "@\b(\b[a-zA-Z0-9.+-_]+\@[a-zA-Z0-9.+-]+[\.]([a-zA-Z]){2,63}\S\b)\b@";

    if(preg_match($pattern,$value)){

      return $value;

    } 
     return $this->response("$value is not a valid email");
  }

  private function validate_url(){
   
    $value = $this->value;

    return filter_var($value, FILTER_VALIDATE_URL); 
  }

  private function matched(){
    $value = $this->value;
    $pattern = '@'.$this->pregmatch.'@';

    return (preg_match($pattern, $value))? $value : false;
  }


  /**
   * calls the validation function
   *
   * @return boolean
   */
  public function validate() : bool {

    if(empty($this->type)) return false ;
    
    $types = self::types;      
    $type  = strtolower($this->type);

    if(in_array($type,$types)){
      switch($type){
        case "string": 
          return $this->validate_string();
          break;     
        case "text":
          return $this->validate_text();
          break;  
        case "integer":
          return $this->validate_integer();
          break;
        case "number":
          return $this->validate_number();
          break;
        case "phone":
          return $this->validate_phone();
          break;
        case "email":
          return $this->validate_email();
          break;                   
        case "pregmatch":
          return $this->matched();
          break;
        case "url":
          return $this->validate_url();
          break;          
        default: return false;
      }
    }else{
      return $this->response("validation cannot be found!");
    }  
  }

  public function setIssue(){
    
    if($this->error_exists){

        $issue = $this->issue;

        switch($issue){
          case "space":
            $message = "no space allowed";
            break;
          case "empty":
            $message = "field is empty";
            break;
          case "range":
            $message = "value set not within range";
            break;                                     
          case "length":
            $length  = ($this->length == null)? $this->default['length']: $this->length;
            $length  = (is_array($length))? $length[0]." - ".$length[1] : $length;
            $message = ('value set exceed a length of '.$length.' chars');
          break;
          default: $message = $this->message; //'please input a valid value';
       }

       $this->response($message);

      } else {

        $this->response("",true);

      }

      return false;
  }

  /**
   * set and return message
   *
   * @param [type] $message
   * @param boolean $return
   * @return bool, string
   */
  public function response($message = null, bool $return = false){

    if(func_num_args() == 0) return $this->message;

    if($message != null){

      $this->message = $message; 

      $this->error_exists = ($return == false)? true : false;

      return $return;
    }


  }

}


/**
 * DOCUMENTATION OF INPUT CLASS
 * 
 * //initialize class
 * $input = new \core\tools\Input;
 * 
 * Example 1:  ............................................
 *  $name = 'grego';
 *  $name = $input->set($name,['type'=>'string',length=>10,range=>['felix','tina','grego']]);
 *    
 *  Explanation 1: The above will:
 *    1: check if $name is a string
 *    2: check if the length is not more than 10
 *    3: check if $name can be found in array ['felix','tina','grego'] 
 *      4: if all validation is successful, the value is returned, else, a null value is returned;
 * 
 * 
 * Example 2:  ............................................
 *  $name = 'russel'; $number = '10';
 * 
 *  $name = $input->set($name,['type'=>'string',length=>[4, 10],range=>['felix','tina','grego']]);
 *  $number = $input->set($number,['type'=>'number',length=>2]); 
 *  
 *    
 *  Explanation 2: In the above,
 * 
 *   - The first $input->set() will:
 *      1: check if $name is a string
 *      2: check if the length is not less than 4 and not more than 10
 *    3: check if $name can be found in array ['felix','tina','grego'] 
 *      4: if all validation is successful, the value is returned, else, a null value is returned;
 * 
 * 
 * Example 3: to prevent the use of spaces .................
 *  $name = 'russel more';
 * 
 *  $name = $input->set($name,['type'=>'string'],'no-space'); 
 * 
 *  In the above, $input->set() will:
 *      1: check if $name is a string
 *      2: check if there is no space in $name
 *      3: if all validation is successful, the value is returned, else, a null value is returned;
 *      4: Since $name contains space, a null value is returned
 * 
 * 
 * SETTING DEFAULTS
 * 
 * You can set defaults configuration by using
 *  $input->default_type()
 *  $input->default_range()
 *  $input->default_length();
 * 
 *  Note: 
 *    1: These methods should be declared before using $input->set() method;
 *    2: Any configuration set within $input->set() will overide the default
 * 
 */