<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

class OriginCACertificates extends AbstractEndpoint
{
    /**
     * List all Origin CA certificates.
     *
     * @link https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/list/
     *
     * @param array $params Query Parameters, e.g. `zone_id`.
     *
     * @return ResponseInterface List Certificates response
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/certificates', $params);
    }

    /**
     * Create an Origin CA certificate.
     *
     * @link https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/create/
     *
     * ```php
     * $client->originCACertificates()->create([
     *     'csr' => $csr,
     *     'hostnames' => ['example.com', '*.example.com'],
     *     'request_type' => 'origin-rsa',
     * ]);
     * ```
     *
     * @param array $values `csr`, `hostnames` and `request_type` (`origin-rsa`, `origin-ecc` or `keyless-certificate`) are required. `requested_validity` is the certificate's lifetime in days, defaulting to Cloudflare's own.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Create Certificate response
     */
    public function create(array $values): ResponseInterface
    {
        $this->requiredParams(['csr', 'hostnames', 'request_type'], $values);

        return $this->getHttpClient()->post('/certificates', $values);
    }

    /**
     * Get an Origin CA certificate.
     *
     * @link https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/get/
     *
     * @param string $certificateId Origin CA certificate Identifier.
     *
     * @return ResponseInterface Get Certificate response
     */
    public function get(string $certificateId): ResponseInterface
    {
        return $this->getHttpClient()->get("/certificates/{$certificateId}");
    }

    /**
     * Revoke an Origin CA certificate.
     *
     * @link https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/delete/
     *
     * @param string $certificateId Origin CA certificate Identifier.
     *
     * @return ResponseInterface Revoke Certificate response
     */
    public function revoke(string $certificateId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/certificates/{$certificateId}");
    }
}
