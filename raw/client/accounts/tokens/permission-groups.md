# Permission Groups

> Permission Groups endpoint reference.

## List

Find all available permission groups for Account Owned API Tokens.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, e.g. name, scope.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accounts()->tokens()->permissionGroups()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-api-tokens-list-permission-groups">

View this operation on the Cloudflare API Reference

</callout>
