<?php

declare(strict_types=1);

namespace App\Web\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PerformanceMiddleware implements MiddlewareInterface
{
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$startTime = microtime(true);
		$response = $handler->handle($request);
		$runtime = (microtime(true) - $startTime) / 1000; // ms

		$memory = memory_get_peak_usage() / 1024 / 1024; // MB

		$response = $response->withHeader('X-Runtime', (string)round($runtime, 1) . ' ms')
			->withHeader('X-Memory', (string)round($memory, 1) . ' MB');

		return $response;
	}
}
