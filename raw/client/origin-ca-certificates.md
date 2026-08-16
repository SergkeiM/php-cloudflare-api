# Origin CA Certificates

> Origin CA Certificates endpoint reference.

## List

List all Origin CA certificates.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Query Parameters, e.g. `zone_id`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create an Origin CA certificate.

<params-table :params="[{"name":"values","type":"array","required":true,"description":"`csr`, `hostnames` and `request_type` (`origin-rsa`, `origin-ecc` or `keyless-certificate`) are required. `requested_validity` is the certificate's lifetime in days, defaulting to Cloudflare's own."}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->create([]);
```

::callout{icon="i-simple-icons-cloudflare" to="[https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/create/](https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/create/) ```php
$client->originCACertificates()->create(<span>

'csr' => $csr,
'hostnames' => <span>

'example.com', '*.example.com'

</span>

,
'request_type' => 'origin-rsa',

</span>

);

```"}
View this operation on the Cloudflare API Reference
::

## Get

Get an Origin CA certificate.

::params-table
---
params:
  - name: "certificateId"
    type: "string"
    required: true
    description: "Origin CA certificate Identifier."
---
::

```php [php]
$response = $client->originCACertificates()->get('CERTIFICATE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Revoke

Revoke an Origin CA certificate.

<params-table :params="[{"name":"certificateId","type":"string","required":true,"description":"Origin CA certificate Identifier."}]">



</params-table>

```php [php]
$response = $client->originCACertificates()->revoke('CERTIFICATE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/origin_ca_certificates/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
