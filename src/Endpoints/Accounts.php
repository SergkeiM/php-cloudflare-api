<?php

namespace SergkeiM\CloudFlare\Endpoints;

use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Endpoints\Accounts\Roles;
use SergkeiM\CloudFlare\Endpoints\Accounts\Members;

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
     * @param string $accountId Account ID to fetch details.
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
     * @param string $accountId Account ID that you want to update.
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
}
