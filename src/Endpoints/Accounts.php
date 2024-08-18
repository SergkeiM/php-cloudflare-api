<?php

namespace CloudFlare\Endpoints;

use CloudFlare\Contracts\CloudFlareResponse;
use CloudFlare\Endpoints\Accounts\Roles;
use CloudFlare\Endpoints\Accounts\Members;
use CloudFlare\Endpoints\Accounts\AuditLogs;

/**
 * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
 */
class Accounts extends AbstractEndpoint
{
    /**
     * List all accounts you have ownership or verified access to.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
     *
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse List Accounts response.
     */
    public function list(array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get('/accounts', $params);
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-account-details
     *
     * @param string $accountId Account identifier.
     *
     * @return CloudFlareResponse Account Details response.
     */
    public function details(string $accountId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}");
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-update-account
     *
     * @param string $accountId Account identifier.
     * @param array $values Values to set on account.
     *
     * @return CloudFlareResponse Update Account response.
     */
    public function update(string $accountId, array $values): CloudFlareResponse
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->put("/accounts/{$accountId}", $values);
    }

    /**
     * Account Roles
     *
     * @return Roles
     */
    public function roles(): Roles
    {
        return new Roles($this->getClient());
    }

    /**
     * Account Members
     *
     * @return Members
     */
    public function members(): Members
    {
        return new Members($this->getClient());
    }

    /**
     * Account audit logs
     *
     * @return AuditLogs
     */
    public function auditLogs(): AuditLogs
    {
        return new AuditLogs($this->getClient());
    }
}
