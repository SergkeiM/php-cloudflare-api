# Accounts

> Accounts endpoint reference.

## List

List of accounts for the Tenant.

<params-table :params="[{"name":"tenantId","type":"string","required":true,"description":"Tenant identifier."}]">



</params-table>

```php [php]
$response = $client->tenants()->accounts()->list('TENANT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/tenants/subresources/accounts/methods/list/">

View this operation on the Cloudflare API Reference

</callout>
