<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class LoadBalancers extends AbstractEndpoint
{
    /**
     * List configured load balancers for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-level-load-balancers-list-load-balancers
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface List load balancers response
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers");
    }

    /**
     * Create a new load balancer for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-level-load-balancers-create-load-balancer
     *
     * @param string $accountId Account Identifier.
     * @param array $values Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`.
     *
     * @return ResponseInterface Create a load balancer response
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'default_pools', 'fallback_pool'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/load_balancers", $values);
    }

    /**
     * Get a single configured load balancer for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-level-load-balancers-load-balancer-details
     *
     * @param string $accountId Account Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     *
     * @return ResponseInterface Load balancer details response
     */
    public function details(string $accountId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/{$loadBalancerId}");
    }

    /**
     * Update an existing load balancer for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-level-load-balancers-update-load-balancer
     *
     * @param string $accountId Account Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     * @param array $values Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`.
     *
     * @return ResponseInterface Update a load balancer response
     */
    public function update(string $accountId, string $loadBalancerId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'default_pools', 'fallback_pool'], $values);

        return $this->getHttpClient()->put("/accounts/{$accountId}/load_balancers/{$loadBalancerId}", $values);
    }

    /**
     * Delete a load balancer for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-level-load-balancers-delete-load-balancer
     *
     * @param string $accountId Account Identifier.
     * @param string $loadBalancerId Load Balancer Identifier.
     *
     * @return ResponseInterface Delete a load balancer response
     */
    public function delete(string $accountId, string $loadBalancerId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/load_balancers/{$loadBalancerId}");
    }
}
