# Cors

> Cors endpoint reference.

## Get

Get the CORS configuration for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->cors()->get('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/r2-get-bucket-cors-policy">

View this operation on the Cloudflare API Reference

</callout>

## Update

Set the CORS configuration for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"rules","type":"array","required":true,"description":"CORS rules to set on the bucket."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->cors()->update('ACCOUNT_ID', 'BUCKET_NAME', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/r2-put-bucket-cors-policy">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete the CORS configuration for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->cors()->delete('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/r2-delete-bucket-cors-policy">

View this operation on the Cloudflare API Reference

</callout>
