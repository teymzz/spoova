<?php

/**
 * This class depends on external plugins PHPMailer, Emogrify to work.
 * It must be executed with files (mail-config.php and sender.php) 
 *
 * @author by Akinola Saheed <github@teymzz.de>
 *
 * @return void
 */

 class mailer{

    /**
     * @var bool
     */
 	private $sendmail = false;

    /**
     * @var bool
     */ 	
 	private $process  = false;

    /**
     * @var null
     */ 	
 	private $content  = null;

    /**
     * @var array()
     */ 
 	private $response = 
 	[
 		'process'  => false,
 	  	'forward'  => false,
 	  	'execTime' => '',
 	  	'status'   => 0,
 	  	'message'  => '',
 	];

 	function __construct(){
 	  include 'mail-setup.php';
 	  $this->updateVars([]);
 	}

 	/**
 	 * This function loads a file such as php, xml and html files
 	 * if declared, mail setup header and addresses keys can be auto updated from supplied php files
 	 *
 	 * @param $file files e.g php, xml, html to be loaded
 	 * only php files support inline mail configurations
 	 */

 	private function obfile($file){
 	  ob_start();
 	  include($file);
 	  $contents = ob_get_contents();
 	  ob_end_clean();

 	  $this->updateVars($webmail); 
 	  return $contents;
 	}

 	/**
 	 * sets the phpmailer header or address configuration values
 	 *
 	 * @param $key mail configuration names (header, from, to, attachment) except the body
 	 * @param $value array or string. only header takes a string as parameter.
 	 *
 	 * NAMES         $KEY     $VALUE (format)              
 	 * header     => header   ""                    
 	 * from       => site     ['mail'=>'', 'name'=>'']         //value index 'name' is optional
 	 * to         => client   ['mail'=>'', 'name'=>'']         //value index 'name' is optional
 	 * attachment => file     ['0'=>['file'=>'', 'name'=>'']]  //value index 'name' is optional
 	 *
 	 * @return bool, returns true if value is set
 	 */

 	private function mail_set($key,$value){
 	  if($key != 'body'){
 	    $replies = ['site','client','reply','cc','bcc'];

 	    if(in_array($key, $replies)){
 	      $rep['mail'] = ($value['mail'])?? '';
 	      $rep['name'] = ($value['name'])?? '';

 	      if($rep['mail'] != null){
 	        $this->$key['mail'] = $rep['mail'];
 	        $this->$key['name'] = $rep['name'];
 	      }
 	    }else{
 	      $this->$key = $value; //header
 	    }
 	    return true;
 	  }
 	  return false;
 	}
 	
 	/**
 	 * This function updates default mail configurations 
 	 *
 	 * @param $webmail mail setup configuration addresses and headers
 	 *
 	 * @return void
 	 */

 	private function updateVars(&$webmail = []){
 	  if(!empty($webmail) and is_array($webmail)){
 	    foreach ($webmail as $mail_key => $value) {
 	      $this->mail_set($key,$value);
 	    }
 	  }
 	}

 	/**
 	 * This function load php, html or xml files
 	 *
 	 * @param $config mail content as string or files (e.g php, html, xml)
     * @param $type, declare config type as 'default', 'file' or 'string' 
     * @param $type = 'default': auto detect config type
     *
     * @return void
 	 */

 	public function load($config = null, $type = 'default'){
 	  //prepare email body (this can be a file or a string)

 	  if(is_file($config)){
 	    $fileexts = ['php','html','xml'];
 	    $fileext  = pathinfo($config,PATHINFo_EXTENSION);
 	    if()
 	    $config = $this->obfile($config);
 	  }

 	  $this->body    = $config;
 	  $this->type    = $type;
 	  $this->process = true;      
 	}

 	/**
 	 * This function updates default mail configurations 
 	 *
 	 * @param $info get the value of a particular config key (header, client, site, cc, bcc)
 	 *
 	 * @return if $info exists return $info value, else return false
 	 */    

 	public function mail_info($info){
 	  if(isset($this->$info)){
 	    return $this->$info;
 	  }
 	  return false;
 	}

 	/**
 	 * This function uses the private method mail_set to set mail configuration for php, html or xml files
 	 *
 	 * @param $key mail setup configuration addresses and headers
 	 */  

 	public function set($key,$value){
 	  $this->mail_set($key,$value);
 	}

    /**
     * This function executes the mail process default mail configurations 
     * @return bool true
     */

 	public function render(){
 	  global $GLOBALS;

 	  $type = $this->type;
 	  $body = $this->body;

 	  if($type === 'string' || $type === false){
 	    $body = $body;
 	  }elseif($type === 'file'){
 	    if(!is_file($body)){ return false; }
 	    $body = $this->obfile($body);
 	  }else{
 	    $body = is_file($body)? $this->obfile($body) : $body;
 	  }

 	  //process the body
 	  $posts = (array) $_POST;
 	  $gets  = (array) $_GET;
 	  $reqs  = (array) $_REQUEST;

 	  foreach ($posts as $postkey => $postval) {
 	    $structure = '{{'.$postkey.'}}';
 	    $body = str_replace($structure, $postval, $body);
 	  } 

 	  foreach ($gets as $getkey => $getval) {
 	    $structure = '{{'.$getkey.'}}';
 	    $body = str_replace($structure, $getval, $body);
 	  }      

 	  foreach ($reqs as $reqkey => $reqval) {
 	    $structure = '{{'.$reqkey.'}}';
 	    $body = str_replace($structure, $getval, $body);
 	  } 

 	  preg_match_all('/[\{]{2}\$?\w+[\}}]{2}/', $body, $matched);
 	  $matches = $matched[0];

 	  foreach ($matches as $match) {
 	    //split response
 	     $fmatch = str_replace('{{$', '', $match);
 	     $fmatch = str_replace('}}', '', $fmatch);
 	     $replacement = isset($GLOBALS[$fmatch])? $GLOBALS[$fmatch] : false;
 	     $body = ($replacement)? str_replace($match, $replacement, $body) : $body;
 	  }

 	  $this->body = $body;
 	  return true;
 	  
 	}
 	
 	/**
 	 * This function updates default mail configurations 
 	 *
 	 * @return var $this->process;
 	 */

 	public function process(){
 	  return $this->process;
 	}

 	/**
 	 * It controls the sending of mail
 	 *
 	 * @param $send = true : send mail, else do not send
 	 * @return void
 	 */

 	public function sendmail($send = true){
 	  if(is_bool($send)){ $this->sendmail = $send; }
 	}

 	/**
 	 * It tells if mail is allowed to send
 	 *
 	 * @return bool
 	 */

 	public function send(){
 	  return $this->sendmail;
 	}

 	/**
 	 * return the response of mail
 	 * 
 	 * @param no arg return an array response
 	 * @param arg = 'json' return a json response
 	 * @param arg = array set response	 
 	 *
 	 * @return response of mail sent
 	 */

 	public function response(){
 	  $args = func_get_args();
 	  if(count($args) < 1){ return $this->response; }
 	  if($args[0] == 'json'){ return json_encode($this->response); }
 	  
 	  $args = (array)$args[0]; 

 	  foreach ($args as $key => $value) {
 	    if($key == 'content'){
 	      $this->content = $value; 
 	      continue;
 	    }
 	    $this->response[$key] = $value;
 	  }

 	}

 	/**
 	 * This return 
 	 *
 	 * @return content of mail
 	 */
 	public function content(){
 	  return $this->content;
 	}

 }