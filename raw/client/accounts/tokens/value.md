# Value

> Value endpoint reference.

## Roll

Roll the Account Owned API token secret.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"tokenId","type":"string","required":true,"description":"Token identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->value()->roll('ACCOUNT_ID', 'TOKEN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/subresources/value/methods/update/">

View this operation on the Cloudflare API Reference

</callout>
