<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;

class Hold extends AbstractEndpoint
{
    /**
     * Retrieve whether the zone is subject to a zone hold, and metadata about the hold.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-hold-get
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\CloudflareResponse Successful Response
     */
    public function details(string $zoneId): CloudflareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/hold");
    }

    /**
     * Enforce a zone hold on the zone, blocking the creation and activation of zones with this zone's hostname.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-hold-post
     *
     * @param string $zoneId Zone Identifier.
     * @param bool $includeSubdomains If provided, the zone hold will extend to block any subdomain of the given zone, as well as SSL4SaaS Custom Hostnames. For example, a zone hold on a zone with the hostname 'example.com' and include_subdomains=true will block 'example.com', 'staging.example.com', 'api.staging.example.com', etc.
     *
     * @return \Cloudflare\Contracts\CloudflareResponse Successful Response
     */
    public function create(string $zoneId, bool $includeSubdomains = true): CloudflareResponse
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/hold", [
            'include_subdomains' => $includeSubdomains
        ]);
    }

    /**
     * Stop enforcement of a zone hold on the zone, permanently or temporarily, allowing the creation and activation of zones with this zone's hostname.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-hold-delete
     *
     * @param string $zoneId Zone Identifier.
     * @param string $holdAfter If provided, the hold will be temporarily disabled, then automatically re-enabled by the system at the time specified in this RFC3339-formatted timestamp. Otherwise, the hold will be disabled indefinitely.
     * @return \Cloudflare\Contracts\CloudflareResponse Successful Response
     */
    public function delete(string $zoneId, string $holdAfter = null): CloudflareResponse
    {
        $values = [];

        if(!is_null($holdAfter)) {
            $values = [
                'hold_after' => $holdAfter
            ];
        }

        return $this->getHttpClient()->delete("/zones/{$zoneId}/hold", $values, format: 'query');
    }
}
