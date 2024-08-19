<?php

namespace Cloudflare\HttpClient;

use Cloudflare\Contracts\CloudflareResponse;
use Psr\Http\Message\ResponseInterface;

class Response implements CloudflareResponse
{
    /**
     * The underlying PSR response.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * The decoded JSON response.
     *
     * @var array
     */
    protected $decoded;

    /**
     * Create a new response instance.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return void
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function body()
    {
        return (string) $this->response->getBody();
    }

    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key = null, $default = null)
    {
        if (! $this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return $this->get($this->decoded, $key, $default);
    }

    /**
     * Get the underlying PSR response for the response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toPsrResponse()
    {
        return $this->response;
    }

    /**
     * Get the status code of the response.
     *
     * @return int
     */
    public function status()
    {
        return (int) $this->response->getStatusCode();
    }

    /**
     * Determine if the request was successful.
     *
     * @return bool
     */
    public function successful()
    {
        return $this->status() === 200;
    }

    /**
     * Determine if the response failed.
     *
     * @return bool
     */
    public function failed()
    {
        return !$this->successful();
    }

    /**
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    protected function get($target, $key, $default = null)
    {
        $key = explode('.', $key);

        foreach ($key as $i => $segment) {
            unset($key[$i]);

            if (is_null($segment)) {
                return $target;
            }

            if (is_float($segment)) {
                $segment = (string) $segment;
            }

            if (is_array($target) && array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return $default;
            }
        }

        return $target;
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->body();
    }
}
