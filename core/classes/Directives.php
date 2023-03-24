<?php

namespace spoova\mi\core\classes;

use Res;

/**
 * Contains Directives for slice tool
 * @author Akinola Saheed <teymss@gmail.com>
 * 
 */
abstract class Directives{

    protected static $locals = [];

    private static $pattern = [

        // Set a page title
        'title'  => "~@title\('.*?'\)~i", 

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
        
        'inPath'       => '~@inPath\(\'\s?[A-Za-z_.:-]+\s?\'(,\s?\'\s?([A-Za-z_\s-]+\s?\')){0,1}\)~i',
        'isPath'       => '~@isPath\(\'\s?[A-Za-z_.:-]+\s?\'(,\s?\'\s?([A-Za-z_\s-]+\s?\')){0,1}\)~i',

        //Include a particular file
        'include'     => "~@include\(\s?'.*?'\s?\)~i", //include local file
        
        //include a rendered file
        'view'        => '~@view\(\'\s?\/?[A-Za-z_.-]+(.rex|)?\s?\'\)~i', //include a rendered file
        
        //Handle flash messages display
        //'flash'       => '~@flash\(\'\s?[A-Za-z_.:-]+\s?\'(,\s?\'\s?(([A-Za-z_\s-]+\s?(\s<<<)?\')|(.+?\s<<<\'))){0,1}\)~i', //include a flash if it exists
        'flash'       => '~@flash\(\'\s?.*?\s?\'\)~i', //include a flash if it exists
        
        //Handle resource importing
        'res'         => '~@res\(\'\s?(::|:)?(http(s)?://)?[A-Za-z0-9-_/\.]+(.php|.js|.html|.css|::js|::css)?\'\s?\)~i',

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
        'live'        => '~@live(\((\'(console|pop|uiconsole|[0-9])?\')?\))?~i', 
        
        // Handle static files inclusion
        'domurl'      => '~@domurl\((\'(\s?(http(s)?://)?[A-Za-z0-9-_/.#?]+)?\'\s?)?\)~i',

        'domlink'     => '~@domlink\((\'(\s?(http(s)?://)?[A-Za-z0-9-_/.#?]+)?\'\s?)?\)~i',

        'formurl'     => '~@formurl\((\'(\s?(http(s)?://)?[A-Za-z0-9-_/.#?]+)?\'\s?)?\)~i',

        //Include images from "res/assets/images" folder
        'images'      => '~@images\((\s?\'([A-Za-z0-9-_/.#?]+)?\'\s?)?\)~i',  

        // Handles layout templating
        // 'styles'      => '~@styles~i', //set a layout a layout file
        'style'       => '~@style\(\s?\'[A-zA-Z0-9_\\.-]{2,}(:[A-zA-Z_0-9.\-_]*?)*?\'\s?\)~i', //set a layout a layout file
        'script'      => '~@script\(\s?\'[A-zA-Z0-9_\\.-]{2,}(:[A-zA-Z_0-9.\-_]*?)*?\'\s?\)~i', //set a layout a layout file
        'onscript'    => '~@onscript\(\s?\'[A-zA-Z0-9_\\.-]{2,}(:[A-zA-Z_0-9.\-_]*?)*?\'\s?\)~i', //set a layout a layout file
        'lay'         => '~@lay\(\s?\'[A-zA-Z0-9_\\.-]{2,}:[A-zA-Z_0-9.\-_]*?\'\s?\)~i', //set a layout a layout file
        'layout'      => '~@layout:[A-Za-z_-0-9.]{2,}\.@layout;~i', //set a layout a layout file
        
        // Handle template injecting
        'template'    => '~@template\(\s?\'[-\w+\\.]+?(:off)?\'\s?\)~i',

        'onShow'      => "~@onShow\(\s?'.*?'\s?\)~is", 
        'onHide'      => "~@onHide\(\s?'.*?'\s?\)~is", 

        'route'       => "~@route\(\s?'.*?'\s?\)~i",

        'formdata'    => "~@formdata~i",
        'csrf'        => "~@csrf~i",
        'action'      => "~@action\(\s?'.*?'\s?\)~i",
        'btn'         => "~@btn\(\s?'.*?'\s?\)~i",
        'old'         => "~@old.(\w+)(\[[\w+\.-_]+\])?~i", 
        'post'        => "~@post.(\w+)(\[[\w+\.-_]+\])?~i", 
        'get'         => "~@get.(\w+)(\[[\w+\.-_]+\])?~i",
        'error'       => "~@error\(\s?'.*?'\s?\)~i", 
        'vdump'       => "~@vdump\(\s?'.*?'\s?\)~i", 
        'php'         => "~@php:.*?@php;~is",
        'attr'        => "~@((attr:[\w+-]+)|(attr\(\s?'.*?'\s?\)))~is",
        
    ];

    /**
     * Store missing files
     *
     * @var array
     */
    private static $missingFiles = ['layout'=> [], 'js'=>[], 'css'=>[]];

    /**
     * Store excluded comments hash
    *
    * @var array
    */
    protected static $layComments = [];

    private static $PULLSTYLES = false;

    /**
     * template extensions
     */
    protected const extensions = ['php'=>'.rex.php', 'html'=>'.rex.html', 'css' => '.rex.css', 'js' => '.rex.js']; // layout extensions

    /**
     * layout extensions
     */
    protected const defaultExtension = self::extensions['php'];

    /**
     * Sets a page title
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesTitle($body): string 
    { 
       
        self::getMatches('title', $body, $matches);

        if($matches){

            $matchValue = $matches[0];
            
            if($matchValue){
                
                //fetch title from directive
                $title = str_replace(['@title',"('","')", ], '', $matchValue);
                $title = "<title>{$title}</title>";
                
                //replace directive with null
                $body = str_replace($matchValue, '', $body);

                $body = preg_replace('~<title>.*?</title>~', $title, $body);

            }

        }

        return $body;
    }
    
    /**
     * Authemticated user redirection
     *
     * @param string $body
     * @return string
     */
    protected static function directivesAuthDirect($body): string{
        //fetch pattern

        self::getMatches('authDirect', $body, $matches);

        foreach($matches as $match => $value){
            $query = str_replace(' ', '', $value);
            $url = str_ireplace(['@authdirect(\'','\')'], '', $query);
            $body = str_ireplace($value, '' , $body);
            authDirect($url);
            break;
        }
        return $body;
    }

    /**
     * Guest Redirection
     *
     * @param string $body
     * @return string
     */
    protected static function directivesGuestDirect($body): string{
        //fetch pattern
        
        self::getMatches('guestDirect', $body, $matches);

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
        
      self::getMatches('auth', $body, $matches);
      
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

        self::getMatches('import', $body, $matches);
        
        //convert and process pattern
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
     * Checks if the current url matches a particular window base
     *
     * @param string $body
     * @return string
     */
    protected static function directivesInPath($body): string {
        //get all imports
        $pattern = self::getMatches('inPath', $body, $matches);

        foreach($matches as $match){
            $arguments = str_ireplace(['@','(','inPath',')'], '', $match);

            $body = str_replace($match,"<?= inPath({$arguments}) ?>", $body);
        }

        return $body;
    }

    /**
     * Checks if the current url matches the entire request url
     *
     * @param string $body
     * @return string
     */
    protected static function directivesIsPath($body): string {
        //get all imports
        self::getMatches('isPath', $body, $matches);
        
        foreach($matches as $match){
            $arguments = str_ireplace(['@','(','isPath',')'], '', $match);

            $body = str_replace($match,"<?= isPath({$arguments}) ?>", $body);
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
        //get all includes
        self::getMatches('include', $body, $matches);

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
        self::getMatches('route', $body, $matches);

        //convert and process pattern
        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $url = preg_replace("~@route\(\s?'(.*?)'\s?\)~", "<?= route('$1'); ?>", $matchValue);

            $body = str_replace($matchValue, $url, $body);
            
        }

        return $body;
    }

    /**
     * Returns the default request data processor file
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesFormData($body): string 
    { 
        self::getMatches('formdata', $body, $matches);

        //convert and process pattern
        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $url = preg_replace("~@formdata~", "<?= DomUrl(FormData::action); ?>", $matchValue);

            $body = str_replace($matchValue, $url, $body);
            
        }

        return $body;
    }

    /**
     * Converts all error index directives to executable function
     *
     * @return string
     */
    protected static function directivesError($body) : string {

        self::getMatches('error', $body, $matches);

        foreach($matches as $structure) {

            //get the error name - fix brackets later!!! using preg_replace instead
            $errorArgs = str_replace(['@error','(',')'], '', $structure);

            $body = str_replace($structure, "<?= error({$errorArgs}) ?>", $body);

        }

        return $body;
        
    }

    /**
     * Sets a csrf token on forms
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesCsrf($body): string 
    { 
        self::getMatches('csrf', $body, $matches);

        if($matches){

            $token = Csrf::token();
            //convert and process pattern
            foreach($matches as $match => $matchValue){

                //strip off the rule pattern
                $csrfBuild = str_replace('@csrf', '<input type="hidden" value="'.$token.'" name="CSRF_TOKEN">', $matchValue); 

                $body = str_replace($matchValue, $csrfBuild, $body);
                
            }


        }

        return $body;
    }

    /**
     * Sets the form action for a specific form
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesAction($body): string 
    { 
        //get all imports
        self::getMatches('action', $body, $matches);

        //convert and process pattern
        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $action = preg_replace("~@action\(\s?'(.*?)'\s?\)~", "<input hidden=\"\" name=\":form-action\" value=\"$1\">", $matchValue);

            $body = str_replace($matchValue, $action, $body);
            
        }

        return $body;
    }

    /**
     * Sets the form attributes of name and value for a specific form input
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesBtn($body): string 
    { 
        //get all imports
        self::getMatches('btn', $body, $matches);

        //convert and process pattern
        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $action = preg_replace("~@btn\(\s?'(.*?)'\s?\)~", "name=\"$1\" value=\"$1\"", $matchValue);

            $body = str_replace($matchValue, $action, $body);
            
        }

        return $body;
    }

    /**
     * Retrieves the value of a last post data request
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesGet($body): string 
    { 

        $pattern = self::getMatches('get', $body, $matches);

        foreach($matches as $match => $matchValue){
            
            //strip off the rule pattern
            $name = str_ireplace(['@get.'],'', $matchValue);

             
            $expNames = explode('[', $name, 2);
            if($name){
                $name = '['.$expNames[0].']'; 
                if(count($expNames) > 1){
                    $name .= '['.$expNames[1];
                }

                $name = str_replace('[', "['", $name);
                $name = str_replace(']', "']", $name);
            
                $name = self::buildName($name, '$_GET');
                $name = "<?= ".$name." ?>";
  
                $old = preg_replace($pattern, $name, $matchValue);

                $body = str_replace($matchValue, $old, $body);
            }   
        }

        return $body;
    }

    /**
     * Retrieves the value of a last post data request
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesPost($body): string 
    { 

        $pattern = self::getMatches('post', $body, $matches);

        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $name = str_ireplace(['@post.'],'', $matchValue);

             
            $expNames = explode('[', $name, 2);
            if($name){
                $name = '['.$expNames[0].']'; 
                if(count($expNames) > 1){
                    $name .= '['.$expNames[1];
                }

                $name = str_replace('[', "['", $name);
                $name = str_replace(']', "']", $name);
            
                $name = self::buildName($name, '$_POST');
                $name = "<?= ".$name." ?>";
  
                $old = preg_replace($pattern, $name, $matchValue);

                $body = str_replace($matchValue, $old, $body);
            }   
        }

        return $body;
    }

    /**
     * Retrieves the value of a last forwarded data
     *
     * @param string $body
     * @return string rendered $body
     */
    protected static function directivesOld($body): string 
    { 

        $pattern = self::getMatches('old', $body, $matches);

        foreach($matches as $match => $matchValue){

            //strip off the rule pattern
            $name = str_ireplace(['@old.'],'', $matchValue);

             
            $expNames = explode('[', $name, 2);
            if($name){
                $name = '['.$expNames[0].']'; 

                if(count($expNames) > 1){
                    $name .= '['.$expNames[1];
                }

                $name = str_replace('[', "['", $name);
                $name = str_replace(']', "']", $name);
            
                $name = self::buildName($name);
                $name = "<?=".trim($name, " ")."?>";

                $old = preg_replace($pattern, $name, $matchValue);

                $body = str_replace($matchValue, $old, $body);
            }   

        }

        return $body;
    }

    private static function buildName($name, $method = '$_POST') {

        $eName = rtrim(str_replace("['", '' , $name), "']");
        $eName = explode("']", $eName);
        $eName = 'reqValue(\''.$method.'\', [\''.implode("','",$eName).'\'])';

        return $eName;
        
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
        self::getMatches('res', $body, $matches);

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
        self::getMatches('live', $body, $matches);
        $counter = 0;
        
        foreach($matches as $match) {

            $match = trim($match);

            if($counter == 0){
                //fetch content
                $params = str_replace(['@live(', '\'', ')'], '', $match);
                $params = str_replace(['@live'], '', $params);
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
        self::getMatches('domurl', $body, $matches);

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@domurl(",")", "'"], "", $match);           
            
            $replacement = "<?= DomUrl('{$url}') ?>";
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;
    }    

    protected static function directivesDomLink($body): string
    { 
  
        //get pattern
        self::getMatches('domlink', $body, $matches);

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@domlink(",")", "'"], "", $match);           
            
            $replacement = "<?= domLink('{$url}') ?>";
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;
    }    

    protected static function directivesFormUrl($body): string
    { 
  
        //get pattern
        self::getMatches('formurl', $body, $matches);

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@formurl(",")", "'"], "", $match);           
            
            $replacement = FormUrl($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;
    }    
    
    protected static function directivesImages($body): string
    { 
  
        //get pattern
        self::getMatches('images', $body, $matches);

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
        self::getMatches('src', $body, $matches);

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@src(",")", "'"], "", $match);           
            
            $replacement = ress($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;

    } 

    /**
     * alias for directiveSrc
     *
     * @param string $body
     * @return string
     */
    protected static function directivesRess($body): string
    { 
      
        return self::directivesSrc($body);

    } 

    /**
     * Add static files from the apps' res/main directory
     *
     * @param string $body
     * @return string
     */
    protected static function directivesMapp($body): string
    { 

        //get pattern
        self::getMatches('mapp', $body, $matches);

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@mapp(",")", "'"], "", $match);           
            $url = 'main/'.ltrim($url, '/');
            $replacement = ress($url);
            $body = str_replace($match, $replacement, $body);
            
        }

        return $body;

    } 

    /**
     * Add static files from the apps' res/assets directory
     *
     * @param string $body
     * @return string
     */
    protected static function directivesMass($body): string
    { 

        //get pattern
        self::getMatches('mass', $body, $matches);

        foreach($matches as $match){

            //strip off the rule pattern
            $url = str_ireplace(["@mass(",")", "'"], "", $match);           
            $url = 'assets/'.ltrim($url, '/');
            $replacement = ress($url);
            $body = str_replace($match, $replacement, $body);
            
        }


        return $body;

    } 

    /**
     * This method will be removed later.. Use @mass instead
     * - Add static files from the apps res/assets folder
     * - Imports static files 
     *
     * @param string $body
     * @return string
     */
    protected static function directivesAssets($body): string
    { 

      //get pattern
      self::getMatches('assets', $body, $matches);

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
            self::getMatches('view', $body, $matches);
    
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
        self::getMatches('lay', $body, $matches);

        foreach($matches as $match => $matchValue){
      
            //strip off the rule pattern
            $value = rtrim(str_ireplace(['@lay(', '\'', ')'], '', $matchValue), " ");
            $valuee = str_replace(['.','\\'],'/', $value);
            $replacement = '';
            
            $explode = explode(":", $valuee);

            if(count($explode)> 1){
                $url = $explode[0];
                $id = $explode[1];

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) === ''){
                    $url .= self::defaultExtension;
                }

                //build a layout pattern from layoutId values
                $layoutPattern = "~@layout:{$id}.*?@layout;~is";//replacement 


                //load layoutId's supplied template url
                $path =  docroot.DS.WIN_REX.ltrim($url, '/');

                if(!is_file($path)){

                    //get missing layout files
                    $missingLayouts = self::$missingFiles['layout'];

                    if(!in_array($path, $missingLayouts)) {

                        self::$missingFiles['layout'][] = $path;
                        
                        print self::directivesMapError([
                            'title'=> 'Layout missing :',
                            'message' => ' ',
                            'path' => str_replace('/', ' . ',WIN_REX.$url).''
                        ], $body);

                    }

                    //replace layout with null
                    $body = str_replace($matchValue, '', $body);

                }else{

                    ob_start();
                    include($path);
                    $templateContent = ob_get_clean();

                    //find expected layoutPattern from the template content
                    preg_match($layoutPattern, $templateContent, $contentsMatched);
                    $contentMatched = $contentsMatched[0]?? '';
                    $replacement = str_ireplace(["@layout:$id", "@layout;"], '', $contentMatched);

                }

                //make replacement in the body
                $newSlice =  Slicer::slice($replacement)->data();
                self::sort_lay_comments($newSlice);
                $data = preg_replace("~@lay\(\s?'{$value}'\s?\)~i",$newSlice, $body);

                $body = $data;
            }

        } 
        return $body;
    }

    protected static function directivesAttr($body): string {

        
       
        $attrLists = GET('x-attrs', 'x-attr-list');

        $pattern1 = "~@attr:[\w+-]+~is";
        // $pattern2 = "~@attr\(\s?'.*?'\s?\)~is";
    
        preg_match_all($pattern1, $body, $matches1);
        $matches1 = $matches1[0] ?? [];

        foreach($matches1 as $match1){

            $value = explode(':', $match1)[1] ?? '';

            $replacement = $attrLists[$value] ?? '';


            $body = str_replace($match1, $replacement, $body);
            
        }


        return $body;
    }

    protected static function directivesStyles($body): string {
        
        if(stripos($body, '@styles') !== false) self::$PULLSTYLES = true;
        return $body;

    }
    
    /**
     * Directs the slicer to remove all layout syntaxes from render page
     * Only the syntax will be removed. The content of the syntax remains
     *
     * @param string $body
     * @return string $body
     */
    protected static function directivesStyle($body): string 
    {   
        self::getMatches('style', $body, $matches);
        $replacement = '';

        foreach($matches as $match => $matchValue){
         
            //strip off the rule pattern
            $value = rtrim(str_ireplace(['@style(', '\'', ')'], '', $matchValue), " ");
            $valuee = str_replace(['.','\\'],'/', $value);
            
            $explode = explode(":", $valuee);

            if(count($explode) > 1){

                $url = $urx = array_shift($explode);

                //$urx = str_replace('/', '.', url($urx)->ignore(1));
                $urx = str_replace('/', '.', $urx);

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) !== 'css'){
                    $url .= self::extensions['css'];
                }

                //load layoutId's supplied template url
                $path =  docroot.DS.WIN_REX.ltrim($url, '/');
                
                if(!is_file($path)){

                    //get missing style files
                    $missingStyles = self::$missingFiles['css'];

                    if(!in_array($path, $missingStyles)) {

                        self::$missingFiles['css'][] = $path;
                        
                        print self::directivesMapError([
                            'title'=> 'Style missing :',
                            'message' => ' ',
                            'path' => str_replace('/', ' . ',WIN_REX.$url).''
                        ], $body);

                    }

                    // replace matched value with null
                    $body = str_replace($matchValue, '', $body);

                }else{

                    ob_start();
                    include($path);
                    $templateContent = ob_get_clean();

                    $replacement = '';


                    foreach($explode as $id){

                        //build a style pattern from style id
                        $layoutPattern = "~#style:{$id}\s(.)*?#style;~is";//replacement 

                        //find expected style pattern from the template content
                        preg_match($layoutPattern, $templateContent, $contentsMatched);
                        $contentMatched = $contentsMatched[0]?? '';
                        $contentMatched = preg_replace('~\\\([A-Za-z0-9]{2,100})~', "\\\\\\\\$1", $contentMatched);
                        $replacement .= str_ireplace(["#style:$id", "#style;"], '', $contentMatched);

                    }                
                    
                    if(trim($replacement)){
                        $replacement = '<style rel="'.$urx.'"> '.$replacement.' </style>';
                    }
                    
                    if(SELF::$PULLSTYLES){
                        $styles = (SETTER::EXISTS(':STYLES'))? GET(':STYLES', '#1234') : ''; 
                        $styles .= $replacement;
    
                        SET(':STYLES', $styles, '#1234');
                        $data = preg_replace("~@style\(\s?'{$value}'\s?\)~i", '', $body);
                    }else{
                        $data = preg_replace("~@style\(\s?'{$value}'\s?\)~i", $replacement, $body);
                    }
                    
                    //make replacement in the body
                    $body = $data; 
                    
                    
                }

                //$id = $explode[1];

  

            }

        }

        return $body;
    }
    
    /**
     * Directs the slicer to remove all layout syntaxes from render page
     * Only the syntax will be removed. The content of the syntax remains
     *
     * @param string $body
     * @return string $body
     */
    protected static function directivesScript($body): string 
    {   
        self::getMatches('script', $body, $matches);
        $replacement = '';

        foreach($matches as $match => $matchValue){
         
            //strip off the rule pattern
            $value = rtrim(str_ireplace(['@script(', '\'', ')'], '', $matchValue), " ");
            $valuee = str_replace(['.','\\'],'/', $value);
            
            $explode = explode(":", $valuee);

            if(count($explode) > 1){

                $url = $explode[0];

                $url = $urx = array_shift($explode);

                //$urx = str_replace('/', '.', url($urx)->ignore(1));
                $urx = str_replace('/', '.', $urx);

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) !== 'js'){
                    $url .= self::extensions['js'];
                }

                //load layoutId's supplied template url
                $path =  docroot.DS.WIN_REX.ltrim($url, '/');
                

                if(!is_file($path)){

                    //get missing script files
                    $missingStyles = self::$missingFiles['js'];

                    if(!in_array($path, $missingStyles)) {

                        self::$missingFiles['js'][] = $path;
                        
                        print self::directivesMapError([
                            'title'=> 'Script missing :',
                            'message' => ' ',
                            'path' => str_replace('/', ' . ',WIN_REX.$url).''
                        ], $body);

                    }
                    
                    // replace matched value with null
                    $body = str_replace($matchValue, '', $body);

                }else{

                    ob_start();
                    include($path);
                    $templateContent = ob_get_clean();

                    $replacement = '';

                    foreach($explode as $id){
                
                        //build a script pattern from script id
                        $layoutPattern = "~#script:{$id}\s(.)*?#script;~is";//replacement 
                        //find expected script pattern from the template content
                        preg_match($layoutPattern, $templateContent, $contentsMatched);
                        
                        $contentMatched = $contentsMatched[0]?? '';
                        $contentMatched = preg_replace('~\\\([A-Za-z0-9]{2,50})~', "\\\\\\\\$1", $contentMatched);
                        $replacement .= str_ireplace(["#script:$id", "#script;"], '', $contentMatched);

                    }

                    if(trim($replacement)){ 
                        $replacement = <<<SCRIPT
                        <script rel="$urx"> 
                            $replacement 
                        </script>
                        SCRIPT;
                    }
                    
                    //make replacement in the body
                    $data = preg_replace("~@script\(\s?'{$value}'\s?\)~i", Slicer::slice($replacement)->data(), $body);
                    $body = $data; 

                }

            }

        }

        return $body;
    }
    
    /**
     * Directs the slicer to remove all layout syntaxes from render page
     * Only the syntax will be removed. The content of the syntax remains
     *
     * @param string $body
     * @return string $body
     */
    protected static function directivesOnScript($body): string 
    {   
        self::getMatches('onscript', $body, $matches);
        $replacement = '';

        foreach($matches as $match => $matchValue){
         
            //strip off the rule pattern
            $value = rtrim(str_ireplace(['@onscript(', '\'', ')'], '', $matchValue), " ");
            $valuee = str_replace(['.','\\'],'/', $value);
            
            $explode = explode(":", $valuee);

            if(count($explode) > 1){

                $url = $explode[0];

                $url = $urx = array_shift($explode);

                //$urx = str_replace('/', '.', url($urx)->ignore(1));
                $urx = str_replace('/', '.', $urx);

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) !== 'css'){
                    $url .= self::extensions['js'];
                }

                //load layoutId's supplied template url
                $path =  docroot.DS.WIN_REX.ltrim($url, '/');

                if(!is_file($path)){
                    print self::directivesMapError([
                        'title'=> 'Script Error :',
                        'message' => ' ',
                        'path' => str_replace('/', ' . ',WIN_REX.$url).''
                    ], $body);
                }else{

                    ob_start();
                    include($path);
                    $templateContent = ob_get_clean();

                    $replacement = '';

                    foreach($explode as $id){
                
                        //build a script pattern from script id
                        $layoutPattern = "~#script:{$id}\s(.)*?#script;~is";//replacement 
                        //find expected script pattern from the template content
                        preg_match($layoutPattern, $templateContent, $contentsMatched);
                        
                        $contentMatched = $contentsMatched[0]?? '';
                        $contentMatched = preg_replace('~\\\([A-Za-z0-9]{2,50})~', "\\\\\\\\$1", $contentMatched);
                        $replacement .= str_ireplace(["#script:$id", "#script;"], '', $contentMatched);

                    }

                    if(trim($replacement)){
                        $replacement = <<<SCRIPT
                        <script rel="$urx"> 
                        window.onload = function() {
                            $replacement 
                        }
                        </script>
                        SCRIPT;
                    }
                    
                    //make replacement in the body
                    $data = preg_replace("~@onscript\(\s?'{$value}'\s?\)~i", Slicer::slice($replacement)->data(), $body);
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

    /**
     * Include a template file
     *
     * @param string $body
     * @return string|void
     */
    protected static function directivesTemplate($body){

        //get the template url openers
        $pattern = "~@template\(\s?'[-\w+\\\.]+(:off)?\'\s?\).*?@template;~is";
        preg_match($pattern, $body, $matches);
        
        //Get template
        $match = $matches[0] ?? ''; 

        if($match){

            //Fetch template opener
            preg_match(self::$pattern['template'], $match, $matched);

            $opener = $matched[0];
            $closer = '@template;';
    
            //Fetch Url
            $tempUrl = str_ireplace(['@template(','\'',')'] ,'', $opener);
            $url = str_replace(['.','\\'], '/', $tempUrl);    
            
            //load template's supplied url
            $off = (substr($url, -4) === ':off');
            
            $urx = explode(':off', $url);
            $rex = WIN_REX.ltrim($urx[0], '/');
            $url = docroot.DS.$rex;

            //get url extension
            if (pathinfo($url, PATHINFO_EXTENSION) === '') {
                $url .= self::defaultExtension;
                $rex .= self::defaultExtension;
            }

            if (!is_file($url)) {

                print self::directivesMapError([
                    'title'=> 'Template Error :',
                    'message' => 'Template file does not exists',
                    'path' => $rex
                ], $body);  

                $needle1 = "@template('$tempUrl')";
                $pos1 = strpos($body, $needle1);
                $body = substr_replace($body, '', $pos1, strlen($needle1));

                $needle2 = "@template;";
                $pos2 = strrpos($body, $needle2);
                $body = substr_replace($body, '', $pos2, strlen($needle2));

                return $body;
            } else { 
                ob_start();
                include($url);
                $template = ob_get_clean(); //new replacement
                
                //filter out structure 
                $content = str_replace([$opener, $closer], '', $match);

                $template = str_replace('@yield()', $content, $template);
                if($off){
                    $template = str_ireplace(['@live()','@live','@import(\'::watch\')', '@res::import(\'::watch\')'], '', $template);
                }
                
                $template = Slicer::slice($template)->data();

                $body = self::directivesTitle(str_replace($match, $template, $body));
            }    

        }
        

        return $body;

    }

    protected static function directivesOnShow($body) : string {

        self::getMatches('onShow', $body, $matches);
    
        foreach($matches as $structure){
    
            //get onshow arguments
            $onShowArgs = str_ireplace(['@onShow', '(',')', "'"], '', $structure);
            $args = explode(',', $onShowArgs);
            array_trim($args);
    
            $args = trim("'".implode("','", $args)."'", ' ');
    
            $body = str_replace($structure, "<?= onShow({$args})?>", $body);
    
        }
        return $body;

    }

    protected static function directivesOnHide($body) : string {

        self::getMatches('onHide', $body, $matches);

        foreach($matches as $structure){

            //get onshow arguments
            $onShowArgs = str_ireplace(['@onHide', '(',')', "'"], '', $structure);
            $args = explode(',', $onShowArgs);
            array_trim($args);

            $args = trim("'".implode("','", $args)."'", ' ');

            $body = str_replace($structure, "<?= onHide({$args})?>", $body);

        }
        return $body;
        
    }



    protected static function directivesSection($body){

        //get the template url openers
        $pattern = "~@section\(\s?'[-\w+\\\.]+\'\s?\).*?@section;~is";
        preg_match($pattern, $body, $matches);

        $callback = function($matches) use ($body) {
            
            //Get template
            $match = $matches[0]; 
           
            //Fetch template opener
            preg_match(self::$pattern['section'], $match, $matched);
                        
            $opener = $matched[0];
            $closer = '@section;';
           
            //Fetch Url
            $tempUrl = str_ireplace(['@section(','\'',')'] ,'', $opener);
            $url = str_replace(['.','\\'], '/', $tempUrl);    
            
            //load template's supplied url
            $url =  docroot.DS.WIN_REX.ltrim($url, '/');
   
            //get url extension
            if (pathinfo($url, PATHINFO_EXTENSION) === '') {
                $url .= self::defaultExtension;
            }
  
            if (!is_file($url)) {
                print self::directivesMapError([
                    'title'=> 'Layout Error :',
                    'message' => 'Layout does not exists',
                    'path' => $url
                ], $body);
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
      self::getMatches('flash', $body, $matches);
     
      foreach($matches as $flash){

        $flasharg = substr($flash, 7, strlen($flash));
        $flasharg = substr($flasharg, 0, -1);

        // print $flasharg;
          
        $body = str_replace($flash, "<?= Res::flash($flasharg)??'' ?>", $body);
      }
      
      return $body;
    } 

    private static function directivesMapError(array $array = [], $body = ''){
        if(func_num_args() > 0){
          $arg = $array;

          $resLink = '<link rel="stylesheet" type="text/css" href="'.domurl('res/main/css/res.css', false).'" x-debug="res-css">';
          
          if(strpos($body, $resLink) !== false){
            $resLink = '';
          }
    
          $title = $arg['title']?? '';
          $message =  $arg['message']?? '';
          $icon    = array_key_exists('icon', $arg)? $arg['icon'] : 'bi-exclamation-triangle';
    
          $filePath    = $arg['path']?? '';
          $message = '<span class="calibri fb-6 class="flex-full midv"><span class="'.$icon.'"></span> '.$title. ' <span> ' .$message.'</span> </span> <span class="c-grey font-em-d85">'.$filePath.' </span>';
          
          return $resLink.'
            <div class="spoova-route-error pxv-4 c-red-d">
              <div class="box-full pxv-10 bc-white-dd">'.$message.'</div>
            </div>
          ';
        }
    }

    protected static function directivesVdump($body){

        
        ob_start();
        include($url);
        $template = ob_get_clean(); //new replacement

        Res::load(_core.'/custom/errors/dump', fn() => compile($var));
        if(func_num_args() > 0){
          $arg = $array;
    
          $title = $arg['title']?? '';
          $message =  $arg['message']?? '';
          $icon    = array_key_exists('icon', $arg)? $arg['icon'] : 'bi-exclamation-triangle';
    
          $filePath    = $arg['path']?? '';
          $message = '<span class="calibri fb-6 class="flex-full midv"><span class="'.$icon.'"></span> '.$title. ' <span> ' .$message.'</span> </span> <span class="c-grey font-em-d85">'.$filePath.' </span>';
          
          return '
            <div class="spoova-route-error pxv-4 c-red-d">
              <div class="box-full pxv-10 bc-white-dd">'.$message.'</div>
            </div>
          ';
        }
    }

    protected static function directivesPhp($body) : string {
      //load flashes
      self::getMatches('php', $body, $matches);

      foreach($matches as $php){

        $body = str_ireplace(['@php:','@php;'], ['<?php', '?>'], $body);

      }

      return $body;

    }

    private static function sort_lay_comments(&$body){
        //fetch all comment-like structures in body
        preg_match_all('~<!--.*?-->~s', $body, $fetches);

        $fetches = $fetches[0];

        foreach($fetches as $fetched) {
            $hashed = base_encode(base_encode($fetched));
            $body = str_replace($fetched, "<!--".$hashed."-->", $body);
            static::$layComments[] = "<!--".$hashed."-->";      
        }

    }
  
    public static function unsort_lay_comments(&$body){
        foreach(static::$layComments as $comment){
            $commentHash = base_decode(base_decode(substr($comment, 4, strlen($comment) - 7)));
            $commentElem = $commentHash;
            $body = str_replace($comment, $commentElem , $body);
        }
    }

    /**
     * Returns the macthes from a pattern
     *
     * @param string $pattern
     * @param string $body text body
     * @param mixed $matches stores data found
     * @return string $pattern return pattern used
     */
    private static function getMatches(string $pattern, $body, &$matches){

      //load flashes
      $pattern = self::$pattern[$pattern]; //include a flash if it exists
    
      preg_match_all($pattern, $body, $matches);
      $matches = $matches[0] ?? [];

      return $pattern;

    }

}

?>