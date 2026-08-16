<?php

namespace Cloudflare\Endpoints\Iam;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Sso extends AbstractEndpoint
{
    /**
     * Lists all SSO connectors configured for the account.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/sso/methods/list/
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface List SSO Connectors response.
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/sso_connectors");
    }

    /**
     * Creates a new SSO connector for logging into Cloudflare through an identity provider.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/sso/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param array $values SSO Connector values, requires email_domain.
     *
     * @return ResponseInterface Create SSO Connector response.
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['email_domain'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/sso_connectors", $values);
    }

    /**
     * Get information about a specific SSO connector.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/sso/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $ssoConnectorId SSO Connector identifier.
     *
     * @return ResponseInterface SSO Connector Details response.
     */
    public function get(string $accountId, string $ssoConnectorId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/sso_connectors/{$ssoConnectorId}");
    }

    /**
     * Updates the state or configuration of an SSO connector.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/sso/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $ssoConnectorId SSO Connector identifier.
     * @param array $values SSO Connector values, e.g. enabled, use_fedramp_language.
     *
     * @return ResponseInterface Update SSO Connector response.
     */
    public function edit(string $accountId, string $ssoConnectorId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/sso_connectors/{$ssoConnectorId}", $values);
    }

    /**
     * Deletes an SSO connector.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/sso/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $ssoConnectorId SSO Connector identifier.
     *
     * @return ResponseInterface Delete SSO Connector response.
     */
    public function delete(string $accountId, string $ssoConnectorId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/sso_connectors/{$ssoConnectorId}");
    }

    /**
     * Begin the verification process for an SSO connector.
     *
     * @link https://developers.cloudflare.com/api/resources/iam/subresources/sso/methods/begin_verification/
     *
     * @param string $accountId Account identifier.
     * @param string $ssoConnectorId SSO Connector identifier.
     *
     * @return ResponseInterface Begin Verification response.
     */
    public function beginVerification(string $accountId, string $ssoConnectorId): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/sso_connectors/{$ssoConnectorId}/begin_verification", []);
    }
}
