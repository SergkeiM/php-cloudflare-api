# Lock

> Lock endpoint reference.

## Get

Get the object lock configuration for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->lock()->get('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/locks/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Set the object lock configuration for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"rules","type":"array","required":true,"description":"Lock (retention) rules to set on the bucket."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->lock()->update('ACCOUNT_ID', 'BUCKET_NAME', [], 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/locks/methods/update/">

View this operation on the Cloudflare API Reference

</callout>
