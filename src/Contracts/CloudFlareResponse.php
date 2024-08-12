<?php

namespace SergkeiM\CloudFlare\Contracts;

use JsonSerializable;
use Stringable;
use Psr\Http\Message\ResponseInterface;

/**
 * @template TKey of array-key
 * @template TValue
 */

interface CloudFlareResponse extends JsonSerializable, Stringable, Arrayable
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
     * Get the body of the response.
     *
     * @param $key null
     * @param $default null
     * @return mixed
     */
    public function json($key = null, $default = null);

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0);
}
