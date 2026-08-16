# Regional Tiered Cache

> Regional Tiered Cache adds a regional hub data center between the lower tiers and the upper tier, which helps when the upper tier is far away.

Regional Tiered Cache adds a regional hub data center between the lower
tiers and the upper tier, which helps when the upper tier is far away.

## Get

Current Regional Tiered Cache setting for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->cache()->regionalTieredCache()->get('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/subresources/regional_tiered_cache/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Turn Regional Tiered Cache on or off for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"enabled","type":"bool","required":true,"description":"Whether Regional Tiered Cache is enabled."}]">



</params-table>

```php [php]
$response = $client->cache()->regionalTieredCache()->edit('ZONE_ID', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/subresources/regional_tiered_cache/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>
