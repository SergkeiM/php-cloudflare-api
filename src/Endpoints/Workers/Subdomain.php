<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Subdomain extends AbstractEndpoint
{
    /**
     * Returns a Workers subdomain for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/workers/subresources/subdomains/methods/get/
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
     * @link https://developers.cloudflare.com/api/resources/workers/subresources/subdomains/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $subdomain Subdomain.
     *
     * @return ResponseInterface Create Subdomain response.
     */
    public function update(string $accountId, string $subdomain): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/subdomain", [
            'subdomain' => $subdomain
        ]);
    }
}
