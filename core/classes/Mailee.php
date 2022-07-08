<?php
namespace spoova\core\classes;

/**
 * This class depends on external plugins PHPMailer, Emogrify to work.
 * It must be executed with files (mail-config.php and sender.php) 
 *
 * @author by Akinola Saheed <teymss@gmail.com>
 *
 * @return void
 */

 class Mailee{

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

    /**
     * @var array()
     */ 
  private $inject = [];


  /**
   * The constructor
   * @param $cssInliner instance of CssInliner
   */
  function __construct($cssInliner){
    include 'mail-setup.php';
    $this->inliner = $cssInliner;
    $this->updateVars($webmail);
  }

  /**
   * load PHPMailer configurations
   */
  public function init($mail){
    $this->mail = $mail;
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
   * Extract mail setup configuration from the mail content string or document (php, xml and html) files only
   * The setup string format is ignored and is not forward along with the mail
   *
   * @param $body mail content loaded from document or string
   */

  private function inlineConfig(){

    $body = $this->body;

    preg_match_all('@<setup type="config">[\w^\s\#:=";-\{\}\/\.]+</setup>@', $body, $matches);

    if(!isset($matches[0][0])){ return false; }

    $setup = ($matches[0][0]);
    $this->body = str_replace($setup, '', $body);
    $setup = str_replace('<setup type="config">', '', $setup);
    $setup = str_replace('</setup>', '', $setup);
    $setup = rtrim($setup);
    $setup = preg_replace('@\h+@',' ', $setup);
    $setup = preg_replace('@\n[^\S]+@',"\n", $setup);
    //var_dump($setup);
    preg_match_all('@\n\@\w+\s:\s\{.{0,}\}@', $setup, $matches);
    //var_dump($matches);

    $configs = ['header'=>'header','site_name','site_mail','client_name','client_mail','file'];
    $setups  = $matches[0];
    $iSetup  = [];

    foreach ($configs as $conkey => $conval) {
      foreach ($setups as $setupkey => $setupval) {
         if(strpos($setupval, "@".$conval." : {")){
           $setupval = substr(str_replace("@".$conval." : {", "", $setupval),0,-1);
           if($conval != 'file'){
             if(strpos($conval, "_") !== false){
              $iSplit = explode('_',$conval);
              $iSetup[$iSplit[0]][$iSplit[1]] = $setupval;
             }else{
              $iSetup[$conval] = $setupval;
            }
           }else{
              $setupval = trim($setupval);
              $expFile = explode("] [", $setupval);
              $filepath = ($expFile[0])? $expFile[0] : '';
              $filename = ($expFile[1])? $expFile[1] : '';
              
              $filepath = (substr($filepath, 0,0) == "[")? substr($url, 1) : '';
              $filename = (substr($filename, 0,-1) == "[")? substr($url, -1) : '';

              $filedata['path']  = $filepath;
              $filedata['name']  = $filename;
              $iSetup[$conval][] = $filedata;
           } 
         }
      }
    }

    $this->updateVars($iSetup);
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

    if(is_array($key) || $key == ""){
      return false;
    }
    $key = strtolower($key);    
    if($key === 'mail'){ return false; }
    if($key === 'body'){ return false; }

    $replies = ['site','client','reply','cc','bcc'];

    if(in_array($key, $replies)){
      $rep['mail'] = ($value['mail'])? $value['mail'] : '';
      $rep['name'] = ($value['name'])? $value['name'] : '';

      if($rep['mail'] != null){
        $this->$key['mail'] = $rep['mail'];
        $this->$key['name'] = $rep['name'];
      }
    }elseif($key === 'file' || $key == 'file'){

        if($key === 'files'){
          $value = $this->reItemize($value);
        }
        foreach ($value as $key => $file) {
          $rep['name'] = ($file['name'])? $file['name'] : '';
          $rep['path'] = ($file['path'])? $file['path'] : '';
          $reps[] = $rep;   
        }

        if(isset($reps)){ $this->file = $reps; }
    }else{
      $this->$key = $value; //header
    }
    return true;
  }

  /**
   * @param
   * reItemize, ungroup or restructure an array
   *
   * @return array()
  */
  private function reItemize($item){
   $box = array(); $items = (array)$item;
   foreach ($item as $key => $values) {
     foreach ($values as $value => $subvalue) {
       $box[$value][$key] = $subvalue;
     }
   }
      return $box;
  }
  
  /**
   * This function updates default mail configurations 
   *
   * @param array $webmail mail setup configuration addresses and headers
   *
   * @return void
   */

  private function updateVars(&$webmail = []){
    if(!empty($webmail) and is_array($webmail)){
      foreach ($webmail as $mail_key => $value) {
        $this->mail_set($mail_key,$value);
      }
    }
  }

  /**
   * This function load php, html or xml files
   *
   * @param $config mail content as string or files (e.g php, html, xml, txt)
     * @param $type, declare config type as 'default', 'file' or 'string' 
     * @param $type = 'default': auto detect config type
     *
     * @return void
   */

  public function load($config = null, $type = 'default'){
    //prepare email body (this can be a file or a string)

    if(is_file($config)){
      $fileexts = ['php','html','xml','txt'];
      $fileext  = pathinfo($config,PATHINFO_EXTENSION);
      if(!in_array($fileext, $fileexts)){ return false; }
      $config = $this->obfile($config);
    }

    $this->type    = $type;
    if(is_string($config) and isset($this->mail)){
        $this->body    = $config;      
        $this->process = true;
    }      
  }

  /**
   * This function updates default mail configurations 
   *
   * @param $info get the value of a particular config key (header, client, site, cc, bcc)
   *
   * @return if $info exists return $info value, else return false
   */    

  public function mail_info($info){

    if(is_array($info)){
      $infos = [];
      foreach ($info as $mail_info) {
        if(isset($this->$mail_info)){
          $infos[$mail_info] = $this->$mail_info;
        }
      }

      return !empty($infos)? $infos : false;
    }
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
   * This function updates default mail configurations 
   *
   * @return var $this->process;
   */

  private function process(){
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

  public function inject($array=[]){
    if(empty($array) || !is_array($array)) { $this->inject = []; return false; }
    $this->inject = $array;
  }


  /**
   * This function executes the mail process default mail configurations 
   * @return bool true
   */

  public function render(){

    
    if($this->process()){
      try{
        $this->response(['execTime'=>date('Y-m-d H:i:s')]);


        // render mail opened -------------------

        global $GLOBALS;
        $INJECTOR = $this->inject;

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
          $structure1 = '{{'.$postkey.'}}';
          $structure2 = '{{post:'.$postkey.'}}';
          $body = str_replace([$structure1,$structure2], $postval, $body);
        } 

        foreach ($gets as $getkey => $getval) {
          $structure1 = '{{'.$getkey.'}}';
          $structure2 = '{{get:'.$getkey.'}}';
          $body = str_replace([$structure1,$structure2], $getval, $body);
        }      

        foreach ($reqs as $reqkey => $reqval) {
          $structure1 = '{{'.$reqkey.'}}';          
          $structure2 = '{{req:'.$reqkey.'}}';
          $body = str_replace([$structure1,$structure2], $reqval, $body);
        } 

        preg_match_all('/[\{]{2}\$?\w+[\}}]{2}/', $body, $matched);
        $matches = $matched[0];
        
        //injector
        foreach ($matches as $match) {
          //split response
           $fmatch = str_replace(['{{$','}}'], '', $match);
           $replacement = isset($INJECTOR[$fmatch])? $INJECTOR[$fmatch] : false;
           $body = ($replacement)? str_replace($match, $replacement, $body) : $body;
        }        

        //globals
        foreach ($matches as $match) {
          //split response
           $fmatch = str_replace(['{{$','}}'], '', $match);
           $replacement = isset($GLOBALS[$fmatch])? $GLOBALS[$fmatch] : false;
           $body = ($replacement)? str_replace($match, $replacement, $body) : $body;
        }



        $this->body = $body;

        $this->inlineConfig();

        // mail sender setup -------------------
        $mail = $this->mail;
        $site =$this->mail_info('site')['mail'];
       

        $mail->setFrom($this->mail_info('site')['mail'],$this->mail_info('site')['name']);
        $mail->addAddress($this->mail_info('client')['mail'],$this->mail_info('client')['name']);

        //configure some additional settings;
        if($this->mail_info('reply')){
          $mail->addReplyTo($this->mail_info('reply')['mail'], $mail->addCC($this->mail_info('reply')['name'])); 
          if($mailer->mail_info('cc')){ 
            $mail->addCC($this->mail_info('cc')['mail'], $mail->addCC($this->mail_info('cc')['name'])); 
            if($this->mail_info('bcc')){ $mail->addCC($this->mail_info('bcc')['mail'], $mail->addCC($this->mail_info('bcc')['name'])); }
          }
        }

        //add files if neccessary
        if(isset($this->files))
        {
          $files = (array) $this->files;  
          foreach ($files as $index => $file) 
          {
            $name = isset($file['name'])? $file['name'] : '';
            $path = isset($file['name'])? $file['name'] : '';
            $mail->addAttachment($path, $name);
          }
        }    

        $mail->isHTML(true);
        $mail->Subject = $this->mail_info('header');

        $body = $this->inliner::fromHtml($this->mail_info('body'))->inlineCss()->render();  // construct a clean email friendly html text; 

        $mail->Body = $body;
        $mail->AltBody = strip_tags($this->mail_info('body'));
        if($this->send()){

           $this->response(['forward'=>true]); //tell mailer that forwarding was allowed

           $mail->send();
           $this->response([
             'process'  => true,
             'status'   => 1,
             'message'  => 'mail sent',
             'content'  => $body,
             'success'  => true,
           ]);
        }else{
           $this->response([
             'process'  => true,
             'message'  => 'mail has not been sent yet',
             'content'  => $body,
           ]);
        }

      }catch(Exception $e){
        $error = $e->getMessage();

        ob_start();
        include('error.php');
        $contents = ob_get_contents();
        ob_end_clean();

        $this->response([
            'process'  => true,
            'message'  => 'mail not sent: '.$error,
            'content'  => $contents,
            'error'    => true
        ]);
      }
    }else{

      $this->response([
        'message'  => 'mail not sent',
      ]);

    }

    return true;
    
  }


  /**
   * return the response of mail
   * 
   * @param no arg return an array response
   * @param arg = 'json' return a json response
   * @param arg = array() set a response   
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

  public function sent(){
    return ($this->response['status'] === 1)? true : false;
  }

  /**
   * This return 
   *
   * @return content of mail
   */
  public function content(){
    return $this->content;
  }

  /**
   * This resets the mailer class 
   *
   * @return content of mail
   */
  public function refresh(){ 
    $this->sendmail = false;
    $this->process  = false;
    $this->content  = null;
    $this->response = 
    [
      'process'  => false,
      'forward'  => false,
      'execTime' => '',
      'status'   => 0,
      'message'  => '',
    ];
  }  

 }