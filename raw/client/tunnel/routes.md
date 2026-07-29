# Routes

> Routes endpoint reference.

## List

Lists and filters private network routes in an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->tunnel()->routes()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/tunnel-route-list-tunnel-routes">

View this operation on the Cloudflare API Reference

</callout>

## Get By IP

Fetches routes that contain the given IP address.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"ip","type":"string","required":true,"description":"IP"},{"name":"virtualNetworkId","type":"string|null","required":false,"description":"UUID of the virtual network."}]">



</params-table>

```php [php]
$response = $client->tunnel()->routes()->getByIP('ACCOUNT_ID', 'IP', 'VIRTUAL_NETWORK_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/tunnel-route-get-tunnel-route-by-ip">

View this operation on the Cloudflare API Reference

</callout>

## Create

Routes a private network through a Cloudflare Tunnel.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"network","type":"string","required":true,"description":"The private IPv4 or IPv6 range connected by the route, in CIDR notation."},{"name":"virtualNetworkId","type":"string|null","required":false,"description":"UUID of the virtual network."},{"name":"comment","type":"string|null","required":false,"description":"Optional remark describing the route."}]">



</params-table>

```php [php]
$response = $client->tunnel()->routes()->create('ACCOUNT_ID', 'NETWORK', 'VIRTUAL_NETWORK_ID', 'COMMENT');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/tunnel-route-create-a-tunnel-route">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a private network route in an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"routeId","type":"string","required":true,"description":"UUID of the route."}]">



</params-table>

```php [php]
$response = $client->tunnel()->routes()->get('ACCOUNT_ID', 'ROUTE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/tunnel-route-get-tunnel-route">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Updates an existing private network route in an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"routeId","type":"string","required":true,"description":"UUID of the route."},{"name":"values","type":"array","required":false,"description":"The fields that are meant to be updated","default":"[]"}]">



</params-table>

```php [php]
$response = $client->tunnel()->routes()->edit('ACCOUNT_ID', 'ROUTE_ID', []);
```

## Delete

Deletes a private network route from an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"routeId","type":"string","required":true,"description":"UUID of the route."}]">



</params-table>

```php [php]
$response = $client->tunnel()->routes()->delete('ACCOUNT_ID', 'ROUTE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/tunnel-route-delete-a-tunnel-route">

View this operation on the Cloudflare API Reference

</callout>
