<?php

declare(strict_types=1);

use App\Web\Action\IndexAction;
use App\Web\Action\ApiAction;
use App\Web\Middleware\CorsMiddleware;
use Semperton\Framework\Interfaces\RouteCollectorInterface;

return static function (RouteCollectorInterface $index) {

	$index->get('/', IndexAction::class);
	$index->get('/:name', IndexAction::class);
	$index->get('/api', ApiAction::class, [CorsMiddleware::class]);
};
