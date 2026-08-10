<?php

/* Custom stand-alone core functions. Do not Remove*/

use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\classes\Attribs;
use spoova\mi\core\classes\Dumper;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Enums\inflect;
use spoova\mi\core\tools\Inspector;

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * prints a break tag or PHP_EOL to the page
 * All arrays are converted to json format
 *
 * @param mixed $var
 * @param int $break
 * @return string
 */
function br($var = '', int $break = 1) : string { 

  $var = is_array($var)? json_encode($var) : $var;

  //isCli is defined in settings
  $br = isCli() ? (isTerminal(['prompt','powershell','wsl'])? "\r\n" : "\n") : "<br>";

  return  $var.str_repeat($br, $break);
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Use htmlentities
 */
function entify(string $string) { 

  $string = htmlentities(trim($string));

  echo $string."\n";
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * variable dump 
 * @param mixed $var
 */
function vdump($var){
   monitor();
   Dumper::vdump(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * variable dump 
 * @param mixed $var
 */
function ddump($var){
   monitor();
   Dumper::vdump(...func_get_args())->exit();
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * This function in used to inspect values
 * @param mixed[] $values
 */
function inspect($values){
  return Inspector::inspect(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * @uses var_dump()
 * Dumps a value within a html pre tag
 */
function preFormat(mixed $value) : void{
  print "<pre>";
  var_dump($value);
  print "</pre>";
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * This function in used to inspect values with defaultly expanded 
 * data types for strings, booleans, integers, double and null values
 * @param mixed[] $values
 */
function check($values){
  Inspector::expand();
  return Inspector::inspect(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * This function inspects values similar to {@see check()} while terminating the script
 * @param mixed[] $values
 */
function checkd($values){
  Inspector::expand();
  Inspector::inspect(...func_get_args());
  die();
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * This function in used to inspect values while terminating the page
 * @param mixed[] $values
 */
function dissect($values){
  Inspector::inspect(...func_get_args());
  die();
}


/**
 * variable dump 
 * @param array $args array key names and their respective values
 * @param array $titles
 * @param false $headers defines if headers are supported
 * @return never
 */
function vlist(array $args, array $titles = [], false $headers = false){

  Dumper::vlist(...func_get_args())->exit();
 
}

/**
* variable dump 
* @param array|string $args array key names and their respective values
*/
function vdiv(array|string $args){
   $args = (array) $args;
   return Dumper::vdiv($args);
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Execute a list of functions sequentially
 *
 * @param array $processes
 * @param boolean $series if set as false, array is returned, else last response is obtained.
 * @return bool|array
 */
function step_run(array $processes, bool $series = false) : mixed {

  $response = []; $result = '';

  foreach($processes as $function => $process) {

    if($process instanceof Closure){

      $response[$function] = $result = $process();

      if(!$series && ($result === false)) {
        return false;
      }

    } else {
      if(!$series && ($process === false)) {
        return false;
      }      
    }

  }

  if(!$series)  return $result;

  return $response;

}

/**
 * (Spoova 1 &gt;= 1.0.0) <br/>
 * Declares / initializes non existing variable
 *
 * @param mixed $value
 * @param mixed $custom
 * @param mixed $replace
 * 
 * @return mixed
 *    ($value empty && $custom defined) => @return $custom
 *    ($value empty && $custom defined && $replace defined) => @return $replace
 *    ($value not initialized && $custom defined && $replace === true) => @return $custom
 */
function setVar( &$value, $custom = '', $replace = false ){

  //check if $value has already been set determining what proceedure to use

  if(isset($value)){

    //if $value has been set before do this:

    if(is_array($value)){

      //if $value is an array do this:

      $newvalue = (empty($value) && $custom !== null)? $custom : $value; //return $custom only if $custom is set and $value is empty array
      
      if($replace){ $value = $newvalue; } //switch supplied $value

      return $newvalue;

    } else {

      //if $value is NOT an array do this:

      $value = trim($value);

      if(!empty($custom) && !is_array($custom)) $custom = trim($custom);  

      return (empty($value) && !empty($custom))? $custom : $value; //return $custom only if $custom is set and $value is empty string

    }


  } else {

    //if $value has not been set before do this:

    if($replace){ $value = $custom; } //switch supplied $value

    return $custom; //return $custom value

  }
}

/**
 * (Spoova 1 &gt;= 1.0.0) <br/>
 * 1. Prepares / Initiaizes a non existing variable <br/>
 * 2. Trims string variables supplied <br/>
 * 3. Returnn $return if $param not initially defined && $return is not empty <br/>
 * 4. similar to setvar function but with little differences
 * 
 * @param mixed $param
 * @param mixed $return alternate value returned if $param no defined
 * @return mixed
 */
function myIsset( &$param, mixed $return = null ){
  if(isset($param)){
    return is_string($param)? trim($param) : $param;
  }elseif(!empty($return)){
    return is_string($return)? trim($return) : $return;
  }
}

/**
 * check if a url string starts with http
 *
 * @param string $url
 * @param boolean $strict determines strictness of validation. 
 *  - FALSE : returns true for both 'https' and 'http'
 *  - TRUE : returns true for only 'http'
 * @return boolean
 */
function isHTTP(string $url = '', $strict = false) : bool {
  if($strict && str_starts_with($url,'https')) return false;
  return (str_starts_with($url,'http') && filter_var($url, FILTER_VALIDATE_URL));
}

/**
 * check if a url string starts with https
 *
 * @param string $url
 * @return boolean
 */
function isHTTPS(string $url) : bool {
  return (str_starts_with($url,'https://') && filter_var($url, FILTER_VALIDATE_URL))? true : false;
}

/**
 * If a trimmed value is not empty, returns another value
 * This act as a proof against empty spaces.
 * 
 * @return mixed
 */
function refil(string $value, mixed $return){
  if( trim($value) ) return $return;
  return $value;
}

/**
 * (Spoova 1 &gt;= 1.0.0) <br/>
 * clean base64_encode without trailing equal sign
 *
 * @param string $string
 * @return string
 */
function base_encode(string $string){
  //clean base64_encode without trailing equal sign
  return  rtrim(strtr(base64_encode($string),'+/','-_'),'=');
}

/**
 * (Spoova 1 &gt;= 1.0.0) <br/>
 * clean base64_decode without trailing equal sign
 *
 * @param string $string
 * @return string
 */
function base_decode(string $string){
  return base64_decode(strtr($string,'-_','+/').str_repeat('=',3-(3+strlen($string))%4));
}

/**
 * Alias for {@see json_encode()}
 * @return string|false
 */
function toJson(mixed $value, int $flags = 0, int $depth = 512) : string|false {
  return json_encode(...func_get_args());
}

/**
 * Shorthand function for decoding a json string
 *  - Note: all stdClass objects are converted to array by default
 *
 * @param string $value JSON string
 * @param boolean $bool associative
 * @param int $depth 
 * @param int $flags
 * @return mixed
 */
function fromJson($value, bool $bool = true, int $depth = 512, int $flags = 0){
  if(func_num_args() > 2){
    $args = func_get_args();
  }else{
    $args = [$value, $bool];
  }
  return json_decode(...$args);
}

if(!function_exists('toSingular')){
  /**
   * Removes trailing letter "s" from a string or array of strings
   *
   * @param array|string $name
   * @return array|string
   */
  function toSingular(array|string $name){

    if(is_array($name)){
      return array_map(function($value){
        return ((strtolower(substr($value, -1)) === 's')? substr($value, 0, strlen($value) - 1) : $value);
      }, $name);
    }
    return ((strtolower(substr($name, -1)) === 's')? substr($name, 0, strlen($name) - 1) : $name);
  }
}

if(!function_exists('toSuffix')){

  /**
   *  Adds a suffix based on minimum threshold value
   *
   * @param array|string $string string to add suffix
   * @param string $suffix string to add suffix
   * @param integer $min minumum threshold of $value before suffix is added to string
   * @param integer $value test value which must be greater than $min before suffix is added
   * @return string
   */
  function toSuffix(string $string, string $suffix, int $min, int $value) : string {
    return $string .= ($value > $min)? $suffix : '';
  }
}

if(!function_exists('enplode')){

  /**
   * Join array element with a string and wrap string within a defined character.
   *
   * @param array|string $separator [optional]
   *  - array should contain two values : a separator, then followed by a wrapper character
   *  - string as separator character
   * @param array|null $array The array of strings to implode
   * @param bool $strict 
   *  A bool of true includes wrapper even if the array is empty 
   *  A bool of false removes wrapper if the array is empty 
   * @return string
   */
  function enplode(array|string $separator="", ?array $array = [], bool $strict = false) : string {
      
    $container = (array) $separator;
    $divider = (string) $container[0];
    $wrapper1 = (string) ($container[1]?? '');
    $wrapper2 = (string) ($container[2]?? $wrapper1);

    if(count($container) > 3){
        trigger_error('maximum array count of 3 for argument(#1)  on enplode() exceeded!');
        return '';
    }

    $implode = implode($divider, $array);

    return ($implode || $strict)? $wrapper1.$implode.$wrapper2 : '';

  }
}

if(!function_exists('trimJoin')){

  /**
   * Join array element with a string and wrap string within a defined character while triming excess spaces.
   *
   * @param array|string $separator [optional]
   *  - array should contain two values : a separator, then followed by a wrapper character
   *  - string as separator character
   * @param array|null $array The array of strings to implode
   * @param bool $strict 
   *  A bool of true includes wrapper even if the array is empty 
   *  A bool of false removes wrapper if the array is empty 
   * @return string
   */
  function trimJoin(array|string $separator="", ?array $array = [], bool $strict = false) : string {
      
    $container = (array) $separator;
    $divider = (string) $container[0];
    $wrapper1 = (string) ($container[1]?? '');
    $wrapper2 = (string) ($container[2]?? $wrapper1);

    if(count($container) > 3){
        trigger_error('maximum array count of 3 for argument(#1)  on enplode() exceeded!');
        return '';
    }

    $implode = implode($divider, $array);

    // remove execess spaces 
    $implode = preg_replace('/\s+/',' ', $implode);

    return ($implode || $strict)? $wrapper1.$implode.$wrapper2 : '';

  }
}


if(!function_exists('inflect')){
  /**
   * Add or remove trailing letter "s" to string 
   * depending on count supplied
   *
   * @param array|string $text
   * 
   * @param int $count 
   * @param boolean|inflect $strict defines extra functionality
   * 
   *  - If $strict is false, a character "s" will only be appended to $text if $count > 1.
   *  - If $strict is true and $count > 1, a character "s" is added to $text only if $text does not have character "s" or "S" as the lasting character.
   *  - If $strict is true and $count < 2, a lasting character "s" or "S" will be removed from $text if it exists, else the supplied $text is returned.
   * 
   * @return array|string
   */
  function inflect(array|string $text, int $count, bool|inflect $strict = false){

    $result = match($strict){

      0, false, inflect::default, inflect::soft => function() use($text, $count) {
        
        $arrText = (array) $text;
          
        if($count != 1){
            $result = $arrText;
        }else{
          $result = array_map(function($value){
            return ((strtolower(substr($value, -1)) !== 's')? $value."s" : $value);
          }, $arrText);        
        }

        return $result;


      },

      1, true, inflect::hard => function() use($text, $count) {

          $arrText = (array) $text;

          if($count < 2){

            $result = array_map(function($value){
              if(is_string($value)) return ((strtolower(substr($value, -1)) === 's')? substr($value, 0, strlen($value) - 1) : $value);
            }, $arrText);
    
          }else{
    
            $result = array_map(function($value){
    
              if( is_string($value) ) {
    
                if((strtolower(substr($value, -1)) !== 's')){
    
                  if( $value === strtoupper($value) ) {
                    
                    return $value."S";
    
                  }else{
                    return $value."s";
                  }
    
                } else{
                  return $value;
                }
    
              }
    
            }, $arrText);        
          } 

          return $result;
  
      },

      inflect::smart => function() use($text, $count) {

        if(!is_array($text)){
          return EInfo::trigger('invalid string argument(#1) supplied for inflect::smart. Argument must be an array.');
        }

        if(count($text) !== 2){
          return EInfo::trigger('invalid array count argument(#1) supplied for <u>inflect::smart</u> flag. Argument must be an array of two counts');
        }

        $singular = $text[0];
        $plural   = $text[1];
        $absCount = abs($count);

        return ($absCount === 1)? $singular : $plural;
        
      },


    };

    return $result();

  }
}

if(!function_exists('toUnitCase')){

  /**
   * Convert a string's unit part to desired case
   *
   * @param string $separator part separator
   * @param string $text
   * @param Closure $callback applied on each part division
   * @return string
   */
  function toUnitCase(string $separator, string $text, Closure $callback) : string {

    $parts = explode($separator, $text);

    $parts = array_map(fn($value) => $callback($value), $parts);

    return implode($separator, $parts);
  }

}

/**
 * Returns the current script name
 * from the basename of $_SERVER["SCRIPT_FILENAME"]
 *
 * @return string
 */
function scriptName(){
  return basename($_SERVER["SCRIPT_FILENAME"] ?? '');
}

/**
 * Encode a string
 * @param string $str
 */
function encodeURIComponent(string $str){
  $revert = array("%21"=>'!','%2A'=>'*','%27'=>"'",'%28'=>'(','%29'=>')');
  return strtr(rawurlencode($str),$revert);
}

/**
 * Fetch the url parameters from a string or current url of a page
 * When no argument is supplied, it assumes the current url of the page
 * 
 * @param undefined $url_link, $url_link = $_SERVER['REQUEST_URI']
 * @param string $url_link custom link to be dissected 
 * @return array  
 */
function UrlParams(string $url_link = ''){
  //get the parameters within a url string or current page
  if(func_num_args() == 0) $url_link = $_SERVER['REQUEST_URI'] ?? '';
  $url = parse_url($url_link,PHP_URL_QUERY);
  parse_str($url, $params);
  return $params;
}

/**
 * Check if a value is within the range of two numbers
 *
 * @param int $value
 * @param int $min
 * @param int $max
 * @return boolean
 */
function inRange($value, $min, $max): bool {
  //check if a value is in range of two numbers
  return (($min <= $value) && ($value <= $max)); 
}

/**
 * 1. checks for empty values in either arrays or single values to return either true or false
 *  
 * @param mixed $var
 * @param mixed $inclusion value to be assumed as empty values
 * @return boolean
 */
function is_empty( $var, mixed $inclusion = null ){

   $inclusion = (array) $inclusion;

   if(!is_array($var)){
      $var = trim($var);
      if(($var == null) || ($var == '') || (empty($var)) || in_array($var,$inclusion)){
        return true;
      }
      return false;
   }else{
     foreach($var as $val){
      if(!is_array($val)){ $val = trim($val); }
      if(($val != null) && ($val != '') && (empty($val)) && in_array($val, $inclusion)){
          return false;
      }
     } 
     return true;
   }

}

/**
 * Reverse of {@see \is_empty()}
 *
 * @param mixed $var
 * @param mixed $inclusion
 * @return boolean
 */
function not_empty($var, mixed $inclusion = null) : bool {

  $inclusion = (array) $inclusion;

   if(!is_array($var)){
      $var = trim($var);
      if(($var != null) || (empty($var) && in_array($var, $inclusion, true))) return true;
      return false;
   }else{
     foreach($var as $val){
      if(!is_array($val)){ $val = trim($val); }
      if((empty($val) && in_array($val, $inclusion, true)) || ($val != null)) return true;
     } 
     return false;
   }

}

/**
 * compares a list of arguments supplied if they match
 *
 * @mixed $args arguments may be two or more
 * @return boolean
 */
function compare( $arg1 = '', $arg2 = '' ) : bool {

  $args  = func_get_args();

  return (count(array_unique($args)) === 1);
}


/**
 * Create a random hashed key with a minimum length of 2
 *
 * @param integer $length length of hash key to be generated
 * @param string $keyspace keys to be used for hashing
 * @return string
 */
function randice(int $length = 4, ?string $keyspace = null){ 
  if($length < 1) { return false; }

  if(func_num_args() < 2){
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  }
  $pieces = [];
  $max = mb_strlen($keyspace, '8bit') - 1;
  for ($i = 0; $i < $length; ++$i) {
      $pieces []= $keyspace[rand(0, $max)];
  }
  return implode('', $pieces);      
} 

/**
 * checks if a path is absolute
 *
 * @param string $path
 * @return boolean
 */
function isAbsolutePath(?string $path = null) : bool {
  if (!is_string($path)) {
      return false;
  }
  if (!ctype_print($path)) {
     return false;
  }
  // Optional wrapper(s).
  $regExp = '%^(?<wrappers>(?:[[:print:]]{2,}://)*)';
  // Optional root prefix.
  $regExp .= '(?<root>(?:[[:alpha:]]:/|/)?)';
  // Actual path.
  $regExp .= '(?<path>(?:[[:print:]]*))$%';
  $parts = [];
  if (!preg_match($regExp, $path, $parts)) {
      return false;
  }
  if ('' !== $parts['root']) {
      return true;
  }
  return false;
}

//-------------------------------ARRAY FUNCTIONS

/**
 * Checks if an array exists inside another array
 *
 * @param array $value
 * @return bool
 */
function arrInside(array $value) : bool{
  foreach ($value as $val) {
    if(is_array($val)) return true;
  }
  return false;
}

/**
 * Returns true if an array is empty after trimming
 * and removing empty keys
 * 
 * @param array|string[] $data
 * @return boolean
 */
function arrVoid($data) : bool {
  //returns true if an array is empty after removing empty values
  if(func_num_args()>1){
    $data = func_get_args();
  }
  array_trim($data);
  $data = array_unset($data,"");
  if(count($data) == 0){
    return true;
  }else{
    return false;
  }
}

/**
 * Returns true if at least one value of 
 * an indexed or associative array is empty.
 * All values are trimmed before testing
 *
 * @param array|string[] $data
 * @return boolean
 */
function arrGetsVoid($data) : bool {  
  //returns true if an array $data contains at least one empty value
  $args = func_num_args();
  if($args > 1) $data = func_get_args();
  $data = (array) $data;

  foreach($data as $key => $value){
    if(is_string($value))  $value = trim($value);
    if(!$value){
      return true;
    }    
  }
  return false;
}

/**
 * Trims an entire array by reference
 *
 * @param array $array referenced array
 * @return array
 */
function array_trim(array &$array): array{
  $nArray = array();
  foreach($array as $data => $value){
       if(is_array($value)){
          $ndata = $value;
          array_trim($value);
       }else{
         $ndata = trim($value);
       }
       $nArray[$data] = $ndata;
  }
  $array = $nArray;
  return $array;    
}

/**
 * Returns the value of an array key if that array key exists 
 * This should not be used to test array containing bool(false) values .
 *
 * @param array $array
 * @param string $arraykey
 * @return mixed
 */
function array_get(array $array, string $arraykey = ''){
  return array_key_exists($arraykey, $array)? $array[$arraykey] : false;
}

/**
 * Converts an array to object format recursively while 
 * other data types are returned in their supplied form.
 *  - spoova modified function 
 * 
 * @param array $array
 * @return string|int|float|bool|stdClass
 */
function array_object($array) {   
  
  if(is_array($array)){
    $newarray = new stdClass();
    foreach($array as $array_keys => $array_vals){
      $newarray->$array_keys = array_object($array_vals);
    }    
  }else{
    $newarray = $array;
  }

  return $newarray;

}

/**
 * Converts an array to object format
 *  - spoova modified function
 * @param array $array
 * @return stdClass
 * @uses array_object()
 */
function toStdClass(array $array) : stdClass {   
  return array_object($array);
}

/**
 * This trims, then removes empty strings from supplied array
 *  - spoova modified function 
 * 
 * @param array   $param
 * @param boolean $sort true return indexed array, false keeps array keys
 * @return array 
 */
function arrSort(array $param, $sort = false ){

  foreach($param as $arrVal => $subVal){
    $subVal = is_array($subVal)? $subVal : trim($subVal);
    if($subVal != ""){ 
      $array[$arrVal] = $subVal;
    }
  }

  $param = ($array)? $array : $param;
  $param = ($sort === true)? array_values($param) : $param;
  return $param;

}

/**
 * This function is used to regroup multiple file uploads $_FILE 
 * For two dimentional arrays of equal values
 * 
 * - SAMPLE ARRAY FORMAT:
 *   ```$_FILES['name'][0], $_FILES['tmp'][0]; ```
 *   ```$_FILES['name'][1], $_FILES['tmp'][1]; ```
 * 
 * - SAMPLE RESULT FORMAT: 
 *   ```$_FILES[0]['name'], $_FILES[0]['tmp']; ```
 *   ```$_FILES[1]['name'], $_FILES[1]['tmp']; ```
 * 
 *
 * @param array $item
 * @return array
 */
function reItemize(array $item): array {
  //for file(s) supply $_FILES[name]
  $box = array();
  foreach ($item as $key => $values) {
    if(is_array($values)){
      foreach ($values as $value => $subvalue) {
        
        if(is_array($subvalue)){ 
          $box[$key] = reItemize($values);
          break;
        }else{
          $box[$value][$key] = $subvalue;
        }
      }
    }
  }
  return $box;
}

/**
 * Returns the number of array values
 *  - spoova modified function
 * @param array $param
 * @return array|bool(false)
 */
function array_count($param){
  //count array values
  if(isset($param) && is_array($param)){
    return array_count_values($param);
  }
  return false;
}

/**
 * Deletes the first index of a value from an array
 *  - spoova modified function 
 * 
 * @param array  $array
 * @param mixed  $value
 * @return array
 */
function array_delete(array $array, $value){  
  return Arr::delete($array, $value);
}

/**
 * Removes the all keys having a declared value from an array
 *  - spoova modified function
 * @param array  $array
 * @param string $value
 * @param bool $series
 *  - If set as true and $value is array, $value will be assumed
 *    to be a container of values expected to be removed. This is useful when 
 *    removing multiple values from $array
 * @return array
 */
function array_unset(array $array, $value, bool $series = false) : array {
  return Arr::unset(...func_get_args());
}   

/**
 * Combines a string or array into the second defined array variable
 *  - spoova modified function 
 * @param string|array $array1
 * @param array        $array2
 * @return array
 * 
 */
function combine($array1, array &$array2){
  //combine $array2 and $array1 into $array2
  $array1 = (array) $array1;

  foreach($array1 as $value){
    $array2[] = $value;
  }
}  

// ---------------------------------------------------------------- Script functions

/** 
 * Javascipt powered function for testing purposes.
 *
 * @param array|string $value
 * @return string
 */
function alert( $value = '' ){

  $val = (is_array($value) || is_dir($value))? json_encode($value) : $value;
  $format = "<script> alert('".$val."') </script>";
  echo $format;

}

/**
 * Javascipt powered browser console function for testing purposes.
 *  - spoova modified function
 * 
 * @param array|string[] $vals
 * @return string
 */
function javaconsole( $vals = [] ){

  if(func_num_args() > 1){
    $vals = func_get_args();
  }else{
    $iVal  = $vals; $vals = [];
    $vals[] = $iVal;
  }

  if(isCli()){
    foreach($vals as $val){
     print_r($val);
    }
  }else{
    $format = "<script>";
    foreach($vals as $val){
     $format .= "console.log(".json_encode($val).") \n";
    }
    $format .= "</script>";   
    echo $format; 
  }


}

/**
 * Javascipt powered function for testing scripts.
 *  - spoova modified function
 * 
 * @param string  $text, javascript url or javascript text
 * @param boolean $print print directly
 * @return string 
 */
function script( string $text, bool|int $print = false ){

  $isSrc = ( filter_var($text, FILTER_VALIDATE_URL) || isAbsolutePath($text) );

  if($isSrc)
  {

    $script = '<script src="'.$text.'"></script>';

  } else 
  {
     $script = '<script>'.$text.'</script>';
  }

  $print = (int) $print;

  if($print) echo $script; return ;
  return $script;

}


/**
 * Simple function to Replace angle brackets to &gt; and &lt; in a string
 *  - spoova modified function 
 * 
 * @param string $item
 * @return string
 */
function to_lgts(string $item){ 
  return str_replace('>', '&gt;', str_replace('<', '&lt;', $item));
}

/**
 * Convert all urls in a string to clickable links having classes 'ref-link'
 * Output is stored in the defined wrapper (tag) which can contain attributes
 *  - spoova modified function 
 * 
 * @param string $input
 * @param string $wrapper
 * @param boolean $track FALSE disables overidding active URL pointer.
 * 
 * @return string
 */
function href(string $input, string $attrs = '', bool $track = true){ 
  //replace a url within a string with link

  $hrefData = explode('::',$input, 2);
  $name = ''; $named = false; $link = $input;

  if(count($hrefData) === 2){
    $name = $hrefData[0];
    $link = $hrefData[1];
    $named = true;
  }

  $link = domUrl($link, $track);
  
  $pattern = '~(http(s)?://)(([a-zA-Z0-9])([:\w+]+)([^\s\.]+[^\s]*)+[^,.\s])~';

  $attribs = Attribs::split($attrs);

  $output = preg_replace_callback($pattern, function($matches) use($name, $named, $attribs){

    $name = ($named) ? $name : $matches[0];  
    $secure = $matches[2];
    $link = $matches[3];

    return "<a href='http$secure://$link'$attribs>$name</a>";

  }, $link);

  return $output;
}

/**
 * Truncates the words in a text to defined limit and appends suffix ...
 *  - spoova modified function 
 * 
 * @param string $text
 * @param int    $limit
 * @return string
 */
function limitText( string $text, $limit ) : string {
  //limits the number of words in $text to $limit
  if(str_word_count($text,0) > $limit){
    $words = str_word_count($text,2);
    $pos   = array_keys($words);
    $text  = substr($text, 0, $pos[$limit]). "...";
  }
  return $text;
}

/**
 * Truncates characters in a text to defined limit and appends suffix ...
 *  - spoova modified function 
 * 
 * @param string $string text whose character's is to be limited.
 * @param int $limit limit to be applied
 * @return string
 */
function limitChars(string $string, int $limit){

  $oldstring = trim( $string );
  $strlen = strlen( $oldstring );
  $remlen = $strlen - $limit;

  $newstring = substr( $oldstring , 0, $limit );   //string characters limit
  $strwords1 = str_word_count( trim($oldstring) ); //words count in original text
  $strwords2 = str_word_count( trim($newstring) ); //words count in final text

  //check if string 1 and 2 does not have same length 
  if($strwords1 != $strwords2){

    $expOld = explode( ' ', $oldstring ); 
    $expNew = explode( ' ', $newstring );    
    $expOldText = $expOld[ $strwords2 - 1 ] ?? '';  //get last word of old string supplied
    $expNewText = $expNew[ $strwords2 - 1 ] ?? '';  //get last word of new string generated

    $oldStrlen = strlen( trim($expOldText) );
    $newStrlen = strlen( trim($expNewText) );

    $extraCount = ($oldStrlen - $newStrlen);

    if( $extraCount < 3 && $extraCount > 0 )
    {

      $expNew[ count($expNew) - 1 ] = $expOldText;
      $string = implode( ' ', $expNew ).'...';

    } else if( $oldStrlen > 2 && $newStrlen < 3)
    {

      unset( $expNew[count($expNew) - 1] );
      $string = implode(' ', $expNew).'...';

    }else
    {
      $string = $newstring.'...';
    }

  }
  return $string; //return the original text

  if( strlen($string) > $limit ){
    $string  = substr( $string, 0, $limit )."...";
  }
  return $string;
}

/**
 * Complex function that truncates the characters of a string to a better $length
 *  - spoova modified function 
 * 
 * @param string $string text to be truncated
 * @param int|string|null $length numeric length
 * @return string
 */
function limitWord(string $string, int|string|null $length = null) : string {
  
  $textString = '';
  $length = ($length == null)? 30 : $length;
  $length2 = $length + 5;    
  $wordexplode = explode(' ',$string);
  $string  = substr($string,0,$length2);

  if($string != null){
      
    $newstring = explode(' ',$string);

    if(count($wordexplode) == count($newstring)){
      for($i=0; $i<count($newstring); $i++){
         if($i == $length){
             break;
         }else{
          $textString .= $newstring[$i].' ';
         }
         $buildexplode = explode(' ',$textString);
         $buildexplode = array_delete($buildexplode,'');
      }   
    }else{
      if(count($newstring)>1){
        for($i=0; $i<count($newstring)-1; $i++){
          if($i == $length){
            break;
          }else{
            $textString .= $newstring[$i].' ';
          } 
        }  
      }else{   
        for($i=0; $i<count($newstring); $i++){
          if($i == $length){
              break;
          }else{
           $textString .= $newstring[$i].' ';
          }
        }       
      }
      $buildexplode = explode(' ',$textString);
      $buildexplode = array_delete($buildexplode,''); 
    }
      
    if(count($wordexplode) > count($buildexplode)){
      $textString .= '...';
    }
  }
  return $textString;
}

/**
 * Checks if a value is integer and also a number
 *  - spoova modified function 
 * 
 * @param mixed $value
 * @return bool
 */
function validateNumber($value) : bool {
  //returns true for a valid an integer
  return ( (!is_nan($value)) && (is_int($value)) );
}   

//----------------------------------------------------------------------------------------------

require_once 'secure.php';
?>
