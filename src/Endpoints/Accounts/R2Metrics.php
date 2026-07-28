<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class R2Metrics extends AbstractEndpoint
{
    /**
     * Get storage metrics for an account's R2 buckets.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-metrics
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters.
     *
     * @return ResponseInterface Metrics response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/metrics", $params);
    }
}
