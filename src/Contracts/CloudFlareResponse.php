<?php

namespace SergkeiM\CloudFlare\Contracts;

use Stringable;
use Psr\Http\Message\ResponseInterface;

/**
 * @template TKey of array-key
 * @template TValue
 */

interface CloudFlareResponse extends Stringable
{
    public function __construct(ResponseInterface $response);

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function body();

    /**
     * Get the underlying PSR response for the response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toPsrResponse();

    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key = null, $default = null);
}
