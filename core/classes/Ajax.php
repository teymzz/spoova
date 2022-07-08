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

  //custom class for handling responses
  private const response = 'response';
  
  private $response_code = 0;
  
  //initialize a new ajax request
  function __construct($message = '' , $code = 0){
    
     $request = $_SERVER['HTTP_X_REQUESTED_WITH']?? '';
      
     if(func_num_args() > 0) {
       
       if($request !== 'XMLHttpRequest'){
         
         $message = $message === true ? 'invalid request method' : $message;                         
         echo (self::response)($code, $message);
         exit;
         
       }                    
       
     }
 	
  }
  
  /**
   * Prevents an invalid ajax request method
   *
   * @param string|array $requests accepted request methods (post, get , delete)
   * @param integer $response_code http_response code sent (default is 401)
   * @param string $custom_message custom message forwarded
   * @return void
   */
  public static function accept($requests, $response_code = 401, $custom_message = '') {
   
    $requests = (array) $requests;
    
    $self = new self;
    $self->set_code($response_code);
   
    if(!in_array( self::request(),  $requests )) {
      //bad request call
      $message = $custom_message?? 'invalid request method';
      echo (self::response)($response_code, $message);
      exit;
    
    }
    return $self;
    
  }
  
  private static function request(){
    return strtolower($_SERVER['REQUEST_METHOD']) ;
  }
  
  public function referred() {
    $response_code = $this->get_code();
    
    if(empty($_SERVER['REQUEST_URI'])) {
      echo (self::response)($response_code, 'invalid transfer protocol');
      exit;
    }
  }
  
  public function set_code($code){
    $this->response_code = $code;
  }
  
  public function get_code(){
    return $this->response_code;
  }

}