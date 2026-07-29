# Managed Domain

> Managed Domain endpoint reference.

## Get

Get the managed (`r2.dev`) domain configuration for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->managedDomain()->get('ACCOUNT_ID', 'BUCKET_NAME', 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/r2-get-bucket-managed-domain">

View this operation on the Cloudflare API Reference

</callout>

## Update

Enable or disable the managed (`r2.dev`) domain for a bucket.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"bucketName","type":"string","required":true,"description":"Bucket Name."},{"name":"enabled","type":"bool","required":true,"description":"Whether the managed domain is enabled."},{"name":"jurisdiction","type":"string|null","required":false,"description":"Jurisdiction where objects in this bucket are guaranteed to be stored."}]">



</params-table>

```php [php]
$response = $client->r2()->managedDomain()->update('ACCOUNT_ID', 'BUCKET_NAME', true, 'JURISDICTION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/r2-edit-bucket-managed-domain">

View this operation on the Cloudflare API Reference

</callout>
