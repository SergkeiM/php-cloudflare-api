<?php

namespace Cloudflare\Contracts;

use Stringable;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

interface ResponseInterface extends Stringable
{
    public function __construct(HttpResponseInterface $response);

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
     * Get the status code of the response.
     *
     * @return int
     */
    public function status();

    /**
     * Determine if the request was successful.
     *
     * @return bool
     */
    public function successful();

    /**
     * Determine if the response failed.
     *
     * @return bool
     */
    public function failed();

    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key = null, $default = null);

    /**
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($target, $key, $default = null);
}
