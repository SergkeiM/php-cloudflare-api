<?php

namespace Cloudflare\Endpoints\Cache;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\MissingArgumentException;

/**
 * Variant support caches images with certain file extensions separately per
 * MIME type, so an origin serving `webp` to one client and `jpeg` to another
 * does not have them collapsed into a single cached copy.
 *
 * Only works on zones with Tiered Cache enabled.
 *
 * @link https://developers.cloudflare.com/cache/how-to/cache-rules/settings/#cache-variants
 */
class Variants extends AbstractEndpoint
{
    /**
     * Current variant support setting for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/variants/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get variants response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/cache/variants");
    }

    /**
     * Set the variants cached for a zone.
     *
     * Keyed by file extension — `avif`, `bmp`, `gif`, `jpeg`, `jpg`, `jpg2`,
     * `jp2`, `png`, `tif`, `tiff`, `webp` — each holding the MIME types to
     * serve as variants of it:
     *
     * ```php
     * $client->cache()->variants()->edit('ZONE_ID', [
     *     'jpeg' => ['image/webp', 'image/avif'],
     *     'png'  => ['image/webp'],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/variants/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $value Variants to cache, keyed by file extension.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Edit variants response
     */
    public function edit(string $zoneId, array $value): ResponseInterface
    {
        if ($value === []) {
            throw new MissingArgumentException('value');
        }

        return $this->getHttpClient()->patch("/zones/{$zoneId}/cache/variants", [
            'value' => $value
        ]);
    }

    /**
     * Revert variant support to its default, caching no variants.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/variants/methods/delete/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete variants response
     */
    public function delete(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/cache/variants");
    }
}
