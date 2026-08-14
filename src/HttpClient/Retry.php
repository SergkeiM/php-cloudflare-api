<?php

namespace Cloudflare\HttpClient;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Retry policy for transient Cloudflare API failures.
 *
 * Mirrors the official Cloudflare SDKs: connection failures and the statuses a
 * request may succeed on if it is simply sent again are retried with exponential
 * backoff, and Cloudflare's `Retry-After` header always wins over that backoff.
 *
 * @author Sergkei Melingk <sergio11of@gmail.com>
 */
final class Retry
{
    /**
     * Ceiling for the first retry, in milliseconds. Doubles on each subsequent attempt.
     */
    public const BASE_DELAY_MS = 500;

    /**
     * Upper bound for the computed backoff, in milliseconds.
     *
     * Does not apply to a delay taken from a `Retry-After` header, which is honoured as sent.
     */
    public const MAX_DELAY_MS = 8000;

    /**
     * Statuses below 500 that are worth sending again.
     *
     * 429 is the rate limit, 408 and 409 are transient by definition. Everything
     * else in the 4xx range is a problem with the request itself.
     */
    public const RETRYABLE_STATUSES = [408, 409, 429];

    /**
     * Build the Guzzle middleware enforcing this policy.
     *
     * @param int $maxRetries Attempts to make after the initial request.
     * @return callable
     */
    public static function middleware(int $maxRetries): callable
    {
        return Middleware::retry(
            static function (int $retries, RequestInterface $request, ?ResponseInterface $response = null, ?Throwable $exception = null) use ($maxRetries): bool {
                return $retries < $maxRetries && self::shouldRetry($response, $exception);
            },
            static function (int $retries, ?ResponseInterface $response = null): int {
                return self::delay($retries, $response);
            }
        );
    }

    /**
     * Determine whether an outcome is worth retrying.
     *
     * @param ResponseInterface|null $response
     * @param Throwable|null $exception
     * @return bool
     */
    public static function shouldRetry(?ResponseInterface $response, ?Throwable $exception = null): bool
    {
        // Guzzle only rejects on transport failures here, since `http_errors` is disabled.
        if ($exception !== null) {
            return $exception instanceof ConnectException;
        }

        if ($response === null) {
            return false;
        }

        $status = $response->getStatusCode();

        return in_array($status, self::RETRYABLE_STATUSES, true) || $status >= 500;
    }

    /**
     * Milliseconds to wait before the given retry attempt.
     *
     * @param int $retries The attempt about to be made, starting at 1.
     * @param ResponseInterface|null $response
     * @return int
     */
    public static function delay(int $retries, ?ResponseInterface $response = null): int
    {
        $retryAfter = $response === null ? null : self::retryAfter($response);

        if ($retryAfter !== null) {
            return $retryAfter;
        }

        $ceiling = min(self::BASE_DELAY_MS * (2 ** max(0, $retries - 1)), self::MAX_DELAY_MS);

        // Full jitter, so a burst of clients does not retry in lockstep.
        return random_int(0, (int) $ceiling);
    }

    /**
     * Read the `Retry-After` header, which Cloudflare sends as either a number
     * of seconds or an HTTP date.
     *
     * @param ResponseInterface $response
     * @return int|null Milliseconds, or null when the header is absent or unparsable.
     */
    private static function retryAfter(ResponseInterface $response): ?int
    {
        $header = trim($response->getHeaderLine('Retry-After'));

        if ($header === '') {
            return null;
        }

        if (ctype_digit($header)) {
            return (int) $header * 1000;
        }

        $date = strtotime($header);

        if ($date === false) {
            return null;
        }

        return max(0, ($date - time()) * 1000);
    }
}
