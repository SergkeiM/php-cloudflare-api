<?php

namespace Cloudflare\Endpoints\DNS;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class DNSSEC extends AbstractEndpoint
{
    /**
     * Details about DNSSEC status and configuration.
     *
     * @link https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface DNSSEC Details response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/dnssec");
    }

    /**
     * Enable or disable DNSSEC.
     *
     * @link https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/edit/
     *
     * ```php
     * $client->dns()->dnssec()->edit('ZONE_ID', ['status' => 'active']);
     * ```
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values `status` is `active` or `disabled`. `dnssec_multi_signer` lets several providers serve the signed zone at once, which is required before DNSKEY records can be added — see [Multi-signer DNSSEC](https://developers.cloudflare.com/dns/dnssec/multi-signer-dnssec/). `dnssec_presigned` transfers in a zone already signed elsewhere, see [Cloudflare as Secondary](https://developers.cloudflare.com/dns/zone-setups/zone-transfers/cloudflare-as-secondary/setup/#dnssec). `dnssec_use_nsec3` is also accepted.
     *
     * @return ResponseInterface Edit DNSSEC Status response
     */
    public function edit(string $zoneId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/dnssec", $values);
    }

    /**
     * Delete DNSSEC.
     *
     * @link https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/delete/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Delete DNSSEC records response
     */
    public function delete(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/dnssec");
    }
}
