<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Accounts\Members;
use Cloudflare\Endpoints\Accounts\Logs;
use Cloudflare\Endpoints\Accounts\AccessRules;
use Cloudflare\Endpoints\Accounts\Settings;
use Cloudflare\Endpoints\Accounts\Subscriptions;
use Cloudflare\Endpoints\Accounts\Tokens;

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
    public function create(string $name, string $type, ?string $unit = null): ResponseInterface
    {
        $values = [
            'name' => $name,
            'type' => $type
        ];

        if (!is_null($unit)) {
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
    public function get(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}");
    }

    /**
     * Update an existing account.
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

        if (!empty($settings)) {
            $values['settings'] = $settings;
        }

        return $this->getHttpClient()->put("/accounts/{$accountId}", $values);
    }

    /**
     * Delete a specific account (only available for tenant admins at this time). This is a permanent operation that will delete any zones or other resources under the account
     *
     * @link https://developers.cloudflare.com/api/operations/account-deletion
     *
     * @param string $accountId Account identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function delete(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}");
    }

    /**
     * Get account profile.
     *
     * @link https://developers.cloudflare.com/api/operations/Accounts_getAccountProfile
     *
     * @param string $accountId Account identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Account Profile response.
     */
    public function profile(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/profile");
    }

    /**
     * Modify account profile.
     *
     * @link https://developers.cloudflare.com/api/operations/Accounts_modifyAccountProfile
     *
     * @param string $accountId Account identifier.
     * @param array $values Account profile values.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update Account Profile response.
     */
    public function updateProfile(string $accountId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/profile", $values);
    }

    /**
     * List account organizations.
     *
     * @link https://developers.cloudflare.com/api/operations/Accounts_listAccountOrganizations
     *
     * @param string $accountId Account identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List Account Organizations response.
     */
    public function organizations(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/organizations");
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
     * Account Logs
     *
     * @return \Cloudflare\Endpoints\Accounts\Logs
     */
    public function logs(): Logs
    {
        return new Logs($this->getClient());
    }

    /**
     * Account Subscriptions
     *
     * @return \Cloudflare\Endpoints\Accounts\Subscriptions
     */
    public function subscriptions(): Subscriptions
    {
        return new Subscriptions($this->getClient());
    }

    /**
     * Account Owned API Tokens
     *
     * @return \Cloudflare\Endpoints\Accounts\Tokens
     */
    public function tokens(): Tokens
    {
        return new Tokens($this->getClient());
    }

    /**
     * Account Settings
     *
     * @return \Cloudflare\Endpoints\Accounts\Settings
     */
    public function settings(): Settings
    {
        return new Settings($this->getClient());
    }

    /**
     * Account IP Access Rules
     *
     * @return \Cloudflare\Endpoints\Accounts\AccessRules
     */
    public function accessRules(): AccessRules
    {
        return new AccessRules($this->getClient());
    }
}
