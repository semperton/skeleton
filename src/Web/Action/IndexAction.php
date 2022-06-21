<?php

declare(strict_types=1);

namespace App\Web\Action;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Semperton\Framework\Interfaces\ActionInterface;

final class IndexAction implements ActionInterface
{
	protected ResponseFactoryInterface $responseFactory;

	public function __construct(ResponseFactoryInterface $responseFactory)
	{
		$this->responseFactory = $responseFactory;
	}

	public function process(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$response = $this->responseFactory->createResponse();
		$response->getBody()->write('Hello ' . ucfirst($args['name'] ?? 'World'));

		return $response;
	}
}
