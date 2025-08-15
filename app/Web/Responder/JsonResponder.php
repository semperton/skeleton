<?php

declare(strict_types=1);

namespace App\Web\Responder;

use App\Domain\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class JsonResponder extends BaseResponder
{
    #[\Override]
    public function render(
        ServerRequestInterface $request,
        PayloadInterface $payload
    ): ResponseInterface {
        $status = $this->getStatusCode($payload);
        $response = $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', 'application/json');
        $json = json_encode(
            $payload->getOutput(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        );
        $response->getBody()->write($json);
        return $response;
    }
}
