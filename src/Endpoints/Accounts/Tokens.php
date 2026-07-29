<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Accounts\Tokens\PermissionGroups;
use Cloudflare\Endpoints\Accounts\Tokens\Value;
use Cloudflare\Contracts\ResponseInterface;

class Tokens extends AbstractEndpoint
{
    /**
     * List all Account Owned API tokens created for this account.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-list-tokens
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Tokens response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/tokens", $params);
    }

    /**
     * Create a new Account Owned API token.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-create-token
     *
     * @param string $accountId Account identifier.
     * @param array $values Token values, requires name and policies.
     *
     * @return ResponseInterface Create Token response.
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'policies'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/tokens", $values);
    }

    /**
     * Get information about a specific Account Owned API token.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-token-details
     *
     * @param string $accountId Account identifier.
     * @param string $tokenId Token identifier.
     *
     * @return ResponseInterface Token Details response.
     */
    public function get(string $accountId, string $tokenId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/tokens/{$tokenId}");
    }

    /**
     * Update an existing token.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-update-token
     *
     * @param string $accountId Account identifier.
     * @param string $tokenId Token identifier.
     * @param array $values Token values, e.g. name, policies, condition, status.
     *
     * @return ResponseInterface Update Token response.
     */
    public function update(string $accountId, string $tokenId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/tokens/{$tokenId}", $values);
    }

    /**
     * Destroy an Account Owned API token.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-delete-token
     *
     * @param string $accountId Account identifier.
     * @param string $tokenId Token identifier.
     *
     * @return ResponseInterface Delete Token response.
     */
    public function delete(string $accountId, string $tokenId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/tokens/{$tokenId}");
    }

    /**
     * Test whether a token works.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-verify-token
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface Verify Token response.
     */
    public function verify(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/tokens/verify");
    }

    /**
     * Account Owned API Token Permission Groups
     *
     * @return \Cloudflare\Endpoints\Accounts\Tokens\PermissionGroups
     */
    public function permissionGroups(): PermissionGroups
    {
        return new PermissionGroups($this->getClient());
    }

    /**
     * Account Owned API Token Value
     *
     * @return \Cloudflare\Endpoints\Accounts\Tokens\Value
     */
    public function value(): Value
    {
        return new Value($this->getClient());
    }
}
