<?php

namespace Cloudflare\Endpoints\Iam;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class PermissionGroups extends AbstractEndpoint
{
    /**
     * List all the permissions groups for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/permission_groups/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params, e.g. id, name, label.
     *
     * @return ResponseInterface List Permission Groups response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/permission_groups", $params);
    }

    /**
     * Get information about a specific permission group in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/permission_groups/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $permissionGroupId Permission Group identifier.
     *
     * @return ResponseInterface Permission Group Details response.
     */
    public function get(string $accountId, string $permissionGroupId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/permission_groups/{$permissionGroupId}");
    }
}
