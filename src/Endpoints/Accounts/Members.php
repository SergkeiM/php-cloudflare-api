<?php

namespace SergkeiM\CloudFlare\Endpoints\Accounts;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;

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
     * @return CloudFlareResponse List Members response.
     */
    public function list(string $accountId, array $params = []): CloudFlareResponse
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
     * @return CloudFlareResponse Add Member response
     */
    public function add(string $accountId, array $values): CloudFlareResponse
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
     * @return CloudFlareResponse Remove Member response
     */
    public function remove(string $accountId, string $memberId): CloudFlareResponse
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
     * @return CloudFlareResponse Member Details response
     */
    public function details(string $accountId, string $memberId): CloudFlareResponse
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
     * @return CloudFlareResponse Update Member response
     */
    public function updateRoles(string $accountId, string $memberId, array $roles): CloudFlareResponse
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
     * @return CloudFlareResponse Update Member response
     */
    public function updatePolicies(string $accountId, string $memberId, array $policies): CloudFlareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/members/{$memberId}", [
            'policies' => $policies
        ]);
    }
}
