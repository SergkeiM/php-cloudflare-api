<?php

namespace Cloudflare\Endpoints\Firewall;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Lockdowns extends AbstractEndpoint
{
    /**
     * Fetches Zone Lockdown rules. You can filter the results using several optional parameters.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/list/
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
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/create/
     *
     * ```php
     * $client->firewall()->lockdowns()->create('ZONE_ID', [
     *     'urls' => ['example.com/admin*'],
     *     'configurations' => [
     *         ['target' => 'ip', 'value' => '198.51.100.4'],
     *         ['target' => 'country', 'value' => 'US'],
     *     ],
     *     'description' => 'Admin area',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/create/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values `urls` and `configurations` are required. Each configuration is `['target' => …, 'value' => …]`, where the target is `ip`, `ip_range`, `asn` or `country`. `description`, `priority` and `paused` are optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create a Zone Lockdown rule response.
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['urls', 'configurations'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/firewall/lockdowns", $values);
    }

    /**
     * Fetches the details of a Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $lockdownId Lockdown identifier
     * .
     * @return \Cloudflare\Contracts\ResponseInterface Get a Zone Lockdown rule response
     */
    public function get(string $zoneId, string $lockdownId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/lockdowns/{$lockdownId}");
    }

    /**
     * Updates an existing Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/update/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $lockdownId Lockdown identifier
     * @param array $values `urls` and `configurations` are required, in the same shape as `create()`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update a Zone Lockdown rule response
     */
    public function update(string $zoneId, string $lockdownId, array $values): ResponseInterface
    {
        $this->requiredParams(['urls', 'configurations'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/firewall/lockdowns/{$lockdownId}", $values);
    }

    /**
     * Deletes an existing Zone Lockdown rule.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/delete/
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
