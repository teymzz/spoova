<?php

namespace spoova\mi\core\classes;

use Closure;

/**
 * This class is used for creating and validating JwsTokens
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class JwsToken{

    private $keys = [
        'aud', // audience by
        'sub', // subject by
        'iss', // issuer or issued by
        'iat', // issued at (time)
        'exp', // expires at (time)
        'nbf', // not active before (time)
        'data' // custom reserved key for storing data 
    ];

    /**
     * Lists of acceptable signature algorithms
     *
     * @var array
     */
    private $algos = [
        'HS256','HS384','HS512',
        'RS256','RS384','RS512', 
        'ES256','ES384','ES512', 
        'PS256','PS384','PS512', 
    ];   

    /**
     * Type of JwsToken [JWS|JWT]
     *
     * @var string
     */ 
    private string $type = 'JWT';

    /**
     * Signature algorithm
     *
     * @var string
     */
    private string $algo = 'HS256';

    /**
     * Secret hashing algorithm for encrypting & 
     * decrypting token (e.g sha256, md5)
     *
     * @var string
     */
    private string $hash = 'sha256';

    /**
     * Secret pass key for encrypting token
     *
     * @var string
     */
    private string $pass;

    private string|array $payload;

    private bool $allowDecrypt = false;

    /**
     * Defines when a token is valid
     *
     * @var boolean
     */
    private bool $valid = false;

    /**
     * Defines when a token has expired
     *
     * @var boolean
     */
    private bool $expired = false;

    /**
     * Defines when a token is not yet active but valid
     *
     * @var boolean
     */    
    private bool $pending = false;

    /**
     * Defines a generated token
     *
     * @var string
     */
    private ?string $token = null;
    
    private ?string $itoken = null;

    /**
     * Sets an error message 
     *
     * @var mixed
     */
    private $error;

    /**
     * Defines the header of a token
     *
     * @var string
     */
    public $basehead;

    /**
     * Defines the payload of a token
     *
     * @var string
     */
    public $baseload;

    /**
     * Defines a decrypted token
     *
     * @var array
     */
    public ?array $decrypt = null;

    /**
     * Sets the type and signature algorithm to be used for generating JwsToken 
     *
     * @param string $type optional [JWS|JWT]
     * @param string $algo
     * @return JwsToken
     */
    public function __construct(string $type = 'JWT', string $algo = 'HS256'){
        $this->set(...func_get_args());
    }

    /**
     * Sets the type and signature algorithm to be used for generating JwsToken 
     *
     * @param string $type optional [JWS|JWT]
     * @param string $algo
     * @return JwsToken
     */
    public function set(string $type = 'JWT', string $algo = 'HS256') : JwsToken{

        if($type !== 'JWS' and $type !== 'JWT'){ 
            $this->error('type '.$type.' unknown'); 
            return $this;
        }

        $this->type = $type;

        if(func_num_args() > 1){
           $this->algo($algo);
        }

        return $this;

    } 

    /**
     * Sets or modifies the digital signature algorithm of a token
     *
     * @param string $algo
     * @return JwsToken
     */
    public function algo(string $algo = 'HS256') : self {

        if($this->error != '') return $this;

        if($algo == '') {
            $this->error('algorithm not supplied!');
            return $this;
        }

        if(!in_array($algo,$this->algos)){
            $this->error('algorithm not known');
            return $this;            
        }

        $this->algo = $algo;
        return $this;
    } 


    /**
     * Used to set secret key and algorithms required 
     * for validating or decrypting tokens.
     *
     * @param string $passkey secret pass key
     * @param string $hash secret hashing alorithm (e.g md5, sha256)
     *  - The default value if not specified is sha256
     * @return JwsToken
     */
    public function secret(string $passkey = '', string $hash = 'sha256') : JwsToken{
        $this->pass = $passkey;
        $this->hash = $hash;
        return $this;
    } 

    /**
     * Sets the payload to be tokenfied
     *
     * @param string|array $payload
     * @return JwsToken
     */
    public function payload(string|array $payload = []) : JwsToken{

        if(is_string($payload)){
            if(empty(trim($payload))){
                $this->error('empty payload supplied');
            }
        }elseif(is_array($payload)){
            if(empty($payload)){
                $this->error('empty payload supplied');
            }
        }
        $this->payload = $payload;
        return $this;
    }

    /**
     * Signs a payload with a secret key and hashing algorithm type
     *
     * @param mixed $passkey to be used to sign the payload.
     *  - This will assumed the default secret key predefined if not specified
     * @param string $hash hashing modifier algorithm to be used. 
     *  - This will use the predefined hashing algorithm if not specified
     * @return JwsToken|false 
     *  - FALSE : if a previous error exists, no type or no hash algorithm is found.
     */
    public function sign(mixed $passkey = null, string $hash = 'sha256') : JwsToken|false {
        
        $type = $this->type;
        $algo = $this->algo;
        
        if(($this->error != '') || (trim($type) === '') || (trim($algo) === '')) return false;

        $headData = ['typ'=>$type,'alg' => $algo];     
        
        if(!isset($this->payload['iat'])){
            $this->payload['iat'] = time();
        }

        $header = json_encode($headData);
        $payload = json_encode($this->payload);
        
        $basehead = str_replace(['+','/','='], ['-','_',''], base64_encode($header));
        $baseload = str_replace(['+','/','='], ['-','_',''], base64_encode($payload));

        $this->basehead = $basehead;
        $this->baseload = $baseload;  
        
        if(func_num_args() < 1){
            $passkey = $this->pass;
            $hash = $this->hash;
        }else{
            
            $this->pass = $passkey;
            $this->hash = $hash;
        }

        $signature = hash_hmac($hash,$basehead . '.' . $baseload, $passkey, true);
        $basesign  =  str_replace(['+','/','='], ['-','_',''], base64_encode($signature));

        $jwt = $basehead. '.' .$baseload. '.'. $basesign;

        $this->token = $jwt;

        return $this;
    }

    /**
     * Declares when a token should become active
     *
     * @param integer|string $secs An integer or numeric string measured in seconds. 
     * @return JwsToken
     */
    public function activates(int $secs = 0) : JwsToken{
        
        $this->payload['nbf'] = time() + $secs;

        return $this;

    }

    /**
     * Declares the time in seconds when a token should expire
     *
     * @param integer|string $secs An integer or numeric string measured in seconds. 
     * @return JwsToken
     */
    public function expires(int $secs = 0) : JwsToken{
        
        $this->payload['exp'] = time() + $secs;

        return $this;

    }

    /**
     * Sets a token or returns a generated token string
     *
     * @param string $token 
     *  - when $token is defined, it sets the token string
     *  - when no argument is supplied, it returns a generated token string
     * 
     * @return string|JwsToken
     */
    public function token(string $token = '') : string | JwsToken {
      if(func_num_args() > 0){
          $this->itoken = $token;
          $this->pending = false;
          $this->expired = false;
          return $this; 
      }
      return isset($this->token)? $this->token : '';
    }

    /**
     * Returns the value of a payload key.
     *
     * @param string $key payload access key.
     * @param string|Closure $format defines the format of value to be returned if value is not null.
     *  - String values are use to convert (exp and nbf) values to date format (e.g 'Y-m-d H:i:s').
     *  - Closure $format($value) is used to define a custom format for displaying values that are 
     *    not null where $value refers to the value of the payload key supplied.
     * @return mixed
     *  - Note that null is returned if the key does not exist
     */
    public function get(string $key, string|Closure $format = '') : mixed {

        if(isset($this->payload) && isset($this->payload[$key])){
            $value = $this->payload[$key];
            if(func_num_args() > 1){
                if(!empty($value)){
                    if(is_numeric($value)){
                        if($format instanceof Closure){
                            $value = $format($value);
                        }else{
                            $value = date($format, $value);
                        }
                    }else{
                        return $this->error('invalid key supplied');
                    }
                }
            }
            return $value;
        }
        return null;
    }

    /**
     * Decrypts a token
     *  - When binded with isValid() method and no arguments supplied, it returns the last 
     *    decrypted token.
     *
     * @param string $token
     * @param string $passkey secret key used when signing token
     * @param string $hash hashing algorithm used to hash token
     * @return string|array|boolean|null
     */
    public function decrypt(?string $token = null, string $passkey = '', string $hash = 'sha256') : string|array|bool|null {

        if(func_num_args() < 1){
            if(!isset($this->itoken)) {
                $this->error('no token detected');
                return $this->decrypt;
            }else{
                $token = $this->itoken;
            }
        }

        if((func_num_args() === 1)){
            if(!isset($this->pass)) {
                trigger_error('no passkey detected');
                return false;
            }
            if(!isset($this->hash)) {
                trigger_error('no hash alogrithm detected');
                return false;
            }
            $passkey = $this->pass;
            $hash = $this->hash;
        }
        
        //Define token to be used for decrypting
        if($token === null) {
            if(!isset($this->itoken)){
                trigger_error('no token was supplied for decrypting');
                return false;
            }
            $token = $this->itoken;
        }

        $explode = explode('.',$token);

        if(count($explode) < 3){ 
            return $this->error('invalid token format detected') ?? false;
        }

        $this->itoken = $token;
        $header = $explode[0];
        $payload = $explode[1];
        
        $basehead = str_replace(['-','_',''], ['+','/','='], base64_decode($header));
        $baseload = str_replace(['-','_',''], ['+','/','='], base64_decode($payload));
        
        $data['header']  = json_decode($basehead, true);
        $data['payload'] = json_decode($baseload, true);
        $this->payload = $data['payload'];

        if($this->allowDecrypt === true){ $this->allowDecrypt = false; return $data; }
        
        if($this->isValidToken($passkey, $hash)){  
            return $this->decrypt = $data;
        }
        return $this->error('token cannot be decrypted') ?? false;

    }

    /**
     * Used to validate or decrypt tokens
     *  - If no arguments are supplied, this will use the default 
     *    values predefined values by the secret() method.
     *
     * @param string $passkey
     * @param string $hash
     * @return boolean
     */
    public function isValid(string $passkey = '', string $hash = 'sha256') : bool {
        if(func_num_args() === 0){
            $passkey = $this->pass;
            $hash = $this->hash;
            return $this->isValidToken($passkey, $hash, true);
        }
        return $this->valid;  
    }

    /**
     * This is an alias to the isValid() method that is used to validate or decrypt tokens
     *  - If no arguments are supplied, this will use the default 
     *    values predefined values by the secret() method.
     *
     * @param string $passkey pass key used for generating token
     * @param string $hash secret hashing alogrithm used for generating token
     * @return boolean
     */
    public function validate(string $passkey = '', string $hash = 'sha256') : bool {
        return $this->isValid(...func_get_args());
    }

    /**
     * Checks if a token is valid or decrypts a token
     *
     * @param string $passkey
     * @param string $hash hashing algorithm
     * @param boolean $decrypt determines if a defined token should be decrypted
     * @param string $test determines if a token is being tested (e.g for exp, nbf) 
     * @return boolean
     */
    private function isValidToken(string $passkey, string $hash, bool $decrypt = false, string $test = ''){

        $token = $this->itoken;
        $explode = explode('.', $token);

        if(count($explode) < 3){ 
            return $this->error('invalid token format detected');
        }

        if(empty($this->itoken)){ return $this->error('invalid token supplied'); }

        $header  = $explode[0];
        $payload = $explode[1];
        $crypt   = $explode[2];

        $signature = hash_hmac($hash, $header . '.' . $payload, $passkey, true);
        $basesign  =  str_replace(['+','/','='], ['-','_',''], base64_encode($signature));

        if($decrypt === true){   
            $this->allowDecrypt = true;
            if($arrdata = $this->decrypt($token, $passkey, $hash)){
        
                $header = $arrdata['header'];
                $payload = $arrdata['payload'];
                if(!$this->validate_token($payload, $test)){
                    return false;
                }else{
                    $this->decrypt = $arrdata;
                }

            }else{
                return false;
            }
        }

        if($crypt === $basesign){
            return true;
        }else{
            return $this->error('token is not valid');
        }

    }

    /**
     * Validate a token using payload supplied
     *
     * @param array $payload
     * @param string $test - optional [nbf|exp]
     *   - Determines the payload key to be tested
     * @return boolean
     */
    private function validate_token(array $payload, $test = '') : bool{
        
        $rels = ['nbf'=>'pending', 'exp' => 'expired'];
        
        if($test){

            // Apply this validation when specific payload timer test key is defined to be validated
            // This is triggered by expired() and pending() methods

            if($test === 'nbf'){
                $nbftime = $payload['nbf'];
                if(time() < $nbftime){
                    $this->pending = true;
                    return false; //validation fails
                } 
            }else if($test === 'exp'){
                $exptime = $payload['exp'];
                if(time() > $exptime){
                    $this->expired = true;
                    return false; //validation fails
                } 
            }
            
        }

        //automatically validate expiry time if defined in payload
        if(isset($payload['exp'])){

            $exptime = $payload['exp'];

            if(time() > $exptime){
                $this->expired = true;
                return $this->error('token has expired');
            }

        }
        
        //automatically validate activation time if defined in payload
        if(isset($payload['nbf'])){
            $nbftime = $payload['nbf'];
            if(time() < $nbftime){
                $this->pending = true;
                return $this->error('token is not active');
            }            
        }

        return true; // token is valid

    }

    /**
     * Checks if a token has expired.
     *  - Note: this requires internal decrypting 
     *
     * @param mixed $passkey
     * @param string $hash secret hashing alogritm (e.g sha256, md5)
     *  - Default is sha256 or value predefined by secret() method
     * @return bool
     */
    public function expired($passkey = '', string $hash = '') : null|bool {
        if(func_num_args() < 1){
          $passkey = $this->pass;
          $hash = $this->hash;
        }elseif(func_num_args() > 0){
            $args = func_get_args();
            if(!isset($args[1])) $hash = $this->hash;
        }
        $this->isValidToken($passkey, $hash, true, 'exp');
        return $this->expired;
    }

    /**
     * Checks if a token has expired. No revalidation
     *
     * @return boolean
     */
    public function hasExpired() : bool {
        return $this->expired;
    }

    /**
     * Detects if a token is not yet active.
     *  - Note: this requires internal decrypting
     *
     * @param string $passkey
     * @param string $hash
     * @return bool returns true only if a token is pending. Bad and active tokens will return false.
     */
    public function pending(string $passkey = '', string $hash='sha256') : bool {
        if(func_num_args() < 0){
            $passkey = $this->pass;
            $hash = $this->hash;
        }elseif(func_num_args() > 0){
            $args = func_get_args();
            if(!isset($args[1])) $hash = $this->hash;
        }
        $this->isValidToken($passkey, $hash, true, 'nbf');

        return $this->pending;
    }

    /**
     * Checks if a token is pending. No revalidation
     *
     * @return boolean
     */
    public function isPending() : bool {
        return $this->pending;
    }

    /**
     * This method returns error encountered during token validation.
     *
     * @return false|string|null
     */
    public function error() : false|string|null {
        if(func_num_args() == 0){ return $this->error; }
        $this->error = func_get_args()[0];
        return $this->valid = false; //when error occurs validation fails
    }

    public function __toString()
    {
        return isset($this->token)? $this->token : '';
    }

}
