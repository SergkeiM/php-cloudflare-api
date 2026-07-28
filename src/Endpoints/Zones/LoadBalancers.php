<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class LoadBalancers extends AbstractEndpoint
{
    /**
     * List configured load balancers for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-level-load-balancers-list-load-balancers
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface List load balancers response
     */
    public function list(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/load_balancers");
    }

    /**
     * Create a new load balancer for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-level-load-balancers-create-load-balancer
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`.
     *
     * @return ResponseInterface Create a load balancer response
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'default_pools', 'fallback_pool'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/load_balancers", $values);
    }

    /**
     * Get a single configured load balancer for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-level-load-balancers-load-balancer-details
     *
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     *
     * @return ResponseInterface Load balancer details response
     */
    public function details(string $zoneId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Update an existing load balancer for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-level-load-balancers-update-load-balancer
     *
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array $values Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`.
     *
     * @return ResponseInterface Update a load balancer response
     */
    public function update(string $zoneId, string $loadBalancerId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'default_pools', 'fallback_pool'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/load_balancers/{$loadBalancerId}", $values);
    }

    /**
     * Delete a load balancer for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-level-load-balancers-delete-load-balancer
     *
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     *
     * @return ResponseInterface Delete a load balancer response
     */
    public function delete(string $zoneId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Apply changes to an existing load balancer, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancers-patch-load-balancer
     *
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array $values Values to patch on the load balancer.
     *
     * @return ResponseInterface Patch a load balancer response
     */
    public function patch(string $zoneId, string $loadBalancerId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/load_balancers/{$loadBalancerId}", $values);
    }
}
