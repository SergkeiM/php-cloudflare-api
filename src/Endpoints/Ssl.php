<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Ssl\CertificatePacks;

class Ssl extends AbstractEndpoint
{
    /**
     * SSL Verification Details.
     *
     * @link https://developers.cloudflare.com/api/operations/ssl-verification-details
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters.
     *
     * @return ResponseInterface SSL Verification Details response
     */
    public function verification(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/ssl/verification", $params);
    }

    /**
     * Edit SSL Certificate Pack Validation Method.
     *
     * @link https://developers.cloudflare.com/api/operations/ssl-edit-ssl-validation-method
     *
     * @param string $zoneId Zone Identifier.
     * @param string $certPackUuid Certificate Pack UUID.
     * @param string $validationMethod Validation Method selected for the order. Allowed values: `http`, `cname`, `txt`, `email`
     *
     * @return ResponseInterface Edit SSL Certificate Pack Validation Method response
     */
    public function editVerification(string $zoneId, string $certPackUuid, string $validationMethod): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/ssl/verification/{$certPackUuid}", [
            'validation_method' => $validationMethod,
        ]);
    }

    /**
     * Universal SSL Settings Details.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-ssl-universal-settings-get
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Universal SSL Settings Details response
     */
    public function universalSettings(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/ssl/universal/settings");
    }

    /**
     * Edit Universal SSL Settings.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-ssl-universal-settings-patch
     *
     * @param string $zoneId Zone Identifier.
     * @param bool $enabled Whether Universal SSL is enabled.
     *
     * @return ResponseInterface Edit Universal SSL Settings response
     */
    public function editUniversalSettings(string $zoneId, bool $enabled): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/ssl/universal/settings", [
            'enabled' => $enabled,
        ]);
    }

    /**
     * Analyze a certificate.
     *
     * Returns the hostnames the certificate covers, its signature algorithm
     * and its expiration date. Sent without a certificate, Cloudflare analyzes
     * the one already on the zone.
     *
     * @link https://developers.cloudflare.com/api/operations/analyze-certificate-analyze-certificate
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Optionally `certificate`, the PEM certificate and any intermediates, and `bundle_method` (`ubiquitous`, `optimal` or `force`).
     *
     * @return ResponseInterface Analyze certificate response
     */
    public function analyze(string $zoneId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/ssl/analyze", $values);
    }

    /**
     * Advanced Certificate Manager Certificate Packs
     *
     * @return \Cloudflare\Endpoints\Ssl\CertificatePacks
     */
    public function certificatePacks(): CertificatePacks
    {
        return new CertificatePacks($this->getClient());
    }
}
