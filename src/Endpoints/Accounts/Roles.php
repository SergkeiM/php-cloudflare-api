<?php

namespace SergkeiM\CloudFlare\Endpoints\Accounts;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;

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
     * @return CloudFlareResponse List Roles response.
     */
    public function list(string $accountId, array $params = []): CloudFlareResponse
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
     * @return CloudFlareResponse Role Details response
     */
    public function details(string $accountId, string $roleId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/roles/{$roleId}");
    }
}