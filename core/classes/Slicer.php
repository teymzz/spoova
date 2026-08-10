<?php

namespace spoova\mi\core\classes;

use Error;
use Exception;
use PDO;
use Reflection;
use ReflectionClass;
use ReflectionMethod;
use User;

/**
 * class Slicer
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
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
      * @var string
      */
     private static $method;

     /**
      * Template Directives
      *
      * @var array
      */
     private static $directives = ['default'=>[],'custom'=>[]];
     
     /**
      * Default Directives
      *
      * @var array
      */
     private static $defaultDirectives = [];
    
     
     /**
      * Custom Directives
      *
      * @var array
      */
     private static $customDirectives = [];
    
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
        // resolve all layouts
        $process = self::process($body, $return);
        return ($return)? $process : (new self);
     }
     
     private static function sort_escapes(&$body){
        self::sort_comments($body);
        self::sort_excludes($body);
     }
     
     public static function unsort_escapes(&$body){
       self::unsort_excludes($body);
       self::unsort_comments($body);
     }

     public static function new_directive(string $name, callable $callback){

      $directives = self::directives();
      if(!$name || (strpos($name, ' ') !== false)) throw new Error('directive name "'.$name.'" is not allowed');
      $name = strtolower($name);
      if(in_array($name, $directives)){
        throw new Error('directive name "'.$name.'" already exists');
      }
      
      self::$customDirectives[$name] = $callback;
      self::$directives[] = $name;

     }

     /**
      * Returns all directives
      * @return array
      */
     public static function directives() : array {

      if(empty(self::$defaultDirectives)){
        $braces = array_keys(self::$pattern);
        $specials = self::specials;
        $authDirectives = array_keys(self::auth_directives);
        $conditionals = [
          'if','endif','else','endif',
          'while','endwhile',
          'for','endfor',
          'foreach','endforeach',
          'each','endeach',
          'loop','endloop',
          'break','test',
          'do','switch','endswitch',
          'case','default'
        ];
  
        $directives = array_merge($braces,$specials,$authDirectives,$conditionals);
        self::$directives = self::$defaultDirectives = array_map(fn($directive)=>strtolower($directive), $directives);
        $rc = new ReflectionClass('Rexit');
        
        // Rexit directives
        $statics = $rc->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC);

        foreach($statics as $method){
          if($method->isPublic() && $method->isStatic()){
            $directiveName = strtolower($method->getName());
            if(!in_array($directiveName, $directives)){
              self::$directives[] = $directiveName;
            }
          }
        }
      }

      return self::$directives;

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
          self::sort_escapes($body);
          
          self::sort_placeholders($body);

          self::check_styles($body);

          //remove unauthorized sections off the grid
          self::sort_auth($body);
          
          //remove authorized sections off the grid
          self::sort_guest($body);       
          
          self::sort_x_saved($body);
          self::sort_x_attrs($body);

          // //apply directives on body
          self::sort_directives($body);    
          self::sort_customized($body);

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
      foreach(self::$comments as $key => $comment){
        $content = base_decode($comment);
        $body = str_replace("@comments(c:$comment)", $content, $body);
      }
    }

    private static function sort_conditions(&$body){

      $body = preg_replace('~@if\((.*?)\):~', '<?php if($1): ?>', $body);
      $body = preg_replace('~@elseif\((.*?)\):~', '<?php elseif($1): ?>', $body);
      $body = preg_replace('~@else:~', '<?php else: ?>', $body);
      $body = preg_replace('~@endif;~', '<?php endif; ?>', $body);

      $body = preg_replace('~@while\((.*?)\):~', '<?php while($1): ?>', $body);
      $body = preg_replace('~@endwhile;~', '<?php endwhile; ?>', $body);

      $body = preg_replace('~@for\((.*?)\):~', '<?php for($1): ?>', $body);
      $body = preg_replace('~@endfor;~', '<?php endfor; ?>', $body);
      
      $body = preg_replace('~@each\((.*?)\):~', '<?php foreach($1): ?>', $body);
      $body = preg_replace('~@endeach;~', '<?php endforeach; ?>', $body);
      $body = preg_replace('~@foreach\((.*?)\):~', '<?php foreach($1): ?>', $body);
      $body = preg_replace('~@endforeach;~', '<?php endforeach; ?>', $body);

      $body = preg_replace('~@break;~', '<?php break; ?>', $body);

      //set switch pattern
      $pattern = '/^[\s]*(@switch\([^)]+\)|@case\([^)]+\)|@break|@default)/m';
      $body = preg_replace($pattern, '$1', $body);

      //handling switch statements
      $body = preg_replace('~@test\((.*?)\):~', '<?php switch($1): ', $body);       
      $body = preg_replace('~@endtest;~', 'endswitch; ?>', $body);
      
      //handle do-while statements
      $pattern = '/@do:(.*?)@while\((.*?)\);/s';

      // Replace the pattern with the desired format
      $replacement = '<?php do{$1}while($2); ?>';
      
      $replacement = '<?php do{ ?>$1<?php }while($2); ?>';
      $body = preg_replace($pattern, $replacement, $body);
      
      //handle loop statement
      // Define the regular expression pattern
      $varArrows = '~@loop\(([^:]+): ?([^ ]+) [@-]> (.+)\):~';
      $body = preg_replace($varArrows, '<?php for($1 = $2; $1 <= $3; $1++): ?>', $body);
      
      $varArrows = '~@loop\(([^:]+): ?([^ ]+) <[@-] (.+)\):~';
      $body = preg_replace($varArrows, '<?php for($1 = $3; $1 >= $2; $1--): ?>', $body);
       
      $varOperators = '~@loop\(([^:]+): ?([^ ]+) ([<>]=?|=) (.+)\):~';
      $body = preg_replace($varOperators, '<?php for($1 = $2; $1 $3 $4; $1++): ?>', $body);
 
      $body = preg_replace('~@endloop;~', '<?php endfor; ?>', $body);
      
      $body = preg_replace_callback('~@switch\((.*?)\):~', function($matches){
         return "<?php switch($matches[1]): ?>";
      },
      $body);       
      $body = preg_replace('~@case\((.*?)\):~', '<?php case $1: ?>', $body);       
      $body = preg_replace('~@default:(.*?)~', '<?php default: $1; ?>', $body);       
      $body = preg_replace('~@endswitch;~', '<?php endswitch; ?>', $body);

    }

    private static function sort_excludes(&$body){
      
      //fetch all comment-like structures in body
      preg_match_all('~@\(.*?\)@~s', $body, $fetches);

      $fetches = $fetches[0];

      usort($fetches, fn($a, $b) => strlen($b) - strlen($a) );

      foreach($fetches as $fetched) {
       $hashed = base_encode($fetched);
       $rep    = "@ccomments(c:$hashed)";
       $reps[] = $rep;
       $body = str_replace($fetched, $rep, $body);
       self::$excludes[] = [
         'hash' => $hashed, 
         'rep' => $rep, 
         'fetched' => $fetched, 
       ];      
      }
            
    }

    final public static function unsort_excludes(&$body){
 

      foreach(self::$excludes as $key => $exclude){
        
        $rep = $exclude['rep'];
        $fetched = $exclude['fetched'];
        $comment = substr($fetched, 2); 
        $comment = substr($comment, 0, -2); 
        
        $body = str_replace($rep, $comment, $body);
      }    
    }
    
    final public static function excludes(){
      return self::$excludes;
    }

    /**
     * Sorts all placeholders that are not directives
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_placeholders(&$body){

      //define smart php format
      $body = preg_replace('~{{:\s?(.*?)?\s?}}~is','<?php $1 ?>', $body);

      //define smart break format 
      $body = preg_replace_callback('~{{\s*(.+?)\s*(:{1,})\s*}}~s', function($matches){
        $expression = $matches[1];
        $colons = $matches[2]; 
        $breaks = str_repeat('<br>', strlen($colons));
        return "<?php echo ({$expression}) .'{$breaks}' ?>";
      }, $body);

      //define constant formats
      $body = preg_replace('~{{\s?([a-zA-Z_0-9]+)?\?\s?}}~is','<?= $$1 ?? \'\' ?>', $body);

      //define tenary isset format for variables
      $body = preg_replace('~{{\s?\$([a-zA-Z_0-9]+)?\?\s?}}~is','<?= $$1 ?? \'\' ?>', $body);
    
      //define other formats 
      $body = preg_replace('~{{\s?(.*?)?\s?}}~is','<?php echo $1; ?>', $body);

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

        $body = preg_replace('~@Auth:\s*(.*?)\s*@Auth;~is', '$1', $body);

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
        $body = preg_replace('~@Guest:\s*(.*?)\s*@Guest;~is', '', $body);
      }
      
    }

    private static function xsaver($body) {
      
      $pattern = '/<\s*x-save:([a-zA-Z0-9_-]+)(\s+id="(\d+)"\s*)?>([\s\S]*?)<\/\s*x-save:\1\s*>/';

      while (preg_match($pattern, $body)) {
          $body = preg_replace_callback($pattern, function ($matches) {
            $mainid = $matches[1];
            $subid = $matches[3];

            ($subid)? $saves[$mainid][$subid]=[] : $saves[$mainid][]=[];
            end($saves[$mainid]);          // Move internal pointer to last element
            $lastKey = key($saves[$mainid]); // Get the key of that element

            $content = self::xsaver($matches[4]); // recursive call
            $saves[$mainid][$lastKey] = $content;

            if(SETTER::EXISTS('x-save')) {
              $saved = GET('x-save', 'x-save-list');
              if(!isset($saved[$mainid])){
                $saved[$mainid] = $saves[$mainid];
                SET('x-save', $saved, 'x-save-list'); // create a new storage and store contents.
              }else{
                $subsaved = $saved[$mainid]; 
                if($subid){
                  if(!array_key_exists($subid, $subsaved)){
                    $saved[$mainid][$lastKey] = $saves[$mainid][$lastKey];
                    SET('x-save', $saved, 'x-save-list');
                  }
                }else{
                  $saved[$mainid][] = $content;
                  SET('x-save', $saved, 'x-save-list');
                }
              }
            } else {
              SET('x-save', $saves, 'x-save-list');
            }

            
            // save items into array format: $array['book']['id'] = 
            return ''; //str_repeat($content, $count);
          }, $body);
      }

      return $body;

    }

    /**
     * Save a part of template to be reused later
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_x_saved(&$body){
      
        $pattern = "~<x-attr:[\w+-]+ .*?\s?/>~is";//

        $body = self::xsaver($body);
      
    }
    /**
     * Save a part of template to be reused later
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_x_attrs(&$body){
      
        $pattern = "~<x-attr:[\w+-]+ .*?\s?/>~is";

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
      SELF::$PULLSTYLES = false; // reset @styles after resolved
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
     * Sort directive patterns using the directives class
     *
     * @param string $body referenced body template
     * @return void
     */
    private static function sort_customized(&$body){
      $pattern = "/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x";
      $body = preg_replace_callback($pattern, function ($matches) {
            $name = $matches[1];
            $expression = $matches[3] ?? '()';

            // 1. Custom directive callback
            if (isset(self::$customDirectives[$name])) {
                $response = call_user_func(self::$customDirectives[$name], $expression);
                if(!is_string($response)) {
                  throw new Exception('callback for custom directive "'.$name.'" must return a string value');
                }
                return $response;
            }

            return $matches[0]; // No match — leave it untouched
        }, $body);
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
      
      SET('::sp-file', $file, 123);
      
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
      include(GET('::sp-file', 123));
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