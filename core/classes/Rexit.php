<?php

use spoova\mi\core\classes\Bond;
use spoova\mi\core\classes\Csrf;
use spoova\mi\core\classes\Directives;
use spoova\mi\core\classes\Request;
use spoova\mi\core\classes\Slicer;

class Rexit {

    static function head($title) {

        return "<title>". $title . "</title>";

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
            return appenv('meta')->$option();
        }else{
            return '';
        }

    }

    static function import() {

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
     * Directs the slicer to render all view syntaxes using view function
     * Syntax will be replaced with either empty string or the appropraite resolved value
     *    - syntax @view('url')
     *
     * @param string $body
     * @return string $body
     */
    static function view($url) {
        return view(...func_get_args());
    }

    static function flash($args) {

        return Res::flash(...$args);

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
     * Alias for directive - recall
     *
     * @return string
     */
    static function load() {
        return self::recall(...func_get_args());
    }

    static function src($url) {
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
     * Add static files from the apps' res/main directory
     *
     * @param string $body
     * @return string
     */
    static function mapp($url) {
        $url = 'main/'.ltrim($url, '/');
        $replacement = ress($url);
        return $replacement;
    }

    /**
     * Add static files from the apps' res/assets directory
     *
     * @param string $body
     * @return string
     */
    static function mass($url) {
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
    static function assets($url) {
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

    static function live() {

        return Res::live(...func_get_args());

    }

    static function domurl($url = '') {
        return domurl($url);
    }

    static function domlink($url) {
        return domlink($url);
    }

    static function formurl($url) {
        return FormUrl($url);
    }

    static function images($url) {
        return DomUrl('res/assets/images/'.$url);
    }

    static function onShow($args = '') {
        return onShow(...func_get_args());
    }

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

        $token = Csrf::token();
        '<input type="hidden" value="'.$token.'" name="CSRF_TOKEN">';

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

    static function vdump() {
        return vdump(...func_get_args());
    }

    static function attr() {

    }

    static function bond() {
        $args = func_get_args();
        return (new Bond)->resolve(...$args);
    }

}