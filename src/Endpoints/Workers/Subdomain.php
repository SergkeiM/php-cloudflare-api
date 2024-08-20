<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Subdomain extends AbstractEndpoint
{
    /**
     * Returns a Workers subdomain for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-subdomain-get-subdomain
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface Get Subdomain response
     */
    public function get(string $accountId): ResponseInterface
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
     * @return ResponseInterface Create Subdomain response.
     */
    public function create(string $accountId, string $subdomain): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/subdomain", [
            'subdomain' => $subdomain
        ]);
    }
}
