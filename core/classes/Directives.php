<?php

namespace spoova\mi\core\classes;

use Exception;
use Res;
use Window;
use Rexit;

/**
 * Contains Directives for slice tool. 
 * All directives specifically defined within this class are 
 * executed at the top of slice tool
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 * 
 */
abstract class Directives{

    protected static $locals = [];
    protected static $cssLayouts = [];
    protected static $jsLayouts = [];
    protected static $current_layout = '';


    protected const specials = ['csrf','lasturi'];

    protected static $pattern = [

        // Set a page title
        'title'  => "~@title\('.*?'\)~i",

        // Handle content displayed
        'auth'        => "~@auth:\s?(.)*?@auth;~is", 
        'guest'       => "~@guest:\s?(.)*?@guest;~is",
        // 'uriscope'    => "~@uriscope:(([a-zA-Z0-9_\(\)@:%\\+.\~&/=-])+?):(true|false)\b?(.*?)@uriscope;~is", //([a-zA-Z0-9_()@:%\\]) follows matches
        'uriscope'    => "#@uriscope:([a-zA-Z0-9_@:%+./~&()=-]+)(?::(follows|matches|deviated|negated))?\s*(.*?)@uriscope;#is", //([a-zA-Z0-9_()@:%\\])
        
        //Handle live server
        'live'        => '~@live(?:\([^()]*\))?~', 

        // Handles layout templating
        'styles'      => '~@styles~i', //set a layout a layout file
        // 'style'       => '~@style\(\s?\'[a-zA-Z0-9_\\.-@]{2,}(:[a-zA-Z0-9.\-_]*?)*?\'\s?\)~i', //set a layout file
        // 'style'       => "~@style\(\s?'([a-zA-Z0-9_.\\-@]+(?::[a-zA-Z0-9_.\\-]+)*)'\s?\)~i", //set a layout file
        'style'       => "~@style\(\s?'((?:@[a-zA-Z0-9_]+::)?[a-zA-Z0-9_.-]+(?::[a-zA-Z0-9_.-]+)*)'\s?\)~i", //set a layout file
        // 'script'      => "~@script\(\s?'([a-zA-Z0-9_\\./\-@]{2,}(?::[a-zA-Z0-9.\-_]*?)*)'(?:\s*,\s*'?(\w+)'?)?\s*\)~i", //set a layout file
        // 'onscript'    => "~@onscript\(\s?'([a-zA-Z0-9_\\./\-@]{2,}(?::[a-zA-Z0-9.\-_]*?)*)'(?:\s*,\s*'?(\w+)'?)?\s*\)~i", //set a layout file
        'script' => "~@script\(\s?'([a-zA-Z0-9_\\\\./\-@]{2,}(?::[a-zA-Z0-9.\-_]*?)*)'(?:\s*,\s*'?(\w+)'?)?\s*\)~i",
        'onscript' => "~@onscript\(\s?'([a-zA-Z0-9_\\\\./\-@]{2,}(?::[a-zA-Z0-9.\-_]*?)*)'(?:\s*,\s*'?(\w+)'?)?\s*\)~i",
        // Handle template injecting
        'template'    => '~@template\(\s?\'[-\w+\\.]+?(:off)?\'\s?\)~i',
        'lay'         => '~@lay\(\s?\'[a-zA-Z0-9_\\-.]{2,}:[a-zA-Z_0-9.\-_]*?\'\s?\)~i', //set a layout file
        'layout'      => '~@layout:[a-zA-Z_-0-9.]{2,}\.@layout;~i', //set a layout file
    
        'php'         => "~@php:.*?@php;~is",
        'use'         => "~@use(.*?)~is",
        'uses'        => "~@uses(.*?)~is",
        'attr'        => "~@((attr:[\w+-]+)|(attr\(\s?'.*?'\s?\)))~is",
        'saved'        => "~@((saved:[\w-]+)|(saved\(\s?'.*?'\s?\)))~is",
        
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

    protected static function directivesController(string $body, string $directive) : string {

        $pattern1A = "~@$directive\(:(.*?)?:\)~i"; 
        $pattern1 = "~@$directive\((.*?)?\)~i"; 
        $pattern2 = '~(?<!\w)@'.$directive.'(?!\w)~i'; // csrf, lasturi, ...
        $pattern3 = '~@'.$directive.'\.(\w+)(\[[\w+\.-_]+\])?~i'; //old, post, get

        preg_match($pattern1, $body, $matches);

        $body = preg_replace("~@$directive\(`(.*?)`\)~i",'@'.$directive.'(\'$1\')',$body); // support for formats e.g @domurl(`path`)
        
        if($matches) {

            $body = preg_replace("~@$directive\((.*?)?\?\s*?\)~i", '<?= Rexit::'.$directive.'($1 ?? \'\') ?>', $body);
            $body = preg_replace($pattern1A, '<?= Rexit::'.$directive.'($1) ?>', $body);
            $body = preg_replace($pattern1, '<?= Rexit::'.$directive.'($1) ?>', $body);
        
        }else{
            
            if(preg_match_all($pattern3, $body, $matches)){
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
            }else if(preg_match($pattern2, $body, $matches)){
                if(in_array($directive, self::specials)){
                    $body = preg_replace($pattern2, '<?= Rexit::'.$directive.'() ?>', $body);
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
        /** @var array $matches */
        foreach($matches as $match => $value){
            $query = str_replace(' ', '', $value);
            $url = str_ireplace(['@guestdirect(\'','\')'], '', $query);
            $body = str_ireplace($value, '' , $body);
            guestDirect($url);
            break;
        }
        return $body;
    }

    protected static function directivesGuest(string $body): string {
      
      
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
    
    protected static function directivesAuth(string &$body): string {
        
      self::getMatches('auth', $body, $matches);
      /** @var array $matches */
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
    
    protected static function directivesUriscope(string &$body): string {
        
      self::getMatches('uriscope', $body, $matches, $all);
      
      /** @var array $matches */
      foreach($matches as $match => $matched) {
        
          
        if(isset($all[1]) && is_array($all[1]) && array_key_exists($match, $all[1])){
            $uri = $all[1][$match]; // supplied url notPath
            $urx = strtolower($uri);

            if(($a = str_ends_with($urx, ':deviated'))||(str_ends_with($urx, ':negated'))){
                $enable = false;
                if($a){
                    $uri = substr($uri, 0, -9);
                    $type = 'deviated';
                }else{
                    $uri =  substr($uri, 0, -8);
                    $type = 'negated';
                }
            }elseif(($a = str_ends_with($urx, ':')) || ($b = str_ends_with($urx, ':imitated')) || (str_ends_with($urx, ':equated'))){
                /** @var bool $a */
                /** @var bool $b */
                $enable = true; 

                if($a){
                    $uri = substr($uri, 0, -1);
                    $type = 'imitated'; // follows
                }elseif($b){
                    $uri = substr($uri, 0, -9);
                    $type = 'imitated'; // follows
                }else{
                    $uri = substr($uri, 0, -8);
                    $type = substr($urx, -7); // imitated, matches
                }
            }else{
                $enable = false;
                $type = false;
            }

            $url = window('base'); // current url
            if($enable){
                if($type === 'equated'){
                    $body = str_replace($matched, (url($url)->is($uri,  Window::IsCaseSensitive()))? $all[3][$match] : '', $body);
                }else{
                    $body = str_replace($matched, (url($url)->isLike($uri,  Window::IsCaseSensitive()))? $all[3][$match] : '', $body);
                }
                continue;
            }else{
                if($type === 'negated'){
                    $body = str_replace($matched, url($url)->is($uri,  Window::IsCaseSensitive())? '' : $all[3][$match], $body);
                }else{
                    if($type !== false){
                        $body = str_replace($matched, url($url)->isLike($uri,  Window::IsCaseSensitive())? '' : $all[3][$match], $body);
                    }
                }
                continue;
            }
            
            $body = str_replace($matched, '', $body);
        }else{
           $body = str_replace($matched, '', $body);
        }
        
      }
      
      return $body; 
      
    }
    
    protected static function directivesImport(string &$body): string
    {

        self::getMatches('import', $body, $matches);
        
        //convert and process pattern
        /** @var array $matches */
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

        if(preg_match('~@(csrf\(.*?\)|csrf)\s~is', $body, $csrf) || preg_match('~@action(.*?)\s~is', $body, $csrf)){
            //replace live server poll to seek if @csrf detected
            $tuneOn = Init::value('CSRF_GEN', fn($val) => strtolower((string)$val)) === 'false'; // CSRF Field Generation off.
            if(!$tuneOn) $body = preg_replace('~@live(\(.*?\))?~is', "", $body);            
            if(!$tuneOn) Res::off();
        }

        if((strtolower(Livescript::key('ACTIVITY')) !== '2') && online) {
           Res::off();
        }

        $body = preg_replace('~@live(\((.*?)?\))?~is', '<?= Res::live($1) ?>', $body);
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
    protected static function directivesLay(string $body): string 
    {
        self::getMatches('lay', $body, $matches);
        /** @var array $matches */
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
                $value = preg_quote($value);
                $data = preg_replace("~@lay\(\s?'{$value}'\s?\)~i",$newSlice, $body);

                $body = $data;
            }

        } 
        return $body;
    }

    protected static function directivesAttr(string $body): string {
       
        $attrLists = GET('x-attrs', 'x-attr-list');

        $pattern1 = "~@attr:[\w+-]+~is";
    
        preg_match_all($pattern1, $body, $matches1);
        $matches1 = $matches1[0] ?? [];

        foreach($matches1 as $match1){

            $value = explode(':', $match1)[1] ?? '';

            $replacement = $attrLists[$value] ?? '';

            $body = str_replace($match1, $replacement, $body);
            
        }

        return $body;
    }

    protected static function directivesSaved(string $body): string {
       
        $attrLists = GET('x-save', 'x-save-list');

        $pattern1 = "~@saved:\w+#\d+\(.*?\)~is";
        $pattern2 = "~@saved:[A-Za-z0-9_]+(?:#[0-9]+)?~is";

        if(preg_match_all($pattern1,$body, $matches1) !== false){
            $replacement = '';
            $matches1 = $matches1[0] ?? [];
            foreach($matches1 as $match1){
                
                preg_match('~@saved:(\w+)#(\d+)\((.*?)\)~is', $match1, $splits);
                
                $key = $splits[1] ?? '';
                $id = $splits[2] ?? '';
                $val = $splits[3] ?? '';

                if(trim($val) && !preg_match('~^[A-Za-z0-9/, _-]+$~', $val)){
                    throw new Exception('saved item cannot contain invalid characters');
                }

                if($key){
                    $values = explode(',', $val);
                    $replacement = $attrLists[$key];
                    $replacement = $replacement[$id] ?? '';
                    // find placeholders in format @savedArg:1
                    if(preg_match_all('~\{@savedArg:(\d+)+?\}~i', $replacement, $entry) !== false){
                        $argIDs = array_unique($entry[1] ?? []);
    
                        foreach($argIDs as $argID){
                            $value = $values[$argID] ?? '';
                            $replacement = preg_replace('~\{@savedArg:'.$argID.'\}~i', $value, $replacement);
                        }
                    }
                }
                    
                $body = str_replace($match1, $replacement, $body);
                
            }
        }
        
        if(preg_match_all($pattern2, $body, $matches1) !== false){
            $matches1 = $matches1[0] ?? [];
            $matches1 = array_unique($matches1);
            foreach($matches1 as $match1){
    
                $value = explode(':', $match1)[1] ?? '';

                if(strpos($value, '#') !== false){
                    $exps = explode('#',$value, 2);
                    $key = $exps[0]; 
                    $id = $exps[1];
                    $replacement = ($attrLists[$key] ?? []);
                    $replacement = $replacement[$id??0] ?? ''; // retrieve the first replacement of id 
                    $replacement = preg_replace('~\{@savedArg:\d+\}~i', '#undefined', $replacement); // replace any @savedArg:digit format
                    
                    $body = str_replace($match1, $replacement, $body);

                }else{
                    
                    $replacement = ($attrLists[$value] ?? []);
                    $replacement = $replacement[0] ?? ''; // retrieve the first replacement of id 
                    $replacement = preg_replace('~\{@savedArg:\d+\}~i', '#undefined', $replacement); // replace any @savedArg:digit format
                    $body = preg_replace('~'.$match1.'(?!#\d+)~', $replacement, $body);

                }
            }
        }
        return $body;
    }

    /**
     * Resolve the directory of the currently-compiled rex file as a path that is
     * RELATIVE to the windows/Rex base, for use by the `@this::` import prefix.
     *
     * `Compiler::currentFile()` may return the rex-relative path, a WIN_REX
     * prefixed path, or a full document-root path depending on how the file was
     * loaded. Since the callers still prepend WIN_REX to build the real file
     * path, any WIN_REX (or docroot) already present here must be stripped first,
     * otherwise the base is duplicated (e.g. "windows/Rex/windows/Rex/...").
     *
     * Comparison honours the dot convention (dots/forward/back slashes are
     * treated as equivalent separators) and is case-insensitive on the base.
     *
     * @return string forward-slash directory relative to windows/Rex,
     *                 without leading/trailing slash (e.g. "docs/cli/generic").
     */
    protected static function thisRexDir() : string
    {
        // Normalise separators; keep the filename intact, then take its directory.
        $current = str_replace('\\', '/', (string) Compiler::currentFile());
        $current = preg_replace('#/+#', '/', $current);
        $dir = trim(dirname($current), '/');
        if($dir === '.' || $dir === '..') $dir = '';

        $root   = trim(str_replace('\\', '/', docroot), '/');
        $winrex = trim(str_replace(['\\', '.'], '/', WIN_REX), '/'); // e.g. "windows/Rex"

        // Strip a leading document-root (full-path form).
        if($root !== '' && str_starts_with(strtolower($dir), strtolower($root).'/')){
            $dir = substr($dir, strlen($root) + 1);
        }

        // Strip a leading windows/Rex base (already-prefixed form).
        if($winrex !== ''){
            $dirCmp = strtolower($dir);
            $winCmp = strtolower($winrex);
            if($dirCmp === $winCmp){
                $dir = '';
            }elseif(str_starts_with($dirCmp, $winCmp.'/')){
                $dir = substr($dir, strlen($winrex) + 1);
            }
        }

        return trim($dir, '/');
    }

    /**
     * Build the `@this::` value (a windows/Rex-relative dotted path) from the
     * current rex directory and the remaining "<file>:<ids>" portion.
     *
     * @param string $value the directive value with the `@this::` prefix removed
     * @return string
     */
    protected static function thisRexValue(string $value) : string
    {
        $dir = self::thisRexDir();
        return ($dir !== '' ? str_replace('/', '.', $dir).'.' : '').$value;
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

        /** @var array $matches */
        foreach($matches as $match => $matchValue){
         
            //strip off the rule pattern
            $value = rtrim(str_ireplace(['@style(', '\'', ')'], '', $matchValue), " ");
            $input = $value; $root = false;
            $prefix = substr($value, 0, 7);
            
            $prefixes = ['@root::','@this::','@windows::', '@rex::'];
            foreach ($prefixes as $prefix){
              if(str_starts_with($value, $prefix)) break;
              $prefix = '';
            }
            
            if($prefix) $value = substr($value, strlen($prefix));

            if($prefix === '@this::'){
                // resolve against the current rex file's directory (relative to windows/Rex)
                $value = self::thisRexValue($value);
            }elseif($prefix === '@root::'){
               // $value = substr($value, 7);
                $value = to_frontslash($value);
                $root = true;
            }elseif($prefix === '@windows'){
                $value = WIN.'/'.to_frontslash($value);
            }elseif($prefix === '@rex::'){
                $value = to_frontslash($value);
                //checkd($value);
            }
            
            $valuee = str_replace(['.','\\'],'/', $value);
            $explode = explode(":", $valuee);

            if(count($explode) > 1){

                $url = $urx = array_shift($explode);

                
                $urx = str_replace('/', '.', $urx);

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) !== 'css'){
                    $url .= self::extensions['css'];
                }

                if($root){
                    $path =  docroot.DS.ltrim($url, '/'); // use the direct file path supplied in relation to document root
                    $xpath = $url;
                } else {
                    // $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/'); // use default windows Rex path
                    // @this:: already carries the current rex directory (relative to windows/Rex),
                    // so it still needs the WIN_REX base to resolve to a real file path.
                    $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/'); // use default windows Rex path
                    $xpath = WIN_REX.$url;
                }

                if(!is_file($path)){

                    //get missing style files
                    $missingStyles = self::$missingFiles['css'];

                    if(!in_array($path, $missingStyles)) {

                        self::$missingFiles['css'][] = $path;
                        
                        print self::directivesMapError([
                            'title'=> 'Style missing :',
                            'message' => ' ',
                            'path' => str_replace('/', ' . ', $xpath).''
                        ], $body);

                    }
                    // replace matched value with null
                    $body = str_replace($matchValue, '', $body);

                }else{


                    if(!($templateContent = (self::$cssLayouts[$path]?? ''))){
                        ob_start();
                        include($path);
                        $templateContent = self::$cssLayouts[$path] = ob_get_clean();
                    }
                    $replacement = '';

                    foreach($explode as $id){

                        //build a style pattern from style id
                        $id = preg_quote($id);
                        $layoutPattern1 = "~/\* style\.* ?{$id}: \*/(.*?)/\* style\.* ?{$id}; \*/~is";//replacement 
                        $layoutPattern2 = "~#style:{$id}\s(.*?)#style;~is";//replacement 

                        //find expected style pattern from the template content
                        if(preg_match($layoutPattern1, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern1, "$1", $contentMatched);                          //$replacement .= str_ireplace(["#style:$id", "#style;"], '', $contentMatched);$replacement 
                        }elseif(preg_match($layoutPattern2, $templateContent, $contentsMatched)){
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern2, "$1", $contentMatched);
                        }else{          
                            print self::directivesMapError([
                                'title'=> 'Style name "'.$id.'" missing :',
                                'message' => ' ',
                                'path' => str_replace('/', ' . ',$url).''
                            ], $body);
                        }
                    }   
                    

                    if(trim($replacement)){
                        $replacement = '<style rel="'.$urx.'"> '.$replacement.' </style>'."\n";
                    }
                    
                    if(SELF::$PULLSTYLES){
                        // store styles 
                        $styles = (SETTER::EXISTS(':STYLES'))? GET(':STYLES', '#1234') : ''; 
                        $styles .= $replacement;
                        SET(':STYLES', $styles, '#1234'); // append new styles
                        $input = preg_quote($input);
                        // remove @style directives...
                        $data = preg_replace("~@style\(\s?'{$input}'\s?\)~i", '', $body);
                    }else{
                        $input = preg_quote($input);
                        $data = preg_replace_callback("~@style\(\s?'{$input}'\s?\)~i", function($matches) use($replacement){
                            return $replacement;
                        }, $body);
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

        /** @var array $matches */
        foreach($matches as $matchValue){

            $rawValue = preg_replace("~@script\('(.*?)'\)~i",'$1',$matchValue); //strip off the rule pattern
            $matchedValue = preg_replace('/\s+/','', $rawValue);
            $event = ''; $value = $matchedValue; $module = ''; $root = false;

            if(($arg = strrpos($matchedValue, "','")) !== false){
                $value = substr($matchedValue, 0, $arg);
                $event = substr($matchedValue, $arg+3);
            }

            if(in_array(substr($value, 0, 7), ['module\\','module/'])){
                $value = substr($value, 7); 
                $module = 'type="module" ';
            }

            $prefix = substr($value, 0, 7);
 
            if($prefix === '@this::'){
                $value = self::thisRexValue(substr($value, 7));
            }elseif($prefix === '@root::'){
                $value = substr($value, 7);
                $value = to_frontslash($value);
                $root = true;
            }

            $valuee = str_replace(['.','\\'],'/', $value);
            
            $explode = explode(":", $valuee);

            if(count($explode) > 1){

                $url = $explode[0];

                $url = $urx = array_shift($explode);
                $urx = str_replace('/', '.', $urx);

                //get url extension
                if(pathinfo($url, PATHINFO_EXTENSION) !== 'js'){
                    $url .= self::extensions['js'];
                }
                
                if($root){
                    $path =  docroot.DS.ltrim($url, '/'); // use the direct file path supplied in relation to document root
                    $xpath = $url;
                } else {
                    // @this:: already carries the current rex directory (relative to windows/Rex),
                    // so it still needs the WIN_REX base to resolve to a real file path.
                    $path =  docroot.DS.to_frontslash(WIN_REX).ltrim($url, '/'); // use default windows Rex path
                    $xpath = WIN_REX.$url;
                }

                if(!is_file($path)){


                    //get missing script files
                    $missingStyles = self::$missingFiles['js'];

                    if(!in_array($path, $missingStyles)) {

                        self::$missingFiles['js'][] = $path;
                        
                        print self::directivesMapError([
                            'title'=> 'Script missing :',
                            'message' => ' ',
                            'path' => str_replace('/', ' . ', $xpath).''
                        ], $body);

                    }
                    // remove script directive from body component
                    $body = str_replace($matchedValue, '', $body);

                }else{

                    if(!($templateContent = (self::$jsLayouts[$path]?? ''))){
                        ob_start();
                        include($path);
                        $templateContent = self::$jsLayouts[$path] = ob_get_clean();
                    }
                    $replacement = '';

                    // resolve multiple colon ids declarations
                    foreach($explode as $id){
                
                        //build a script pattern from script id
                        $id = preg_quote($id);
                        $layoutPattern1 = "~/\* script\.* ?{$id}: \*/(.*?)/\* script\.* ?{$id}; \*/~is";//replacement
                        $layoutPattern2 = "~// ?script\.* ?{$id}:(.*?)// ?script\.* ?{$id};~is";//replacement
                        $layoutPattern3 = "~#script:{$id}\s(.*?)#script;~is";//replacement  
                        
                        //find expected script pattern from the template content
                        if(preg_match($layoutPattern1, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern1, "$1", $contentMatched);
                        }elseif(preg_match($layoutPattern2, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern2, "$1", $contentMatched);
                        }elseif(preg_match($layoutPattern3, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern3, "$1", $contentMatched);
                        }

                    }
                    
                    if(trim($replacement)){
                        if($event){
                            $replacement = <<<SCRIPT
                            <script {$module}rel="$urx"> 
                            window.addEventListener('$event', function() {
                                $replacement 
                            })
                            </script>
                            SCRIPT;
                        }else{     
                            $replacement = <<<SCRIPT
                            <script {$module}rel="$urx"> 
                            $replacement
                            </script>
                            SCRIPT;
                        }
                    }
                    
                    // replace matched directive with rendered component
                    $rawValue = preg_quote($rawValue);
                    $data = preg_replace_callback(
                        "~@script\(\s?'{$rawValue}'\s?\)~i",
                        function($matches) use ($replacement) {
                            return Slicer::slice($replacement)->data();
                        },
                        $body
                    );
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

        /** @var array $matches */
        foreach($matches as $matchValue){

            $rawValue = preg_replace("~@onscript\('(.*?)'\)~i",'$1',$matchValue); //strip off the rule pattern
            $matchedValue = preg_replace('/\s+/','', $rawValue);
            $event = 'load'; $value = $matchedValue; $module = '';

            if(($arg = strrpos($matchedValue, "','")) !== false){
                $value = substr($matchedValue, 0, $arg);
                $event = substr($matchedValue, $arg+3);
            }

            if(in_array(substr($value, 0, 7), ['module\\','module/'])){
                $value = substr($value, 7); 
                $module = 'type="module" ';
            }
 
            if(substr($value, 0, 7) === '@this::'){
                $value = self::thisRexValue(substr($value, 7));
            }
            $valuee = str_replace(['.','\\'],'/', $value);
            
            $explode = explode(":", $valuee);


            if(count($explode) > 1){

                $url = $explode[0];

                $url = $urx = array_shift($explode);
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
                    // remove script directive from body component
                    $body = str_replace($matchedValue, '', $body);

                }else{

                    ob_start();
                    include($path);
                    $templateContent = ob_get_clean();

                    $replacement = '';

                    // resolve multiple colon ids declarations
                    foreach($explode as $id){
                
                        //build a script pattern from script id
                        $id = preg_quote($id);
                        $layoutPattern1 = "~/\* script\.* ?{$id}: \*/(.*?)/\* script\.* ?{$id}; \*/~is";//replacement
                        $layoutPattern2 = "~// ?script\.* ?{$id}:(.*?)// ?script\.* ?{$id};~is";//replacement
                        $layoutPattern3 = "~#script:{$id}\s(.*?)#script;~is";//replacement  
                        
                        //find expected script pattern from the template content
                        if(preg_match($layoutPattern1, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern1, "$1", $contentMatched);
                        }elseif(preg_match($layoutPattern2, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern2, "$1", $contentMatched);
                        }elseif(preg_match($layoutPattern3, $templateContent, $contentsMatched)) {
                          $contentMatched = $contentsMatched[0]?? '';
                          $replacement .= preg_replace($layoutPattern3, "$1", $contentMatched);
                        }
                        

                    }

                    
                    if(trim($replacement)){
                        $replacement = <<<SCRIPT
                        <script {$module}rel="$urx"> 
                        window.addEventListener('$event', function() {
                            $replacement 
                        })
                        </script>
                        SCRIPT;
                    }
                    
                    // replace matched directive with rendered component
                    $rawValue = preg_quote($rawValue);
                    $data = preg_replace_callback(
                        "~@onscript\(\s?'{$rawValue}'\s?\)~i",
                        function($matches) use ($replacement) {
                            return Slicer::slice($replacement)->data();
                        },
                        $body
                    );
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
            $tempLoc = $urx[0]??''; // template location
            $prefix = (str_ends_with($tempLoc, '///'))? '' : WIN_REX;
            $tempLoc = rtrim($tempLoc, '/');
            $rex = to_frontslash($prefix).ltrim($tempLoc, '/');
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
                    $template = str_ireplace(['@import(\'::watch\')', '@res::import(\'::watch\')'], '', $template);
                    $template = preg_replace('~@live(?:\([^()]*\))?~','',$template);
                }                
                
                $template = Slicer::slice($template)->data();

                $body = self::directivesTitle(str_replace($match, $template, $body));
            }    

        }

        return $body;

    }



    protected static function directivesSection(string $body): string {

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
        // Development-only diagnostics: missing layout/asset notices are a
        // build-time signal for the developer, never something a visitor should
        // see. On a live (online) site we suppress them silently — the caller
        // still strips the broken directive, so the page renders without it.
        if(defined('online') && online){
          return '';
        }
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

    protected static function directivesPhp(string $body) : string {

      self::getMatches('php', $body, $matches);

        /** @var array $matches */
      foreach($matches as $php){

        $newphp = str_ireplace(['@php:','@php;'], ['<?php', '?>'], $php);

        $body = str_ireplace($php, $newphp, $body);

      }

      return $body;

    }

    protected static function directivesUse(string $body) : string {

      $body = preg_replace('~@use\(\'(.*?)\'\)~is','<?php use $1; ?>',$body);
      $body = preg_replace('~@use\((.*?)\)~is','<?php use $1; ?>',$body);

      return $body;

    }

    protected static function directivesUses(string $body) : string {
        $body = preg_replace_callback('~@uses\(\'(.*?)\'\)~is', function($matches){
            return '<?php use '.scheme($matches[1]).'; ?>';
        }, $body);
        $body = preg_replace_callback('~@uses\((.*?)\)~is', function($matches){
            return '<?php use '.scheme($matches[1]).'; ?>';
        }, $body);

      return $body;

    }

    /**
     * Returns the matches from a pattern
     *
     * @param string $pattern
     * @param string $body text body
     * @param array &$matches [optional] stores data found
     * @return string $all references all matches
     */
    private static function getMatches(string $pattern, $body, &$matches = [], &$all = []){

      //load flashes
      $pattern = self::$pattern[$pattern]; //include a flash if it exists
    
      preg_match_all($pattern, $body, $matches);

      $all = $matches;

      $matches = $matches[0] ?? [];

      return $pattern;

    }

}

?>