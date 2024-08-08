<?php

namespace SergkeiM\CloudFlare\Endpoints;

use SergkeiM\CloudFlare\Client;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

abstract class AbstractApi
{
    /**
     * The client instance.
     *
     * @var Client
     */
    private $client;

    /**
     * The per page parameter. It is used by the ResultPager.
     *
     * @var int|null
     */
    private $perPage;

    /**
     * Create a new API instance.
     *
     * @param Client $client
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return $this
     */
    public function configure()
    {
        return $this;
    }

    /**
     * Get the client instance.
     *
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return array
     */
    protected function get(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        if (null !== $this->perPage && !isset($parameters['per_page'])) {
            $parameters['per_page'] = $this->perPage;
        }

        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        return $this->send(
            'get',
            $path,
            $requestHeaders
        );
    }

    /**
     * Send a HEAD request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     HEAD parameters.
     * @param array  $requestHeaders Request headers.
     *
     * @return array
     */
    protected function head(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->send(
            'head',
            $path.'?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986),
            $requestHeaders
        );
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array
     */
    protected function post(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders,
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string $path           Request path.
     * @param string $body           Request body.
     * @param array  $requestHeaders Request headers.
     *
     * @return array
     */
    protected function postRaw(string $path, $body, array $requestHeaders = []): array
    {
        return $this->send(
            'post',
            $path,
            $requestHeaders,
            $body
        );
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array
     */
    protected function patch(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->send(
            'patch',
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array
     */
    protected function put(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->send(
            'put',
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return array
     */
    protected function delete(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->send(
            'delete',
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param array $parameters Request parameters
     *
     * @return string|null
     */
    protected function createJsonBody(array $parameters): ?string
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }

    /**
     * Send the request to the given URL.
     *
     * @param  string  $method
     * @param  string|UriInterface  $url
     * @param  array  $headers
     * @param  StreamInterface|string|null $body
     * @return array
     */
    protected function send(
        string $method,
        string $url,
        array $headers = [],
        $body = null
    ): array
    {
        $response = $this->client->getHttpClient()->send($method, $url, $headers, $body);

        $body = (string) $response->getBody();

        return json_decode($body, true);
    }
}
