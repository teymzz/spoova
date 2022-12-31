<?php

namespace spoova\core\classes;

/**
 * @author Akinola Saheed <teymss@gmail.com>
 * @package \core\classes
 * 
 * This class enables a customized structure 
 * for building ajax responses. It is dependent on 
 * custom "response" function. 
 * Note:: Class should only be initialized with 
 * arguments for ajax requests. This will direct the class to  
 * terminate if the request is not ajax. 
 * 
 *
 */
class Ajax {
 
  private const request_types = [
   'post', 'get', 'put', 'delete'
   ];

  //custom function for handling responses
  private const response = 'response';
  
  private $response_code = 0;

  /**
   * Initialize new ajax request
   *
   * @param mixed $emessage error response message if request is not ajax
   * @param integer $ecode error response code if request is not ajax
   */
  function __construct($emessage = null, $ecode = 401){
    
    $request = $_SERVER['HTTP_X_REQUESTED_WITH']?? '';
    
    if(func_num_args() > 0) {
      
      if($request !== 'XMLHttpRequest'){

        $emessage = $emessage === true ? 'invalid request method' : $emessage;                         
        echo (self::response)($ecode, $emessage);
        exit;
        
      }                    
      
    }
 	
  }

  /**
   * - Returns true on an ajax request
   * - Declares response content type
   * 
   * @param string $type option ':json' sets content-type to 'application/json'
   * @return boolean
   */
  public static function isAjax(string $type = ''){
    
    $request = $_SERVER['HTTP_X_REQUESTED_WITH']?? '';

    if($type == ':json'){
      header('content-type:application/json');
    }elseif($type){
      header('content-type:'.$type);
    }

    return ($request === 'XMLHttpRequest');
  }

  /**
   * Initializes Ajax class with content-type 'application/json'
   * When arguments are supplied, it initializes the ajax class with the argument supplied and request type (strictly) must be ajax
   * 
   * @param mixed $emessage response message
   * @param int $ecode response code
   * @return Ajax
   */
  public static function withJson($emessage = null, int $ecode = 401) {

    header('content-type:application/json');

    return new self(...func_get_args());

  }
  
  /**
   * Prevents an invalid ajax request method
   *
   * @param string|array $requests accepted request methods (post, get , delete)
   * @param integer $response_code http_response code to be sent on invalid request (default is 401)
   * @param mixed $custom_message custom message forwarded on invalid request
   * @return void|Ajax
   */
  public static function accept($requests, $response_code = 401, $custom_message = '') {
   
    $requests = (array) $requests;
    
    $self = new self;
    $self->setcode($response_code);
   
    if(!in_array( self::request(),  $requests )) {
      //bad request call
      $message = $custom_message?? 'invalid request method';

      //Note:: uses the response() function declared in custom/functions...
      echo (self::response)($response_code, $message);
      exit;

    }
    return $self;
    
  }
  
  /**
   * Returns the request method
   *
   * @return string
   */
  public static function request(){
    return strtolower($_SERVER['REQUEST_METHOD']) ;
  }
  
  /**
   * Allows only referred requests. Prevents direct page loading
   *
   * @return void
   */
  public function referred() {
    $response_code = $this->getcode();
    
    if(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      echo (self::response)($response_code, 'invalid request method');
      exit;
    }
  }
  
  /**
   * Sets an ajax response code
   *
   * @param int $code [e.g 200, 404 ... ]
   * @return Ajax
   */
  public function setcode($code){
    $this->response_code = $code;
    return $this;
  }
  
  /**
   * Returns the response code set
   *
   * @return void
   */
  public function getcode(){
    return $this->response_code;
  }

}
