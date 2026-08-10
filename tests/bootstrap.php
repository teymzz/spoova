<?php

/**
 * PHPUnit bootstrap for Spoova unit tests.
 *
 * This deliberately performs the *minimum* wiring needed to exercise the leaf
 * classes in isolation — it does NOT boot the full framework (no session,
 * database, request handling or output). If a future test needs more of the
 * framework, prefer adding narrowly-scoped setup here rather than including
 * the full application entry point.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

// Core path constants used across the classes under test.
if (!defined('docroot'))    define('docroot', dirname(__DIR__));      // project root
if (!defined('DS'))         define('DS', DIRECTORY_SEPARATOR);
if (!defined('docBase'))    define('docBase', basename(docroot));     // Activity's default name
if (!defined('WIN_ROUTES')) define('WIN_ROUTES', 'windows\\Routes\\');

// Global helper functions: isCli(), isTerminal(), to_frontslash().
require dirname(__DIR__) . '/core/custom/configs/funcs.php';

// br(), used by the CLI renderers.
require dirname(__DIR__) . '/core/custom/functions.php';

chdir(docroot);
