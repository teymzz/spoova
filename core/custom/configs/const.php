<?php

/* App Basic Constants */

//define system root

if( !defined('sys') ) define('sys', $_SERVER['SystemRoot'] ?? $_SERVER['SYSTEMROOT'] ?? '' );

//define console handler
if( !defined('consoler') ) define('consoler', 'mi' );

//set core & icore (root) folders 
if( !defined('_core') ) define('_core', docroot.DS.'core'.DS);
if( !defined('_icore') ) define('_icore', docroot.DS.'icore'.DS);

//set app folder
if( !defined('fol') ) define('fol', '');

//app namespace
if( !defined('scheme') )
    define('scheme', '\spoova\mi\\');

//app Routes Directory
if( !defined('WIN') )
    define('WIN', 'windows\\');

//template file path
if( !defined('WIN_REX') )
    define('WIN_REX', 'windows\Rex\\');

//app Routes Directory
if( !defined('WIN_ROUTES') )
    define('WIN_ROUTES', 'windows\Routes\\');

//app Model Directory
if( !defined('WIN_MODELS') )
    define('WIN_MODELS', 'windows\Models\\');

//app Frame Directory
if( !defined('WIN_FRAMES') )
    define('WIN_FRAMES', 'windows\Frames\\');

//default error file
if( !defined('E_404') )
    define('E_404', _core.'custom'.DS.'errors'.DS.'e-404');

//default csrf error file
if( !defined('E_CSRF') )
    define('E_CSRF', _core.'custom'.DS.'errors'.DS.'e-csrf');
    
//app environment settings
if( !defined('siteUrl') )
    ((online)? define('siteUrl',''): define('siteUrl',''));

if( !defined('docdir') )
    ((online)? define('docdir','') : define('docdir', DS.docBase.DS));

if( !defined('pathlink') )
    ((online)? define('pathlink',server.DS.docdir): define('pathlink', ''));

if( !defined('baseUrl') )
    ((online)? define('baseUrl','<base href="'.siteUrl.'">'): define('baseUrl', ''));

if( !defined('baseUri') )
    ((online)? define('baseUri','<base href="/'.docBase.'">'): define('baseUri', '<base href="/'.docBase.'">'));

if( !defined('ajaxUrl') )
    ((online)? define('ajaxUrl', ''): define('ajaxUrl', fol));

if( !defined('htdirect') )
    ((online)? define('htdirect', false): define('htdirect', false));