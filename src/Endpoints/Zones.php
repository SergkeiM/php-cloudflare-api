<?php

namespace CloudFlare\Endpoints;

use CloudFlare\Contracts\CloudFlareResponse;
use CloudFlare\Endpoints\Zones\Cache;
use CloudFlare\Endpoints\Zones\CloudConnector;
use CloudFlare\Endpoints\Zones\DNS;
use CloudFlare\Endpoints\Zones\PageRules;
use CloudFlare\Configurations\Zones\CachePurge;

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
     * @return \CloudFlare\Contracts\CloudFlareResponse List zones of account found.
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
     * @param string $accountId Account Identifier.
     * @param string $name The domain name
     * @param string $type A full zone implies that DNS is hosted with Cloudflare. A partial zone is typically a partner-hosted zone or a CNAME setup.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse
     */
    public function create(string $accountId, string $name, string $type = 'full'): CloudFlareResponse
    {
        return $this->getHttpClient()->post('/zones', [
            'name' => $name,
            'account' => [
                'id' => $accountId
            ],
            'type' => $type
        ]);
    }

    /**
     * Delete Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-delete
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Delete Zone response.
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
     * @param string $zoneId Zone Identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Zone Details response.
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
     * @param string $zoneId Zone Identifier.
     * @param string $type A full zone implies that DNS is hosted with Cloudflare. A partial zone is typically a partner-hosted zone or a CNAME setup. This parameter is only available to Enterprise customers or if it has been explicitly enabled on a zone.
     * @param array $vanityNameServers An array of domains used for custom name servers. This is only available for Business and Enterprise plans.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse
     */
    public function update(string $zoneId, string $type, array $vanityNameServers = []): CloudFlareResponse
    {

        $options = [
            'type' => $type
        ];

        if(!empty($vanityNameServers)) {

            $options['vanity_name_servers'] = $vanityNameServers;
        }

        return $this->getHttpClient()->patch("/zones/{$zoneId}", $options);
    }

    /**
     * Triggeres a new activation check for a PENDING Zone. This can be triggered every 5 min for paygo/ent customers, every hour for FREE Zones.
     *
     * @link https://developers.cloudflare.com/api/operations/put-zones-zone_id-activation_check
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Activation Check Response
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
     * @param string $zoneId Zone Identifier.
     * @param array|\CloudFlare\Configurations\Zones\CachePurge $purgeBy
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Purge Cached Content Response
     */
    public function purge(string $zoneId, array|CachePurge $purgeBy): CloudFlareResponse
    {
        if(is_array($purgeBy)) {
            $this->requiredAnyParams(['files', 'tags', 'hosts', 'prefixes'], $purgeBy);
        } else {
            $purgeBy = $purgeBy->toArray();
        }

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
