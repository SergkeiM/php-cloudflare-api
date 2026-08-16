# Tenants

> Tenants endpoint reference.

## Get

Retrieves a Tenant by Tenant ID.

<params-table :params="[{"name":"tenantId","type":"string","required":true,"description":"Tenant identifier."}]">



</params-table>

```php [php]
$response = $client->tenants()->get('TENANT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/tenants/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Account Types](/client/tenants/account-types)
- [Accounts](/client/tenants/accounts)
- [Entitlements](/client/tenants/entitlements)
- [Memberships](/client/tenants/memberships)
