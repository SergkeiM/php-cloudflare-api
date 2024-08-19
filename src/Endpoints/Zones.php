<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\CloudflareResponse;
use Cloudflare\Endpoints\Zones\Cache;
use Cloudflare\Endpoints\Zones\CloudConnector;
use Cloudflare\Endpoints\Zones\DNS;
use Cloudflare\Endpoints\Zones\PageRules;
use Cloudflare\Endpoints\Zones\Hold;
use Cloudflare\Endpoints\Zones\Lockdown;
use Cloudflare\Configurations\Zones\CachePurge;

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
     * @return \Cloudflare\Contracts\CloudflareResponse List zones of account found.
     */
    public function list(array $params = []): CloudflareResponse
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
     * @return \Cloudflare\Contracts\CloudflareResponse
     */
    public function create(string $accountId, string $name, string $type = 'full'): CloudflareResponse
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
     * @return \Cloudflare\Contracts\CloudflareResponse Delete Zone response.
     */
    public function delete(string $zoneId): CloudflareResponse
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
     * @return \Cloudflare\Contracts\CloudflareResponse Zone Details response.
     */
    public function details(string $zoneId): CloudflareResponse
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
     * @return \Cloudflare\Contracts\CloudflareResponse
     */
    public function update(string $zoneId, string $type, array $vanityNameServers = []): CloudflareResponse
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
     * @return \Cloudflare\Contracts\CloudflareResponse Activation Check Response
     */
    public function activationCheck(string $zoneId): CloudflareResponse
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/activation_check");
    }

    /**
     * Purge Cached Content
     *
     * @link https://developers.cloudflare.com/api/operations/zone-purge
     *
     * @param string $zoneId Zone Identifier.
     * @param array|\Cloudflare\Configurations\Zones\CachePurge $purgeBy
     *
     * @return \Cloudflare\Contracts\CloudflareResponse Purge Cached Content Response
     */
    public function purge(string $zoneId, array|CachePurge $purgeBy): CloudflareResponse
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
     * @return \Cloudflare\Endpoints\Zones\Cache
     */
    public function cache(): Cache
    {
        return new Cache($this->getClient());
    }

    /**
     * Zone Cloud Connector rules
     *
     * @return \Cloudflare\Endpoints\Zones\CloudConnector
     */
    public function cloudConnector(): CloudConnector
    {
        return new CloudConnector($this->getClient());
    }

    /**
     * Zone DNS
     *
     * @return \Cloudflare\Endpoints\Zones\DNS
     */
    public function dns(): DNS
    {
        return new DNS($this->getClient());
    }

    /**
     * Zone PageRules
     *
     * @return \Cloudflare\Endpoints\Zones\PageRules
     */
    public function pageRules(): PageRules
    {
        return new PageRules($this->getClient());
    }

    /**
     * Zone Holds
     *
     * @return \Cloudflare\Endpoints\Zones\Hold
     */
    public function holds(): Hold
    {
        return new Hold($this->getClient());
    }

    /**
     * Zone Lockdown
     *
     * @return \Cloudflare\Endpoints\Zones\Lockdown
     */
    public function lockdowns(): Hold
    {
        return new Lockdown($this->getClient());
    }
}
