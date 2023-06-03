<?php

//sets meta strings

$_ENV['meta'] = new spoova\mi\core\classes\Meta;
$_ENV['meta']->charset();
$_ENV['meta']->equiv('X-UA-Compatible', 'IE=edge');
$_ENV['meta']->name('viewport',    'width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1');
$_ENV['meta']->name('description', 'spoova framework');
$_ENV['meta']->link('icon',  DomUrl('res/main/images/icons/favicon.png'), 'type:image/png; sizes:16x16');
// $_ENV['meta']->prop('og:title',    'website_name');
// $_ENV['meta']->prop('og:image',    '//website_icon_url');
// $_ENV['meta']->prop('og:type',     'website');
