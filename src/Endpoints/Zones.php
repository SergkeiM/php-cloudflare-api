<?php

namespace CloudFlare\Endpoints;

use CloudFlare\Contracts\CloudFlareResponse;
use CloudFlare\Endpoints\Zones\Cache;
use CloudFlare\Endpoints\Zones\CloudConnector;
use CloudFlare\Endpoints\Zones\DNS;
use CloudFlare\Endpoints\Zones\PageRules;

/**
 * @link https://developers.cloudflare.com/api/operations/zones-get
 */
class Zones extends AbstractEndpoint
{
    /**
     * Lists, searches, sorts, and filters your zones. Listing zones across more than 500 accounts is currently not allowed.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-get
     *
     * @param array $params Query Parameters.
     *
     * @return CloudFlareResponse List zones of account found.
     */
    public function list(array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get('/zones', $params);
    }

    /**
     * Create Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-post
     *
     * @param string $accountId Account ID that you want to zone for.
     * @param array $values Values to set on zone.
     *
     * @return CloudFlareResponse Create Zone response.
     */
    public function create(string $accountId, array $values): CloudFlareResponse
    {

        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->post('/zones', [
            ...$values,
            'account' => [
                'id' => $accountId
            ]
        ]);
    }

    /**
     * Delete Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-delete
     *
     * @param string $zoneId Zone ID that you want to delete.
     *
     * @return CloudFlareResponse Delete Zone response.
     */
    public function delete(string $zoneId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}");
    }

    /**
     * Zone Details
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-get
     *
     * @param string $zoneId Zone ID to fetch details.
     *
     * @return CloudFlareResponse Zone Details response.
     */
    public function details(string $zoneId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}");
    }

    /**
     * Edit Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-patch
     *
     * @param string $zoneId Zone ID to update.
     *
     * @return CloudFlareResponse Edit Zone response.
     */
    public function update(string $zoneId, array $values): CloudFlareResponse
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}", $values);
    }

    /**
     * Triggeres a new activation check for a PENDING Zone. This can be triggered every 5 min for paygo/ent customers, every hour for FREE Zones.
     *
     * @link https://developers.cloudflare.com/api/operations/put-zones-zone_id-activation_check
     *
     * @param string $zoneId Zone ID to trigger Activation Check.
     *
     * @return CloudFlareResponse Activation Check Response
     */
    public function activationCheck(string $zoneId): CloudFlareResponse
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/activation_check");
    }

    /**
     * Purge Cached Content
     *
     * @link https://developers.cloudflare.com/api/operations/zone-purge
     *
     * @param string $zoneId Zone ID to purge cache.
     * @param array $purgeBy Any of: tags, hostnames, prefixes, everything, files
     *
     * @return CloudFlareResponse Purge Cached Content Response
     */
    public function purge(string $zoneId, array $purgeBy): CloudFlareResponse
    {

        $this->requiredParams(['files', 'tags', 'hosts', 'prefixes'], $purgeBy);

        return $this->getHttpClient()->post("/zones/{$zoneId}/purge_cache", $purgeBy);
    }

    /**
     * Zone cache settings
     *
     * @return Cache
     */
    public function cache(): Cache
    {
        return new Cache($this->getClient());
    }

    /**
     * Zone Cloud Connector rules
     *
     * @return CloudConnector
     */
    public function cloudConnector(): CloudConnector
    {
        return new CloudConnector($this->getClient());
    }

    /**
     * Zone DNS
     *
     * @return DNS
     */
    public function dns(): DNS
    {
        return new DNS($this->getClient());
    }

    /**
     * Zone PageRules
     *
     * @return PageRules
     */
    public function pageRules(): PageRules
    {
        return new PageRules($this->getClient());
    }
}
