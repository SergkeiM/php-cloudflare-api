<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Lockdown extends AbstractEndpoint
{
    /**
     * Fetches Zone Lockdown rules. You can filter the results using several optional parameters.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-lockdown-list-zone-lockdown-rules
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters
     *
     * @return \Cloudflare\Contracts\ResponseInterface List Zone Lockdown rules response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/lockdowns", $params);
    }

    /**
     * Creates a new Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-lockdown-create-a-zone-lockdown-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $value The IP address/range to match. You can only use prefix lengths /16 and /24. This address/range will be compared to the IP address of incoming requests.
     * @param array $urls The URLs to include in the current WAF override. You can use wildcards. Each entered URL will be escaped before use, which means you can only use simple wildcard patterns.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create a Zone Lockdown rule response.
     */
    public function create(string $zoneId, string $value, array $urls): ResponseInterface
    {
        $values = [
            'urls' => $urls,
            'configurations' => [
                'target' => str_contains($value, '/') ? 'ip_range' : 'ip',
                'value' => $value
            ]
        ];

        return $this->getHttpClient()->post("/zones/{$zoneId}/firewall/lockdowns", $values);
    }

    /**
     * Fetches the details of a Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-lockdown-get-a-zone-lockdown-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $lockdownId Lockdown identifier
     * .
     * @return \Cloudflare\Contracts\ResponseInterface Get a Zone Lockdown rule response
     */
    public function details(string $zoneId, string $lockdownId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/lockdowns/{$lockdownId}");
    }

    /**
     * Updates an existing Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-lockdown-update-a-zone-lockdown-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $lockdownId Lockdown identifier
     * @param string $value The IP address/range to match. You can only use prefix lengths /16 and /24. This address/range will be compared to the IP address of incoming requests.
     * @param array $urls The URLs to include in the current WAF override. You can use wildcards. Each entered URL will be escaped before use, which means you can only use simple wildcard patterns.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update a Zone Lockdown rule response
     */
    public function update(string $zoneId, string $lockdownId, string $value, array $urls): ResponseInterface
    {
        $values = [
            'urls' => $urls,
            'configurations' => [
                'target' => str_contains($value, '/') ? 'ip_range' : 'ip',
                'value' => $value
            ]
        ];

        return $this->getHttpClient()->put("/zones/{$zoneId}/firewall/lockdowns/{$lockdownId}", $values);
    }

    /**
     * Deletes an existing Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-lockdown-delete-a-zone-lockdown-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $lockdownId Lockdown identifier
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete a Zone Lockdown rule response
     */
    public function delete(string $zoneId, string $lockdownId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/firewall/lockdowns/{$lockdownId}");
    }
}
