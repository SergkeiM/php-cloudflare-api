# SSL

> SSL endpoint reference.

## Verification

SSL Verification Details.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->ssl()->verification('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/ssl/subresources/verification/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit Verification

Edit SSL Certificate Pack Validation Method.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"certPackUuid","type":"string","required":true,"description":"Certificate Pack UUID."},{"name":"validationMethod","type":"string","required":true,"description":"Validation Method selected for the order. Allowed values: `http`, `cname`, `txt`, `email`"}]">



</params-table>

```php [php]
$response = $client->ssl()->editVerification('ZONE_ID', 'CERT_PACK_UUID', 'VALIDATION_METHOD');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/ssl/subresources/verification/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Universal Settings

Universal SSL Settings Details.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->ssl()->universalSettings('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/ssl/subresources/universal/subresources/settings/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit Universal Settings

Edit Universal SSL Settings.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"enabled","type":"bool","required":true,"description":"Whether Universal SSL is enabled."}]">



</params-table>

```php [php]
$response = $client->ssl()->editUniversalSettings('ZONE_ID', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/ssl/subresources/universal/subresources/settings/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Analyze

Analyze a certificate.

Returns the hostnames the certificate covers, its signature algorithm
and its expiration date. Sent without a certificate, Cloudflare analyzes
the one already on the zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":false,"description":"Optionally `certificate`, the PEM certificate and any intermediates, and `bundle_method` (`ubiquitous`, `optimal` or `force`).","default":"[]"}]">



</params-table>

```php [php]
$response = $client->ssl()->analyze('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/ssl/subresources/analyze/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Certificate Packs](/client/ssl/certificate-packs)
