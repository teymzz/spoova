<?php

namespace spoova\mi\core\classes\Mailer;

use Closure;
use PHPMailer\PHPMailer\PHPMailer;
use Pelago\Emogrifier\CssInliner;
use Pelago\Emogrifier\HtmlProcessor\HtmlNormalizer;
use Pelago\Emogrifier\HtmlProcessor\HtmlPruner;
use spoova\mi\core\classes\EInfo;
use spoova\mi\core\classes\Compiler;


/**
 * This class depends on external plugins PHPMailer, Emogrify to work.
 *
 * Note:: ------------------------------------------------------------
 * For emogrifier to work, CssInliner's __construct() method ...
 * must be redefined from private to public 
 * 
 * @author by Akinola Saheed <akinolasaheed001@gmail.com>
 */
class Mailer extends PHPMailer{
    
    public $property;
    public $type;
    public $content;
    public $file;
    public $files;
    public $headers;
    public array|Closure $css = [];

    /**
     * Contains all declared headers and setup
     *
     * @var array
     */
    private $pull = ['server'=>[], 'setup'=>[]];

    private $sendmail = false;

    /**
     * Defines when the setup method is called
     *
     * @var boolean
     */
    private bool $updated = true;

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
     * Header key aliases. Canonical names are the values; legacy/alternate names
     * are the keys and resolve to the canonical name so both vocabularies work.
     *
     * @var array<string,string>
     */
    private const HEADER_ALIASES = [
        'site'   => 'sender',
        'client' => 'target',
    ];

    /**
     * Recipient headers that may hold more than one address. These are stored as
     * a list of ['mail'=>,'name'=>] entries; the rest (sender/reply) are stored
     * as a single ['mail'=>,'name'=>] entry.
     *
     * @var string[]
     */
    private const MULTI_RECIPIENTS = ['target', 'cc', 'bcc'];

    /**
     * Sets the mail server configuration
     *
     * @param array|string $setup array or array file
     * @return void
     */
    function server(array|string $setup){

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
     * 
     * @return void
     */
    function setup(array|string $setup, $value = ''){
        if(is_string($setup)){

            if((func_num_args() > 1)){
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
        $this->updated = true;
    }

    /**
     * Alias for setup method. This sets the default mail headers 
     * Sets new headers configuration
     * Overwrites previous header declared for a specific config key
     * 
     * @param array|string $setup mail headers config
     * @param string $value value to a supplied ($setup) key 
     * 
     *      - [array] => config array.
     * 
     *      - [string] => config file returning array.
     * 
     *      - [args?] => config key and value pairs
     *
     * ##### notice: For string pairs, two arguments should be supplied, 
     * else $setup is assumed to be a filename
     * 
     * @return void
     */
    function header(array|string $setup, $value = ''){
       return $this->setup(...func_get_args());
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
     * @param string $type optional [server|setup]
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
     * @return MailerInjector
     */
    public function inject($array = []) : MailerInjector {
        if(empty($array) || !is_array($array)) { 
            $this->inject = []; 
        }else{
            $this->inject = $array;
        }
        return new MailerInjector($this);
    }

    /**
     * Read and Update headers
     *
     * @return void
     */
    public function update(){

        if(!isset($this->headers['body'])) {
            return EInfo::trigger('You must add a content first before inject::update()!');
        }

        $body = Compiler::read('core/storage/__mails', fn() => $this->headers['body'])->setArgs($this->inject);
        $this->headers['body'] = (string) $body;
        
        $this->inlineConfig(); //filter out body configuration
        $this->updated = false;
    }
    
    /**
     * - Sets / Returns the content of a mail.
     * - Loads php, html or xml files.
     *
     * @param string|Closure $body mail content as an html body string, a filepath (php, html, xml, txt),
     *                              or a Closure returning the body text directly (simplest test form)
     * @param string $type optional declares config type ['auto', 'default', 'file', 'string']
     *  - when set as "auto", auto detect config type
     *
     * @return string|false|null
     */
    function content(string|Closure $body = '', string $type = 'auto'){
        //prepare email body (this can be a file, a string or a closure)

        if(func_num_args() === 0) return $this->headers['body'] ?? '';

        // A closure returns the mail body text directly — the simplest form,
        // handy for quick test mails: $mailer->content(fn() => 'Hi there');
        if($body instanceof Closure){
            $result = $body();
            $this->type            = (func_num_args() >= 2) ? $type : 'string';
            $this->headers['body'] = is_string($result) ? $result : '';
            $this->process         = true;
            $this->updated         = true;
            return null;
        }

        if(is_file($body)){
            $fileexts = ['php','html','xml','txt'];
            $fileext  = pathinfo($body,PATHINFO_EXTENSION);
            if(!in_array($fileext, $fileexts)){ 
              return false; 
            }
            $this->headers['body'] = $body = $this->obfile($body);
        }

        $this->type    = $type;
        if(is_string($body)){
            $this->headers['body'] = $body;      
            $this->process = true;
        } 
        
        $this->updated = true;   

        return null;  
    } 


    /**
     * It controls the sending of mail. Determines if a mail is authorized to be forwarded
     *
     * @param bool $send declares if to send mail or not
     *    - true sends mail while false does not send
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
    public function sendmail(string $content = ''){

        $mailer = $phpmailer = $this;

        //apply content for sending
        if($content) $mailer->content($content);

        if($mailer->process){
            try{
                $mailer->set_response(['execTime'=>date('Y-m-d H:i:s')]);

                // render mail opened -------------------
                $body = $mailer->headers['body'] ?? '';
                $type = $mailer->type;

                if($type === 'string' || $type === false){
                  
                  $body = $body;

                }elseif($type === 'file'){

                  if(!is_file($body)) return false; //no file (body) parameter found

                  $body = $mailer->obfile($body);

                }else{

                  $body = is_file($body)? $mailer->obfile($body) : $body;

                }
                
                $mailer->headers['body'] = $body;

                if($mailer->updated) $mailer->update();

                $mailContent = $body = $mailer->headers['body']; //fetch new body

                if(!trim($body, ' ')) return false; //no body parameter found
                            
                // configure phpmailer parameters
                $mailer->configurePHPMailer($this);
                $mailContent = $mailer->applyCssFormatter($mailContent);

                //set mail response ...
                if(!$mailContent){
                  $mailer->set_response([
                      'process' => true,
                      'ready'   => 0,
                      'state'   => 'not sent',
                      'status'  => 0, //not sent
                      'error'   => true,
                      'message' => 'no mail content found',
                  ]);
                  return false;
                }
                    
                $this->headers['body'] = $mailContent;
                $phpmailer->Body = $mailContent;
                $phpmailer->AltBody = strip_tags($mailContent);

                if($this->authorized()){

                    $this->set_response([
                        'attempt' => true
                    ]);

                    $sent = $phpmailer->send();
                    $phpmailer->clearAllRecipients();
                    $phpmailer->clearAttachments();

                    if($sent) {
                        $mailer->set_response([
                            'process' => true,
                            'ready'   => 1,
                            'state'   => 'sent',
                            'status'  => 2, //sent
                            'success' => true,
                            'message' => 'mail sent'
                        ]);
                    } else {
                        $mailer->set_response([
                            'process' => true,
                            'ready'   => 1,
                            'state'   => 'pending',
                            'status'  => 1,
                            'message' => 'mail ready'
                        ]);                        
                    }

                }else{
                    $mailer->set_response([
                        'process' => true,
                        'message' => 'forwarding mail not authorized'
                    ]);
                }
    
                $mailer->set_response(['content' => $body ]);


            }catch(\Exception $e){
                $error = $e->getMessage();

                $mailer->set_response([
                    'message'  => 'mail not sent: '.$error,
                    'content'  => '',
                    'error'    => true
                ]);
            }
        }else{

            $message = (!$this->body)? 'undefined mail body' : 'mail not processed';

            $this->set_response([
                'error'    => true,
                'message'  => 'mail not sent',
                'debug'    => $message
            ]);

        }

        return true;
        
    }
    
    function css(array|Closure $css){
        if(is_array($css)){
            
            $sanitize = $css['sanitize'] ?? false;
            $classes = $css['classes'] ?? [];

            if($sanitize && $classes && is_array($classes)){
                return EInfo::view('mailer->css() : method cannot apply both sanitize option with array classes. Check '.href('docs::docs/mailer'));
            }
        }
        $this->css = $css;
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
     * @param array|string $info get the value of a particular config key (header, client, site, cc, bcc)
     *
     * @return array|string
     *    - returns array if array was supplied 
     *    - returns string if string was supplied
     */    
    public function info(array|string $info) : array|string {

        if(is_array($info)){
            $infos = [];
            foreach ($info as $mailInfo) {
                $key = $this->canonicalKey($mailInfo);
                if(array_key_exists($key, $this->headers)){
                    $infos[$mailInfo] = $this->headers[$key];
                }
            }

            return $infos;
        }
        $key = $this->canonicalKey($info);
        if(array_key_exists($key, $this->headers)) return $this->headers[$key];
        return [];
    }

    /**
     * Sets the response of a mail
     * 
     * @param array $response response key and value pairs.
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
    
    public function view(){
      return $this->info('body');
    }

    /**
     * Resolve dotted & undotted file paths
     *
     * @param string $path 
     * @return boolean $php TRUE adds '.php' extension name.
     */
    private function resolve(string $path, bool $php = false) {

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
    /**
     * Resolves a header key to its canonical name (case-insensitive), mapping
     * legacy aliases such as "site" -> "sender" and "client" -> "target" so that
     * both the old and new vocabularies configure and read the same header slot.
     *
     * @param string $key supplied header key
     * @return string canonical header key
     */
    private function canonicalKey(string $key) : string {
        $key = strtolower($key);
        return self::HEADER_ALIASES[$key] ?? $key;
    }

    /**
     * Normalises a recipient header value into a list of ['mail'=>,'name'=>].
     *
     * Accepts every documented shape:
     *   - "email::name"                         (the ::name part is optional)
     *   - ['mail'=>'email', 'name'=>'name']     (associative form)
     *   - ['a@x.com::foo', ['mail'=>'b@y.com']] (a list mixing either of the above)
     *
     * @param mixed $value
     * @return array<int,array{mail:string,name:string}>
     */
    private function parseRecipients($value) : array {

        if(is_string($value)){
            return [$this->parseRecipientString($value)];
        }

        if(is_array($value)){
            // a single associative entry
            if(array_key_exists('mail', $value) || array_key_exists('name', $value)){
                return [[
                    'mail' => trim((string) ($value['mail'] ?? '')),
                    'name' => trim((string) ($value['name'] ?? '')),
                ]];
            }
            // otherwise a list of entries (each a string or associative array)
            $out = [];
            foreach($value as $entry){
                if(is_string($entry)){
                    $out[] = $this->parseRecipientString($entry);
                }elseif(is_array($entry)){
                    $out[] = [
                        'mail' => trim((string) ($entry['mail'] ?? '')),
                        'name' => trim((string) ($entry['name'] ?? '')),
                    ];
                }
            }
            return $out;
        }

        return [];
    }

    /**
     * Splits an "email::name" string into a ['mail'=>,'name'=>] pair. The name is
     * optional, so a bare "email" yields an empty name.
     *
     * @param string $value
     * @return array{mail:string,name:string}
     */
    private function parseRecipientString(string $value) : array {
        $parts = explode('::', $value, 2);
        return [
            'mail' => trim($parts[0] ?? ''),
            'name' => trim($parts[1] ?? ''),
        ];
    }

    /**
     * Coerces a stored recipient header into a list of ['mail'=>,'name'=>], so a
     * caller can iterate uniformly whether it holds a single entry or many.
     *
     * @param mixed $stored
     * @return array<int,array>
     */
    private function asRecipientList($stored) : array {
        if(!is_array($stored) || $stored === []) return [];
        if(array_key_exists('mail', $stored) || array_key_exists('name', $stored)){
            return [$stored];
        }
        return array_values($stored);
    }

    private function mail_set(string $key, $value, $type = 'setup'){

        $key = $this->canonicalKey($key);
        $isSetup = ($type !== 'update');
        //prevent invalid keys
        $esc = ['', 'mail', 'body'];

        if(in_array($key, $esc) || !$key) return false;

        //acceptable headers

        $replies = ['sender','target','reply','cc','bcc'];

        if(in_array($key, $replies)){

            // resolve strings / arrays / lists into a normalised recipient list
            $recipients = $this->parseRecipients($value);

            if(in_array($key, self::MULTI_RECIPIENTS, true)){

                // cc / bcc may carry multiple recipients: keep those with a mail
                $list = array_values(array_filter(
                    $recipients,
                    fn($rep) => trim((string) $rep['mail']) !== ''
                ));

                if($list){
                    if($isSetup){
                        $this->headers[$key]       = $list;
                        $this->pull['setup'][$key] = $list;
                    } elseif($this->pull['setup'][$key] ?? false){
                        // update: only overwrite an already-defined header
                        $this->headers[$key]       = $list;
                        $this->pull['setup'][$key] = $list;
                    }
                }

            } else {

                // sender / target / reply: a single recipient
                $rep = $recipients[0] ?? ['mail' => '', 'name' => ''];

                if(trim((string) $rep['mail']) !== ''){
                    //apply update only if the mail index is defined.
                    $this->headers[$key]['mail'] = $rep['mail'];
                    $this->headers[$key]['name'] = $rep['name'];
                }

                if($isSetup){
                    $this->pull['setup'][$key]['mail'] = $rep['mail'];
                    $this->pull['setup'][$key]['name'] = $rep['name'];
                } else {
                    if($this->pull['setup'][$key] ?? ''){
                        $this->pull['setup'][$key]['mail'] = $rep['mail'] ?: ($this->pull['setup'][$key]['mail'] ?? '');
                        $this->pull['setup'][$key]['name'] = $rep['name'] ?: ($this->pull['setup'][$key]['name'] ?? '');
                    }
                }

            }


        }elseif($key === 'file'){

            $this->headers['file'] = $value; 
            $this->pull['setup']['files'] = $value;

        }else{
            //handle header (only)
            $this->headers[$key] = $value;
            $this->pull['setup'][$key] = $value;
        }
        return true;
    }

    /**
     * This function loads a file such as php, xml and html files
     * if declared, mail setup header and addresses keys can be auto updated from supplied php files
     *
     * @param string $file files e.g php, xml, html to be loaded
     * only php files support inline mail configurations
     */
    private function obfile(string $file){
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
    * @param array $webmail mail setup configuration addresses and headers
    *
    * @return void
    */
    private function updateVars(&$webmail = []){
        if(!empty($webmail) and is_array($webmail)){
            foreach ($webmail as $mail_key => $value) {
                $this->mail_set($mail_key, $value);
            }
        }
    }

    private function configurePHPMailer(Mailer $mailer){
      $phpmailer = $mailer;

      $phpmailer->isHTML(true);
      $phpmailer->Subject = $mailer->info('header');
      $phpmailer->setFrom($mailer->info('sender')['mail'] ?? '', $mailer->info('sender')['name'] ?? '');
      foreach($this->asRecipientList($mailer->info('target')) as $to){
          if(trim((string) ($to['mail'] ?? '')) !== '') $phpmailer->addAddress($to['mail'], $to['name'] ?? '');
      }

      //configure some additional settings; reply-to, cc and bcc are independent
      if($reply = $mailer->info('reply')){
          $phpmailer->addReplyTo($reply['mail'] ?? '', $reply['name'] ?? '');
      }
      foreach($this->asRecipientList($mailer->info('cc')) as $cc){
          if(trim((string) ($cc['mail'] ?? '')) !== '') $phpmailer->addCC($cc['mail'], $cc['name'] ?? '');
      }
      foreach($this->asRecipientList($mailer->info('bcc')) as $bcc){
          if(trim((string) ($bcc['mail'] ?? '')) !== '') $phpmailer->addBCC($bcc['mail'], $bcc['name'] ?? '');
      }
      
      if(isset($mailer->files))
      {
          $files = (array) $mailer->files; 

          foreach($files as $file) 
          {
              $name = $file['name'] ?? '';
              $path = $file['path'] ?? '';
              if( $name && is_readable($path) ) $phpmailer->addAttachment($path, $name); // add files to phpmailer
          }
      }    

    }
    
    /**
     * This method applies css formatting to a supplied string using the defined options from Mailer::css() method.
     *
     * @param string $mailContent html content to be rendered 
     * @return string
     */
    public function applyCssFormatter(string $mailContent) : string {
    
      $css = $this->css;
      
      if($css instanceof Closure){

        $response = $css();
        if(is_string($response)) {
          $mailContent = $response;
        }

      } else if ($css) {

        $path = $css['path'] ?? ''; //set file path
        $media = $css['media'] ?? []; //set allowed media queries
        $normalize = $css['html5'] ?? false; //add HTML5 Document
        $excludes  = $css['excludes'] ?? false; // excluded selectors
        $sanitize  = $css['sanitize'] ?? false;//removes display none elements
        $classes = $css['classes'] ?? []; //classes to keep
        $inlined = false;
        
        if($normalize) $mailContent = HtmlNormalizer::fromHtml($mailContent)->render();
        
        $body = CssInliner::fromHtml($mailContent); // construct a clean email friendly html text; 

        if($media && is_array($media)) {
          foreach ($media as $query){
            $not = substr($query, 0, 1) === "!";
            $notquery = substr($query, 1, strlen($query));
            if($not){
              $body->removeAllowedMediaType($notquery);
            }else{
              $body->addAllowedMediaType($notquery);
            }
          }
        }
        
        if(is_array($excludes)) {
          //fix : .... 
          foreach ($excludes as $exclude){
              $body->addExcludedSelector($exclude);
          }
        }

        if(!$classes || ($classes === ':smart')) { 
          // use inLineCss when redunduntClasses are not defined!.
          $body->inlineCss($path); 
          $inlined = true;
        }

        if($sanitize){
          if(!$inlined){
              $sanitizer = $body->render();
              $sanitizer = HtmlPruner::fromHtml($sanitizer);
              $sanitizer->removeElementsWithDisplayNone();
          }else{
              $sanitizer = HtmlPruner::fromDomDocument($body->getDomDocument());
              $sanitizer->removeElementsWithDisplayNone();
          }
        }
        
        if($classes){

          if(!empty($sanitizer)){
              $html = $sanitizer;
          }else{
              if($inlined){
                  $html = HtmlPruner::fromHtml($body->render());
              }else{
                  $html = HtmlPruner::fromDomDocument($body->getDomDocument());
              }
          }

          if($inlined){
              $html->removeRedundantClassesAfterCssInlined($body);
          }else{
              $html->removeRedundantClasses($classes);
          }

        }

        if(empty($html)) $html = $body;
        
      }

      return $html ?? $mailContent;
    }
    
    /**
     * Extract mail setup configuration from the mail content string or document (php, xml and html) files only
     * The setup string format is ignored and is not forward along with the mail
     *
     * @return void
     */
    private function inlineConfig(){

        // $body as mail content loaded from document or string
        $body = $this->headers['body'] ?? '';

        //replace configuration pattern from template & use configuration

        $body = preg_replace_callback('~<setup mail:header>(.*)?</setup>(\n)?~is', function($matches){

            $setup = $matches[1]  ?? '';

            if($setup){

                //match all lines format (@header, @site_name, @site_mail, @client_name, @client_mail, @attachment)
                preg_match_all('~\@\w+\s+?:\s\'.*?\'~is', $setup, $matches);
    
                $setups  = $matches[0];
                $iSetup  = [];

                preg_replace_callback('~\@(\w+)\s+?:\s\'(.*)?\'~is', function($matched) use(&$iSetup){
                    $header_keys = explode('_',$matched[1]);
                    $header_main_key = $header_keys[0];
                    $header_sub_key  = $header_keys[1] ?? false;
                    
                    if($header_sub_key){
                        $iSetup[$header_main_key][$header_sub_key] = $matched[2];
                    } else {
                        if(in_array(strtolower($header_main_key), ['attachment', 'file'])){
                            //format: @attachment  : 'filepath::filename'
                            $header_main_key = 'file';
                            $filedata = explode('::', $matched[2], 2);
                            $filepath = rtrim(ltrim($filedata[0] ?? '', ' '), ' ');
                            $filename = rtrim(ltrim($filedata[1] ?? '', ' '), ' ');

                            $fileinfo = [];

                            if($filepath)  $fileinfo['path'] = $filepath;
                            if($filename)  $fileinfo['name'] = $filename  ?: $filepath;

                            $iSetup[$header_main_key][] = $fileinfo;
                        }elseif(in_array($this->canonicalKey($header_main_key), self::MULTI_RECIPIENTS, true)){
                            //target/cc/bcc may be declared on multiple lines; accumulate them
                            $iSetup[$header_main_key][] = $matched[2];
                        }else{
                            $iSetup[$header_main_key] = $matched[2];
                        }
                    }
                }, $setups);
    
                $this->updateVars($iSetup);
                
            }

            return '';

        }, $body);

        $this->headers['body'] = $body;  

    }

    /**
     * @param array|string $item reItemize, ungroup or restructure an array
     *
     * @return array
     */
    private function reItemize(array|string $item) : array {
        $box = array(); $items = (array) $item;
        foreach ($items as $key => $values) {
            foreach ($values as $value => $subvalue) {
                $box[$value][$key] = $subvalue;
            }
        }
        return $box;
    }

}