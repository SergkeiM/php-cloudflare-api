<?php

namespace Cloudflare\Endpoints\User\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Load balancer pools owned by the authenticated user.
 *
 * The account-scoped counterpart is `$client->loadBalancers()->pools()`, which
 * takes an account identifier.
 *
 * @link https://developers.cloudflare.com/load-balancing/understand-basics/pools/
 */
class Pools extends AbstractEndpoint
{
    /**
     * List the user's configured load balancer pools.
     *
     * @param array $params Query Parameters: `monitor`, to list only the pools using a given monitor.
     *
     * @return ResponseInterface List pools response
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/load_balancers/pools', $params);
    }

    /**
     * Create a new load balancer pool for the user.
     *
     * @param array $values Values to set on the pool, e.g. `name`, `origins`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Create a pool response
     */
    public function create(array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'origins'], $values);

        return $this->getHttpClient()->post('/user/load_balancers/pools', $values);
    }

    /**
     * Get a single configured load balancer pool.
     *
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface Pool details response
     */
    public function get(string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/load_balancers/pools/{$poolId}");
    }

    /**
     * Update an existing load balancer pool, overwriting the full configuration.
     *
     * @param string $poolId Pool Identifier.
     * @param array $values Values to set on the pool, e.g. `name`, `origins`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Update a pool response
     */
    public function update(string $poolId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'origins'], $values);

        return $this->getHttpClient()->put("/user/load_balancers/pools/{$poolId}", $values);
    }

    /**
     * Apply changes to an existing pool, overwriting only the supplied properties.
     *
     * @param string $poolId Pool Identifier.
     * @param array $values Values to patch on the pool.
     *
     * @return ResponseInterface Patch a pool response
     */
    public function edit(string $poolId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/user/load_balancers/pools/{$poolId}", $values);
    }

    /**
     * Apply changes to a number of existing pools, overwriting the supplied properties.
     *
     * Returns the list of affected pools.
     *
     * @param array $values List of pool patches to apply, each identified by `id`.
     *
     * @return ResponseInterface Patch pools response
     */
    public function bulkEdit(array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch('/user/load_balancers/pools', $values);
    }

    /**
     * Delete a load balancer pool.
     *
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface Delete a pool response
     */
    public function delete(string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/user/load_balancers/pools/{$poolId}");
    }

    /**
     * Fetch the latest pool health status for a single pool.
     *
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface Pool health details response
     */
    public function health(string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/load_balancers/pools/{$poolId}/health");
    }

    /**
     * Preview pool health using the specified monitor and show the effective response.
     *
     * Answers with a preview identifier; read the result with
     * `$client->user()->loadBalancers()->preview()`.
     *
     * @param string $poolId Pool Identifier.
     * @param array $values The monitor details to run the preview with.
     *
     * @return ResponseInterface Preview pool response
     */
    public function preview(string $poolId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/user/load_balancers/pools/{$poolId}/preview", $values);
    }

    /**
     * List the load balancers that reference a given pool.
     *
     * @param string $poolId Pool Identifier.
     *
     * @return ResponseInterface List pool references response
     */
    public function references(string $poolId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/load_balancers/pools/{$poolId}/references");
    }
}
