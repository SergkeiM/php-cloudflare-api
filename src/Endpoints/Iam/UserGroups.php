<?php

namespace Cloudflare\Endpoints\Iam;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Iam\UserGroups\Members;
use Cloudflare\Contracts\ResponseInterface;

class UserGroups extends AbstractEndpoint
{
    /**
     * List all the user groups for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params, e.g. id, name, fuzzyName.
     *
     * @return ResponseInterface List User Groups response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/user_groups", $params);
    }

    /**
     * Create a new user group under the specified account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param array $values User Group values, requires name.
     *
     * @return ResponseInterface Create User Group response.
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/iam/user_groups", $values);
    }

    /**
     * Get information about a specific user group in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     *
     * @return ResponseInterface User Group Details response.
     */
    public function get(string $accountId, string $userGroupId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/iam/user_groups/{$userGroupId}");
    }

    /**
     * Modify an existing user group.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     * @param array $values User Group values, e.g. name, policies.
     *
     * @return ResponseInterface Update User Group response.
     */
    public function update(string $accountId, string $userGroupId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/iam/user_groups/{$userGroupId}", $values);
    }

    /**
     * Remove a user group from an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $userGroupId User Group identifier.
     *
     * @return ResponseInterface Delete User Group response.
     */
    public function delete(string $accountId, string $userGroupId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/iam/user_groups/{$userGroupId}");
    }

    /**
     * Account User Group Members
     *
     * @return \Cloudflare\Endpoints\Iam\UserGroups\Members
     */
    public function members(): Members
    {
        return new Members($this->getClient());
    }
}
