# Monitors

> Monitors endpoint reference.

## List

List configured load balancer monitors for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->list('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/load-balancer-monitors-list-monitors">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new load balancer monitor for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":false,"description":"Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/load-balancer-monitors-create-monitor">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a single configured load balancer monitor for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->get('ACCOUNT_ID', 'MONITOR_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/load-balancer-monitors-monitor-details">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing load balancer monitor for an account, overwriting the full configuration.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->update('ACCOUNT_ID', 'MONITOR_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/load-balancer-monitors-update-monitor">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Apply changes to an existing monitor, overwriting only the supplied properties.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."},{"name":"values","type":"array","required":true,"description":"Values to patch on the monitor."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->edit('ACCOUNT_ID', 'MONITOR_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-load-balancer-monitors-patch-monitor">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a load balancer monitor for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->delete('ACCOUNT_ID', 'MONITOR_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/load-balancer-monitors-delete-monitor">

View this operation on the Cloudflare API Reference

</callout>

## Preview

Preview pools associated with a given monitor and show the effective response.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."},{"name":"values","type":"array","required":false,"description":"The pools to run the preview on.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->preview('ACCOUNT_ID', 'MONITOR_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/load-balancer-monitors-preview-monitor">

View this operation on the Cloudflare API Reference

</callout>

## References

List the load balancers and pools that reference a given monitor.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitors()->references('ACCOUNT_ID', 'MONITOR_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-load-balancer-monitors-list-monitor-references">

View this operation on the Cloudflare API Reference

</callout>
