<?php

declare(strict_types=1);

namespace App\Web\Action;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Semperton\Framework\Interfaces\ActionInterface;

final class ApiAction implements ActionInterface
{
	protected ResponseFactoryInterface $responseFactory;

	public function __construct(ResponseFactoryInterface $responseFactory)
	{
		$this->responseFactory = $responseFactory;
	}

	#[\Override]
	public function process(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$response = $this->responseFactory->createResponse();
		$response->getBody()->write((string)json_encode([
			'status' => 200,
			'message' => 'Hello World'
		]));

		return $response->withHeader('Content-Type', 'application/json');
	}
}
