# Routes

> Routes endpoint reference.

## List

Returns routes for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone identifier."},{"name":"params","type":"array","required":false,"default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->routes()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-routes-list-routes">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a route that maps a URL pattern to a Worker.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone identifier."},{"name":"values","type":"array","required":true,"description":"Values."}]">



</params-table>

```php [php]
$response = $client->workers()->routes()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-routes-create-route">

View this operation on the Cloudflare API Reference

</callout>

## Get

Returns information about a route, including URL pattern and Worker.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone identifier."},{"name":"routeId","type":"string","required":true,"description":"Route Identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->routes()->get('ZONE_ID', 'ROUTE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-routes-get-route">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates the URL pattern or Worker associated with a route.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone identifier."},{"name":"routeId","type":"string","required":true,"description":"Route Identifier."},{"name":"values","type":"array","required":true,"description":"Values."}]">



</params-table>

```php [php]
$response = $client->workers()->routes()->update('ZONE_ID', 'ROUTE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-routes-update-route">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes a route.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone identifier."},{"name":"routeId","type":"string","required":true,"description":"Route Identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->routes()->delete('ZONE_ID', 'ROUTE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-routes-delete-route">

View this operation on the Cloudflare API Reference

</callout>
