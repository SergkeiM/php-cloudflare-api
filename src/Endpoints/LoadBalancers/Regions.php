<?php

namespace Cloudflare\Endpoints\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Regions extends AbstractEndpoint
{
    /**
     * List Load Balancer region mappings for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/regions/methods/list/
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters: `subdivision_code`, `subdivision_code_a2` and `country_code_a2`.
     *
     * @return ResponseInterface List regions response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/regions", $params);
    }

    /**
     * Get a single Load Balancer region mapping for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/load_balancers/subresources/regions/methods/get/
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
