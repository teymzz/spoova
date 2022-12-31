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
     'POST' => '~[\{]{2}\s?post:[a-zA-Z_][a-zA-Z_0-9]*\s?[\}]{2}~',
     'REQUEST'  => '~[\{]{2}\s?req:[a-zA-Z_][a-zA-Z_0-9]*\s?[\}]{2}~',
     'VARIABLES_LOCAL' => '~[\{]{2}\s?[[a-zA-Z_][a-zA-Z_0-9]*\s?\??(\?\s\'[\s\w+\\\(\)]*?\')?\s?[\}]{2}~',
      
     //normal resolve
     'PLACEHOLDER' => '~[\{]{2}.*?[\}]{2}~',

    ];

     private static $directives = [
      //'@title',
      '@authDirect',
      '@guestDirect',
      '@auth',
      '@guest',
      '@meta',
      '@import',
      '@inPath',
      '@isPath',  
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
      '@onShow',
      '@onHide',
      '@yield',
      '@layout',
      '@styles',
      '@style',
      '@script',
      '@onscript',
      '@lay',
      '@flash',
      '@domurl', 
      '@formurl', 
      '@images',
      '@route',
      '@formdata',
      '@csrf',
      '@btn',
      '@action',
      '@old',
      '@get',
      '@post',
      '@error',
      '@vdump',
      '@php',
      '@attr',
     ];

     /**
      * Store excluded comments hash
      *
      * @var array
      */
     private static $comments = [];

     /**
      * store excluded comments
      *
      * @var array
      */
     private static $excludes = [];     

     /**
      * Resolves patterns in rendered content from loaded template
      * Pattern converted must be injected to another file before being included.
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
      * Slice urls to naming conventions
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
        static $count = 0;

        if($body){
          self::sort_comments($body);
          //self::unsort_lay_comments($body);
          self::sort_excludes($body);
          
          self::sort_placeholders($body);
          
          //remove unauthorized sections off the grid
          self::sort_auth($body);
          
          //remove authorized sections off the grid
          self::sort_guest($body);       
          
          self::sort_x_attrs($body);

          // //apply directives on body
          self::sort_directives($body);    

          self::sort_styles($body);

          self::sort_conditions($body);
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
        $content = base_decode(substr($comment, 4, strlen($comment) - 7));
        $body = str_replace($comment, $content, $body);
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

      $body = preg_replace('~{{\s?([\$a-zA-Z_\\s)\(-]+)\s?}}~is','<?= $1 ?>', $body);
      $body = preg_replace('~{{\s?([\$a-zA-Z_\\s)\(-]+)\??\s?}}~is','<?= ($1)?? "" ?>', $body);
      $body = preg_replace('~{{(.*?)?}}~is','<?= ($1)?? "" ?>', $body);
     
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
     * Add the guest layout when user is not authenticated
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_x_attrs(&$body){
      
       $pattern = "~<x-attr:[\w+-]+ .*?\s?/>~is";//

       preg_match_all($pattern, $body, $matches);

       $matches = $matches[0] ?? [];

       $attrLists = [];

       foreach($matches as $match){

           $value = substr( $match, 8, strlen($match) - 10 );

           $value = explode(' ', $value, 2);

           $key   = rtrim($value[0], " '");
           $attr  = ltrim($value[1], " '");

           $attrLists[$key] = $attr;

           $body = str_replace($match, '', $body);

           
       }
       
       if(!SETTER::EXISTS('x-attrs')) {
         SET('x-attrs', $attrLists, 'x-attr-list');
       } else {
         $attrs = GET('x-attrs', 'x-attr-list');
         $newAttrs = array_merge($attrs, $attrLists);
         SET('x-attrs', $newAttrs, 'x-attr-list');
       }
      
    }

    /**
     * Sort directive patterns using the directives class
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_styles(&$body){    

      if(SETTER::EXISTS(':STYLES')) {
        //var_dump(GET(':STYLES', '#1234'));
        $body = str_ireplace('@styles', GET(':STYLES', '#1234'), $body);
      }
      
      //return $body;

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
          $handle = str_replace('-','_', $handle);
          
          if(method_exists(get_class(new self), $handle)){
            $body = self::$handle($body);            
          }

        }
      }

    }

    //* PLACEHOLDER HANDLER METHODS ------------------------------------------------------------------------------ */

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

    private static function testMethod($method, &$isStrict = true){
      if(self::$method && self::$method !== $method){
        
        return false;
        
      }else if(self::$method !== $method){
        
        $isStrict = false;
        
      }
      return true;
    }

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
    
    /**
     * When finalize is set as data returned will run the final steps on templating.
     * This means that the data returned will no longer be subjected to further slicing
     *
     * @param boolean $finalize
     * @return string
     */
    public function data(bool $finalize = false){
        $body = self::$body;
        if($finalize){
          $body = self::finalize(self::$body);
        }
        return $body;
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

    /**
     * This function is used after all slicing is done to unsort all comments
     */
    public static function finalize(string $body) : string{
      static::unsort_lay_comments($body);
      static::unsort_comments($body);
      static::unsort_comments($body);
      static::unsort_excludes($body);
      return $body;
    }

}