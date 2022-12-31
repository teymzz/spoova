<?php

//sets meta strings

$_ENV['meta'] = new spoova\core\classes\Meta;
$_ENV['meta']->name('viewport',    'width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1');
$_ENV['meta']->name('description', 'website_description');
$_ENV['meta']->link('icon',  domUrl('res/main/images/icons/favicon.png'),'image/png'); // add attr sizes="16×16" later
// $_ENV['meta']->prop('og:title',    'website_name');
// $_ENV['meta']->prop('og:image',    '//website_icon_url');
// $_ENV['meta']->prop('og:type',     'website');
