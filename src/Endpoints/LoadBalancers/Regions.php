<?php

namespace Cloudflare\Endpoints\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Regions extends AbstractEndpoint
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

    /**
     * Get a single Load Balancer region mapping for an account.
     *
     * @link https://developers.cloudflare.com/api/operations/load-balancer-regions-get-region
     *
     * @param string $accountId Account Identifier.
     * @param string $regionId Region Identifier.
     *
     * @return ResponseInterface Get region response
     */
    public function get(string $accountId, string $regionId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/regions/{$regionId}");
    }
}
