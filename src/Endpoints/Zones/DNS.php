<?php

namespace Cloudflare\Endpoints\Zones;

use GuzzleHttp\RequestOptions;
use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class DNS extends AbstractEndpoint
{
    /**
     * Scan DNS Records.
     * Scan for common DNS records on your domain and automatically add them to your zone. Useful if you haven't updated your nameservers yet.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-scan-dns-records
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Scan DNS Records response
     */
    public function scan(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/dns_records/scan");
    }

    /**
     * List, search, sort, and filter a zones' DNS records.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-list-dns-records
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters
     *
     * @return ResponseInterface List DNS Records response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/dns_records", $params);
    }

    /**
     * Create a new DNS record for a zone.
     * Notes:
     *  - A/AAAA records cannot exist on the same name as CNAME records.
     *  - NS records cannot exist on the same name as any other record type.
     *  - Domain names are always represented in Punycode, even if Unicode characters were used when creating the record.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-create-dns-record
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Values to set on DNS.
     *
     * @return ResponseInterface Create DNS Record response
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['content', 'name', 'type'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/dns_records", $values);
    }

    /**
     * Export BIND config.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-export-dns-records
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Export DNS Records response
     */
    public function export(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/dns_records/export");
    }

    /**
     * Import BIND config.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-import-dns-records
     *
     * @param string $zoneId Zone Identifier.
     * @param string $content Content of BIND config to import.
     * @param string $proxied Should DNS records be proxied.
     *
     * @return ResponseInterface Export DNS Records response
     */
    public function import(string $zoneId, string $content, bool $proxied = true): ResponseInterface
    {
        return $this->getHttpClient()->post(
            "/zones/{$zoneId}/dns_records/import",
            [
                [
                    'name'     => 'file',
                    'contents' => $content
                ],
                [
                    'name'     => 'proxied',
                    'contents' => $proxied
                ],
            ],
            format: RequestOptions::MULTIPART
        );
    }

    /**
     * DNS Record Details
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-dns-record-details
     *
     * @param string $zoneId Zone Identifier.
     * @param string $dnsRecordId DNS ID to fetch details.
     *
     * @return ResponseInterface DNS Record Details response
     */
    public function details(string $zoneId, string $dnsRecordId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/dns_records/{$dnsRecordId}");
    }

    /**
     * Update an existing DNS record.
     * Notes:
     *  - A/AAAA records cannot exist on the same name as CNAME records.
     *  - NS records cannot exist on the same name as any other record type.
     *  - Domain names are always represented in Punycode, even if Unicode characters were used when creating the record.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-patch-dns-record
     *
     * @param string $zoneId Zone Identifier.
     * @param string $dnsRecordId DNS ID to update.
     *
     * @return ResponseInterface Update DNS Record response
     */
    public function update(string $zoneId, string $dnsRecordId, array $values): ResponseInterface
    {
        $this->requiredParams(['content', 'name', 'type'], $values);

        return $this->getHttpClient()->patch("/zones/{$zoneId}/dns_records/{$dnsRecordId}", $values);
    }

    /**
     * Overwrite an existing DNS record.
     * Notes:
     *  - A/AAAA records cannot exist on the same name as CNAME records.
     *  - NS records cannot exist on the same name as any other record type.
     *  - Domain names are always represented in Punycode, even if Unicode characters were used when creating the record.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-update-dns-record
     *
     * @param string $zoneId Zone Identifier.
     * @param string $dnsRecordId DNS ID to overwrite.
     *
     * @return ResponseInterface Overwrite DNS Record response
     */
    public function overwrite(string $zoneId, string $dnsRecordId, array $values): ResponseInterface
    {
        $this->requiredParams(['content', 'name', 'type'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/dns_records/{$dnsRecordId}", $values);
    }

    /**
     * Delete DNS Record
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-delete-dns-record
     *
     * @param string $zoneId Zone Identifier.
     * @param string $dnsRecordId DNS ID to delete.
     *
     * @return ResponseInterface Delete DNS Record response
     */
    public function delete(string $zoneId, string $dnsRecordId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/dns_records/{$dnsRecordId}");
    }
}
