<?php

namespace spoova\core\classes;

/**
 * Create and Validate JWSTokens
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
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
    private $expired;
    private $pending;
    private $signature;
    private $activate;
    private $token;
    private $itoken;
    private $error;
    public $basehead;
    public $baseload;
    public $decrypt;

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

    public function sign($secretkey,$hash = 'sha256'){
        
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

    public function expires($secs = 3600){

        if($this->payload == ''){
            return false;
        }

        $sec = (int) $secs;
        if($sec < 60){ $sec = 60; }
        
        $this->payload['exp'] = $secs;

        return $this;

    }

    public function token($token = ''){
      if(func_num_args() > 0){
          $this->itoken = $token;
          $this->pending = '';
          $this->expired = '';
          return $this; 
      }
      return $this->token;
    }

    public function decrypt($token = '', $secretkey = '', $hash = 'sha256'){

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

    public function isValid($secretkey, $hash='sha256'){
        
        return $this->isValidToken($secretkey ,$hash, true);
                
    }

    private function isValidToken($secretkey, $hash, $process = false, $test = ''){

        $token = $this->itoken;
        $explode = explode('.',$token);

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

    private function validate(array $payload, $test = ''){
        
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

    public function expired($secret = '', $hash='sha256'){
        if(func_num_args() > 0){
          $this->isValidToken($secret ,$hash, true, 'exp');
        }
        return $this->expired;
    }

    public function pending($secret = '', $hash='sha256'){
        if(func_num_args() > 0){
          $this->isValidToken($secret ,$hash, 'nbf');
        }
        return $this->pending;
    }

    public function error($message = ''){
        if(func_num_args() == 0){ return $this->error; }
        if($message == 'exists'){
            return ($this->error != '')? true : false;
        }
        $this->error = $message;
        return false;
    }

}

/* 
  SAMPLE OF USAGE

  payload can be set using the following keys
  
  //optional
  iss - issued by
  iat - issued at 
  data - user data

  //if you need to set time before or expire time, the following should be added to your payload
  nbf - time before activation
  exp - expire time after activation

  Sample 1A: getting a token
    
    $jws = new \core\classes\JwsToken;   //initialize class

    $payload = ['name'=>'me','nbf'=>time() + 60,'exp'=>time() + 120];

    $jws->payload($payload)->sign('secret_key');
    $token = $jws->token(); //return the token

  Sample 1B: modify settings before getting a token
    
    $jws = new \core\classes\JwsToken;   //initialize class

    $jws->set('JWS','HS512'); //default is ('JWT','HS256');

    $payload = ['data'=>'mydata','somedata'=>'','nbf'=>time() + 60,'exp'=>time() + 120];

    $jws->payload($payload)->sign('secret_key');
    $token = $jws->token(); //return the token  
    
  Sample 1C: modify only algoritm before getting a token
    
    $jws = new \core\classes\JwsToken;   //initialize class

    $jws->algo('HS512'); //use HS512

    $payload = ['data'=>'mydata','somedata'=>''];

    $jws->payload($payload)->sign('secret_key');
    $token = $jws->token(); //return the token      

  Sample 1D: using expires to set expire time
    
    $jws = new \core\classes\JwsToken;   //initialize class

    $payload = ['data'=>'mydata','somedata'=>''];
    $expires = time() + 120; //after one minute

    $jws->payload($payload)->expires($expires)->sign('secret_key');
    $token = $jws->token(); //return the token  
    
  Sample 1E: modify hash algorithm
    
    $jws = new \core\classes\JwsToken;   //initialize class

    $payload = ['data'=>'mydata','somedata'=>'some_data_here'];

    $jws->payload($payload)->sign('secret_key','sha1'); //use sha1
    $token = $jws->token(); //return the token  
    
 Sample 2: getting your token and decrypting the data
    
    $jws = new \core\classes\JwsToken;
    $token = 'my_token_here';

    if($jws->token($token)->isValid('secret_key')){

        print($jws->decrypt());

    }elseif($jws->error('exists')){

        print($jws->error());

    }

 Sample 3: decrypting only data
    
    $jws = new \core\classes\JwsToken;    
     //syntax: $jws->decrypt('token','secret_key','hash_algo')); //default hash_algo is sha256

    if($decrypt = $jws->decrypt('mytoken','secret_key','sha1'))){
        print $decrypt; //decrypt with sha1 only when encrypted with sha1
    }else{
        print $jws->error;
    }

 #Note: hash algorithms must match

 USAGE Example

    $payload = ['name'=>'me','nbf'=>time() + 60,'exp'=>time() + 120];

    $jws = new \core\classes\JwsToken;

    $jws->payload($payload)->sign('password_here');
    $token = $jws->token();
    
    print $token;

*/