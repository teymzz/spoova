<?php 

namespace spoova\mi\core\classes;

use Closure;
use spoova\mi\core\classes\JwsToken;

/**
 * This is an helper class for the  
 * JwsToken class
 */
class Jws{

    private static JwsToken $JwsToken;

    /**
     * Sets the type and signature algorithm to be used for generating JwsToken 
     *
     * @param string $type optional [JWS|JWT]
     * @param string $algo
     * @return JwsToken
     */
    public function __construct($type = 'JWT', $algo = 'HS256'){
        self::JwsToken()->set(...func_get_args());
    }

    public static function createJWT(array $payload,  mixed $passkey, string $hash='sha256', string $algo = 'HS256') : string {
        return self::createToken(...func_get_args());
    }

    public static function createJWS(array $payload,  mixed $passkey, string $hash='sha256', string $algo = 'HS256') : string {   
        return self::createToken($payload,  $passkey, $hash, $algo, 'JWS');
    }

    private static function createToken(array $payload,  mixed $passkey, string $hash='sha256', string $algo = 'HS256', string $type="JWT") : string {
        self::set($type,$algo)->secret($passkey, $hash);
        self::payload($payload);
        return self::JwsToken()->sign()->token();
    }

    /**
     * Sets the type and signature algorithm to be used for generating JwsToken 
     *
     * @param string $type optional [JWS|JWT]
     * @param string $algo
     * @return JwsToken
     */
    public static function set($type = 'JWT', $algo = 'HS256') : JwsToken{

        return self::JwsToken()->set(...func_get_args());

    }

    /**
     * Used to set secret key and algorithms required 
     * for validating or decrypting tokens.
     *
     * @param mixed $passkey secret pass key
     * @param string $hash secret hashing alorithm (e.g md5, sha256)
     *  - The default value if not specified is sha256
     * @return JwsToken
     */
    public function secret($passkey = '', string $hash = 'sha256') : JwsToken{
        return self::JwsToken()->secret(...func_get_args());
    } 

    /**
     * Sets the payload to be tokenfied
     *   - supports more than on arguments.
     *
     * @param string|array $payload
     * @return JwsToken
     */
    public static function payload(string|array $payload = []) : JwsToken{
        self::JwsToken()->payload(...func_get_args());
        return self::$JwsToken;
    }

    /**
     * Declares when a token should become active
     *
     * @param integer|string $secs An integer or numeric string measured in seconds. 
     * @return JwsToken
     */
    public function activates(int $secs = 0) : JwsToken{
        
        return self::$JwsToken->activates(...func_get_args());

    }

    /**
     * Declares the time in seconds when a token should expire
     *
     * @param integer|string $secs An integer or numeric string measured in seconds. 
     * @return JwsToken
     */
    public function expires(int $secs = 0) : JwsToken{
        
        return self::$JwsToken->expires(...func_get_args());

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
    public static function token($token = ''): string | JwsToken {
        self::JwsToken()->token(...func_get_args());
        return self::$JwsToken;
    }

    /**
     * Decrypts a token
     *  - When binded with isValid() method and no arguments supplied, it returns the last 
     *    decrypted token.
     *
     * @param string $token
     * @param string $passkey secret key used when signing token
     * @param string $hash hashing algorithm used to hash token
     * @return string|array|bool|null
     */
    public static function decrypt(string $token = '', $passkey = '', $hash = 'sha256') : string|array|bool|null {
        return self::JwsToken()->decrypt(...func_get_args());
    }

    /**
     * Used to validate or decrypt tokens
     *  - If no arguments are supplied, this will use the default 
     *    values predefined values by the secret() method.
     *
     * @param mixed $passkey
     * @param string $hash
     * @return boolean
     */
    public static function isValid($passkey = '', $hash = 'sha256') : bool {
        //must use existing instance
        return self::JwsToken()->isValid(...func_get_args()); 
    }

    /**
     * This is an alias to the isValid() method that is used to validate or decrypt tokens
     *  - If no arguments are supplied, this will use the default 
     *    values predefined values by the secret() method.
     *
     * @param mixed $passkey pass key used for generating token
     * @param string $hash secret hashing alogrithm used for generating token
     * @return boolean
     */
    public static function validate($passkey = '', $hash = 'sha256') : bool {
        return self::JwsToken()->isValid(...func_get_args());
    }

    /**
     * Returns the value of a payload key
     *
     * @param string $key payload access key
     * @param string|Closure $format defines the format of value to be returned if value is not null 
     *  - String values are use to convert (exp and nbf) values to date format (e.g 'Y-m-d H:i:s')
     *  - Closure is used to define a custom format for displaying values that are not null.
     * @return mixed
     *  - Note that null is returned if the key does not exist
     */
    public static function get($key, string|Closure $format = '') : mixed {
        return self::$JwsToken->get(...func_get_args());
    }
    
    /**
     * Checks if a token has expired.
     *  - Note: this requires internal decrypting 
     *
     * @param mixed $passkey
     * @param string $hash secret hashing alogritm (e.g sha256, md5)
     *  - Default is sha256 or value predefined by secret() method
     * @return bool|null
     */
    public function expired($passkey = '', string $hash = '') : bool|null {
        return self::$JwsToken->expired(...func_get_args());
    }

    /**
     * Checks if a token has expired. No revalidation
     *
     * @return bool
     */
    public function hasExpired() : bool {
        return self::$JwsToken->hasExpired();
    }

    /**
     * Detects if a token is not yet active.
     *  - Note: this requires internal decrypting
     *
     * @param string $passkey
     * @param string $hash
     * @return bool returns true only if a token is pending. Bad and active tokens will return false.
     */
    public function pending($passkey = '', $hash='sha256') : bool {
        return self::$JwsToken->pending(...func_get_args());
    }

    /**
     * Checks if a token is pending. No revalidation
     *
     * @return bool 
     */
    public function isPending() : bool {
        return self::$JwsToken->isPending();
    }

    /**
     * This method returns error encountered during token validation.
     *
     * @return false|string|null
     */
    public static function error() : false|string|null {
        return self::$JwsToken->error();
    }

    /**
     * Converts supplied integer to time in seconds
     *
     * @param integer $time futuristic time (in seconds). For example, 20 means 20 seconds after the current time.
     * @return int
     */
    public static function time(int $time = 0) : int {
        return time() + $time;
    }

    /**
     * Generates a new instance of JwsToken
     *  - Warning: This will override the previous instance stored completely.
     * @return void
     */
    public static function init() : void {
        self::JwsToken(true);
    }

    /**
     * Initialize JwsToken class or access existing intialized class
     *
     * @return JwsToken
     */
    private static function JwsToken(bool $new = false) : JwsToken {
       if(!isset(self::$JwsToken) || $new) {
         self::$JwsToken = new JwsToken;
       }
       return self::$JwsToken;
    }
}