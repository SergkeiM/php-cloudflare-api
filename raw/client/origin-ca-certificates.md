# Origin CA Certificates

> Origin CA Certificates endpoint reference.

## List

List all Origin CA certificates.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Query Parameters, e.g. `zone_id`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/origin-ca-certificates-list-certificates">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create an Origin CA certificate.

<params-table :params="[{"name":"csr","type":"string","required":true,"description":"Certificate Signing Request (CSR)."},{"name":"hostnames","type":"array","required":true,"description":"Array of hostnames or wildcard names bound to the certificate."},{"name":"requestedValidity","type":"int","required":false,"description":"The number of days for which the certificate should be valid.","default":"5475"},{"name":"requestType","type":"string","required":false,"description":"The signature type desired on the certificate. Allowed values: `origin-rsa`, `origin-ecc`, `keyless-certificate`","default":"'origin-rsa'"}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->create('CSR', [], 1, 'REQUEST_TYPE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/origin-ca-certificates-create-certificate">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get an Origin CA certificate.

<params-table :params="[{"name":"certificateId","type":"string","required":true,"description":"Origin CA certificate Identifier."}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->get('CERTIFICATE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/origin-ca-certificates-certificate-details">

View this operation on the Cloudflare API Reference

</callout>

## Revoke

Revoke an Origin CA certificate.

<params-table :params="[{"name":"certificateId","type":"string","required":true,"description":"Origin CA certificate Identifier."}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->revoke('CERTIFICATE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/origin-ca-certificates-revoke-certificate">

View this operation on the Cloudflare API Reference

</callout>
