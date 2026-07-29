# Profile

> Profile endpoint reference.

## Get

Get an organizations profile if it exists.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."}]">



</params-table>

```php [php]
$response = $client->organizations()->profile()->get('ORGANIZATION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/Organizations_getProfile">

View this operation on the Cloudflare API Reference

</callout>

## Update

Modify organization profile.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"values","type":"array","required":true,"description":"Profile values, requires business_name, business_email, business_phone, business_address and external_metadata."}]">



</params-table>

```php [php]
$response = $client->organizations()->profile()->update('ORGANIZATION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/Organizations_modifyProfile">

View this operation on the Cloudflare API Reference

</callout>
