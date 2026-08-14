<?php

namespace Cloudflare\HttpClient;

use Cloudflare\Contracts\ResponseInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class Response implements ResponseInterface
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
    public function __construct(HttpResponseInterface $response)
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
     * True for any 2xx status. Cloudflare answers most endpoints with `200`,
     * but some return `201`, `202` or `204`, and a `HEAD` request may too.
     *
     * @return bool
     */
    public function successful()
    {
        return $this->status() >= 200 && $this->status() < 300;
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
     * Errors Cloudflare reported in the response envelope.
     *
     * Cloudflare answers some operations with a 2xx status and a body carrying
     * `"success": false`, notably where part of a bulk request failed, so a
     * successful status alone does not always mean the operation worked.
     *
     * @return array<int, array>
     */
    public function errors()
    {
        return $this->envelope('errors');
    }

    /**
     * Informational messages Cloudflare returned in the response envelope.
     *
     * @return array<int, array>
     */
    public function messages()
    {
        return $this->envelope('messages');
    }

    /**
     * Determine if Cloudflare reported any errors in the response envelope.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return $this->errors() !== [];
    }

    /**
     * Read a list from the Cloudflare response envelope.
     *
     * @param  string  $key
     * @return array<int, array>
     */
    private function envelope(string $key)
    {
        $value = $this->json($key);

        return is_array($value) ? $value : [];
    }

    /**
     * Resolve a dot notated key against the decoded body.
     *
     * @param  mixed  $target
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    private function get($target, string $key, $default = null)
    {
        foreach (explode('.', $key) as $segment) {
            if (!is_array($target) || !array_key_exists($segment, $target)) {
                return $default;
            }

            $target = $target[$segment];
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
