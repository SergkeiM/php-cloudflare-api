# Monitor Groups

> Monitor Groups endpoint reference.

## List

List configured load balancer monitor groups for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->list('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new load balancer monitor group for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the monitor group, e.g. `description`, `members`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a single configured load balancer monitor group for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorGroupId","type":"string","required":true,"description":"Monitor Group Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->get('ACCOUNT_ID', 'MONITOR_GROUP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Apply changes to an existing monitor group, overwriting only the supplied properties.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorGroupId","type":"string","required":true,"description":"Monitor Group Identifier."},{"name":"values","type":"array","required":true,"description":"Values to patch on the monitor group."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->edit('ACCOUNT_ID', 'MONITOR_GROUP_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing load balancer monitor group for an account, overwriting the full configuration.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorGroupId","type":"string","required":true,"description":"Monitor Group Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the monitor group, e.g. `description`, `members`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->update('ACCOUNT_ID', 'MONITOR_GROUP_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a load balancer monitor group for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorGroupId","type":"string","required":true,"description":"Monitor Group Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->delete('ACCOUNT_ID', 'MONITOR_GROUP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## References

List the pools that reference a given monitor group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"monitorGroupId","type":"string","required":true,"description":"Monitor Group Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->monitorGroups()->references('ACCOUNT_ID', 'MONITOR_GROUP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/monitor_groups/subresources/references/methods/get/">

View this operation on the Cloudflare API Reference

</callout>
