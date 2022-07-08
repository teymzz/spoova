<?php

/* Custom stand-alone functions */

/**
 * prints a break tag or PHP_EOL to the page
 * All arrays are converted to json format
 *
 * @param mixed $var
 * @param int   $break
 * @return string
 */
function br($var = null, int $break = 1) : string { 

  $var = is_array($var)? json_encode($var) : $var;

  //isCli is defined in settings
  $br = isCli() ? PHP_EOL : "<br>";

  return $var.str_repeat($br, $break);
  
}

/**
 * variable dump 
 * @param mixed $var
 */
function vdump($var){

  ini_set('xdebug.var_display_max_depth', -1);
  ini_set('xdebug.var_display_max_children', -1);
  ini_set('xdebug.var_display_max_data', -1);

  $style = '
    display: inline-block;
    word-break: break-word;
    color: #3b4664;
    background: rgba(238, 238, 238, 0.9); 
    float:left; width:97%; 
    padding: 1em;
    overflow-x: auto;
    max-height: 94vh;
  ';
  
  print '<div style="'.$style.'">';
  var_dump($var);
  print "</div>";
  die();
}

/**
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
function setVar( &$value, $custom = null, $replace = false ){

  //check if $value has already been set determining what proceedure to use

  if(isset($value)){

    //if $value has been set before do this:

    if(is_array($value)){

      //if $value is an array do this:

      $newvalue = (empty($value) && $custom != null)? $custom : $value; //return $custom only if $custom is set and $value is empty array
      
      if($replace){ $value = $newvalue; } //switch supplied $value

      return $newvalue; //return $newvalue

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
 * 1. Prepares / Initiaizes a non existing variable
 * 2. Trims string variables supplied
 * 3. Returns @param $return if $param not initially defined && $return is not empty
 * 4. similar to setvar function but with little differences
 * 
 * @param mixed $param
 * @param  $return
 * @return void|mixed
 */
function myIsset( &$param, $return = null ){
  if(isset($param)){
    return is_array($param)? $param : trim($param);
  }elseif(!empty($return)){
    return is_array($return)? $return : trim($return);
  }
}

/**
 * check if a string starts with http
 *
 * @param string $url
 * @return boolean
 */
function isHTTP(string $url = ''){
  return (substr($url, 0, 4) == 'http' && filter_var($url, FILTER_VALIDATE_URL));
}

/**
 * check if a string starts with https
 *
 * @param string $url
 * @return boolean
 */
function isHTTPS(string $url){
  return (substr($url, 0, 5) == 'https' && filter_var($url, FILTER_VALIDATE_URL))? true : false;
}

/**
 * If a trimmed value is not empty, returns another value
 * This act as a proof against empty spaces.
 * 
 */
function refil($value, $return){
  if( trim($value) ) return $return;
  return $value;
}

/**
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
 * clean base64_decode without trailing equal sign
 *
 * @param string $string
 * @return string
 */
function base_decode(string $string){
  return base64_decode(strtr($string,'-_','+/').str_repeat('=',3-(3+strlen($string))%4));
}

/**
 * Shorthand function for json_encode
 *
 * @param mixed $args argument accepted by json_encode
 * @return void
 */
function toJson($args){
  return json_encode(...func_get_args());
}

/**
 * Shorthand function for converting json to array
 * 
 * @notice All std are converted to array by default
 *
 * @param mixed $args argument accepted by json_encode
 * @return void
 */
function fromJson($value, $bool = true){
  if(func_get_args() > 2){
    $args = func_get_args();
  }else{
    $args = [$value, $bool];
  }
  return json_decode(...$args);
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
 * get defined constant's value from string
 *
 * @param string $core
 * @return string
 */
function getDefined(string $core){
  return defined($core)? constant($core) : '';
}

/**
 * Spoova redirection function (using declared constants)
 * Redirects a page using php header or javascript window.location
 * Javascript redirection may be needed when an output is already set
 * When no url is set , redirects to current page
 *
 * @param string $url
 * @param string $type java as javascript redirection
 * @return void
 */
function redirect( string $url = '', string $type = 'header' ){

  if($url == '') {
    $loc = $_SERVER['PHP_SELF'];
  }else if($url != ''){

    $isOffline = defined('online') ? !online : false;

    $url = ($url == "/" && $isOffline)? '' : $url;

    if(!in_array($url, ['uri', 'self', 'this'])){
        
        if(isHTTP($url)){
          $eUrl = $url;
        } else {
          $eUrl = str_replace("//","/",getDefined('docroot').DS.$url);
          if(!file_exists(pathinfo($eUrl,PATHINFO_DIRNAME))){ 
            return false;
          }
        }

    }

    $type = ($type === 'header')? $type : 'java';

    $self  = $_SERVER['PHP_SELF'];
    $rqUri = $_SERVER['REQUEST_URI'];
    $scUri = $_SERVER["SCRIPT_URI"]?? '';

    if($url == 'self') $loc  = $self?? ''; //redirect to self
    if($url == 'this') $loc  = $rqUri?? ''; //redirect to current uri
    if($url == 'uri') $loc = $scUri?? $rqUri;

    $loc = !isset($loc)? (isHTTP($url)? $url : getDefined('srcRoot').$url) : $loc; 

    $query = explode( "?", $loc );
    $loc = array_get( $query, 0 );          
    $linkquery = array_get( $query, 1 );

    $linkquery = ($linkquery != null)? "?".$linkquery : null;

    $pathExt = pathinfo($loc, PATHINFO_EXTENSION);
    if($pathExt == "php" && getDefined('fext') == ""){
      $loc = str_replace(".php", "", $loc);
    }elseif($pathExt == "" && strtolower(getDefined('fext')) === ".php"){
      $loc .= ".php";
    }

    $loc .= $linkquery;

  }
  
  if($type === "header"){
    header("location: $loc");
  }else{
    echo " <script> window.location  = '$loc' </script> ";
  }
  
}

/**
 * redirect to another page using header Location
 *
 * @param string $url
 * @return void
 */
function redirectTo(string $url){
  header("location: ".$url);
}

/**
 * This function enables a standard structure 
 * for building ajax responses. The json string returned 
 * (by default) is based on error codes unless the behaviour
 * is modified by a third argument. All 4xx and 5xx responses 
 * by default sets the error index as true and success as false
 * unless a third argument is supplied to overide this behaviour
 *  
 * @param int   $code header code (e.g 404, 301) 
 * @param mixed $message custom response message. 
 * @param bool  $success sets the error or success index key of json text. 
 *              -when set as true returns ['success' => true, 'error' => false]
 *              -when set as false returns ['success' => false, 'error' => true]
 * @return string json response 
 *         
 */  
function response($code = 0, $message, bool $success = false) : string {
  
  // accept only numeric strings
  if(!is_numeric($code)){
    trigger_error('first argument must be of numeric value!');
    return '';
  }

  //convert negative integers to positive
  $code = abs($code);
  
  $headercodes = [1, 2, 3, 4, 5];
  $headercode  = substr($code, 0, 1); //get first number     
  
  $error = true;
  $addheader  = false;
  $response   = [];
  
  //convert header code to integer
  $headercode !== 0 ? floor(log10($code) + 1) : 1;

  if(in_array($headercode, $headercodes))
  {
    //default responses
    $addheader  = true;
    
    if($headercode === '1') {
      $error = false;
    } elseif ($headercode === '2') {
      $error = false;
    } elseif ($headercode === '3') {
      $error = false;
    } elseif ($headercode === '4') {
      $error = true;
    } elseif ($headercode === '5') {
      $error = true;
    }
    
  } elseif ($code === 0) {
      $error = true;
  }
  
  //set valid response header
  if ($addheader) http_response_code($code);
  
  if(func_num_args() < 3) {
      //modify success message with response code
      $success = !$error;
  }
  
  //set array of response
  if(func_num_args() > 1) {
    
    $response = [
      'success' => $success, 
      'error'   => !$success, 
      'message' => $message, 
      'response_code' => $code,
      ];
    
  }
  
  return json_encode($response);
  
}

/**
 * 1. checks for empty values in either arrays or single values to return either true or false
 *  
 * @param mixed $var
 * @param mixed $inclusion value to be included as part of null
 * @return boolean
 */
function is_empty( $var, $inclusion = null ){

  //$inclusion should contain array of values to be counted as empty strings

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
 * Reverse of @see is_empty()
 *
 * @param mixed $var
 * @param mixed $inclusion
 * @return boolean
 */
function not_empty( $var, $inclusion = null ){
  return is_empty($var)? false : true;
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
 * @return void
 */
function randice(int $length = 4, string $keyspace = null){ 
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
function isAbsolutePath(string $path = null) : bool {
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
 * @return void
 */
function arrInside(array $value) : bool{
  //check if array exists inside another $value
  foreach ($value as $arrVal => $val) {
    return is_array($val);
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
 * Converts an array to object format
 * @param array $array
 * @return array
 */
function array_object(array $array){   
  
  $newarray = new stdClass();
  foreach($array as $array_keys => $array_vals){
     $newarray->$array_keys = $array_vals;
  }
  return $newarray;

}

/**
 * This trims, then removes empty strings from supplied array
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
 * An array:
 *  $_FILES['name'][0] = 'fileName1';
 *  $_FILES['name'][1] = 'fileName2';
 * 
 * Becomes: 
 *   $_FILES[0]['name'] = 'fileName1';
 *   $_FILES[1]['name'] = 'fileName2';
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
 *
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
 *
 * @param array  $array
 * @param mixed  $value
 * @return array
 */
function array_delete(array $array, $value){  
  $val = array_search($value,$array);
  unset($array[$val]);
  return $array;
}

/**
 * Removes the all keys having a declared value from an array
 *
 * @param array  $array
 * @param string $value
 * @return array
 */
function array_unset($array,$value){
  //unsets all indices of $value in $array  
  if(!is_array($array)){ return false; }  

  foreach ($array as $key => $val) {
    if($val == $value){
      unset($array[$key]);
    }
  }
  return $array;  
}   

/**
 * Combines a string or array into the second defined array
 *
 * @param string|array $array
 * @param array        $array2
 * @return void
 * 
 */
function combine($array, array &$array2){
  //combine $array2 and $array and sets combined value in $array2
  $array = (array) $array;
  $combiner = array_combine($array2,$array);
  $array2 = $combiner ;
}  

// ---------------------------------------------------------------- Script functions

/** 
 * For testing purposes
 * javascript alert. To be used within html body
 *
 * @param string 
 * @param array
 * @return void
 */
function alert( $value = null ){
  $val = (is_array($value) || is_dir($value))? json_encode($value) : $value;
  $format = "<script> alert('".$val."') </script>";
  echo $format;
}

/**
 * For testing purposes
 * prints a detail in the javascript browser console
 *
 * @param array|string[] $vals
 * @return void
 */
function javaconsole( $vals = [] ){

  if(func_num_args() > 1){
    $vals = func_get_args();
  }else{
    $iVal  = $vals; $vals = [];
    $vals[] = $iVal;
  }

  $format = "<script>";
  foreach($vals as $val){
   $format .= "console.log(".json_encode($val).") \n";
  }
  $format .= "</script>";   
  echo $format; 

}

/**
 * For testing purposes
 * Adds a javascript tag to a page 
 *
 * @param string  $text, javascript url or javascript text
 * @param boolean $ready
 * @return string 
 */
function script( string $text, $ready = false ){

  $isSrc = ( filter_var($text, FILTER_VALIDATE_URL) || isAbsolutePath($text) );

  if($isSrc)
  {

    $script = '<script src="'.$text.'"></script>';

  } else 
  {
     $script = '<script>'.$text.'</script>';
  }

  $ready = (int) $ready;

  if($ready) echo $script; return ;
  return $script;

}


/**
 * Simple function to Replace angle brackets to &gt; and &lt; in a string
 *
 * @param string $item
 * @return void
 */
function to_lgts(string $item){ 
  return str_replace('>', '&gt;', str_replace('<', '&lt;', $item));
}

/**
 * Convert all urls in a string to clickable links having classes 'ref-link'
 * Output is stored in the defined wrapper (tag) which can contain attributes
 * 
 * @param string $input
 * @param string $wrapper
 * 
 * @return void
 */
function href(string $input, string $wrapper = 'span'){ 
  //replace a url within a string with link
  $pattern = '@(http(s)?://)(([a-zA-Z0-9])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
  $output = preg_replace($pattern, "<a href='http$2://$3' class='ref-link'>$0</a>", $input);
  $wrapper = $wrapper? ['<'.$wrapper.'>', '</'.explode(" ", $wrapper)[0].'>'] : ['', ''];
  return $wrapper[0].$output.$wrapper[1];
}


/**
 * Strip the last slashes of a specific string
 *
 * @param string $var
 * @return string
 */
function striplastSlash(string $var){
  if(substr($var, -1)=='\\' || substr($var, -1)=='/'){
    $var = substr($var, 0,-1);
    if(substr($var, -1)=='\\' || substr($var, -1)=='/'){
      $var = striplastSlash($var);
    }
   return $var;
  }  
  return $var;
} 

/**
 * Truncates the words in a text to defined limit and appends suffix ...
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
 *
 * @param string $text
 * @param int    $limit
 * @return string
 */
function limitChars( $string, $limit ){

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
    $expOldText = $expOld[ $strwords2 - 1 ];  //get last word of old string supplied
    $expNewText = $expNew[ $strwords2 - 1 ];  //get last word of new string generated

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
 *
 * @param string $string Text to be truncated
 * @param int    $length
 * @return void
 */
function limitWord( string $string, $length = null ){
  
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
 * Checks if a number is integer and also a number
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
