<?php

namespace Cloudflare\Tests\Concerns;

use Cloudflare\Client;
use Cloudflare\ClientOptions;
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
     * Guzzle options as they were resolved for each outgoing request.
     *
     * @var array<int, array>
     */
    protected array $requestOptions = [];

    /**
     * @param ResponseInterface[] $responses
     * @param ClientOptions|null $clientOptions Transport configuration to build the client with. The mock handler is appended to its middlewares.
     *
     * Retries are off unless $clientOptions asks for them, so a single queued
     * response is enough for the vast majority of tests.
     *
     * @return Client
     */
    protected function mockClient(array $responses, ?ClientOptions $clientOptions = null): Client
    {
        $mock = new MockHandler($responses);

        $middlewares = array_merge($clientOptions?->middlewares ?? [], [
            Middleware::history($this->requestHistory),
            fn (callable $handler) => function ($request, array $options) use ($mock) {
                $this->requestOptions[] = $options;

                return $mock($request, $options);
            },
        ]);

        return new Client('token', new ClientOptions(
            baseUrl: $clientOptions?->baseUrl,
            timeout: $clientOptions?->timeout ?? ClientOptions::DEFAULT_TIMEOUT,
            connectTimeout: $clientOptions?->connectTimeout ?? ClientOptions::DEFAULT_CONNECT_TIMEOUT,
            headers: $clientOptions?->headers ?? [],
            middlewares: $middlewares,
            maxRetries: $clientOptions?->maxRetries ?? 0,
        ));
    }

    protected function lastRequest(): RequestInterface
    {
        return end($this->requestHistory)['request'];
    }

    /**
     * The Guzzle options resolved for the most recent request.
     *
     * @return array
     */
    protected function lastRequestOptions(): array
    {
        return end($this->requestOptions);
    }
}
