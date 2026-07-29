# Memberships

> Memberships endpoint reference.

## List

List of active members (Cloudflare users) for the Tenant.

<params-table :params="[{"name":"tenantId","type":"string","required":true,"description":"Tenant identifier."}]">



</params-table>

```php [php]
$response = $client->tenants()->memberships()->list('TENANT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/Tenants_listMemberships">

View this operation on the Cloudflare API Reference

</callout>
