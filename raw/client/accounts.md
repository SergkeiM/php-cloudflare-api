# Accounts

> Accounts endpoint reference.

## List

List all accounts you have ownership or verified access to.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accounts()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create an account (only available for tenant admins at this time)

```php
$client->accounts()->create([
    'name' => 'Example Account',
    'type' => 'standard',
]);
```

<params-table :params="[{"name":"values","type":"array","required":true,"description":"`name` and `type` (`standard` for self-serve, `enterprise` otherwise) are required. `unit` optionally names the [tenant unit](https://developers.cloudflare.com/tenant/how-to/manage-accounts/) to create the account under, as `['id' => '…']`."}]">



</params-table>

```php [php]
$response = $client->accounts()->create([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get information about a specific account that you are a member of.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->get('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":true,"description":"`name` is required; `settings` is optional."}]">



</params-table>

```php [php]
$response = $client->accounts()->update('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a specific account (only available for tenant admins at this time). This is a permanent operation that will delete any zones or other resources under the account

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->delete('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Profile

Get account profile.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->profile('ACCOUNT_ID');
```

## Update Profile

Modify account profile.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":false,"description":"Account profile values.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accounts()->updateProfile('ACCOUNT_ID', []);
```

## Organizations

List account organizations.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->organizations('ACCOUNT_ID');
```

## Related

- [Members](/client/accounts/members)
- [Logs](/client/accounts/logs)
- [Subscriptions](/client/accounts/subscriptions)
- [Tokens](/client/accounts/tokens)
- [Settings](/client/accounts/settings)
- [Access Rules](/client/accounts/access-rules)
