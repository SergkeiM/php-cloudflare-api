<?php

namespace CloudFlare\Endpoints\Workers;

use CloudFlare\Endpoints\AbstractEndpoint;
use CloudFlare\Contracts\CloudFlareResponse;

class Subdomain extends AbstractEndpoint
{
    /**
     * Returns a Workers subdomain for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-subdomain-get-subdomain
     *
     * @param string $accountId Account identifier.
     *
     * @return CloudFlareResponse Get Subdomain response
     */
    public function get(string $accountId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/subdomain");
    }

    /**
     * Creates a Workers subdomain for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-subdomain-create-subdomain
     *
     * @param string $accountId Account identifier.
     * @param string $subdomain Subdomain.
     *
     * @return CloudFlareResponse Create Subdomain response.
     */
    public function create(string $accountId, string $subdomain): CloudFlareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/subdomain", [
            'subdomain' => $subdomain
        ]);
    }
}
