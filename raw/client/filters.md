# Filters

> Filters endpoint reference.

## List

List, search, sort, and filter a zone's filters.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->filters()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/filters-list-filters">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a single filter.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"filterId","type":"string","required":true,"description":"Filter Identifier."}]">



</params-table>

```php [php]
$response = $client->filters()->get('ZONE_ID', 'FILTER_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/filters-filter-details">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create one or more filters.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"filters","type":"array","required":true,"description":"Array of filter definitions, e.g. `[['expression' => 'ip.src eq 127.0.0.1']]`."}]">



</params-table>

```php [php]
$response = $client->filters()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/filters-create-filters">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing filter.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"filterId","type":"string","required":true,"description":"Filter Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the filter."}]">



</params-table>

```php [php]
$response = $client->filters()->update('ZONE_ID', 'FILTER_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/filters-update-a-filter">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a filter.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"filterId","type":"string","required":true,"description":"Filter Identifier."}]">



</params-table>

```php [php]
$response = $client->filters()->delete('ZONE_ID', 'FILTER_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/filters-delete-a-filter">

View this operation on the Cloudflare API Reference

</callout>
