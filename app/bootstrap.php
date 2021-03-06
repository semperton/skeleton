<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Semperton\Container\Container;

define('START_TIME', microtime(true));

// set some php defaults

ini_set('precision', '-1');

date_default_timezone_set('UTC');

/** @var ClassLoader */
$classLoader = require_once __DIR__ . '/../vendor/autoload.php';

/** @var array */
$definitions = require __DIR__ . '/definitions.php';
$container = new Container($definitions);

return $container;
