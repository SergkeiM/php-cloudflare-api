<?php

namespace Cloudflare\Tests\Concerns;

use Cloudflare\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Wires a Cloudflare Client to a Guzzle MockHandler so tests can assert on
 * requests and control responses without hitting the network.
 */
trait InteractsWithMockClient
{
    /**
     * @var array
     */
    protected array $requestHistory = [];

    /**
     * @param ResponseInterface[] $responses
     * @return Client
     */
    protected function mockClient(array $responses): Client
    {
        $mock = new MockHandler($responses);

        return new Client('token', [
            Middleware::history($this->requestHistory),
            fn (callable $handler) => fn ($request, array $options) => $mock($request, $options),
        ]);
    }

    protected function lastRequest(): RequestInterface
    {
        return end($this->requestHistory)['request'];
    }
}
