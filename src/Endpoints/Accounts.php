<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Accounts\Roles;
use Cloudflare\Endpoints\Accounts\Members;
use Cloudflare\Endpoints\Accounts\AuditLogs;

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
     * @return \Cloudflare\Contracts\ResponseInterface List Accounts response.
     */
    public function list(array $params = []): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function create(string $name, string $type, string $unit = null): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Account Details response.
     */
    public function details(string $accountId): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Update Account response.
     */
    public function update(string $accountId, string $name, array $settings = []): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function delete(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}");
    }

    /**
     * Account Roles
     *
     * @return \Cloudflare\Endpoints\Accounts\Roles
     */
    public function roles(): Roles
    {
        return new Roles($this->getClient());
    }

    /**
     * Account Members
     *
     * @return \Cloudflare\Endpoints\Accounts\Members
     */
    public function members(): Members
    {
        return new Members($this->getClient());
    }

    /**
     * Account audit logs
     *
     * @return \Cloudflare\Endpoints\Accounts\AuditLogs
     */
    public function auditLogs(): AuditLogs
    {
        return new AuditLogs($this->getClient());
    }
}
