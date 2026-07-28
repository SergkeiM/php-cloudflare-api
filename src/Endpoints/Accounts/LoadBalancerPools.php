<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class LoadBalancerPools extends AbstractEndpoint
{
    /**
     * List configured load balancer pools for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-list-pools
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface List pools response
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/pools");
    }

    /**
     * Create a new load balancer pool for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-create-pool
     *
     * @param string $accountId Account Identifier.
     * @param array $values Values to set on the pool, e.g. `name`, `origins`.
     *
     * @return ResponseInterface Create a pool response
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'origins'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/load_balancers/pools", $values);
    }

    /**
     * Get a single configured load balancer pool for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-pool-details
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface Pool details response
     */
    public function details(string $accountId, string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/pools/{$poolId}");
    }

    /**
     * Update an existing load balancer pool for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-update-pool
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     * @param array $values Values to set on the pool, e.g. `name`, `origins`.
     *
     * @return ResponseInterface Update a pool response
     */
    public function update(string $accountId, string $poolId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'origins'], $values);

        return $this->getHttpClient()->put("/accounts/{$accountId}/load_balancers/pools/{$poolId}", $values);
    }

    /**
     * Delete a load balancer pool for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-delete-pool
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface Delete a pool response
     */
    public function delete(string $accountId, string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/load_balancers/pools/{$poolId}");
    }

    /**
     * Fetch the latest pool health status for a single pool.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-pool-health-details
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface Pool health details response
     */
    public function health(string $accountId, string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/pools/{$poolId}/health");
    }

    /**
     * Preview pool health using the specified monitor and show the effective response.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-pools-preview-pool
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     * @param array $values The monitor details to run the preview with.
     *
     * @return ResponseInterface Preview pool response
     */
    public function preview(string $accountId, string $poolId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/load_balancers/pools/{$poolId}/preview", $values);
    }

    /**
     * Apply changes to an existing pool, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/operations/account-load-balancer-pools-patch-pool
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     * @param array $values Values to patch on the pool.
     *
     * @return ResponseInterface Patch a pool response
     */
    public function patch(string $accountId, string $poolId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/load_balancers/pools/{$poolId}", $values);
    }

    /**
     * Apply changes to a number of existing pools, overwriting the supplied properties. Returns the list of affected pools.
     *
     * @link https://developers.cloudflare.com/api/operations/account-load-balancer-pools-patch-pools
     *
     * @param string $accountId Account Identifier.
     * @param array $values List of pool patches to apply, each identified by `id`.
     *
     * @return ResponseInterface Patch pools response
     */
    public function patchMultiplePools(string $accountId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/load_balancers/pools", $values);
    }

    /**
     * List the load balancers that reference a given pool.
     *
     * @link https://developers.cloudflare.com/api/operations/account-load-balancer-pools-list-pool-references
     *
     * @param string $accountId Account Identifier.
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface List pool references response
     */
    public function references(string $accountId, string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/pools/{$poolId}/references");
    }
}
