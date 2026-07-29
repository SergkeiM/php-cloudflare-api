# Rate Limits

> Rate Limits endpoint reference.

## List

List, search, sort, and filter a zone's rate limits.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->rateLimits()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-list-rate-limits">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a single rate limit.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"rateLimitId","type":"string","required":true,"description":"Rate Limit Identifier."}]">



</params-table>

```php [php]
$response = $client->rateLimits()->get('ZONE_ID', 'RATE_LIMIT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-get-a-rate-limit">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new rate limit for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the rate limit, e.g. `threshold`, `period`, `match`, `action`."}]">



</params-table>

```php [php]
$response = $client->rateLimits()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-create-a-rate-limit">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing rate limit for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"rateLimitId","type":"string","required":true,"description":"Rate Limit Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the rate limit, e.g. `threshold`, `period`, `match`, `action`."}]">



</params-table>

```php [php]
$response = $client->rateLimits()->update('ZONE_ID', 'RATE_LIMIT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-update-a-rate-limit">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a rate limit for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"rateLimitId","type":"string","required":true,"description":"Rate Limit Identifier."}]">



</params-table>

```php [php]
$response = $client->rateLimits()->delete('ZONE_ID', 'RATE_LIMIT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-delete-a-rate-limit">

View this operation on the Cloudflare API Reference

</callout>
