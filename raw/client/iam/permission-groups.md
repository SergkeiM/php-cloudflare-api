# Permission Groups

> Permission Groups endpoint reference.

## List

List all the permissions groups for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, e.g. id, name, label.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->iam()->permissionGroups()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-permission-group-list">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get information about a specific permission group in an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"permissionGroupId","type":"string","required":true,"description":"Permission Group identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->permissionGroups()->get('ACCOUNT_ID', 'PERMISSION_GROUP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-permission-group-details">

View this operation on the Cloudflare API Reference

</callout>
