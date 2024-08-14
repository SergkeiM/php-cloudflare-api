<?php

namespace SergkeiM\CloudFlare\Endpoints\Zones;

use GuzzleHttp\RequestOptions;
use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\Exceptions\MissingArgumentException;

class DNS extends AbstractEndpoint
{
    /**
     * Scan DNS Records.
     * Scan for common DNS records on your domain and automatically add them to your zone. Useful if you haven't updated your nameservers yet.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-scan-dns-records
     *
     * @param string $zoneId Zone ID to scan DNS Records
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Scan DNS Records response
     */
    public function scan(string $zoneId): CloudFlareResponse
    {
        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->getHttpClient()->post('/zones/'.rawurlencode($zoneId).'/dns_records/scan');
    }

    /**
     * List DNS Records
     * List, search, sort, and filter a zones' DNS records.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-list-dns-records
     *
     * @param string $zoneId Zone ID to list DNS records.
     * @param array $params Query Parameters
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse List DNS Records response
     */
    public function all(string $zoneId, array $params = []): CloudFlareResponse
    {
        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->getHttpClient()->get('/zones/'.rawurlencode($zoneId).'/dns_records', $params);
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
     * @param string $zoneId Zone ID that you want to create a new DNS record for.
     * @param array $values Values to set on DNS.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Create DNS Record response
     */
    public function create(string $zoneId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(
            empty($values['content']) ||
            empty($values['name']) ||
            empty($values['type'])
        ) {
            throw new MissingArgumentException(['content', 'name', 'type']);
        }

        return $this->getHttpClient()->post('/zones/'.rawurlencode($zoneId).'/dns_records', $values);
    }

    /**
     * Export BIND config.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-export-dns-records
     *
     * @param string $zoneId Zone ID to export DNS records
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Export DNS Records response
     */
    public function export(string $zoneId): CloudFlareResponse
    {
        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->getHttpClient()->get('/zones/'.rawurlencode($zoneId).'/dns_records/export');
    }

    /**
     * Import BIND config.
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-import-dns-records
     *
     * @param string $zoneId Zone ID to import DNS records.
     * @param string $content Content of BIND config to import.
     * @param string $proxied Should DNS records be proxied.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Export DNS Records response
     */
    public function import(string $zoneId, string $content, bool $proxied = true): CloudFlareResponse
    {
        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->getHttpClient()->post(
            '/zones/'.rawurlencode($zoneId).'/dns_records/import',
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
     * @param string $zoneId Zone ID to fetch details.
     * @param string $dnsRecordId DNS ID to fetch details.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse DNS Record Details response
     */
    public function details(string $zoneId, string $dnsRecordId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($dnsRecordId)) {
            throw new InvalidArgumentException('DNS ID is required.');
        }

        return $this->getHttpClient()->get('/zones/'.rawurlencode($zoneId).'/dns_records/'.rawurlencode($dnsRecordId));
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
     * @param string $zoneId Zone ID to update DNS record on.
     * @param string $dnsRecordId DNS ID to update.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Update DNS Record response
     */
    public function update(string $zoneId, string $dnsRecordId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($dnsRecordId)) {
            throw new InvalidArgumentException('DNS ID is required.');
        }

        if(
            empty($values['content']) &&
            empty($values['name']) &&
            empty($values['type'])
        ) {
            throw new MissingArgumentException(['content', 'name', 'type']);
        }

        return $this->getHttpClient()->patch('/zones/'.rawurlencode($zoneId).'/dns_records/'.rawurlencode($dnsRecordId), $values);
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
     * @param string $zoneId Zone ID to overwrite DNS record on.
     * @param string $dnsRecordId DNS ID to overwrite.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Overwrite DNS Record response
     */
    public function overwrite(string $zoneId, string $dnsRecordId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($dnsRecordId)) {
            throw new InvalidArgumentException('DNS ID is required.');
        }

        if(
            empty($values['content']) &&
            empty($values['name']) &&
            empty($values['type'])
        ) {
            throw new MissingArgumentException(['content', 'name', 'type']);
        }

        return $this->getHttpClient()->put('/zones/'.rawurlencode($zoneId).'/dns_records/'.rawurlencode($dnsRecordId), $values);
    }

    /**
     * Delete DNS Record
     *
     * @link https://developers.cloudflare.com/api/operations/dns-records-for-a-zone-delete-dns-record
     *
     * @param string $zoneId Zone ID that you want to delete DNS Record for.
     * @param string $dnsRecordId DNS ID to delete.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Delete DNS Record response
     */
    public function delete(string $zoneId, string $dnsRecordId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($dnsRecordId)) {
            throw new InvalidArgumentException('DNS ID is required.');
        }

        return $this->getHttpClient()->delete('/zones/'.rawurlencode($zoneId).'/dns_records/'.rawurlencode($dnsRecordId));
    }
}
