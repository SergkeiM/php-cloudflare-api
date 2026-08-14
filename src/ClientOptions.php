<?php

namespace Cloudflare;

use Cloudflare\Exceptions\InvalidArgumentException;

/**
 * Transport configuration for the {@see \Cloudflare\Client}.
 *
 * Every option is optional and falls back to a sensible default, so
 * `new ClientOptions()` is equivalent to the client's built-in behaviour.
 *
 * ```php
 * $client = new Client('CLOUDFLARE_TOKEN', new ClientOptions(
 *     timeout: 120,
 *     headers: ['User-Agent' => 'my-app/1.0'],
 * ));
 * ```
 *
 * @author Sergkei Melingk <sergio11of@gmail.com>
 */
final readonly class ClientOptions
{
    /**
     * The Cloudflare API v4 base URL.
     */
    public const DEFAULT_BASE_URL = 'https://api.cloudflare.com/client/v4/';

    /**
     * Seconds to wait for a response before timing out.
     */
    public const DEFAULT_TIMEOUT = 30.0;

    /**
     * Seconds to wait while connecting before timing out.
     */
    public const DEFAULT_CONNECT_TIMEOUT = 10.0;

    /**
     * Sent as `User-Agent` unless overridden via `$headers`.
     */
    public const DEFAULT_USER_AGENT = 'php-cloudflare-api (https://github.com/SergkeiM/php-cloudflare-api)';

    /**
     * Base URL every request is resolved against, with a guaranteed trailing slash.
     */
    public string $baseUrl;

    /**
     * Seconds to wait for a response. `0` disables the timeout.
     */
    public float $timeout;

    /**
     * Seconds to wait while connecting. `0` disables the timeout.
     */
    public float $connectTimeout;

    /**
     * Additional headers sent with every request.
     *
     * @var array<string, string|string[]>
     */
    public array $headers;

    /**
     * Guzzle middlewares. https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#middleware
     *
     * @var array<int, callable>
     */
    public array $middlewares;

    /**
     * @param string|null $baseUrl Base URL for API requests. Defaults to the Cloudflare API v4 endpoint.
     * @param float $timeout Seconds to wait for a response. `0` disables the timeout.
     * @param float $connectTimeout Seconds to wait while connecting. `0` disables the timeout.
     * @param array<string, string|string[]> $headers Additional headers sent with every request. `Authorization` is always managed by the client and cannot be overridden here.
     * @param array<int, callable> $middlewares Guzzle middlewares.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $baseUrl = null,
        float $timeout = self::DEFAULT_TIMEOUT,
        float $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT,
        array $headers = [],
        array $middlewares = []
    ) {
        $this->baseUrl = self::normalizeBaseUrl($baseUrl);
        $this->timeout = self::normalizeTimeout($timeout, 'timeout');
        $this->connectTimeout = self::normalizeTimeout($connectTimeout, 'connectTimeout');
        $this->headers = self::normalizeHeaders($headers);
        $this->middlewares = self::normalizeMiddlewares($middlewares);
    }

    /**
     * @param string|null $baseUrl
     *
     * @throws InvalidArgumentException
     * @return string
     */
    private static function normalizeBaseUrl(?string $baseUrl): string
    {
        if ($baseUrl === null) {
            return self::DEFAULT_BASE_URL;
        }

        $baseUrl = trim($baseUrl);

        if ($baseUrl === '') {
            throw new InvalidArgumentException('The base URL cannot be empty.');
        }

        $scheme = parse_url($baseUrl, PHP_URL_SCHEME);

        if (!in_array($scheme, ['http', 'https'], true) || parse_url($baseUrl, PHP_URL_HOST) === null) {
            throw new InvalidArgumentException(sprintf('The base URL must be an absolute http(s) URL, "%s" given.', $baseUrl));
        }

        // Paths are always appended to the base URL, so a trailing slash is required.
        return rtrim($baseUrl, '/').'/';
    }

    /**
     * @param float $seconds
     * @param string $option
     *
     * @throws InvalidArgumentException
     * @return float
     */
    private static function normalizeTimeout(float $seconds, string $option): float
    {
        if ($seconds < 0) {
            throw new InvalidArgumentException(sprintf('The %s must be zero or greater, %s given.', $option, $seconds));
        }

        return $seconds;
    }

    /**
     * @param array<string, string|string[]> $headers
     *
     * @throws InvalidArgumentException
     * @return array<string, string|string[]>
     */
    private static function normalizeHeaders(array $headers): array
    {
        foreach ($headers as $name => $value) {
            if (!is_string($name) || trim($name) === '') {
                throw new InvalidArgumentException('Header names must be non-empty strings.');
            }

            if (!is_string($value) && !is_array($value)) {
                throw new InvalidArgumentException(sprintf('The value for header "%s" must be a string or an array of strings.', $name));
            }
        }

        return $headers;
    }

    /**
     * @param array<int, callable> $middlewares
     *
     * @throws InvalidArgumentException
     * @return array<int, callable>
     */
    private static function normalizeMiddlewares(array $middlewares): array
    {
        foreach ($middlewares as $middleware) {
            if (!is_callable($middleware)) {
                throw new InvalidArgumentException('Every middleware must be callable.');
            }
        }

        return $middlewares;
    }
}
