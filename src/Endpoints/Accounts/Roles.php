<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Roles extends AbstractEndpoint
{
    /**
     * Get all available roles for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-roles-list-roles
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Roles response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/roles", $params);
    }

    /**
     * Get information about a specific role for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-roles-role-details
     *
     * @param string $accountId Account identifier.
     * @param string $roleId Role identifier.
     *
     * @return ResponseInterface Role Details response
     */
    public function details(string $accountId, string $roleId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/roles/{$roleId}");
    }
}
