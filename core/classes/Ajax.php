<?php

namespace spoova\mi\core\classes;

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
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

  //custom function for handling responses
  private const response = 'response';
  
  private $response_code = 0;
  private static bool $imitateAjax = false;

  /**
   * Initialize the Ajax class with or without XMLHttpRequest request header validation
   *
   * @param mixed $message error response message if request header is not XMLHttpRequest
   * @param integer $status error response code if request is not not XMLHttpRequest
   * 
   * @return Ajax|never
   */
  function __construct(mixed $message = null, $status = 401){
    
    $request = $_SERVER['HTTP_X_REQUESTED_WITH']?? '';
    
    if(func_num_args() > 0) {
      
      if(strtolower($request) !== 'xmlhttprequest'){
        
        $message = $message === true ? 'invalid request header' : $message;                         
        echo (self::response)($status, $message);
        exit;
        
      }                    
      
    }
 	
  }

  public static function imitateAjax(bool $imitate = true){
    self::$imitateAjax = $imitate; 
  }

  /**
   * Declares header content-type of an API.
   * 
   * @param string $type option ':json' sets content-type to 'application/json'
   * @return boolean TRUE if request header's 'HTTP_X_REQUESTED_WITH' is XMLHttpRequest else FALSE
   */
  public static function isAjax(string $type = '') : bool {

    if(self::$imitateAjax) return true; // feign ajax

    $request = $_SERVER['HTTP_X_REQUESTED_WITH']?? '';

    if($type == ':json'){
      header('content-type:application/json');
    }elseif($type){
      header('content-type:'.$type);
    }

    return (strtolower($request) === 'xmlhttprequest');
  }

  /**
   * Initializes Ajax class with header content-type 'application/json'
   *  - If arguments are supplied, it instantiates the Ajax class with the argument supplied and validates that the request header  
   * 'HTTP_X_REQUESTED_WITH' must be of XMLHttpRequest type.
   * 
   * @param mixed $message response message
   * @param int $code response code
   * @return Ajax
   */
  public static function withJson(mixed $message = null, int $code = 401) : Ajax {

    header('content-type:application/json');

    return new self(...func_get_args());

  }
  
  /**
   * Prevents an invalid ajax request method
   *
   * @param string|array $requests accepted request methods (post, get , delete)
   * @param integer $response_code http_response code to be sent on invalid request (default is 401)
   * @param mixed $custom_message custom message forwarded on invalid request
   * @return Ajax|never
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
   * Returns the server's request method
   *
   * @return string
   */
  public static function request(){
    return strtolower($_SERVER['REQUEST_METHOD']) ;
  }
  
  /**
   * Allows only requests with 'HTTP_X_REQUESTED_WITH' header.
   *  - On error, invalid request header response message is displayed with default code
   * @return void
   */
  public function referred() {
    $response_code = $this->getcode();
    
    if(empty($_SERVER['HTTP_REFERER'])) {
      echo (self::response)($response_code, 'invalid request');
      exit;
    }
  }
  
  /**
   * Returns a Success
   *
   * @param integer $status valid http_response_code
   * @param string $message valid http response message
   * @param mixed $data valid response message
   * @return void
   */
  public function response(?int $status = null, ?string $message = null, $data = []) {
    if(($status === null) && ($message === null)){
      $status  = $data['status'] ?? 500;
      $message = $data['message'] ?? '';
    }
    
    header("HTTP/1.1 $status $message");

    echo json_encode($data);

    echo (self::response)($status, 'invalid request method');
    exit;
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
   * @return int|string
   */
  public function getcode() : int|string {
    return $this->response_code;
  }

}
