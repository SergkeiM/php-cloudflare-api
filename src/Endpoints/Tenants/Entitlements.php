<?php

namespace Cloudflare\Endpoints\Tenants;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Entitlements extends AbstractEndpoint
{
    /**
     * List of innate entitlements available for the Tenant.
     *
     * @link https://developers.cloudflare.com/api/resources/tenants/subresources/entitlements/methods/get/
     *
     * @param string $tenantId Tenant identifier.
     *
     * @return ResponseInterface Tenant Entitlements response.
     */
    public function get(string $tenantId): ResponseInterface
    {
        return $this->getHttpClient()->get("/tenants/{$tenantId}/entitlements");
    }
}
