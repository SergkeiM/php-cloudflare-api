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
 * @link https://developers.cloudflare.com/api/resources/accounts/methods/list/
 */
class Accounts extends AbstractEndpoint
{
    /**
     * List all accounts you have ownership or verified access to.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/methods/list/
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
     * ```php
     * $client->accounts()->create([
     *     'name' => 'Example Account',
     *     'type' => 'standard',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/methods/create/
     *
     * @param array $values `name` and `type` (`standard` for self-serve, `enterprise` otherwise) are required. `unit` optionally names the [tenant unit](https://developers.cloudflare.com/tenant/how-to/manage-accounts/) to create the account under, as `['id' => '…']`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function create(array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'type'], $values);

        return $this->getHttpClient()->post("/accounts", $values);
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/methods/get/
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
     * @link https://developers.cloudflare.com/api/resources/accounts/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param array $values `name` is required; `settings` is optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update Account response.
     */
    public function update(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->put("/accounts/{$accountId}", $values);
    }

    /**
     * Delete a specific account (only available for tenant admins at this time). This is a permanent operation that will delete any zones or other resources under the account
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/methods/delete/
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
