<?php

declare(strict_types=1);

use App\Web\Middleware\PerformanceMiddleware;
use Semperton\Framework\Application;

return static function (Application $app) {

	$app->addMiddleware(PerformanceMiddleware::class);
	$app->addErrorMiddleware();
	$app->addRoutingMiddleware();
	$app->addConditionalMiddleware();
	$app->addActionMiddleware();
};
