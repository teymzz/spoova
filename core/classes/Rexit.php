<?php

use spoova\mi\core\classes\Bond;
use spoova\mi\core\classes\Csrf;
use spoova\mi\core\classes\Request;

class Rexit {

    static function scheme($namespace = '', $prefix = true) {

        return scheme($namespace, $prefix);

    }
    
    static function head($title) {

        return "<title>". $title . "</title>";

    }

   /**
     * Redirect to a new page
     *
     * @param string $body
     * @return string
     */
    static function redirect($url) {
        return redirectTo(DomUrl($url));
    }

   /**
     * Authenticated user redirection
     *
     * @param string $body
     * @return string
     */
    static function authDirect($url) {
        return authDirect($url);
    }

    /**
     * Guest Redirection
     *
     * @param string $body
     * @return string
     */
    static function guestDirect($url) {
        return guestDirect($url);
    }

    static function meta($option = '') {

        if($option){
            $appenv = (appenv('meta'));
            if($appenv) return $appenv->$option();
        }else{
            return '';
        }

    }

    /**
     * Checks if the current url matches the entire request url
     *
     * @param string $body
     * @return string
     */
    static function isPath($args = '') {
        return isPath(...func_get_args());
    }

    /**
     * Checks if the current url matches a particular window base
     *
     * @param string $body
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
     * Directs the slicer to render all view syntaxes using rex compiler function
     * Syntax will be replaced with either empty string or the appropriate resolved value
     *    - This directive is an alias to the Rexit::rex() directive and it should not be confused 
     *      with the view() function.
     *    - syntax @view('url')
     *
     * @param string $body
     * @return string $body
     */
    static function view($url) {
        return rex(...func_get_args());
    }

    /**
     * Directs the slicer to render all view syntaxes using rex compiler function
     * Syntax will be replaced with either empty string or the appropriate resolved value
     *    - syntax @view('url')
     *
     * @param string $body
     * @return string $body
     */
    static function rex($url) {
        return rex(...func_get_args());
    }

    /**
     * Applies 
     */
    static function flash($args) {

        return Res::flash(...func_get_args());

    }

    static function res($url) {

        if(substr($url, 0, 1) == ":"){

            if($url === '::watch'){
                $values = Res::import('::watch');
                return $values;
            }else {
                $values = ":lists";

                $values = Res::export('',$url);
                $values = array_map(fn($value) => $value."\n", $values);
                $values = implode("\n",$values);
            }
        }else {
            
            $values = Res::callFile($url, false); //get values of index
                
            if(is_array($values)){
                $values = array_map(function($value){
                    return $value."\n";
                }, $values);
            }

        }
        
        return $values;

    }

    static function recall($url) {
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
     * @param string $body
     * @return string
     */
    static function ress() {
        return self::src(...func_get_args());
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
     * @param string $body
     * @return string
     */
    static function assets(string $url = '') {
        if(substr($url, 0, 1) == ":"){

            if($url == '::watch'){

                 $values = Res::import($url);

            } else {
                $values = ":lists";

                $values = Res::import('', $url, $values);
            }
           
            
        }  else {
            $url = 'res/assets/'.$url;
            $values = Res::callFile($url, false); //get values of index  
        } 

        return $url;
    }

    /**
     * Adds live script to template file
     *
     * @return string
     */
    static function live() {

        return Res::live(...func_get_args());

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
     * Returns localized url protocol for url supplied stating from project root. 
     * All character dots are always converted to slashes. This should be used for 
     * only links that do not have a dot character within them
     *
     * @param string $url path of file to be converted to http protocol
     * @return string
     */
    static function domlink($url = '') {
        return domlink($url);
    }

    static function formurl(string $url = '') {
        return FormUrl($url);
    }

    /**
     * Returns localized url protocol for url supplied whose parent directory is 
     * res/assets/images directory.
     *
     * @param string $url path of file to be converted to http protocol
     * @return string
     */
    static function images(string $url = '') {
        return DomUrl('res/assets/images/'.$url);
    }

    /**
     * Returns the word "hidden" when the function $name supplied returns a non-empty value
     * @param string $func function name to be called.
     * @param string[] $args list of arguments for specified function
     * @return string
     */
    static function onShow(string $func, $args = null) {
        return onShow(...func_get_args());
    }

    /**
     * Returns the word "hidden" when the function $name supplied returns an empty value
     * @param string $func function name to be called.
     * @param string[] $args list of arguments for specified function
     * @return string
     */
    static function onHide($args = '') {
        return onHide(...func_get_args());
    }

    /**
     * Returns a named route
     *
     * @param string $body
     * @return string rendered $body
     */
    static function route($routeName) {
        return route($routeName);
    }

    /**
     * Returns the default request data processor file
     *
     * @param string $body
     * @return string rendered $body
     */
    static function formdata() {
        return  DomUrl(FormData::action);
    }

    /**
     * Sets a csrf token on forms
     *
     * @param string $body
     * @return string rendered $body
     */
    static function csrf() {
        static $count = 0;
        $count++;

        $token = ($count > 1)? Csrf::old() : Csrf::token();
        $token = Csrf::token();
        return '<input type="hidden" value="'.$token.'" name="CSRF_TOKEN">';

    }

    static function action($url = '') {
        return "<input hidden=\"\" name=\":form-action\" value=\"$url\">";
    }

    /**
     * Sets the form attributes of name and value for a specific form input
     *
     * @param string $body
     * @return string rendered $body
     */
    static function btn($name = '') {
        return 'name="'.$name.'" value="'.$name.'"';
    }

    
    /**
     * Retrieves the value of a last post or get data request
     *
     * @param string $body
     * @return string rendered $body
     */
    static function old($values = []) {
        
        $Request = new Request();
        $Method  = $Request->method();

        if($Method == '$_POST'){
            $method = $_POST;
        }else{
            $method = $_GET;
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
     * @param string $body
     * @return string rendered $body
     */
    static function post($values = []) {
      
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
     * @param string $body
     * @return string rendered $body
     */
    static function get($values = []) {
        
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
     * Returns saved form validation error
     *
     * @return string
     */
    static function formerror($args = '') {
        return formerror(...func_get_args());
    }

    /**
     * Dumps useful information about the argument supplied.
     */
    static function vdump() {
        return vdump(...func_get_args());
    }

    static function bond() {
        $args = func_get_args();
        return (new Bond)->resolve(...$args);
    }

}