# Pools

> Pools endpoint reference.

## List

List configured load balancer pools for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `monitor`, to list only the pools using a given monitor.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new load balancer pool for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the pool, e.g. `name`, `origins`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a single configured load balancer pool for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->get('ACCOUNT_ID', 'POOL_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing load balancer pool for an account, overwriting the full configuration.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the pool, e.g. `name`, `origins`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->update('ACCOUNT_ID', 'POOL_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Apply changes to an existing pool, overwriting only the supplied properties.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."},{"name":"values","type":"array","required":true,"description":"Values to patch on the pool."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->edit('ACCOUNT_ID', 'POOL_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Bulk Edit

Apply changes to a number of existing pools, overwriting the supplied properties. Returns the list of affected pools.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":true,"description":"List of pool patches to apply, each identified by `id`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->bulkEdit('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/bulk_edit/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a load balancer pool for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->delete('ACCOUNT_ID', 'POOL_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Health

Fetch the latest pool health status for a single pool.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->health('ACCOUNT_ID', 'POOL_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/subresources/health/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Preview

Preview pool health using the specified monitor and show the effective response.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."},{"name":"values","type":"array","required":false,"description":"The monitor details to run the preview with.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->preview('ACCOUNT_ID', 'POOL_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/subresources/health/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## References

List the load balancers that reference a given pool.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"poolId","type":"string","required":true,"description":"Pool Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->pools()->references('ACCOUNT_ID', 'POOL_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/pools/subresources/references/methods/get/">

View this operation on the Cloudflare API Reference

</callout>
