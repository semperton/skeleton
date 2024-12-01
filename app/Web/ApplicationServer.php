<?php

declare(strict_types=1);

namespace App\Web;

use HttpSoft\Message\ServerRequest;
use HttpSoft\Message\StreamFactory;
use Psr\Http\Message\ResponseInterface;
use Semperton\Framework\Application;
use stdClass;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Worker;

final class ApplicationServer
{
    protected Worker $httpWorker;

    // protected Worker $socketWorker;

    public function __construct(
        protected Application $application,
        protected StreamFactory $streamFactory
    ) {
        $this->httpWorker = new Worker('http://0.0.0.0:8080');
        $this->httpWorker->name = 'http';
        $this->httpWorker->count = 4;
        // $this->httpWorker->reusePort = true;

        $this->httpWorker->onMessage = [$this, 'handleRequest'];

        // $this->socketWorker = new Worker('websocket://0.0.0.0:8080');
        // $this->socketWorker->count = 2;
        // $this->socketWorker->reusePort = true;

        // $this->socketWorker->onConnect = function($connection){
        //     var_dump('new connection');
        // };
        // $this->socketWorker->onMessage = function(ConnectionInterface $connection, string $data){
        //     $connection->send($data . ' Back');
        // };
    }

    public function handleRequest(
        TcpConnection $connection,
        Request $workerRequest
    ): void {
        /** @var array<string, mixed> */
        $cookieParams = $workerRequest->cookie();

        /** @var array<string, string|array<int, string>> */
        $queryParams = $workerRequest->get();

        /** @var string */
        $uri = $workerRequest->uri();

        /** @var array<string, string> */
        $headers = $workerRequest->header();

        $method = $workerRequest->method();
        $body = $this->streamFactory->createStream($workerRequest->rawBody());
        $protocol = $workerRequest->protocolVersion();

        $request = new ServerRequest(
            $_SERVER,
            [],
            $cookieParams,
            $queryParams,
            null,
            $method,
            $uri,
            $headers,
            $body,
            $protocol
        );
        $request = $request->withAttribute('_connection', $connection);

        $response = $this->application->handle($request);
        $this->sendResponse($connection, $response);
    }

    protected function sendResponse(
        TcpConnection $connection,
        ResponseInterface $response
    ): void {
        $protocol = $response->getProtocolVersion();
        $status = $response->getStatusCode();
        $reason = $response->getReasonPhrase();
        $body = $response->getBody();

        $shouldChunk = $response->getHeaderLine('transfer-encoding') === 'chunked';
        $keepOpen = $response->getHeaderLine('content-type') === 'text/event-stream';
        $contentLength = $response->getHeaderLine('content-length');
        if (!$shouldChunk && !$keepOpen && $contentLength === '') {
            $response = $response->withHeader('Content-Length', (string)$body->getSize());
        }

        $head = "HTTP/$protocol $status $reason";
        $headers = $response->getHeaders();

        foreach ($headers as $name => $values) {
            $head .= "\r\n$name: " . implode(', ', $values);
        }

        $connection->send("$head\r\n\r\n", true);

        if ($body->isSeekable()) {
            $body->rewind();
        }

        $connection->context = $connection->context ?? new stdClass;
        $connection->context->bufferFull = false;
        $writeFunc = static function () use ($body, $connection, $shouldChunk): void {
            $eof = $body->eof();
            while (
                $connection->getStatus() === TcpConnection::STATUS_ESTABLISHED &&
                !$connection->context->bufferFull &&
                !$eof
            ) {
                $data = $body->read(4096);
                $eof = $body->eof();
                if ($shouldChunk) {
                    $size = dechex(strlen($data));
                    $connection->send("$size\r\n$data\r\n", true);
                    if ($eof) {
                        $connection->send("0\r\n\r\n", true);
                    }
                } else {
                    $connection->send($data, true);
                }
            }
        };

        $connection->onBufferFull = static function () use ($connection): void {
            $connection->context->bufferFull = true;
        };

        $connection->onBufferDrain = static function () use ($writeFunc, $connection): void {
            $connection->context->bufferFull = false;
            $writeFunc();
        };

        $writeFunc();
    }
}
