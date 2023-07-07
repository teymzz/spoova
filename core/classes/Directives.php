<?php

namespace spoova\mi\core\classes;

use Res;
use Rexit;
use spoova\mi\app\RexComponent;

/**
 * Contains Directives for slice tool
 * @author Akinola Saheed <teymss@gmail.com>
 * 
 */
abstract class Directives{

    protected static $locals = [];

    protected static $pattern = [

        // Set a page title
        'title'  => "~@title\('.*?'\)~i", 
        
        // Handle content displayed
        'auth'        => "~@auth:\s?(.)*?@auth;~is", 
        'guest'       => "~@guest:\s?(.)*?@guest;~is",

        // Import a specific resource
        'import'      => "~(<@import\s|@import\()\s?\'?(http(s)?:\/\/)?[A-Za-z_\/]+(.[A-Za-z]+)\'?\s?(\)|\/>)~i", //import (local or remote file) css / js files

        //Handle live server
        'live'        => '~@live(\((\'(console|pop|uiconsole|[0-9])?\')?\))?~i', 

        // Handles layout templating
        'styles'      => '~@styles~i', //set a layout a layout file
        'style'       => '~@style\(\s?\'[A-zA-Z0-9_\\.-]{2,}(:[A-zA-Z_0-9.\-_]*?)*?\'\s?\)~i', //set a layout a layout file
        'script'      => '~@script\(\s?\'[A-zA-Z0-9_\\.-]{2,}(:[A-zA-Z_0-9.\-_]*?)*?\'\s?\)~i', //set a layout a layout file
        'onscript'    => '~@onscript\(\s?\'[A-zA-Z0-9_\\.-]{2,}(:[A-zA-Z_0-9.\-_]*?)*?\'\s?\)~i', //set a layout a layout file
        
        // Handle template injecting
        'template'    => '~@template\(\s?\'[-\w+\\.]+?(:off)?\'\s?\)~i',
        'lay'         => '~@lay\(\s?\'[A-zA-Z0-9_\\.-]{2,}:[A-zA-Z_0-9.\-_]*?\'\s?\)~i', //set a layout a layout file
        'layout'      => '~@layout:[A-Za-z_-0-9.]{2,}\.@layout;~i', //set a layout a layout file
    
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

    protected static $PULLSTYLES = false;

    /**
     * template extensions
     */
    protected const extensions = ['php'=>'.rex.php', 'html'=>'.rex.html', 'css' => '.rex.css', 'js' => '.rex.js']; // layout extensions

    /**
     * layout extensions
     */
    protected const defaultExtension = self::extensions['php'];

    protected static function directivesController(string $body, $directive) : string {

        $pattern1 = "~@$directive\((.*?)?\)~i"; 
        $pattern2 = '~@'.$directive.'[\s\n]+?~i';
        $pattern3 = '~@(old|post|get).(\w+)(\[[\w+\.-_]+\])?~i';

        preg_match($pattern1, $body, $matches);

        if($matches) {

            //if(strtolower($directive) === 'head' && (strpos('??', $name) === false)) $name = " ?? ''";
            $body = preg_replace("~@$directive\((.*?)?\?\s*?\)~i", '<?= Rexit::'.$directive.'($1 ?? \'\') ?>', $body);
            $body = preg_replace($pattern1, '<?= Rexit::'.$directive.'($1) ?>', $body);
        
        }else{

            preg_match($pattern2, $body, $matches);

            if($matches) {
                $body = preg_replace($pattern2, '<?= Rexit::'.$directive.'() ?>', $body);
            }else{

                //request pattern - 1
                preg_match_all($pattern3, $body, $matches);
                $matches = $matches[0] ?? [];

                if($matches){

                    foreach($matches as $match){
                        $name = str_ireplace(["@$directive."],'', $match);

                        $expNames = explode('[', $name, 2);
                        if($name){
                            $name = '['.$expNames[0].']'; 
            
                            if(count($expNames) > 1){
                                $name .= '['.$expNames[1];
                            }
            
                            $name = str_replace(['][','[',']'], ['\',\'','[\'','\']'], $name);

                            $body = str_replace($match, '<?= Rexit::'.$directive.'('.$name.') ?>', $body);
        
                        }   
                    }

                }
               

            }
            
        }

        return $body;

    }

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

                $body = preg_replace('~<\?= Rexit::head(.*?) \?>~', $title, $body);
                $body = preg_replace('~<title>.*?</title>~', $title, $body);

            }

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
     * Loads and renders the file path supplied
     *
     * @param string $file
     * @param array $params variables supplied as arguments
     * @return string rendered $body
     */
    abstract protected static function loadTemplate(string $file, $params = []);

    /**
     * Start a live server
     *
     * @param string $body
     * @return string
     */
    protected static function directivesLive($body): string {
    
        if(preg_match('~@csrf\s~is', $body, $csrf)){
            $body = preg_replace('~@live(\((\'(console|pop|uiconsole|[0-9])?\')?\))?~i', '', $body);
        }

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
                $body = str_replace($match, '<?= Res::live() ?>', $body);
            } 
            $body = str_replace($match, '', $body);
            $counter++;
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
                $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/');

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

                //self::sort_lay_comments($newSlice);
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
                $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/');
                
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
                        $replacement = '<style rel="'.$urx.'"> '.$replacement.' </style>'."\n";
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
                $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/');
                

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
                $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/');

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
            $rex = to_frontslash(WIN_REX).ltrim($urx[0], '/');
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
            $url =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/');
   
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

    protected static function directivesPhp($body) : string {

      self::getMatches('php', $body, $matches);

      foreach($matches as $php){

        $newphp = str_ireplace(['@php:','@php;'], ['<?php', '?>'], $php);

        $body = str_ireplace($php, $newphp, $body);

      }

      return $body;

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