<?php

declare(strict_types=1);

use App\Action\IndexAction;
use Semperton\Framework\Interfaces\RouteCollectorInterface;

return static function (RouteCollectorInterface $index) {

	$index->get('/', IndexAction::class);
};
