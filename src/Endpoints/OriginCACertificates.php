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
     * @param string $csr Certificate Signing Request (CSR).
     * @param array $hostnames Array of hostnames or wildcard names bound to the certificate.
     * @param int $requestedValidity The number of days for which the certificate should be valid.
     * @param string $requestType The signature type desired on the certificate. Allowed values: `origin-rsa`, `origin-ecc`, `keyless-certificate`
     *
     * @return ResponseInterface Create Certificate response
     */
    public function create(string $csr, array $hostnames, int $requestedValidity = 5475, string $requestType = 'origin-rsa'): ResponseInterface
    {
        return $this->getHttpClient()->post('/certificates', [
            'csr' => $csr,
            'hostnames' => $hostnames,
            'requested_validity' => $requestedValidity,
            'request_type' => $requestType,
        ]);
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
