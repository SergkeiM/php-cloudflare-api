<?php

namespace SergkeiM\CloudFlare\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SergkeiM\CloudFlare\Exceptions\RequestException;
use SergkeiM\CloudFlare\Exceptions\ConnectionException;

/**
 * API HttpClient.
 */
class HttpClient
{
    /**
     * Guzzle HTTP
     *
     * @var Client
     */
    protected Client $client;

    /**
     * The base URL for CloudFlare API requests.
     *
     * @var string
     */
    protected string $baseUrl = 'https://api.cloudflare.com/client/v4/';

    /**
     * @param  string  $token
     * @param array $middleware The middleware callables added by users that will handle requests.
     * @return void
     */
    public function __construct(
        string $token,
        array $middlewares = []
    ) {

        $stack = HandlerStack::create();

        $stack->push($this->exceptionThrower());

        foreach ($middlewares as $middleware) {
            $stack->push($middleware);
        }

        $this->client = new Client([
            'stack' => $stack,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Authorization' => "Bearer {$token}",
                'User-Agent' => 'php-cloudflare-api (https://github.com/SergkeiM/php-cloudflare-api)'
            ],
            RequestOptions::CONNECT_TIMEOUT => 10,
            RequestOptions::CRYPTO_METHOD => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            RequestOptions::TIMEOUT => 30
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
     * Issue a GET request to the given CloudGlare endpoint.
     *
     * @param  string  $url
     * @param  array|string|null  $query
     * @param  array  $options
     * @return \SergkeiM\CloudFlare\HttpClient\Response
     */
    public function get(string $url, $query = null, array $options = [])
    {
        return $this->send('GET', $url, is_null($query) ? $options : [
            ...$options,
            'query' => $query,
        ]);
    }

    /**
     * Issue a HEAD request to the given CloudGlare endpoint.
     *
     * @param  string  $url
     * @param  array|string|null  $query
     * @param  array  $options
     * @return \SergkeiM\CloudFlare\HttpClient\Response
     */
    public function head(string $url, $query = null, array $options = [])
    {
        return $this->send('HEAD', $url, is_null($query) ? $options : [
            ...$options,
            'query' => $query,
        ]);
    }

    /**
     * Issue a POST request to the given CloudGlare endpoint.
     *
     * @param  string  $url
     * @param  array  $data
     * @param  array  $options
     * @param  string  $format
     * @return \SergkeiM\CloudFlare\HttpClient\Response
     */
    public function post(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('POST', $url, [
            ...$options,
            $format => $data,
        ]);
    }

    /**
    * Issue a PATCH request to the given CloudGlare endpoint.
    *
    * @param  string  $url
    * @param  array  $data
    * @param  array  $options
    * @param  string  $format
    * @return \SergkeiM\CloudFlare\HttpClient\Response
    */
    public function patch(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('PATCH', $url, [
            ...$options,
            $format => $data,
        ]);
    }

    /**
     * Issue a PUT request to the given CloudGlare endpoint.
     *
     * @param  string  $url
     * @param  array  $data
     * @param  array  $options
     * @param  string  $format
     * @return \SergkeiM\CloudFlare\HttpClient\Response
     */
    public function put(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('PUT', $url, [
            ...$options,
            $format => $data,
        ]);
    }

    /**
     * Issue a DELETE request to the given CloudGlare endpoint.
     *
     * @param  string  $url
     * @param  array  $data
     * @param  array  $options
     * @param  string  $format
     * @return \SergkeiM\CloudFlare\HttpClient\Response
     */
    public function delete(string $url, array $data = [], array $options = [], string $format = RequestOptions::JSON)
    {
        return $this->send('DELETE', $url, empty($data) ? [] : [
            ...$options,
            $format => $data,
        ]);
    }

    /**
     * Send the request to the given CloudGlare endpoint.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  array  $options
     *
     * @throws ConnectionException
     * @throws RequestException
     *
     * @return \SergkeiM\CloudFlare\HttpClient\Response
     */
    public function send(string $method, string $url, array $options = [])
    {
        try {

            $response = new Response($this->client->request($method, $this->baseUrl.ltrim($url, '/'), $options));

            if ($response->failed()) {

                throw new RequestException($response);
            }

            return $response;

        } catch (ConnectException $e) {

            $exception = new ConnectionException($e->getMessage(), 0, $e);

            throw $exception;
        }

    }

    protected function exceptionThrower()
    {

        var_dump('exceptionThrower');

        return function (callable $handler) {

            var_dump('handler exceptionThrower');

            return function (
                RequestInterface $request,
                array $options
            ) use ($handler) {
                $promise = $handler($request, $options);
                return $promise->then(function (ResponseInterface $response) {

                    $failed = $response->getStatusCode() >= 500 || ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500);

                    if ($failed) {
                        throw new RequestException($response);
                    }

                    return $response;
                });
            };
        };
    }
}
