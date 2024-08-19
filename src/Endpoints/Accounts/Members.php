<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;

class Members extends AbstractEndpoint
{
    /**
     * List all members of an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-members-list-members
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudflareResponse List Members response.
     */
    public function list(string $accountId, array $params = []): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/members", $params);
    }

    /**
     * Add a user to the list of members for this account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-members-add-member
     *
     * @param string $accountId Account identifier.
     * @param array $values Values to set on Member.
     *
     * @return CloudflareResponse Add Member response
     */
    public function add(string $accountId, array $values): CloudflareResponse
    {

        $this->requiredParams(['email', 'roles'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/members", $values);
    }

    /**
     * Remove a member from an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-members-remove-member
     *
     * @param string $accountId Account identifier.
     * @param string $memberId Member identifier.
     *
     * @return CloudflareResponse Remove Member response
     */
    public function delete(string $accountId, string $memberId): CloudflareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/members/{$memberId}");
    }

    /**
     * Get information about a specific member of an account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-members-remove-member
     *
     * @param string $accountId Account identifier.
     * @param string $memberId Member identifier.
     *
     * @return CloudflareResponse Member Details response
     */
    public function details(string $accountId, string $memberId): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/members/{$memberId}");
    }

    /**
     * Modify an account member roles.
     *
     * @link https://developers.cloudflare.com/api/operations/account-members-update-member
     *
     * @param string $accountId Account identifier.
     * @param string $memberId Member identifier.
     * @param array $roles Role identifiers.
     *
     * @return CloudflareResponse Update Member response
     */
    public function updateRoles(string $accountId, string $memberId, array $roles): CloudflareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/members/{$memberId}", [
            'roles' => $roles
        ]);
    }

    /**
     * Modify an account member policies.
     *
     * @link https://developers.cloudflare.com/api/operations/account-members-update-member
     *
     * @param string $accountId Account identifier.
     * @param string $memberId Member identifier.
     * @param array $policies Policies associated with this member.
     *
     * @return CloudflareResponse Update Member response
     */
    public function updatePolicies(string $accountId, string $memberId, array $policies): CloudflareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/members/{$memberId}", [
            'policies' => $policies
        ]);
    }
}
