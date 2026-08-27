<?php
 
namespace spoova\mi\core\tools;

use Exception;

/**
 * This class is a simply used for validating the following lists.
 * strings, integer, email, phone, number, ranges, json, text 
 * 
 * For proper validation of mail and phone you may need a more complex solution
 *
 * @author by Akinola Saheed <akinolasaheed001@gmail.com>
 */

class Input{

  /**
   * Defines the identifier name for the test value
   *
   * @var string
   */
  private $id = '';

  /**
   * value supplied 
   *
   * @var string|array
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

  private const types = [
    'string', 'text', 'json',
    'integer', 'number','numeric',
    'email', 'phone', 
    'url', 'pregmatch',
    'float','decimal'
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
  private $message = '';
  private static array $voidKey = [];

  private $errors = [];

  
  /**
   * Sets the identifier name for the current test value
   *
   * @param string $id
   * @return Input
   */
  public function id(string $id) : Input {
    $this->id = $id;
    return $this;
  }

  /**
   * sets a value to be validated along with some custom settings
   *
   * @param string|int|float|bool $value
   * @param array $config declares the configuration options
   *                ```[
   *                 'type'  => Input::types,
   *                 'range' => [option, option, ...],
   *                 'length' => [min, max],
   *                 'pregmatch' => 'pattern',
   *                 'spaces' => true|false
   *                ]```
   * @param boolean $isBool determines if the value returned should be boolean. TRUE sets the mode to boolean while FALSE returns 
   * the value supplied if validation is successful.
   * @return mixed
   *  - If validation fails, a false value is returned. However, if successful, data supplied is returned in string 
   * or boolean form if $isBool is set as false. 
   */
  public function set($value, array $config = [], bool $isBool = false) : bool|string {
    
    //check for existing errors first
    if($this->error_exists)
    {

      $this->setIssue();
      if($this->strict) return false;

    }

    //check if no value was supplied
    if(trim($value) == null) return $this->response("no value set");

    //check if type was set or regex keys defined
    if(!$this->set_type($config['type'] ?? 'string')) return $this->response("no type set");

    $this->value = $value;
    
    //check for length if supplied
    if(array_key_exists('length', $config)){

      $length = $this->length = $config['length'];

      if(!$this->validate_length($length)){
        $this->error_exists = true;
        $this->issue = "length";
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
    if(array_key_exists('pregmatch', $config) || array_key_exists('pattern', $config)){

      $this->pregmatch = $config['pattern'] ?? $config['pregmatch'];

      if(!$this->matched($value)) return false;

    } 

    $check_space = (($config['spaces']??'') === false); //set space permission

    if($this->findSpace($value, $check_space)) return false;

    //check for range if supplied
    if(array_key_exists('range', $config)){

      $range =  $config['range'];
      $this->range = $this->range_options($range);
      $use_range = true;

    } else {

      $this->range = null;

      $use_range = (is_array($this->default['range']));
         
    }

    if($use_range){

      if($this->validate_range($value)){
        if($this->strict){
          if(!$this->validate()) return false;
        }
        if($this->id) unset($this->errors[$this->id]);
        return $value;
      }else{
        $this->error_exists = true;
        $this->issue = "range";
        return false;
      }

    }else{

      if($this->validate()){
        if($this->id) unset($this->errors[$this->id]);
        return $isBool ?: $value;
      }
      return false;

    }

  }

  /**
   * sets a value to be validated along with some custom settings
   *
   * @param string $value
   * @param array $config 
   *                ```[
   *                 'type'  => {@see Input::types},
   *                 'range' => [value_a, value_b],
   *                 'length' =>[min, max],
   *                 'pregmatch' => 'pattern'
   *                ]```
   * @return bool|string
   */
  public function test($value, array $config) : bool|string {
    return $this->set(...func_get_args());
  }

  /**
   * configures the class to return values for each data validation
   *
   * @param boolean $value
   * @return boolean
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
  public function default_length(int|array|null $length = null){
    if($length === null){
      // a default length is removed by supplying null, like the other default_* methods
      $this->allow_length = false;
      $this->default['length'] = null;
      return;
    }

    $this->allow_length = true;
    $this->default['length'] = $length;
  }

  /**
   * sets the default type
   *
   * @param string $default_type optional [string|integer|decimal|number|text|email|phone|url|pregmatch]
   * @return void
   */
  public function default_type($default_type){    
    if($default_type === null) {
      unset($this->default['type']);
    }else{
      $this->default['type'] = $default_type;
    }
  }
  
  /**
   * sets the default range
   *
   * @param array|string|integer $default_range
   * @return void
   */
  public function default_range(array|string|int|null $default_range = null){
    if($default_range === null) {
      $this->allow_range = false;
      /* The stored range goes as well. set() decides whether a default range applies by
         looking at this value, so leaving it behind meant every later value was still
         checked against a range the caller had just removed. */
      $this->default['range'] = null;
    }else{
      $this->allow_range = true;
      /* stored as a list, so that a single option supplied on its own is applied like any
         other range rather than being passed over by the array test in set() */
      $this->default['range'] = $this->range_options($default_range);
    }
  }

  public static function arrGetsVoid($data){
    
    //returns true if an array $data contains at least one empty value
    if(func_num_args() > 1){
        $data = func_get_args();
    }
    
    $data = (array) $data;

    /* The keys belong to the data being checked, so the list starts afresh. It used to be
       added to, which left a later check reporting keys an earlier one had found. */
    self::$voidKey = [];

    $response = false;

    foreach($data as $key => $value){

      /* A request value can itself be an array (i.e a "name[]" field), which trim() cannot
         take, and the documented use passes request data straight in. An array holding
         nothing counts as empty like any other empty value. */
      $isVoid = is_array($value)? ($value === []) : (trim((string) $value) === '');

      if($isVoid){

        self::$voidKey[] = $key;

        $response = true;
      }
    }

    return $response;
    
  }
  
  public static function voidKeys() {
    return self::$voidKey;
  }

  /**
   * Defines the type of data to be validated
   *
   * @param string|null $type optional [string|integer|decimal|bool|number|text|email|phone|url|pregmatch]
   * 
   * @return bool true is returned if $type (validation type) exists
   */
  private function set_type(?string $type = null) : bool {

    $types = self::types;

    $type  = ($type === null)? strtolower($this->default['type']) : strtolower($type);

    if(in_array($type, $types)){

      $this->type  =  $type;
      return true;

    }else{

      trigger_error('invalid data type "'.$type.'" supplied');
      return false;

    }

  }

  private function findSpace($value, $check = false){
    if($check){
      if(strpos($value," ")) {
        $this->response("value does not allow space",false);
        $this->issue = 'space';
        return true;
      }
    }
    return false;
  }

  private function validate_string() : bool {

    return is_string($this->value) ?: $this->response('value is not a valid string');

  }

  private function validate_text() : bool {

    return !preg_match('/[^a-zA-Z]/', $this->value) ?:  $this->response('value is not a valid text');

  }  

  private function validate_integer() : bool {
      
    $value = $this->value;
     
    if(is_numeric($value)) {

      //check if the value is not decimal
      if(is_float($value)) return $this->response('value is not a valid integer'); //returns: false
  
      $nvalue = $value + 0;

      if(!is_int($nvalue)) return $this->response('value is not a valid integer'); //returns: false

      //check if range is set on the value
      if($this->allow_range === true){

        $ranges = $this->range;

        if(is_array($ranges) && !$ranges) {
          return $this->response('value range is not supplied'); //returns: false
        }

        if(in_array($nvalue, $ranges)){

          return $this->response("value in range", true); //returns: true

        }else{

          return $this->response("value not in range"); //returns: false

        }

      }

      //return $nvalue;
      return $this->response("value is valid", true); //returns: true
    
    }else{

      return $this->response('value is not a valid number'); //returns: false

    }

  }

  private function validate_decimal() : bool {
      
    $value = $this->value;
     
    if(is_numeric($value)) {
  
      $nvalue = $value + 0;

      if(!is_float($nvalue)) return $this->response('value is not a valid decimal'); //returns: false

      //check if range is set on the value
      if($this->allow_range === true){

        $ranges = $this->range;
        if(is_array($ranges) && !$ranges) {
          return $this->response('value range is not supplied'); //returns: false
        }

        if(in_array($nvalue, $ranges)){

          //return true    
          $this->response('value in range', true); //returns: true
          return $value;

        }else{

          return $this->response('value not in range'); //returns: false

        }
      }
      
      // return $nvalue;
      return $this->response('value is valid', true); //returns: true
    
    }else{

      return $this->response('value is not a valid decimal'); //returns: false

    }

  }

  /**
   * checks if number of characters in test value is within the length(s) supplied
   *
   * @param array|integer $length
   * @return bool
   */
  private function validate_length($length) : bool{
    
    $value = $this->value;
    if($length != null){

      if(!is_array($length)){
        $len = is_numeric($length)? $length + 0 : $length;
      }else{        

        //set minimum as maximum length
        if(count($length) == 1){ $length[1] = $length[0]; }

        //define minimum and maximum length variables
        if(count($length) == 2){
          $len1 = $length[0];
          $len2 = $length[1];
        }
      }
     
    }

    if(isset($len)){

      if(!is_int($len)){
        return $this->response('supplied characters length is invalid');
      }

      /* The is_empty() test that stood here is a framework helper, which made a length of
         one number fatal wherever this class was used on its own. It could not change the
         outcome either: $length has just been established as an integer, and a length of
         zero is already turned away by the character count above it. */
      if( (strlen($value) > 0) && (strlen($value) <= $length) ){
        return true;
      }else{
        return $this->response("string maximum length ($length chars) exceeded !");
      }

    }elseif (isset($len1)) {

      if(!is_numeric($len1) || !is_numeric($len2)){
        return $this->response("length range must both be numeric."); //returns: false
      }

      if($len1 > $len2){
        return $this->response("range of lengths misplaced."); //returns: false
      }

      if($len1 == $len2){
        if(strlen($value) != $len1){ 
          return $this->response("value must be $len1 chars in length.");  //returns: false
        }
        return true;
      }
      
      $range = range($len1, $len2);

      if(in_array(strlen($value), $range)){
        return true;
      }else{
        if(is_array($length)){ $length = $length[0].' - '.$length[1]; }
        return $this->response("value not in range of $length chars."); //returns: false    
      }

    }
    
    return $this->response('defined characters length cannot be resolved.');  //returns: false

  }

  /**
   * check if value is not within the supplied range of values
   *
   * @param string $value
   * @return boolean
   */
  private function validate_range($value) : bool{

    $range = ($this->range === null)? $this->default['range'] : $this->range;

    $range = $this->range_options($range);

    return in_array($value, $range) ?: $this->response('value supplied is not within specified options');

  }

  /**
   * Returns a range as the list of options a value is matched against.
   *
   * A range holding a single option may be supplied on its own (i.e 'range' => 'yes')
   * rather than as a list, and no range at all matches nothing.
   *
   * @param mixed $range supplied range
   * @return array
   */
  private function range_options($range) : array {

    if($range === null) return [];

    return is_array($range)? $range : [$range];

  }
  
  private function validate_number() : bool {

    return (is_numeric($this->value)) ?: $this->response('value supplied is not a valid number');

  }

  private function validate_phone() : bool {
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
      return true;
    }

    return $this->response('value supplied is not a valid phone'); //returns: false

  }

  private function validate_email() : bool {
      
    $value = trim($this->value);

    if($this->findSpace($value, true)) return false;
    
    $pattern = "@\b(\b[a-zA-Z0-9.+-_]+\@[a-zA-Z0-9.+-]+[\.]([a-zA-Z]){2,63}\S\b)\b@";

    return preg_match($pattern, $value) ?: $this->response("invalid email supplied"); 

  }

  private function validate_json() : bool {
    
    try{
      json_decode($this->value);
      return true;
    }catch(Exception $e){
      return $this->response("invalid json supplied"); 
    }

  }

  private function validate_url() : bool {
    return filter_var($this->value, FILTER_VALIDATE_URL) ?: $this->response("invalid url supplied"); 
  }

  private function matched() : bool {
    $value = (string) $this->value;
    $pattern = (string) $this->pregmatch;

    /* The pattern is used exactly as it is supplied, delimiters and modifiers included, so
       that a case insensitive match (i.e "/[a-z]+/i") stays available to the caller. */
    if(@preg_match($pattern, '') === false){
      return $this->response("pattern supplied is not a valid regular expression");
    }

    /* It has to account for the whole value as well. An unanchored pattern such as
       "/[a-zA-Z]+/" matches the letters inside "abc123" and used to let that value through,
       which reads as the opposite of a validation. */
    if(preg_match($pattern, $value, $matches) && (($matches[0] ?? null) === $value)){
      return true;
    }

    return $this->response("$value does not match specified pattern");
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

    if(in_array($type, $types)){
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
        case ($type === "float") || ($type === "decimal"):
          return $this->validate_decimal();
          break;
        case ($type === "number") || ($type === "numeric"):
          return $this->validate_number();
          break;
        case "phone":
          return $this->validate_phone();
          break;
        case "email":
          return $this->validate_email();
          break;                   
        case "json":
          return $this->validate_json();
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
      return $this->response("unknown validation rule!");
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

      $this->response("", true);

    }

    return false;
  }

  /**
   * This method either sets a response message or returns last response message (if defined).
   *
   * @param mixed $message
   * @param boolean $return defines response to return when $message is not null
   * @return boolean|string
   */
  public function response(mixed $message = null, ?bool $return = false) : bool|string {

    if(func_num_args() == 0) return $this->message;

    if($message !== null){

      if($return == false){

        /* The first failure is the one reported. A later failure used to displace it, so
           response() answered with whichever validation failed last rather than the first
           one, which is what error tracking describes. Errors kept per id are unaffected. */
        if(($this->message === null) || ($this->message === '')) $this->message = $message;

        if($this->id) $this->errors[$this->id] = $message;

        $this->error_exists = true;

        return $return;

      }

      /* A validation that passed carries no error to report. Its message used to be kept
         all the same, and error_exists() reads that message, so a value that passed was
         reported as a failure. */
      $this->message = '';

      $this->error_exists = false;

      return $return;
    }
    return false;
  }

  /**
   * Returns true if any error exists during validation
   *
   * @return boolean
   */
  public function error_exists() : bool {
    return $this->message ? true : false;
  }

  /**
   * Returns true if any error exists during validation
   *
   * @param boolean|string $id
   * @return array|string|false
   *  - returns array of errors if $id is set as true (default)
   *  - returns string of error value if error id exists in the list of detected errors.
   *  - returns false if error id does not exist in the list of errors.
   */
  public function error(bool|string $id = true) : array|string|false {
    if($id === true) return $this->errors;
   return $this->errors[$id] ?? false;
  }

}