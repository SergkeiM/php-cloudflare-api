<?php

namespace SergkeiM\CloudFlare\Endpoints;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use SergkeiM\CloudFlare\Client;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\HttpClient\Response;

abstract class AbstractEndpoint
{
    /**
     * Create a new API instance.
     *
     * @param Client $client
     *
     * @return void
     */
    public function __construct(private Client $client)
    {

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
     * @return CloudFlareResponse
     */
    protected function sendGet(string $path, array $parameters = [], array $requestHeaders = []): CloudFlareResponse
    {
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
     * @return CloudFlareResponse
     */
    protected function sendHead(string $path, array $parameters = [], array $requestHeaders = []): CloudFlareResponse
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
     * @return CloudFlareResponse
     */
    protected function sendPost(string $path, array $parameters = [], array $requestHeaders = []): CloudFlareResponse
    {
        return $this->sendPostRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders,
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string $path Request path.
     * @param StreamInterface|string|null Request body.
     * @param array $requestHeaders Request headers.
     *
     * @return CloudFlareResponse
     */
    protected function sendPostRaw(string $path, StreamInterface|string|null $body = null, array $requestHeaders = []): CloudFlareResponse
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
     * @return CloudFlareResponse
     */
    protected function sendPatch(string $path, array $parameters = [], array $requestHeaders = []): CloudFlareResponse
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
     * @return CloudFlareResponse
     */
    protected function sendPut(string $path, array $parameters = [], array $requestHeaders = []): CloudFlareResponse
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
     * @return CloudFlareResponse
     */
    protected function sendDelete(string $path, array $parameters = [], array $requestHeaders = []): CloudFlareResponse
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
     * @param string                      $method
     * @param string|UriInterface         $url
     * @param array                       $headers
     * @param StreamInterface|string|null $body
     *
     * @return CloudFlareResponse
     */
    protected function send(
        string $method,
        string $url,
        array $headers = [],
        StreamInterface|string|null $body = null
    ): CloudFlareResponse {

        $response = $this->client->getHttpClient()->send($method, $url, $headers, $body);

        return new Response($response);
    }
}
