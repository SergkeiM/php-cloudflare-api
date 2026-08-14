<?php

namespace Cloudflare\Endpoints\Cache;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Regional Tiered Cache adds a regional hub data center between the lower
 * tiers and the upper tier, which helps when the upper tier is far away.
 *
 * @link https://developers.cloudflare.com/cache/how-to/tiered-cache/regional-tiered-cache/
 */
class RegionalTieredCache extends AbstractEndpoint
{
    /**
     * Current Regional Tiered Cache setting for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/regional_tiered_cache/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Regional Tiered Cache response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/cache/regional_tiered_cache");
    }

    /**
     * Turn Regional Tiered Cache on or off for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/regional_tiered_cache/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param bool $enabled Whether Regional Tiered Cache is enabled.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Edit Regional Tiered Cache response
     */
    public function edit(string $zoneId, bool $enabled): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/cache/regional_tiered_cache", [
            'value' => $enabled ? 'on' : 'off'
        ]);
    }
}
