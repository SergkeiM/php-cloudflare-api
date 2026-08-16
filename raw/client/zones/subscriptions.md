# Subscriptions

> Subscriptions endpoint reference.

## Get

Lists zone subscription details.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->subscriptions()->get('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/subresources/subscriptions/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a zone subscription, either plan or add-ons.

```php
$client->zones()->subscriptions()->create('ZONE_ID', [
    'frequency' => 'monthly',
    'rate_plan' => ['id' => 'PARTNERS_PRO'],
]);
```

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":false,"description":"Subscription values, e.g. `frequency`, `rate_plan`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->zones()->subscriptions()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/subresources/subscriptions/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates zone subscriptions, either plan or add-ons.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":false,"description":"Subscription values, e.g. `frequency`, `rate_plan`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->zones()->subscriptions()->update('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/subresources/subscriptions/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes a zone's subscription.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->subscriptions()->delete('ZONE_ID');
```
