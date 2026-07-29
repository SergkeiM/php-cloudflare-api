<?php

namespace Cloudflare\Endpoints\Tenants;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class AccountTypes extends AbstractEndpoint
{
    /**
     * List of account types available for the Tenant to provision accounts.
     *
     * @link https://developers.cloudflare.com/api/operations/Tenants_validAccountTypes
     *
     * @param string $tenantId Tenant identifier.
     *
     * @return ResponseInterface List Account Types response.
     */
    public function list(string $tenantId): ResponseInterface
    {
        return $this->getHttpClient()->get("/tenants/{$tenantId}/account_types");
    }
}
