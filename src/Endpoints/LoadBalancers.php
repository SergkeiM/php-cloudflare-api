<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\LoadBalancers\HealthCheck;
use Cloudflare\Endpoints\LoadBalancers\Monitors;
use Cloudflare\Endpoints\LoadBalancers\Pools;
use Cloudflare\Endpoints\LoadBalancers\Regions;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\LoadBalancers\LoadBalancer;

class LoadBalancers extends AbstractEndpoint
{
    /**
     * List configured load balancers.
     * 
     * @link https://developers.cloudflare.com/api/operations/load-balancers-list-load-balancers
     * 
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters
     * 
     * @return \Cloudflare\Contracts\ResponseInterface List Load Balancers response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/${zoneId}/load_balancers", $params);
    }

    /**
     * Create a new load balancer.
     * 
     * @link https://developers.cloudflare.com/api/operations/load-balancers-create-load-balancer
     * 
     * @param string $zoneId Zone Identifier.
     * @param array|\Cloudflare\Configurations\LoadBalancers\LoadBalancer $values Values to set on LoadBalancer.
     * 
     * @return \Cloudflare\Contracts\ResponseInterface Create Load Balancer response
     */
    public function create(string $zoneId, array|LoadBalancer $values): ResponseInterface
    {

        if(is_array($values)) {
            $this->requiredParams(['default_pools', 'fallback_pool', 'name'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->post("/zones/${zoneId}/load_balancers", $values);
    }

    /**
     * Fetch a single configured load balancer.
     * 
     * @link https://developers.cloudflare.com/api/operations/load-balancers-load-balancer-details
     * 
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * 
     * @return \Cloudflare\Contracts\ResponseInterface Load Balancer Details response
     */
    public function details(string $zoneId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/${zoneId}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Update a configured load balancer.
     * 
     * @link https://developers.cloudflare.com/api/operations/load-balancers-update-load-balancer
     * 
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array|\Cloudflare\Configurations\LoadBalancers\LoadBalancer $values Values to set on LoadBalancer.
     * 
     * @return \Cloudflare\Contracts\ResponseInterface Update Load Balancer response
     */
    public function update(string $zoneId, string $loadBalancerId, array|LoadBalancer $values): ResponseInterface
    {

        if(is_array($values)) {
            $this->requiredParams(['default_pools', 'fallback_pool', 'name'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->put("/zones/${zoneId}/load_balancers/{$loadBalancerId}", $values);
    }

    /**
     * Apply changes to an existing load balancer, overwriting the supplied properties.
     * 
     * @link https://developers.cloudflare.com/api/operations/load-balancers-patch-load-balancer
     * 
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array|\Cloudflare\Configurations\LoadBalancers\LoadBalancer $values Values to set on LoadBalancer.
     * 
     * @return \Cloudflare\Contracts\ResponseInterface Overwrite Load Balancer response
     */
    public function overwrite(string $zoneId, string $loadBalancerId, array|LoadBalancer $values): ResponseInterface
    {

        if(is_array($values)) {
            $this->requiredParams(['default_pools', 'fallback_pool', 'name'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->patch("/zones/${zoneId}/load_balancers/{$loadBalancerId}", $values);
    }

    /**
     * Delete a configured load balancer.
     * 
     * @link https://developers.cloudflare.com/api/operations/load-balancers-delete-load-balancer
     * 
     * @param string $zoneId Zone Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * 
     * @return \Cloudflare\Contracts\ResponseInterface Delete Load Balancer response
     */
    public function delete(string $zoneId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/${zoneId}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Healthcheck Events
     * @return \Cloudflare\Endpoints\LoadBalancers\HealthCheck
     */
    public function healthCheck(): HealthCheck
    {
        return new HealthCheck($this->getClient());
    }

    /**
     * Monitors
     * @return \Cloudflare\Endpoints\LoadBalancers\Monitors
     */
    public function monitors(): Monitors
    {
        return new Monitors($this->getClient());
    }

    /**
     * Pools
     * @return \Cloudflare\Endpoints\LoadBalancers\Pools
     */
    public function pools(): Pools
    {
        return new Pools($this->getClient());
    }

    /**
     * Regions
     * @return \Cloudflare\Endpoints\LoadBalancers\Regions
     */
    public function regions(): Regions
    {
        return new Regions($this->getClient());
    }
}