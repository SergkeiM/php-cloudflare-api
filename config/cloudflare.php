<?php

/*
 * This file is part of Laravel Cloudflare.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | A token is required. Blank values count as unset, and resolving the
    | client without one throws a ConfigurationException.
    |
    | https://developers.cloudflare.com/fundamentals/api/get-started/create-token
    |
    */

    'auth' => [

        'token' => env('CLOUDFLARE_TOKEN'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | Base URL every request is resolved against. Leave null to use the
    | Cloudflare API v4 endpoint. Useful for pointing at a mock server or a
    | gateway during testing.
    |
    */

    'base_url' => env('CLOUDFLARE_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Timeouts
    |--------------------------------------------------------------------------
    |
    | Seconds to wait for a response, and seconds to wait while connecting.
    | Set either to 0 to disable it. Raise `timeout` if you upload large
    | Worker scripts or run long queries.
    |
    */

    'timeout' => env('CLOUDFLARE_TIMEOUT', 30),

    'connect_timeout' => env('CLOUDFLARE_CONNECT_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | Max Retries
    |--------------------------------------------------------------------------
    |
    | Attempts made after the initial request before giving up. Connection
    | failures and the 408, 409, 429 and 5xx statuses are retried with
    | exponential backoff, honouring Cloudflare's `Retry-After` header.
    | Set to 0 to disable retries.
    |
    */

    'max_retries' => env('CLOUDFLARE_MAX_RETRIES', 2),

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    |
    | Additional headers sent with every request. `Authorization` is always
    | managed by the client and cannot be overridden here.
    |
    */

    'headers' => [],

];
