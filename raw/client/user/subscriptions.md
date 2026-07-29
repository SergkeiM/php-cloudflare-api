# Subscriptions

> Subscriptions endpoint reference.

## List

Lists all of a user's subscriptions.

```php [php]
$response = $client->user()->subscriptions()->list();
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/user-subscription-get-user-subscriptions">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a user subscription.

<params-table :params="[{"name":"values","type":"array","required":false,"description":"Subscription values, e.g. frequency, rate_plan.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->subscriptions()->create([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/user-subscription-create-user-subscription">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates a user's subscription.

<params-table :params="[{"name":"subscriptionId","type":"string","required":true,"description":"Subscription identifier tag."},{"name":"values","type":"array","required":false,"description":"Subscription values, e.g. frequency, rate_plan.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->subscriptions()->update('SUBSCRIPTION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/user-subscription-update-user-subscription">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes a user's subscription.

<params-table :params="[{"name":"subscriptionId","type":"string","required":true,"description":"Subscription identifier tag."}]">



</params-table>

```php [php]
$response = $client->user()->subscriptions()->delete('SUBSCRIPTION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/user-subscription-delete-user-subscription">

View this operation on the Cloudflare API Reference

</callout>
