<?php

namespace Cloudflare\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\ConnectException;
use Cloudflare\ClientOptions;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\HttpClient\Exceptions\BadRequestException;
use Cloudflare\HttpClient\Exceptions\AuthenticationException;
use Cloudflare\HttpClient\Exceptions\PermissionDeniedException;
use Cloudflare\HttpClient\Exceptions\NotFoundException;
use Cloudflare\HttpClient\Exceptions\UnprocessableEntityException;
use Cloudflare\HttpClient\Exceptions\RateLimitException;
use Cloudflare\HttpClient\Exceptions\InternalServerException;
use Cloudflare\HttpClient\Exceptions\RequestException;
use Cloudflare\HttpClient\Exceptions\ConnectionException;

/**
 * API HttpClient.
 */
class HttpClient
{
    /**
     * Guzzle HTTP
     */
    protected readonly Client $client;

    /**
     * Transport configuration this client was built with.
     */
    protected readonly ClientOptions $options;

    /**
     * Token presented on every request.
     */
    protected readonly string $token;

    /**
     * @param  string  $token Cloudflare API token.
     * @param  \Cloudflare\ClientOptions|null  $options Transport configuration. Defaults to `new ClientOptions()`.
     *
     * @throws InvalidArgumentException
     * @return void
     */
    public function __construct(
        string $token,
        ?ClientOptions $options = null
    ) {

        if (trim($token) === '') {
            throw new InvalidArgumentException('The API token cannot be empty.');
        }

        $this->token = $token;

        $this->options = $options ?? new ClientOptions();

        $stack = HandlerStack::create();

        // Pushed before the user's middlewares so it wraps them: they observe
        // every attempt, rather than only the outcome of the last one.
        if ($this->options->maxRetries > 0) {
            $stack->push(Retry::middleware($this->options->maxRetries), 'cloudflare_retry');
        }

        foreach ($this->options->middlewares as $middleware) {
            $stack->push($middleware);
        }

        $this->client = new Client([
            'handler' => $stack,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => self::buildHeaders($this->token, $this->options->headers),
            RequestOptions::CONNECT_TIMEOUT => $this->options->connectTimeout,
            RequestOptions::CRYPTO_METHOD => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            RequestOptions::TIMEOUT => $this->options->timeout
        ]);
    }

    /**
     * Get Guzzle Client
     *
     * @return Client
     */
    public function getGuzzleClient()
    {
        return $this->client;
    }

    /**
     * Get the transport configuration this client was built with.
     *
     * @return \Cloudflare\ClientOptions
     */
    public function getOptions(): ClientOptions
    {
        return $this->options;
    }

    /**
     * Merge the user supplied headers over the defaults, case-insensitively.
     *
     * The token is owned by the client, so `Authorization` is always applied last.
     *
     * @param  string  $token
     * @param  array<string, string|string[]>  $headers
     * @return array<string, string|string[]>
     */
    private static function buildHeaders(string $token, array $headers): array
    {
        $merged = ['User-Agent' => ClientOptions::DEFAULT_USER_AGENT];

        foreach ($headers as $name => $value) {
            $merged = self::withoutHeader($merged, $name);
            $merged[$name] = $value;
        }

        $merged = self::withoutHeader($merged, 'Authorization');
        $merged['Authorization'] = "Bearer {$token}";

        return $merged;
    }

    /**
     * Remove every case-insensitive match for the given header name.
     *
     * @param  array<string, string|string[]>  $headers
     * @param  string  $name
     * @return array<string, string|string[]>
     */
    private static function withoutHeader(array $headers, string $name): array
    {
        foreach (array_keys($headers) as $existing) {
            if (strcasecmp((string) $existing, $name) === 0) {
                unset($headers[$existing]);
            }
        }

        return $headers;
    }

    /**
     * Issue a GET request to the given Cloudflare endpoint.
     *
     * @param  string  $url
     * @param  array|string|null  $query
     * @param  array  $options
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function get(string $url, $query = null, array $options = [])
    {
        return $this->send('GET', $url, is_null($query) ? $options : array_merge($options, [
            'query' => $query,
        ]));
    }

    /**
     * Issue a HEAD request to the given Cloudflare endpoint.
     *
     * @param  string  $url
     * @param  array|string|null  $query
     * @param  array  $options
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function head(string $url, $query = null, array $options = [])
    {
        return $this->send('HEAD', $url, is_null($query) ? $options : array_merge($options, [
            'query' => $query,
        ]));
    }

    /**
     * Issue a POST request to the given Cloudflare endpoint.
     *
     * @param  string  $url
     * @param  array  $data
     * @param  array  $options
     * @param  string  $format
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function post(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('POST', $url, array_merge($options, [
            $format => $data,
        ]));
    }

    /**
    * Issue a PATCH request to the given Cloudflare endpoint.
    *
    * @param  string  $url
    * @param  array  $data
    * @param  array  $options
    * @param  string  $format
    * @return \Cloudflare\Contracts\ResponseInterface
    */
    public function patch(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('PATCH', $url, array_merge($options, [
            $format => $data,
        ]));
    }

    /**
     * Issue a PUT request to the given Cloudflare endpoint.
     *
     * @param  string  $url
     * @param  array  $data
     * @param  array  $options
     * @param  string  $format
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function put(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('PUT', $url, array_merge($options, [
            $format => $data,
        ]));
    }

    /**
     * Issue a DELETE request to the given Cloudflare endpoint.
     *
     * @param  string  $url
     * @param  array  $data
     * @param  array  $options
     * @param  string  $format
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function delete(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('DELETE', $url, empty($data) ? $options : array_merge($options, [
            $format => $data,
        ]));
    }

    /**
     * Send the request to the given Cloudflare endpoint.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  array  $options
     *
     * @throws \Cloudflare\HttpClient\Exceptions\BadRequestException
     * @throws \Cloudflare\HttpClient\Exceptions\AuthenticationException
     * @throws \Cloudflare\HttpClient\Exceptions\PermissionDeniedException
     * @throws \Cloudflare\HttpClient\Exceptions\NotFoundException
     * @throws \Cloudflare\HttpClient\Exceptions\UnprocessableEntityException
     * @throws \Cloudflare\HttpClient\Exceptions\RateLimitException
     * @throws \Cloudflare\HttpClient\Exceptions\InternalServerException
     * @throws \Cloudflare\HttpClient\Exceptions\RequestException
     * @throws \Cloudflare\HttpClient\Exceptions\ConnectionException
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function send(string $method, string $url, array $options = [])
    {
        try {

            $response = new Response($this->client->request($method, $this->options->baseUrl.ltrim($url, '/'), $options));

            if ($response->failed()) {

                $status = $response->status();

                match (true) {
                    $status === 400 => throw new BadRequestException($response),
                    $status === 401 => throw new AuthenticationException($response),
                    $status === 403 => throw new PermissionDeniedException($response),
                    $status === 404 => throw new NotFoundException($response),
                    $status === 422 => throw new UnprocessableEntityException($response),
                    $status === 429 => throw new RateLimitException($response),
                    $status >= 500 => throw new InternalServerException($response),
                    default => throw new RequestException($response),
                };
            }

            return $response;

        } catch (ConnectException $e) {

            throw new ConnectionException($e->getMessage(), 0, $e);
        }

    }
}
