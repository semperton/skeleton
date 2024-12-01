<?php

declare(strict_types=1);

namespace App\Web\Responder;

use App\Domain\PayloadInterface;
use Psr\Http\Message\ResponseFactoryInterface;

abstract class BaseResponder implements ResponderInterface
{
    public function __construct(
        protected ResponseFactoryInterface $responseFactory
    ) {}

    protected function getStatusCode(PayloadInterface $payload): int
    {
        $statusCode = 200;
        switch ($payload->getStatus()) {
            case $payload::STATUS_CREATED:
                $statusCode = 201;
                break;
            case $payload::STATUS_ERROR:
                $statusCode = 500;
                break;
            case $payload::STATUS_NOT_AUTHENTICATED:
            case $payload::STATUS_NOT_AUTHORIZED:
                $statusCode = 401;
                break;
            case $payload::STATUS_NOT_VALID:
                $statusCode = 400;
                break;
            case $payload::STATUS_NOT_FOUND:
                $statusCode = 404;
                break;
            case $payload::STATUS_CONFLICT:
                $statusCode = 409;
                break;
        }
        return $statusCode;
    }
}
