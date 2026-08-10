<?php

if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    $file = __DIR__ . urldecode($path);
    if ($path !== '/' && is_file($file) && !preg_match('/\.php$/i', $file)) {
        return false; // let the built-in server serve the asset as-is
    }
}

include 'icore/filebase.php';

Server::run('');
