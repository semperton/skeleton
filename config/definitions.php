<?php

declare(strict_types=1);

use App\Config\ArrayConfig;
use App\Config\ConfigInterface;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Semperton\Framework\Application;
use Semperton\Framework\CommonResolver;

return [
	ConfigInterface::class => static function () {

		/** @var array */
		$config = require __DIR__ . '/values.php';
		return new ArrayConfig($config);
	},

	ResponseFactoryInterface::class => static fn(ResponseFactory $factory) => $factory,
	StreamFactoryInterface::class => static fn(StreamFactory $factory) => $factory,

	Application::class => static function (
		ContainerInterface $container,
		ResponseFactoryInterface $responseFactory
	) {

		$commonResolver = new CommonResolver($responseFactory, $container);
		$application = new Application($responseFactory, $commonResolver);

		// apply routes
		/** @var Closure */
		$routeCallback = require __DIR__ . '/routes.php';
		$routeCallback($application);

		// add middleware
		/** @var Closure */
		$middlewareCallback = require __DIR__ . '/middleware.php';
		$middlewareCallback($application);

		return $application;
	}
];
