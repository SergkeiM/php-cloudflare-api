<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\User\Tokens\PermissionGroups;
use Cloudflare\Endpoints\User\Tokens\Value;
use Cloudflare\Contracts\ResponseInterface;

class Tokens extends AbstractEndpoint
{
    /**
     * List all API tokens created for this user.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-list-tokens
     *
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Tokens response.
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/tokens', $params);
    }

    /**
     * Create a new API token.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-create-token
     *
     * @param array $values Token values, requires name and policies.
     *
     * @return ResponseInterface Create Token response.
     */
    public function create(array $values): ResponseInterface
    {
        $this->requiredParams(['name', 'policies'], $values);

        return $this->getHttpClient()->post('/user/tokens', $values);
    }

    /**
     * Get information about a specific API token.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-token-details
     *
     * @param string $tokenId Token identifier.
     *
     * @return ResponseInterface Token Details response.
     */
    public function get(string $tokenId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/tokens/{$tokenId}");
    }

    /**
     * Update an existing token.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-update-token
     *
     * @param string $tokenId Token identifier.
     * @param array $values Token values, e.g. name, policies, condition, status.
     *
     * @return ResponseInterface Update Token response.
     */
    public function update(string $tokenId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->put("/user/tokens/{$tokenId}", $values);
    }

    /**
     * Destroy an API token.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-delete-token
     *
     * @param string $tokenId Token identifier.
     *
     * @return ResponseInterface Delete Token response.
     */
    public function delete(string $tokenId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/user/tokens/{$tokenId}");
    }

    /**
     * Test whether a token works.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-verify-token
     *
     * @return ResponseInterface Verify Token response.
     */
    public function verify(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/tokens/verify');
    }

    /**
     * User API Token Permission Groups
     *
     * @return \Cloudflare\Endpoints\User\Tokens\PermissionGroups
     */
    public function permissionGroups(): PermissionGroups
    {
        return new PermissionGroups($this->getClient());
    }

    /**
     * User API Token Value
     *
     * @return \Cloudflare\Endpoints\User\Tokens\Value
     */
    public function value(): Value
    {
        return new Value($this->getClient());
    }
}
