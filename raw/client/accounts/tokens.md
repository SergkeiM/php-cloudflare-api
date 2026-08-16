# Tokens

> Tokens endpoint reference.

## List

List all Account Owned API tokens created for this account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new Account Owned API token.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":true,"description":"Token values, requires name and policies."}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get information about a specific Account Owned API token.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"tokenId","type":"string","required":true,"description":"Token identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->get('ACCOUNT_ID', 'TOKEN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing token.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"tokenId","type":"string","required":true,"description":"Token identifier."},{"name":"values","type":"array","required":true,"description":"Token values, e.g. name, policies, condition, status."}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->update('ACCOUNT_ID', 'TOKEN_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Destroy an Account Owned API token.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"tokenId","type":"string","required":true,"description":"Token identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->delete('ACCOUNT_ID', 'TOKEN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Verify

Test whether a token works.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->verify('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/methods/verify/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Permission Groups](/client/accounts/tokens/permission-groups)
- [Value](/client/accounts/tokens/value)
