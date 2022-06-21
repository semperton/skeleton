<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Semperton\Framework\Application;

// php dev server
if (php_sapi_name() === 'cli-server') {
	$filePath = __DIR__ . explode('?', $_SERVER['REQUEST_URI'], 2)[0];
	if (is_file($filePath)) {
		return false;
	}
}

// shutdown handler
// register_shutdown_function(static function () {

// 	if (null === $error = error_get_last()) {
// 		return;
// 	}
// });

/** @var ContainerInterface */
$container = require __DIR__ . '/../app/bootstrap.php';

/** @var Application */
$application = $container->get(Application::class);

// FIXME: use request creator class
/** @var ServerRequestInterface */
$request = ($container->get('ServerRequestCreator'))();

$application->run($request);
