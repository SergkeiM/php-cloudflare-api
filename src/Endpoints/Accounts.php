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
     * @return \CloudFlare\Contracts\CloudFlareResponse List Accounts response.
     */
    public function list(array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get('/accounts', $params);
    }

    /**
     * Create an account (only available for tenant admins at this time)
     *
     * @link https://developers.cloudflare.com/api/operations/account-creation
     *
     * @param string $name Account name
     * @param string $type The type of account being created. For self-serve customers, use standard. for enterprise customers, use enterprise.
     * @param string $unit Tenant unit ID. Information related to the tenant unit, and optionally, an id of the unit to create the account on. [see](https://developers.cloudflare.com/tenant/how-to/manage-accounts/)
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse
     */
    public function create(string $name, string $type, string $unit = null): CloudFlareResponse
    {
        $values = [
            'name' => $name,
            'type' => $type
        ];

        if(!is_null($unit)) {
            $values['unit'] = [
                'id' => $unit
            ];
        }

        return $this->getHttpClient()->post("/accounts", $values);
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-account-details
     *
     * @param string $accountId Account identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Account Details response.
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
     * @param string $name Account name.
     * @param array $settings Account settings.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Update Account response.
     */
    public function update(string $accountId, string $name, array $settings = []): CloudFlareResponse
    {

        $values = [
            'name' => $name,
        ];

        if(!empty($settings)) {
            $values['settings'] = $settings;
        }

        return $this->getHttpClient()->put("/accounts/{$accountId}", $values);
    }

    /**
     * Delete a specific account (only available for tenant admins at this time). This is a permanent operation that will delete any zones or other resources under the account
     *
     * @link https://developers.cloudflare.com/api/operations/account-deletion
     *
     * @param string $accountIdAccount identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse
     */
    public function delete(string $accountId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}");
    }

    /**
     * Account Roles
     *
     * @return \CloudFlare\Endpoints\Accounts\Roles
     */
    public function roles(): Roles
    {
        return new Roles($this->getClient());
    }

    /**
     * Account Members
     *
     * @return \CloudFlare\Endpoints\Accounts\Members
     */
    public function members(): Members
    {
        return new Members($this->getClient());
    }

    /**
     * Account audit logs
     *
     * @return \CloudFlare\Endpoints\Accounts\AuditLogs
     */
    public function auditLogs(): AuditLogs
    {
        return new AuditLogs($this->getClient());
    }
}
