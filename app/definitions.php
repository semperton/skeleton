<?php

declare(strict_types=1);

use App\Config\ArrayConfig;
use App\Config\ConfigInterface;
use App\Web\Middleware\PerformanceMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Semperton\Framework\Application;
use Semperton\Framework\CommonResolver;

return [
	ConfigInterface::class => static function () {

		/** @var array */
		$config = require __DIR__ . '/config.php';
		$env = __DIR__ . '/../env.php';

		if (is_file($env)) {

			$override = require $env;

			if (is_array($override)) {
				$config = array_merge($config, $override);
			}
		}

		return new ArrayConfig($config);
	},

	ResponseFactoryInterface::class => static fn (Psr17Factory $factory) => $factory,
	'ServerRequestCreator' => static function (Psr17Factory $factory) {

		$requestCreator = new ServerRequestCreator($factory, $factory, $factory, $factory);

		return [$requestCreator, 'fromGlobals'];
	},

	Application::class => static function (ContainerInterface $container, ResponseFactoryInterface $responseFactory) {

		$commonResolver = new CommonResolver($responseFactory, $container);

		$application = new Application($responseFactory, null, $commonResolver);

		// apply routes
		/** @var Closure */
		$routeCallback = require __DIR__ . '/routes.php';
		$routeCallback($application);

		// add middleware
		/** @var Closure */
		$middlewareCallback = require __DIR__ . '/middleware.php';
		$middlewareCallback($application);

		return $application;
	},

	PerformanceMiddleware::class => static function () {
		return new PerformanceMiddleware(START_TIME);
	}
];
