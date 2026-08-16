# Load Balancers

> Load balancers distribute traffic across your origin servers to reduce response time and increase availability. A load balancer is scoped to either an account or a zone: pass exactly one of $accountId or $zoneId.

Load balancers distribute traffic across your origin servers to reduce
response time and increase availability. A load balancer is scoped to
either an account or a zone: pass exactly one of $accountId or $zoneId.

## List

List configured load balancers.

<params-table :params="[{"name":"accountId","type":"string|null","required":false,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":false,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->list('ACCOUNT_ID', 'ZONE_ID');
```

## Create

Create a new load balancer.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"values","type":"array","required":true,"description":"Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->create('ACCOUNT_ID', 'ZONE_ID', []);
```

## Get

Get a single configured load balancer.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"loadBalancerId","type":"string","required":true,"description":"Load Balancer Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->get('ACCOUNT_ID', 'ZONE_ID', 'LOAD_BALANCER_ID');
```

## Update

Update an existing load balancer, overwriting the full configuration.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"loadBalancerId","type":"string","required":true,"description":"Load Balancer Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the load balancer, e.g. `name`, `default_pools`, `fallback_pool`."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->update('ACCOUNT_ID', 'ZONE_ID', 'LOAD_BALANCER_ID', []);
```

## Edit

Apply changes to an existing load balancer, overwriting only the supplied properties.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"loadBalancerId","type":"string","required":true,"description":"Load Balancer Identifier."},{"name":"values","type":"array","required":true,"description":"Values to patch on the load balancer."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->edit('ACCOUNT_ID', 'ZONE_ID', 'LOAD_BALANCER_ID', []);
```

## Delete

Delete a load balancer.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"loadBalancerId","type":"string","required":true,"description":"Load Balancer Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->delete('ACCOUNT_ID', 'ZONE_ID', 'LOAD_BALANCER_ID');
```

## Usage

Fetch the current load balancer usage for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->usage('ACCOUNT_ID');
```

## Related

- [Pools](/client/load-balancers/pools)
- [Monitors](/client/load-balancers/monitors)
- [Monitor Groups](/client/load-balancers/monitor-groups)
- [Regions](/client/load-balancers/regions)
- [Searches](/client/load-balancers/searches)
- [Previews](/client/load-balancers/previews)
