<?php

namespace spoova\core\classes;

use Res;

/**
 * Contains Directives for slice tool
 * @author Akinola Saheed <teymss@gmail.com>
 * 
 */
abstract class Directives{

    protected static $locals = [];

    private static $pattern = [

        // Handle all redirection
        'authDirect'  => "~@authdirect\('[\w+\/]*?'\)~i", 
        'guestDirect' => "~@guestdirect\('[\w+\/]*?'\)~i",
        
        // Handle content displayed
        'auth'        => "~@auth:\s?(.)*?@auth;~is", 
        'guest'       => "~@guest:\s?(.)*?@guest;~is",
        
        //Handle meta display
        'meta'        => "~@meta\(\s?'\w*?'\s?\)~",

        // Import a specific resource
        'import'      => "~(<@import\s|@import\()\s?\'?(http(s)?:\/\/)?[A-Za-z_\/]+(.[A-Za-z]+)\'?\s?(\)|\/>)~i", //import (local or remote file) css / js files
        
        //Include a particular file
        'include'     => "~@include\(\s?'.*?'\s?\)~i", //include local file
        
        //include a rendered file
        'view'        => '~@view\(\'\s?\/?[A-Za-z_.-]+(.rex|)?\s?\'\)~i', //include a rendered file
        
        //Handle flash messages display
        'flash'       => '~@flash\(\'\s?[A-Za-z_.-]+\s?\'(,\s?\'\s?(([A-Za-z_\s-]+\s?(\s<<<)?\')|(.+?\s<<<\'))){0,1}\)~i', //include a flash if it exists
        
        //Handle resource importing
        'res'         => '~@Res\(\'\s?(::|:)?(http(s)?://)?[A-Za-z0-9-_/\.]+(.php|.js|.html|.css)?\'\s?\)~i',

        //Add files from "res/" folder
        'src'         => '~@src\(\s?\'[A-Za-z0-9-_/.]+\'\s?\)~i',  
        
        //Alias "src"
        'ress'        => 'alias-for-src-index',  
                        
        //Returns link from "res/main" folder
        'mapp'         => '~@mapp\(\s?\'[A-Za-z0-9-_/.]+\'\s?\)~i',
                        
        //Returns link from "res/assets" folder
        'mass'         => '~@mass\(\s?\'[A-Za-z0-9-_/.]+\'\s?\)~i',

        //Add files from "res/assets" folder
        'assets'      => '~@assets\(\s?\'(::|:)?[A-Za-z0-9-_/.]+\'\s?\)~i', 

        //Handle live server
        'live'        => '~@live\((\'(console|pop|uiconsole|[0-9])?\')?\)~i',  
        
        // Handle static files inclusion
        'domurl'      => '~@domurl\(\'\s?(http(s)?://)?[A-Za-z0-9-_/.#?]+\'\s?\)~i',  
        
        //Include images from "res/assets/images" folder
        'images'      => '~@images\(\s?\'[A-Za-z0-9-_/.#?]+\'\s?\)~i',  

        // Handles layout templating
        'lay'         => '~@lay\(\s?\'[A-zA-Z0-9_\\.-]{2,}:[A-zA-Z_0-9.-_]*?\'\s?\)~i', //set a layout a layout file
        'layout'      => '~@layout:[A-Za-z_-0-9.]{2,}\.@Layout;~i', //set a layout a layout file
        
        // Handle template injecting
        'template'    => '~@template\(\s?\'[-\w+\\.]+?\'\s?\)~i',

        'route'    => "~@route\(\s?'.*?'\s?\)~i",
        
    ];

    protected const extensions = ['php'=>'.rex.php', 'html'=>'.rex.html']; // layout extensions
    
    protected const defaultExtension = self::extensions['php']; // layout extensions
    
    protected static function directivesAuthDirect($body): string{
        //fetch pattern
        $pattern = self::$pattern['authDirect'];

        preg_match_all($pattern, $body, $matches);

        $matches = $matches[0];

        foreach($matches as $match => $value){
            $query = str_replace(' ', '', $value);
            $url = str_ireplace(['@authdirect(\'','\')'], '', $query);
            $body = str_ireplace($value, '' , $body);
            authDirect($url);
            break;
        }
        return $body;
    }

    protected static function directivesGuestDirect($body): string{
        //fetch pattern
        $pattern = self::$pattern['guestDirect'];

        preg_match_all($pattern, $body, $matches);

        $matches = $matches[0];

        foreach($matches as $match => $value){
            $query = str_replace(' ', '', $value);
            $url = str_ireplace(['@guestdirect(\'','\')'], '', $query);
            $body = str_ireplace($value, '' , $body);
            guestDirect($url);
            break;
        }
        return $body;
    }

    protected static function directivesGuest($body): string {
      
      
      $pattern = self::$pattern['guest'];
      //convert and process pattern
      $callback = function($matches) use ($body) {
         
        $matched = $matches[0];
        if(isGuest()) {
         $matchedd = str_ireplace(['@guest:', '@guest;'] , '', $matched);
         $rep = str_replace($matched , $matchedd , $matched);
        }else{
         $rep = str_replace($matched, '', $matched);
        }
       
        return $rep; 
        
      };
      
      return preg_replace_callback($pattern, $callback, $body);
      
    }

    protected static function directivesMeta($body): string {
      
      $pattern = self::$pattern['meta'];
      //convert and process pattern
      $callback = function($matches) use ($body) {
         
        $matched = $matches[0];

        $matchedd = str_ireplace(['@meta(', ')', '\''] , '', $matched);

        if(appenv('meta')->$matchedd(true)){
            $rep = str_replace($matched , (appenv('meta')->$matchedd(true))?? '' , $matched);
        } else {
            $rep = str_replace($matched , '' , $matched);
        }
       
        return $rep; 
        
      };
      
      return preg_replace_callback($pattern, $callback, $body);
      
    }    
    
    protected static function directivesAuth(&$body): string {
      
      
      $pattern = self::$pattern['auth'];
     
      //convert and process pattern
      preg_match_all($pattern, $body, $matches);
      
      $matches = $matches[0];
      
      
      foreach($matches as $match => $matched) {
        
        if(isUser()) {
         $matchedd = str_ireplace(['@auth:', '@auth;'] , '', $matched);
         $body = str_replace($matched, $matchedd, $body);
        } else {
         $body = str_replace($matched, '', $body);
        }
        
      }
      
      return $body; 
      
    }
    
    

    protected static function directivesImport(&$body): string
    {
        $pattern = self::$pattern['import'];

        //convert and process pattern
        // <@import css/home.css />
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match => $matchValue){

            if(
                 ( $test1 = ((substr($matchValue, 0, 9) === '<@import ') and (substr($matchValue, strlen($matchValue) - 1, 1) === '>')) )  ||
                 ( $test2 = ((substr($matchValue, 0, 8) === "@import(") and (substr($matchValue, strlen($matchValue) - 1, 1) === ')')) )
                ) {
                
                    if($test1){
                        //strip off tags and directives <@import() />
                        $url = str_replace(["<@import(",")", "'", ">"], "", $matchValue);
                    }else{
                        //strip off directives
                        $url = str_replace(["@import(",")", "'"], "", $matchValue);                       
                    }


                $template = Slicer::loadTemplate($matchValue);
                $body = str_replace($matchValue, $template, $body); 

            }

            
        }
        return $body;
    }

    /**
     * Loads and renders all include tags from the template string supplied
     *
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesInclude($body): string 
    { 
        //get all imports
        $pattern = self::$pattern['include'];
        preg_match_all($pattern, $body, $matches);

        $matches = $matches[0];

        //convert and process pattern
        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $url = preg_replace("~@include\(\s?'(.*?)'\s?\)~", "<?php include('".docroot.DS."$1'); ?>", $matchValue);

            $body = str_replace($matchValue, $url, $body);
            
        }

        return $body;
    }

    /**
     * Returns a named route
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesRoute($body): string 
    { 
        //get all imports
        $pattern = self::$pattern['route'];
        preg_match_all($pattern, $body, $matches);

        $matches = $matches[0];

        //convert and process pattern
        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $url = preg_replace("~@route\(\s?'(.*?)'\s?\)~", "<?= route('$1'); ?>", $matchValue);

            $body = str_replace($matchValue, $url, $body);
            
        }

        return $body;
    }

    /**
     * Loads and renders the file path supplied
     *
     * @param string $file
     * @param array $params variables supplied as arguments
     * @return string rendered $body
     */
    abstract protected static function loadTemplate($file, $params = []);

    protected static function directivesRes($body): string
    { 
        //get pattern
        $pattern = self::$pattern['res'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@res(",")", "'",], "", $match);
            if(substr($url, 0, 1) == ":"){

                if($url == '::watch'){

                     $values = Res::import($url);

                } else {
                    $values = ":lists";

                    $values = Res::import('', $url, $values);
                    
                }
               
                $body = str_replace($match, $values, $body);
                
            } else {

                $values = Res::callFile($url, false); //get values of index

                $body = str_replace($match, $values, $body);    

            }
            
        }


        return $body;
    }

    protected static function directivesLive($body): string {
        //get pattern
        $pattern = self::$pattern['live'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0]; $counter = 0;

        foreach($matches as $match) {

            $match = trim($match);

            if($counter == 0){
                //fetch content
                $params = str_replace(['@live(', '\'', ')'], '', $match);
                $params = explode(',', $params);
                $body = str_replace($match, Res::import('::watch'), $body);
            } 
            $body = str_replace($match, '', $body);
            $counter++;
        }

        return $body;
    }

    protected static function directivesDomUrl($body): string
    { 
  
        //get pattern
        $pattern = self::$pattern['domurl'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@domurl(",")", "'"], "", $match);           
            
            $replacement = DomUrl($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;
    }    
    
    protected static function directivesImages($body): string
    { 
  
        //get pattern
        $pattern = self::$pattern['images'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@images(",")", "'"], "", $match);           
            
            $replacement = DomUrl('res/assets/images/'.$url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;
    } 
    
    protected static function directivesSrc($body): string
    { 
           
        //get pattern
        $pattern = self::$pattern['src'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@src(",")", "'"], "", $match);           
            
            $replacement = ress($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;

    } 

    protected static function directivesRess($body): string
    { 
      
        return self::directivesSrc($body);

    } 

    protected static function directivesMapp($body): string
    { 

        //get pattern
        $pattern = self::$pattern['mapp'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@mapp(",")", "'"], "", $match);           
            $url = 'main/'.ltrim($url, '/');
            $replacement = ress($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;

    } 

    protected static function directivesMass($body): string
    { 

        //get pattern
        $pattern = self::$pattern['mass'];
        preg_match_all($pattern, $body, $matches);
        $matches = $matches[0];

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@mass(",")", "'"], "", $match);           
            $url = 'assets/'.ltrim($url, '/');
            $replacement = ress($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;

    } 

    protected static function directivesAssets($body): string
    { 
      
      
      //get pattern
      $pattern = self::$pattern['assets'];
      preg_match_all($pattern, $body, $matches);
      $matches = $matches[0];

      foreach($matches as $match){
        //strip off the rule pattern
        $url = str_ireplace(["@assets(",")", "'",], "", $match);
        if(substr($url, 0, 1) == ":"){

            if($url == '::watch'){

                 $values = Res::import($url);

            } else {
                $values = ":lists";

                $values = Res::import('', $url, $values);
            }
           
            $body = str_replace($match, $values, $body);
            
        }  else {
            $url = 'res/assets/'.$url;
            $values = Res::callFile($url, false); //get values of index
            $body = str_replace($match, $values, $body);    
        }     
          
      }


        return $body;
    } 
    
    

    /**
     * Directs the slicer to render all view syntaxes using view function
     * Syntax will be replaced with either empty string or the appropraite resolved value
     *    - syntax @view('url')
     *
     * @param string $body
     * @return string $body
     */
    protected static function directivesView($body) : string 
    {
        
            //get pattern
            $pattern = self::$pattern['view'];
            preg_match_all($pattern, $body, $matches);
            $matches = $matches[0];
    
            foreach($matches as $match){
    
                //strip off the rule pattern
                $url = str_ireplace(["@view(","@",")", "'"], "", $match);
                $url = view($url);
                $body = str_replace($match, $url, $body);    
            }
    
            return $body;

    }
    
    /**
     * Directs the slicer to remove all layout syntaxes from render page
     * Only the syntax will be removed. The content of the syntax remains
     *      - sytax <@Layout layoutid > <@/Layout>
     *
     * @param string $body
     * @return string $body
     */
    protected static function directivesLay($body): string 
    {   
        $pattern = self::$pattern['lay'];
        preg_match_all($pattern, $body, $matches);
        
        $matches = $matches[0]?? [];

        foreach($matches as $match => $matchValue){
         
            //strip off the rule pattern
            $value = rtrim(str_ireplace(['@lay(', '\'', ')'], '', $matchValue), " ");
            $valuee = str_replace(['.','\\'],'/', $value);
            
            $explode = explode(":", $valuee);

            if(count($explode)> 1){
                $url = $explode[0];
                $id = $explode[1];

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) === ''){
                    $url .= self::defaultExtension;
                }
                
                //build a layout pattern from layoutId values
                /* $layoutIdPattern = "~<@LayoutId\s{$value}\s?\/?>~"; */ //pattern to be replaced
                $layoutPattern = "~@layout:{$id}\s(.)*?@layout;~is";//replacement 

                //load layoutId's supplied template url
                $url =  docroot.DS.scheme.ltrim($url, '/');

                if(!is_file($url)){
                    print self::directivesError([
                        'title'=> 'Layout Error :',
                        'message' => 'Layout does not exists',
                        'path' => $url
                    ]);
                }else{

                    ob_start();
                    include($url);
                    $templateContent = ob_get_clean();

                    //find expected layoutPattern from the template content
                    preg_match($layoutPattern, $templateContent, $contentsMatched);
                    $contentMatched = $contentsMatched[0]?? '';
                    $replacement = str_ireplace(["@layout:$id", "@layout;"], '', $contentMatched);
                    
                    //make replacement in the body
                    $data = preg_replace("~@lay\(\s?'{$value}'\s?\)~i", Slicer::slice($replacement)->data(), $body);
                    $body = $data;   

                }

            }

        }

        return $body;
    }
    
    /**
     * Directs the slicer to remove all layout syntaxes from render page
     * Only the syntax will be removed. The content of the syntax remains
     *      - sytax <@Layout layoutid > <@/Layout>
     *
     * @param string $body
     * @return string $body
     */
    protected static function directivesLayout($body): string 
    {
        $body = preg_replace('~@Layout(;|(\:[.A-Za-z_-]{2,}))~i', '', $body);
        return $body;
    }


    protected static function directivesTemplate($body){

        //get the template url openers
        $pattern = "~@template\(\s?'[-\w+\\\.]+\'\s?\).*?@template;~is";
        preg_match($pattern, $body, $matches);

        $callback = function($matches) use ($body) {
            
            //Get template
            $match = $matches[0]; 
           
            //Fetch template opener
            preg_match(self::$pattern['template'], $match, $matched);
                        
            $opener = $matched[0];
            $closer = '@template;';
           
            //Fetch Url
            $tempUrl = str_ireplace(['@template(','\'',')'] ,'', $opener);
            $url = str_replace(['.','\\'], '/', $tempUrl);    
            
            //load template's supplied url
            $url =  docroot.DS.scheme.ltrim($url, '/');
   
            //get url extension
            if (pathinfo($url, PATHINFO_EXTENSION) === '') {
                $url .= self::defaultExtension;
            }
  
            if (!is_file($url)) {
                print self::directivesError([
                    'title'=> 'Layout Error :',
                    'message' => 'Layout does not exists',
                    'path' => $url
                ]);
                return $body;
            } else {
                ob_start();
                include($url);
                $template = ob_get_clean(); //new replacement
                
                //filter out structure 
                $content = str_replace([$opener, $closer], '', $match);
  
                //find yield in templateContent
                $template = str_replace('@yield()', $content, $template);
                $template = Slicer::slice($template)->data();
                //replace template directive with new template
                return $body = str_replace($match, $template, $body);
            }         
           
           
        };
        
        return preg_replace_callback($pattern, $callback, $body);

    }
   
    protected static function directivesFlash($body): string{
      
      //load flashes
      $pattern = self::$pattern['flash']; //include a flash if it exists
      preg_match_all($pattern, $body, $matches);
      $matches = $matches[0];
     //print_r ($matches);
     
      foreach($matches as $flash){
        
        $args = []; 
        if(strpos($flash, '<<<') !== false){
          preg_match('~(?<=\').*?(?= <<<\s?\'\))~', $flash, $flashargs);
          $flashargs = $flashargs[0]; 
          //Get flash arg
          $flasharg  = strstr($flashargs, "'") ?: $flashargs;
          $flasharg  = substr($flasharg, 1, strlen($flasharg));
          $flasharg  = strstr($flasharg, "'") ?: $flasharg;
          $flashmess = substr($flasharg, 1, strlen($flasharg));  
          
        } else {
          preg_match('~(?<=\').*?(?=\s?\'\))~', $flash, $flashargs);
          $flashargs = $flashargs[0];  
        }
        
        //Get flash key
        $flashkey = strstr($flashargs, "'", true) ?: $flashargs; 
        $args[] = $flashkey;        

        //Get the flash message
        if($flashmess ?? null) $args[] = $flashmess; 
          
        $body = str_replace($flash??'', Res::flash(...$args)??'', $body);
      }
      
      return $body;
    } 

    private static function directivesError(array $array = []){
        if(func_num_args() > 0){
          $arg = $array;
    
          $title = $arg['title']?? '';
          $message =  $arg['message']?? '';
          $icon    = array_key_exists('icon', $arg)? $arg['icon'] : 'ico-emo-house';
    
          $filePath    = $arg['path']?? '';
          $message = '<span class="fb-6 class="flex-full midv"><span class="'.$icon.'"></span> '.$title. ' <span> ' .$message.'</span></span> : '.$filePath;
          
          return '
            <div class="spoova-route-error pxv-4 c-red-d">
              <div class="mox-full pxv-10 bc-white-dd">'.$message.'</div>
            </div>
          ';
        }
    }

}

/* 
   #Layout Pattern
   <@Layout id_of_layout>

   </@Layout> 
  
   #LayoutId Pattern
   <@LayoutId id_of_layout:url_of_layout >
   
   #Import a file
   @import('url_here'),  <@Import '' \>

   #Inject a file
   <@Inject name >      
*/

?>