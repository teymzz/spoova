<?php

namespace spoova\mi\core\classes;

use PDO;
use Reflection;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use User;

/**
 * class Slicer
 * 
 * @author Akinola Saheed <teymss@gmail.com>
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
        $process = self::process($body, $return);

        return ($return)? $process : (new self);
     }

     protected function endSlice(){

        self::$locals = [];

     }

     /**
      * Converts file path to rex path based on url supplied
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
      * @return string|void
      */
     private static function process($body, $return){ 

        if($body){
          self::sort_comments($body);
          
          self::sort_excludes($body);
          
          self::sort_placeholders($body);

          self::check_styles($body);

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

        $body = $body;
        if($return) return $body;
        self::$body = $body;

    }

    private static function sort_comments(&$body){
      
      //fetch all comment-like structures in body
      preg_match_all('~<!--.*?-->~s', $body, $fetches);

      $fetches = $fetches[0];

      foreach($fetches as $fetched) {
       $hashed = base_encode($fetched);
       $rep = "@comments(c:$hashed)";
       
       $body = str_replace($fetched, $rep, $body);
       self::$comments[] = $hashed;      
      }

    }

    public static function unsort_comments(&$body){
      foreach(self::$comments as $comment){
        $content = base_decode($comment);
        $body = str_replace("@comments(c:$comment)", $content, $body);
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
      preg_match_all('~@\(.*?\)@~s', $body, $fetches);

      $fetches = $fetches[0];

      foreach($fetches as $fetched) {
       $hashed = base_encode($fetched);
       $rep    = "@ccomments(c:$hashed)";
       $body = str_replace($fetched, $rep, $body);
       self::$excludes[] = $hashed;      
      }
            
    }

    final public static function unsort_excludes(&$body){
      foreach(self::$excludes as $exclude){
        $mod = base_decode($exclude);
        
        $body = str_replace("@ccomments(c:$exclude)", $mod, $body);
        //$body = preg_replace('~@\(\{\{(.*?)\}\}\)@~', "&#123;&#123;$1&#125;&#125;", $body);
        $body = preg_replace('~@\((.*?)\)@~s', "$1", $body);
      }
    }

    /**
     * Sorts all placeholders that are not directives
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_placeholders(&$body){

      $body = preg_replace('~{{\s?([a-zA-Z_0-9]+)?\?\s?}}~is','<?= $$1 ?? \'\' ?>', $body);
      $body = preg_replace('~{{\s?\$([a-zA-Z_0-9]+)?\?\s?}}~is','<?= $$1 ?? \'\' ?>', $body);
    
      $body = preg_replace('~{{\s?(.*?)?\s?}}~is','<?= $1 ?>', $body);

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
     * Check directive patterns related to styles
     *
     * @param string $body referenced body template
     * @return void
     */
    public static function check_styles(&$body){    

      if(stripos($body, '@styles') !== false) {
        SELF::$PULLSTYLES = true;
      }
        
      return $body;
      
    }

    /**
     * Sort directive patterns related to styles
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_styles(&$body){    

      if(SETTER::EXISTS(':STYLES')) {
       $body = str_ireplace('@styles', GET(':STYLES', '#1234'), $body);
      }else{
        $body = str_ireplace('@styles', '', $body);
      }
      
    }
    

    /**
     * Sort directive patterns using the directives class
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_directives(&$body){



      //get all directives ... 
      $rc = new ReflectionClass('Rexit');
      $statics = $rc->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC);
      $staticMethods = [];

      //iterate over declared directives      
      $directives = array_keys(self::$pattern);    

      foreach($statics as $method){
        if($method->isPublic() && $method->isStatic()){
          $name = $method->getName();
          if(!in_array($name, $directives)){
            $staticMethods[] = $method->getName();
          }
        }
      }

      array_map(function($directive) use(&$body) {

        if(stripos($body, '@'.$directive) !== false){

          $handle = "directives".$directive;
          $handle = str_replace('-','_', $handle);
          
          if(method_exists(get_called_class(), $handle)){
            if($directive !== 'title') $body = self::$handle($body);
          }

        }

      }, $directives);
      

      array_map(function($directive) use(&$body) {

        if(stripos($body, '@'.$directive) !== false){

          $directive = str_replace('-','_', $directive);
          
          $body = self::directivesController($body, $directive);
          
        }

      }, $staticMethods);


      

    }

    /**
     * Raw loading a supplied file path without slicing. Only variable(local) parameters supplied will be resolved
     * This method is called before slice method
     *
     * @param string $file file url
     * @param array $params variables passed as arguments
     * @return string raw contents of file
     */
    public static function loadTemplate(string $file, $params = []){

      foreach($params as $locals => $value){
        if($locals != 'this') $$locals = $value;
      }

      foreach($params as $param => $value){

        if(!is_array($value) and !is_bool($value)) {
          if($param != 'this') $$param = $value; 
            /** store local variables supplied - to be used for slicing */
          self::$locals[$param] = $value;       
        }

      }

      ob_start();
      include($file);
      $template = ob_get_clean();
      return $template;

    }

    /**
     * Slices a rex file 
     *
     * @param string $file
     * @param array $params
     * @return Slice
     */
    public static function loadSlice($file, $params = []){
      $template = self::loadTemplate($file, $params);
      return self::slice($template, false);
    }
    
    /**
     * When finalize is set as true, data returned will run the final steps on templating.
     * This means that the data returned will no longer be subjected to further slicing
     *
     * @return string
     */
    public function data() : string {
        $body = self::$body;
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
     * This method is used to add more values to default arguments
     *
     * @param array $locals
     * @return void
     */
    public static function addlocals(array $locals = []){
      
      $compileLocals = [];

      foreach ($locals as $key => $value) {
        $compileLocals[$key] = $value;
      }

      self::$locals = array_merge(self::$locals, $compileLocals);

    }

    public static function args() {
      return self::$locals;
    }

}