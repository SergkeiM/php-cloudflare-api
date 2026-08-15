<?php

namespace Cloudflare\Endpoints\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class MonitorGroups extends AbstractEndpoint
{
    /**
     * List configured load balancer monitor groups for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/list/
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface List monitor groups response
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/monitor_groups");
    }

    /**
     * Create a new load balancer monitor group for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/create/
     *
     * @param string $accountId Account Identifier.
     * @param array $values Values to set on the monitor group, e.g. `description`, `members`.
     *
     * @return ResponseInterface Create a monitor group response
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['description', 'members'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/load_balancers/monitor_groups", $values);
    }

    /**
     * Get a single configured load balancer monitor group for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/get/
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorGroupId Monitor Group Identifier.
     *
     * @return ResponseInterface Monitor group details response
     */
    public function get(string $accountId, string $monitorGroupId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/monitor_groups/{$monitorGroupId}");
    }

    /**
     * Apply changes to an existing monitor group, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/edit/
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorGroupId Monitor Group Identifier.
     * @param array $values Values to patch on the monitor group.
     *
     * @return ResponseInterface Patch a monitor group response
     */
    public function edit(string $accountId, string $monitorGroupId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/load_balancers/monitor_groups/{$monitorGroupId}", $values);
    }

    /**
     * Update an existing load balancer monitor group for an account, overwriting the full configuration.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/update/
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorGroupId Monitor Group Identifier.
     * @param array $values Values to set on the monitor group, e.g. `description`, `members`.
     *
     * @return ResponseInterface Update a monitor group response
     */
    public function update(string $accountId, string $monitorGroupId, array $values): ResponseInterface
    {
        $this->requiredParams(['description', 'members'], $values);

        return $this->getHttpClient()->put("/accounts/{$accountId}/load_balancers/monitor_groups/{$monitorGroupId}", $values);
    }

    /**
     * Delete a load balancer monitor group for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/delete/
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorGroupId Monitor Group Identifier.
     *
     * @return ResponseInterface Delete a monitor group response
     */
    public function delete(string $accountId, string $monitorGroupId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/load_balancers/monitor_groups/{$monitorGroupId}");
    }

    /**
     * List the pools that reference a given monitor group.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/subresources/references/methods/get/
     *
     * @param string $accountId Account Identifier.
     * @param string $monitorGroupId Monitor Group Identifier.
     *
     * @return ResponseInterface List monitor group references response
     */
    public function references(string $accountId, string $monitorGroupId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/monitor_groups/{$monitorGroupId}/references");
    }
}
