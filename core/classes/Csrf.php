<?php

namespace spoova\mi\core\classes;

use Form;
use Res;
use spoova\mi\core\classes\Hasher;
use Window;

/**
 * This class handles CSRF token generation and validations
 * 
 * @author Akinola Saheed <teymss@gmail.com>
 */
class Csrf {

     /**
      * Expire time in seconds (Default 10 minutes)
      *
      * @param string $type
      * @return string
      */
     private static $expires = false;
     private static $strict = false;
     private static $isExpired = false;
     private static $isReferred = false;
     private static $emessage = [
      'default' => [
         'title'=>'invalid form submission',
         'info' =>'Opps! Invalid request detected. This is usually caused when the conditions to prevent 
                   a cross-site request forgery is not met. Ensure that you\'re submitting a valid data 
                   to the server.'
        ],
      'expired' => [
         'title'=> 'invalid form session',
         'info' =>'Request requires to revalidate form submission because the form session has expired!'
        ], 
      'invalid' => [
         'title'=>'invalid form request',
         'info' =>'Opps! Invalid request detected. This is usually caused when the conditions to prevent 
                   a cross-site request forgery is not met. Ensure that you\'re submitting a valid data 
                   to the server.'
        ],
     ];
     private static array $error = [];

     /**
      * Error types - optional [default|expired|invalid]
      *
      * @var string
      */
     private static string $errorType = '';

    final public function __construct() {}

    /**
     * Generates and returns a csrf session token. If other 
     * valid options except for the default is supplied, the old 
     * token is only returned. 
     *
     * @param string $type optional - [new|session/old]
     *  - Determines if a new token or an old token (session) is returned. 
     *  - Note: When a new token is generated, it automatically updates the old session token
     * @return string
     */
    public static function token(string $type = 'new') : string {

        if(strtolower($type) === 'new') {
            $Hasher = new Hasher;

            $hash = $Hasher->randomHash(20);

            $_SESSION['CSRF_TOKEN'] = $hash;
            $_SESSION['CSRF_TIME'] = time();
        }

        if(in_array($type, ['old','session', 'new'])){
               
          return $_SESSION['CSRF_TOKEN'] ?? '';
        
        }

        return '';

    }

    /**
     * Returns an old token only without generating a new one
     *
     * @return string old token if it exists
     */
    public static function old() : string {
        return $_SESSION['CSRF_TOKEN'] ?? '';
    }

    /**
     * Returns a boolean value of true if the default token 
     * matches the supplied token string 
     *
     * @param string $csrf token to be matched with session token
     * @return void
     */
    public static function matches(string $csrf) : bool{
        return ($csrf === ($_SESSION['CSRF_TOKEN'] ?? ''));
    }
    
    /**
     * Set and/or returns expiry time
     *
     * @param int $time set expiry time in seconds default is 10 minutes
     *    -when no argument is supplied, returns the expire time only.
     * @return int
     */
    public static function expires($time = 600) : int{
     if(func_num_args() > 0) self::$expires = $time;
     return self::$expires;
    }

    /**
     * Checks if a csrf token has expired
     * @return bool
     * 
     */
    public static function hasExpired(){

       if(!self::$expires) return false;

        //time generated
        $time = $_SESSION['CSRF_TIME'] ?? '';

        if(self::isReferred()){
          $time = self::ref()->time;
        }

        if($time) {
          if(time() > ($time + self::$expires)){
               return true;
          }
        }

        return false;
    }

    /**
     * Csrf invalid file to be loaded
     *
     * @return string
     */
    public static function page() {
      return 'csrf_invalid';
    }

    /**
     * Restrict the current page from loading
     * while loading the invalid csrf page
     *
     * @return void
     */
    public static function block() {
      if(self::$expires && self::hasExpired()){
          $type = !self::errorType()? self::setError('expired') : self::setError(self::errorType());
          $error = self::getError('expired');
          Form::setError('title', $error['title']);
          Form::setError('info', $error['info']);
      }else{  
          self::setError('invalid');
          $error = self::getError('invalid');
          Form::setError('title', $error['title']);
          Form::setError('info', $error['info']);          
      }

      Res::load(Window::wvm(':csrf'), fn() => compile() );
      die();
    }

    /**
     * Set csrf authentication as strict type while returning the 
     * instance of the same class. Strict types automatically display 
     * error pages when Csrf::auth() is called and validation fails.
     *
     * @param boolean $strict
     * @return Csrf
     */
    public static function strict(bool $strict = true) : Csrf {
     self::$strict = $strict;
     return new self;
    }

    /**
     * Return true if authentication is set as strict type.
     *
     * @return boolean
     */
    public static function isStrict() : bool {
     return self::$strict;
    }

    /**
     * This tests if a csrf token exist, matches the session token and is not expired.
     * Token must be supplied for validation.
     * 
     * @param string $csrfToken token to be checked for validity
     * @return bool
     */
    public static function isValid(string $csrfToken) : bool {

      $matched = (self::old() && self::matches($csrfToken));

      if(!$matched) { 
        self::setError('invalid');     
        return false;
      }
     
      if(self::$expires){
          $expired = self::hasExpired();
          if($expired) self::setError('expired');
          return ($matched && !self::hasExpired());
      }

      return true;

    }

    /**
     * Return the object of a manually referenced form array data. 
     * Referenced form data is accessible only after a form data is 
     * pushed forward to external route and pulled back through window::pushFormData() 
     * to the current route .
     *
     * @return object
     */
    public static function ref() : object {
      
      $default = [
        'VALID'  => false, 
        'valid'  => false,
        'isValid'=> false,
        'time'   => '0000000000',
        'TIME'   => '0000000000' 
      ];

      if(isset($_ENV[':FORM'])){
        $csrf = $_ENV[':FORM']['CSRF_REF'] ?? [];
      }else{
        $csrf = [];
      }

      $ref = $csrf ?: $default;
      return (object) $ref;

    }

    /**
     * Authenticate csrf. When Csrf is set as strict type, if 
     * authentication fails, an error page is automatically displayed. 
     * Non-strict type will return false instead.
     *
     * @param string $csrfToken token to be validated
     *  - Token must be supplied if the request data pulled from external redirect.
     * @param integer $expires in seconds defines the token expiry time
     * @return void|bool
     */
    public static function auth(string $csrfToken = '') {

      if(self::isReferred()) {
        //run this if form data is pulled from a push request

        $Request = new Request;

        if($Request->isPost()){
          $method = &$_POST;
        }else{
          $method = &$_GET;
        }
        
        if(!Csrf::ref()->valid){
          $method = [];
          self::setError('invalid');
          if(Csrf::isStrict()) self::block();
          return false;
        }

      } else {

        if(!self::old() || !self::matches($csrfToken)){
          self::setError('invalid');
          if(self::isStrict()) self::block();
          return false;
        }          
        
      }

      if(self::$expires && Csrf::hasExpired()) {
        $method = [];
        self::setError('expired');
        if(self::isStrict()) self::block();
        return false;
      }

      return true;
      
    }

    /**
     * Return csrf errors encountered
     *
     * @return array
     */
    public static function error() : array {
      return self::$error;
    }

    /**
     * Set error response
     *
     * @param string $type optional - [default|invalid|expired]
     * @param array|string  $custom optional custom message for defined type
     *  -If string, it sets $type info 
     *  -If array, accepted array keys: [title|info]
     * @return void
     */
    public static function setError(string $type, $custom = ''){
      if(is_string($custom)){
        if(func_num_args() > 1){
          if($custom) self::$emessage[$type]['info'] = $custom;
        }
      }elseif(is_array($custom) && $custom){
        ($custom['title'] ?? '')? self::$emessage[$type]['title'] = $custom['title'] : '';
        ($custom['info']  ?? '')? self::$emessage[$type]['info'] = $custom['title'] : '';
      }

      static::$error = self::$emessage[$type];
      static::$errorType = $type;
    }

    /**
     * Set error response
     *
     * @param string $type [optional] - [default|invalid|expired]
     * @return null|string
     */
    private static function getError(string $type){
      return self::$emessage[$type];
    }

    /**
     * Returns the last error type as default, invalid or expired
     *
     * @return string
     */
    public static function errorType() : string {
      return self::$errorType;
    }

    /**
     * Returns true if environment key ':FORM' is defined. 
     * This is automatically defined when a pushed form data is
     * pulled back from an external route.
     *
     * @return boolean
     */
    public static function isReferred() : bool {
      return isset($_ENV[':FORM']);
    }

}
