<?php

namespace Cloudflare\Endpoints\Tenants;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Memberships extends AbstractEndpoint
{
    /**
     * List of active members (Cloudflare users) for the Tenant.
     *
     * @link https://developers.cloudflare.com/api/operations/Tenants_listMemberships
     *
     * @param string $tenantId Tenant identifier.
     *
     * @return ResponseInterface List Memberships response.
     */
    public function list(string $tenantId): ResponseInterface
    {
        return $this->getHttpClient()->get("/tenants/{$tenantId}/memberships");
    }
}
