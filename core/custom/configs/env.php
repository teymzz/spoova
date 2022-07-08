<?php

//* Environment Constants
$_ENV['constants'] = [

    # app directories
    'approot'=> approot,
    'docroot'=> docroot,
    'server' => server,
  
    # app root extension
    'file-ext' => fext,  
  
    # environment
    'online' => online,
    'uri'    => uri,
    
    # databases (dev)
    'encrypt'   => 'md5',
    'auto-date' => true,
  
    # assets directories
    'site-url' => siteUrl,
    'fol-name' => appcon('fol-name'),
    'path-dir' => appcon('path-dir'),
  
    # asset directories - editable
    'base-url' => appcon('base-url'),
    'base-uri' => appcon('base-uri'),
    'pathlink' => appcon('pathlink'),

    # app schemes root
    'scheme' => scheme
    
  ];