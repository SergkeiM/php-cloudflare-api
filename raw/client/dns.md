# DNS

> DNS endpoint reference.

## Scan

Scan DNS Records.

Scan for common DNS records on your domain and automatically add them to your zone. Useful if you haven't updated your nameservers yet.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->dns()->scan('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/scan/">

View this operation on the Cloudflare API Reference

</callout>

## Trigger Scan

Trigger an asynchronous scan for common DNS records on a domain.

Unlike the deprecated `scan()`, this does **not** add anything to the
zone. The scan runs in the background; read what it found with
`scannedRecords()` and decide record by record with `reviewScan()`.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->dns()->triggerScan('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/dns/manage-dns-records/how-to/import-and-export/">

View this operation on the Cloudflare API Reference

</callout>

## Scanned Records

List the DNS records discovered so far by the asynchronous scan.

These records are temporary until accepted or rejected through
`reviewScan()`, and the scan may turn up more of them afterwards.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->dns()->scannedRecords('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/dns/manage-dns-records/how-to/import-and-export/">

View this operation on the Cloudflare API Reference

</callout>

## Review Scan

Accept or reject DNS records found by the scan.

Accepted records are permanently added to the zone; rejected ones are
permanently deleted.

```php
$client->dns()->reviewScan('ZONE_ID', accepts: ['record_id_a'], rejects: ['record_id_b']);
```

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"accepts","type":"array","required":false,"description":"Scanned records to add to the zone.","default":"[]"},{"name":"rejects","type":"array","required":false,"description":"Scanned records to discard.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->dns()->reviewScan('ZONE_ID', [], []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/dns/manage-dns-records/how-to/import-and-export/">

View this operation on the Cloudflare API Reference

</callout>

## Batch

Send a batch of DNS record changes to be executed together.

Cloudflare runs the batch in a single database transaction, but
propagation is not atomic: its distributed store treats each record as
its own key, so changes become visible independently.

```php
$client->dns()->batch('ZONE_ID', [
    'posts' => [['type' => 'A', 'name' => 'www', 'content' => '198.51.100.4']],
    'deletes' => [['id' => 'record_id']],
]);
```

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"Any of `posts` (create), `puts` (overwrite), `patches` (partial update) and `deletes`, each a list of record operations."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `include_shadow_metadata`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->dns()->batch('ZONE_ID', [], []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/dns/manage-dns-records/how-to/batch-record-changes/">

View this operation on the Cloudflare API Reference

</callout>

## Usage

Get the current DNS record usage and quota for an account.

May include internal DNS usage and quota alongside the public zones'.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."}]">



</params-table>

```php [php]
$response = $client->dns()->usage('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/dns/">

View this operation on the Cloudflare API Reference

</callout>

## List

List, search, sort, and filter a zones' DNS records.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters","default":"[]"}]">



</params-table>

```php [php]
$response = $client->dns()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new DNS record for a zone.

Notes:

- A/AAAA records cannot exist on the same name as CNAME records.
- NS records cannot exist on the same name as any other record type.
- Domain names are always represented in Punycode, even if Unicode characters were used when creating the record.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on DNS."}]">



</params-table>

```php [php]
$response = $client->dns()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Export

Export BIND config.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->dns()->export('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/export/">

View this operation on the Cloudflare API Reference

</callout>

## Import

Import BIND config.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"content","type":"string","required":true,"description":"Content of BIND config to import."},{"name":"proxied","type":"bool","required":false,"description":"Should DNS records be proxied.","default":"true"}]">



</params-table>

```php [php]
$response = $client->dns()->import('ZONE_ID', 'CONTENT', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/import/">

View this operation on the Cloudflare API Reference

</callout>

## Get

DNS Record Details

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"dnsRecordId","type":"string","required":true,"description":"DNS ID to fetch details."}]">



</params-table>

```php [php]
$response = $client->dns()->get('ZONE_ID', 'DNS_RECORD_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Apply changes to an existing DNS record, overwriting only the supplied properties.

Notes:

- A/AAAA records cannot exist on the same name as CNAME records.
- NS records cannot exist on the same name as any other record type.
- Domain names are always represented in Punycode, even if Unicode characters were used when creating the record.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"dnsRecordId","type":"string","required":true,"description":"DNS ID to update."},{"name":"values","type":"array","required":true}]">



</params-table>

```php [php]
$response = $client->dns()->edit('ZONE_ID', 'DNS_RECORD_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing DNS record, overwriting the full configuration.

Notes:

- A/AAAA records cannot exist on the same name as CNAME records.
- NS records cannot exist on the same name as any other record type.
- Domain names are always represented in Punycode, even if Unicode characters were used when creating the record.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"dnsRecordId","type":"string","required":true,"description":"DNS ID to overwrite."},{"name":"values","type":"array","required":true}]">



</params-table>

```php [php]
$response = $client->dns()->update('ZONE_ID', 'DNS_RECORD_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete DNS Record

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"dnsRecordId","type":"string","required":true,"description":"DNS ID to delete."}]">



</params-table>

```php [php]
$response = $client->dns()->delete('ZONE_ID', 'DNS_RECORD_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/records/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [DNSSEC](/client/dns/dnssec)
