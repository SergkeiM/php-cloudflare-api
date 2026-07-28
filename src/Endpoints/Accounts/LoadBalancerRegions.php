<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class LoadBalancerRegions extends AbstractEndpoint
{
    /**
     * List Load Balancer region mappings for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-regions-list-regions
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface List regions response
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/regions");
    }
}
