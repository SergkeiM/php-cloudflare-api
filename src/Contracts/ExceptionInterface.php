<?php

namespace Cloudflare\Contracts;

use Throwable;

/**
 * Implemented by every exception this package throws.
 *
 * Catch this to handle anything originating from the client, whatever its
 * cause, without listing each type or falling back to `\Throwable`:
 *
 * ```php
 * try {
 *     $client->zones()->get($zoneId);
 * } catch (ExceptionInterface $e) {
 *     // Any failure from this package.
 * }
 * ```
 *
 * The individual exceptions keep their native parents — `InvalidArgumentException`
 * still extends `\InvalidArgumentException`, and so on — so existing catch blocks
 * against the SPL types keep working.
 */
interface ExceptionInterface extends Throwable
{
}
