# Permission Groups

> Permission Groups endpoint reference.

## List

Find all available permission groups for API Tokens.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, e.g. name, scope.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->tokens()->permissionGroups()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/permission-groups-list-permission-groups">

View this operation on the Cloudflare API Reference

</callout>
