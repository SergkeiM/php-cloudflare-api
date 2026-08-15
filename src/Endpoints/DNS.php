<?php

namespace Cloudflare\Endpoints;

use GuzzleHttp\RequestOptions;
use Cloudflare\Contracts\ResponseInterface;

class DNS extends AbstractEndpoint
{
    /**
     * Scan DNS Records.
     * Scan for common DNS records on your domain and automatically add them to your zone. Useful if you haven't updated your nameservers yet.
     *
     * @deprecated Cloudflare marks this operation deprecated. Use `triggerScan()` to start a scan, then `scannedRecords()` and `reviewScan()` to decide what gets added — the newer flow does not add records to the zone on its own.
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
     * Trigger an asynchronous scan for common DNS records on a domain.
     *
     * Unlike the deprecated `scan()`, this does **not** add anything to the
     * zone. The scan runs in the background; read what it found with
     * `scannedRecords()` and decide record by record with `reviewScan()`.
     *
     * @link https://developers.cloudflare.com/dns/manage-dns-records/how-to/import-and-export/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Trigger DNS record scan response
     */
    public function triggerScan(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/dns_records/scan/trigger");
    }

    /**
     * List the DNS records discovered so far by the asynchronous scan.
     *
     * These records are temporary until accepted or rejected through
     * `reviewScan()`, and the scan may turn up more of them afterwards.
     *
     * @link https://developers.cloudflare.com/dns/manage-dns-records/how-to/import-and-export/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface List scanned DNS records response
     */
    public function scannedRecords(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/dns_records/scan/review");
    }

    /**
     * Accept or reject DNS records found by the scan.
     *
     * Accepted records are permanently added to the zone; rejected ones are
     * permanently deleted.
     *
     * ```php
     * $client->dns()->reviewScan('ZONE_ID', accepts: ['record_id_a'], rejects: ['record_id_b']);
     * ```
     *
     * @link https://developers.cloudflare.com/dns/manage-dns-records/how-to/import-and-export/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $accepts Scanned records to add to the zone.
     * @param array $rejects Scanned records to discard.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Review scanned DNS records response
     */
    public function reviewScan(string $zoneId, array $accepts = [], array $rejects = []): ResponseInterface
    {
        $this->requiredAnyParams(['accepts', 'rejects'], [
            'accepts' => $accepts,
            'rejects' => $rejects,
        ]);

        return $this->getHttpClient()->post("/zones/{$zoneId}/dns_records/scan/review", [
            'accepts' => array_values($accepts),
            'rejects' => array_values($rejects),
        ]);
    }

    /**
     * Send a batch of DNS record changes to be executed together.
     *
     * Cloudflare runs the batch in a single database transaction, but
     * propagation is not atomic: its distributed store treats each record as
     * its own key, so changes become visible independently.
     *
     * ```php
     * $client->dns()->batch('ZONE_ID', [
     *     'posts' => [['type' => 'A', 'name' => 'www', 'content' => '198.51.100.4']],
     *     'deletes' => [['id' => 'record_id']],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/dns/manage-dns-records/how-to/batch-record-changes/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Any of `posts` (create), `puts` (overwrite), `patches` (partial update) and `deletes`, each a list of record operations.
     * @param array $params Query Parameters: `include_shadow_metadata`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Batch DNS records response
     */
    public function batch(string $zoneId, array $values, array $params = []): ResponseInterface
    {
        $this->requiredAnyParams(['posts', 'puts', 'patches', 'deletes'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/dns_records/batch", $values, [
            'query' => $params,
        ]);
    }

    /**
     * Get the current DNS record usage and quota for an account.
     *
     * May include internal DNS usage and quota alongside the public zones'.
     *
     * @link https://developers.cloudflare.com/dns/
     *
     * @param string $accountId Account Identifier.
     *
     * @return ResponseInterface DNS record usage response
     */
    public function usage(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/dns_records/usage");
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
     * @param bool $proxied Should DNS records be proxied.
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
    public function get(string $zoneId, string $dnsRecordId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/dns_records/{$dnsRecordId}");
    }

    /**
     * Apply changes to an existing DNS record, overwriting only the supplied properties.
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
     * @return ResponseInterface Edit DNS Record response
     */
    public function edit(string $zoneId, string $dnsRecordId, array $values): ResponseInterface
    {
        $this->requiredParams(['content', 'name', 'type'], $values);

        return $this->getHttpClient()->patch("/zones/{$zoneId}/dns_records/{$dnsRecordId}", $values);
    }

    /**
     * Update an existing DNS record, overwriting the full configuration.
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
     * @return ResponseInterface Update DNS Record response
     */
    public function update(string $zoneId, string $dnsRecordId, array $values): ResponseInterface
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
