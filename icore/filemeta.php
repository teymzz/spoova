<?php

//sets meta strings

$_ENV['meta'] = new spoova\mi\core\classes\Meta;
$_ENV['meta']->charset(); //Character-Encoding
$_ENV['meta']->equiv('X-UA-Compatible', 'IE=edge');
$_ENV['meta']->name('viewport',    'width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=0');
$_ENV['meta']->name('description', 'A light php development framework.');
$_ENV['meta']->link('icon',  DomUrl('res/main/images/icons/favicon.png'), 'type:image/png; sizes:16x16');
$_ENV['meta']->prop('og:title',    'Spoova php framework for web development.');
$_ENV['meta']->prop('og:image',    '//res/main/images/icons/favicon.png');
$_ENV['meta']->prop('og:type',     'website');
