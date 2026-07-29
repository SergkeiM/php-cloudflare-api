# Resource Groups

> Resource Groups endpoint reference.

## List

List all the resource groups for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, e.g. id, name.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->iam()->resourceGroups()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-resource-group-list">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new Resource Group under the specified account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":true,"description":"Resource Group values, requires name and scope."}]">



</params-table>

```php [php]
$response = $client->iam()->resourceGroups()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-resource-group-create">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get information about a specific resource group in an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"resourceGroupId","type":"string","required":true,"description":"Resource Group identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->resourceGroups()->get('ACCOUNT_ID', 'RESOURCE_GROUP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-resource-group-details">

View this operation on the Cloudflare API Reference

</callout>

## Update

Modify an existing resource group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"resourceGroupId","type":"string","required":true,"description":"Resource Group identifier."},{"name":"values","type":"array","required":false,"description":"Resource Group values, e.g. name, scope.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->iam()->resourceGroups()->update('ACCOUNT_ID', 'RESOURCE_GROUP_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-resource-group-update">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Remove a resource group from an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"resourceGroupId","type":"string","required":true,"description":"Resource Group identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->resourceGroups()->delete('ACCOUNT_ID', 'RESOURCE_GROUP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-resource-group-delete">

View this operation on the Cloudflare API Reference

</callout>
