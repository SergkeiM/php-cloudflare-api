<?php

namespace Cloudflare\Endpoints\LoadBalancers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Previews extends AbstractEndpoint
{
    /**
     * Get the result of a previously requested monitor or pool preview.
     *
     * @link https://developers.cloudflare.com/api/operations/account-load-balancer-monitors-preview-result
     *
     * @param string $accountId Account Identifier.
     * @param string $previewId Preview Identifier.
     *
     * @return ResponseInterface Preview result response
     */
    public function get(string $accountId, string $previewId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/load_balancers/preview/{$previewId}");
    }
}
