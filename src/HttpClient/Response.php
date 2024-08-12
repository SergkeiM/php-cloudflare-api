<?php

namespace SergkeiM\CloudFlare\HttpClient;

use Psr\Http\Message\ResponseInterface;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;

/**
 * @template TKey of array-key
 * @template TValue
 */

class Response implements CloudFlareResponse
{
    /**
     * The decoded JSON response.
     *
     * @var array<TKey, TValue>
     */
    protected $decoded;

    public function __construct(
        protected ResponseInterface $response
    ) {
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
     * Get the underlying PSR response for the response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toPsrResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Get the body of the response.
     *
     * @param $key null
     * @param $default null
     * @return mixed
     */
    public function json($key = null, $default = null): mixed
    {
        if (! $this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return data_get($this->decoded, $key, $default);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array<TKey, TValue>
     */
    public function jsonSerialize(): array
    {
        return $this->json();
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->json();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->body();
    }
}
