<?php

namespace spoova\core\classes;

use \User;

/**
 * class Slicer
 * 
 * @package spoova\core\classes
 * @Author Akinola Saheed <teymss@gmail.com>
 * @todo add more Isset methods, User calls
 * @todo sort urls
 */
class Slicer extends Directives{ 
    
     /**
      * Rendered body content
      *
      * @var string
      */
     private static $body = '';
     
     /**
      * Router method (post or get)
      *
      * @var [type]
      */
     private static $method;
    
     private const auth_directives = [
      'Auth'  => '~@Auth:(.*?)?@Auth;~is', //to change this
      'Guest'     => '~@Guest:(.*?)?@Guest;~is', //to change this     
     ];

     private const placeholders_structure = '
      ~[\{]{2}\\s?\$?[\w+]+:?([\(]?[\w+,:\\s]*?[\)]?)?\??\\s?[\}]{2}~
     ';   

     private const placeholders = [
       //spec resolve
      'GET'  => '~[\{]{2}\s?get:[a-zA-Z_][a-zA-Z_0-9]*+\s?[\}]{2}~',
      // 'GETISSET'  => '~[\{]{2}\s?get:[a-zA-Z_][a-zA-Z_0-9]*+\?\s?[\}]{2}~',
      'POST' => '~[\{]{2}\s?post:[a-zA-Z_][a-zA-Z_0-9]*\s?[\}]{2}~',
      // 'POSTISSET' => '~[\{]{2}\s?post:[a-zA-Z_][a-zA-Z_0-9]*\?\s?[\}]{2}~',
      'REQUEST'  => '~[\{]{2}\s?req:[a-zA-Z_][a-zA-Z_0-9]*\s?[\}]{2}~',
      // 'REQUESTISSET'  => '~[\{]{2}\s?req:[a-zA-Z_][a-zA-Z_0-9]*+\?\s?[\}]{2}~',
      'VARIABLES_LOCAL' => '~[\{]{2}\s?[[a-zA-Z_][a-zA-Z_0-9]*\s?\??(\?\s\'[\s\w+\\\(\)]*?\')?\s?[\}]{2}~',
       
      //normal resolve
      'NORM' => '~[\{]{2}.*?[\}]{2}~',

     ];

     private static $directives = [
      '@authDirect',
      '@guestDirect',
      '@auth',
      '@guest',
      '@meta',
      '@import',
      '@include',
      '@Res',
      '@src',
      '@ress', //alias for src
      '@mapp',
      '@mass',
      '@assets', 
      '@live',
      '@show',
      '@view',
      '@template',
      '@yield',
      '@layout',
      '@lay',
      '@flash',
      '@domurl', 
      '@images',
      '@route'
     ];

     private static $comments = [];

     private static $excludes = [];     

     /**
      * Resolve patterns in rendered content from loaded template
      *
      * @param string $body raw file(template) content
      * @param boolean $return return data
      * @return Slicer
      */
     public static function slice($body, $return = false){ 
        if($return) return self::process($body, $return);
        self::process($body, $return);
        return new self;
     }

     protected function endSlice(){

        self::$locals = [];

     }

     /**
      * Slice urls to nameing conventions
      *
      * @return string
      */
     public static function sliceUrl(string $url = '') : string {

        $ext = '';
        $url = str_replace("\\", "/", $url);

        $val_ext = ['htm:','php:'];

        $pre_ext = substr($url, 0, 4); 

        if(in_array($pre_ext, $val_ext)) {
          $ext = ($pre_ext == 'htm:')? self::extensions['html'] : self::extensions['php'];
          if($ext){
            $url = substr($url, 4, strlen($url));
          }
        }else{
          $ext = self::defaultExtension;
        }

        $url = trim($url, '. ');
        $url = str_replace('.', '/', $url);

        return $url.$ext;
     }

     /**
      * Renders all placeholders and directives
      *
      * @param string $body loaded template data
      * @param bool $return directs the method to store or return rendered body
      * @return void
      */
     private static function process($body, $return){ 
        
        if($body){

            self::sort_comments($body);
            self::sort_excludes($body);

            self::sort_placeholders($body);

            //remove unauthorized sections off the grid
            self::sort_auth($body);

            //remove authorized sections off the grid
            self::sort_guest($body);         

            // //apply directives on body
            self::sort_directives($body);

            self::unsort_excludes($body);        
            self::sort_conditions($body);
            self::unsort_comments($body);
        }

        if($return) return $body;

        self::$body = $body;

    }

    private static function sort_comments(&$body){
      
      //fetch all comment-like structures in body
      preg_match_all('~<!--.*?-->~s', $body, $fetches);

      $fetches = $fetches[0];

      foreach($fetches as $fetched) {
       $hashed = base_encode($fetched);
       $body = str_replace($fetched, "<!--".$hashed."-->", $body);
       self::$comments[] = "<!--".$hashed."-->";      
      }

    }

    private static function unsort_comments(&$body){
      foreach(self::$comments as $comment){
        $body = str_replace($comment, base_decode(substr($comment, 4, strlen($comment) - 7)), $body);
      }
    }

    private static function sort_conditions(&$body){
      $body = preg_replace('~@if\((.*?)\):~', '<?php if($1): ?>', $body);
      $body = preg_replace('~@elseif\((.*?)\):~', '<?php elseif($1): ?>', $body);
      $body = preg_replace('~@else:~', '<?php else: ?>', $body);
      $body = preg_replace('~@endif;~', '<?php endif; ?>', $body);

      $body = preg_replace('~@do:~', '<?php do: ?>', $body);
      $body = preg_replace('~@while\((.*?)\):~', '<?php while($1): ?>', $body);
      $body = preg_replace('~@endwhile;~', '<?php endwhile; ?>', $body);

      $body = preg_replace('~@for\((.*?)\):~', '<?php for($1): ?>', $body);
      $body = preg_replace('~@endfor;~', '<?php endfor; ?>', $body);
      
      $body = preg_replace('~@each\((.*?)\):~', '<?php foreach($1): ?>', $body);
      $body = preg_replace('~@endeach;~', '<?php endforeach; ?>', $body);
      $body = preg_replace('~@foreach\((.*?)\):~', '<?php foreach($1): ?>', $body);
      $body = preg_replace('~@endforeach;~', '<?php endforeach; ?>', $body);

      $body = preg_replace('~@break;~', '<?php break; ?>', $body);

      //handling switch statements
      $body = preg_replace('~@switch\((.*?)\):~', '<?php switch($1): ', $body);       
      $body = preg_replace('~@endswitch;~', 'endswitch; ?>', $body);
      
      /* $body = preg_replace('~@case\s(.*?)?:~', ' case $1: ?>', $body); */
/*       $body = preg_replace('~@case\s(.*?)?:~', '<?php case $1: ?>', $body);
      $body = preg_replace('~@default\s(.*?)?:~', '<?php default $1: ?>', $body); */
    }

    private static function sort_excludes(&$body){
      
      //fetch all comment-like structures in body
      preg_match_all('~@\((.*?)\)@~', $body, $fetches);

      $fetches = $fetches[0];

      foreach($fetches as $fetched) {
       $hashed = base_encode($fetched);
       $body = str_replace($fetched, "<!--".$hashed."-->", $body);
       self::$excludes[] = "<!--".$hashed."-->";      
      }
            
    }

    private static function unsort_excludes(&$body){
      foreach(self::$excludes as $exclude){
        $mod = base_decode(substr($exclude, 4, strlen($exclude) - 7));
        $body = str_replace($exclude, $mod, $body);
        $body = preg_replace('~@\(\{\{(.*?)\}\}\)@~', "&#123;&#123;$1&#125;&#125;", $body);
        $body = preg_replace('~@\((.*?)\)@~', "&#64;$1", $body);
        
      }
    }

    /**
     * Sorts all placeholders that are not directives
     *
     * @param string $body refrenced body template
     * @return void
     */
    private static function sort_placeholders(&$body){
      
      $specas = ['GET','POST','REQUEST','VARIABLES_LOCAL'];

      //fetch all placeholder-like structures in body
      preg_match_all(self::placeholders_structure, $body, $fetches);
      
      $allFetches = ($fetches[0])?? [];

      $requests = ['GET','POST','REQUEST'];
      $placeholders = self::placeholders;

      $results = [];
     
      foreach($placeholders as $placeholderkey => $pattern){


          preg_match_all($pattern, $body, $matches);

          $matches = ($matches[0])?? false;

          #If matches was found in body for the current pattern
          if($matches) {

            foreach($matches as $placeholder){

              //iterate over relative matches for current placeholder pattern
              //render the placeholder with the placeholder pattern's key
              if($placeholderkey == "VARIABLES_LOCAL"){
 
                //replace braces and resolve value
                $anchor = str_replace([' ','{','}'], '', $placeholder);

                //store resolved value into array
                $results[$placeholder] = self::handleLocalVariables($anchor, $placeholder);

              }elseif(in_array($placeholderkey, $requests)){

                if(self::testMethod($placeholderkey, $isStrict)){

                      //$type is allowed, proceed to get content
                      $anchor = str_replace([' ','{', '}','post', 'get', 'req', ':', '?'], '', $placeholder);
                      $results[$placeholder] = self::handleRequests($placeholderkey, $placeholder, $anchor);
                      
                  }
              }

            }         

        }

      }

      //Replace resolved patterns
      foreach ($results  as $patterns => $resolved){
        $body = str_replace($patterns, $resolved, $body);
      } 

      $body = preg_replace('~{{\s?([\$a-zA-Z_\\s)\(-]+)\s?}}\s?~is','<?= $1 ?>', $body);
      $body = preg_replace('~{{\s?([\$a-zA-Z_\\s)\(-]+)\??\s?}}\s?~is','<?= ($1)?? "" ?>', $body);
      $body = preg_replace('~{{(.*?)?}}\s?~is','<?= ($1)?? "" ?>', $body);
     
    }

    /**
     * Remove unauthorized layout fields from application
     * 
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_auth(&$body){

      //search for UserAuth calls
      
      preg_match(self::auth_directives['Auth'], $body, $authtext);

      $authsections = ($authtext)?? false;
      if( User::id() ){

        $body = str_replace(['@Auth:','@Auth;'], '', $body);

      }else{
        if(is_array($authsections)){
          foreach($authsections as $authsection){
            if(strpos($authsection, "@Auth:")){
               $body = str_replace($authsection, '', $body);
            }
          }          
        }
      }
      
    }

    /**
     * Add the guest layout when user is not authenticated
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_guest(&$body){
      
      if(User::id()){ 
        //search and remove all Guest calls
        preg_match_all(self::auth_directives['Guest'], $body, $guestsections);
           
        $guests = ($guestsections[0])?? [];
        
        foreach($guests as $guest){ 
          $body = str_replace($guest, '', $body);
        }
      }else if( !User::id() ) {
        //remove only Guest Pattern
        $body = str_ireplace(['@Guest:','@Guest;'],'',$body);
      }
      
    }

    /**
     * Sort directive patterns using the directives class
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_directives(&$body){

      //iterate over declared directives in self::$directives
      foreach(self::$directives as $directValue){
        if(stripos($body, $directValue) !== false){
          //handle other directives
          $handle = "directives".ltrim( $directValue, '@');
          
          if(method_exists(get_class(new self), $handle)){
            $body = self::$handle($body);            
          }

        }
      }

    }

    /**
     * Sort User(class) calls. No documentations yet
     * will be added later
     *
     * @return string
     */
    private static function sort_users(){}

    /**
     * Sort classes. No documentations yet
     * will be added later
     * 
     * @return string
     */    
    private static function sort_class(){ }

    //* PLACEHOLDER HANDLER METHODS ------------------------------------------------------------------------------ */

    /**
     * Resolves out the content of the placeholder
     *
     * @param string $anchor placeholder's content
     * @param string $placeholder the matched braces
     * @return string
     */
    private static function handleGlobalVariables($anchor, $placeholder){  

        $isset = (substr($anchor, strlen($anchor) - 1, strlen($anchor)) == "?");
    
        if($isset){
          $var = rtrim($anchor, '?');
          $result = ($GLOBALS[$var])?? '';
        }else{
          $result = ($GLOBALS[$anchor])?? $placeholder;  
        }
        if (is_array($result)) {
          trigger_error('array values cannot be returned in template scope for "'.$anchor.'"');
          return false;
        }
        return $result;
    }

    /**
     * Handles all local variables declared
     * Local variables exists only as arguments 
     *
     * @param string $anchor placeholder's content
     * @param string $placeholder the matched braces
     * @return string
     */
    private static function handleLocalVariables($anchor, $placeholder){
        $explode = explode("??", $placeholder);
        $value = '';

        if(count($explode) == 2){
          $anchor = trim(ltrim($explode[0],"{{"))."?";
          $value  = rtrim(ltrim(rtrim($explode[1],'}}'),"' "), "' ");
        }
        
        $isset = (substr($anchor, strlen($anchor) - 1, strlen($anchor)) == "?");

        if($isset){
          $anchor = rtrim($anchor, '?');
          $result = (self::$locals[$anchor])?? $value;
        }else{
          $result = (self::$locals[$anchor])?? $placeholder;  
        }
        if (is_array($result)) {
          trigger_error('array values cannot be returned in template scope for "'.$anchor.'"');
          return false;
        } 
        return $result;
    }    
    
    /**
     * Handle all request formats
     *
     * @param string $placeholderkey the relative placeholder's key
     * @param string $placeholder the matched braces
     * @param string $anchor the content of matched braces
     * @return string
     */
    private static function handleRequests($placeholderkey, $placeholder, $anchor){
      
      //(sort variables or calculations here later...)
      $type = str_replace('ISSET', '', $placeholderkey);

      if (is_array($GLOBALS['_'.$type][$anchor])) {
        trigger_error('array values cannot be returned in template scope');
      }      
      
      if($placeholderkey === $type.'ISSET'){

        //for variables only
        return ($GLOBALS['_'.$type][$anchor])??  '';   
        
      }else{
        //run as base request method
        return ($GLOBALS['_'.$type][$anchor])??  $placeholder;
      }     
      
    }
    
    /**
     * Handles all functions and classes
     *
     * @param string $placeholderkey  class placeholder pattern's key
     * @param string $placeholder the matched braces
     * @param string $anchor the matched braces content
     * @param string $callType - options [function | class]
     * @param string $accessor
     * @return string
     */
    private static function handleFunctions($placeholderkey, $placeholder, $anchor, $callType = 'function', $accessor = ''){

      //(sort variables or calculations here later...)
      $type = str_replace('ISSET', '', $placeholderkey);
      //split response
      $expfmatch = explode('(', $placeholder);
      $funcName = trim($expfmatch[0]);
      
      $params   = explode(',', str_replace([' ', '(', ')', '?'],'',$expfmatch[1]));
      $nparams  = [];
      if($callType === "class"){
        $funcName = explode($accessor, str_replace(['@', '?'], '', $placeholder))[0];
      }

      $funcName = str_replace([' ', '{', '}'],'',$funcName);

      //test function if it is function and function does not exist
      if($callType === 'function'){

        if(!function_exists($funcName)) return ($placeholderkey === $type.'ISSET')? '' : $placeholder;

      }

      //process all other functions or methods

      if(!empty($params)){

        //if function parameters are supplied, then try to sort parameters as digit or variable
        foreach($params as $param){
          
          if(!empty($param)){
            
            if(!is_numeric($param)){

               //sort as variable & decide if it exists
               $isVar = (substr($param, 0, 1) === ':');
              
              if($isVar){

                $param = ltrim($param, ':');
                if(isset($GLOBALS[$param])){
                  $nparams[] = $GLOBALS[$param];
                } else {
                  $nparams[] = '';
                }

              }else{
                
                $nparams[] = $param;

              }
              
            }else{
              
              //sort as digit
              $nparams[] = $param;
              
            }
            
          }
          
        }     

      } 

      //process as function or as class
      if($callType === 'function'){

        return $replacement = ($nparams === false)? $placeholder : $funcName(...$nparams);     

      }else{

        $isMethod = (strpos($placeholder, '(') !== false); 

        $called = explode($accessor, $placeholder)[1];
        $called = explode('(', $called)[0];
        $classvar = $funcName;
        
        if(isset($GLOBALS[$classvar])){

          $class = $GLOBALS[$classvar];
          
          if(@get_class($class)){
            
            //do this
            if($accessor == '::'){
              if($isMethod){
                $replacement = $class::$called(...$nparams);
              }else{
                $replacement = $class::$called;
              }
            }else{
              if($isMethod){
                $replacement = $class->$called(...$nparams);
              }else{
                $replacement = $class->$called;
              }              
            }

          } else {
            
            $replacement = ($placeholderkey === $type.'ISSET')? '' : $placeholder;
           
          }


        }else{
          //check for isset first  
           $replacement = ($placeholderkey === $type.'ISSET')? '' : $placeholder;
        }
       
        if($replacement !== $placeholder){
            if (is_array($replacement)) {
              trigger_error('array values should not be used in template scope');
              //$replacement = json_encode($replacement);
            }
            return str_replace($placeholder, $replacement, $anchor);
        }else{
            return $anchor;
        }
        
      }

    }
    
    private static function testMethod($method, &$isStrict = true){
      if(self::$method && self::$method !== $method){
        
        return false;
        
      }else if(self::$method !== $method){
        
        $isStrict = false;
        
      }
      return true;
    }

/*     

    private static function sort_url($url, &$sorted = '', &$id = '', &$varStrict = false){
        //handle urls
        preg_match_all('~[\{]{2}\$??\w+\(([\w+\s,]+)?\)[\}}]{2}~', $sorted, $matched); 
        $uri = ltrim("/user/feks/{seem?}","/");
        $dir = (pathinfo($uri,PATHINFO_DIRNAME));
        
        $results = [
            'mod'=> '',
            'viw'=> '',
            'con'=>'',
        ];

        //if directory is supplied
        if($dir){
            
            // //sort last item (only the one isset can be applied upon)
            $query = basename($uri);

            //sort MVC
            $mvc = explode('/', $uri);
            $mod = $viw = $con = '';

            if(isset($mvc[0])){
                $mod = $mvc[0];
                unset($mvc[0]);
            }

            if(isset($mvc[1])){
                $viw = $mvc[1];
                unset($mvc[1]);
            }             

            $viw = ($mvc[1])?? '';
            $con = ($mvc[2])?? '';

            preg_match_all('~[\{]{1}\$?[a-zA-Z][a-zA-Z-0-9]+?\?[\}]{1}~', $query, $sorted1); 
            preg_match_all('~[\{]{1}\$?[a-zA-Z][a-zA-Z-0-9]+?[\}]{1}~', $query, $sorted2); 
            preg_match_all('~[\{]{1}\$?[a-zA-Z][a-zA-Z-0-9]+?[\}]{1}~', $query, $sorted3);
            
            if(!empty($sorted1)){
                $var = str_replace(['{','}','?'], '', $sorted1[0]);
                $varStrict = false;
            }
            if (!empty($sorted2)) {
                $var = str_replace(['{','}','?'], '', $sorted2[0]);
                $varStrict = true;

            } elseif(!empty($sorted3)) {
            
            } else {
            
            }
        }
        
    } */

    /**
     * Loads a supplied file path. Only variable(local) parameters supplied will be resolved
     * This method is called before slice method
     *
     * @param string $file file url
     * @param array $params variables passed as arguments
     * @return string contents of rendered file
     */
    public static function loadTemplate($file, $params = []){

      foreach($params as $locals => $value){
        $$locals = $value;
      }

      foreach($params as $param => $value){

        if(!is_array($value) and !is_bool($value)) {
          $$param = $value; 
            /** store local variables supplied - to be used for slicing */
          self::$locals[$param] = $value;       
        }

      }

      ob_start();
      include($file);
      $template = ob_get_clean();
      return $template;

    }


    public static function loadSlice($file, $params = []){
      $template = self::loadTemplate($file, $params);
      return self::slice($template, false);
    }

    public function data(){
        return self::$body;
    }

    /**
     * This method is used to control the local arguments
     *
     * @param array $locals
     * @return void
     */
    public static function setlocals(array $locals = []){
      
      $compileLocals = [];

      foreach ($locals as $key => $value) {
        $compileLocals[$key] = $value;
      }

      self::$locals = $compileLocals;

    }


}