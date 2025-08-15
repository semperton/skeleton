<?php

declare(strict_types=1);

namespace App\Web\Action;

use App\Domain\Payload;
use App\Web\Responder\JsonResponder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Semperton\Framework\Interfaces\ActionInterface;

final class IndexAction implements ActionInterface
{
	public function __construct(
		protected JsonResponder $jsonResponder
	) {}

	#[\Override]
	public function process(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$payload = new Payload(Payload::STATUS_SUCCESS, [
			'message' => $args
		]);
		return $this->jsonResponder->render($request, $payload);
	}
}
