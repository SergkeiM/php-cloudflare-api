<?php

namespace Cloudflare\Endpoints\Iam;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class OauthClients extends AbstractEndpoint
{
    /**
     * List all the OAuth clients for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/list/
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface List OAuth Clients response.
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/oauth_clients");
    }

    /**
     * Create a new OAuth client.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param array $values OAuth Client values, requires client_name, grant_types, redirect_uris, response_types, scopes and token_endpoint_auth_method.
     *
     * @return ResponseInterface Create OAuth Client response.
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams([
            'client_name',
            'grant_types',
            'redirect_uris',
            'response_types',
            'scopes',
            'token_endpoint_auth_method',
        ], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/oauth_clients", $values);
    }

    /**
     * Get details of a specific OAuth client.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $oauthClientId OAuth Client identifier.
     *
     * @return ResponseInterface OAuth Client Details response.
     */
    public function get(string $accountId, string $oauthClientId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/oauth_clients/{$oauthClientId}");
    }

    /**
     * Update an existing OAuth client.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $oauthClientId OAuth Client identifier.
     * @param array $values OAuth Client values, e.g. client_name, grant_types, redirect_uris.
     *
     * @return ResponseInterface Update OAuth Client response.
     */
    public function update(string $accountId, string $oauthClientId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/oauth_clients/{$oauthClientId}", $values);
    }

    /**
     * Delete an OAuth client.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $oauthClientId OAuth Client identifier.
     *
     * @return ResponseInterface Delete OAuth Client response.
     */
    public function delete(string $accountId, string $oauthClientId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/oauth_clients/{$oauthClientId}");
    }

    /**
     * Creates a second client secret so you can update your client configuration before deleting the old one.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/rotate_secret/
     *
     * @param string $accountId Account identifier.
     * @param string $oauthClientId OAuth Client identifier.
     *
     * @return ResponseInterface Rotate Secret response.
     */
    public function rotateSecret(string $accountId, string $oauthClientId): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/oauth_clients/{$oauthClientId}/rotate_secret", []);
    }

    /**
     * Removes the old client secret after a rotation, keeping only the new one.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/oauth_clients/methods/delete_rotated_secret/
     *
     * @param string $accountId Account identifier.
     * @param string $oauthClientId OAuth Client identifier.
     *
     * @return ResponseInterface Delete Rotated Secret response.
     */
    public function deleteRotatedSecret(string $accountId, string $oauthClientId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/oauth_clients/{$oauthClientId}/rotate_secret");
    }
}
