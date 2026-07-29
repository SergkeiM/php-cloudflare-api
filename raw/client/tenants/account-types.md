# Account Types

> Account Types endpoint reference.

## List

List of account types available for the Tenant to provision accounts.

<params-table :params="[{"name":"tenantId","type":"string","required":true,"description":"Tenant identifier."}]">



</params-table>

```php [php]
$response = $client->tenants()->accountTypes()->list('TENANT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/Tenants_validAccountTypes">

View this operation on the Cloudflare API Reference

</callout>
