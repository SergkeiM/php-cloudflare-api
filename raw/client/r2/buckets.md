# Buckets

> Buckets endpoint reference.

## List

Returns a list of buckets for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->buckets()->list('ACCOUNT_ID', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a new bucket for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the bucket, e.g. `name`, `locationHint`, `storageClass`."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->buckets()->create('ACCOUNT_ID', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a bucket's details.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->buckets()->get('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Apply changes to the storage class of an existing bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"storageClass","type":"string","required":true,"description":"Storage class to set on the bucket, e.g. `Standard` or `InfrequentAccess`."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->buckets()->edit('ACCOUNT_ID', 'BUCKET_NAME', 'STORAGE_CLASS', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an existing bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->buckets()->delete('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Create Temporary Credentials

Creates temporary access credentials scoped to a specific bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set, e.g. `bucket`, `permission`, `ttlSeconds`, `parentAccessKeyId`."}]">



</params-table>

```php [php]
$response = $client->r2()->buckets()->createTemporaryCredentials('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/temporary_credentials/methods/create/">

View this operation on the Cloudflare API Reference

</callout>
