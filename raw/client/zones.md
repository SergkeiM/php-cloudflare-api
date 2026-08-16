# Zones

> Zones endpoint reference.

## List

Lists, searches, sorts, and filters your zones. Listing zones across more than 500 accounts is currently not allowed.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->zones()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create Zone

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":true,"description":"`name`, the domain name, is required. `type` is `full` when Cloudflare hosts the DNS, or `partial` for a partner-hosted or CNAME setup."}]">



</params-table>

```php [php]
$response = $client->zones()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/methods/create/ The account is taken from `$accountId`; everything else comes from `$values`.">

View this operation on the Cloudflare API Reference

</callout>

## Get

Zone Details

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->get('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete Zone

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->delete('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Edit Zone

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"Any of `type` (`full` or `partial`, Enterprise-only unless enabled on the zone), `vanity_name_servers` (Business and Enterprise plans), `paused` and `plan`."}]">



</params-table>

```php [php]
$response = $client->zones()->edit('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Activation Check

Triggeres a new activation check for a PENDING Zone. This can be triggered every 5 min for paygo/ent customers, every hour for FREE Zones.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->activationCheck('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/subresources/activation_check/methods/trigger/">

View this operation on the Cloudflare API Reference

</callout>

## Purge

Purge Cached Content

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"purgeBy","type":"CachePurge|array","required":true,"configuration":"/advanced/configurations/zones/cache-purge"}]">



</params-table>

```php [php]
$response = $client->zones()->purge('ZONE_ID', $purgeBy);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/cache/methods/purge/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Holds](/client/zones/holds)
- [Settings](/client/zones/settings)
- [Transformation Flows](/client/zones/transformation-flows)
