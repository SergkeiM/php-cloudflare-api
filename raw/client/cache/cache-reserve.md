# Cache Reserve

> Cache Reserve stores cacheable files in Cloudflare's persistent object storage, so they survive eviction from the edge cache. It requires a paid R2 subscription.

Cache Reserve stores cacheable files in Cloudflare's persistent object
storage, so they survive eviction from the edge cache. It requires a paid
R2 subscription.

## Get

Current Cache Reserve setting for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->cache()->cacheReserve()->get('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Turn Cache Reserve on or off for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"enabled","type":"bool","required":true,"description":"Whether Cache Reserve is enabled."}]">



</params-table>

```php [php]
$response = $client->cache()->cacheReserve()->edit('ZONE_ID', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Clear

Start clearing the Cache Reserve of a zone.

Cache Reserve has to be disabled first, and cannot be re-enabled while
the clear is running. Poll `status()` for progress.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->cache()->cacheReserve()->clear('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/clear/">

View this operation on the Cloudflare API Reference

</callout>

## Status

Progress of the most recent Cache Reserve clear.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->cache()->cacheReserve()->status('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/subresources/cache_reserve/methods/status/">

View this operation on the Cloudflare API Reference

</callout>
