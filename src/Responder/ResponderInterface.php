<?php

declare(strict_types=1);

namespace App\Responder;

use App\Payload\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponderInterface
{
	public function render(ServerRequestInterface $request, PayloadInterface $payload): ResponseInterface;
}
