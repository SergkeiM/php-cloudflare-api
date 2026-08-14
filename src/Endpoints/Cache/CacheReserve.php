<?php

namespace Cloudflare\Endpoints\Cache;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Cache Reserve stores cacheable files in Cloudflare's persistent object
 * storage, so they survive eviction from the edge cache. It requires a paid
 * R2 subscription.
 *
 * @link https://developers.cloudflare.com/cache/advanced-configuration/cache-reserve/
 */
class CacheReserve extends AbstractEndpoint
{
    /**
     * Current Cache Reserve setting for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Cache Reserve response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/cache/cache_reserve");
    }

    /**
     * Turn Cache Reserve on or off for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param bool $enabled Whether Cache Reserve is enabled.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Edit Cache Reserve response
     */
    public function edit(string $zoneId, bool $enabled): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/cache/cache_reserve", [
            'value' => $enabled ? 'on' : 'off'
        ]);
    }

    /**
     * Start clearing the Cache Reserve of a zone.
     *
     * Cache Reserve has to be disabled first, and cannot be re-enabled while
     * the clear is running. Poll {@see self::status()} for progress.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/clear/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Cache Reserve Clear response
     */
    public function clear(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/cache/cache_reserve_clear", []);
    }

    /**
     * Progress of the most recent Cache Reserve clear.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/status/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Cache Reserve Clear status response
     */
    public function status(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/cache/cache_reserve_clear");
    }
}
