# Custom Domains

> Custom Domains endpoint reference.

## List

List custom domains for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->customDomains()->list('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Add a custom domain to a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"values","type":"array","required":true,"description":"Values to set, e.g. `domain`, `zoneId`, `enabled`."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->customDomains()->create('ACCOUNT_ID', 'BUCKET_NAME', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get an existing custom domain for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"domain","type":"string","required":true,"description":"Custom domain name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->customDomains()->get('ACCOUNT_ID', 'BUCKET_NAME', 'DOMAIN', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing custom domain for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"domain","type":"string","required":true,"description":"Custom domain name."},{"name":"values","type":"array","required":true,"description":"Values to set, e.g. `enabled`, `minTLS`, `ciphers`."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->customDomains()->update('ACCOUNT_ID', 'BUCKET_NAME', 'DOMAIN', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Remove a custom domain from a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"domain","type":"string","required":true,"description":"Custom domain name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->customDomains()->delete('ACCOUNT_ID', 'BUCKET_NAME', 'DOMAIN', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
