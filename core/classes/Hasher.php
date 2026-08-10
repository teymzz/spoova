<?php

namespace spoova\mi\core\classes;

/**
 * Generates different hash types.
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Hasher{
  
  /**
   * Defines default salting algorithms lists (e.g sha256, sha384, base_encode, bson_encode)
   *  - Custom hash functions that takes a single argument can also be used
   *
   * @var array
   */
  private array $hashFunc = [];
  
  /**
   * Defines inline salting algorithms lists (e.g sha256, sha384, base_encode, bson_encode)
   *  - Custom hash functions that takes a single argument can also be used
   *
   * @var array
   */
  private array $inlineFuncs = [];

  /**
   * Secret credentials to be used for validating hash strings
   *
   * @var array
   */
  protected array $credentials = [];

  /**
   * Key to be used for hashing 
   *
   * @var string|null
   */
  private ?string $hashKey = null; 

  /**
   * Sets the hash counter
   *
   * @var integer
   */
  private int $hashcounter = 0;

  /**
   * Defines a random value used for generating dynamic hash strings
   *
   * @var int
   */
  private int|string|null $random = null;

  /**
   * Defines when an hash string is randomized    
   *
   * @var bool
   */
  private bool $randomize = false;

  private bool $process = false;

  private array $fixedHashes = ["1a2b3c","4b5c6d",
                                       "5a6d7e","8d9e0f",
                                       "1a4b5d","8d1a2e",
                                       "5c6a9b","5b2a3e",
                                       "6c7d0e","2c5a6e"];
  /**
   * Default random hashing chracter string
   *
   * @var string
   */
  private string $keySpace    = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  private int $keyLength   = 6;
  
  /**
  * sets data to be hashed
  *
  * @param mixed $credentials data to be hashed
  * @param string $hashKey an anonymous key to be used hash $credentials 
  * @return void
  */  
  function __construct(mixed $credentials = null, ?string $hashKey = null)
  {
    if(func_num_args() > 0) $this->setHash($credentials, $hashKey);
  }
  
  /**
  * sets data to be hashed
  *
  * @param array|string $credentials data to be hashed
  * @param string $hashKey an anonymous key to be used hash $credentials 
  * @return void
  */
  public function setHash($credentials, ?string $hashKey = null){
    $this->credentials = (array) $credentials;
    $this->hashKey = $hashKey;

    if(is_array($credentials)){
      $this->process = true;
    }else{
      $this->process = false;
    }
  }

  public function data(){
    return $this->credentials;
  }

  /**
  * This method uses a defined text string or time() to create a dynamic hash string 
  *
  * @param boolean $random 
  *   - If $random is bool (true) randomizes hash with time();
  *   - If $random is bool (false) unset randomization
  *   - If value is not a bool, it uses supplied value to generate hash key
  * @return void
  */
  public function randomize(bool|int|string $random = true){
    
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
   * @param array|string $hashFuncs
   * @return bool True is returned if all hashing functions supplied exists.
   */
  public function hashFunc(array|string $hashFuncs = []) : bool {
    
    $hashFuncs =  (array) $hashFuncs;
    $hashes = []; 

    foreach ($hashFuncs as $hashFunc) {
      if(function_exists($hashFunc)){
          $hashes[] = $hashFunc;
      }else{
        return false;
      }
    }

    if($this->inlineFuncs) {
      $this->inlineFuncs = $hashes;
    } else {
      $this->hashFunc = $hashes;
    }

    return true;

  }
  
  /**
  * Executes the hashing process
  *
  * @param int|bool|array  $param1
  *     - If $param1 is greater than zero, sets the number of times for hashing
  *     - If $param1 is set as zero => reset hash and return first hash  
  *     - If $param1 == (array | string) => list of hashing functions
  * 
  * @param int $param2
  *     - If $param2 == (int > 0) => number of times for hashing
  *     - If $param2 == (int = 0) => reset hash and return first hash 
  *
  * @return string
  *     
  */
  public function hashify(array|int|bool|string $param1 = true, int|bool|null $param2 = null){
      if($this->process == false){ return false; }

      $args = func_num_args();
      $type = $param1;

      if($args){
        if($args === 1){
          //convert parameter to integer for bools and numeric values
          if(is_numeric($param1) || is_bool($param1)){
            $val = (int) $param1;
          } else {
            $type = $param2;
            $val = (int) $param2;
            $funcs = $param1;
          }
        }else{
          $type = $param2;
          $val = (int) $param2;
          $funcs = $param1;
        }
      }else{
        $val = (int) $param1;
      }

      if($val === 0){ $this->hashcounter = 0; }

      if(isset($funcs)){ 
        $this->inlineFuncs = (array) $funcs;
        $this->hashFunc($funcs); 
      }

      if($val === 0){
        //false and zero values
        $this->hashcounter = 0;
        $nval = $this->runHash();
        //$this->hashcounter = 0;         
      }else{
        if($type === true){
          $nval = $this->runHash();
        }else{
          $this->hashcounter = 0;
          for($i = 0; $i <= $val; $i++){
            $nval = $this->runHash();
          } 
        }
      }

      return $nval; 
  }

  private function runHash(){ 
    
    $hashList = ""; 
    $hashFuncs = $this->hashFunc;
    $credentials = $this->credentials;
    array_unshift($hashFuncs,'sha1');
    $hashFuncs = array_merge($hashFuncs, $this->inlineFuncs);
    $this->inlineFuncs = []; //reset

    //hash all credentials
    $credo = implode("",$credentials);
    $shacredo = $credo != null? substr(sha1($credo), 0, 2) : strlen($credo) % 3;


    foreach ($credentials as $credential) {
      $credential = sha1(json_encode($credential));
      $prefix     = substr($credential, 0, -4);
      $hashList  .= $prefix.$this->hashGen($credential);
    }

    $random = $this->random;
    $hashKey = $this->hashKey;

    /* the key is optional, and md5() has not accepted NULL since PHP 8.1 — the cast
       keeps an unkeyed hasher off the deprecation without moving any digest, since
       NULL was being coerced to the empty string here anyway */
    $hashed = $this->reBaseEncode($shacredo.$hashList.substr(md5((string) $hashKey), 0, 4).$random);

    foreach ($hashFuncs as $hashFunc) {
      $hashed = $hashFunc($hashed);
    }   

    return $hashed; 
  } 

  /**
  * generate an independent quick random hash string
  *
  * @param integer $length length of hash
  * @param string $key specific characters from which hash key should be generated
  * @param string|array $func functions any hashing function
  * @return string
  */
  public function randomHash(?int $length = null, ?string $key = null, array|string $func = '') : string {
    
    if($key != null){ $this->keySpace = $key; }

    $length = (int)$length;

    if($length > 1){ $this->keyLength = $length; }
    return $this->randomGen($func);

  }

  private function reBaseEncode(string $string){
    return rtrim(strtr(base64_encode($string),'+/','-_'),'=');
  }

  private function hashGen(string $value){

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

  private function randomGen(array|string $hashFuncs){

    $length = $this->keyLength;
    $keyspace = $this->keySpace;  
    if ($length < 1) {
      return false;
    }
    //custom hashing
    if(!empty($hashFuncs)){
      if(!is_array($hashFuncs)){ $hashFuncs = (array) $hashFuncs; }
      $keyspace .= time();
      foreach ($hashFuncs as $hashFunc) {
        if(function_exists($hashFunc)){
          $keyspace = $hashFunc($keyspace); 
        }else{
          return false;
        }
      }
      return $keyspace.'';
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