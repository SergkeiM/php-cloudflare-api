<?php

namespace Cloudflare\Endpoints\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Searches extends AbstractEndpoint
{
    /**
     * Search load balancing resources (Load Balancers, Pools, Monitors) by name.
     *
     * @link https://developers.cloudflare.com/api/operations/account-load-balancer-search-search-resources
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters, e.g. `query`, `references`, `page`, `per_page`.
     *
     * @return ResponseInterface Search resources response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/search", $params);
    }
}
