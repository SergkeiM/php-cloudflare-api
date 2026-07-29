# Subscriptions

> Subscriptions endpoint reference.

## List

Lists all of an account's subscriptions.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->subscriptions()->list('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-subscriptions-list-subscriptions">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates an account subscription.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":false,"description":"Subscription values, e.g. frequency, rate_plan.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accounts()->subscriptions()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-subscriptions-create-subscription">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates an account subscription.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"subscriptionId","type":"string","required":true,"description":"Subscription identifier tag."},{"name":"values","type":"array","required":false,"description":"Subscription values, e.g. frequency, rate_plan.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accounts()->subscriptions()->update('ACCOUNT_ID', 'SUBSCRIPTION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-subscriptions-update-subscription">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an account's subscription.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"subscriptionId","type":"string","required":true,"description":"Subscription identifier tag."}]">



</params-table>

```php [php]
$response = $client->accounts()->subscriptions()->delete('ACCOUNT_ID', 'SUBSCRIPTION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-subscriptions-delete-subscription">

View this operation on the Cloudflare API Reference

</callout>
