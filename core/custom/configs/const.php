<?php

/* App Basic Constants */

//define system root

if( !defined('sys') ) define('sys', $_SERVER['SystemRoot'] ?? $_SERVER['SYSTEMROOT'] ?? '' );

// Define console handler
if( !defined('consoler') ) define('consoler', 'mi' );
if( !defined('SIGWRITE') ) define('SIGWRITE', 1000);

// Set core & icore (root) folders 
if( !defined('_root') ) {
    /** Refers to the full document root */
    define('_root', docroot.DS);
}

if( !defined('_core') ) {
    /** Refers to the core subdirectory in the root directory */
    define('_core', docroot.DS.'core'.DS);
}

if( !defined('_icore') ) {
    /** Refers to the icore subdirectory in the root directory */
    define('_icore', docroot.DS.'icore'.DS);
}

// Set app folder
if( !defined('fol') ) define('fol', '');

// App namespace
if( !defined('scheme') )
    /** Refers to the app root namespace */
    define('scheme', '\spoova\mi\\');

//app Routes Directory
if( !defined('WIN') ){
    /** Window subnamespace name*/
    define('WIN', 'windows\\');
}

//template file path
if( !defined('WIN_REX') ){
    /** Rex directory subnamespace path relative to windows directory */
    define('WIN_REX', 'windows\Rex\\');
}

//app Routes Directory
if( !defined('WIN_ROUTES') ){
    /** Route directory subnamespace path relative to windows directory */
    define('WIN_ROUTES', 'windows\Routes\\');
}

//app Model Directory
if( !defined('WIN_MODELS') ){
    /** Models directory subnamespace path relative to windows directory */
    define('WIN_MODELS', 'windows\Models\\');
}

//app Frame Directory
if( !defined('WIN_FRAMES') ){
    /** Frames directory subnamespace path relative to windows directory */
    define('WIN_FRAMES', 'windows\Frames\\');
}

//default error file
if( !defined('E_404') ){
    /** Default Path for 404 error file */
    define('E_404', _core.'custom'.DS.'errors'.DS.'e-404');
}


//default csrf error file
if( !defined('E_CSRF') ){
    /** Default Path for CSRF error file */
    define('E_CSRF', _core.'custom'.DS.'errors'.DS.'e-csrf');
}
    
//app environment settings
if( !defined('siteUrl') ){
    /**
     * Specifies a site url. 
     *  - Note : To remove this later!!!
     *  @deprecated 2.6
     */
    ((online)? define('siteUrl',''): define('siteUrl',''));
}

if( !defined('docdir') ){
    /**
     * App root's relative path based on environment (i.e online or offline). 
     *  - offline: This uses the project folder name.
     *  - online: This is defined as empty usually resolved by the hostname.
     **/
    ((online)? define('docdir','') : define('docdir', DS.docBase.DS));
}

if( !defined('pathlink') ){
    /**
     * This specifies the true host name defined only in an online environment and empty for local environments
     **/
    ((online)? define('pathlink',server.DS.docdir): define('pathlink', ''));
}

if( !defined('baseUrl') ){
    /**
     * This specifies a base url html tag.
     * @deprecated 2.6
     **/
    ((online)? define('baseUrl','<base href="'.siteUrl.'">'): define('baseUrl', ''));
}

if( !defined('baseUri') ){
    /**
     * This specifies a base uri html tag using the document base name.
     **/
    ((online)? define('baseUri','<base href="/'.docBase.'">'): define('baseUri', '<base href="/'.docBase.'">'));
}

if( !defined('ajaxUrl') ){
    /**
     * Applied as prefix path on ajax URLs.
     * @deprecated 2.6
     */
    ((online)? define('ajaxUrl', ''): define('ajaxUrl', fol));
}

if( !defined('htdirect') )
    ((online)? define('htdirect', false): define('htdirect', false));