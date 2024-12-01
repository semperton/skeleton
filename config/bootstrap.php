<?php

declare(strict_types=1);

use Semperton\Container\Container;

// set some php defaults
ini_set('precision', '-1');
date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

/** @var array<string, mixed> */
$definitions = require __DIR__ . '/definitions.php';
$container = new Container($definitions);

return $container;
