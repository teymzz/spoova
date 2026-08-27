<?php

//init files

use spoova\mi\core\functions\Functions;

require_once __DIR__.'/path.php';

/**
 * Public files are handed back to the web server before the framework loads.
 *
 * A page asks for many files and PHP's built-in server answers them one at a time, so
 * booting the application to decide would slow every one of them down. The decision is
 * carried back to the router file (i.e "index.php") by server(), whose return value is what
 * the built-in server reads: FALSE tells it to serve the file itself.
 * {@see staticRequest()}
 */
if(staticRequest()){
    function server(string $logic = ''){ return false; }
    return;
}

require_once 'config.php';
require_once filebase(__DIR__);
require_once domroot('res/res.php');
require_once 'filemeta.php';

Server::loadBase(uri);
Functions::autoload();