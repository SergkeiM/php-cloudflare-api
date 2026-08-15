<?php

namespace Cloudflare\Endpoints\User\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Load balancer monitors owned by the authenticated user.
 *
 * The account-scoped counterpart is `$client->loadBalancers()->monitors()`,
 * which takes an account identifier.
 *
 * @link https://developers.cloudflare.com/load-balancing/understand-basics/monitors/
 */
class Monitors extends AbstractEndpoint
{
    /**
     * List the user's configured load balancer monitors.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @return ResponseInterface List monitors response
     */
    public function list(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/load_balancers/monitors');
    }

    /**
     * Create a new load balancer monitor for the user.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param array $values Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`.
     *
     * @return ResponseInterface Create a monitor response
     */
    public function create(array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/user/load_balancers/monitors', $values);
    }

    /**
     * Get a single configured load balancer monitor.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param string $monitorId Monitor Identifier.
     *
     * @return ResponseInterface Monitor details response
     */
    public function get(string $monitorId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/load_balancers/monitors/{$monitorId}");
    }

    /**
     * Update an existing load balancer monitor, overwriting the full configuration.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param string $monitorId Monitor Identifier.
     * @param array $values Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`.
     *
     * @return ResponseInterface Update a monitor response
     */
    public function update(string $monitorId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->put("/user/load_balancers/monitors/{$monitorId}", $values);
    }

    /**
     * Apply changes to an existing monitor, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param string $monitorId Monitor Identifier.
     * @param array $values Values to patch on the monitor.
     *
     * @return ResponseInterface Patch a monitor response
     */
    public function edit(string $monitorId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/user/load_balancers/monitors/{$monitorId}", $values);
    }

    /**
     * Delete a load balancer monitor.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param string $monitorId Monitor Identifier.
     *
     * @return ResponseInterface Delete a monitor response
     */
    public function delete(string $monitorId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/user/load_balancers/monitors/{$monitorId}");
    }

    /**
     * Preview pools associated with a given monitor and show the effective response.
     *
     * Answers with a preview identifier; read the result with
     * `$client->user()->loadBalancers()->preview()`.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param string $monitorId Monitor Identifier.
     * @param array $values The pools to run the preview on.
     *
     * @return ResponseInterface Preview monitor response
     */
    public function preview(string $monitorId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/user/load_balancers/monitors/{$monitorId}/preview", $values);
    }

    /**
     * List the load balancers and pools that reference a given monitor.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/load_balancers/
     *
     * @param string $monitorId Monitor Identifier.
     *
     * @return ResponseInterface List monitor references response
     */
    public function references(string $monitorId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/load_balancers/monitors/{$monitorId}/references");
    }
}
