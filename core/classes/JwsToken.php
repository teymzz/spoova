<?php

namespace teymzz\spoova\core\classes;

/**
 * This class is used for creating and validating JWSTokens
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
class JwsToken{

    private $keys = ['aud','exp','iss','iat','nbf','data'];
    private $algos = ['HS256','HS384','HS512','RS256'];    
    private $type = 'JWT';
    private $algo = 'HS256';
    private $hash = 'sha256';
    private $pass;
    private $header;
    private $payload;
    private $expire = 3600;
    private $allowDecrypt;
    private $expired = false;
    private $pending = false;
    private $signature;
    private $activate;
    private $token;
    private $itoken;
    private $error;
    public $basehead;
    public $baseload;
    public $decrypt;

    /**
     * Set the type and algorithm to be used for jwstoken 
     *
     * @param string $type
     * @param string $algo
     * @return JWSToken
     */
    public function set($type = 'JWS', $algo = 'HS256'){

        if($this->error != '') return $this;
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
     * Sets or modifies the algorithm to be used for token generation or decrypting
     *
     * @param string $algo
     * @return JWSToken
     */
    public function algo($algo = 'HS256'){

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
     * Sets the payload to be tokenfied
     *
     * @param array $payload
     * @return JWSToken
     */
    public function payload($payload = []){

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
     * @param mixed $secretkey to be used to sign the payload
     * @param string $hash hashing modifier algorithm to be used. Overides the JWSToken->algo() method
     * @return void
     */
    public function sign($secretkey, $hash = 'sha256'){
        
        $type = $this->type;
        $algo = $this->algo;
        $exp  = $this->expire;
        
        if($this->error != '') return false;
        if(trim($type) === '' || trim($algo) === '') return false;

        $headData = ['typ'=>$type,'alg' => $algo];
        $payData =  $this->payload;        

        $header = json_encode($headData);
        $payload = json_encode($this->payload);
        
        $basehead = str_replace(['+','/','='], ['-','_',''], base64_encode($header));
        $baseload = str_replace(['+','/','='], ['-','_',''], base64_encode($payload));

        $this->basehead = $basehead;
        $this->baseload = $baseload;      

        $signature = hash_hmac($hash,$basehead . '.' . $baseload, $secretkey, true);
        $basesign  =  str_replace(['+','/','='], ['-','_',''], base64_encode($signature));

        $jwt = $basehead. '.' .$baseload. '.'. $basesign;
        $this->token = $jwt;
    }

    /**
     * Declares when a token should expire
     *
     * @param integer|string $secs An integer or numeric string measured in seconds. 
     * @return JWSToken
     */
    public function expires($secs = 3600){

        if($this->payload == ''){
            return false;
        }

        $sec = (int) $secs;
        if($sec < 60){ $sec = 60; }
        
        $this->payload['exp'] = $secs;

        return $this;

    }

    /**
     * Sets a token or returns a generated token string
     *
     * @param string $token 
     *  - when $token is defined, it sets the token string
     *  - when no argument is supplied, it returns a generated token string
     * 
     * @return JWSToken|string
     */
    public function token($token = ''){
      if(func_num_args() > 0){
          $this->itoken = $token;
          $this->pending = false;
          $this->expired = false;
          return $this; 
      }
      return $this->token;
    }

    /**
     * Decrypts a token
     *  - When binded with isValid() method and no arguments supplied, it returns the last 
     *    decrypted token. 
     *
     * @param string $token 
     * @param string $secretkey secret key used when signing token
     * @param string $hash hashing algorithm used to hash token
     * @return mixed
     */
    public function decrypt(string $token = '', $secretkey = '', $hash = 'sha256'){

        if(func_num_args() < 1){
            return $this->decrypt;
        }

        if(!isset($token, $secretkey, $hash)){
            trigger_error('decrypt must contain no arguments or exactly three arguments');
        }

        $explode = explode('.',$token);
        if(count($explode) < 3){ 
            return $this->error('invalid data format detected');
        }

        $this->itoken = $token;
        $header = $explode[0];
        $payload = $explode[1];
        
        $basehead = str_replace(['-','_',''], ['+','/','='], base64_decode($header));
        $baseload = str_replace(['-','_',''], ['+','/','='], base64_decode($payload));
        
        $data['header']    = json_decode($basehead, true);
        $data['payload']   = json_decode($baseload, true);
        $data['hash']      = $hash;
        $data['secretkey'] = $secretkey; 

        if($this->allowDecrypt === true){ $this->allowDecrypt = false; return $data; }

        if($this->isValidToken($secretkey, $hash)){  
            return $data;
        }
        return false;

    }

    /**
     * Used to validate and decy
     *
     * @param mixed $secretkey
     * @param string $hash
     * @return boolean
     */
    public function isValid($secretkey, $hash = 'sha256') : bool {
        
        return $this->isValidToken($secretkey, $hash, true);
                
    }

    /**
     * Checks if a token is valid or decrypts a token
     *
     * @param mixed $secretkey
     * @param string $hash hashing algorithm
     * @param boolean $process determines if a defined token should be decrypted
     * @param string $test determines if a token is being tested (e.g for exp, nbf) 
     * @return boolean
     */
    private function isValidToken($secretkey, $hash, $process = false, $test = ''){

        $token = $this->itoken;
        $explode = explode('.', $token);

        if(count($explode) < 3){ 
            return $this->error('invalid token format detected');
        }

        if($this->itoken == ''){ return $this->error('invalid token suppled'); }

        $header  = $explode[0];
        $payload = $explode[1];
        $crypt   = $explode[2];

        $basehead = base64_decode($header);
        $baseload = base64_decode($payload);
        $signature = hash_hmac($hash, $header . '.' . $payload, $secretkey, true);
        $basesign  =  str_replace(['+','/','='], ['-','_',''], base64_encode($signature));

        if($process === true){   
            $this->allowDecrypt = true;
            if($arrdata = $this->decrypt($token, $secretkey, $hash)){
        
                $header = $arrdata['header'];
                $payload = $arrdata['payload'];

                if(!$this->validate($payload, $test)){
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

    private function validate(array $payload, $test = '') : bool{
        
        $rels = ['nbf'=>'pending', 'exp' => 'expired'];
        
        if($test){

            if(!isset($payload[$test])) {
                $this->{$rels[$test]} = '';
                return false;
            }

            if($test == 'nbf'){
                $nbftime = $payload['nbf'];
                if(time() < $nbftime){
                    $this->{$rels[$test]} = true;
                    return false;
                } 
            }

            if($test == 'exp'){
                $exptime = $payload['exp'];
                if(time() > $exptime){
                    $this->{$rels[$test]} = true;
                    return false;
                } 
            }
            
        }

        if(isset($payload['exp'])){

            $exptime = $payload['exp'];

            if(time() > $exptime){
                $this->expired = true;
                return $this->error('token has expired');
            }

        }

        if(isset($payload['nbf'])){
            $nbftime = $payload['nbf'];
            if(time() < $nbftime){
                $this->pending = true;
                return $this->error('token is not active');
            }            
        }
        return true;

    }

    /**
     * Checks if a token has expired
     *
     * @param string $secret
     * @param string $hash
     * @return bool
     */
    public function expired($secret = '', $hash='sha256') : bool {
        if(func_num_args() > 0){
          $this->isValidToken($secret, $hash, true, 'exp');
        }
        return $this->expired;
    }

    /**
     * Detects if a token is not yet active
     *
     * @param string $secret
     * @param string $hash
     * @return bool
     *  - Returns true only if a token is pending. Bad and active tokens will return false.
     */
    public function pending($secret = '', $hash='sha256'){
        if(func_num_args() > 0){
          $this->isValidToken($secret ,$hash, 'nbf');
        }
        return $this->pending;
    }

    /**
     * This method returns error encountered during token validation.
     *
     */
    public function error(){
        if(func_num_args() == 0){ return $this->error; }
        if(func_num_args() == 1){
            $this->error = func_get_args()[0];
            return false;
        }
    }

}
