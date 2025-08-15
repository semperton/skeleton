<?php

declare(strict_types=1);

namespace App\Web\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PerformanceMiddleware implements MiddlewareInterface
{
	#[\Override]
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$startTime = microtime(true);
		$response = $handler->handle($request);
		$runtime = (microtime(true) - $startTime) / 1000.0; // ms

		$memory = (float)memory_get_peak_usage() / 1024.0 / 1024.0; // MB

		$response = $response->withHeader('X-Runtime', (string)round($runtime, 1) . ' ms')
			->withHeader('X-Memory', (string)round($memory, 1) . ' MB');

		return $response;
	}
}
