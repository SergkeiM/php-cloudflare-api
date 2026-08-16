<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Zones\Holds;
use Cloudflare\Endpoints\Zones\Settings;
use Cloudflare\Endpoints\Zones\Subscriptions;
use Cloudflare\Endpoints\Zones\TransformationFlows;
use Cloudflare\Configurations\Zones\CachePurge;

/**
 * @link https://developers.cloudflare.com/api/resources/zones/methods/list/
 */
class Zones extends AbstractEndpoint
{
    /**
     * Lists, searches, sorts, and filters your zones. Listing zones across more than 500 accounts is currently not allowed.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/methods/list/
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List Zones response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        $params = array_merge($params, [
            'account' => array_merge($params['account'] ?? [], [
                'id' => $accountId
            ])
        ]);

        return $this->getHttpClient()->get('/zones', $params);
    }

    /**
     * Create Zone
     *
     * @link https://developers.cloudflare.com/api/resources/zones/methods/create/
     *
     * The account is taken from `$accountId`; everything else comes from `$values`.
     *
     * @param string $accountId Account Identifier.
     * @param array $values `name`, the domain name, is required. `type` is `full` when Cloudflare hosts the DNS, or `partial` for a partner-hosted or CNAME setup.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->post('/zones', array_merge([
            'account' => ['id' => $accountId],
        ], $values));
    }

    /**
     * Zone Details
     *
     * @link https://developers.cloudflare.com/api/resources/zones/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Zone Details response.
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}");
    }

    /**
     * Delete Zone
     *
     * @link https://developers.cloudflare.com/api/resources/zones/methods/delete/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete Zone response.
     */
    public function delete(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}");
    }

    /**
     * Edit Zone
     *
     * @link https://developers.cloudflare.com/api/resources/zones/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Any of `type` (`full` or `partial`, Enterprise-only unless enabled on the zone), `vanity_name_servers` (Business and Enterprise plans), `paused` and `plan`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function edit(string $zoneId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}", $values);
    }

    /**
     * Triggeres a new activation check for a PENDING Zone. This can be triggered every 5 min for paygo/ent customers, every hour for FREE Zones.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/activation_check/methods/trigger/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Activation Check Response
     */
    public function activationCheck(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/activation_check");
    }

    /**
     * Purge Cached Content
     *
     * @link https://developers.cloudflare.com/api/resources/cache/methods/purge/
     *
     * @param string $zoneId Zone Identifier.
     * @param array|\Cloudflare\Configurations\Zones\CachePurge $purgeBy
     *
     * @return \Cloudflare\Contracts\ResponseInterface Purge Cached Content Response
     */
    public function purge(string $zoneId, array|CachePurge $purgeBy): ResponseInterface
    {
        if (is_array($purgeBy)) {
            $this->requiredAnyParams(['files', 'tags', 'hosts', 'prefixes'], $purgeBy);
        } else {
            $purgeBy = $purgeBy->toArray();
        }

        return $this->getHttpClient()->post("/zones/{$zoneId}/purge_cache", $purgeBy);
    }

    /**
     * Zone Holds
     *
     * @return \Cloudflare\Endpoints\Zones\Holds
     */
    public function holds(): Holds
    {
        return new Holds($this->getClient());
    }

    /**
     * Zone Settings
     *
     * @return \Cloudflare\Endpoints\Zones\Settings
     */
    public function settings(): Settings
    {
        return new Settings($this->getClient());
    }

    /**
     * Zone Subscriptions
     *
     * @return \Cloudflare\Endpoints\Zones\Subscriptions
     */
    public function subscriptions(): Subscriptions
    {
        return new Subscriptions($this->getClient());
    }

    /**
     * Zone Image Transformation Flows
     *
     * @return \Cloudflare\Endpoints\Zones\TransformationFlows
     */
    public function transformationFlows(): TransformationFlows
    {
        return new TransformationFlows($this->getClient());
    }
}
