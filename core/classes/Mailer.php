<?php

namespace spoova\core\classes;

use Pelago\Emogrifier\CssInliner;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * This class depends on external plugins PHPMailer, Emogrify to work.
 *
 * Note:: ------------------------------------------------------------
 * For emogrifier to work, CssInliner's __construct() method ...
 * must be redefined from private to public 
 * 
 * @author by Akinola Saheed <teymss@gmail.com>
 */
class Mailer extends PHPMailer{
    
    /**
     * Contains all declared headers and setup
     *
     * @var array
     */
    private $pull = ['server'=>[], 'setup'=>[]];

    private $sendmail = false;

    /**
     * @var bool
     */   
    private $process  = false;

    /**
     * message content body
     *
     * @var string
     */
    private $body;

    /**
     * response returned by mailer
     *
     * @var array
     */ 
    private $response = 
    [
        'process'  => false,
        'attempt'  => false, //becomes true when attempt is made to send a message
        'execTime' => null, //execution time
        'ready'    => 0, // 0, 1
        'status'   => 0, // 0, 1, 2
        'message'  => '',
    ];

    /**
     * @var array()
     */ 
    private $inject = [];

    /**
     * CssInliner
     *
     * @var CssInliner
     */
    private static CssInliner $CssInliner;

    
    /* 
        // parent construct is assumed
        function __construct()
        {
            parent::__construct(...func_get_args());
        } 
    */
   
    /**
     * Css renderer
     *
     * @param CssInliner $CssInliner
     * @return void
     */
    static function engine(CssInliner $CssInliner) {
        self::$CssInliner = $CssInliner;
    }

    /**
     * Sets the mail server configuration
     *
     * @param array|string $setup array or array file
     * @return void
     */
    function server($setup){

        $configs = $setup;

        if(is_string($setup)) { 
            $setup = str_replace(['/','\\'],'.', $setup);
            $setup = $this->resolve($setup, true);

            if(!is_file($setup)) return;
            
            $configs = include($setup);
        }

        if(is_array($configs)){
            foreach($configs as $config => $property){
                $this->property = $property;
                $this->pull['server'][$config] = $property;
            }
        }

    }

    /**
     * Sets the default mail headers 
     * Sets new headers configuration
     * Overwrites previous header declared for a specific config key
     * 
     * @param array|string $setup mail headers config
     * @param string $value value to a supplied ($setup) key 
     * 
     *      [array] => config array.
     * 
     *      [string] => config file returning array.
     * 
     *      <args> => config key and value pairs
     *
     * @notice: For string pairs, two arguments should be supplied, 
     * else $setup is assumed to be a filename
     */
    function setup($setup, $value = ''){
        if(is_string($setup)){

            if((func_num_args() > 1)){
                $args = func_get_args();
                $webmail = [$setup => $value];
            } else {
                $setup = $this->resolve($setup, true);      
                
                //setup file must include $webmail or return an array
                $item = include $setup;
                if(is_array($item)) $webmail = $item;                
            }

        } else {
            $webmail = $setup;
        }

        $this->updateVars($webmail);

    }

    /**
     * This function updates default mail headers already set 
     * for php, html or xml files
     *
     * @param string $key mail setup configuration addresses and headers
     * @param string $value relative value for supplied key
     * 
     * @return void
     * 
     * @notice Files cannot be synced, they must be redeclared.
     */  
    public function sync($key, $value){
        $this->mail_set($key, $value, 'update');
    }

    /**
     * Pulls the current server or mail setup configurations  headers data
     *
     * @param string $type [server|setup]
     * 
     * @return array
     */
    public function pull(string $type) : array{
        
        if(isset($this->pull[$type]))
            return $this->pull[$type];
        
        return [];

    }


    /**
     * Inject variables
     *
     * @param array $array
     * @return void
     */
    public function inject($array=[]){
        if(empty($array) || !is_array($array)) { $this->inject = []; return false; }
        $this->inject = $array;
    }
    
    /**
     * - Sets / Returns the content of a mail.
     * - Loads php, html or xml files.
     *
     * @param string $body mail content as html body string or filepath (e.g php, html, xml, txt)
     * @param $type, declares config type ['default', 'file', 'string'] 
     * @param $type = 'auto': auto detect config type
     *
     * @return string|void
     */
    function content($body = null, $type = 'auto'){
        //prepare email body (this can be a file or a string)

        if(func_get_args() == 0) return $this->body;

        if(is_file($body)){
            $fileexts = ['php','html','xml','txt'];
            $fileext  = pathinfo($body,PATHINFO_EXTENSION);
            if(!in_array($fileext, $fileexts)){ return false; }
            $body = $this->obfile($body);
        }

        $this->type    = $type;
        if(is_string($body)){
            $this->body    = $body;      
            $this->process = true;
        }      
    } 


    /**
     * It controls the sending of mail
     *
     * @param $send = true : send mail, else do not send
     * @return void
     */
    public function authorize(bool $send = true){
        $this->sendmail = $send;
    } 

    /**
     * It tells if mail is allowed to send
     *
     * @return bool
     */
    public function authorized(){
        return $this->sendmail;
    }

    /**
     * This function executes the mail process default mail configurations 
     * 
     * @return bool true
     */
    public function sendmail($content = ''){

        //apply content for sending
        if($content) $this->content($content);

        if($this->process){
            try{
                $this->set_response(['execTime'=>date('Y-m-d H:i:s')]);


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
                $mail = $this;
                $site = $this->info('site')['mail'] ?? '';
            
                $mail->setFrom($this->info('site')['mail'] ?? '', $this->info('site')['name'] ?? '');
                $mail->addAddress($this->info('client')['mail'] ?? '', $this->info('client')['name'] ?? '');

                //configure some additional settings;
                if($this->info('reply')){
                    $mail->addReplyTo($this->info('reply')['mail'], $mail->addCC($this->info('reply')['name'])); 
                    if($mail->info('cc')){ 
                        $mail->addCC($this->info('cc')['mail'], $mail->addCC($this->info('cc')['name'])); 
                        if($this->info('bcc')){ $mail->addCC($this->info('bcc')['mail'], $mail->addCC($this->info('bcc')['name'])); }
                    }
                }

                //add files if neccessary
                if(isset($this->files))
                {
                    $files = (array) $this->files;  
                    foreach ($files as $index => $file) 
                    {
                        $name = isset($file['name'])?? '';
                        $path = isset($file['name'])?? '';
                        $mail->addAttachment($path, $name);
                    }
                }    

                $mail->isHTML(true);
                $mail->Subject = $this->info('header');

                $body = (self::$CssInliner)::fromHtml($this->info('body') ?: '')->inlineCss()->render();  // construct a clean email friendly html text; 
                
                $mail->Body = $body;
                $mail->AltBody = strip_tags($this->info('body') ?: '');
                
                if($this->authorized()){

                    $this->set_response([
                        'attempt' => true
                    ]);

                    $sent = $mail->send();
                    $mail->clearAllRecipients();
                    $mail->clearAttachments();

                    if($sent) {
                        $this->set_response([
                            'process' => true,
                            'ready'   => 1,
                            'state'   => 'sent',
                            'status'  => 2, //sent
                            'success' => true,
                            'message' => 'mail sent',
                        ]);
                    } else {
                        $this->set_response([
                            'ready'   => 1,
                            'state'   => 'pending',
                            'status'  => 1,
                            'message' => 'mail ready'
                        ]);                        
                    }

                }else{
                    $this->set_response([
                        'process'  => true,
                        'message'  => 'mail not forwarded yet'
                    ]);
                }

                $this->set_response(['content' => $body ]);

            }catch(\Exception $e){
                $error = $e->getMessage();
                // ob_start();
                // include('error.php');
                // $contents = ob_get_contents();
                // ob_end_clean();

                $this->set_response([
                    'process'  => true,
                    'message'  => 'mail not sent: '.$error,
                    'content'  => '',
                    'error'    => true
                ]);
            }
        }else{

            $message = (!$this->body)? 'void message' : 'not processed';

            $this->set_response([
                'message'  => 'mail not sent',
                'emess'    => $message
            ]);

        }

        return true;
        
    }

    /**
     * Check if a mail is ready but not sent
     *
     * @return bool
     */
    public function attempted() : bool{
        return ($this->response['status'] === 1);
    }

    /**
     * Check if a mail was forwarded
     * 
     * @param string $enviro options [online|offline]
     * @return bool
     */
    public function sent($enviro = 'online') : bool{
        if($enviro === 'offline'){
            if(defined('online')) return $this->casted(!online);
        }
        return ($this->response['status'] === 2);
    }
    
    /**
     * Check if a mail was attempted but not sent
     * For offline testing.
     *
     * @param bool $enviro enironment
     * 
     * @return bool
     */
    public function casted($enviro = true) : bool{
        return ($this->attempted() && !$this->sent() && $enviro);
    }    

    /**
     * This function returns mail data values 
     *
     * @param $info get the value of a particular config key (header, client, site, cc, bcc)
     *
     * @return array|string
     *      array => when array is supplied 
     *      string => when string is supplied
     */    
    public function info($info){

        if(is_array($info)){
            $infos = [];
            foreach ($info as $info) {
                if(isset($this->$info)){
                    $infos[$info] = $this->$info;
                }
            }

            return $infos;
        } 
        if(isset($this->$info)) return $this->$info;
        return [];
    }

    /**
     * Sets the response of a mail
     * 
     * @param array $array response key and value pairs.
     * 
     * @return void
     */
    public function set_response($response = []){
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
     * Sets / Returns the response of mail sent
     * 
     * @param <args> args supplied arguments.
     * 
     *      - args < 1 => return an array response
     *      - args = 'json' => return a json string response
     *      - args = (array) => sets response with array supplied and returns void 
     *
     * @return array
     */
    public function response() : array {

        return $this->response;

    }

    /**
     * Resolve dotted & undotted file paths
     *
     * @param string $path
     * @return bool $php add php extension
     */
    private function resolve($path, bool $php = false) {

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if($ext != 'php') $path .= '.php';

        $exppath = explode('.', $path);
        $expnumb = count($exppath) - 1;

        $extpath = $exppath[$expnumb];

        if( $extpath == 'php' ) unset($exppath[$expnumb]);
        $path = implode(DIRECTORY_SEPARATOR, $exppath);
        $path .= ($php)? '.php' : '';

        return $path;
    }


    /**
     * Sets the phpmailer header or address configuration values
     * Note:: The mail body is handled by the sendmail() or content() methods
     * 
     * @param string $key mail configuration names (header, from, to, attachment) except the body
     * @param array|string $value only header takes a string as parameter.
     * @param string $type [setup | update]
     *
     * NAMES         $KEY     $VALUE (format)              
     * header     => header   ""                    
     * from       => site     ['mail'=>'', 'name'=>'']         //value index 'name' is optional
     * to         => client   ['mail'=>'', 'name'=>'']         //value index 'name' is optional
     * attachment => file     ['0'=>['file'=>'', 'name'=>'']]  //value index 'name' is optional
     *
     * @return bool, returns true if value is set
     * 
     */
    private function mail_set(string $key, $value, $type = 'setup'){

        $key = strtolower($key);
        $isSetup = ($type !== 'update');

        //prevent invalid keys
        $esc = ['', 'mail', 'body'];
        
        if(in_array($key, $esc)) return false; 

        //acceptable headers

        $replies = ['site','client','reply','cc','bcc'];

        if(in_array($key, $replies)){
            $rep['mail'] = ($value['mail'])?? '';
            $rep['name'] = ($value['name'])?? '';

            if($rep['mail'] != null){
                $this->$key['mail'] = $rep['mail'];
                $this->$key['name'] = $rep['name'];
            }

            if($isSetup){
                $this->pull['setup'][$key]['mail'] = $rep['mail'];
                $this->pull['setup'][$key]['name'] = $rep['name'];
            } else {
                if($this->pull['setup'][$key] ?? ''){
                    $this->pull['setup'][$key]['mail'] = $rep['mail']?: $this->pull['setup'][$key]['mail']?? '';
                    $this->pull['setup'][$key]['name'] = $rep['name']?: $this->pull['setup'][$key]['name']?? '';
                }
            }


        }elseif($key === 'file' || $key == 'file'){

            if($key === 'files'){
                $value = $this->reItemize($value);
            }
            foreach ($value as $key => $file) {
                $rep['name'] = ($file['name'])?? '';
                $rep['path'] = ($file['path'])?? '';
                $reps[] = $rep;   
            }

            if(isset($reps)){ 
                $this->file = $reps; 
                $this->pull['setup']['files'] = $reps;
            }
        }else{
            //handle header (only)
            $this->$key = $value;
            $this->pull['setup'][$key] = $value;
        }
        return true;
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
    * This function updates default mail configurations 
    *
    * @param $webmail mail setup configuration addresses and headers
    *
    * @return void
    */
    private function updateVars(&$webmail = []){
        if(!empty($webmail) and is_array($webmail)){
            foreach ($webmail as $mail_key => $value) {
                javaconsole($value);
                $this->mail_set($mail_key, $value);
            }
        }
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
                $setupval = substr(str_replace("@".$conval." : {", "", $setupval), 0, -1);
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
                    $filepath = ($expFile[0])?? '';
                    $filename = ($expFile[1])?? '';
                    
                    $filepath = (substr($filepath, 0,0) == "[")? substr($filepath, 1) : '';
                    $filename = (substr($filename, 0,-1) == "[")? substr($filepath, -1) : '';

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

}

mailer::engine(new CssInliner);