<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;

class Subdomain extends AbstractEndpoint
{
    /**
     * Returns a Workers subdomain for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-subdomain-get-subdomain
     *
     * @param string $accountId Account identifier.
     *
     * @return CloudflareResponse Get Subdomain response
     */
    public function get(string $accountId): CloudflareResponse
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
     * @return CloudflareResponse Create Subdomain response.
     */
    public function create(string $accountId, string $subdomain): CloudflareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/subdomain", [
            'subdomain' => $subdomain
        ]);
    }
}
