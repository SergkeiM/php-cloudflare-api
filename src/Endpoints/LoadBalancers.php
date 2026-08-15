<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\LoadBalancers\Pools;
use Cloudflare\Endpoints\LoadBalancers\Monitors;
use Cloudflare\Endpoints\LoadBalancers\MonitorGroups;
use Cloudflare\Endpoints\LoadBalancers\Regions;
use Cloudflare\Endpoints\LoadBalancers\Searches;
use Cloudflare\Endpoints\LoadBalancers\Previews;

/**
 * Load balancers distribute traffic across your origin servers to reduce
 * response time and increase availability. A load balancer is scoped to
 * either an account or a zone: pass exactly one of $accountId or $zoneId.
 */
class LoadBalancers extends AbstractEndpoint
{
    /**
     * List configured load balancers.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     *
     * @return ResponseInterface List load balancers response
     */
    public function list(?string $accountId = null, ?string $zoneId = null): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/load_balancers");
    }

    /**
     * Create a new load balancer.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param array $values Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`.
     *
     * @return ResponseInterface Create a load balancer response
     */
    public function create(?string $accountId, ?string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'default_pools', 'fallback_pool'], $values);

        return $this->getHttpClient()->post("{$this->scopePath($accountId, $zoneId)}/load_balancers", $values);
    }

    /**
     * Get a single configured load balancer.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $loadBalancerId Load Balancer Identifier.
     *
     * @return ResponseInterface Load balancer details response
     */
    public function get(?string $accountId, ?string $zoneId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Update an existing load balancer, overwriting the full configuration.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array $values Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`.
     *
     * @return ResponseInterface Update a load balancer response
     */
    public function update(?string $accountId, ?string $zoneId, string $loadBalancerId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'default_pools', 'fallback_pool'], $values);

        return $this->getHttpClient()->put("{$this->scopePath($accountId, $zoneId)}/load_balancers/{$loadBalancerId}", $values);
    }

    /**
     * Apply changes to an existing load balancer, overwriting only the supplied properties.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array $values Values to patch on the load balancer.
     *
     * @return ResponseInterface Patch a load balancer response
     */
    public function edit(?string $accountId, ?string $zoneId, string $loadBalancerId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("{$this->scopePath($accountId, $zoneId)}/load_balancers/{$loadBalancerId}", $values);
    }

    /**
     * Delete a load balancer.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $loadBalancerId Load Balancer Identifier.
     *
     * @return ResponseInterface Delete a load balancer response
     */
    public function delete(?string $accountId, ?string $zoneId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->delete("{$this->scopePath($accountId, $zoneId)}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Fetch the current load balancer usage for an account.
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface List load balancer usage response
     */
    public function usage(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/usage");
    }

    /**
     * Load Balancer Pools
     *
     * @return \Cloudflare\Endpoints\LoadBalancers\Pools
     */
    public function pools(): Pools
    {
        return new Pools($this->getClient());
    }

    /**
     * Load Balancer Monitors
     *
     * @return \Cloudflare\Endpoints\LoadBalancers\Monitors
     */
    public function monitors(): Monitors
    {
        return new Monitors($this->getClient());
    }

    /**
     * Load Balancer Monitor Groups
     *
     * @return \Cloudflare\Endpoints\LoadBalancers\MonitorGroups
     */
    public function monitorGroups(): MonitorGroups
    {
        return new MonitorGroups($this->getClient());
    }

    /**
     * Load Balancer Regions
     *
     * @return \Cloudflare\Endpoints\LoadBalancers\Regions
     */
    public function regions(): Regions
    {
        return new Regions($this->getClient());
    }

    /**
     * Load Balancer Resource Search
     *
     * @return \Cloudflare\Endpoints\LoadBalancers\Searches
     */
    public function searches(): Searches
    {
        return new Searches($this->getClient());
    }

    /**
     * Load Balancer Monitor/Pool Preview Results
     *
     * @return \Cloudflare\Endpoints\LoadBalancers\Previews
     */
    public function previews(): Previews
    {
        return new Previews($this->getClient());
    }
}
