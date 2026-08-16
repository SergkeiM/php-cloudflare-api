# Monitors

> Load balancer monitors owned by the authenticated user.

Load balancer monitors owned by the authenticated user.

## List

List the user's configured load balancer monitors.

```php [php]
$response = $client->user()->loadBalancers()->monitors()->list();
```

## Create

Create a new load balancer monitor for the user.

<params-table :params="[{"name":"values","type":"array","required":false,"description":"Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->create([]);
```

## Get

Get a single configured load balancer monitor.

<params-table :params="[{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->get('MONITOR_ID');
```

## Update

Update an existing load balancer monitor, overwriting the full configuration.

<params-table :params="[{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the monitor, e.g. `type`, `method`, `path`, `expected_codes`."}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->update('MONITOR_ID', []);
```

## Edit

Apply changes to an existing monitor, overwriting only the supplied properties.

<params-table :params="[{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."},{"name":"values","type":"array","required":true,"description":"Values to patch on the monitor."}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->edit('MONITOR_ID', []);
```

## Delete

Delete a load balancer monitor.

<params-table :params="[{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->delete('MONITOR_ID');
```

## Preview

Preview pools associated with a given monitor and show the effective response.

Answers with a preview identifier; read the result with
`$client->user()->loadBalancers()->preview()`.

<params-table :params="[{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."},{"name":"values","type":"array","required":false,"description":"The pools to run the preview on.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->preview('MONITOR_ID', []);
```

## References

List the load balancers and pools that reference a given monitor.

<params-table :params="[{"name":"monitorId","type":"string","required":true,"description":"Monitor Identifier."}]">



</params-table>

```php [php]
$response = $client->user()->loadBalancers()->monitors()->references('MONITOR_ID');
```
