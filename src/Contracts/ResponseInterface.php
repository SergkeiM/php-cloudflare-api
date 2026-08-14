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
     * Determine if the request was successful, meaning any 2xx status.
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
     * Supports dot notation, e.g. `$response->json('result.id')`.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key = null, $default = null);

    /**
     * Errors Cloudflare reported in the response envelope.
     *
     * @return array<int, array>
     */
    public function errors();

    /**
     * Informational messages Cloudflare returned in the response envelope.
     *
     * @return array<int, array>
     */
    public function messages();

    /**
     * Determine if Cloudflare reported any errors in the response envelope.
     *
     * @return bool
     */
    public function hasErrors();
}
