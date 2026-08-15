<?php

namespace Cloudflare\Endpoints\Tenants;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Accounts extends AbstractEndpoint
{
    /**
     * List of accounts for the Tenant.
     *
     * @link https://developers.cloudflare.com/api/resources/tenants/subresources/accounts/methods/list/
     *
     * @param string $tenantId Tenant identifier.
     *
     * @return ResponseInterface List Accounts response.
     */
    public function list(string $tenantId): ResponseInterface
    {
        return $this->getHttpClient()->get("/tenants/{$tenantId}/accounts");
    }
}
