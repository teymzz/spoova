<?php

namespace spoova\core\classes;

/**
 * Generates different hash types.
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
 */
class Hasher{
  
  private $hashFunc = []; //hash functions: md5, base_encode, sha1, bson_encode, custom functions with single parameters
  protected $credentials;
  private $hashKey; 
  private $hashcounter = 0;
  private $randomize   = false;
  private $random      = null;
  private $process     = false;
  private $fixedHashes = ["1a2b3c","4b5c6d","5a6d7e","8d9e0f","1a4b5d",
                          "8d1a2e","5c6a9b","5b2a3e","6c7d0e","2c5a6e"];
  private $keySpace    = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  private $keyLength   = 6;   
  private $hashed;
  
  /**
  * sets data to be hashed
  *
  * @param array|string $credentials data to be hashed
  * @param string  $hashKey an anonymous key to be used hash $credentials 
  * @return void
  */
  public function setHash($credentials, $hashKey = null){
    $this->credentials = (array) $credentials;
    $this->hashKey = $hashKey;

    if(is_array($credentials)){
      $this->process = true;
    }else{
      $this->process = false;
    }
  }

  /**
  * This method uses a defined text string or time() to create a dynamic hash string 
  *
  * @param boolean $random 
  *   @$random == bool (true) randomize hash with time();
  *   @$random == bool (false) unset randomization
  *   @$random != bool use supplied value to generate hash key
  * @return void
  */
  public function randomize($random = true){
    
    if($random !== false){
      $this->randomize = true;
      if($random === true){
        $this->random = time();
      }else{
        $this->random = $random;
      }
    }else{
        $this->randomize = false;
        $this->random = null;
    }
  }

  /**
  * supplies string or array lists of hashing algo(s) to be used for hashing 
  * nb: consider supplying few algos name when using this method to save memory reponse
  *
  * @param array $hashFuncs
  * @return void|false
  */
  public function hashFunc($hashFuncs = []){
    
    $hashFuncs =  (array) $hashFuncs;
    $hashes = []; 

    foreach ($hashFuncs as $hashFunc) {
      if(function_exists($hashFunc)){
          $hashes[] = $hashFunc;
      }else{
        return false;
      }
    }

    $this->hashFunc = $hashes;

  }
  
  /**
  * Executes the hashing process
  *
  * @param int|bool|array  $param1
  *       @ $param1 == (int > 0) => number of times for hashing
  *       @ $param1 == (int = 0) => reset hash and return first hash  
  *       @ $param1 == (array | string) => list of hashing algorithms
  * 
  * @param int $param2
  *       @ $param2 == (int > 0) => number of times for hashing
  *       @ $param2 == (int = 0) => reset hash and return first hash 
  *
  * @return string
  *     
  */
  public function hashify($param1 = true, int $param2 = null){
      if($this->process == false){ return false; }

      $args = func_get_args();

      $argsCount = func_num_args();

      if($argsCount == 1){
        $argVal = $args[0];
      
        if(is_int($param1) || is_bool($param1)){
          $val = (int) $argVal; //arg => int number of times for rehashing
        }else{
          $funcs = $argVal; //arg => functions e.g md5, sha1
        }
        
      }elseif($argsCount > 1){
        $funcs = $args[0]; //arg 1 => functions e.g md5, sha1
        $val = $args[1]; //arg 2 => int number of times for rehashing
      }else if($argsCount == 0){
        $val = 1;
      }

      $val = !isset($val)? false : $val;
      $funcs = !isset($funcs)? false : $funcs;


      if($val === 0){ $this->hashcounter = 0; }
      if($funcs !== false){ $this->hashFunc($funcs); }

      if($val === 0){
          $this->hashcounter = 0;
          $nval = $this->runHash();
          $this->hashcounter = 0;         
      }else{
        for($i = 0; $i < $val; $i++){
          $nval = $this->runHash();
        }  
      }

      return $nval; 
  }

  private function runHash(){ 
    
    $hashList = ""; 
    $hashFuncs = $this->hashFunc;
    $credentials = $this->credentials;
    array_unshift($hashFuncs,'sha1');

    //hash all credentials
    $credo = implode("",$credentials);
    $shacredo = $credo != null? substr(sha1($credo), 0, 2) : strlen($credo) % 3;


    foreach ($credentials as $keys => $credential) {
    $credential = md5($credential);
    $prefix     = substr($credential, 0, 1);
    $hashList  .= $prefix.$this->hashGen($credential);
    }

    $random = $this->random;
    $hashKey = $this->hashKey;

    $hashed = $this->reBaseEncode($shacredo.$hashList.substr(md5($hashKey), 0, 4).$random);

    foreach ($hashFuncs as $hashFunc) {
    $hashed = $hashFunc($hashed);
    }
    
    return $hashed; 
  } 

  /**
  * generate an independent quick random hash string
  *
  * @param int $length length of hash
  * @param string $key specific characters from which hash key should be generated
  * @param string $hashAlgos any hashing algorithm
  * @return string
  */
  public function randomHash($length = null, $key = null, $hashAlgos = null) : string {
    
    if($key != null){ $this->keySpace = $key; }

    $length = (int)$length;

    if($length > 1){ $this->keyLength = $length; }
    return $this->randomGen($hashAlgos);

  }

  private function reBaseEncode($string){
    return rtrim(strtr(base64_encode($string),'+/','-_'),'=');
  }

  private function hashGen($value){

    $fixedHashes = $this->fixedHashes; //hashes
    $hashPoint = $this->hashcounter; //hash key length pointer
    $hashIndex = strlen($value) % 9;  //value id  
    $hashWord  = isset($fixedHashes[$hashIndex]) ? $fixedHashes[$hashIndex] : $fixedHashes[0]; 

    $hashValue = substr($value, 0, 2);
    $hashText  = substr($hashWord, $hashPoint, 2); 

    $hash = substr(sha1($hashValue.$hashText),$hashPoint,2); 

    //reset counter
    $this->hashcounter = $hashPoint + 2;
    return $hash;  
  }

  private function randomGen($hashAlgos){

    $length = $this->keyLength;
    $keyspace = $this->keySpace;  
    if ($length < 1) {
      return false;
    }
    //custom hashing
    if(!empty($hashAlgos)){
      if(!is_array($hashAlgos)){ $hashAlgos = (array) $hashAlgos; }
      $hashAlgos = $hashAlgos;
      $keyspace .= time();
      foreach ($hashAlgos as $algo) {
        if(function_exists($algo)){
          $keyspace = $algo($keyspace); 
        }else{
          return false;
        }
      }
      return $keyspace;
    }

    
    //auto hashing
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[rand(0, $max)];
    }
    return implode('', $pieces);
  }

}

/**
 * $Hasher = new \core\classes\Hasher; //initiate class
 *
 * //advanced hashing method (1)
 * $Hasher->setHash(['temitope',"adeola"],'ades9e72'); //set usable paramaters
 *   ['temitope',"adeola"] => array of values to be hashed
 *  'ades9e72' => defined key to be used for hashing
 *
 * $Hasher->randomize(true|false|randomText); // randomize result - {optional}
 *  @param => true (use time()) | false (null) | custom text {if method called, default is true}
 *
 * $Hasher->hashFunc("sha1");  // optional, set hashtype.  { $Hasher->hashFunc(["sha1",...]) }
 *  @param => function(s) to be used for hashing
 *
 * print $Hasher->hashify(); //run/excute hash process
 *
 * //quick hashing method (2)
 *
 * print $Hasher->randomHash(50); //generate a random hash with 50 characters
 *
 * print $Hasher->randomHash(50,$value); //generate a random hash with 50 characters from value
 *
 * print $Hasher->randomHash('',$value,$algos); //generate random chars from value using algos (e.g sha1) + time
 *
 */

 #EXAMPLE 1 (NOT RANDOM)

 // $Hasher->setHash([$username,$password],'1234');
 // $Hasher->hashFunc(['sha1','md5']);  // optional set function(s) to use for hashtype
 // $Hasher->hashify(); //run process and return hashed value

 #EXAMPLE 2 (RANDOM)

 // $Hasher->setHash([$username,$password],'1234');
 // $Hasher->randomize(); // randomize (use time())
 // $Hasher->hashFunc("sha1");  // optional, set function(s) to use for hashtype
 // $Hasher->hashify(); //run process and return hashed value
 
 #EXAMPLE 3 (UNIQUE RANDOM)

 // $Hasher->setHash([$username,$password],'1234');
 // $Hasher->randomize('mystring'); // randomize (use "mystring") 
 // $Hasher->hashFunc("sha1");  // optional, set function(s) to use for hashtype
 // $Hasher->hashify(); //run process and return an hashed value; //start hash, return first hashed value
 // $Hasher->hashify(); //second hash value , return second hashed value;
 // $Hasher->hashify(0); //reset process, returns the first hashed value;
 // $Hasher->hashify(); //restart hash, return first hashed value;
 // nb: randomize(false); // will only disallow inclusion of supplied parameter  

 #EXAMPLE 4 (QUICk RANDOM)
 // $Hasher->randomHash(50); //generate 50 chars random Text
 // $Hasher->randomHash(50,$value); //generate a random hash with 50 characters using characters in $value supplied
 // $Hasher->randomHash("",$value,['sha1','md5']); //generate random hash for value supplied using functions + time 