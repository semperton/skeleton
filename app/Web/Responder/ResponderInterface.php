<?php

declare(strict_types=1);

namespace App\Web\Responder;

use App\Domain\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponderInterface
{
	public function render(ServerRequestInterface $request, PayloadInterface $payload): ResponseInterface;
}
