# Transformation Flows

> Image transformation flows for a zone.

Image transformation flows for a zone.

## Get

Get the transformation flows configured for a zone.

The response carries an `etag` — pass it back to `update()` so Cloudflare
can reject a write that would clobber someone else's change.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->transformationFlows()->get('ACCOUNT_ID', 'ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/images/transform-images/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Replace the transformation flows configured for a zone.

This is a full replace, not a merge: the flows you send become the whole
configuration. Each flow is one of two shapes —

- `['type' => 'provider', 'provider' => 'fastly', 'enabled' => true, 'version' => 1]`
- `['type' => 'custom', 'name' => '…', 'enabled' => true, 'trigger' => […], 'transformations' => [['key' => '…', 'value' => '…']]]`

A custom flow's `trigger` is itself typed: `path` with `paths`,
`extension` with `extensions`, `query-param` with `params`, or `or`
combining several `triggers`.

```php
$current = $client->zones()->transformationFlows()->get('ACCOUNT_ID', 'ZONE_ID');

$client->zones()->transformationFlows()->update('ACCOUNT_ID', 'ZONE_ID', [
    'flows' => [
        [
            'type' => 'custom',
            'name' => 'Thumbnails',
            'enabled' => true,
            'trigger' => ['type' => 'path', 'paths' => ['/thumbs/*']],
            'transformations' => [['key' => 'width', 'value' => '200']],
        ],
    ],
    'etag' => $current->json('result.etag'),
]);
```

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"`flows` is required and replaces the whole configuration; an empty list clears it. `etag` from `get()` makes the write conditional on nothing having changed since. `version` is the request's schema version, defaulting to the `2` Cloudflare accepts."}]">



</params-table>

```php [php]
$response = $client->zones()->transformationFlows()->update('ACCOUNT_ID', 'ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/images/transform-images/">

View this operation on the Cloudflare API Reference

</callout>
