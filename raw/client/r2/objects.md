# Objects

> Objects stored in an R2 bucket, over Cloudflare's REST API.

Objects stored in an R2 bucket, over Cloudflare's REST API.

## List

List objects in a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `per_page`, `prefix`, `delimiter`, `cursor` and `start_after`.","default":"[]"},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->list('ACCOUNT_ID', 'BUCKET_NAME', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Retrieve an object from a bucket.

The response carries the object itself, not a JSON envelope, so read it
with `body()` rather than `json()`. Object metadata comes back as
response headers, reachable through `toPsrResponse()`.

```php
$object = $client->r2()->objects()->get('ACCOUNT_ID', 'my-bucket', 'path/to/file.txt');

file_put_contents('file.txt', $object->body());
```

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"objectKey","type":"string","required":true,"description":"Key of the object, e.g. `path/to/file.txt`."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->get('ACCOUNT_ID', 'BUCKET_NAME', 'OBJECT_KEY', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>

## Upload

Upload an object to a bucket.

The object is sent as the raw request body, up to 300 MB. Anything larger
needs R2's S3-compatible API and its multipart upload.

```php
$client->r2()->objects()->upload(
    'ACCOUNT_ID',
    'my-bucket',
    'path/to/file.txt',
    file_get_contents('file.txt'),
    'text/plain'
);
```

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"objectKey","type":"string","required":true,"description":"Key to store the object under, e.g. `path/to/file.txt`."},{"name":"contents","type":"string","required":true,"description":"The object itself."},{"name":"contentType","type":"string","required":false,"description":"Media type of the object.","default":"'application/octet-stream'"},{"name":"storageClass","type":"string|null","required":false,"description":"Storage class to store the object as, e.g. `Standard` or `InfrequentAccess`. Defaults to the bucket's own."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->upload('ACCOUNT_ID', 'BUCKET_NAME', 'OBJECT_KEY', 'CONTENTS', 'CONTENT_TYPE', 'STORAGE_CLASS', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a single object from a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"objectKey","type":"string","required":true,"description":"Key of the object to delete."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->delete('ACCOUNT_ID', 'BUCKET_NAME', 'OBJECT_KEY', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>

## Delete Many

Delete a list of objects from a bucket.

Every key given is deleted, and Cloudflare reports failures per key in
the response rather than failing the whole request.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"objectKeys","type":"array","required":true,"description":"Keys of the objects to delete."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->deleteMany('ACCOUNT_ID', 'BUCKET_NAME', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>

## Delete By Prefix

Delete every object whose key begins with a prefix.

Cloudflare answers with a job descriptor rather than doing the work
inline: small jobs may come back already `COMPLETED`, larger ones keep
running in the background, so poll the `id` you get back with
`$client->r2()->jobs()->get()`. Objects written after the job starts are
not included in it.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"prefix","type":"string","required":true,"description":"Key prefix to delete under. Pass an empty string to delete every object — or use `emptyBucket()`, which says so plainly."},{"name":"dataCatalogCheck","type":"bool","required":false,"description":"Refuse the request with a `409` if R2 Data Catalog is enabled on the bucket.","default":"false"},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->deleteByPrefix('ACCOUNT_ID', 'BUCKET_NAME', 'PREFIX', true, 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>

## Empty Bucket

Delete every object in a bucket.

The same operation as `deleteByPrefix()` with an empty prefix, and it
behaves the same way: you get a job descriptor back to poll with
`$client->r2()->jobs()->get()`.

Cloudflare refuses to empty a bucket that has event notifications
configured, answering `409` with error code `10034` — remove the
notification rules first. Abort any active multipart uploads before
submitting, and avoid writing to the bucket while the job runs.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"dataCatalogCheck","type":"bool","required":false,"description":"Refuse the request with a `409` if R2 Data Catalog is enabled on the bucket.","default":"false"},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->objects()->emptyBucket('ACCOUNT_ID', 'BUCKET_NAME', true, 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/r2/api/">

View this operation on the Cloudflare API Reference

</callout>
