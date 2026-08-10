<?php

use spoova\mi\core\classes\Bond;
use spoova\mi\core\classes\Controller;
use spoova\mi\core\classes\CSRF;
use spoova\mi\core\classes\DomUrl;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\Request;

class Rexit {

    private static $namedURI = [];

    /**
     * Resolve
     *
     * @param string $namespace
     * @param boolean $prefix
     * @return void
     */
    static function scheme(string $namespace = '', bool $prefix = false) {

        return scheme($namespace, $prefix);

    }
    
    static function head(string $title) {

        return "<title>". $title . "</title>";

    }

   /**
     * Resolves redirection to a new page using {@see \redirectTo()} 
     *  - $url is resolved with {@see \domUrl()} helper function
     *
     * @param string $url redirection
     * @return void
     */
    static function redirect(string $url) {
        return redirectTo(domUrl($url));
    }

   /**
     * Automatically redirects an authenticated user to a specified url using {@see \authDirect()} helper function.
     * 
     * @param string $url url to be redirected to
     * @return void
     */
    static function authDirect(string $url) {
        return authDirect($url);
    }

    /**
     * Automatically redirects an unauthenticated user to a specified url using {@see \authDirect()} helper function.
     *
     * @param string $url
     * @return void
     */
    static function guestDirect(string $url) {
        return guestDirect($url);
    }

    /**
     * Resolves the meta tags using the global Meta class configurations
     *
     * @param string $option
     * @return string
     */
    static function meta($option = '') : string {

        if($option){
            $appenv = (appenv('meta'));
            if($appenv) return $appenv->$option();
        }

        return '';

    }

    /**
     * Returns the last url retrieved from the last called domurl
     * 
     * @param string $name name assigned to a previously stored route.
     * @param string $subpath path to be appended to the route corresponding to an existing stored name
     * @param string $new_name assigns a new storage name for the route resolved by this method
     * @return string
     */
    static function lasturi(?string $name = null, string $subpath = '', $new_name = '') : string {
        $path =  GET(DomUrl::Name(), DomUrl::Hash());
        $path = rtrim(ltrim(to_frontslash($path), '/'), '/');
        $args = func_num_args();
        if($args === 0) {
            return domurl($path, false);
        }else{
            if($name!==null){
                $silent = str_starts_with($name,'::')? $name = substr($name, 2) : false;

                $namedURI = self::$namedURI[$name] ?? '';

                $newURI = $namedURI.(trim($subpath,' ')? '/'.$subpath : '');
                if($args < 3){
                    $uri = domurl($newURI);
                    if(!$silent) return $uri;
                }elseif($args > 2){
                    self::namedURI($newURI, $new_name);
                    $uri = domurl($newURI);
                    if(!$silent) return $uri;
                }
            }
        }
        return '';
    }

    /**
     * Returns the last url retrieved from the last called domurl
     * 
     * @param string $xpath a specified route to be registered and/or returned 
     * @return string $name name to be registered for specified route
     * @return int $access determines if the route registered is returned
     *  - int(1) : register route only 
     *  - int(2) : register and return registered route 
     * @return string Return registered route or empty string
     */
    static function namedURI(string $xpath, string $name, int $access = 0) : string {
        if(!trim($name)) throw new ErrorException('named URI must have a valid name');
        if(isset(self::$namedURI[$name])) throw new ErrorException('named URI must be a unique name');
        self::$namedURI[$name] = $xpath;
        if($access === 1){
             domurl(self::$namedURI[$name]);
        }elseif($access === 2){
         return domurl(self::$namedURI[$name]);
        }
        return '';
    }

    /**
     * Checks if the current url matches the entire request url
     *
     * @param string $args
     * @return string
     */
    static function isPath($args = '') {
        return isPath(...func_get_args());
    }

    /**
     * Checks if the current url matches a particular window base
     *
     * @param string $args
     * @return string
     */
    static function inPath($args = '') {
        return inPath(...func_get_args());
    }

    /**
     * Loads and renders all include tags from the template string supplied
     *
     *
     * @param string $body
     * @return string rendered $body
     */
    static function include($path) {
        include(docroot.DS.$path);
    }

    /**
     * Alias of {@see self::rex()} Directs the slicer to render all view syntaxes using rex compiler function
     * Syntax will be replaced with either empty string or the appropriate resolved value
     *    - This directive is an alias to the Rexit::rex() directive and it should not be confused 
     *      with the view() function.
     *    - syntax @view('foo.path')
     *
     * @param string $path to template component starting from 'Windows/Rex' folder
     * @return string markup of a rendered component
     */
    static function view($path) : string {
        return rex(...func_get_args());
    }

    /**
     * Directs the slicer to render all view syntaxes using rex compiler function
     * Syntax will be replaced with either empty string or the appropriate resolved value
     *    - syntax @rex('foo.path')
     *
     * @param string $path path to template component starting from 'Windows/Rex' folder
     * @return string $body
     */
    static function rex($path) {
        return rex(...func_get_args());
    }

    /**
     * Resolves @flash template directives 
     * @param string $key key of flash message
     * @param mixed $message
     */
    static function flash(string $key = '', $message = '') {

        return \Res::flash(...func_get_args());

    }

    /**
     * Resolves static resource file urls
     *
     * @param string $url local relative url
     * @return void
     */
    static function res(string $url) {

        if(str_starts_with($url, ':')){

            if($url === '::watch'){
                $values = \Res::import('::watch');
                return $values;
            }else {
                $values = ":lists";

                $values = \Res::export($url);
                $values = array_map(fn($value) => $value."\n", $values);
                $values = implode("\n",$values);
            }
        }else {
            
            $values = \Res::callFile($url, false); //get values of index
                
            if(is_array($values)){
                $values = array_map(function($value){
                    return $value."\n";
                }, $values);
            }

        }
        
        return $values;

    }

    /**
     * Imports resource files from the resource storage space.
     *
     * @param mixed $url
     * @return string
     */
    static function recall($url) : string {
        return recall(...func_get_args());
    }

    /**
     * Import static resources
     *
     * @param string|array $url
     * @return string
     */
    static function import(string|array $url = '') {
        return import(...func_get_args());
    }

    /**
     * Alias for directive - recall
     *
     * @return string
     */
    static function load() {
        return self::recall(...func_get_args());
    }

    /**
     * Alternative directive for recall in relation to ss modules.
     *
     * @return string
     */
    static function ss() {
        $args = func_get_args();
        $args = array_map(fn($value) => ($value && $value[0] !== ':')? 'ss.'.$value : substr($value, 1), $args);
        return self::recall(...$args);
    }

    /**
     * Returns paths of resources starting from res directory
     *
     * @param string $url path of static file   
     * @return string
     */
    static function src(string $url = '') {
        return ress($url);
    }

    /**
     * alias for directive - src
     *
     * @return string
     */
    static function ress(string $url = '') {
        return self::src($url);
    }

    /**
     * Returns path to files starting from the res/main directory
     *
     * @param string $url path of static file within res/main directory
     * @return string
     */
    static function mapp(string $url = '') {
        $url = 'main/'.ltrim($url, '/');
        $replacement = ress($url);
        return $replacement;
    }

    /**
     * Returns path to files starting from the res/assets directory
     * 
     * @param string $url path of static file within res/assets directory
     * @return string
     */
    static function mass(string $url = '') {
        $url = 'assets/'.ltrim($url, '/');
        $replacement = ress($url);
        return $replacement;
    }

    /**
     * This method will be removed later.. Use @mass instead
     * - Add static files from the apps res/assets folder
     * - Imports static files 
     *
     * @param string $url
     * @return string
     */
    static function assets(string $url = '') {
        if(substr($url, 0, 1) == ":"){

            if($url == '::watch'){

                 $values = \Res::import($url);

            } else {
                $values = ":lists";

                $values = \Res::import('', $url, $values);
            }
           
            
        }  else {
            $url = 'res/assets/'.$url;
            $values = \Res::callFile($url, false); //get values of index  
        } 

        return $url;
    }

    /**
     * Adds live script to template file
     *
     * @return string
     */
    static function live() {

        return \Res::live(...func_get_args());

    }

    /**
     * Returns localized url protocol for url supplied stating from project root
     *
     * @param string $url path of file to be converted to http protocol
     * @return string
     */
    static function domurl($url = '') {
        return domurl($url);
    }

    /**
     * Converts slashes in urls to icon format
     * @param string $url path whose slashes are to be replaced
     * @param string $ico class name 
     *  - Uses the "i" html element to anchor the class defined
     * @return string
     */
    static function navico($url, $ico = '') : string {
        if(func_num_args() === 1 && (count($exp = explode(':', $url)) === 2)){
            $url = $exp[0];
            $ico = $exp[1];
        }
        $url = str_replace('\\', "/", $url);
        $nav = str_replace('/', ' <i class="'.$ico.'"></i> ', $url);
        return $nav;
    }

    /**
     * Returns html Anchor link tag
     *
     * @param string $url anchor link
     * @param string $attrs defines attributes of link (e.g 'class:foo;rel:stylesheet')
     * @param bool $track TRUE updated active URL pointer to the $url defined.
     * @return string
     */
    static function href(string $url = '', string $attrs = '', bool $track = true) {
        return href($url, $attrs, $track);
    }

    /**
     * Returns localized url protocol for url supplied stating from project root. 
     * All character dots are always converted to slashes. This should be used for 
     * only links that do not have a dot character within them
     *   - automatically updates active URL pointer to the $url defined.
     * @param string $url path of file to be converted to http protocol
     * @return string
     */
    static function domlink(string $url = '') {
        return domlink($url);
    }

    /**
     * Adds a form url to form action
     *
     * @param string $url
     * @return string
     */
    static function formurl(string $url = '') : string {
        return FormUrl($url);
    }

    /**
     * Returns localized url protocol for url supplied whose parent directory is 
     * res/assets/images directory.
     *
     * @param string $url path of file to be converted to http protocol
     * @param bool $track TRUE updates active URL pointer to the $url defined.
     * @return string
     */
    static function images(string $url = '', bool $track = false) {
        return DomUrl('res/assets/images/'.$url, $track);
    }

    /**
     * Returns the word "hidden" when the function $name supplied returns a non-empty value
     * @param string $name function name to be called.
     * @param string[] $args list of arguments for specified function
     * @return string
     */
    static function onShow(string $name, ?string $args = null) : string {
        return onShow(...func_get_args());
    }

    /**
     * Returns the word "hidden" when the function $name supplied returns an empty value
     * @param string $name function name to be called.
     * @param string[] $args list of arguments for specified function
     * @return string
     */
    static function onHide(string $name, ?string $args = null) : string {
        return onHide(...func_get_args());
    }

    /**
     * Resolves a route using name defined in the Route class. 
     * See {@see Controller::nameRoutes()}
     *
     * @param string $routeName
     * @return string rendered $body
     */
    static function route($routeName) {
        return route($routeName);
    }

    /**
     * Returns the default request data processor file
     *
     * @return string rendered $body
     */
    static function formdata() {
        return  DomUrl(\FormData::action);
    }

    /**
     * Sets a csrf token on forms
     *
     * @param string $type
     * @return string rendered $body
     */
    static function csrf($type = '', string $url = '') : string {
        if(gettype($type) === 'string') $type = strtolower($type);
        $arg = ($type === 'old') ? false : true;
        if(strtolower(Init::key('CSRF_GEN')) === 'false'){
            return '';
        }
        return CSRF::field($arg).($url? "\n<input hidden=\"\" name=\":form-action\" value=\"$url\">" : '');
    }

    /**
     * Sets a csrf token on forms
     *
     * @param string $id identifier key for accessing a saved section in a template component
     * @param string $repeat number of copies to be generated
     * @param string $subid 
     * @return string rendered component
     */
    static function saved($id, $repeat = 1, string $subid = '', bool $eager = true) {
        $saved = GET('x-save', 'x-save-list');

        if(!isset($saved[$id])) throw new ErrorException("missing content for id '$id' argument(#1) supplied on @(@saved)@ directive");

        $saved = $saved[$id];
        if($subid){
            if(!isset($saved[$subid])) throw new ErrorException("missing content for subid '$id' argument(#3) supplied on @(@saved)@ directive");
            $saved = $saved[$subid];
        }

        if(is_array($saved)) {
            $saves = array_filter($saved, fn($key) => is_numeric($key), ARRAY_FILTER_USE_KEY);
            if($eager){
                foreach($saves as $saved){
                    echo str_repeat($saved, $repeat);
                }
            } else {
                echo str_repeat(implode('',$saves), $repeat);
            }
        }else{
            echo str_repeat($saved, $repeat);
        }
    }

    static function action($url = '') {
        return self::csrf()."\n<input hidden=\"\" name=\":form-action\" value=\"$url\">";
    }

    /**
     * Sets the form attributes of name and value for a specific form input
     *  - Can be applied on input and btn elements.
     * @param string $name
     * @return string rendered $body
     */
    static function btn($name = '') {
        return 'name="'.$name.'" value="'.$name.'"';
    }

    
    /**
     * Retrieves the value of a last post or get data request
     *
     * @param array $values
     * @return string rendered $body
     */
    static function old(array $values = []) {
        
        $Request = new Request();
        $method  = strtolower($Request->method());

        if($method === 'post'){
            $method = $_POST;
        }elseif($method === 'get'){
            $method = $_GET;
        }else{
            return '';
        }

        foreach($values as $child){
            if(isset($method[$child])){
                $method = $method[$child];
            }else{
                $method = '';
            }
        }

        return $values? $method : '';

    }

    /**
     * Retrieves the value of a last post data request
     *
     * @param array $values
     * @return string rendered $body
     */
    static function post(array $values = []) {
      
        $method = $_POST;

        foreach($values as $child){
            if(isset($method[$child])){
                $method = $method[$child];
            }else{
                $method = '';
            }
        }

        return $values? $method : '';
    }

    /**
     * Retrieves the value of a last get data request
     *
     * @param array $values
     * @return string rendered $body
     */
    static function get(array $values = []) {
        
        $method  = $_GET;

        foreach($values as $child){
            if(isset($method[$child])){
                $method = $method[$child];
            }else{
                $method = '';
            }
        }

        return $values? $method : '';
    }

    /**
     * Converts all error index directives to executable function
     *
     * @return string
     */
    static function error($args = '') {
        return error(...func_get_args());
    }

    /**
     * Returns saved form validation error. 
     *  - See docs at {@see \formerror()}
     * @return string
     */
    static function formerror(string $castedName, string $errorKey) : string {
        return formerror($castedName, $errorKey);
    }

    /**
     * Dumps useful information about the argument(s) supplied.
     */
    static function vdump() {
        return vdump(...func_get_args());
    }

    /**
     * Resolve bond directive
     *
     * @return string
     */
    static function bond() : string {
        $args = func_get_args();
        return (new Bond)->resolve(...$args);
    }

}