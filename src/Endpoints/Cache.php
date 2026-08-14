<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\Cache\CacheReserve;
use Cloudflare\Endpoints\Cache\RegionalTieredCache;
use Cloudflare\Endpoints\Cache\SmartTieredCache;
use Cloudflare\Endpoints\Cache\Variants;

/**
 * How a zone caches: where copies are kept, which upper tiers are consulted,
 * and which file variants are cached separately.
 *
 * Purging is not here — it lives on the zone itself, as `$client->zones()->purge()`.
 *
 * @link https://developers.cloudflare.com/cache/
 */
class Cache extends AbstractEndpoint
{
    /**
     * Cache Reserve
     *
     * @return \Cloudflare\Endpoints\Cache\CacheReserve
     */
    public function cacheReserve(): CacheReserve
    {
        return new CacheReserve($this->getClient());
    }

    /**
     * Regional Tiered Cache
     *
     * @return \Cloudflare\Endpoints\Cache\RegionalTieredCache
     */
    public function regionalTieredCache(): RegionalTieredCache
    {
        return new RegionalTieredCache($this->getClient());
    }

    /**
     * Smart Tiered Cache
     *
     * @return \Cloudflare\Endpoints\Cache\SmartTieredCache
     */
    public function smartTieredCache(): SmartTieredCache
    {
        return new SmartTieredCache($this->getClient());
    }

    /**
     * Cache Variants
     *
     * @return \Cloudflare\Endpoints\Cache\Variants
     */
    public function variants(): Variants
    {
        return new Variants($this->getClient());
    }
}
