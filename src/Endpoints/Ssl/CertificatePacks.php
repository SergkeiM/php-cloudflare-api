<?php

namespace Cloudflare\Endpoints\Ssl;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Advanced Certificate Manager certificate packs for a zone.
 *
 * A pack is one ordered certificate covering a set of hostnames, issued by the
 * certificate authority you pick and validated by the method you choose.
 *
 * @link https://developers.cloudflare.com/ssl/edge-certificates/advanced-certificate-manager/
 */
class CertificatePacks extends AbstractEndpoint
{
    /**
     * List a zone's active certificate packs.
     *
     * @link https://developers.cloudflare.com/api/resources/ssl/subresources/certificate_packs/methods/list/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters: `status` (`all`), `deploy` (`staging` or `production`), `page` and `per_page`.
     *
     * @return ResponseInterface List certificate packs response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/ssl/certificate_packs", $params);
    }

    /**
     * Get a zone's certificate pack quotas.
     *
     * @link https://developers.cloudflare.com/api/resources/ssl/subresources/certificate_packs/subresources/quota/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Certificate pack quotas response
     */
    public function quota(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/ssl/certificate_packs/quota");
    }

    /**
     * Order an Advanced Certificate Manager certificate pack.
     *
     * `hosts` must include the zone apex and may not exceed 50 entries.
     * `type` is filled in as `advanced`, the only value Cloudflare accepts.
     *
     * ```php
     * $client->ssl()->certificatePacks()->order('ZONE_ID', [
     *     'certificate_authority' => 'lets_encrypt',
     *     'hosts' => ['example.com', 'www.example.com'],
     *     'validation_method' => 'txt',
     *     'validity_days' => 90,
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/ssl/subresources/certificate_packs/methods/create/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values `certificate_authority` (`google`, `lets_encrypt` or `ssl_com`), `hosts`, `validation_method` (`txt`, `http` or `email`) and `validity_days` (`14`, `30`, `90` or `365`) are required. `cloudflare_branding` is optional, and `type` defaults to `advanced`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Order certificate pack response
     */
    public function order(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['certificate_authority', 'hosts', 'validation_method', 'validity_days'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/ssl/certificate_packs/order", array_merge([
            'type' => 'advanced',
        ], $values));
    }

    /**
     * Get a single certificate pack.
     *
     * @link https://developers.cloudflare.com/api/resources/ssl/subresources/certificate_packs/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $certificatePackId Certificate Pack Identifier.
     *
     * @return ResponseInterface Certificate pack details response
     */
    public function get(string $zoneId, string $certificatePackId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/ssl/certificate_packs/{$certificatePackId}");
    }

    /**
     * Restart validation for a certificate pack, or change its Cloudflare branding.
     *
     * Sent with no values, this restarts validation — which Cloudflare only
     * accepts for a pack sitting in `validation_timed_out`. Sent with
     * `cloudflare_branding`, it updates that instead.
     *
     * @link https://developers.cloudflare.com/api/resources/ssl/subresources/certificate_packs/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $certificatePackId Certificate Pack Identifier.
     * @param array $values Optionally `cloudflare_branding`, which adds a subdomain of `sni.cloudflaressl.com` as the Common Name when true.
     *
     * @return ResponseInterface Restart validation response
     */
    public function edit(string $zoneId, string $certificatePackId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/ssl/certificate_packs/{$certificatePackId}", $values);
    }

    /**
     * Delete an Advanced Certificate Manager certificate pack.
     *
     * @link https://developers.cloudflare.com/api/resources/ssl/subresources/certificate_packs/methods/delete/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $certificatePackId Certificate Pack Identifier.
     *
     * @return ResponseInterface Delete certificate pack response
     */
    public function delete(string $zoneId, string $certificatePackId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/ssl/certificate_packs/{$certificatePackId}");
    }
}
