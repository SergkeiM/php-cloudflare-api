<?php

namespace Cloudflare\Endpoints\Cache;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Smart Tiered Cache picks the single closest upper tier for each of a zone's
 * lower tiers, rather than having the topology configured by hand.
 *
 * @link https://developers.cloudflare.com/cache/how-to/tiered-cache/smart-tiered-cache/
 */
class SmartTieredCache extends AbstractEndpoint
{
    /**
     * Current Smart Tiered Cache setting for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/smart_tiered_cache/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Smart Tiered Cache response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/cache/tiered_cache_smart_topology_enable");
    }

    /**
     * Set the Smart Tiered Cache topology for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/smart_tiered_cache/methods/create/
     *
     * @param string $zoneId Zone Identifier.
     * @param bool $enabled Whether Smart Tiered Cache is enabled.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create Smart Tiered Cache response
     */
    public function create(string $zoneId, bool $enabled): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/cache/tiered_cache_smart_topology_enable", [
            'value' => $enabled ? 'on' : 'off'
        ]);
    }

    /**
     * Turn Smart Tiered Cache on or off for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/smart_tiered_cache/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param bool $enabled Whether Smart Tiered Cache is enabled.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Edit Smart Tiered Cache response
     */
    public function edit(string $zoneId, bool $enabled): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/cache/tiered_cache_smart_topology_enable", [
            'value' => $enabled ? 'on' : 'off'
        ]);
    }

    /**
     * Remove the Smart Tiered Cache topology from a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/cache/subresources/smart_tiered_cache/methods/delete/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete Smart Tiered Cache response
     */
    public function delete(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/cache/tiered_cache_smart_topology_enable");
    }
}
