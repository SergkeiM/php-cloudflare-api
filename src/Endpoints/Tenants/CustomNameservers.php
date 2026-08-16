<?php

namespace Cloudflare\Endpoints\Tenants;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class CustomNameservers extends AbstractEndpoint
{
    /**
     * List of custom nameservers for the Tenant.
     *
     * @link https://developers.cloudflare.com/api/resources/tenant_custom_nameservers/methods/get/
     *
     * @param string $tenantId Tenant identifier.
     *
     * @return ResponseInterface List Custom Nameservers response.
     */
    public function get(string $tenantId): ResponseInterface
    {
        return $this->getHttpClient()->get("/tenants/{$tenantId}/custom_ns");
    }

    /**
     * Add a custom nameserver to the Tenant.
     *
     * ```php
     * $client->tenants()->customNameservers()->create('TENANT_ID', [
     *     'ns_name' => 'ns1.example.com',
     *     'ns_set' => 1,
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/tenant_custom_nameservers/methods/create/
     *
     * @param string $tenantId Tenant identifier.
     * @param array $values `ns_name` is required and is the FQDN of the name server. `ns_set` optionally numbers the set the name server belongs to.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Add Custom Nameserver response.
     */
    public function create(string $tenantId, array $values): ResponseInterface
    {
        $this->requiredParams(['ns_name'], $values);

        return $this->getHttpClient()->post("/tenants/{$tenantId}/custom_ns", $values);
    }

    /**
     * Delete a custom nameserver from the Tenant.
     *
     * @link https://developers.cloudflare.com/api/resources/tenant_custom_nameservers/methods/delete/
     *
     * @param string $tenantId Tenant identifier.
     * @param string $nsName FQDN of the name server to delete.
     *
     * @return ResponseInterface Delete Custom Nameserver response.
     */
    public function delete(string $tenantId, string $nsName): ResponseInterface
    {
        return $this->getHttpClient()->delete("/tenants/{$tenantId}/custom_ns/{$nsName}");
    }
}
