<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Tenants\AccountTypes;
use Cloudflare\Endpoints\Tenants\Accounts;
use Cloudflare\Endpoints\Tenants\CustomNameservers;
use Cloudflare\Endpoints\Tenants\Entitlements;
use Cloudflare\Endpoints\Tenants\Memberships;

class Tenants extends AbstractEndpoint
{
    /**
     * Retrieves a Tenant by Tenant ID.
     *
     * @link https://developers.cloudflare.com/api/resources/tenants/methods/get/
     *
     * @param string $tenantId Tenant identifier.
     *
     * @return ResponseInterface Tenant Details response.
     */
    public function get(string $tenantId): ResponseInterface
    {
        return $this->getHttpClient()->get("/tenants/{$tenantId}");
    }

    /**
     * Tenant Account Types
     *
     * @return \Cloudflare\Endpoints\Tenants\AccountTypes
     */
    public function accountTypes(): AccountTypes
    {
        return new AccountTypes($this->getClient());
    }

    /**
     * Tenant Accounts
     *
     * @return \Cloudflare\Endpoints\Tenants\Accounts
     */
    public function accounts(): Accounts
    {
        return new Accounts($this->getClient());
    }

    /**
     * Tenant Custom Nameservers
     *
     * @return \Cloudflare\Endpoints\Tenants\CustomNameservers
     */
    public function customNameservers(): CustomNameservers
    {
        return new CustomNameservers($this->getClient());
    }

    /**
     * Tenant Entitlements
     *
     * @return \Cloudflare\Endpoints\Tenants\Entitlements
     */
    public function entitlements(): Entitlements
    {
        return new Entitlements($this->getClient());
    }

    /**
     * Tenant Memberships
     *
     * @return \Cloudflare\Endpoints\Tenants\Memberships
     */
    public function memberships(): Memberships
    {
        return new Memberships($this->getClient());
    }
}
