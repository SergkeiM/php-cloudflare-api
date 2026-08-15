<?php

namespace Cloudflare\Endpoints\Iam;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class ResourceGroups extends AbstractEndpoint
{
    /**
     * List all the resource groups for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/resource_groups/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params, e.g. id, name.
     *
     * @return ResponseInterface List Resource Groups response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/resource_groups", $params);
    }

    /**
     * Create a new Resource Group under the specified account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/resource_groups/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param array $values Resource Group values, requires name and scope.
     *
     * @return ResponseInterface Create Resource Group response.
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'scope'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/iam/resource_groups", $values);
    }

    /**
     * Get information about a specific resource group in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/resource_groups/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $resourceGroupId Resource Group identifier.
     *
     * @return ResponseInterface Resource Group Details response.
     */
    public function get(string $accountId, string $resourceGroupId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/resource_groups/{$resourceGroupId}");
    }

    /**
     * Modify an existing resource group.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/resource_groups/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $resourceGroupId Resource Group identifier.
     * @param array $values Resource Group values, e.g. name, scope.
     *
     * @return ResponseInterface Update Resource Group response.
     */
    public function update(string $accountId, string $resourceGroupId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/iam/resource_groups/{$resourceGroupId}", $values);
    }

    /**
     * Remove a resource group from an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/resource_groups/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $resourceGroupId Resource Group identifier.
     *
     * @return ResponseInterface Delete Resource Group response.
     */
    public function delete(string $accountId, string $resourceGroupId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/iam/resource_groups/{$resourceGroupId}");
    }
}
