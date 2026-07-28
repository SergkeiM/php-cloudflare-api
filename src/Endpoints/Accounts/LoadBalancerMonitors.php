<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class LoadBalancerMonitors extends AbstractEndpoint
{
    /**
     * List configured load balancer monitors for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-monitors-list-monitors
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface List monitors response
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/monitors");
    }

    /**
     * Create a new load balancer monitor for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-monitors-create-monitor
     *
     * @param string $accountId Account Identifier.
     * @param array $values Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`.
     *
     * @return ResponseInterface Create a monitor response
     */
    public function create(string $accountId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/load_balancers/monitors", $values);
    }

    /**
     * Get a single configured load balancer monitor for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-monitors-monitor-details
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorId Monitor Identifier.
     *
     * @return ResponseInterface Monitor details response
     */
    public function details(string $accountId, string $monitorId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/monitors/{$monitorId}");
    }

    /**
     * Update an existing load balancer monitor for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-monitors-update-monitor
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorId Monitor Identifier.
     * @param array $values Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`.
     *
     * @return ResponseInterface Update a monitor response
     */
    public function update(string $accountId, string $monitorId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/load_balancers/monitors/{$monitorId}", $values);
    }

    /**
     * Delete a load balancer monitor for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-monitors-delete-monitor
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorId Monitor Identifier.
     *
     * @return ResponseInterface Delete a monitor response
     */
    public function delete(string $accountId, string $monitorId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/load_balancers/monitors/{$monitorId}");
    }

    /**
     * Preview pools associated with a given monitor and show the effective response.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-monitors-preview-monitor
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorId Monitor Identifier.
     * @param array $values The pools to run the preview on.
     *
     * @return ResponseInterface Preview monitor response
     */
    public function preview(string $accountId, string $monitorId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/load_balancers/monitors/{$monitorId}/preview", $values);
    }
}
