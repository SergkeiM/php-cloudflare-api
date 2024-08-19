<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;

class Domains extends AbstractEndpoint
{
    /**
     * Lists all Worker Domains for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-domain-list-domains
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudflareResponse List Domains response
     */
    public function get(string $accountId, array $params = []): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/domains", $params);
    }

    /**
     * Attaches a Worker to a zone and hostname.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-domain-attach-to-domain
     *
     * @param string $accountId Account identifier.
     * @param array $values Values to set on account.
     *
     * @return CloudflareResponse Attach to Domain response
     */
    public function attach(string $accountId, array $values = []): CloudflareResponse
    {
        $this->requiredParams(['environment', 'hostname', 'service', 'zone_id'], $values);

        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/domains", $values);
    }

    /**
     * Detaches a Worker from a zone and hostname.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-domain-detach-from-domain
     *
     * @param string $accountId Account identifier.
     * @param string $domainId Identifer of the Worker Domain.
     *
     * @return CloudflareResponse Detach from Domain response
     */
    public function detach(string $accountId, string $domainId = []): CloudflareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/workers/domains/{$domainId}");
    }

    /**
     * Gets a Worker domain.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-domain-get-a-domain
     *
     * @param string $accountId Account identifier.
     * @param string $domainId Identifer of the Worker Domain.
     *
     * @return CloudflareResponse Get a Domain response
     */
    public function domain(string $accountId, string $domainId = []): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/domains/{$domainId}");
    }
}
