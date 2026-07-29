<?php

namespace Cloudflare\Endpoints\Iam\UserGroups;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Members extends AbstractEndpoint
{
    /**
     * List all the members attached to a user group.
     *
     * @link https://developers.cloudflare.com/api/operations/account-user-group-member-list
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     * @param array $params Array containing the necessary params, e.g. fuzzyEmail.
     *
     * @return ResponseInterface List Members response.
     */
    public function list(string $accountId, string $userGroupId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/user_groups/{$userGroupId}/members", $params);
    }

    /**
     * Add members to a User Group.
     *
     * @link https://developers.cloudflare.com/api/operations/account-user-group-member-create
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     * @param array $members Array of member identifiers to add, e.g. [['id' => 'member_id']].
     *
     * @return ResponseInterface Add Members response.
     */
    public function create(string $accountId, string $userGroupId, array $members): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/iam/user_groups/{$userGroupId}/members", $members);
    }

    /**
     * Replace the set of members attached to a User Group.
     *
     * @link https://developers.cloudflare.com/api/operations/account-user-group-members-update
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     * @param array $members Array of member identifiers, e.g. [['id' => 'member_id']].
     *
     * @return ResponseInterface Replace Members response.
     */
    public function update(string $accountId, string $userGroupId, array $members): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/iam/user_groups/{$userGroupId}/members", $members);
    }

    /**
     * Remove a member from a User Group.
     *
     * @link https://developers.cloudflare.com/api/operations/account-user-group-member-delete
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     * @param string $memberId Member identifier.
     *
     * @return ResponseInterface Remove Member response.
     */
    public function delete(string $accountId, string $userGroupId, string $memberId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/iam/user_groups/{$userGroupId}/members/{$memberId}");
    }

    /**
     * Get information about a specific member of a User Group.
     *
     * @link https://developers.cloudflare.com/api/operations/account-user-group-member-get
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     * @param string $memberId Member identifier.
     *
     * @return ResponseInterface Member Details response.
     */
    public function get(string $accountId, string $userGroupId, string $memberId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/user_groups/{$userGroupId}/members/{$memberId}");
    }
}
